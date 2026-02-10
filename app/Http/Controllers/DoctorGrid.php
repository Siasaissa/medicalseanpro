<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;



class DoctorGrid extends Controller
{
public function grid()
{
    $doctor = User::where('role', 'doctor')->get();

    return view('patient.doctor-grid', compact('doctor'));
}

public function show($doctorId)
{
    $doctor = User::findOrFail($doctorId);

    return view('patient.booking', compact('doctor'));
}


public function MyPatient()
{
    $Mypatient = Booking::select('user_id', DB::raw('COUNT(*) as total'))
        ->where('doctor_id', Auth::id()) // doctor viewing their patients
        ->groupBy('user_id')
        ->orderByDesc('total')
        ->with('patient') // make sure Booking model has: public function patient()
        ->get();
$total = Booking::where('doctor_id', Auth::id())
                ->distinct('user_id')  // unique patients
                ->count('user_id');


    return view('doctor.mypatients', compact('Mypatient','total'));
}

public function speciality(){
    return view('doctor.specialities');
}

public function updateAvailability(Request $request)
{
    $request->validate([
        'availability' => 'required|in:available,not_available',
    ]);

    $profile = Profile::where('user_id', Auth::id())->first();

    if (!$profile) {
        return response()->json(['error' => 'Doctor not found'], 404);
    }

    $profile->availability = $request->availability;
    $profile->save();

    return response()->json([
        'success' => true,
        'availability' => $profile->availability,
    ]);
}
public function filterDoctors(Request $request)
{
    $availability = $request->query('availability');

    $query = User::where('role', 'doctor')->with('profile');

    if ($availability === 'available') {
        $query->whereHas('profile', function($q) {
            $q->where('availability', 'available');
        });
    } elseif ($availability === 'not_available') {
        $query->whereHas('profile', function($q) {
            $q->where('availability', 'not_available');
        });
    }

    $doctors = $query->get();

    // Return only the HTML part (to replace in the frontend)
    return view('partials.doctor-cards', compact('doctors'))->render();
}

}
