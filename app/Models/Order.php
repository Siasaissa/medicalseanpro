<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'items',
        'total',
        'shipping_address',
        'payment_method',
        'payment_gateway',
        'phone',
        'status',
        'payment_reference',
        'transaction_id',
        'payment_response',
        'fulfilled_at',
    ];

    protected $casts = [
        'items' => 'array',
        'fulfilled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'user_id', 'user_id');
    }
}
