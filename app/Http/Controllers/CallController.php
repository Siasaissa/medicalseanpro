<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\CallNotification;
use Illuminate\Support\Facades\Auth;
use App\Events\CallSignal;

class CallController extends Controller
{
    // Video call page
    public function video($bookingId)
    {
        $booking = $this->resolveActiveBookingForUser((int) $bookingId);
        return view('patient.video', compact('booking'));
    }

        public function videoDoctor($bookingId)
    {
        $booking = $this->resolveActiveBookingForUser((int) $bookingId);
        return view('doctor.video', compact('booking'));
    }

    // Voice call page
    public function voice($bookingId)
    {
        $booking = $this->resolveActiveBookingForUser((int) $bookingId);
        return view('patient.voice', compact('booking'));
    }

    public function voiceDoctor($bookingId)
    {
        $booking = $this->resolveActiveBookingForUser((int) $bookingId);
        return view('doctor.voice', compact('booking'));
    }

    // Home visit details (Patient side)
    public function home($bookingId)
    {
        $booking = Booking::with('doctor', 'patient')->findOrFail($bookingId);
        return view('patient.home', compact('booking'));
    }

    // Home visit details (Doctor side)
    public function homeDoctor($bookingId)
    {
        $booking = Booking::with('doctor', 'patient')->findOrFail($bookingId);
        return view('doctor.home', compact('booking'));
    }

    public function signal(Request $request, $bookingId)
    {
        $this->resolveActiveBookingForUser((int) $bookingId);

        // Broadcast the signaling data to the other user
        broadcast(new CallSignal($bookingId, $request->all()))->toOthers();

        return response()->json(['status' => 'Signal sent']);
    }

    // Persist a call invite notification for the other participant.
    public function invite(Request $request, $bookingId)
    {
        $request->validate([
            'type' => 'required|in:video,voice',
        ]);

        $booking = $this->resolveActiveBookingForUser((int) $bookingId);
        $senderId = Auth::id();

        if ($senderId !== (int) $booking->doctor_id && $senderId !== (int) $booking->user_id) {
            abort(403, 'Unauthorized booking access.');
        }

        $receiverId = $senderId === (int) $booking->doctor_id
            ? (int) $booking->user_id
            : (int) $booking->doctor_id;

        // Deduplicate noisy repeated invites (same sender/receiver/type in 30s window).
        $existing = CallNotification::where('booking_id', $booking->id)
            ->where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->where('type', $request->type)
            ->where('created_at', '>=', now()->subSeconds(30))
            ->first();

        if ($existing) {
            return response()->json(['success' => true, 'invite_id' => $existing->id]);
        }

        $invite = CallNotification::create([
            'booking_id' => $booking->id,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'type' => $request->type,
        ]);

        return response()->json(['success' => true, 'invite_id' => $invite->id]);
    }

    // Poll endpoint for browser call notifications.
    public function getNewInvites(Request $request)
    {
        $lastId = (int) $request->query('last_id', 0);
        $receiverId = Auth::id();

        $query = CallNotification::where('receiver_id', $receiverId)
            ->with(['sender:id,name', 'booking:id,doctor_id,user_id']);

        if ($lastId > 0) {
            $query->where('id', '>', $lastId);
        } else {
            $query->where('created_at', '>=', now()->subMinutes(10));
        }

        $invites = $query
            ->orderBy('id', 'asc')
            ->limit(20)
            ->get()
            ->filter(function ($invite) use ($receiverId) {
                return $invite->booking
                    && ((int) $invite->booking->doctor_id === (int) $receiverId || (int) $invite->booking->user_id === (int) $receiverId)
                    && $invite->booking->isSessionActive();
            })
            ->map(function ($invite) use ($receiverId) {
                $isDoctor = $invite->booking && (int) $invite->booking->doctor_id === (int) $receiverId;
                $joinUrl = '#';

                if ($invite->booking_id) {
                    if ($invite->type === 'video') {
                        $joinUrl = $isDoctor
                            ? route('doctor.video', ['booking' => $invite->booking_id])
                            : route('patient.video', ['booking' => $invite->booking_id]);
                    } else {
                        $joinUrl = $isDoctor
                            ? route('doctor.voice', ['booking' => $invite->booking_id])
                            : route('patient.voice', ['booking' => $invite->booking_id]);
                    }
                }

                return [
                    'id' => $invite->id,
                    'booking_id' => $invite->booking_id,
                    'type' => $invite->type,
                    'sender_name' => $invite->sender->name ?? 'Caller',
                    'url' => $joinUrl,
                    'created_at' => optional($invite->created_at)->toDateTimeString(),
                ];
            });

        return response()->json([
            'success' => true,
            'invites' => $invites,
            'last_id' => $invites->max('id') ?? $lastId,
        ]);
    }

    public function markInviteSeen($inviteId)
    {
        $invite = CallNotification::where('receiver_id', Auth::id())->findOrFail($inviteId);

        if (!$invite->seen_at) {
            $invite->update(['seen_at' => now()]);
        }

        return response()->json(['success' => true]);
    }

    private function resolveActiveBookingForUser(int $bookingId): Booking
    {
        $booking = Booking::with(['doctor', 'patient'])->findOrFail($bookingId);
        $userId = (int) Auth::id();

        if ($userId !== (int) $booking->doctor_id && $userId !== (int) $booking->user_id) {
            abort(403, 'Unauthorized booking access.');
        }

        if (!$booking->isSessionActive()) {
            abort(403, 'Consultation time has ended for this booking.');
        }

        return $booking;
    }
}
