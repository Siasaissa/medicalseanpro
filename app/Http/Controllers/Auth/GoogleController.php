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
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                // Create new user WITH THE ROLE FIELD
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)), // Random password
                    'email_verified_at' => now(), // Google emails are already verified
                    'role' => 'patient', // ADD THIS LINE - match your registration controller
                ]);
            }
            
            // Log the user in
            Auth::login($user);
            
            // Redirect to dashboard or home
            return redirect()->intended('/dashboard');
            
        } catch (\Exception $e) {
            // Log the error to see what's happening
            \Log::error('Google login failed: ' . $e->getMessage());
            
            // Handle error
            return redirect('/login')->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }
}