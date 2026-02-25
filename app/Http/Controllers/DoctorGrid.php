<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Carbon\Carbon;



class DoctorGrid extends Controller
{
public function grid(Request $request)
    {
        dd(now(), now()->format('H:i:s'));
        
        $query = User::whereHas('profile', function($q) {
            $q->whereNotNull('id') // Ensure user has a profile
                ->where('start_time', '<=', Carbon::now()->format('H:i:s'))
                ->where('end_time', '=>', Carbon::now()->format('H:i:s'));
        })  ->where('role', 'doctor');

            
            

        // Apply filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('profile', function($profileQuery) use ($request) {
                      $profileQuery->where('hospital', 'like', '%' . $request->search . '%')
                                  ->orWhere('speciality', 'like', '%' . $request->search . '%')
                                  ->orWhere('primary_speciality', 'like', '%' . $request->search . '%');
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
                    $mode = $this->mapConsultationTypeToMode($type);
                    if ($mode) {
                        $q->whereJsonContains('consultation_modes', $mode);
                    }
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

        // Enhanced Availability filter
        if ($request->boolean('available')) {
            $this->applyAvailabilityFilter($query);
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
        
        // Get counts for filters
        $specialityCounts = $this->getSpecialityCounts();
        $genderCounts = $this->getGenderCounts();

        $doctors = $query->with('profile')->paginate(12)->withQueryString();
        
        $totalDoctors = $doctors->total();

        return view('patient.doctor-grid', compact(
            'doctors', 
            'totalDoctors', 
            'specialities', 
            'locations', 
            'languages',
            'consultationTypes',
            'specialityCounts',
            'genderCounts'
        ));
    }

    /**
     * Enhanced availability filter that checks current time against doctor's schedule
     */
    private function applyAvailabilityFilter($query)
    {
        $currentTime = Carbon::now();
        $currentDay = strtolower($currentTime->format('l')); // monday, tuesday, etc.
        $currentTimeString = $currentTime->format('H:i:s');

        return $query->whereHas('profile', function($q) use ($currentDay, $currentTimeString) {
            $q->where(function($query) use ($currentDay, $currentTimeString) {
                $query->whereNotNull('availability_schedule')
                      ->where('availability_schedule', '!=', '[]')
                      ->whereRaw("JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".is_available') = true")
                      ->whereRaw("JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".start_time') <= ?", [$currentTimeString])
                      ->whereRaw("JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".end_time') >= ?", [$currentTimeString]);
            });

            // Check break time if exists
            $q->where(function($query) use ($currentDay, $currentTimeString) {
                $query->whereRaw("JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".break_time') IS NULL")
                      ->orWhereRaw("JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".break_time') = ''")
                      ->orWhere(function($subQuery) use ($currentDay, $currentTimeString) {
                          $subQuery->whereRaw("? NOT BETWEEN JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".break_start') AND JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".break_end')", [$currentTimeString]);
                      });
            });
        });
    }

    /**
     * Alternative availability filter for MySQL 5.7+ using JSON functions
     * Use this if your MySQL version supports JSON functions
     */
    private function applyAvailabilityFilterMySQL57($query)
    {
        $currentTime = Carbon::now();
        $currentDay = strtolower($currentTime->format('l'));
        $currentTimeString = $currentTime->format('H:i:s');

        return $query->whereHas('profile', function($q) use ($currentDay, $currentTimeString) {
            $q->whereNotNull('availability_schedule')
              ->where('availability_schedule', '!=', '[]')
              ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".is_available')) = 'true'")
              ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".start_time')) <= ?", [$currentTimeString])
              ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".end_time')) >= ?", [$currentTimeString])
              ->where(function($query) use ($currentDay, $currentTimeString) {
                  $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".break_time')) IS NULL")
                        ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".break_time')) = ''")
                        ->orWhere(function($subQuery) use ($currentDay, $currentTimeString) {
                            $breakStart = "JSON_UNQUOTE(JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".break_start'))";
                            $breakEnd = "JSON_UNQUOTE(JSON_EXTRACT(availability_schedule, '$.\"$currentDay\".break_end'))";
                            $subQuery->whereRaw("? NOT BETWEEN $breakStart AND $breakEnd", [$currentTimeString]);
                        });
              });
        });
    }

    /**
     * Alternative for PostgreSQL using JSONB functions
     */
    private function applyAvailabilityFilterPostgreSQL($query)
    {
        $currentTime = Carbon::now();
        $currentDay = strtolower($currentTime->format('l'));
        $currentTimeString = $currentTime->format('H:i:s');

        return $query->whereHas('profile', function($q) use ($currentDay, $currentTimeString) {
            $q->whereNotNull('availability_schedule')
              ->where('availability_schedule', '!=', '[]')
              ->whereRaw("availability_schedule->'$.\"$currentDay\"'->>'is_available' = 'true'")
              ->whereRaw("(availability_schedule->'$.\"$currentDay\"'->>'start_time')::time <= ?::time", [$currentTimeString])
              ->whereRaw("(availability_schedule->'$.\"$currentDay\"'->>'end_time')::time >= ?::time", [$currentTimeString])
              ->where(function($query) use ($currentDay, $currentTimeString) {
                  $query->whereRaw("availability_schedule->'$.\"$currentDay\"'->>'break_time' IS NULL")
                        ->orWhereRaw("availability_schedule->'$.\"$currentDay\"'->>'break_time' = ''")
                        ->orWhere(function($subQuery) use ($currentDay, $currentTimeString) {
                            $subQuery->whereRaw("?::time NOT BETWEEN (availability_schedule->'$.\"$currentDay\"'->>'break_start')::time AND (availability_schedule->'$.\"$currentDay\"'->>'break_end')::time", [$currentTimeString]);
                        });
              });
        });
    }

    /**
     * Check if a specific doctor is currently available
     * Useful for displaying real-time availability status
     */
    public function checkDoctorAvailability($profile)
    {
        if (!$profile->availability_schedule || empty($profile->availability_schedule)) {
            return false;
        }

        $currentTime = Carbon::now();
        $currentDay = strtolower($currentTime->format('l'));
        $currentTimeString = $currentTime->format('H:i:s');

        $schedule = $profile->availability_schedule;

        // Check if doctor is available on this day
        if (!isset($schedule[$currentDay]) || 
            !($schedule[$currentDay]['is_available'] ?? false)) {
            return false;
        }

        $daySchedule = $schedule[$currentDay];
        
        // Check if current time is within working hours
        $startTime = $daySchedule['start_time'] ?? null;
        $endTime = $daySchedule['end_time'] ?? null;
        
        if (!$startTime || !$endTime) {
            return false;
        }

        $isWithinWorkingHours = $currentTimeString >= $startTime && $currentTimeString <= $endTime;
        
        if (!$isWithinWorkingHours) {
            return false;
        }

        // Check if current time is within break time
        $hasBreak = !empty($daySchedule['break_time'] ?? '');
        if ($hasBreak) {
            $breakStart = $daySchedule['break_start'] ?? null;
            $breakEnd = $daySchedule['break_end'] ?? null;
            
            if ($breakStart && $breakEnd) {
                $isOnBreak = $currentTimeString >= $breakStart && $currentTimeString <= $breakEnd;
                if ($isOnBreak) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get availability status for multiple doctors
     */
    public function getDoctorsAvailabilityStatus($doctors)
    {
        $statuses = [];
        foreach ($doctors as $doctor) {
            if ($doctor->profile) {
                $statuses[$doctor->id] = $this->checkDoctorAvailability($doctor->profile);
            }
        }
        return $statuses;
    }

    private function mapConsultationTypeToMode($type)
    {
        $map = [
            'voice' => 'voice_call',
            'video' => 'video_call',
            'chat' => 'chat',
            'home_visit' => 'home_visit'
        ];
        
        return $map[$type] ?? null;
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
            'voice' => 'Audio Call',
            'video' => 'Video Call',
            'chat' => 'Chat',
            'home_visit' => 'Home Visit'
        ];
    }

    private function getSpecialityCounts()
    {
        $counts = [];
        $specialities = $this->getUniqueSpecialities();
        
        foreach ($specialities as $speciality) {
            $count = User::where('role', 'doctor')
                ->whereHas('profile', function($q) use ($speciality) {
                    $q->where('speciality', $speciality)
                      ->orWhere('primary_speciality', $speciality)
                      ->orWhereJsonContains('secondary_specialities', $speciality);
                })->count();
            
            if ($count > 0) {
                $counts[$speciality] = $count;
            }
        }
        
        return $counts;
    }

    private function getGenderCounts()
    {
        return [
            'male' => User::where('role', 'doctor')
                ->whereHas('profile', function($q) {
                    $q->where('sex', 'male');
                })->count(),
            'female' => User::where('role', 'doctor')
                ->whereHas('profile', function($q) {
                    $q->where('sex', 'female');
                })->count()
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
