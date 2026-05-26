<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name', 'file_name', 'mime_type', 'path', 'disk',
        'collection', 'alt', 'size', 'custom_properties',
    ];

    protected $casts = [
        'size' => 'integer',
        'custom_properties' => 'json',
    ];

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    public function getThumbnailAttribute()
    {
        $info = pathinfo($this->path);
        return asset('storage/' . $info['dirname'] . '/thumb_' . $info['basename']);
    }

    public function scopeImages($query)
    {
        return $query->whereIn('mime_type', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
    }
}
