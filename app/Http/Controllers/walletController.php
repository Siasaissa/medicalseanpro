<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class walletController extends Controller
{
    public function transaction(){

        $history = Booking::where('user_id', Auth::id())->with('patient')
                            ->where('status', 'active')
                            ->orderBy('appointment_datetime', 'desc')
                            ->paginate(10);
                            
        $total = Booking::where('user_id', Auth::id())->sum('service_price');

        return view('patient.wallet', compact('history','total'));
    }
}
