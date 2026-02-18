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
        });

        $doctor = null;
        $messages = collect();
        $booking = null;

        if ($bookingId) {
            $booking = Booking::with('doctor')->findOrFail($bookingId);
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
        });

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

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'booking_id' => $request->booking_id,
            'is_read' => false, // New message starts as unread
            'read_at' => null
        ]);

        // Load relationships for the response
        $message->load(['sender', 'receiver', 'booking']);

        // If you want to keep broadcasting, keep this line
        // broadcast(new MessageSent($message))->toOthers();

        // For AJAX requests, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'unread_count' => $this->getUnreadCountForBooking($request->booking_id)
            ]);
        }

        // For regular form submissions
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
        $lastMessageId = $request->last_message_id ?? 0;
        $userId = Auth::id();

        // Get messages newer than last_message_id
        $messages = Message::where('booking_id', $bookingId)
            ->where('id', '>', $lastMessageId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Don't mark as read here - that happens when user views them

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

    // API endpoint to mark single message as read
    public function markMessageAsRead(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);
        
        // Only the receiver can mark as read
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

        // Get all booking IDs where user has messages
        $bookingIds = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->distinct()
            ->pluck('booking_id');

        $unreadCounts = [];
        $totalUnread = 0;

        foreach ($bookingIds as $bookingId) {
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

    // Helper method to get unread count for a specific booking
    private function getUnreadCountForBooking($bookingId)
    {
        if (!$bookingId) return 0;

        return Message::where('booking_id', $bookingId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    // Optional: Get messages with read status for a booking
    public function getMessagesWithStatus($bookingId)
    {
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
}