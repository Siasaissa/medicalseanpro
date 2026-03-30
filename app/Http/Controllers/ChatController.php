<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    // Show chat page (Patient side)
    public function index(Request $request)
    {
        $bookingId = $request->query('booking');
        $userId = Auth::id();

        // Sidebar: group chats by booking_id with unread counts
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver', 'booking.doctor'])
            ->get();
        
        // Group messages by booking_id and add unread counts
        $patients = $messages->groupBy('booking_id')->map(function ($chatMessages) use ($userId) {
            $booking = $chatMessages->first()->booking;
            $lastMessage = $chatMessages->last();
            
            // Calculate unread count for this booking
            $unreadCount = $chatMessages
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();
            
            return (object) [
                'booking' => $booking,
                'messages' => $chatMessages,
                'last_message' => $lastMessage,
                'unread_count' => $unreadCount
            ];
        })->filter(function ($chatData) {
            return $chatData->booking && $chatData->booking->isSessionActive();
        });

        $doctor = null;
        $messages = collect();
        $booking = null;

        if ($bookingId) {
            $booking = $this->getAuthorizedBooking((int) $bookingId);
            if (!$booking->isSessionActive()) {
                return redirect()
                    ->route('patient.appointment')
                    ->with('error', 'This chat session has ended. Please create a new booking to continue.');
            }

            $booking->loadMissing('doctor');
            $doctor = $booking->doctor;

            // Get messages for this booking
            $messages = Message::where('booking_id', $bookingId)
                ->orderBy('created_at', 'asc')
                ->get();
            
            // Mark messages as read when user opens the chat
            Message::where('booking_id', $bookingId)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);
        }

        return view('patient.chat', compact('doctor', 'messages', 'booking', 'patients'));
    }

    // Show chat page (Doctor side)
    public function indexDoctor(Request $request)
    {
        $bookingId = $request->query('booking');
        $userId = Auth::id();

        // Fetch all conversations for the logged-in doctor grouped by booking
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver', 'booking.doctor', 'booking.patient'])
            ->get();
        
        // Group messages by booking_id and add unread counts
        $patients = $messages->groupBy('booking_id')->map(function ($chatMessages) use ($userId) {
            $booking = $chatMessages->first()->booking;
            $lastMessage = $chatMessages->last();
            
            // Calculate unread count for this booking
            $unreadCount = $chatMessages
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();
            
            return (object) [
                'booking' => $booking,
                'messages' => $chatMessages,
                'last_message' => $lastMessage,
                'unread_count' => $unreadCount
            ];
        })->filter(function ($chatData) {
            return $chatData->booking && $chatData->booking->isSessionActive();
        });

        $doctor = Auth::user();
        $patient = null;
        $messages = collect();
        $booking = null;

        if ($bookingId) {
            $booking = $this->getAuthorizedBooking((int) $bookingId);
            if (!$booking->isSessionActive()) {
                return redirect()
                    ->route('doctor.appointment')
                    ->with('error', 'This chat session has ended. Please create a new booking to continue.');
            }

            $booking->loadMissing(['doctor', 'patient']);
            $patient = $booking->patient;

            // Get messages with this patient
            $messages = Message::where('booking_id', $bookingId)
                ->with('sender', 'receiver')
                ->orderBy('created_at', 'asc')
                ->get();
            
            // Mark messages as read when doctor opens the chat
            Message::where('booking_id', $bookingId)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);
        }

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

        if (!$request->filled('booking_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Booking is required for chat.'
            ], 422);
        }

        $booking = $this->getAuthorizedBooking((int) $request->booking_id);
        if (!$booking->isSessionActive()) {
            return $this->expiredSessionJson();
        }

        $expectedReceiverId = (Auth::id() === (int) $booking->doctor_id)
            ? (int) $booking->user_id
            : (int) $booking->doctor_id;

        if ((int) $request->receiver_id !== $expectedReceiverId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid receiver for this booking chat.'
            ], 422);
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'booking_id' => $request->booking_id,
            'is_read' => false,
            'read_at' => null
        ]);

        // Load relationships for the response
        $message->load(['sender', 'receiver', 'booking']);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'unread_count' => $this->getUnreadCountForBooking($request->booking_id)
            ]);
        }

        return back()->with('success', 'Message sent successfully');
    }

    // API endpoint to get new messages (for polling)
    public function getNewMessages(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'last_message_id' => 'nullable|integer'
        ]);

        $bookingId = $request->booking_id;
        $booking = $this->getAuthorizedBooking((int) $bookingId);
        if (!$booking->isSessionActive()) {
            return $this->expiredSessionJson();
        }

        $lastMessageId = $request->last_message_id ?? 0;

        $messages = Message::where('booking_id', $bookingId)
            ->where('id', '>', $lastMessageId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'has_more' => $messages->isNotEmpty()
        ]);
    }

    // API endpoint to mark messages as read
    public function markAsRead(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id'
        ]);

        $userId = Auth::id();
        $bookingId = $request->booking_id;
        $booking = $this->getAuthorizedBooking((int) $bookingId);
        if (!$booking->isSessionActive()) {
            return $this->expiredSessionJson();
        }

        $updated = Message::where('booking_id', $bookingId)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'marked_read' => $updated,
            'remaining_unread' => $this->getUnreadCountForBooking($bookingId)
        ]);
    }

    // NEW: API endpoint to mark all messages in a booking as read
    public function markBookingAsRead(Request $request, $bookingId)
    {
        $userId = Auth::id();
        $booking = $this->getAuthorizedBooking((int) $bookingId);
        if (!$booking->isSessionActive()) {
            return $this->expiredSessionJson();
        }

        $updated = Message::where('booking_id', $bookingId)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'marked_read' => $updated,
            'booking_id' => $bookingId
        ]);
    }

    // API endpoint to mark single message as read
    public function markMessageAsRead(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);
        if (!$message->booking_id) {
            return response()->json([
                'success' => false,
                'message' => 'Message is not linked to a booking.'
            ], 422);
        }

        $booking = $this->getAuthorizedBooking((int) $message->booking_id);
        if (!$booking->isSessionActive()) {
            return $this->expiredSessionJson();
        }
        
        if ($message->receiver_id == Auth::id() && !$message->is_read) {
            $message->update([
                'is_read' => true,
                'read_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message marked as read'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized or already read'
        ], 403);
    }

    // API endpoint to get unread counts for all chats
    public function getUnreadCounts(Request $request)
    {
        $userId = Auth::id();

        $bookingIds = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->distinct()
            ->pluck('booking_id');

        $unreadCounts = [];
        $totalUnread = 0;

        foreach ($bookingIds as $bookingId) {
            if (!$bookingId) continue;

            $booking = Booking::find($bookingId);
            if (!$booking || !$this->isBookingParticipant($booking, $userId) || !$booking->isSessionActive()) {
                continue;
            }
            
            $count = Message::where('booking_id', $bookingId)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();
            
            if ($count > 0) {
                $unreadCounts[$bookingId] = $count;
                $totalUnread += $count;
            }
        }

        return response()->json([
            'success' => true,
            'unread_counts' => $unreadCounts,
            'total_unread' => $totalUnread
        ]);
    }

    // Global browser notifications for new messages (for any page)
    public function getMessageNotifications(Request $request)
    {
        $userId = Auth::id();
        $lastId = (int) $request->query('last_id', 0);

        $query = Message::where('receiver_id', $userId)
            ->where('is_read', false)
            ->with(['sender:id,name', 'booking:id,user_id,doctor_id']);

        // On first run, avoid flooding the user with old notifications.
        if ($lastId > 0) {
            $query->where('id', '>', $lastId);
        } else {
            $query->where('created_at', '>=', now()->subMinutes(10));
        }

        $messages = $query
            ->orderBy('id', 'asc')
            ->limit(20)
            ->get()
            ->filter(function ($message) {
                return $message->booking && $message->booking->isSessionActive();
            })
            ->map(function ($message) use ($userId) {
                $isDoctor = $message->booking && (int) $message->booking->doctor_id === (int) $userId;
                $chatUrl = $message->booking_id
                    ? ($isDoctor
                        ? route('doctor.chat', ['booking' => $message->booking_id])
                        : route('chat.index', ['booking' => $message->booking_id]))
                    : null;

                return [
                    'id' => $message->id,
                    'booking_id' => $message->booking_id,
                    'sender_name' => $message->sender->name ?? 'New Message',
                    'message' => mb_strimwidth((string) $message->message, 0, 120, '...'),
                    'url' => $chatUrl,
                    'created_at' => optional($message->created_at)->toDateTimeString(),
                ];
            });

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'last_id' => $messages->max('id') ?? $lastId,
        ]);
    }

    // Helper method to get unread count for a specific booking
    private function getUnreadCountForBooking($bookingId)
    {
        if (!$bookingId) return 0;

        return Message::where('booking_id', $bookingId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    // Get messages with read status for a booking
    public function getMessagesWithStatus($bookingId)
    {
        $booking = $this->getAuthorizedBooking((int) $bookingId);
        if (!$booking->isSessionActive()) {
            return $this->expiredSessionJson();
        }

        $messages = Message::where('booking_id', $bookingId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'is_read' => $message->is_read,
                    'read_at' => $message->read_at ? $message->read_at->format('Y-m-d H:i:s') : null,
                    'created_at' => $message->created_at->format('Y-m-d H:i:s'),
                    'sender_name' => $message->sender->name,
                    'sender_image' => $message->sender->profile_image
                ];
            });

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    private function getAuthorizedBooking(int $bookingId): Booking
    {
        $booking = Booking::findOrFail($bookingId);
        if (!$this->isBookingParticipant($booking, Auth::id())) {
            abort(403, 'Unauthorized booking access.');
        }

        return $booking;
    }

    private function isBookingParticipant(Booking $booking, int $userId): bool
    {
        return $userId === (int) $booking->user_id || $userId === (int) $booking->doctor_id;
    }

    private function expiredSessionJson(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Consultation time has ended for this booking. Create a new booking to continue.',
            'session_expired' => true,
        ], 403);
    }
}
