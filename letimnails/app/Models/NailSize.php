<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NailSize extends Model
{
    protected $fillable = [
        'name', 'slug', 'nail_shape_id', 'image', 'position',
    ];

    public function shape()
    {
        return $this->belongsTo(NailShape::class, 'nail_shape_id');
    }
}
