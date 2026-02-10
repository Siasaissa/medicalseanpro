<?php

namespace App\Http\Controllers;

use App\Models\Order;
use DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Profile;

class AdminController extends Controller
{
    public function dashboard(){
        $doctor = User::where('role', 'doctor')->count();
        $patient = User::where('role', 'patient')->count();
        $booking = Booking::all()->count();
        $revenue = DB::table('bookings')->sum('total');

        return view('admin.dashboard',compact('doctor','patient','booking','revenue'));
    }
    public function appointment(){
        $appointment = Booking::all();

        return view('admin.appointment',compact('appointment'));
    }

public function doctorList()
{
    $doctor = Profile::whereHas('user', function ($query) {
        $query->where('role', 'doctor');

    })->get();

    return view('admin.doctorList', compact('doctor'));
}


    public function patientList(){
        $patient = Profile::whereHas('user', function($query){
            $query->where('role','patient');
        })->get();
        
        return view('admin.patientList', compact('patient'));
    }
    public function Transaction(){
        $transactions = Order::latest()->get();

        return view('admin.Transaction', compact('transactions'));
    }
}
