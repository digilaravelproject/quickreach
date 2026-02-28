<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    protected $fillable = ['qr_id', 'caller', 'agent', 'status', 'response'];
}
