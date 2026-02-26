<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'qr_code',
        'category_id',
        'user_id',
        'qr_image_path',
        'order_id',
        'status',
        'assigned_at',
        'registered_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'registered_at' => 'datetime',
    ];

    /**
     * Get the category that owns the QR code.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order associated with the QR code.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the registration details for this QR code.
     */
    public function registration(): HasOne
    {
        return $this->hasOne(QrRegistration::class, 'qr_code_id', 'id');
    }

    /**
     * Get the scan history for this QR code.
     */
    public function scans(): HasMany
    {
        return $this->hasMany(QrScan::class);
    }

    // --- Scopes ---

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    public function scopeRegistered($query)
    {
        return $query->where('status', 'registered');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
