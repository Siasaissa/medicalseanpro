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

    // Only update fields that exist in the request
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

    // Handle image upload separately
    if ($request->hasFile('dp')) {
        $file = $request->file('dp');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/profile'), $filename);
        $profile->dp = 'uploads/profile/' . $filename;
    }

    $profile->user_id = Auth::id();
    $profile->save();

    return back()->with('success', 'Profile updated successfully.');
}

   public function updateProfile(Request $request)
{
    $user = auth()->user();
    $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

    $baseRules = [
        'sex' => 'nullable|string',
        'dob' => 'nullable|date',
        'blood_group' => 'nullable|string',
        'address' => 'nullable|string',
        'dp' => 'nullable|string', // or file if image upload
    ];

    $doctorRules = [
        'speciality' => 'nullable|string|max:255',
        'service' => 'nullable|string|max:255',
        'about_service' => 'nullable|string|max:1000',
    ];

    // Apply different validation rules based on role
    if ($user->role === 'doctor') {
        $rules = array_merge($baseRules, $doctorRules);
    } else {
        $rules = $baseRules;
    }

    $validated = $request->validate($rules);

    $profile->fill($validated)->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}

public function ProSetting(){
    return view('doctor.profilesettings');
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


}
