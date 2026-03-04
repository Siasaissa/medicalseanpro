<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGooglePatient()
    {
        session(['google_role' => 'patient']);
        $redirectUrl = config('services.google.redirect') . '/patient';
        return Socialite::driver('google')
            ->redirectUrl($redirectUrl)
            ->redirect();
    }

    public function redirectToGoogleDoctor()
    {
        session(['google_role' => 'doctor']);
        $redirectUrl = config('services.google.redirect') . '/doctor';
        return Socialite::driver('google')
            ->redirectUrl($redirectUrl)
            ->redirect();
    }

    public function handleGoogleCallbackPatient()
    {
        return $this->handleCallback('patient');
    }

    public function handleGoogleCallbackDoctor()
    {
        return $this->handleCallback('doctor');
    }

    private function handleCallback($role)
    {
        try {
            $redirectUrl = config('services.google.redirect') . '/' . $role;
            $googleUser = Socialite::driver('google')
                ->redirectUrl($redirectUrl)
                ->user();
            
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,

                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                    'role' => $role,
                ]);
                $user->profile()->create([
                    'dp' => 'profiles/' . $avatarName,
                ]);
            } elseif ($user->role !== $role) {
                return redirect('/login')->with('error', "This email is registered as a {$user->role}.");
            }
            
            Auth::login($user);
            
            $dashboard = $role === 'doctor' ? '/doctor-dashboard' : '/dashboard';
            return redirect()->intended($dashboard);
            
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login failed: ' . $e->getMessage());
        }
    }
}