<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'razorpay_order_id',
        'razorpay_payment_id',
        'subtotal',
        'tax',
        'shipping_cost',
        'total_amount',
        'status',           // 'pending' | 'confirmed'
        'payment_status',   // 'pending' | 'completed'
        'payment_method',   // 'online'  | 'cod'       ← was MISSING, caused the bug
        'shipping_data',
        'paid_at',
    ];

    protected $casts = [
        'shipping_data' => 'array',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'paid_at'       => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function qrCodes()
    {
        return $this->hasMany(QrCode::class, 'order_id');
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    public function isCod(): bool
    {
        return $this->payment_method === 'cod';
    }

    public function isCompleted(): bool
    {
        return $this->payment_status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }
}
