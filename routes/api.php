<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\ZegoToken;
use App\Http\Controllers\BookingController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});

Route::post('/clickpesa/webhook', [BookingController::class, 'clickpesaWebhook']);


