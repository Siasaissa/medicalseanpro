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
                                            @foreach ($patients as $bId => $chatMessages)
                                                @php
                                                    $booking = $chatMessages->first()->booking;
                                                    $doctor = $booking?->doctor;
                                                    $doctorImage = $doctor?->profile_image ? asset('storage/' . $doctor->profile_image) : asset('images/default.jpeg');
                                                    $lastMessage = $chatMessages->last();
                                                    $unreadCount = $chatMessages->where('sender_id', '!=', Auth::id())->where('is_read', 0)->count();
                                                @endphp
                                                @if($doctor)
                                                    <li class="user-list-item chat-user-item {{ request('booking') == $chatMessages->first()->booking_id ? 'active' : '' }}" 
                                                        data-booking-id="{{ $chatMessages->first()->booking_id }}"
                                                        data-doctor-id="{{ $doctor->id }}"
                                                        data-unread="{{ $unreadCount }}">
                                                        <a href="{{ route('chat.index', ['booking' => $chatMessages->first()->booking_id]) }}"
                                                           onclick="handleChatClick(event, {{ $chatMessages->first()->booking_id }})">
                                                            <div class="avatar avatar-online">
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
                                            @endforeach
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
                                                    $activeDoctorImage = $activeDoctor?->profile_image 
                                                        ? asset('storage/' . $activeDoctor->profile_image) 
                                                        : asset('images/default.jpeg');
                                                } elseif(isset($messages) && $messages->isNotEmpty()) {
                                                    $activeDoctor = $messages->first()->booking?->doctor;
                                                    $activeDoctorImage = $activeDoctor?->profile_image 
                                                        ? asset('storage/' . $activeDoctor->profile_image) 
                                                        : asset('images/default.jpeg');
                                                }
                                            @endphp
                                            <figure class="avatar avatar-online">
                                                <img src="{{ $activeDoctorImage }}" alt="{{ $activeDoctor?->name ?? 'Doctor' }}" id="currentDoctorImage">
                                            </figure>
                                            <div class="mt-1">
                                                <h5 id="currentDoctorName">{{ $activeDoctor?->name ?? 'Select a chat' }}</h5>
                                                <small class="last-seen" id="doctorStatus">
                                                    @if($activeDoctor)
                                                        <span class="online-status">● Online</span>
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
                                                        title="Search">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="btn btn-outline-light no-bg" href="#"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item">Close Chat</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#mute-notification">Mute Notification</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#disappearing-messages">Disappearing Message</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#clear-chat">Clear Message</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#change-chat">Delete Chat</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#report-user">Report</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#block-user">Block</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Chat Search -->
                                        <div class="chat-search">
                                            <form>
                                                <span class="form-control-feedback"><i
                                                        class="fa-solid fa-magnifying-glass"></i></span>
                                                <input type="text" name="chat-search" placeholder="Search Chats"
                                                    class="form-control" id="messageSearch">
                                                <div class="close-btn-chat"><i class="fa fa-close"></i></div>
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
                                                        $senderImage = Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default.jpeg');
                                                        $senderName = Auth::user()->name;
                                                    } else {
                                                        $senderImage = $msgDoctor?->profile_image ? asset('storage/' . $msgDoctor->profile_image) : asset('images/default.jpeg');
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
                                                    {{-- Patient message (right side) --}}
                                                    <div class="chats chats-right" data-message-id="{{ $msg->id }}">
                                                        <div class="chat-content">
                                                            <div class="chat-profile-name text-end justify-content-end">
                                                                <h6>{{ $senderName }}
                                                                    <span>{{ $msg->created_at->format('h:i A') }}</span>
                                                                </h6>
                                                            </div>
                                                            <div class="message-content">
                                                                {{ $msg->message }}
                                                            </div>
                                                        </div>
                                                        <div class="chat-avatar">
                                                            <img src="{{ $senderImage }}" class="dreams_chat" alt="{{ $senderName }}">
                                                        </div>
                                                    </div>
                                                @else
                                                    {{-- Doctor message (left side) --}}
                                                    <div class="chats" data-message-id="{{ $msg->id }}">
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
                                </div>
                            </div>

                            <div class="chat-footer">
                                @php
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
                                                    <a class="action-circle" href="#" data-bs-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item"><span><i class="fa-solid fa-file-lines"></i></span>Document</a>
                                                        <a href="#" class="dropdown-item"><span><i class="fa-solid fa-camera"></i></span>Camera</a>
                                                        <a href="#" class="dropdown-item"><span><i class="fa-solid fa-image"></i></span>Gallery</a>
                                                        <a href="#" class="dropdown-item"><span><i class="fa-solid fa-volume-high"></i></span>Audio</a>
                                                        <a href="#" class="dropdown-item"><span><i class="fa-solid fa-location-dot"></i></span>Location</a>
                                                        <a href="#" class="dropdown-item"><span><i class="fa-solid fa-user"></i></span>Contact</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="smile-foot emoj-action-foot">
                                            <a href="#" class="action-circle"><i class="fa-regular fa-face-smile"></i></a>
                                            <div class="emoj-group-list-foot down-emoji-circle">
                                                <ul>
                                                    <li><a href="javascript:void(0);"><img src="{{asset('images/emoj-icon-01.svg')}}" alt="Icon"></a></li>
                                                    <li><a href="javascript:void(0);"><img src="{{asset('images/emoj-icon-02.svg')}}" alt="Icon"></a></li>
                                                    <li><a href="javascript:void(0);"><img src="{{asset('images/emoj-icon-03.svg')}}" alt="Icon"></a></li>
                                                    <li><a href="javascript:void(0);"><img src="{{asset('images/emoj-icon-04.svg')}}" alt="Icon"></a></li>
                                                    <li><a href="javascript:void(0);"><img src="{{asset('images/emoj-icon-05.svg')}}" alt="Icon"></a></li>
                                                    <li class="add-emoj"><a href="javascript:void(0);"><i class="fa-solid fa-plus"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="smile-foot">
                                            <a href="#" class="action-circle"><i class="isax isax-microphone-2"></i></a>
                                        </div>

                                        <!-- Message input -->
                                        <input type="text" name="message" class="form-control chat_form" id="messageInput"
                                            placeholder="Type your message here..." required autocomplete="off">

                                        <div class="form-buttons">
                                            <button class="btn send-btn" type="submit" id="sendMessageBtn">
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
                <strong class="me-auto">New Message</strong>
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
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }
        .toast {
            min-width: 250px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .online-status {
            color: #28a745;
            font-weight: bold;
        }
        .chat-user-item.active {
            background-color: #e3f2fd;
            border-left: 3px solid #0d6efd;
        }
        .chat-user-item {
            transition: all 0.3s ease;
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
        }
        #messageInput:disabled {
            background-color: #f8f9fa;
            cursor: not-allowed;
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

    <!-- Combined JavaScript -->
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
            pollInterval: 2000, // Poll every 2 seconds
            authId: {{ Auth::id() }},
            authName: '{{ Auth::user()->name }}',
            authImage: '{{ Auth::user()->profile_image ? asset("storage/" . Auth::user()->profile_image) : asset("images/default.jpeg") }}',
            defaultImage: '{{ asset("images/default.jpeg") }}',
            soundEnabled: true
        };

        // ==================== UTILITY FUNCTIONS ====================
        function getCurrentBookingId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('booking');
        }

        function getCurrentDoctorId() {
            return document.getElementById('receiverId')?.value || null;
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
            if (CONFIG.soundEnabled) {
                const sound = document.getElementById('notificationSound');
                sound.play().catch(e => console.log('Sound play failed:', e));
            }
        }

        function showToast(message, senderName = 'New Message') {
            const toastEl = document.getElementById('newMessageToast');
            const toastBody = document.getElementById('toastMessageContent');
            const toastHeader = toastEl.querySelector('.toast-header strong');
            
            toastHeader.textContent = senderName;
            toastBody.textContent = message;
            
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        // ==================== MOBILE HANDLING ====================
        function handleChatClick(event, bookingId) {
            if (window.innerWidth < 992) {
                setTimeout(function() {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-block');
                }, 50);
            }
        }

        function showSidebarOnMobile() {
            document.getElementById('chatMessages').classList.add('d-none');
            document.getElementById('chatMessages').classList.remove('d-block');
            document.getElementById('chatSidebar').classList.remove('d-none');
        }

        // ==================== MESSAGE RENDERING ====================
        function createMessageElement(message, isCurrentUser) {
            const messageDiv = document.createElement('div');
            messageDiv.className = isCurrentUser ? 'chats chats-right' : 'chats';
            messageDiv.setAttribute('data-message-id', message.id);
            
            const timeString = formatTime(message.created_at);
            const senderName = isCurrentUser ? CONFIG.authName : (message.sender?.name || 'Doctor');
            const senderImage = isCurrentUser 
                ? CONFIG.authImage
                : (message.sender?.profile_image ? `/storage/${message.sender.profile_image}` : CONFIG.defaultImage);
            
            if (isCurrentUser) {
                messageDiv.innerHTML = `
                    <div class="chat-content">
                        <div class="chat-profile-name text-end justify-content-end">
                            <h6>${senderName} <span>${timeString}</span></h6>
                        </div>
                        <div class="message-content">
                            ${escapeHtml(message.message)}
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

        // Simple escape function to prevent XSS
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function addMessageToContainer(message, isCurrentUser, scroll = true) {
            const messagesContainer = document.getElementById('messagesContainer');
            if (!messagesContainer) return;

            // Remove "no messages" placeholder if it exists
            const noMessages = messagesContainer.querySelector('.no-messages');
            if (noMessages) {
                noMessages.remove();
            }

            // Check if message already exists (prevent duplicates)
            if (messagesContainer.querySelector(`[data-message-id="${message.id}"]`)) {
                return;
            }

            const messageElement = createMessageElement(message, isCurrentUser);
            messagesContainer.appendChild(messageElement);

            if (scroll) {
                scrollToBottom();
            }
        }

        function scrollToBottom() {
            const chatBody = document.getElementById('chatMessagesBody');
            if (chatBody) {
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        }

        // ==================== FETCH NEW MESSAGES ====================
        async function fetchNewMessages() {
            const bookingId = getCurrentBookingId();
            const doctorId = getCurrentDoctorId();
            
            if (!bookingId || !doctorId) return;

            try {
                const response = await fetch(`/chat/messages/${bookingId}?last_message_id=${lastMessageId}`, {
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
                        
                        // Add message to current chat if it's for the active booking
                        if (message.booking_id == bookingId) {
                            addMessageToContainer(message, isCurrentUser, true);
                            hasNewMessages = true;
                            
                            // Show notification for messages from others
                            if (!isCurrentUser) {
                                showToast(message.message, message.sender?.name || 'Doctor');
                                playNotificationSound();
                            }
                        }
                        
                        // Update last message ID
                        if (message.id > lastMessageId) {
                            lastMessageId = message.id;
                        }
                    });
                    
                    if (hasNewMessages) {
                        updateSidebarLastMessage(bookingId, data.messages[data.messages.length - 1]);
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

                // Update unread count if message is from other user
                if (lastMessage.sender_id != CONFIG.authId) {
                    const unreadBadge = chatItem.querySelector('.unread-badge');
                    const currentUnread = parseInt(chatItem.dataset.unread || '0');
                    chatItem.dataset.unread = currentUnread + 1;
                    
                    if (unreadBadge) {
                        unreadBadge.textContent = currentUnread + 1;
                    } else {
                        const lastChatTime = chatItem.querySelector('.last-chat-time');
                        if (lastChatTime) {
                            const badge = document.createElement('div');
                            badge.className = 'new-message-count unread-badge';
                            badge.textContent = '1';
                            lastChatTime.appendChild(badge);
                        }
                    }
                }
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
                    
                    if (doctorName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // ==================== INITIALIZATION ====================
        let lastMessageId = 0;
        let pollInterval = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Set initial last message ID
            const lastMessage = document.querySelector('.messages .chats:last-child');
            if (lastMessage) {
                lastMessageId = parseInt(lastMessage.dataset.messageId) || 0;
            }

            // Mobile view handling
            const currentBookingId = getCurrentBookingId();
            
            if (window.innerWidth < 992) {
                if (currentBookingId) {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-block');
                    
                    const activeChat = document.querySelector(`[data-booking-id="${currentBookingId}"]`);
                    if (activeChat) {
                        activeChat.classList.add('active');
                    }
                } else {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-none');
                }
            }

            // Scroll to bottom
            scrollToBottom();

            // Setup chat search
            setupChatSearch();

            // Start polling for new messages if a chat is selected
            if (currentBookingId) {
                pollInterval = setInterval(fetchNewMessages, CONFIG.pollInterval);
            }

            // Mark messages as read when chat is opened
            if (currentBookingId) {
                fetch(`/chat/mark-read/${currentBookingId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
            }
        });

        // ==================== FORM HANDLING ====================
        document.getElementById('chatForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();
            
            if (!message) return;

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                
                // Add message to chat
                addMessageToContainer(data.message, true, true);
                
                // Clear input
                messageInput.value = '';
                
                // Update last message ID
                if (data.message.id > lastMessageId) {
                    lastMessageId = data.message.id;
                }
                
                // Update sidebar
                updateSidebarLastMessage(data.message.booking_id, data.message);
                
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
            }
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
            if (pollInterval) {
                clearInterval(pollInterval);
            }
        });
    </script>

    <!-- Laravel Echo for real-time (optional, falls back to polling) -->
    <script type="module">
        import Echo from 'laravel-echo';
        window.Pusher = require('pusher-js');

        try {
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: import.meta.env.VITE_PUSHER_APP_KEY || 'local',
                wsHost: import.meta.env.VITE_PUSHER_HOST || '127.0.0.1',
                wsPort: import.meta.env.VITE_PUSHER_PORT || 6001,
                forceTLS: false,
                disableStats: true,
            });

            const bookingId = document.querySelector('input[name="booking_id"]')?.value;

            if (bookingId) {
                window.Echo.channel(`chat.${bookingId}`)
                    .listen('.MessageSent', (e) => {
                        // Message will also be picked up by polling, but this is faster
                        console.log('Real-time message received:', e);
                    });
            }
        } catch (error) {
            console.log('Echo not available, using polling only:', error);
        }
    </script>

    <script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="87d100b3f0de52923242b24d-|49" defer></script>
</body>
</html>