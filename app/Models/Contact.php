<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * In fields ko hum form se direct save kar sakte hain.
     */
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read'
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];
}
