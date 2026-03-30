<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use App\Models\Booking;
use App\Models\Order;
use App\Models\User;

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

            $adminNotifications = collect();
            $adminUnreadCount = 0;
            $adminPendingCounts = [
                'bookings' => 0,
                'orders' => 0,
                'doctors' => 0,
            ];

            if (Auth::check() && Auth::user()->role === 'admin') {
                $recentBookings = Booking::with(['patient:id,name', 'doctor:id,name'])
                    ->latest()
                    ->limit(4)
                    ->get()
                    ->map(function ($booking) {
                        return [
                            'title' => 'New Booking',
                            'message' => ($booking->patient->name ?? 'Patient') . ' booked Dr. ' . ($booking->doctor->name ?? 'Doctor'),
                            'time' => optional($booking->created_at)->diffForHumans(),
                            'ts' => optional($booking->created_at)->timestamp ?? 0,
                            'url' => route('admin.appointment', ['q' => $booking->id]),
                        ];
                    });

                $recentOrders = Order::with('user:id,name')
                    ->latest()
                    ->limit(4)
                    ->get()
                    ->map(function ($order) {
                        return [
                            'title' => 'Pharmacy Order',
                            'message' => ($order->user->name ?? 'Guest User') . ' placed order #ORD' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                            'time' => optional($order->created_at)->diffForHumans(),
                            'ts' => optional($order->created_at)->timestamp ?? 0,
                            'url' => route('admin.Transaction', ['source' => 'pharmacy', 'q' => $order->id]),
                        ];
                    });

                $adminNotifications = $recentBookings
                    ->concat($recentOrders)
                    ->sortByDesc('ts')
                    ->take(8)
                    ->values();

                $adminPendingCounts = [
                    'bookings' => Booking::whereIn('status', ['PENDING', 'PROCESSING', 'ACTIVE'])->count(),
                    'orders' => Order::whereIn('status', ['pending', 'processing'])->count(),
                    'doctors' => User::where('role', 'doctor')->whereHas('profile', function ($q) {
                        $q->whereIn('status', ['inactive', 'suspended']);
                    })->count(),
                ];

                $adminUnreadCount = $adminPendingCounts['bookings'] + $adminPendingCounts['orders'] + $adminPendingCounts['doctors'];
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
                'adminNotifications' => $adminNotifications,
                'adminUnreadCount' => $adminUnreadCount,
                'adminPendingCounts' => $adminPendingCounts,
            ]);
        });
    }
}
