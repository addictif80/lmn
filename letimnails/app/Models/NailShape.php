<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NailShape extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'position', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    public function sizes()
    {
        return $this->hasMany(NailSize::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }
}
