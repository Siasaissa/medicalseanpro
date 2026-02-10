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
        'phone',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

    public function profile()
{
    return $this->hasOne(Profile::class, 'user_id');
}

}
