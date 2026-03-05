<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\QrCode;
use App\Models\Slider;
use App\Models\QrRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Razorpay\Api\Api;


class UserController extends Controller
{
    protected $razorpayApi;

    public function __construct()
    {
        // Check if config exists to avoid errors during setup
        if (config('services.razorpay.key') && config('services.razorpay.secret')) {
            $this->razorpayApi = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );
        }
    }

    // --- 1. Public Store Pages ---

    public function products()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $sliders = Slider::where('is_active', true)->orderBy('order_priority', 'asc')->get();

        // Check stock availability for each category
        $categories->each(function ($category) {
            $category->in_stock = QrCode::where('category_id', $category->id)
                ->where('status', 'available')
                ->exists();
        });

        return view('user.products', compact('categories', 'sliders'));
    }

    public function showCategory(Category $category)
    {
        if (!$category->is_active) abort(404);

        // Show stock count
        $availableStock = QrCode::where('category_id', $category->id)
            ->where('status', 'available')
            ->count();

        return view('user.category-detail', compact('category', 'availableStock'));
    }

    // --- 2. Guest Checkout Logic ---

    public function cartCheckout(Request $request)
    {
        return view('user.checkout');
    }

    // public function createOrder(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'cart_items' => 'required|array',
    //             'shipping_data' => 'required|array',
    //             // Detailed validation inside shipping_data array for new UI
    //             'shipping_data.full_name' => 'required|string|max:255',
    //             'shipping_data.email' => 'required|email',
    //             'shipping_data.mobile_number' => 'required|string',
    //             'shipping_data.address_line1' => 'required|string',
    //             'shipping_data.city' => 'required|string',
    //             'shipping_data.pincode' => 'required|string',
    //             'amount' => 'required|numeric|min:1'
    //         ]);

    //         // Stock Check
    //         foreach ($validated['cart_items'] as $item) {
    //             $stock = QrCode::where('category_id', $item['id'])
    //                 ->where('status', 'available')
    //                 ->count();

    //             if ($stock < $item['quantity']) {
    //                 return response()->json(['success' => false, 'message' => "Insufficient stock for " . $item['name']], 400);
    //             }
    //         }

    //         DB::beginTransaction();

    //         // Determine User ID (Use NULL if guest)
    //         $userId = Auth::check() ? Auth::id() : null;

    //         // Optional: Map new format shipping data to old format if your DB strictly needs it a certain way.
    //         // But since shipping_data is usually a JSON column, saving the raw array directly is perfect.
    //         $shippingMethod = $validated['shipping_data']['shipping_method'] ?? 'standard';

    //         // Create Order
    //         $order = Order::create([
    //             'user_id' => $userId, // Safe (NULL allowed)
    //             'order_number' => 'ORD-' . strtoupper(Str::random(10)),
    //             'subtotal' => $validated['amount'] / 1.18,
    //             'tax' => $validated['amount'] - ($validated['amount'] / 1.18),
    //             'shipping_cost' => $shippingMethod === 'express' ? 99 : 0,
    //             'total_amount' => $validated['amount'],
    //             'status' => 'pending',
    //             'shipping_data' => $validated['shipping_data'], // Saves full JSON structure nicely
    //             'payment_status' => 'pending'
    //         ]);

    //         foreach ($validated['cart_items'] as $item) {
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'category_id' => $item['id'],
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price'],
    //                 'subtotal' => $item['price'] * $item['quantity']
    //             ]);
    //         }

    //         // Create Razorpay Order
    //         $razorpayOrder = $this->razorpayApi->order->create([
    //             'receipt' => $order->order_number,
    //             'amount' => (int)($validated['amount'] * 100), // Ensure integer (paise)
    //             'currency' => 'INR',
    //             'notes' => [
    //                 'order_id' => (string)$order->id,
    //                 'customer_name' => $validated['shipping_data']['full_name'],
    //                 'email' => $validated['shipping_data']['email']
    //             ]
    //         ]);

    //         $order->update(['razorpay_order_id' => $razorpayOrder->id]);

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'order_id' => $razorpayOrder->id,
    //             'amount' => $validated['amount'] * 100,
    //             'razorpay_key' => config('services.razorpay.key'),
    //             'internal_order_id' => $order->id
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         \Log::error('Order creation failed: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }

    // public function verifyPayment(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'order_id' => 'required|string',
    //             'payment_id' => 'required|string',
    //             'signature' => 'required|string',
    //             'internal_order_id' => 'required|exists:orders,id'
    //         ]);

    //         $this->razorpayApi->utility->verifyPaymentSignature([
    //             'razorpay_order_id' => $validated['order_id'],
    //             'razorpay_payment_id' => $validated['payment_id'],
    //             'razorpay_signature' => $validated['signature']
    //         ]);

    //         DB::beginTransaction();

    //         $order = Order::findOrFail($validated['internal_order_id']);
    //         $order->update([
    //             'payment_id' => $validated['payment_id'],
    //             'payment_status' => 'completed',
    //             'status' => 'confirmed',
    //             'paid_at' => now()
    //         ]);

    //         // Assign Inventory
    //         $orderItems = OrderItem::where('order_id', $order->id)->get();

    //         foreach ($orderItems as $item) {
    //             // Find available tags
    //             $availableQrs = QrCode::where('category_id', $item->category_id)
    //                 ->where('status', 'available')
    //                 ->limit($item->quantity)
    //                 ->lockForUpdate()
    //                 ->get();

    //             if ($availableQrs->count() < $item->quantity) {
    //                 throw new \Exception("Stock error during processing. Contact support.");
    //             }

    //             foreach ($availableQrs as $qr) {
    //                 $qr->update([
    //                     'order_id' => $order->id,
    //                     // IMPORTANT: Keep user_id NULL if guest. Status 'sold' reserves it.
    //                     'user_id' => $order->user_id,
    //                     'status' => 'sold',
    //                     'assigned_at' => now()
    //                 ]);
    //             }
    //         }

    //         DB::commit();

    //         return response()->json(['success' => true, 'order_id' => $order->id]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:1'
        ]);

        $userId = Auth::id();
        $coupon = Coupon::where('code', $request->code)->first();

        // 1. Coupon Exists?
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.'], 404);
        }

        // 2. Coupon Active?
        if (!$coupon->is_active) {
            return response()->json(['success' => false, 'message' => 'This coupon code is inactive.'], 400);
        }

        // 3. Trying to apply own coupon? (Admin assigning to self, etc)
        if ($userId && $coupon->user_id === $userId) {
            return response()->json(['success' => false, 'message' => 'You cannot apply your own coupon.'], 403);
        }

        // 4. Coupon Expired?
        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json(['success' => false, 'message' => 'This coupon code has expired.'], 400);
        }

        // Calculate Discount
        $discountAmount = 0;
        if ($coupon->discount_type === 'fixed') {
            $discountAmount = min($coupon->discount_amount, $request->subtotal);
        } elseif ($coupon->discount_type === 'percentage') {
            $discountAmount = ($request->subtotal * $coupon->discount_amount) / 100;
        }

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => round($discountAmount, 2),
            'coupon_code' => $coupon->code
        ]);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'cart_items'            => 'required|array|min:1',
            'cart_items.*.id'       => 'required|integer|exists:categories,id',
            'cart_items.*.quantity' => 'required|integer|min:1',
            'cart_items.*.price'    => 'required|numeric|min:0',
            'shipping_data'         => 'required|array',
            'amount'                => 'required|numeric|min:1',
            'payment_method'        => 'required|in:online,cod',
        ]);

        $user          = Auth::user();
        $cartItems     = $request->cart_items;
        $shippingData  = $request->shipping_data;
        $paymentMethod = $request->payment_method;
        $subtotal      = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);

        $discount      = 0;
        $appliedCoupon = null;
        $appliedCouponId = null;

        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', $request->coupon_code)->where('is_active', true)->first();

            // Validate: Exists, is not the their own coupon, and is not expired
            if ($coupon && (!$user || $coupon->user_id !== $user->id) && (!$coupon->expires_at || !$coupon->expires_at->isPast())) {
                $appliedCoupon = $coupon->code;
                $appliedCouponId = $coupon->id;
                if ($coupon->discount_type === 'fixed') {
                    $discount = min($coupon->discount_amount, $subtotal);
                } elseif ($coupon->discount_type === 'percentage') {
                    $discount = ($subtotal * $coupon->discount_amount) / 100;
                }
            }
        }

        $totalPay = max(0, $subtotal - $discount);

        DB::beginTransaction();
        try {
            // Include discount details in shipping_data for tracking
            $shippingData['coupon_code'] = $appliedCoupon;
            $shippingData['discount'] = round($discount, 2);

            // 1. Create Order
            $order = Order::create([
                'user_id'        => $user ? $user->id : null,
                'coupon_id'      => $appliedCouponId,
                'order_number'   => 'QR-' . strtoupper(Str::random(8)),
                'subtotal'       => $subtotal,
                'tax'            => 0,
                'shipping_cost'  => 0,
                'total_amount'   => $totalPay,
                'status'         => 'pending',
                'payment_status' => 'pending',   // always starts as 'pending'
                'payment_method' => $paymentMethod,
                'shipping_data'  => $shippingData,
            ]);

            // 2. Create Order Items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'    => $order->id,
                    'category_id' => $item['id'],
                    'quantity'    => $item['quantity'],
                    'price'       => $item['price'],
                    'subtotal'    => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // 3. COD — return order_id immediately, no Razorpay
            if ($paymentMethod === 'cod') {
                return response()->json([
                    'success'  => true,
                    'order_id' => $order->id,
                    'message'  => 'Your order has been placed successfully.',
                ]);
            }

            // 4. Online — create Razorpay order
            $razorpay      = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            // If totalPay becomes 0 after discount, handle it by bypassing Razorpay entirely
            if ($totalPay <= 0 && $paymentMethod === 'online') {
                $order->update([
                    'payment_status' => 'completed',
                    'status' => 'confirmed',
                    'paid_at' => now(),
                ]);

                // Auto-assign QR codes since payment is "free"
                foreach ($order->items as $orderItem) {
                    $needed = $orderItem->quantity;
                    $qrQuery = QrCode::where('status', 'available')
                        ->where('category_id', $orderItem->category_id)
                        ->lockForUpdate()
                        ->limit($needed);

                    if (\Schema::hasColumn('qr_codes', 'source')) {
                        $qrQuery->where(function ($q) {
                            $q->whereNull('source')
                                ->orWhere('source', 'online_order');
                        });
                    }
                    $qrCodes = $qrQuery->get();
                    if ($qrCodes->count() < $needed) {
                        throw new \Exception("Stock error during processing. Contact support.");
                    }
                    foreach ($qrCodes as $qr) {
                        $updateData = [
                            'status'      => 'sold',
                            'order_id'    => $order->id,
                            'user_id'     => $order->user_id,
                            'assigned_at' => now(),
                        ];
                        if (\Schema::hasColumn('qr_codes', 'source')) {
                            $updateData['source'] = 'online_order';
                        }
                        $qr->update($updateData);
                    }
                }

                DB::commit();
                return response()->json([
                    'success'  => true,
                    'order_id' => $order->id,
                    'is_free'  => true,
                    'message'  => 'Your order was fully discounted and processed successfully.',
                ]);
            }

            $razorpayOrder = $razorpay->order->create([
                'amount'   => round($totalPay * 100),
                'currency' => 'INR',
                'receipt'  => $order->order_number,
            ]);

            $order->update(['razorpay_order_id' => $razorpayOrder->id]);

            return response()->json([
                'success'           => true,
                'razorpay_key'      => config('services.razorpay.key'),
                'amount'            => round($totalPay * 100),
                'order_id'          => $razorpayOrder->id,
                'internal_order_id' => $order->id,
                'is_free'           => false
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to place the order. Please try again.',
            ], 500);
        }
    }


    // public function verifyPayment(Request $request)
    // {
    //     // 1. Validate only existing fields (Removed signature and payment_id from validation)
    //     $request->validate([
    //         'order_id'          => 'required|string',
    //         'internal_order_id' => 'required|integer|exists:orders,id',
    //     ]);

    //     // 2. Load order
    //     $order = Order::with('items.category')->findOrFail($request->internal_order_id);

    //     DB::beginTransaction();
    //     try {
    //         // 3. Mark order as completed
    //         // NOTE: Removed 'razorpay_payment_id' and 'payment_id' because they don't exist in your DB
    //         $order->update([
    //             'payment_status' => 'completed',
    //             'status'         => 'confirmed',
    //             'paid_at'        => now(),
    //         ]);

    //         // 4. Assign QR codes
    //         foreach ($order->items as $orderItem) {
    //             $needed = $orderItem->quantity;

    //             $qrQuery = QrCode::where('status', 'available')
    //                 ->where('category_id', $orderItem->category_id)
    //                 ->lockForUpdate()
    //                 ->limit($needed);

    //             // Apply source filter only if 'source' column exists
    //             if (\Schema::hasColumn('qr_codes', 'source')) {
    //                 $qrQuery->where(function ($q) {
    //                     $q->whereNull('source')
    //                         ->orWhere('source', 'online_order');
    //                 });
    //             }

    //             $qrCodes = $qrQuery->get();

    //             if ($qrCodes->count() < $needed) {
    //                 DB::rollBack();
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => "Stock error during processing. Contact support.",
    //                 ], 422);
    //             }

    //             foreach ($qrCodes as $qr) {
    //                 $updateData = [
    //                     'status'      => 'sold',
    //                     'order_id'    => $order->id,
    //                     'user_id'     => $order->user_id,
    //                     'assigned_at' => now(),
    //                 ];

    //                 if (\Schema::hasColumn('qr_codes', 'source')) {
    //                     $updateData['source'] = 'online_order';
    //                 }

    //                 $qr->update($updateData);
    //             }
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'success'  => true,
    //             'order_id' => $order->id,
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         \Log::error('verifyPayment failed: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Payment verification failed. Please contact support.',
    //         ], 500);
    //     }
    // }

    public function verifyPayment(Request $request)
    {
        // 1. Validate only existing fields
        $request->validate([
            'order_id'          => 'required|string',
            'internal_order_id' => 'required|integer|exists:orders,id',
        ]);

        // 2. Load order
        $order = Order::findOrFail($request->internal_order_id);

        DB::beginTransaction();
        try {
            // 3. Mark order as completed
            $order->update([
                'payment_status' => 'completed',
                'status'         => 'confirmed',
                'paid_at'        => now(),
            ]);

            DB::commit();

            return response()->json([
                'success'  => true,
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('verifyPayment failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed. Please contact support.',
            ], 500);
        }
    }

    public function orderSuccess(Request $request)
    {
        // Allow guest to see success page (removed user_id check)
        $order = Order::with(['items.category'])->findOrFail($request->order_id);
        return view('user.order-success', compact('order'));
    }

    // --- 3. Registration (Claiming Tags) Logic ---

    public function showRegistrationForm(QrCode $qrCode)
    {
        // 1. Check if ALREADY REGISTERED
        if ($qrCode->status === 'registered') {
            $registration = QrRegistration::where('qr_code_id', $qrCode->id)->first();
            if ($registration) {
                if (Auth::check() && $qrCode->user_id === Auth::id()) {
                    return redirect()->route('user.my-qrs')->with('info', 'You have already registered this tag.');
                }
                return view('scanner.contact-owner', [
                    'qrCode' => $qrCode,
                    'ownerDetails' => $registration
                ]);
            }
        }

        // 3. Security Check for Registration
        $isOwner = ($qrCode->user_id === Auth::id());
        $isGuestPurchase = ($qrCode->user_id === null && in_array($qrCode->status, ['sold', 'assigned']));

        if (!$isOwner && !$isGuestPurchase) {
            abort(403, 'Unauthorized. This tag belongs to someone else or is invalid.');
        }

        return view('user.register-qr', compact('qrCode'));
    }

    public function storeRegistration(Request $request, QrCode $qrCode)
    {
        $isOwner = ($qrCode->user_id === Auth::id());
        $isGuestPurchase = ($qrCode->user_id === null && in_array($qrCode->status, ['sold', 'assigned']));

        if (!$isOwner && !$isGuestPurchase) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'friend_family_1' => 'nullable|string|max:15',
            'friend_family_2' => 'nullable|string|max:15',
            'full_address' => 'nullable|string',
            'selected_tags' => 'nullable|array'
        ]);

        try {
            DB::beginTransaction();

            $alreadyRegistered = QrRegistration::where('qr_code_id', $qrCode->id)->exists();
            if ($alreadyRegistered) {
                return back()->with('error', 'This QR is already registered.');
            }

            QrRegistration::create([
                'qr_code_id' => $qrCode->id,
                'user_id' => Auth::id(),
                'full_name' => $validated['full_name'],
                'mobile_number' => $validated['mobile_number'],
                'full_address' => $validated['full_address'] ?? null,
                'friend_family_1' => $validated['friend_family_1'] ?? null,
                'friend_family_2' => $validated['friend_family_2'] ?? null,
                'selected_tags' => $validated['selected_tags'] ?? [],
                'is_active' => true,
            ]);

            $qrCode->update([
                'user_id' => Auth::id(),
                'status' => 'registered',
                'registered_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('user.my-qrs')
                ->with('success', 'Tag Activated Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Registration Failed!')->withInput();
        }
    }


    // --- 4. User Dashboard ---

    public function myQrs()
    {
        $qrCodes = QrCode::where('user_id', Auth::id())
            ->where('status', 'registered')
            ->with('registration')
            ->latest()
            ->paginate(12);

        return view('user.my-qrs', compact('qrCodes'));
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('user.my-orders', compact('orders'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }


    public function index()
    {
        // Logged in user ke orders fetch karein with items and categories
        $orders = Auth::user()->orders()
            ->with(['items.category'])
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function show($id)
    {
        // Security check: Order current user ka hi hona chahiye
        $order = Auth::user()->orders()
            ->with(['items.category', 'qrCodes'])
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }
}
