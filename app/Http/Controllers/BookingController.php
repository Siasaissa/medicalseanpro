<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
        public function showToken()
    {
        return response()->json([
            'token' => $this->getClickPesaToken()
        ]);
    }
    /**
     * Generate ClickPesa access token
     */
    private function getClickPesaToken()
{
    $response = Http::withHeaders([
        'api-key'   => config('services.clickpesa.api_key'),
        'client-id' => config('services.clickpesa.client_id'),
        'Accept'    => 'application/json',
    ])->post('https://api.clickpesa.com/third-parties/generate-token');

    if (!$response->successful()) {
    return response()->json([
        'status' => $response->status(),
        'body'   => $response->body(),
        'json'   => $response->json(),
        'headers'=> $response->headers(),
    ], 500);
}


    // 👇 REMOVE "Bearer " prefix
    return str_replace('Bearer ', '', $response->json('token'));
}


    /**
     * Store booking and initiate payment
     */
   public function store(Request $request, $doctorId)
    {

        try {
            Log::info('Booking store request received', $request->all());

            /** ---------------- VALIDATION ---------------- */
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'appointment_datetime' => 'required',
                'appointment_type' => 'required|in:video,voice,chat,home',
                'service_price' => 'required|numeric|min:0',
                'service' => 'required|string',
                'service_time' => 'required|string',
                'fees' => 'required|numeric|min:0',
                'tax' => 'required|numeric|min:0',
                'discount' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'phone' => 'required|string|max:20',
                'payment_gateway' => 'required|string|max:50',
            ]);

            /** ---------------- DATE PARSING ---------------- */
            $appointmentDate = null;
            $datetimeStr = trim($validated['appointment_datetime']);

            $formats = [
                'M d, Y \a\t h:i A',
                'M d, Y h:i A',
                'F d, Y \a\t h:i A',
                'Y-m-d H:i:s',
            ];

            foreach ($formats as $format) {
                try {
                    $appointmentDate = Carbon::createFromFormat($format, $datetimeStr);
                    break;
                } catch (\Exception $e) {}
            }

            if (!$appointmentDate) {
                try {
                    $appointmentDate = Carbon::parse($datetimeStr);
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['appointment_datetime' => ['Invalid date format']]
                    ], 422);
                }
            }

            $appointmentDateFormatted = $appointmentDate->format('Y-m-d H:i:s');

            /** ---------------- PREVENT DOUBLE BOOKING ---------------- */
            $exists = Booking::where('doctor_id', $doctorId)
                ->where('appointment_datetime', $appointmentDateFormatted)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'errors' => ['appointment_datetime' => ['This time slot is already booked']]
                ], 422);
            }

            /** ---------------- PAYMENT PREP ---------------- */
            $orderReference = 'BOOK' . time() . $validated['user_id'];

            $payload = [
                'amount' => (string) $validated['total'],
                'currency' => 'TZS',
                'orderReference' => $orderReference,
                'phoneNumber' => $validated['phone'],
                'checksum' => (string) $validated['total'],
            ];

            /** ---------------- CLICKPESA PAYMENT ---------------- */
            try {
                $token = $this->getClickPesaToken();

                $response = Http::withToken($token)
                    ->timeout(30)
                    ->post(
                        'https://api.clickpesa.com/third-parties/payments/initiate-ussd-push-request',
                        $payload
                    );

                $paymentResponse = $response->json();

                if (!$response->successful()) {
                    Log::error('ClickPesa payment failed', [
                        'response' => $paymentResponse
                    ]);

                    $paymentResponse['status'] = 'FAILED';
                }

            } catch (\Exception $e) {
                Log::error('ClickPesa error', ['error' => $e->getMessage()]);

                $paymentResponse = [
                    'status' => 'ERROR',
                    'message' => $e->getMessage()
                ];
            }

            /** ---------------- SAVE BOOKING ---------------- */
            $booking = Booking::create([
                'user_id' => $validated['user_id'],
                'doctor_id' => $doctorId, // 🔒 secure
                'appointment_datetime' => $appointmentDateFormatted,
                'appointment_type' => $validated['appointment_type'],
                'service_price' => $validated['service_price'],
                'service' => $validated['service'],
                'service_time' => $validated['service_time'],
                'fees' => $validated['fees'],
                'tax' => $validated['tax'],
                'discount' => $validated['discount'],
                'total' => $validated['total'],
                'phone' => $validated['phone'],
                'payment_gateway' => $validated['payment_gateway'],
                'status' => 'pending_payment',
                'payment_reference' => $orderReference,
                'payment_response' => json_encode($paymentResponse),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully. Please check your phone for payment prompt.',
                'booking_id' => $booking->id,
                'redirect' => route('patient.doctor-grid', $doctorId)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Unexpected booking error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'errors' => ['general' => ['An unexpected error occurred']]
            ], 500);
        }
    }


    public function doctorBookings()
    {
        $bookings = Booking::where('doctor_id', Auth::id())->with('patient')
                            ->where('status', 'active')
                            ->orderBy('appointment_datetime', 'desc')
                            ->get();

       $counts = Booking::where('doctor_id', Auth::id())
    ->where('status', 'active')
    ->whereRaw("DATE_ADD(appointment_datetime, INTERVAL service_time MINUTE) > ?", [Carbon::now()])
    ->count();

            
        $completed = Booking::where('appointment_datetime', '<', Carbon::now())
                            ->where('doctor_id', Auth::id())->with('patient')
                            ->where('status', 'active')
                            ->count();
        return view('doctor.appointment', compact('bookings','counts', 'completed'));
    }

    public function patientBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())->with('doctor')
                            ->orderBy('appointment_datetime', 'desc')
                            ->where('status', 'active')
                            ->get();

        $counts = Booking::where('user_id', Auth::id())->with('doctor')
                            ->where('user_id', Auth::id())->with('doctor')
                            ->where('status', 'active')
                            ->where('appointment_datetime', '>', Carbon::now())
                            ->count();
            
        $completed = Booking::where('appointment_datetime', '<', Carbon::now())
                            ->where('user_id', Auth::id())->with('doctor')
                            ->where('status', 'active')
                            ->count();

        return view('patient.appointment', compact('bookings', 'counts','completed'));
    }

