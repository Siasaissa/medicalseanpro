<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterface;

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
    'status',
    'payment_reference',
    'transaction_id',
    'payment_response'
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

    public function sessionStartAt(): Carbon
    {
        return Carbon::parse($this->appointment_datetime);
    }

    public function sessionDurationMinutes(): int
    {
        $minutes = (int) preg_replace('/\D+/', '', (string) $this->service_time);
        return max($minutes, 0);
    }

    public function sessionEndAt(): Carbon
    {
        return $this->sessionStartAt()->copy()->addMinutes($this->sessionDurationMinutes());
    }

    public function isSessionActive(?CarbonInterface $at = null): bool
    {
        $now = $at ? Carbon::instance($at) : now();
        $start = $this->sessionStartAt();
        $end = $this->sessionEndAt();

        return $now->greaterThanOrEqualTo($start) && $now->lessThan($end);
    }

    public function isSessionEnded(?CarbonInterface $at = null): bool
    {
        $now = $at ? Carbon::instance($at) : now();
        return $now->greaterThanOrEqualTo($this->sessionEndAt());
    }
}
