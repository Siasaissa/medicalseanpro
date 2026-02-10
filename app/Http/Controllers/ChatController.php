<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    // Show chat page (Patient side)
    public function index(Request $request)
    {


        $bookingId = $request->query('booking');

        // Sidebar: group chats by booking_id
        $patients = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['sender', 'receiver', 'booking.doctor'])
            ->get()
            ->groupBy('booking_id');

        $doctor = null;
        $messages = collect();
        $booking = null;

        if ($bookingId) {
            $booking = Booking::with('doctor')->findOrFail($bookingId);
            $doctor = $booking->doctor;

            $messages = Message::where('booking_id', $bookingId)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        //dd($bookingId, $messages->pluck('id'));
        return view('patient.chat', compact('doctor', 'messages', 'booking', 'patients'));
    }


    // Show chat page (Doctor side)
    public function indexDoctor(Request $request)
{
    $bookingId = $request->query('booking');

    // Fetch all conversations for the logged-in doctor grouped by booking
    $patients = Message::where('sender_id', Auth::id())
        ->orWhere('receiver_id', Auth::id())
        ->with(['sender', 'receiver', 'booking.doctor', 'booking.patient'])
        ->get()
        ->groupBy('booking_id');

    $doctor = Auth::user();
    $patient = null;
    $messages = collect();
    $booking = null;

    if ($bookingId) {
        $booking = Booking::with(['doctor', 'patient'])->findOrFail($bookingId);
        $patient = $booking->patient;

        // Ensure logged-in doctor owns this booking
        if ($booking->doctor->id !== Auth::id()) {
            abort(403, 'Unauthorized access to this chat.');
        }

        // Messages with this patient
        $messages = Message::where('booking_id', $bookingId)
            ->with('sender', 'receiver')
            ->orderBy('created_at', 'asc')
            ->get();
    }
    //dd($bookingId, $messages->pluck('id'));
    return view('doctor.chat', compact('doctor', 'patient', 'messages', 'booking', 'patients'));
}


    // Store new message
   public function store(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'required|string',
        'booking_id' => 'nullable|exists:bookings,id',
    ]);

    $message = Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message,
        'booking_id' => $request->booking_id,
    ]);

    broadcast(new MessageSent($message))->toOthers();

    return back();
}



}
