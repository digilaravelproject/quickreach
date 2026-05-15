<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::with('orders.user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('code', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        $coupons = $query->get()->map(function ($coupon) {
            $coupon->total_sales = $coupon->orders()->count();
            $coupon->unique_users = $coupon->orders()->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            return $coupon;
        });

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function show(Coupon $coupon)
    {
        $coupon->load('orders.user');

        $orders = $coupon->orders()->with('user')->get();

        $usersWithOrders = $orders->groupBy(function ($o) {
            if ($o->user_id) {
                return 'user_' . $o->user_id;
            }
            return 'guest_' . ($o->shipping_data['email'] ?? $o->id);
        })->map(function ($group) {
            $first = $group->first();
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

        $totalDiscount = $orders->sum(function ($order) {
            return $order->shipping_data['discount'] ?? 0;
        });

        return view('admin.coupons.show', compact('coupon', 'usersWithOrders', 'totalSales', 'uniqueUsers', 'totalDiscount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_amount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
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
