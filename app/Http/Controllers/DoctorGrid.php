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
public function grid(Request $request)
    {
        $query = User::whereHas('profile', function($q) {
            $q->whereNotNull('id'); // Ensure user has a profile
        })->where('role', 'doctor'); // Assuming you have a role column

        // Apply filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('profile', function($profileQuery) use ($request) {
                      $profileQuery->where('hospital', 'like', '%' . $request->search . '%')
                                  ->orWhere('speciality', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('location')) {
            $query->whereHas('profile', function($q) use ($request) {
                $q->where('location', 'like', '%' . $request->location . '%')
                  ->orWhere('address', 'like', '%' . $request->location . '%');
            });
        }

        // Speciality filter
        if ($request->filled('specialities')) {
            $specialities = $request->specialities;
            $query->whereHas('profile', function($q) use ($specialities) {
                $q->where(function($query) use ($specialities) {
                    foreach ($specialities as $speciality) {
                        $query->orWhere('speciality', $speciality)
                              ->orWhere('primary_speciality', $speciality)
                              ->orWhereJsonContains('secondary_specialities', $speciality);
                    }
                });
            });
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->whereHas('profile', function($q) use ($request) {
                $q->whereIn('sex', $request->gender);
            });
        }

        // Consultation type filter
        if ($request->filled('consultation_types')) {
            $query->whereHas('profile', function($q) use ($request) {
                foreach ($request->consultation_types as $type) {
                    $q->whereJsonContains('consultation_modes', $type);
                }
            });
        }

        // Languages filter
        if ($request->filled('languages')) {
            $query->whereHas('profile', function($q) use ($request) {
                foreach ($request->languages as $language) {
                    $q->whereJsonContains('known_languages', $language);
                }
            });
        }

        // Availability filter
        if ($request->boolean('available')) {
            // You can implement your availability logic here
            // This is a placeholder - adjust based on your availability logic
            $query->whereHas('profile', function($q) {
                $q->whereNotNull('availability_schedule');
            });
        }

        // Sort by price
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'price_low_high':
                    $query->whereHas('profile', function($q) {
                        $q->orderBy('video_fee', 'asc');
                    });
                    break;
                case 'price_high_low':
                    $query->whereHas('profile', function($q) {
                        $q->orderBy('video_fee', 'desc');
                    });
                    break;
            }
        }

        // Get distinct filter options for the sidebar
        $specialities = $this->getUniqueSpecialities();
        $locations = $this->getUniqueLocations();
        $languages = $this->getUniqueLanguages();
        $consultationTypes = $this->getConsultationTypes();

        $doctors = $query->with('profile')->paginate(12)->withQueryString();
        
        $totalDoctors = $doctors->total();

        return view('patient.doctor-grid', compact(
            'doctors', 
            'totalDoctors', 
            'specialities', 
            'locations', 
            'languages',
            'consultationTypes'
        ));
    }

    private function getUniqueSpecialities()
    {
        $specialities = Profile::whereNotNull('speciality')
            ->select('speciality')
            ->distinct()
            ->pluck('speciality')
            ->toArray();

        $primarySpecialities = Profile::whereNotNull('primary_speciality')
            ->select('primary_speciality')
            ->distinct()
            ->pluck('primary_speciality')
            ->toArray();

        return array_unique(array_merge($specialities, $primarySpecialities));
    }

    private function getUniqueLocations()
    {
        return Profile::whereNotNull('location')
            ->select('location')
            ->distinct()
            ->pluck('location')
            ->toArray();
    }

    private function getUniqueLanguages()
    {
        $allLanguages = [];
        $profiles = Profile::whereNotNull('known_languages')->get();
        
        foreach ($profiles as $profile) {
            if (is_array($profile->known_languages)) {
                $allLanguages = array_merge($allLanguages, $profile->known_languages);
            }
        }
        
        return array_unique($allLanguages);
    }

    private function getConsultationTypes()
    {
        return [
            'video' => 'Video Call',
            'voice' => 'Audio Call',
            'chat' => 'Chat',
            'home_visit' => 'Home Visit'
        ];
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
