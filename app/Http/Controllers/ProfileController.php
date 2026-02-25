<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

public function store(Request $request)
{
    $request->validate([
        'sex' => 'nullable|string',
        'dob' => 'nullable|string',
        'blood_group' => 'nullable|string',
        'address' => 'nullable|string',
        'dp' => 'nullable|image|mimes:jpg,png,svg|max:4096',
    ]);

    $profile = Profile::firstOrNew(['user_id' => Auth::id()]);

    // Update text fields
    if ($request->filled('sex')) {
        $profile->sex = $request->sex;
    }
    if ($request->filled('dob')) {
        $profile->dob = $request->dob;
    }
    if ($request->filled('blood_group')) {
        $profile->blood_group = $request->blood_group;
    }
    if ($request->filled('address')) {
        $profile->address = $request->address;
    }

    // Handle image upload with DEBUGGING
    if ($request->hasFile('dp')) {
        $file = $request->file('dp');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Define the upload path
        $uploadPath = public_path('uploads/profile/');
        
        // DEBUG: Check if directory exists and its permissions
        $debugInfo = [
            'upload_path' => $uploadPath,
            'directory_exists' => file_exists($uploadPath),
            'is_writable' => is_writable($uploadPath),
            'original_name' => $file->getClientOriginalName(),
            'temp_path' => $file->getRealPath(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
            $debugInfo['directory_created'] = true;
        }
        
        // Try to move the file
        try {
            $file->move($uploadPath, $filename);
            
            // Check if file was actually moved
            $savedFilePath = $uploadPath . '/' . $filename;
            if (file_exists($savedFilePath)) {
                $debugInfo['file_saved'] = true;
                $debugInfo['saved_path'] = $savedFilePath;
                $debugInfo['file_permissions'] = substr(sprintf('%o', fileperms($savedFilePath)), -4);
                
                // Delete old image if it exists
                if ($profile->dp) {
                    $oldImagePath = public_path($profile->dp);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                        $debugInfo['old_deleted'] = true;
                    }
                }
                
                $profile->dp = 'public/uploads/profile/' . $filename;
            } else {
                $debugInfo['file_saved'] = false;
            }
        } catch (\Exception $e) {
            $debugInfo['error'] = $e->getMessage();
        }
        
        dd($debugInfo);
    }

    $profile->user_id = Auth::id();
    $profile->save();

    return back()->with('success', 'Profile updated successfully.');
}
  

public function ProSetting(){
    $doctor = Profile::where('user_id', Auth::id())->first();
    return view('doctor.profilesettings', compact('doctor'));
}

public function updateProfile1(Request $request)
{
    // Validation
    $validated = $request->validate([
        'sex' => 'nullable|string|max:10',
        'dob' => 'nullable|date',
        'blood_group' => 'nullable|string|max:5',
        'marital_status' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'phone_numbers' => 'nullable|string|max:20',
        'known_languages' => 'nullable|string|max:255',
        'title' => 'nullable|string|max:100',
        'hospital' => 'nullable|string|max:100',
        'year_of_experience' => 'nullable|string|max:50',
        'location' => 'nullable|string|max:100',
        'job_description' => 'nullable|string|max:1000',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'about_membership' => 'nullable|string|max:255',
        'dp' => 'nullable|image|mimes:jpg,png,svg|max:4096', // match form input name
    ]);

    // Find the logged-in doctor profile
    $doctor = Profile::where('user_id', Auth::id())->first();

    // If no profile exists, create one
    if (!$doctor) {
        $doctor = new Profile();
        $doctor->user_id = Auth::id();
    }

    // Handle profile image upload
    if ($request->hasFile('dp')) {
        // Delete old image if exists
        if ($doctor->dp && file_exists(public_path($doctor->dp))) {
            unlink(public_path($doctor->dp));
        }

        $file = $request->file('dp');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/profile'), $filename);
        $doctor->dp = 'uploads/profile/' . $filename;
    }

    // Only update fields that exist in the request
    foreach ($validated as $key => $value) {
        // Skip dp here because it is handled above
        if ($key === 'dp') continue;

        if (!is_null($value)) {
            $doctor->{$key} = $value;
        }
    }

    $doctor->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}

// New method for updating speciality & services
public function updateSpeciality(Request $request)
{
    $validated = $request->validate([
        'primary_speciality' => 'nullable|string|max:255',
        'secondary_specialities' => 'nullable|string|max:500',
        'services' => 'nullable|array',
    ]);

    $doctor = Profile::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);
    
    $doctor->primary_speciality = $validated['primary_speciality'] ?? null;
    $doctor->secondary_specialities = $validated['secondary_specialities'] ?? null;
    
    if (isset($validated['services'])) {
        $doctor->services_offered = json_encode($validated['services']);
    }
    
    $doctor->save();

    return redirect()->back()->with('success', 'Speciality & Services updated successfully!');
}

