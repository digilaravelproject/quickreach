<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['title', 'sub_title', 'image_path', 'link', 'order_priority', 'is_active'];
}
