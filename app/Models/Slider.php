<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'link_url',
        'button_text',
        'order_num',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_num' => 'integer',
    ];

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset('images/banners/hero_village.jpg');
        }

        // 1. Check storage (symlink public/storage or physical storage/app/public)
        if (file_exists(public_path('storage/' . $this->image_path)) || file_exists(storage_path('app/public/' . $this->image_path))) {
            return asset('storage/' . $this->image_path);
        }

        // 2. Check direct public folder (e.g. images/banners/hero_village.jpg)
        if (file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }

        // 3. Check external URL or absolute path
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://') || str_starts_with($this->image_path, '/')) {
            return $this->image_path;
        }

        return asset('images/banners/hero_village.jpg');
    }
}
