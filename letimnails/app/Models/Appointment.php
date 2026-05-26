<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id', 'appointment_type_id', 'first_name', 'last_name',
        'email', 'phone', 'date', 'time', 'status', 'notes', 'admin_notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(AppointmentType::class, 'appointment_type_id');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByDate($query, $date)
    {
        return $query->where('date', $date);
    }
}
