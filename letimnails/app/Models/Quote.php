<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'quote_number', 'user_id', 'name', 'email', 'phone', 'description',
        'nail_shape', 'nail_size', 'nail_length', 'design_ideas',
        'status', 'admin_notes', 'quoted_price',
    ];

    protected $casts = [
        'quoted_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
