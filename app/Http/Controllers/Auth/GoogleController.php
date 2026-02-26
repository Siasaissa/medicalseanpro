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
    $redirectUri = 'https://www.medicalsean.org/auth/google/callback/patient';
    
    
    return Socialite::driver('google')
        ->redirectUrl($redirectUri)
        ->redirect();
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
    dd('Callback reached!', request()->all());
    
    try {
        \Log::channel('stack')->info('========== GOOGLE LOGIN ATTEMPT START ==========');
        \Log::info('Attempting to get Google user');
        
        $googleUser = Socialite::driver('google')->user();
        
        \Log::info('Google user retrieved successfully', [
            'email' => $googleUser->email,
            'name' => $googleUser->name,
            'id' => $googleUser->id
        ]);
        
        // Check if user already exists
        \Log::info('Checking if user exists in database');
        $user = User::where('email', $googleUser->email)->first();
        
        if ($user) {
            \Log::info('Existing user found', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_email' => $user->email
            ]);
        } else {
            \Log::info('No existing user found, creating new one');
            
            try {
                $userData = [
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                    'role' => 'patient',
                ];
                
                \Log::info('Attempting to create user with data:', $userData);
                
                $user = User::create($userData);
                
                \Log::info('User created successfully', [
                    'user_id' => $user->id,
                    'user_role' => $user->role
                ]);
            } catch (\Exception $createError) {
                \Log::error('Failed to create user: ' . $createError->getMessage());
                \Log::error('SQL Error: ' . ($createError->getPrevious() ? $createError->getPrevious()->getMessage() : 'No previous error'));
                throw $createError;
            }
        }
        
        // Check if user role matches
        if ($user->role !== 'patient') {
            \Log::warning('Role mismatch', ['expected' => 'patient', 'actual' => $user->role]);
            return redirect('/login')->with('error', "This email is registered as a {$user->role}.");
        }
        
        // Log the user in
        \Log::info('Attempting to login user', ['user_id' => $user->id]);
        Auth::login($user);
        
        // Regenerate session
        session()->regenerate();
        \Log::info('Session regenerated');
        
        \Log::info('========== GOOGLE LOGIN SUCCESS ==========');
        return redirect()->intended('/dashboard');
        
    } catch (\Exception $e) {
        \Log::error('========== GOOGLE LOGIN ERROR ==========');
        \Log::error('Error message: ' . $e->getMessage());
        \Log::error('Error file: ' . $e->getFile() . ':' . $e->getLine());
        \Log::error('Error trace: ' . $e->getTraceAsString());
        
        return redirect('/login')->with('error', 'Login failed: ' . $e->getMessage());
    }
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