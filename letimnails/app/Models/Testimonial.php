<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name', 'content', 'rating', 'source', 'image', 'is_active', 'position',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }
}
