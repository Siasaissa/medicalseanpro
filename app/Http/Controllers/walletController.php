<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Support\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class walletController extends Controller
{
    public function transaction(){
        $history = Booking::where('user_id', Auth::id())
            ->with('doctor')
            ->orderByDesc('appointment_datetime')
            ->paginate(10);

        $totalSuccessful = Booking::where('user_id', Auth::id())
            ->whereIn('status', PaymentStatus::successValues())
            ->sum('total');

        $totalTransactions = Booking::where('user_id', Auth::id())->count();

        $lastPaymentDate = Booking::where('user_id', Auth::id())
            ->whereIn('status', array_merge(PaymentStatus::successValues(), PaymentStatus::processingValues()))
            ->orderByDesc('updated_at')
            ->value('updated_at');

        return view('patient.wallet', compact(
            'history',
            'totalSuccessful',
            'totalTransactions',
            'lastPaymentDate'
        ));
    }
}
