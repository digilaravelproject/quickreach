<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HowItWork extends Model
{
    protected $table = 'how_it_works';
    protected $fillable = ['step_order', 'title', 'description', 'image_path'];
}
