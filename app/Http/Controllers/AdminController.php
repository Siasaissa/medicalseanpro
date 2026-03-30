<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Booking;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $doctor = User::where('role', 'doctor')->count();
        $patient = User::where('role', 'patient')->count();
        $booking = Booking::count();
        $revenue = Booking::sum('total');

        $recentBookings = Booking::with(['doctor:id,name', 'patient:id,name'])
            ->latest()
            ->limit(8)
            ->get();

        $recentTransactions = Order::with('user:id,name')
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'doctor',
            'patient',
            'booking',
            'revenue',
            'recentBookings',
            'recentTransactions'
        ));
    }

    public function appointment(Request $request)
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'status' => trim((string) $request->query('status', '')),
            'type' => trim((string) $request->query('type', '')),
            'from' => trim((string) $request->query('from', '')),
            'to' => trim((string) $request->query('to', '')),
        ];

        $query = Booking::with(['doctor.profile', 'patient.profile']);

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $query->where(function ($sub) use ($q) {
                $sub->where('id', $q)
                    ->orWhereHas('doctor', function ($doctorQ) use ($q) {
                        $doctorQ->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    })
                    ->orWhereHas('patient', function ($patientQ) use ($q) {
                        $patientQ->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
            });
        }

        if ($filters['status'] !== '') {
            $query->where('status', strtoupper($filters['status']));
        }

        if ($filters['type'] !== '') {
            $query->where('appointment_type', strtolower($filters['type']));
        }

        if ($filters['from'] !== '') {
            $query->whereDate('appointment_datetime', '>=', $filters['from']);
        }

        if ($filters['to'] !== '') {
            $query->whereDate('appointment_datetime', '<=', $filters['to']);
        }

        $appointment = $query->orderByDesc('appointment_datetime')->paginate(25)->withQueryString();

        $bookingStatusOptions = [
            'PENDING',
            'PROCESSING',
            'SUCCESS',
            'FAILED',
            'PAID',
            'ACTIVE',
            'COMPLETED',
            'CANCELLED',
        ];

        return view('admin.appointment', compact('appointment', 'filters', 'bookingStatusOptions'));
    }

    public function doctorList(Request $request)
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'status' => trim((string) $request->query('status', '')),
        ];

        $query = User::where('role', 'doctor')
            ->with(['profile', 'doctorBookings']);

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('id', $q)
                    ->orWhereHas('profile', function ($profileQ) use ($q) {
                        $profileQ->where('speciality', 'like', "%{$q}%")
                            ->orWhere('phone_numbers', 'like', "%{$q}%");
                    });
            });
        }

        if ($filters['status'] !== '') {
            $query->whereHas('profile', function ($profileQ) use ($filters) {
                $profileQ->where('status', strtolower($filters['status']));
            });
        }

        $doctors = $query->latest()->paginate(20)->withQueryString();
        $statusOptions = ['active', 'inactive', 'suspended'];

        return view('admin.doctorList', compact('doctors', 'filters', 'statusOptions'));
    }

    public function patientList(Request $request)
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'status' => trim((string) $request->query('status', '')),
        ];

        $query = User::where('role', 'patient')
            ->with(['profile', 'patientBookings']);

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('id', $q)
                    ->orWhereHas('profile', function ($profileQ) use ($q) {
                        $profileQ->where('phone_numbers', 'like', "%{$q}%")
                            ->orWhere('address', 'like', "%{$q}%");
                    });
            });
        }

        if ($filters['status'] !== '') {
            $query->whereHas('profile', function ($profileQ) use ($filters) {
                $profileQ->where('status', strtolower($filters['status']));
            });
        }

        $patients = $query->latest()->paginate(20)->withQueryString();
        $statusOptions = ['active', 'inactive', 'suspended'];

        return view('admin.patientList', compact('patients', 'filters', 'statusOptions'));
    }

    public function transaction(Request $request)
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'source' => trim((string) $request->query('source', 'all')),
            'pharmacy_status' => trim((string) $request->query('pharmacy_status', '')),
            'booking_status' => trim((string) $request->query('booking_status', '')),
        ];

        $pharmacyQuery = Order::with(['user.profile']);
        $bookingQuery = Booking::with(['patient.profile', 'doctor.profile']);

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $pharmacyQuery->where(function ($sub) use ($q) {
                $sub->where('id', $q)
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($userQ) use ($q) {
                        $userQ->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
            });

            $bookingQuery->where(function ($sub) use ($q) {
                $sub->where('id', $q)
                    ->orWhereHas('doctor', function ($doctorQ) use ($q) {
                        $doctorQ->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    })
                    ->orWhereHas('patient', function ($patientQ) use ($q) {
                        $patientQ->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
            });
        }

        if ($filters['pharmacy_status'] !== '') {
            $pharmacyQuery->where('status', strtolower($filters['pharmacy_status']));
        }

        if ($filters['booking_status'] !== '') {
            $bookingQuery->where('status', strtoupper($filters['booking_status']));
        }

        $showPharmacy = in_array($filters['source'], ['all', 'pharmacy'], true);
        $showBooking = in_array($filters['source'], ['all', 'booking'], true);

        $pharmacyTransactions = $showPharmacy
            ? $pharmacyQuery->latest()->paginate(15, ['*'], 'pharmacy_page')->withQueryString()
            : null;

        $bookingTransactions = $showBooking
            ? $bookingQuery->latest()->paginate(15, ['*'], 'booking_page')->withQueryString()
            : null;

        $totals = [
            'pharmacy' => (float) Order::sum('total'),
            'booking' => (float) Booking::sum('total'),
        ];

        $transactionStatusOptions = ['pending', 'processing', 'paid', 'failed', 'cancelled', 'refunded'];
        $bookingStatusOptions = ['PENDING', 'PROCESSING', 'SUCCESS', 'FAILED', 'PAID', 'ACTIVE', 'COMPLETED', 'CANCELLED'];

        return view('admin.Transaction', compact(
            'pharmacyTransactions',
            'bookingTransactions',
            'filters',
            'transactionStatusOptions',
            'bookingStatusOptions',
            'totals'
        ));
    }

    public function updateUserStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive,suspended',
        ]);

        if ($user->role === 'admin') {
            return back()->with('error', 'Admin accounts cannot be modified here.');
        }

        $profile = Profile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'sex' => 'Not set',
                'dob' => 'Not set',
                'blood_group' => 'Not set',
                'address' => 'Not set',
            ]
        );
        $profile->status = $validated['status'];
        $profile->save();

        return back()->with('success', "{$user->name} status updated to {$validated['status']}.");
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:PENDING,PROCESSING,SUCCESS,FAILED,PAID,ACTIVE,COMPLETED,CANCELLED',
        ]);

        $booking->status = $validated['status'];
        $booking->save();

        return back()->with('success', "Booking #APT000{$booking->id} status updated.");
    }

    public function updateTransactionStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,paid,failed,cancelled,refunded',
        ]);

        $order->status = $validated['status'];
        $order->save();

        return back()->with('success', "Order #ORD" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . " updated.");
    }

    public function destroyTransaction(Order $order)
    {
        $orderId = $order->id;
        $order->delete();

        return back()->with('success', 'Transaction #ORD' . str_pad($orderId, 4, '0', STR_PAD_LEFT) . ' deleted.');
    }
}
