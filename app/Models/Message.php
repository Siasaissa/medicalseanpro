<?php

// app/Models/Message.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
        'read_at',
        'booking_id',
        
    ];

    protected $casts = [
    'is_read' => 'boolean',
    'read_at' => 'datetime',
    ];

    public $timestamps = true; 

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

        public function booking()
    {
        return $this->belongsTo(\App\Models\Booking::class, 'booking_id');
    }

    // Mark message as read
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
    }

    // Scope to get unread messages for a user
    public function scopeUnreadForUser($query, $userId)
    {
        return $query->where('receiver_id', $userId)
                     ->where('is_read', false);
    }

    // Scope to get unread messages for a specific booking
    public function scopeUnreadForBooking($query, $bookingId, $userId)
    {
        return $query->where('booking_id', $bookingId)
                     ->where('receiver_id', $userId)
                     ->where('is_read', false);
    }

}

