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
        session(['google_role' => 'patient']);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect doctor to Google
     */
    public function redirectToGoogleDoctor()
    {
        session(['google_role' => 'doctor']);
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
     * Simple shared callback handler
     */
    private function handleGoogleCallback($role)
    {
        try {
            // Get Google user
            $googleUser = Socialite::driver('google')->user();
            
            // Find or create user
            $user = User::firstOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                    'role' => $role,
                ]
            );
            
            // Check if role matches (for existing users)
            if ($user->role !== $role) {
                return redirect('/login')->with('error', "This email is already registered as a {$user->role}.");
            }
            
            // Login
            Auth::login($user);
            
            // Redirect based on role
            $dashboard = ($role === 'doctor') ? '/doctor/dashboard' : '/patient/dashboard';
            return redirect()->intended($dashboard);
            
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login failed. Please try again.');
        }
    }
}