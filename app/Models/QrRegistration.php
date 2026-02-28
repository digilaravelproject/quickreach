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
        'category_data', // New field
        'emergency_note', // New field
        'photo_path', // New field
        'is_active',
    ];

    protected $casts = [
        'selected_tags' => 'array',
        'category_data' => 'array', // JSON to array cast
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
        if ($value && $value !== 'null') {
            return json_decode($value, true) ?? [];
        }

        $contacts = [];

        if ($this->friend_family_1) {
            $contacts[] = [
                'name' => 'Emergency Contact 1',
                'number' => $this->friend_family_1
            ];
        }

        if ($this->friend_family_2) {
            $contacts[] = [
                'name' => 'Emergency Contact 2',
                'number' => $this->friend_family_2
            ];
        }

        return $contacts;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
