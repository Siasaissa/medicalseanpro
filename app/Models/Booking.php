<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'doctor_id',
    'appointment_datetime',
    'appointment_type',
    'service_price',
    'service',
    'service_time',
    'fees',
    'tax',
    'discount',
    'total',
    'phone',             
    'payment_gateway',   
];

    // Relations
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
