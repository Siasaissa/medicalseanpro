@include ('layouts.head')
@vite('resources/js/app.js')
<body class="main-chat-blk">

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include ('layouts.header')
        <!-- /Header -->

        <div class="page-wrapper chat-page-wrapper">
            <div class="container">

                <div class="content doctor-content">

                    <div class="chat-sec">

                        <!-- sidebar group -->
                        <div class="sidebar-group left-sidebar chat_sidebar" id="chatSidebar">

                            <!-- Chats sidebar -->
                            <div id="chats" class="left-sidebar-wrap sidebar active slimscroll">

                                <div class="slimscroll-active-sidebar">

                                    <!-- Left Chat Title -->
                                    <div class="left-chat-title all-chats">
                                        <div class="setting-title-head">
                                            <h4>All Chats</h4>
                                            <span class="total-unread-badge" id="totalUnreadBadge" style="display: none;">0</span>
                                        </div>
                                        <div class="add-section">
                                            <!-- Chat Search -->
                                            <form action="" method="">
                                                @csrf
                                                <div class="user-chat-search">
                                                    <span class="form-control-feedback"><i
                                                            class="fa-solid fa-magnifying-glass"></i></span>
                                                    <input type="text" name="chat-search" placeholder="Search"
                                                        class="form-control" id="chatSearch">
                                                </div>
                                            </form>
                                            <!-- /Chat Search -->
                                        </div>
                                    </div>
                                    <!-- /Left Chat Title -->

                                    <div class="sidebar-body chat-body" id="chatsidebar">

                                        <!-- Left Chat Title -->
                                        <div class="d-flex justify-content-between align-items-center ps-0 pe-0">
                                            <div class="fav-title pin-chat">
                                                <h6>Recent Chat</h6>
                                            </div>
                                        </div>
                                        <!-- /Left Chat Title -->
                                        
                                        <ul class="user-list" id="chatUserList">
                                            @forelse ($patients as $bId => $chatData)
                                                @php
                                                    $booking = $chatData->booking;
                                                    $doctor = $booking?->doctor;
                                                    $doctorImage = $doctor?->profile->dp ? asset( $doctor->profile->dp) : asset('images/default.jpeg');
                                                    $lastMessage = $chatData->last_message;
                                                    $unreadCount = $chatData->unread_count;
                                                    $isActive = request('booking') == $booking?->id;
                                                @endphp
                                                @if($doctor && $lastMessage)
                                                    <li class="user-list-item chat-user-item {{ $isActive ? 'active' : '' }}" 
                                                        data-booking-id="{{ $booking->id }}"
                                                        data-doctor-id="{{ $doctor->id }}"
                                                        data-unread="{{ $unreadCount }}">
                                                        <a href="{{ route('chat.index', ['booking' => $booking->id]) }}"
                                                           onclick="handleChatClick(event, {{ $booking->id }})">
                                                            <div class="avatar {{ $doctor->is_online ? 'avatar-online' : 'avatar-offline' }}">
                                                                <img src="{{ $doctorImage }}" alt="{{ $doctor->name }}">
                                                            </div>
                                                            <div class="users-list-body">
                                                                <div>
                                                                    <h5>{{ $doctor->name }}</h5>
                                                                    <p class="last-message">{{ Str::limit($lastMessage->message, 30) }}</p>
                                                                </div>
                                                                <div class="last-chat-time">
                                                                    <small class="text-muted last-message-time">
                                                                        {{ $lastMessage->created_at->diffForHumans() }}
                                                                    </small>
                                                                    @if($unreadCount > 0)
                                                                        <div class="new-message-count unread-badge">
                                                                            {{ $unreadCount }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif
                                            @empty
                                                <li class="text-center text-muted p-3">No chats yet</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- / Chats sidebar -->
                        </div>
                        <!-- /Sidebar group -->

                        <!-- Chat -->
                        <div class="chat chat-messages" id="chatMessages">
                            <div class="slimscroll">
                                <div class="chat-inner-header">
                                    <div class="chat-header">
                                        <div class="user-details">
                                            <div class="d-lg-none">
                                                <ul class="list-inline mt-2 me-2">
                                                    <li class="list-inline-item">
                                                        <a class="text-muted px-0 left_sides" href="javascript:void(0);" onclick="showSidebarOnMobile()">
                                                            <i class="fas fa-arrow-left"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            @php
                                                $activeBookingId = request('booking');
                                                $activeDoctor = null;
                                                $activeDoctorImage = asset('images/default.jpeg');
                                                
                                                if ($activeBookingId) {
                                                    $activeBooking = \App\Models\Booking::with('doctor')->find($activeBookingId);
                                                    $activeDoctor = $activeBooking?->doctor;
                                                    $activeDoctorImage = $activeDoctor?->profile->dp
                                                        ? asset( $activeDoctor->profile->dp) 
                                                        : asset('images/default.jpeg');
                                                } elseif(isset($messages) && $messages->isNotEmpty()) {
                                                    $activeDoctor = $messages->first()->booking?->doctor;
                                                    $activeDoctorImage = $activeDoctor?->profile->dp 
                                                        ? asset( $activeDoctor->profile->dp) 
                                                        : asset('images/default.jpeg');
                                                }
                                            @endphp
                                            <figure class="avatar {{ $activeDoctor?->is_online ? 'avatar-online' : 'avatar-offline' }}">
                                                <img src="{{ $activeDoctorImage }}" alt="{{ $activeDoctor?->name ?? 'Doctor' }}" id="currentDoctorImage">
                                            </figure>
                                            <div class="mt-1">
                                                <h5 id="currentDoctorName">{{ $activeDoctor?->name ?? 'Select a chat' }}</h5>
                                                <small class="last-seen" id="doctorStatus">
                                                    @if($activeDoctor)
                                                        <span class="online-status {{ $activeDoctor->is_online ? 'text-success' : 'text-secondary' }}">
                                                            {{ $activeDoctor->is_online ? '● Online' : '○ Offline' }}
                                                        </span>
                                                    @else
                                                        &nbsp;
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="chat-options">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-light chat-search-btn"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Search in chat">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="btn btn-outline-light no-bg" href="#"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" onclick="markAllAsRead()">Mark all as read</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#clear-chat">Clear Chat</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#block-user">Block User</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Chat Search -->
                                        <div class="chat-search">
                                            <form onsubmit="return false;">
                                                <span class="form-control-feedback"><i
                                                        class="fa-solid fa-magnifying-glass"></i></span>
                                                <input type="text" placeholder="Search in conversation..."
                                                    class="form-control" id="messageSearch">
                                                <div class="close-btn-chat" onclick="closeMessageSearch()"><i class="fa fa-close"></i></div>
                                            </form>
                                        </div>
                                        <!-- /Chat Search -->
                                    </div>
                                </div>
                                
                                <div class="chat-body" id="chatMessagesBody">
                                    <div class="messages" id="messagesContainer">
                                        @php
                                            $lastDate = null;
                                        @endphp

                                        @if(isset($messages) && $messages->isNotEmpty())
                                            @foreach($messages as $msg)
                                                @php
                                                    $msgDoctor = $msg->booking?->doctor;
                                                    $currentDate = $msg->created_at->format('F d, Y');
                                                    
                                                    // Get profile images
                                                    if($msg->sender_id == Auth::id()) {
                                                        $senderImage = Auth::user()->profile->dp ? asset( Auth::user()->profile->dp) : asset('images/default.jpeg');
                                                        $senderName = Auth::user()->name;
                                                    } else {
                                                        $senderImage = $msgDoctor?->profile->dp ? asset( $msgDoctor->profile->dp) : asset('images/default.jpeg');
                                                        $senderName = $msgDoctor?->name ?? 'Doctor';
                                                    }
                                                @endphp

                                                {{-- Show timeline only when date changes --}}
                                                @if ($lastDate !== $currentDate)
                                                    <div class="chat-line">
                                                        <span class="chat-date">{{ $currentDate }}</span>
                                                    </div>
                                                    @php
                                                        $lastDate = $currentDate;
                                                    @endphp
                                                @endif

                                                @if($msg->sender_id == Auth::id())
                                                    {{-- My message (right side) --}}
                                                    <div class="chats chats-right" data-message-id="{{ $msg->id }}" data-read="{{ $msg->is_read ? '1' : '0' }}" data-read-at="{{ $msg->read_at }}">
                                                        <div class="chat-content">
                                                            <div class="chat-profile-name text-end justify-content-end">
                                                                <h6>{{ $senderName }}
                                                                    <span>{{ $msg->created_at->format('h:i A') }}</span>
                                                                </h6>
                                                            </div>
                                                            <div class="message-content">
                                                                {{ $msg->message }}
                                                            </div>
                                                            <div class="message-status">
                                                                @if($msg->is_read)
                                                                    <span class="read-receipt read" title="Read {{ $msg->read_at ? $msg->read_at->diffForHumans() : '' }}">
                                                                        <i class="fa fa-check-double"></i> Read
                                                                    </span>
                                                                @else
                                                                    <span class="read-receipt delivered" title="Delivered">
                                                                        <i class="fa fa-check"></i> Delivered
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="chat-avatar">
                                                            <img src="{{ $senderImage }}" class="dreams_chat" alt="{{ $senderName }}">
                                                        </div>
                                                    </div>
                                                @else
                                                    {{-- Other person's message (left side) --}}
                                                    <div class="chats" data-message-id="{{ $msg->id }}" data-is-read="{{ $msg->is_read ? '1' : '0' }}">
                                                        <div class="chat-avatar">
                                                            <img src="{{ $senderImage }}" class="dreams_chat" alt="{{ $senderName }}">
                                                        </div>
                                                        <div class="chat-content">
                                                            <div class="chat-profile-name">
                                                                <h6>{{ $senderName }}
                                                                    <span>{{ $msg->created_at->format('h:i A') }}</span>
                                                                </h6>
                                                            </div>
                                                            <div class="message-content">
                                                                {{ $msg->message }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="text-center text-muted p-5 no-messages">
                                                <p>No messages yet. Start the conversation!</p>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Typing indicator -->
                                    <div class="typing-indicator" id="typingIndicator" style="display: none;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-footer">
                                @php

                                    use Carbon\Carbon;

                                    $now = Carbon::now();

                                    $appointments = \App\Models\Booking::where('appointment_datetime', '<=', $now)
                                        ->whereRaw(
                                            "DATE_ADD(appointment_datetime, INTERVAL service_time MINUTE) > ?",
                                            [$now]
                                        )
                                        ->get();
                                        
                                    // Get current active booking and doctor
                                    $activeBookingId = request('booking');
                                    $activeDoctorId = null;
                                    
                                    if ($activeBookingId) {
                                        $activeBooking = \App\Models\Booking::with('doctor')->find($activeBookingId);
                                        $activeDoctorId = $activeBooking?->doctor?->id;
                                    } elseif(isset($messages) && $messages->isNotEmpty()) {
                                        $activeBookingId = $messages->first()->booking_id;
                                        $activeDoctorId = $messages->first()->booking?->doctor?->id;
                                    }
                                @endphp

                                @if($activeBookingId && $activeDoctorId)
                                    <form action="{{ route('chat.store1') }}" method="POST" id="chatForm">
                                        @csrf
                                        <input type="hidden" name="receiver_id" id="receiverId" value="{{ $activeDoctorId }}">
                                        <input type="hidden" name="booking_id" id="bookingId" value="{{ $activeBookingId }}">

                                        <div class="smile-foot">
                                            <div class="chat-action-btns">
                                                <div class="chat-action-col">
                                                    <a class="action-circle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-paperclip"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item"><span><i class="fa-solid fa-image"></i></span>Image</a>
                                                        <a href="#" class="dropdown-item"><span><i class="fa-solid fa-file"></i></span>Document</a>
                                                        <a href="#" class="dropdown-item"><span><i class="fa-solid fa-camera"></i></span>Camera</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="smile-foot emoj-action-foot">
                                            <a href="#" class="action-circle emoji-picker-btn"><i class="fa-regular fa-face-smile"></i></a>
                                            <div class="emoj-group-list-foot down-emoji-circle" id="emojiPicker" style="display: none;">
                                                <ul>
                                                    <li><a href="javascript:void(0);" onclick="insertEmoji('😊')">😊</a></li>
                                                    <li><a href="javascript:void(0);" onclick="insertEmoji('😂')">😂</a></li>
                                                    <li><a href="javascript:void(0);" onclick="insertEmoji('❤️')">❤️</a></li>
                                                    <li><a href="javascript:void(0);" onclick="insertEmoji('👍')">👍</a></li>
                                                    <li><a href="javascript:void(0);" onclick="insertEmoji('🎉')">🎉</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Message input -->
                                        

                                         @if ($activeType)

                                         <input type="text" name="message" class="form-control chat_form" id="messageInput"
                                            placeholder="Type your message here..." required autocomplete="off"
                                            onkeyup="checkTyping()" onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); sendMessage(); }">

                                         @else

                                         <input type="none" name="message" class="form-control chat_form" id="messageInput"
                                            placeholder="Type your message here..." required autocomplete="off"
                                            onkeyup="checkTyping()" onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); sendMessage(); }">

                                         @endif
                                        
                                        <div class="form-buttons">
                                            <button class="btn send-btn" type="button" id="sendMessageBtn" onclick="sendMessage()" >
                                                <i class="isax isax-send-25"></i>
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="text-center p-3 text-muted no-chat-selected">
                                        <i class="fa fa-comment-slash"></i> Select a chat to start messaging
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- /Chat -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->

    <!-- Toast notification for new messages -->
	 

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="newMessageToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
            <div class="toast-header">
                <img src="{{ asset('images/icon-message.png') }}" class="rounded me-2" width="20" height="20" alt="Message">
                <strong class="me-auto" id="toastSender">New Message</strong>
                <small>just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessageContent">
                You have a new message
            </div>
        </div>
    </div>

    <!-- Audio for notification -->
    <audio id="notificationSound" preload="auto" style="display:none;">
        <source src="{{ asset('sounds/notification.mp3') }}" type="audio/mpeg">
    </audio>

    <style>
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .toast {
            min-width: 250px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .online-status.text-success {
            color: #28a745;
            font-weight: bold;
        }
        .online-status.text-secondary {
            color: #6c757d;
        }
        .chat-user-item.active {
            background-color: #e3f2fd;
            border-left: 3px solid #0d6efd;
        }
        .chat-user-item {
            transition: all 0.3s ease;
            position: relative;
        }
        .chat-user-item:hover {
            background-color: #f8f9fa;
        }
        .new-message-count {
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            display: inline-block;
            min-width: 20px;
            text-align: center;
        }
        #messageInput:disabled {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        .message-status {
            font-size: 11px;
            margin-top: 2px;
            text-align: right;
            color: #6c757d;
        }
        .message-status .read-receipt.read {
            color: #0d6efd;
        }
        .message-status .read-receipt.delivered {
            color: #6c757d;
        }
        .read-receipt i {
            font-size: 12px;
        }
        .avatar-online {
            position: relative;
        }
        .avatar-online::after {
            content: '';
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background-color: #28a745;
            border-radius: 50%;
            border: 2px solid white;
        }
        .avatar-offline::after {
            content: '';
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background-color: #6c757d;
            border-radius: 50%;
            border: 2px solid white;
        }
        .typing-indicator {
            display: flex;
            padding: 10px 20px;
            background: #f8f9fa;
            border-radius: 20px;
            margin: 10px;
            width: fit-content;
        }
        .typing-indicator span {
            height: 8px;
            width: 8px;
            margin: 0 2px;
            background-color: #9E9EA1;
            border-radius: 50%;
            display: inline-block;
            animation: typing 1.4s infinite ease-in-out both;
        }
        .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
        .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }
        @keyframes typing {
            0%, 80%, 100% { transform: scale(0.6); opacity: 0.6; }
            40% { transform: scale(1); opacity: 1; }
        }
        .total-unread-badge {
            background-color: #dc3545;
            color: white;
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 12px;
            margin-left: 10px;
        }
    </style>

    <!-- Voice Call Modal -->
    <div class="modal fade call-modal" id="voice_call">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="call-box incoming-box">
                        <div class="call-wrapper">
                            <div class="call-inner">
                                <div class="call-user">
                                    <img alt="User Image" src="{{asset('images/doctor-thumb-02.jpg')}}"
                                        class="call-avatar">
                                    <h4>Darren Elder</h4>
                                    <span>Connecting...</span>
                                </div>
                                <div class="call-items">
                                    <a href="javascript:void(0);" class="btn call-item call-end" data-bs-dismiss="modal"
                                        aria-label="Close"><i class="material-icons">call_end</i></a>
                                    <a href="voice-call.html" class="btn call-item call-start"><i
                                            class="material-icons">call</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Call Modal -->
    <div class="modal fade call-modal" id="video_call">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="call-box incoming-box">
                        <div class="call-wrapper">
                            <div class="call-inner">
                                <div class="call-user">
                                    <img class="call-avatar" src="{{asset('images/doctor-thumb-02.jpg')}}"
                                        alt="User Image">
                                    <h4>Darren Elder</h4>
                                    <span>Calling ...</span>
                                </div>
                                <div class="call-items">
                                    <a href="javascript:void(0);" class="btn call-item call-end" data-bs-dismiss="modal"
                                        aria-label="Close"><i class="material-icons">call_end</i></a>
                                    <a href="video-call.html" class="btn call-item call-start"><i
                                            class="material-icons">videocam</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clear Chat Modal -->
    <div class="modal fade" id="clear-chat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Clear Chat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to clear this conversation? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="clearCurrentChat()">Clear Chat</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Block User Modal -->
    <div class="modal fade" id="block-user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Block User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to block this user? You will no longer receive messages from them.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="blockUser()">Block User</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script data-cfasync="false" src="{{asset('js/email-decode.min.js')}}"></script>
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/ResizeSensor.js')}}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/daterangepicker.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>

    <script>
        // ==================== CONFIGURATION ====================
        const CONFIG = {
            pollInterval: 2000,
            unreadPollInterval: 5000,
            authId: {{ Auth::id() }},
            authName: '{{ Auth::user()->name }}',
            authImage: '{{ Auth::user()->profile && Auth::user()->profile->dp ? asset( Auth::user()->profile->dp) : asset("images/default.jpeg") }}',
            defaultImage: '{{ asset("images/default.jpeg") }}',
            soundEnabled: true,
            isDoctor: false
        };

        // State variables
        let lastMessageId = {{ $messages->last()->id ?? 0 }};
        let pollInterval = null;
        let unreadPollInterval = null;
        let typingTimer = null;
        let isTyping = false;
        let isSending = false; // Flag to prevent multiple sends
        let notificationSound = document.getElementById('notificationSound');

        // ==================== UTILITY FUNCTIONS ====================
        function getCurrentBookingId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('booking');
        }

        function getCurrentReceiverId() {
            return document.getElementById('receiverId')?.value || null;
        }

        function getApiBaseUrl() {
            return '/patient/chat';
        }

        function formatTime(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
        }

        function formatRelativeTime(timestamp) {
            const date = new Date(timestamp);
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMins / 60);
            const diffDays = Math.floor(diffHours / 24);

            if (diffMins < 1) return 'just now';
            if (diffMins < 60) return `${diffMins} min ago`;
            if (diffHours < 24) return `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`;
            if (diffDays === 1) return 'yesterday';
            return date.toLocaleDateString();
        }

        function playNotificationSound() {
            if (CONFIG.soundEnabled && notificationSound) {
                notificationSound.play().catch(e => console.log('Sound play failed:', e));
            }
        }

        function showToast(message, senderName = 'New Message') {
            const toastEl = document.getElementById('newMessageToast');
            if (!toastEl) return;
            
            document.getElementById('toastSender').textContent = senderName;
            document.getElementById('toastMessageContent').textContent = message;
            
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ==================== MOBILE HANDLING ====================
        function handleChatClick(event, bookingId) {
            if (event) {
                event.preventDefault();
            }
            
            if (window.innerWidth < 992) {
                setTimeout(function() {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-block');
                }, 50);
            }
            
            // Navigate to the chat
            window.location.href = `{{ route('chat.index') }}?booking=${bookingId}`;
        }

        function showSidebarOnMobile() {
            document.getElementById('chatMessages').classList.add('d-none');
            document.getElementById('chatMessages').classList.remove('d-block');
            document.getElementById('chatSidebar').classList.remove('d-none');
            
            // Remove booking from URL
            const url = new URL(window.location);
            url.searchParams.delete('booking');
            window.history.pushState({}, '', url);
        }

        // ==================== MESSAGE RENDERING ====================
        function createMessageElement(message, isCurrentUser) {
            const messageDiv = document.createElement('div');
            messageDiv.className = isCurrentUser ? 'chats chats-right' : 'chats';
            messageDiv.setAttribute('data-message-id', message.id);
            if (!isCurrentUser) {
                messageDiv.setAttribute('data-is-read', message.is_read ? '1' : '0');
            }
            
            const timeString = formatTime(message.created_at);
            const senderName = isCurrentUser ? CONFIG.authName : (message.sender?.name || 'Doctor');
            
            // Fix image path syntax
            let senderImage = CONFIG.defaultImage;
            if (isCurrentUser) {
                senderImage = CONFIG.authImage;
            } else if (message.sender?.profile_image) {
                senderImage = `/storage/${message.sender.profile_image}`;
            } else if (message.sender?.profile?.dp) {
                senderImage = message.sender.profile.dp;
            }
            
            if (isCurrentUser) {
                messageDiv.innerHTML = `
                    <div class="chat-content">
                        <div class="chat-profile-name text-end justify-content-end">
                            <h6>${senderName} <span>${timeString}</span></h6>
                        </div>
                        <div class="message-content">
                            ${escapeHtml(message.message)}
                        </div>
                        <div class="message-status">
                            <span class="read-receipt ${message.is_read ? 'read' : 'delivered'}" title="${message.is_read ? 'Read' : 'Delivered'}">
                                <i class="fa ${message.is_read ? 'fa-check-double' : 'fa-check'}"></i> 
                                ${message.is_read ? 'Read' : 'Delivered'}
                            </span>
                        </div>
                    </div>
                    <div class="chat-avatar">
                        <img src="${senderImage}" class="dreams_chat" alt="${senderName}">
                    </div>
                `;
            } else {
                messageDiv.innerHTML = `
                    <div class="chat-avatar">
                        <img src="${senderImage}" class="dreams_chat" alt="${senderName}">
                    </div>
                    <div class="chat-content">
                        <div class="chat-profile-name">
                            <h6>${senderName} <span>${timeString}</span></h6>
                        </div>
                        <div class="message-content">
                            ${escapeHtml(message.message)}
                        </div>
                    </div>
                `;
            }
            
            return messageDiv;
        }

        function addMessageToContainer(message, isCurrentUser, scroll = true) {
            const messagesContainer = document.getElementById('messagesContainer');
            if (!messagesContainer) return;

            // Remove "no messages" placeholder
            const noMessages = messagesContainer.querySelector('.no-messages');
            if (noMessages) noMessages.remove();

            // Check for duplicates
            if (messagesContainer.querySelector(`[data-message-id="${message.id}"]`)) {
                return;
            }

            const messageElement = createMessageElement(message, isCurrentUser);
            messagesContainer.appendChild(messageElement);

            if (scroll) scrollToBottom();
        }

        function scrollToBottom() {
            const chatBody = document.getElementById('chatMessagesBody');
            if (chatBody) {
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        }

        // ==================== READ RECEIPTS ====================
        async function markMessagesAsRead(bookingId) {
            if (!bookingId) return;

            try {
                const url = CONFIG.isDoctor 
                    ? `/doctor/chat/mark-booking-read/${bookingId}`
                    : `/patient/chat/mark-booking-read/${bookingId}`;
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) throw new Error('Failed to mark messages as read');

                const data = await response.json();
                
                if (data.marked_read > 0) {
                    removeUnreadBadge(bookingId);
                    updateMessageReadStatus(bookingId);
                    fetchUnreadCounts();
                }
            } catch (error) {
                console.error('Error marking messages as read:', error);
            }
        }

        function removeUnreadBadge(bookingId) {
            const chatItem = document.querySelector(`.chat-user-item[data-booking-id="${bookingId}"]`);
            if (chatItem) {
                const badge = chatItem.querySelector('.unread-badge');
                if (badge) badge.remove();
                chatItem.dataset.unread = '0';
            }
        }

        function updateMessageReadStatus(bookingId) {
            // Update all my messages in current chat to show as read
            const myMessages = document.querySelectorAll('.chats-right[data-message-id]');
            myMessages.forEach(msg => {
                const statusSpan = msg.querySelector('.message-status .read-receipt');
                if (statusSpan) {
                    statusSpan.className = 'read-receipt read';
                    statusSpan.innerHTML = '<i class="fa fa-check-double"></i> Read';
                    statusSpan.title = 'Read';
                }
            });
        }

        async function markMessageAsRead(messageId) {
            if (!messageId) return false;

            try {
                const url = CONFIG.isDoctor
                    ? `/doctor/chat/mark-message-read/${messageId}`
                    : `/patient/chat/mark-message-read/${messageId}`;

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) throw new Error('Failed to mark message as read');

                const data = await response.json();
                return data.success;
            } catch (error) {
                console.error('Error marking message as read:', error);
                return false;
            }
        }

        // ==================== UNREAD COUNTS ====================
        async function fetchUnreadCounts() {
            try {
                const response = await fetch(`${getApiBaseUrl()}/unread-counts`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) throw new Error('Failed to fetch unread counts');

                const data = await response.json();
                
                updateSidebarUnreadBadges(data.unread_counts);
                updateTotalUnreadBadge(data.total_unread);
                updatePageTitle(data.total_unread);
                
            } catch (error) {
                console.error('Error fetching unread counts:', error);
            }
        }

        function updateSidebarUnreadBadges(unreadCounts) {
            const chatItems = document.querySelectorAll('.chat-user-item');
            
            chatItems.forEach(item => {
                const bookingId = item.dataset.bookingId;
                const unreadCount = unreadCounts[bookingId] || 0;
                
                item.dataset.unread = unreadCount;
                
                const lastChatTime = item.querySelector('.last-chat-time');
                let badge = item.querySelector('.unread-badge');
                
                if (unreadCount > 0) {
                    if (badge) {
                        badge.textContent = unreadCount;
                    } else {
                        badge = document.createElement('div');
                        badge.className = 'new-message-count unread-badge';
                        badge.textContent = unreadCount;
                        lastChatTime?.appendChild(badge);
                    }
                } else if (badge) {
                    badge.remove();
                }
            });
        }

        function updateTotalUnreadBadge(total) {
            const badge = document.getElementById('totalUnreadBadge');
            if (badge) {
                if (total > 0) {
                    badge.textContent = total;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        }

        function updatePageTitle(totalUnread) {
            const baseTitle = 'Chat - {{ config("app.name") }}';
            document.title = totalUnread > 0 ? `(${totalUnread}) ${baseTitle}` : baseTitle;
        }

        // ==================== POLLING FOR NEW MESSAGES ====================
        async function fetchNewMessages() {
            const bookingId = getCurrentBookingId();
            if (!bookingId) return;

            try {
                const response = await fetch(`${getApiBaseUrl()}/messages/new?booking_id=${bookingId}&last_message_id=${lastMessageId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                
                if (data.messages && data.messages.length > 0) {
                    let hasNewMessages = false;
                    
                    data.messages.forEach(message => {
                        const isCurrentUser = message.sender_id == CONFIG.authId;
                        
                        if (message.booking_id == bookingId) {
                            addMessageToContainer(message, isCurrentUser, true);
                            hasNewMessages = true;
                            
                            if (!isCurrentUser) {
                                showToast(message.message, message.sender?.name || 'Doctor');
                                playNotificationSound();
                                
                                // If chat is visible, mark as read
                                if (isChatVisible()) {
                                    markMessagesAsRead(bookingId);
                                }
                            }
                        }
                        
                        if (message.id > lastMessageId) {
                            lastMessageId = message.id;
                        }
                    });
                    
                    if (hasNewMessages) {
                        updateSidebarLastMessage(bookingId, data.messages[data.messages.length - 1]);
                        fetchUnreadCounts();
                    }
                }
            } catch (error) {
                console.error('Error fetching messages:', error);
            }
        }

        function updateSidebarLastMessage(bookingId, lastMessage) {
            const chatItem = document.querySelector(`.chat-user-item[data-booking-id="${bookingId}"]`);
            if (chatItem) {
                const lastMsgEl = chatItem.querySelector('.last-message');
                const timeEl = chatItem.querySelector('.last-message-time');
                
                if (lastMsgEl) {
                    lastMsgEl.textContent = lastMessage.message.substring(0, 30) + (lastMessage.message.length > 30 ? '...' : '');
                }
                if (timeEl) {
                    timeEl.textContent = formatRelativeTime(lastMessage.created_at);
                }
            }
        }

        function isChatVisible() {
            return document.visibilityState === 'visible' && 
                   document.getElementById('chatMessages').classList.contains('d-block');
        }

        // ==================== SEND MESSAGE (FIXED - PREVENTS MULTIPLE SENDS) ====================
        async function sendMessage() {
            // Prevent multiple simultaneous sends
            if (isSending) {
                console.log('Message already sending, please wait...');
                return;
            }

            const form = document.getElementById('chatForm');
            if (!form) {
                console.error('Chat form not found');
                return;
            }

            const messageInput = document.getElementById('messageInput');
            if (!messageInput) {
                console.error('Message input not found');
                return;
            }

            const message = messageInput.value.trim();
            
            if (!message) {
                alert('Please enter a message');
                return;
            }

            // Check if receiver_id and booking_id are set
            const receiverId = document.getElementById('receiverId')?.value;
            const bookingId = document.getElementById('bookingId')?.value;
            
            if (!receiverId || !bookingId) {
                alert('Chat session not properly initialized. Please select a chat again.');
                return;
            }

            // Set sending flag to true
            isSending = true;
            
            // Disable the send button and input to prevent multiple clicks
            const sendBtn = document.getElementById('sendMessageBtn');
            if (sendBtn) {
                sendBtn.disabled = true;
            }
            messageInput.disabled = true;

            // Create FormData and manually append fields to ensure they're sent
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('receiver_id', receiverId);
            formData.append('booking_id', bookingId);
            formData.append('message', message);
            
            console.log('Sending message once:', {
                url: form.action,
                receiver_id: receiverId,
                booking_id: bookingId,
                message: message
            });

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                        // Don't set Content-Type header - let browser set it with boundary for FormData
                    }
                });

                // Try to parse the response
                let data;
                const contentType = response.headers.get('content-type');
                
                if (contentType && contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    const text = await response.text();
                    console.error('Non-JSON response:', text);
                    throw new Error('Server returned non-JSON response');
                }

                if (!response.ok) {
                    throw new Error(data.message || `HTTP error! status: ${response.status}`);
                }

                console.log('Message sent successfully:', data);
                
                if (data.success) {
                    // Add message to chat
                    addMessageToContainer(data.message, true, true);
                    
                    // Clear input
                    messageInput.value = '';
                    
                    // Update last message ID
                    if (data.message.id > lastMessageId) {
                        lastMessageId = data.message.id;
                    }
                    
                    // Update sidebar with last message
                    updateSidebarLastMessage(data.message.booking_id, data.message);
                    
                    // Fetch updated unread counts
                    fetchUnreadCounts();
                } else {
                    alert('Failed to send message: ' + (data.message || 'Unknown error'));
                }
                
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please check your connection and try again.\nError: ' + error.message);
            } finally {
                // Reset sending flag and re-enable inputs
                isSending = false;
                if (sendBtn) {
                    sendBtn.disabled = false;
                }
                messageInput.disabled = false;
                messageInput.focus();
            }
        }

        // ==================== TYPING INDICATOR ====================
        function checkTyping() {
            if (!isTyping) {
                isTyping = true;
                // Broadcast typing status (can be implemented with WebSocket)
            }
            
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                isTyping = false;
                // Broadcast stopped typing
            }, 1000);
        }

        // ==================== EMOJI PICKER ====================
        const emojiPickerBtn = document.querySelector('.emoji-picker-btn');
        if (emojiPickerBtn) {
            emojiPickerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const picker = document.getElementById('emojiPicker');
                if (picker) {
                    picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
                }
            });
        }

        // Close emoji picker when clicking outside
        document.addEventListener('click', function(e) {
            const picker = document.getElementById('emojiPicker');
            const btn = document.querySelector('.emoji-picker-btn');
            if (picker && btn && !btn.contains(e.target) && !picker.contains(e.target)) {
                picker.style.display = 'none';
            }
        });

        function insertEmoji(emoji) {
            const input = document.getElementById('messageInput');
            if (input) {
                input.value += emoji;
                input.focus();
                document.getElementById('emojiPicker').style.display = 'none';
            }
        }

        // ==================== MESSAGE SEARCH ====================
        const messageSearch = document.getElementById('messageSearch');
        if (messageSearch) {
            messageSearch.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const messages = document.querySelectorAll('.chats .message-content');
                
                messages.forEach(msg => {
                    const text = msg.textContent.toLowerCase();
                    const chatElement = msg.closest('.chats');
                    
                    if (text.includes(searchTerm) && searchTerm.length > 0) {
                        chatElement.style.backgroundColor = '#fff3cd';
                        chatElement.style.transition = 'background-color 0.3s';
                    } else {
                        chatElement.style.backgroundColor = '';
                    }
                });
            });
        }

        function closeMessageSearch() {
            const searchInput = document.getElementById('messageSearch');
            if (searchInput) {
                searchInput.value = '';
            }
            document.querySelectorAll('.chats').forEach(el => el.style.backgroundColor = '');
        }

        // ==================== CHAT ACTIONS ====================
        function markAllAsRead() {
            const bookingId = getCurrentBookingId();
            if (bookingId) {
                markMessagesAsRead(bookingId);
                
                // Also update the UI for all messages in current chat
                const unreadMessages = document.querySelectorAll('.chats:not(.chats-right)[data-is-read="0"]');
                unreadMessages.forEach(msg => {
                    msg.dataset.isRead = '1';
                });
            }
        }

        function clearCurrentChat() {
            const bookingId = getCurrentBookingId();
            if (bookingId && confirm('Are you sure you want to clear this chat?')) {
                // Implement clear chat functionality
                $('#clear-chat').modal('hide');
            }
        }

        function blockUser() {
            const doctorName = document.getElementById('currentDoctorName')?.textContent || 'this user';
            if (confirm(`Are you sure you want to block ${doctorName}?`)) {
                // Implement block user functionality
                $('#block-user').modal('hide');
            }
        }

        // ==================== CHAT SEARCH ====================
        function setupChatSearch() {
            const searchInput = document.getElementById('chatSearch');
            if (!searchInput) return;

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const chatItems = document.querySelectorAll('.chat-user-item');
                
                chatItems.forEach(item => {
                    const doctorName = item.querySelector('h5')?.textContent.toLowerCase() || '';
                    const lastMessage = item.querySelector('.last-message')?.textContent.toLowerCase() || '';
                    
                    item.style.display = (doctorName.includes(searchTerm) || lastMessage.includes(searchTerm)) ? '' : 'none';
                });
            });
        }

        // ==================== INTERSECTION OBSERVER FOR AUTO-READ ====================
        function setupReadReceiptObserver() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const messageElement = entry.target;
                        const messageId = messageElement.dataset.messageId;
                        const isFromOther = !messageElement.classList.contains('chats-right');
                        
                        if (isFromOther && messageId && messageElement.dataset.isRead === '0') {
                            markMessageAsRead(messageId).then(success => {
                                if (success) {
                                    messageElement.dataset.isRead = '1';
                                }
                            });
                            
                            observer.unobserve(messageElement);
                        }
                    }
                });
            }, { threshold: 0.5 });

            // Observe all messages from other users that are not read
            const messages = document.querySelectorAll('.chats:not(.chats-right)[data-is-read="0"]');
            messages.forEach(msg => observer.observe(msg));
        }

        // ==================== FORM SUBMISSION HANDLER (SIMPLIFIED) ====================
        function setupFormHandler() {
            const form = document.getElementById('chatForm');
            if (form) {
                // Remove any existing listeners to prevent duplicates
                form.removeEventListener('submit', handleFormSubmit);
                form.addEventListener('submit', handleFormSubmit);
            }

            // Enter key handler
            const messageInput = document.getElementById('messageInput');
            if (messageInput) {
                messageInput.removeEventListener('keydown', handleEnterKey);
                messageInput.addEventListener('keydown', handleEnterKey);
            }

            // Send button click handler
            const sendBtn = document.getElementById('sendMessageBtn');
            if (sendBtn) {
                // Remove the onclick attribute if it exists
                sendBtn.removeAttribute('onclick');
                sendBtn.removeEventListener('click', handleButtonClick);
                sendBtn.addEventListener('click', handleButtonClick);
            }
        }

        // Separate handler functions to allow proper removal
        function handleFormSubmit(e) {
            e.preventDefault();
            sendMessage();
        }

        function handleEnterKey(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        }

        function handleButtonClick(e) {
            e.preventDefault();
            sendMessage();
        }

        // ==================== INITIALIZATION ====================
        document.addEventListener('DOMContentLoaded', function() {
            // Set last message ID
            const lastMessage = document.querySelector('.messages .chats:last-child');
            if (lastMessage) {
                lastMessageId = parseInt(lastMessage.dataset.messageId) || 0;
                console.log('Last message ID:', lastMessageId);
            }

            // Mobile view handling
            const currentBookingId = getCurrentBookingId();
            
            if (window.innerWidth < 992) {
                if (currentBookingId) {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-block');
                    
                    const activeChat = document.querySelector(`[data-booking-id="${currentBookingId}"]`);
                    if (activeChat) activeChat.classList.add('active');
                } else {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-none');
                }
            }

            // Scroll to bottom
            scrollToBottom();

            // Setup chat search
            setupChatSearch();

            // Setup read receipt observer
            setupReadReceiptObserver();

            // Setup form handler
            setupFormHandler();

            // Start polling
            if (currentBookingId) {
                pollInterval = setInterval(fetchNewMessages, CONFIG.pollInterval);
            }
            
            unreadPollInterval = setInterval(fetchUnreadCounts, CONFIG.unreadPollInterval);
            
            // Initial fetch
            fetchUnreadCounts();

            // Mark messages as read if chat is open
            if (currentBookingId && isChatVisible()) {
                markMessagesAsRead(currentBookingId);
            }

            // Visibility change handler
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden && currentBookingId) {
                    markMessagesAsRead(currentBookingId);
                }
            });

            console.log('Chat initialized with booking ID:', currentBookingId);
        });

        // ==================== RESIZE HANDLING ====================
        window.addEventListener('resize', function() {
            const currentBookingId = getCurrentBookingId();
            
            if (window.innerWidth >= 992) {
                document.getElementById('chatSidebar').classList.remove('d-none');
                document.getElementById('chatMessages').classList.remove('d-none');
                document.getElementById('chatMessages').classList.add('d-block');
            } else {
                if (currentBookingId) {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').classList.remove('d-none');
                } else {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-none');
                }
            }
        });

        // ==================== CLEANUP ====================
        window.addEventListener('beforeunload', function() {
            if (pollInterval) clearInterval(pollInterval);
            if (unreadPollInterval) clearInterval(unreadPollInterval);
        });
    </script>
    <script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="87d100b3f0de52923242b24d-|49" defer></script>
</body>
</html>