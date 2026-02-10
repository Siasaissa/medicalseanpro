<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Events\CallSignal;

class CallController extends Controller
{
    // Video call page
    public function video($bookingId)
    {
        $booking = Booking::with('doctor', 'patient')->findOrFail($bookingId);
        return view('patient.video', compact('booking'));
    }

        public function videoDoctor($bookingId)
    {
        $booking = Booking::with('doctor', 'patient')->findOrFail($bookingId);
        return view('doctor.video', compact('booking'));
    }

    // Voice call page
    public function voice($bookingId)
    {
        $booking = Booking::with('doctor', 'patient')->findOrFail($bookingId);
        return view('patient.voice', compact('booking'));
    }

    public function voiceDoctor($bookingId)
    {
        $booking = Booking::with('doctor', 'patient')->findOrFail($bookingId);
        return view('doctor.voice', compact('booking'));
    }

    public function signal(Request $request, $bookingId)
    {
        // Broadcast the signaling data to the other user
        broadcast(new CallSignal($bookingId, $request->all()))->toOthers();

        return response()->json(['status' => 'Signal sent']);
    }
}
