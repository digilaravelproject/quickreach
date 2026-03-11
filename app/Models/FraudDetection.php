<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FraudDetection extends Model
{
    protected $fillable = [
        'from_number',
        'to_number',
        'type',
        'qr_code_id',
        'fraud',
        'call_started_at',
        'call_ended_at'
    ];

    /**
     * Ensure call timestamps are cast to Carbon instances so formatting works.
     */
    protected $casts = [
        'call_started_at' => 'datetime',
        'call_ended_at' => 'datetime',
    ];
}
