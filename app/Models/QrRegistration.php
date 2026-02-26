<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrRegistration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'qr_code_id',
        'user_id',
        'full_name',
        'mobile_number',
        'full_address',
        'friend_family_1',
        'friend_family_2',
        'selected_tags',
        'is_active',
    ];

    protected $casts = [
        'selected_tags' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the QR code for this registration
     */
    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QrCode::class);
    }

    /**
     * Get the user for this registration
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get emergency contacts as array
     */
    public function getEmergencyContactsAttribute($value): array
    {
        // Agar database se value hai to use karo
        if ($value && $value !== 'null') {
            return json_decode($value, true) ?? [];
        }

        // Otherwise friend_family fields se banao
        $contacts = [];

        if ($this->friend_family_1) {
            $contacts[] = [
                'name' => 'Friend/Family 1',
                'number' => $this->friend_family_1
            ];
        }

        if ($this->friend_family_2) {
            $contacts[] = [
                'name' => 'Friend/Family 2',
                'number' => $this->friend_family_2
            ];
        }

        return $contacts;
    }

    /**
     * Scope for active registrations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
