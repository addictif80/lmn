<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentType extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'duration_minutes', 'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_minutes' => 'integer',
        'is_active' => 'boolean',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFormattedDurationAttribute()
    {
        $hours = intdiv($this->duration_minutes, 60);
        $mins = $this->duration_minutes % 60;
        $parts = [];
        if ($hours > 0) $parts[] = "{$hours}h";
        if ($mins > 0) $parts[] = "{$mins}min";
        return implode(' ', $parts);
    }
}
