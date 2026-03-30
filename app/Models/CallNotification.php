<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'sender_id',
        'receiver_id',
        'type',
        'seen_at',
    ];

    protected $casts = [
        'seen_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}

