<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // 1️⃣ Redirect to Google
    public function redirect($role)
    {
        session(['google_role' => $role]);

        return Socialite::driver('google')->redirect();
    }

    // 2️⃣ Handle Callback (Single Function)
    public function callback()
    {
        try {

            $googleUser = Socialite::driver('google')->user();
            $role = session('google_role');

            // Check if user exists
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {

                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                    'role' => $role,
                ]);

            } elseif ($user->role !== $role) {

                return redirect()->route('login')
                    ->with('error', "This email is registered as a {$user->role}.");
            }

            Auth::login($user);

            return redirect()->intended(
                $role === 'doctor'
                    ? route('doctor.dashboard')
                    : route('patient.dashboard')
            );

        } catch (\Exception $e) {

            return redirect()->route('login')
                ->with('error', 'Login failed. Please try again.');
        }
    }
}