<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'short_description',
        'price', 'compare_price', 'sku', 'type', 'is_customizable',
        'is_available_for_quote', 'stock', 'track_stock', 'is_active',
        'is_featured', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'is_customizable' => 'boolean',
        'is_available_for_quote' => 'boolean',
        'track_stock' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'stock' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function getImageAttribute()
    {
        $primary = $this->primaryImage;
        return $primary ? $primary->path : null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getFinalPriceAttribute()
    {
        return $this->compare_price ?: $this->price;
    }

    public function getHasDiscountAttribute()
    {
        return $this->compare_price !== null && $this->compare_price > 0;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->hasDiscount || $this->price == 0) return 0;
        return round((1 - $this->compare_price / $this->price) * 100);
    }
}
