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

            // 🔹 Get higher resolution avatar
            $avatarUrl = str_replace('=s96-c', '=s400-c', $googleUser->avatar);

            // 🔹 Prepare upload path (same as your store method)
            $uploadPath = public_path('uploads/profile/');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $filename = time() . '_' . uniqid() . '.jpg';

            // 🔹 Download image
            $imageContents = Http::get($avatarUrl)->body();

            file_put_contents($uploadPath . $filename, $imageContents);

            // 🔹 Create user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => now(),
                'role' => $role,
            ]);

            // 🔹 Create profile
            $user->profile()->create([
                'dp' => 'public/uploads/profile/' . $filename,
            ]);
        }

        elseif ($user->role !== $role) {
            return redirect('/login')
                ->with('error', "This email is registered as a {$user->role}.");
        }

        Auth::login($user);

        $dashboard = $role === 'doctor'
            ? '/doctor-dashboard'
            : '/dashboard';

        return redirect()->intended($dashboard);

    } catch (\Exception $e) {
        return redirect('/login')
            ->with('error', 'Login failed: ' . $e->getMessage());
    }
}
}