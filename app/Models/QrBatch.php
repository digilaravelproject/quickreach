<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrBatch extends Model
{
    protected $fillable = ['batch_code', 'category_id', 'quantity'];

    public function qrCodes(): HasMany
    {
        return $this->hasMany(QrCode::class, 'qr_batch_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Generates a short, readable batch code.
     * Example: ELC-20260302-100PCS
     */
    public static function generateBatchCode($categoryName, $quantity): string
    {
        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $categoryName), 0, 3));
        return $prefix . '-' . now()->format('Ymd-Hi') . '-' . $quantity . 'PCS';
    }
}
