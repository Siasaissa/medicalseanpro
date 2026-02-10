<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
        'category',
        'price',
        'quantity',
        'discount',
        'description',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
