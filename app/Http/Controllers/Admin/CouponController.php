<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\CouponAssignedMail;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::with('user', 'orders.user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        $coupons = $query->get()->map(function($coupon) {
            $coupon->total_sales = $coupon->orders()->count();
            $coupon->unique_users = $coupon->orders()->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            return $coupon;
        });
        
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $users = User::all(['id', 'name']);
        return view('admin.coupons.create', compact('users'));
    }

    public function show(Coupon $coupon)
    {
        $coupon->load('user', 'orders.user');
        
        // load orders with user relationships
        $orders = $coupon->orders()->with('user')->get();

        // Build user grouping including guests (by email)
        $usersWithOrders = $orders->groupBy(function($o) {
            if ($o->user_id) {
                return 'user_'.$o->user_id;
            }
            return 'guest_'.($o->shipping_data['email'] ?? $o->id);
        })->map(function($group) {
            $first = $group->first();
            // prepare a pseudo-user object for both registered and guest
            if ($first->user) {
                $userObj = (object)[
                    'id' => $first->user->id,
                    'name' => $first->user->name,
                    'email' => $first->user->email,
                ];
            } else {
                $userObj = (object)[
                    'id' => null,
                    'name' => $first->shipping_data['name'] ?? 'Guest',
                    'email' => $first->shipping_data['email'] ?? '',
                ];
            }

            return [
                'user' => $userObj,
                'orders_count' => $group->count(),
                'total_spent' => $group->sum('total_amount'),
                'orders' => $group,
            ];
        });

        $totalSales = $orders->sum('total_amount');
        $uniqueUsers = $usersWithOrders->count();
        
        // Calculate total discount from shipping_data
        $totalDiscount = $orders->sum(function($order) {
            return $order->shipping_data['discount'] ?? 0;
        });

        return view('admin.coupons.show', compact('coupon', 'usersWithOrders', 'totalSales', 'uniqueUsers', 'totalDiscount'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'required|string|unique:coupons,code',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_amount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $coupon = Coupon::create($validated);

        try {
            $user = User::findOrFail($validated['user_id']);
            Mail::to($user->email)->send(new CouponAssignedMail($coupon));
        } catch (\Exception $e) {
            // Log error or silently ignore if email fails
            \Log::error('Failed to send coupon email: ' . $e->getMessage());
        }

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        $users = User::all(['id', 'name']);
        return view('admin.coupons.edit', compact('coupon', 'users'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:fixed,percentage',
            'discount_amount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }

    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        return redirect()->back()->with('success', 'Coupon status updated successfully.');
    }
}
