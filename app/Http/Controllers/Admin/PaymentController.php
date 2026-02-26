<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display listing of Orders (Transactions)
     */
    // public function index(Request $request)
    // {
    //     $query = Order::with(['user']);

    //     // Filter by payment status
    //     if ($request->filled('status')) {
    //         $query->where('payment_status', $request->status);
    //     }

    //     // Search logic
    //     if ($request->filled('search')) {
    //         $search = $request->search;
    //         $query->where(function ($q) use ($search) {
    //             $q->where('order_number', 'like', "%{$search}%")
    //                 ->orWhere('payment_id', 'like', "%{$search}%")
    //                 ->orWhere('razorpay_order_id', 'like', "%{$search}%")
    //                 ->orWhereHas('user', function ($userQuery) use ($search) {
    //                     $userQuery->where('name', 'like', "%{$search}%");
    //                 });
    //         });
    //     }

    //     // Date filters
    //     if ($request->filled('date_from')) {
    //         $query->whereDate('created_at', '>=', $request->date_from);
    //     }
    //     if ($request->filled('date_to')) {
    //         $query->whereDate('created_at', '<=', $request->date_to);
    //     }

    //     $orders = $query->latest()->paginate(20)->withQueryString();

    //     // Statistics
    //     $stats = [
    //         'total_revenue' => Order::where('payment_status', 'completed')->sum('total_amount'),
    //         'today_revenue' => Order::where('payment_status', 'completed')
    //             ->whereDate('updated_at', Carbon::today())
    //             ->sum('total_amount'),
    //         'pending_count' => Order::where('payment_status', 'pending')->count(),
    //         'failed_count'  => Order::where('payment_status', 'failed')->count(),
    //     ];

    //     return view('admin.payments.index', compact('orders', 'stats'));
    // }

    public function index(Request $request)
    {
        $query = Order::with(['user']);

        // Search & Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('payment_id', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($orders);
        }

        // Stats for initial load
        $stats = [
            'total_revenue' => Order::where('payment_status', 'completed')->sum('total_amount'),
            'today_revenue' => Order::where('payment_status', 'completed')->whereDate('updated_at', now())->sum('total_amount'),
            'pending_count' => Order::where('payment_status', 'pending')->count(),
            'failed_count'  => Order::where('payment_status', 'failed')->count(),
        ];

        return view('admin.payments.index', compact('stats'));
    }

    /**
     * Show single Order details
     */
    public function show($id)
    {
        // Fetch Order with related data
        $payment = Order::with(['user', 'items.category', 'qrCodes'])->findOrFail($id);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Process refund via Razorpay API & Release Inventory
     */
    public function refund(Request $request, $id)
    {
        $request->validate([
            'refund_reason' => 'required|string|max:500'
        ]);

        $order = Order::findOrFail($id);

        // Security check
        if ($order->payment_status !== 'completed') {
            return redirect()->back()->with('error', 'Only completed payments can be refunded.');
        }

        $razorpayPaymentId = $order->payment_id;

        if (!$razorpayPaymentId) {
            return redirect()->back()->with('error', 'Missing Razorpay Transaction ID.');
        }

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            // 1. Initiate Refund on Razorpay
            $refund = $api->refund->create([
                'payment_id' => $razorpayPaymentId,
                'amount'     => (int)($order->total_amount * 100), // Convert to paise
                'notes'      => [
                    'reason'       => $request->refund_reason,
                    'order_number' => $order->order_number,
                ]
            ]);

            // 2. Database Updates
            DB::transaction(function () use ($order, $refund, $request) {

                // Update Order Status
                $order->update([
                    'payment_status' => 'refunded',
                    'status'         => 'cancelled',
                ]);

                // 3. Release Inventory: Set associated QR Codes back to 'available'
                $linkedQrs = QrCode::where('order_id', $order->id)->get();

                foreach ($linkedQrs as $qr) {
                    $qr->update([
                        'status'      => 'available',
                        'user_id'     => null,
                        'order_id'    => null,
                        'assigned_at' => null,
                    ]);
                }
            });

            return redirect()
                ->route('payments.show', $order->id)
                ->with('success', 'Refund successful! Order cancelled and Inventory released.');
        } catch (\Exception $e) {
            Log::error('Razorpay Refund Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Refund failed: ' . $e->getMessage());
        }
    }
}
