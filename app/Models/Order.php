<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'razorpay_order_id',
        'subtotal',
        'tax',
        'shipping_cost',
        'total_amount',
        'status',
        'payment_status',
        'shipping_data'
    ];

    protected $casts = [
        'shipping_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // New Relationship to link QR Codes directly to the Order
    public function qrCodes()
    {
        return $this->hasMany(QrCode::class, 'order_id');
    }
}
