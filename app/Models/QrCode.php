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
        'qr_batch_id',
        'user_id',
        'qr_image_path',
        'order_id',
        'status',
        'source',           // 'online_order' | 'bulk_admin' — prevents bulk QRs mixing with online assignment
        'assigned_at',
        'registered_at',
    ];

    protected $casts = [
        'assigned_at'   => 'datetime',
        'registered_at' => 'datetime',
    ];

    // ── Relationships ───────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registration(): HasOne
    {
        return $this->hasOne(QrRegistration::class, 'qr_code_id', 'id');
    }

    public function scans(): HasMany
    {
        return $this->hasMany(QrScan::class);
    }

    // ── Scopes ──────────────────────────────────────────────

    /** QR codes available for online order assignment (excludes bulk-admin QRs) */
    public function scopeAvailableForOnlineOrder($query)
    {
        return $query->where('status', 'available')
            ->where(function ($q) {
                $q->whereNull('source')
                    ->orWhere('source', 'online_order');
            });
    }

    /** QR codes generated for bulk admin download/sale (never auto-assigned to online orders) */
    public function scopeBulkAdmin($query)
    {
        return $query->where('source', 'bulk_admin');
    }

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

    // ── Helpers ─────────────────────────────────────────────

    public function isBulkAdminQr(): bool
    {
        return $this->source === 'bulk_admin';
    }
}
