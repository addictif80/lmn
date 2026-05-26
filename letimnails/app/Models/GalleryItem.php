<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = [
        'gallery_category_id', 'title', 'reference', 'description', 'image', 'is_active', 'position',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
