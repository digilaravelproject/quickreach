<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $table = 'contact_settings'; // table protect (fix)

    protected $fillable = [
        'email',
        'phone',
        'whatsapp',
        'instagram',
        'facebook',
        'twitter',
        'youtube',
        'linkedin',
        'website',
        'address',
        'support_hours',
    ];
}