public function favourites()
{
    $favourite = Booking::select('doctor_id', DB::raw('COUNT(*) as total'),DB::raw('MAX(appointment_datetime) as last_appointment'))
        ->where('user_id', Auth::id())
        ->groupBy('doctor_id')
        ->orderByDesc('total')
        ->with('doctor') // load doctor details
        ->get();

    return view('patient.favourites', compact('favourite'));
}

public function PatientDashboard()
{

    $data1 = User::where('role', 'doctor')->count();


    $data2 = Booking::where('user_id', Auth::id())->count();


    $data3 = Booking::where('user_id', Auth::id())
                    ->where('appointment_datetime', '>', now())
                    ->count();

    return view('dashboard', compact('data1', 'data2', 'data3'));
}

public function DoctorDashboard(){
    $data1 = User::where('role', 'patient')->count();

    $data2 = Booking::where('doctor_id', Auth::id())->count();

    $data3 = Booking::where('doctor_id', Auth::id())
                    ->where('appointment_datetime','>', now())
                    ->count();

    $doctor = Auth::user();
    $availability = \App\Models\profile::where('user_id', $doctor->id)->first();

    return view('doctor-dashboard', compact('data1','data2','data3','availability'));
}




public function chat(Request $request)
{
    // Step 1: Get bookingId from URL
    $bookingId = $request->query('booking');  

    // Step 2: Get booking
    $booking = Booking::find($bookingId);

    // Step 3: Get doctor from users table (assuming doctor is User)
    $doctor = User::find($booking->doctor_id);

    // Step 4: Get doctor name
    $doctorName = $doctor ? $doctor->name : 'Unknown Doctor';

    return view('patient.chat', compact('doctorName'));
}


}
