<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect patient to Google
     */
    public function redirectToGooglePatient()
    {
        // Store the role in session before redirecting
        session(['google_login_role' => 'patient']);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect doctor to Google
     */
    public function redirectToGoogleDoctor()
    {
        // Store the role in session before redirecting
        session(['google_login_role' => 'doctor']);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback for patient
     */
    public function handleGoogleCallbackPatient()
    {
        return $this->handleGoogleCallback('patient');
    }

    /**
     * Handle callback for doctor
     */
    public function handleGoogleCallbackDoctor()
    {
        return $this->handleGoogleCallback('doctor');
    }

    /**
     * Shared callback handler
     */
    private function handleGoogleCallback($expectedRole)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                // Create new user with the role from the URL
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                    'role' => $expectedRole, // Use the role from the URL
                ]);
            } else {
                // User exists - check if role matches
                if ($user->role !== $expectedRole) {
                    // User exists but with different role
                    return redirect('/login')
                        ->with('error', "This email is already registered as a {$user->role}. Please login with the correct account type.");
                }
            }
            
            // Log the user in
            Auth::login($user);
            
            // Redirect to appropriate dashboard based on role
            if ($user->role === 'doctor') {
                return redirect()->intended('/doctor/dashboard');
            } else {
                return redirect()->intended('/patient/dashboard');
            }
            
        } catch (\Exception $e) {
            \Log::error('Google login failed: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }
}