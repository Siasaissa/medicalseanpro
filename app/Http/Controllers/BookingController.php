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
use Illuminate\Support\Facades\Mail;
use App\Mail\DoctorBookingNotification;
use function Pest\Laravel\json;

class BookingController extends Controller
{
    private function normalizePaymentStatus(?string $status): string
    {
        $value = strtoupper(trim((string) $status));

        return match ($value) {
            'SUCCESS', 'SUCCEEDED', 'COMPLETED', 'PAID' => 'SUCCESS',
            'FAILED', 'FAIL', 'ERROR', 'DECLINED', 'CANCELLED' => 'FAILED',
            'PROCESSING', 'PENDING', 'INITIATED', 'IN_PROGRESS' => 'PROCESSING',
            default => 'PROCESSING',
        };
    }

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
        throw new \RuntimeException('Failed to generate ClickPesa token: ' . $response->body());
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
            $orderReference = 'SEAN' . time() . $validated['user_id'];


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
                    'status' => 'FAILED',
                    'message' => $e->getMessage()
                ];
            }

            $paymentStatus = $this->normalizePaymentStatus($paymentResponse['status'] ?? null);
            $paymentMessage = $paymentResponse['message'] ?? null;

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
                'status' => $paymentStatus,
                'payment_reference' => $orderReference,
                'payment_response' => json_encode($paymentResponse),
            ]);

            // Notify doctor with a direct link to this booking.
            if ($paymentStatus !== 'FAILED' && !empty($booking->doctor?->email)) {
                try {
                    $booking->loadMissing(['doctor', 'patient']);
                    $actionUrl = route('doctor.appointment.booking', ['booking' => $booking->id]);
                    Mail::to($booking->doctor->email)->send(new DoctorBookingNotification($booking, $actionUrl));
                } catch (\Exception $mailException) {
                    Log::warning('Doctor booking notification email failed', [
                        'booking_id' => $booking->id,
                        'doctor_id' => $booking->doctor_id,
                        'error' => $mailException->getMessage(),
                    ]);
                }
            }

            if ($paymentStatus === 'FAILED') {
                return response()->json([
                    'success' => false,
                    'message' => $paymentMessage ?: 'Payment failed. Please top up and try again.',
                    'booking_id' => $booking->id,
                    'payment_status' => $paymentStatus
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => $paymentStatus === 'SUCCESS'
                    ? 'Payment completed successfully.'
                    : 'Booking created successfully. Please check your phone for payment prompt.',
                'booking_id' => $booking->id,
                'payment_status' => $paymentStatus,
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

    public function verification($payment_reference)
{
    $orderReference = $payment_reference;
    
    $token = $this->getClickPesaToken();
    
    // Method 2: Using double quotes for interpolation
    $response = Http::withToken($token)
                ->timeout(30)
                ->get(
                    "https://api.clickpesa.com/third-parties/payments/{$orderReference}"
                );
    
    $paymentData = [];
    $normalizedStatus = 'PROCESSING';

    // Check if the request was successful
    if ($response->successful()) {
        $data = $response->json();
        
        $paymentData = is_array($data) && isset($data[0]) ? $data[0] : $data;
        $normalizedStatus = $this->normalizePaymentStatus($paymentData['status'] ?? null);

        // Update your table - adjust field names based on your database
        DB::table('bookings')
            ->where('payment_reference', $payment_reference)
            ->update([
                'status' => $normalizedStatus,
                'transaction_id' => $paymentData['id'] ?? null,
                'payment_gateway' => $paymentData['channel'] ?? null,
                'payment_response' => json_encode($paymentData ?? []),
            ]);
        
    }
    
    if ($normalizedStatus === 'SUCCESS') {
        return redirect()->route('patient.appointment')->with([
            'success' => 'Payment verified successfully!',
            'payment_data' => $paymentData
        ]);
    }

    if ($normalizedStatus === 'FAILED') {
        return redirect()->route('patient.appointment')->with([
            'error' => $paymentData['message'] ?? 'Payment failed. Please try again.',
            'payment_data' => $paymentData
        ]);
    }

    return redirect()->route('patient.appointment')->with([
        'warning' => 'Payment is still processing. Please check again shortly.',
        'payment_data' => $paymentData
    ]);

}


    public function doctorBookings()
    {
        $bookings = Booking::where('doctor_id', Auth::id())->with('patient')
                            ->orderBy('appointment_datetime', 'desc')
                            ->get();

        $counts = Booking::where('doctor_id', Auth::id())
                            ->whereRaw("DATE_ADD(appointment_datetime, INTERVAL service_time MINUTE) > ?", [Carbon::now()])
                            ->count();

            
        $completed = Booking::where('appointment_datetime', '<', Carbon::now())
                            ->where('doctor_id', Auth::id())->with('patient')
                            ->count();
        return view('doctor.appointment', compact('bookings','counts', 'completed'));
    }

    public function patientBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())->with('doctor')
                            ->orderBy('appointment_datetime', 'desc')
                            ->get();

        $counts = Booking::where('user_id', Auth::id())->with('doctor')
                            ->where('user_id', Auth::id())->with('doctor')
                            ->where('appointment_datetime', '>', Carbon::now())
                            ->count();

        $completed = Booking::where('appointment_datetime', '<', Carbon::now())
                            ->where('user_id', Auth::id())->with('doctor')
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

public function clickpesaWebhook(Request $request)
{
    Log::info('ClickPesa Webhook Received', $request->all());

    try {

        $orderReference = $request->input('orderReference');
        $status = $request->input('status');
        $transactionId = $request->input('transactionId');
        $amount = $request->input('amount');

        if (!$orderReference) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        $booking = Booking::where('payment_reference', $orderReference)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Prevent duplicate processing
        if ($this->normalizePaymentStatus($booking->status) === 'SUCCESS') {
            return response()->json(['message' => 'Already processed'], 200);
        }

        // Verify amount
        if ((float)$booking->total !== (float)$amount) {
            return response()->json(['message' => 'Amount mismatch'], 400);
        }

        if ($this->normalizePaymentStatus($status) === 'SUCCESS') {

            $booking->update([
                'status' => 'SUCCESS',
                'transaction_id' => $transactionId,
                'payment_response' => json_encode($request->all()),
            ]);

        } else {

            $booking->update([
                'status' => 'FAILED',
                'payment_response' => json_encode($request->all()),
            ]);
        }

        return response()->json(['message' => 'Webhook processed successfully'], 200);

    } catch (\Exception $e) {

        Log::error('Webhook error', [
            'error' => $e->getMessage()
        ]);

        return response()->json(['message' => 'Server error'], 500);
    }
}

public function doctorBookingRedirect(Booking $booking)
{
    if ($booking->doctor_id !== Auth::id()) {
        abort(403, 'Unauthorized booking access.');
    }

    return redirect()->route('doctor.appointment', ['focus_booking' => $booking->id]);
}



}
