<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            Paginator::useBootstrap();
            $profile = null;
            $age = null;
            $doctorData = [
                'speciality' => null,
                'service' => null,
                'about_service' => null,
                'dp' => null,
                'availability' => null, // ✅ added
            ];

            if (Auth::check()) {
                $profile = Auth::user()->profile;

                // ✅ Calculate age if DOB exists
                if ($profile && $profile->dob) {
                    try {
                        $dob = Carbon::createFromFormat('d/m/Y', $profile->dob);
                    } catch (\Exception $e) {
                        try {
                            $dob = Carbon::parse($profile->dob);
                        } catch (\Exception $e) {
                            $dob = null;
                        }
                    }

                    if ($dob) {
                        $years = $dob->diffInYears(now());
                        $months = $dob->copy()->addYears($years)->diffInMonths(now());
                        $age = "{$years} years {$months} months";
                    }
                }

                //  If user is a doctor, extract additional data
                if (Auth::user()->role === 'doctor' && $profile) {
                    $doctorData['speciality'] = $profile->speciality;
                    $doctorData['service'] = $profile->service;
                    $doctorData['about_service'] = $profile->about_service;
                    $doctorData['sex'] = $profile->sex;
                    $doctorData['dp'] = $profile->dp;
                    $doctorData['availability'] = $profile->availability ?? 'not_available'; // ✅ added
                }
            }

            // Share to all views
            $view->with([
                'sex' => $profile,
                'profile' => $profile,
                'age' => $age,
                'doctor_speciality' => $doctorData['speciality'],
                'doctor_service' => $doctorData['service'],
                'doctor_about_service' => $doctorData['about_service'],
                'doctor_dp' => $doctorData['dp'],
                'availability' => $doctorData['availability'], // ✅ shared globally
            ]);
        });
    }
}