// New method for updating availability
public function updateAvailability(Request $request)
{
    $validated = $request->validate([
        'working_days' => 'nullable|array',
        'start_time' => 'nullable|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i',
        'session_duration' => 'nullable|integer|min:15|max:120',
        'break_time' => 'nullable|string|max:50',
    ]);

    $doctor = Profile::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);
    
    if (isset($validated['working_days'])) {
        $doctor->working_days = json_encode($validated['working_days']);
    }
    
    $doctor->start_time = $validated['start_time'] ?? null;
    $doctor->end_time = $validated['end_time'] ?? null;
    $doctor->session_duration = $validated['session_duration'] ?? null;
    $doctor->break_time = $validated['break_time'] ?? null;
    
    $doctor->save();

    return redirect()->back()->with('success', 'Availability schedule updated successfully!');
}

// New method for updating consultation modes
public function updateConsultation(Request $request)
{
    $validated = $request->validate([
        'video_platform' => 'nullable|string|max:100',
        'voice_call_number' => 'nullable|string|max:20',
        'home_visit_radius' => 'nullable|integer|min:1|max:100',
        'chat_response_time' => 'nullable|string|max:50',
        'emergency_contact' => 'nullable|string|max:20',
    ]);

    $doctor = Profile::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);
    
    $doctor->video_platform = $validated['video_platform'] ?? null;
    $doctor->voice_call_number = $validated['voice_call_number'] ?? null;
    $doctor->home_visit_radius = $validated['home_visit_radius'] ?? null;
    $doctor->chat_response_time = $validated['chat_response_time'] ?? null;
    $doctor->emergency_contact = $validated['emergency_contact'] ?? null;
    
    $doctor->save();

    return redirect()->back()->with('success', 'Consultation settings updated successfully!');
}

// New method for updating payment & fees
public function updatePayment(Request $request)
{
    $validated = $request->validate([
        'video_fee' => 'nullable|string|max:50',
        'voice_fee' => 'nullable|string|max:50',
        'chat_fee' => 'nullable|string|max:50',
        'home_visit_fee' => 'nullable|string|max:50',
        'payment_methods' => 'nullable|string|max:500',
        'bank_account' => 'nullable|string|max:500',
    ]);

    $doctor = Profile::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);
    
    $doctor->video_fee = $validated['video_fee'] ?? null;
    $doctor->voice_fee = $validated['voice_fee'] ?? null;
    $doctor->chat_fee = $validated['chat_fee'] ?? null;
    $doctor->home_visit_fee = $validated['home_visit_fee'] ?? null;
    $doctor->payment_methods = $validated['payment_methods'] ?? null;
    $doctor->bank_account = $validated['bank_account'] ?? null;
    
    $doctor->save();

    return redirect()->back()->with('success', 'Payment & Fees updated successfully!');
}

// Enhanced method for updating experiences (handles multiple experiences)
public function updateExperiences(Request $request)
{
    $validated = $request->validate([
        'experiences' => 'nullable|array',
        'experiences.*.title' => 'nullable|string|max:100',
        'experiences.*.hospital' => 'nullable|string|max:100',
        'experiences.*.year_of_experience' => 'nullable|string|max:50',
        'experiences.*.location' => 'nullable|string|max:100',
        'experiences.*.job_description' => 'nullable|string|max:1000',
        'experiences.*.start_date' => 'nullable|date',
        'experiences.*.end_date' => 'nullable|date',
        'experiences.*.about_membership' => 'nullable|string|max:255',
    ]);

    $doctor = Profile::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);
    
    if (isset($validated['experiences'])) {
        $doctor->experiences = json_encode($validated['experiences']);
    }
    
    $doctor->save();

    return redirect()->back()->with('success', 'Experiences updated successfully!');
}

// Method for updating qualifications
public function updateQualifications(Request $request)
{
    $validated = $request->validate([
        'qualifications' => 'nullable|array',
        'qualifications.*.degree' => 'nullable|string|max:100',
        'qualifications.*.university' => 'nullable|string|max:200',
        'qualifications.*.year' => 'nullable|integer|min:1900|max:' . date('Y'),
        'qualifications.*.certificate_file' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
    ]);

    $doctor = Profile::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);
    
    if (isset($validated['qualifications'])) {
        $doctor->qualifications = json_encode($validated['qualifications']);
    }
    
    $doctor->save();

    return redirect()->back()->with('success', 'Qualifications updated successfully!');
}

public function password(){
    return view('doctor.changePassword');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    $user = Auth::user();

    // Check if the old password matches
    if (!Hash::check($request->old_password, $user->password)) {
        return back()->withErrors(['old_password' => 'The old password is incorrect.']);
    }

    // Update the password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Password updated successfully!');
}

// Helper method to get doctor profile with fallback
public function getDoctorProfile()
{
    return Profile::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);
}

}