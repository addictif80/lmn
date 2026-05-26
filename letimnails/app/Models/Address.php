<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'type', 'first_name', 'last_name', 'address_line1',
        'address_line2', 'city', 'state', 'postal_code', 'country',
        'phone', 'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullAddressAttribute()
    {
        $parts = [$this->address_line1];
        if ($this->address_line2) $parts[] = $this->address_line2;
        $parts[] = "{$this->postal_code} {$this->city}";
        return implode(', ', $parts);
    }
}
