<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UseCase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'icon_image',
        'bg_color',
        'sort_order',
    ];

    /**
     * Get the full URL for the icon image.
     * Use case: {{ $item->icon_url }} in Blade
     */
    public function getIconUrlAttribute()
    {
        if ($this->icon_image && Storage::disk('public')->exists($this->icon_image)) {
            return asset('storage/' . $this->icon_image);
        }

        // Return a default placeholder if no image exists
        return asset('assets/images/default-icon.png');
    }
}
