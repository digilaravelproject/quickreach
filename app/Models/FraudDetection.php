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
        'call_started_at',
        'call_ended_at'
    ];
}
