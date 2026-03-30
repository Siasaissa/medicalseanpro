<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientVital extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bmi',
        'heart_rate',
        'fbc_status',
        'weight',
        'blood_pressure',
        'glucose_level',
        'body_temperature',
        'spo2',
        'recorded_at',
        'notes',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

