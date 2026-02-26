<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'main_title',
        'main_description',
        'main_image',
        'mission_title',
        'mission_description',
        'mission_image',
        'story_description',
        'story_image'
    ];
}
