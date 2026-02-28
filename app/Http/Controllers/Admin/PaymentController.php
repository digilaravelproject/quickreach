<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\QrCode;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        // ADDED: 'items.category' ko load kiya taaki JSON me bhej sakein
        $query = Order::with(['user', 'items.category']);

        // ── Search fix: wrap everything in ONE where() group ──────────────
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('razorpay_order_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhere('shipping_data', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->latest()->paginate(10);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'data' => $orders->map(function ($order) {
                    $shipping = is_array($order->shipping_data)
                        ? $order->shipping_data
                        : (json_decode($order->shipping_data, true) ?? []);

                    return [
                        'id'                  => $order->id,
                        'order_number'        => $order->order_number,
                        'razorpay_payment_id' => $order->razorpay_order_id ?? null,
                        'user'                => [
                            'name'  => $order->user->name  ?? ($shipping['full_name'] ?? 'Guest'),
                            'email' => $order->user->email ?? ($shipping['email']     ?? '—'),
                        ],
                        // ADDED: Category names ko comma separated string banaya
                        'categories'     => $order->items->pluck('category.name')->filter()->unique()->implode(', ') ?: 'N/A',
                        'total_amount'   => $order->total_amount,
                        'payment_method' => $order->payment_method ?? 'online',
                        'payment_status' => $order->payment_status,
                        'status'         => $order->status,
                        'created_at'     => $order->created_at,
                        'paid_at'        => $order->paid_at,
                    ];
                }),
                'current_page' => $orders->currentPage(),
                'last_page'    => $orders->lastPage(),
                'total'        => $orders->total(),
            ]);
        }

        $stats = [
            'total_revenue' => Order::where('payment_status', 'completed')->sum('total_amount'),
            'today_revenue' => Order::where('payment_status', 'completed')->whereDate('paid_at', today())->sum('total_amount'),
            'pending_count' => Order::where('payment_status', 'pending')->count(),
            'cod_pending'   => Order::where('payment_method', 'cod')->where('payment_status', 'pending')->count(),
        ];

        return view('admin.payments.index', compact('stats'));
    }
    // ─────────────────────────────────────────────────────────────────────────
    //  SHOW
    // ─────────────────────────────────────────────────────────────────────────
    public function show($id)
    {
        $payment = Order::with(['user', 'items.category', 'qrCodes'])->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  CREATE — Manual payment form
    // ─────────────────────────────────────────────────────────────────────────
    public function create()
    {
        $users = User::orderBy('name')->get();

        // FIXED: Fetch only categories that actually have available QR codes in stock
        // and count how many are available using the existing relation.
        $categories = Category::where('is_active', true)
            ->whereHas('availableQrCodes')
            ->withCount('availableQrCodes')
            ->orderBy('name')
            ->get();

        return view('admin.payments.create', compact('users', 'categories'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  STORE — Manual payment (completed immediately, QR assigned)
    // ─────────────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'category_id'    => 'required|exists:categories,id',
            'final_amount'   => 'required|numeric|min:1',
            'payment_method' => 'required|in:offline,bank_transfer,razorpay',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        $category = Category::findOrFail($request->category_id);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'             => $request->user_id,
                'order_number'        => $request->order_id ?? ('ORD-' . strtoupper(\Str::random(8))),
                'subtotal'            => $request->final_amount,
                'tax'                 => 0,
                'shipping_cost'       => 0,
                'total_amount'        => $request->final_amount,
                'status'              => 'confirmed',
                'payment_status'      => 'completed',
                'payment_method'      => 'online',
                'razorpay_order_id'   => $request->transaction_id,
                'paid_at'             => now(),
                'shipping_data'       => [],
            ]);

            \App\Models\OrderItem::create([
                'order_id'    => $order->id,
                'category_id' => $category->id,
                'quantity'    => 1,
                'price'       => $request->final_amount,
                'subtotal'    => $request->final_amount,
            ]);

            // Assign QR code
            $qr = QrCode::where('status', 'available')
                ->where('category_id', $category->id)
                ->where(function ($q) {
                    $q->whereNull('source')->orWhere('source', 'online_order');
                })
                ->lockForUpdate()
                ->first();

            if ($qr) {
                $qr->update([
                    'status'      => 'sold',
                    'order_id'    => $order->id,
                    'user_id'     => $request->user_id,
                    'source'      => 'online_order',
                    'assigned_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.payments.show', $order->id)
                ->with('success', 'Manual payment entry created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Manual payment store failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to create the payment entry. Please try again.')->withInput();
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  MARK COD PAID — pending COD → completed + assign QR codes
    // ─────────────────────────────────────────────────────────────────────────
    public function markCodPaid(Order $order)
    {
        if ($order->payment_method !== 'cod') {
            return response()->json([
                'success' => false,
                'message' => 'This order is not a COD order.',
            ], 422);
        }



        if ($order->payment_status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'This order is already marked as completed.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            $order->update([
                'payment_status' => 'completed',
                'status'         => 'confirmed',
                'paid_at'        => now(),
            ]);

            $order->load('items.category');

            foreach ($order->items as $orderItem) {
                $needed  = $orderItem->quantity;
                $qrCodes = QrCode::where('status', 'available')
                    ->where('category_id', $orderItem->category_id)
                    ->where(function ($q) {
                        $q->whereNull('source')->orWhere('source', 'online_order');
                    })
                    ->lockForUpdate()
                    ->limit($needed)
                    ->get();

                if ($qrCodes->count() < $needed) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Not enough QR codes available for: {$orderItem->category->name}. Available: {$qrCodes->count()}, Required: {$needed}.",
                    ], 422);
                }

                foreach ($qrCodes as $qr) {
                    $qr->update([
                        'status'      => 'sold',
                        'order_id'    => $order->id,
                        'user_id'     => $order->user_id,
                        'source'      => 'online_order',
                        'assigned_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order marked as completed. QR codes have been assigned successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('markCodPaid failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process the request. Please try again.',
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  EXPORT — CSV download with same filters
    // ─────────────────────────────────────────────────────────────────────────
    public function export(Request $request)
    {
        $query = Order::with(['user']);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('razorpay_order_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhere('shipping_data', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->latest()->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="payments_' . now()->format('Ymd_His') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($orders) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Order Number',
                'Payment ID / Transaction Ref',
                'Customer Name',
                'Customer Email',
                'Total Amount (INR)',
                'Payment Method',
                'Payment Status',
                'Order Status',
                'Paid At',
                'Created At',
            ]);

            foreach ($orders as $order) {
                $shipping = is_array($order->shipping_data)
                    ? $order->shipping_data
                    : (json_decode($order->shipping_data, true) ?? []);

                fputcsv($handle, [
                    $order->order_number,
                    $order->razorpay_order_id ?? 'N/A',
                    $order->user->name  ?? ($shipping['full_name'] ?? 'Guest'),
                    $order->user->email ?? ($shipping['email']     ?? 'N/A'),
                    number_format($order->total_amount, 2),
                    strtoupper($order->payment_method ?? 'ONLINE'),
                    ucfirst($order->payment_status),
                    ucfirst($order->status ?? 'N/A'),
                    $order->paid_at?->format('d M Y, H:i') ?? 'N/A',
                    $order->created_at?->format('d M Y, H:i') ?? 'N/A',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
