<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Umkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'owner_name',
        'phone',
        'address',
        'dusun',
        'latitude',
        'longitude',
        'maps_url',
        'description',
        'logo_image',
        'banner_image',
        'instagram_url',
        'facebook_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($umkm) {
            if (empty($umkm->slug)) {
                $umkm->slug = Str::slug($umkm->name);
            }
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Check if UMKM has WhatsApp number
     */
    public function getHasWhatsappAttribute(): bool
    {
        return !empty(trim((string)$this->phone));
    }

    /**
     * Clean phone number for WhatsApp URL (convert 08... to 628...)
     */
    public function getCleanPhoneAttribute(): ?string
    {
        if (!$this->has_whatsapp) {
            return null;
        }
        $phone = preg_replace('/[^0-9]/', '', (string)$this->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    /**
     * Check if UMKM has valid GPS coordinates
     */
     public function getHasCoordinatesAttribute(): bool
     {
         return !is_null($this->latitude) && !is_null($this->longitude) && $this->latitude != 0 && $this->longitude != 0;
     }

    /**
     * Direct Google Maps pin URL
     */
    public function getGoogleMapsUrlAttribute(): ?string
    {
        if ($this->has_coordinates) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return $this->maps_url;
    }

    /**
     * Direct Google Maps Embed URL for iframe preview (Free, no API key required)
     */
    public function getGoogleMapsEmbedUrlAttribute(): ?string
    {
        if ($this->has_coordinates) {
            return "https://maps.google.com/maps?q={$this->latitude},{$this->longitude}&hl=id&z=16&output=embed";
        }
        if ($this->maps_url && (str_contains($this->maps_url, 'google.com/maps') || str_contains($this->maps_url, 'maps.app.goo.gl'))) {
            return "https://maps.google.com/maps?q=" . urlencode($this->name . ' ' . $this->address . ' Kamarang Cirebon') . "&hl=id&z=16&output=embed";
        }
        return null;
    }

    /**
     * Direct Google Maps Directions / Navigation URL
     */
    public function getGoogleMapsDirectionUrlAttribute(): ?string
    {
        if ($this->has_coordinates) {
            return "https://www.google.com/maps/dir/?api=1&destination={$this->latitude},{$this->longitude}";
        }
        return $this->google_maps_url;
    }

    /**
     * Direct WhatsApp chat link for this UMKM store
     */
    public function getWhatsappLinkAttribute(): ?string
    {
        $phone = $this->clean_phone;
        if (!$phone) {
            return null;
        }
        $message = urlencode("Halo {$this->name}, saya melihat profil UMKM Anda di Website Katalog Desa Kamarang. Saya ingin bertanya seputar produk yang tersedia.");
        return "https://wa.me/{$phone}?text={$message}";
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo_image && file_exists(public_path('storage/' . $this->logo_image))) {
            return asset('storage/' . $this->logo_image);
        }
        if ($this->logo_image && (str_starts_with($this->logo_image, 'http://') || str_starts_with($this->logo_image, 'https://') || str_starts_with($this->logo_image, '/'))) {
            return $this->logo_image;
        }
        return asset('images/default-umkm.jpg');
    }
}
