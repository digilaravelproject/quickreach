<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'discount_type',
        'discount_amount',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationships for coupon usage tracking
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Get total sales using this coupon
    public function getTotalSalesAttribute()
    {
        // sum of total_amount from related orders
        return $this->orders()->sum('total_amount');
    }

    // Get unique users who used this coupon (including guests by email)
    public function getUniqueUsersAttribute()
    {
        $orders = $this->orders()->get();
        return $orders->map(function($o) {
            if ($o->user_id) {
                return 'user_'.$o->user_id;
            }
            return 'guest_'.($o->shipping_data['email'] ?? $o->id);
        })->unique()->count();
    }

    // Get users who used this coupon with their order details
    public function getUsersWithOrders()
    {
        return User::whereIn('id', $this->orders()->pluck('user_id'))->get();
    }
}
