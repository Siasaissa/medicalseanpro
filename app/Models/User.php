<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    // Backward-compatible alias used in existing pages (doctor bookings).
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'doctor_id');
    }

    public function doctorBookings()
    {
        return $this->hasMany(Booking::class, 'doctor_id');
    }

    public function patientBookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
}
