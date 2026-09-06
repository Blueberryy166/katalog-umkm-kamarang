<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id',
        'category_id',
        'name',
        'slug',
        'price',
        'price_max',
        'unit',
        'variants',
        'short_description',
        'full_description',
        'main_image',
        'gallery_images',
        'pirt_number',
        'stock_status',
        'is_featured',
        'view_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_max' => 'decimal:2',
        'is_featured' => 'boolean',
        'variants' => 'array',
        'gallery_images' => 'array',
        'view_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Check if product seller has WhatsApp
     */
    public function getHasWhatsappAttribute(): bool
    {
        return $this->umkm && $this->umkm->has_whatsapp;
    }

    /**
     * Check if product has multiple variants
     */
    public function getHasVariantsAttribute(): bool
    {
        return !empty($this->variants) && is_array($this->variants) && count($this->variants) > 0;
    }

    /**
     * Direct WhatsApp order/inquiry URL for this specific product (if seller has phone)
     */
    public function getWhatsappOrderUrlAttribute(): ?string
    {
        return $this->getWhatsappUrlWithVariant();
    }

    /**
     * Get WhatsApp order URL with specific variant
     */
    public function getWhatsappUrlWithVariant(?string $variant = null): ?string
    {
        if (!$this->has_whatsapp) {
            return null;
        }

        $phone = $this->umkm->clean_phone;
        $umkmName = $this->umkm->name;
        $formattedPrice = $this->formatted_price;
        $unit = $this->unit ? '/' . $this->unit : '';

        $variantText = !empty($variant) ? " (Varian: {$variant})" : '';
        $text = "Halo {$umkmName}, saya melihat produk \"{$this->name}\"{$variantText} ({$formattedPrice}{$unit}) di Website Katalog UMKM Desa Kamarang. Apakah produk ini masih tersedia?";

        return "https://wa.me/{$phone}?text=" . urlencode($text);
    }

    /**
     * Formatted price or price range (e.g. Rp 10.000 or Rp 10.000 - 20.000)
     */
    public function getFormattedPriceAttribute(): string
    {
        $min = (float)$this->price;
        $max = $this->price_max ? (float)$this->price_max : null;

        if ($max && $max > $min) {
            return 'Rp ' . number_format($min, 0, ',', '.') . ' - ' . number_format($max, 0, ',', '.');
        }

        return 'Rp ' . number_format($min, 0, ',', '.');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->main_image && file_exists(public_path('storage/' . $this->main_image))) {
            return asset('storage/' . $this->main_image);
        }
        if ($this->main_image && (str_starts_with($this->main_image, 'http://') || str_starts_with($this->main_image, 'https://') || str_starts_with($this->main_image, '/'))) {
            return $this->main_image;
        }
        return asset('images/default-product.jpg');
    }

    public function getStockStatusLabelAttribute(): string
    {
        return match ($this->stock_status) {
            'available' => 'Tersedia',
            'preorder' => 'Pre-Order',
            'out_of_stock' => 'Stok Habis',
            default => 'Tersedia',
        };
    }

    public function getStockStatusBadgeClassAttribute(): string
    {
        return match ($this->stock_status) {
            'available' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'preorder' => 'bg-amber-100 text-amber-800 border-amber-300',
            'out_of_stock' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-emerald-100 text-emerald-800 border-emerald-300',
        };
    }
}
