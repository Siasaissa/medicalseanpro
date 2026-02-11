@include ('layouts.head')
@vite('resources/js/app.js')
<body class="main-chat-blk">

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include ('layouts.doctorHeader')
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
                                            <h4> All Chats</h4>
                                        </div>
                                        <div class="add-section">
                                            <!-- Chat Search -->
                                            <form action="" method="">
                                                @csrf
                                                <div class="user-chat-search">
                                                    <span class="form-control-feedback"><i
                                                            class="fa-solid fa-magnifying-glass"></i></span>
                                                    <input type="text" id="chatSearchInput" name="chat-search" placeholder="Search"
                                                        class="form-control">
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
                                                    $patient = $booking?->patient;
                                                    $patientImage = $patient?->profile_image ? asset('storage/' . $patient->profile_image) : asset('images/default.jpeg');
                                                    $lastMessage = $chatMessages->last();
                                                    $unreadCount = $chatMessages->where('sender_id', $patient?->id)->where('receiver_id', Auth::id())->where('is_read', 0)->count();
                                                    $isActive = request()->get('booking') == $chatMessages->first()->booking_id;
                                                @endphp
                                                @if($patient)
                                                    <li class="user-list-item chat-user-item {{ $isActive ? 'active' : '' }}" 
                                                        data-booking-id="{{ $chatMessages->first()->booking_id }}"
                                                        data-patient-id="{{ $patient->id }}"
                                                        data-patient-name="{{ $patient->name }}"
                                                        data-patient-image="{{ $patientImage }}"
                                                        data-unread="{{ $unreadCount }}">
                                                        <a href="javascript:void(0);"
                                                           onclick="handleChatClick({{ $chatMessages->first()->booking_id }})">
                                                            <div class="avatar avatar-online">
                                                                <img src="{{ $patientImage }}" alt="{{ $patient->name }}">
                                                            </div>
                                                            <div class="users-list-body">
                                                                <div>
                                                                    <h5>{{ $patient->name }}</h5>
                                                                    <p class="last-message-text">{{ Str::limit($lastMessage->message ?? 'No messages yet', 30) }}</p>
                                                                </div>
                                                                <div class="last-chat-time">
                                                                    <small class="text-muted last-message-time">
                                                                        {{ $lastMessage->created_at?->format('h:i A') ?? '' }}
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
                                                $currentPatient = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking?->patient : null;
                                                $currentPatientImage = $currentPatient?->profile_image ? asset('storage/' . $currentPatient->profile_image) : asset('images/default.jpeg');
                                            @endphp
                                            <figure class="avatar avatar-online">
                                                <img id="currentChatAvatar" src="{{ $currentPatientImage }}" alt="{{ $currentPatient?->name ?? 'Patient' }}">
                                            </figure>
                                            <div class="mt-1">
                                                <h5 id="currentChatName">{{ $currentPatient?->name ?? 'Select a chat' }}</h5>
                                                <small class="last-seen" id="currentChatStatus">
                                                    {{ $currentPatient ? 'Online' : '' }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="chat-options ">
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
                                                        <a href="#" class="dropdown-item ">Close Chat </a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#mute-notification">Mute Notification</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#disappearing-messages">Disappearing
                                                            Message</a>
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
                                                    class="form-control">
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
                                                    $msgPatient = $msg->booking?->patient;
                                                    $currentDate = $msg->created_at->format('F d, Y');
                                                    
                                                    // Get profile images
                                                    if($msg->sender_id == Auth::id()) {
                                                        $senderImage = Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default.jpeg');
                                                        $senderName = Auth::user()->name;
                                                    } else {
                                                        $senderImage = $msgPatient?->profile_image ? asset('storage/' . $msgPatient->profile_image) : asset('images/default.jpeg');
                                                        $senderName = $msgPatient?->name ?? 'Patient';
                                                    }
                                                @endphp

                                                {{-- Show timeline only when date changes --}}
                                                @if ($lastDate !== $currentDate)
                                                    <div class="chat-line">
                                                        <span class="chat-date">
                                                            @if ($msg->created_at->isToday())
                                                                Today
                                                            @elseif ($msg->created_at->isYesterday())
                                                                Yesterday
                                                            @else
                                                                {{ $currentDate }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                    @php
                                                        $lastDate = $currentDate;
                                                    @endphp
                                                @endif

                                                @if($msg->sender_id == Auth::id())
                                                    {{-- Doctor message (right side) --}}
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
                                                    {{-- Patient message (left side) --}}
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
                                <form action="{{ route('chat.store') }}" method="POST" id="chatForm">
                                    @csrf

                                    <!-- Hidden fields -->
                                    @php
                                        $currentBooking = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking : null;
                                        $currentPatientId = $currentBooking?->patient?->id ?? '';
                                        $currentBookingId = $currentBooking?->id ?? '';
                                    @endphp
                                    <input type="hidden" name="receiver_id" id="receiverId" value="{{ $currentPatientId }}">
                                    <input type="hidden" name="booking_id" id="bookingId" value="{{ $currentBookingId }}">

                                    <div class="smile-foot">
                                        <div class="chat-action-btns">
                                            <div class="chat-action-col">
                                                <a class="action-circle" href="#" data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#" class="dropdown-item "><span><i
                                                                class="fa-solid fa-file-lines"></i></span>Document</a>
                                                    <a href="#" class="dropdown-item"><span><i
                                                                class="fa-solid fa-camera"></i></span>Camera</a>
                                                    <a href="#" class="dropdown-item"><span><i
                                                                class="fa-solid fa-image"></i></span>Gallery</a>
                                                    <a href="#" class="dropdown-item"><span><i
                                                                class="fa-solid fa-volume-high"></i></span>Audio</a>
                                                    <a href="#" class="dropdown-item"><span><i
                                                                class="fa-solid fa-location-dot"></i></span>Location</a>
                                                    <a href="#" class="dropdown-item"><span><i
                                                                class="fa-solid fa-user"></i></span>Contact</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="smile-foot emoj-action-foot">
                                        <a href="#" class="action-circle emoji-toggle"><i class="fa-regular fa-face-smile"></i></a>
                                        <div class="emoj-group-list-foot down-emoji-circle">
                                            <ul>
                                                <li><a href="javascript:void(0);" data-emoji="😊"><img
                                                            src="{{asset('images/emoj-icon-01.svg')}}" alt="Icon"></a>
                                                </li>
                                                <li><a href="javascript:void(0);" data-emoji="😂"><img
                                                            src="{{asset('images/emoj-icon-02.svg')}}" alt="Icon"></a>
                                                </li>
                                                <li><a href="javascript:void(0);" data-emoji="❤️"><img
                                                            src="{{asset('images/emoj-icon-03.svg')}}" alt="Icon"></a>
                                                </li>
                                                <li><a href="javascript:void(0);" data-emoji="👍"><img
                                                            src="{{asset('images/emoj-icon-04.svg')}}" alt="Icon"></a>
                                                </li>
                                                <li><a href="javascript:void(0);" data-emoji="🎉"><img
                                                            src="{{asset('images/emoj-icon-05.svg')}}" alt="Icon"></a>
                                                </li>
                                                <li class="add-emoj"><a href="javascript:void(0);"><i
                                                            class="fa-solid fa-plus"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="smile-foot">
                                        <a href="#" class="action-circle"><i class="isax isax-microphone-2"></i></a>
                                    </div>

                                    <!-- Message input -->
                                    <input type="text" name="message" class="form-control chat_form" id="messageInput"
                                        placeholder="Type your message here..." autocomplete="off" required>

                                    <div class="form-buttons">
                                        <button class="btn send-btn" type="submit" id="sendMessageBtn">
                                            <i class="isax isax-send-25"></i>
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!-- /Chat -->

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Main Wrapper -->

    <!-- Notification Sound -->
    <audio id="notificationSound" preload="auto" style="display: none;">
        <source src="{{ asset('sounds/notification.mp3') }}" type="audio/mpeg">
    </audio>

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
                                    <h4 id="callPatientName">Darren Elder</h4>
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
                                    <h4 id="videoCallPatientName">Darren Elder</h4>
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

    <style>
        /* Notification animation */
        @keyframes notificationPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); background-color: #fff3cd; }
            100% { transform: scale(1); }
        }
        
        .new-message-highlight {
            animation: notificationPulse 1s ease 3;
        }
        
        .unread-badge {
            background-color: #dc3545 !important;
        }
        
        .user-list-item.active {
            background-color: rgba(13, 110, 253, 0.1);
            border-left: 3px solid #0d6efd;
        }
        
        /* Toast notification */
        .message-toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            border-left: 4px solid #0d6efd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 9999;
            max-width: 350px;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .message-toast img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        
        .message-toast-content {
            flex: 1;
        }
        
        .message-toast-title {
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .message-toast-text {
            color: #6c757d;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }
        
        .message-toast-close {
            cursor: pointer;
            color: #6c757d;
            font-size: 18px;
        }
        
        .message-toast-close:hover {
            color: #dc3545;
        }
    </style>

    <!-- Mobile Chat Toggle Script -->
    <script>
        // ============================================
        // DOCTOR CHAT SYSTEM WITH REAL-TIME NOTIFICATIONS
        // ============================================
        
        let currentBookingId = '{{ request()->get('booking') }}';
        let refreshInterval = null;
        let lastMessageCount = 0;
        let notificationSound = null;
        
        // Initialize notification sound
        document.addEventListener('DOMContentLoaded', function() {
            notificationSound = document.getElementById('notificationSound');
        });
        
        // Play notification sound
        function playNotificationSound() {
            try {
                if (notificationSound) {
                    notificationSound.play().catch(e => console.log('Sound play failed:', e));
                }
            } catch (e) {
                console.log('Sound error:', e);
            }
        }
        
        // Show toast notification
        function showToastNotification(patientName, message, patientImage) {
            // Remove existing toast
            const existingToast = document.querySelector('.message-toast');
            if (existingToast) existingToast.remove();
            
            // Create toast
            const toast = document.createElement('div');
            toast.className = 'message-toast';
            toast.innerHTML = `
                <img src="${patientImage}" alt="${patientName}">
                <div class="message-toast-content">
                    <div class="message-toast-title">${patientName}</div>
                    <div class="message-toast-text">${message}</div>
                </div>
                <span class="message-toast-close" onclick="this.parentElement.remove()">&times;</span>
            `;
            
            document.body.appendChild(toast);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) toast.remove();
            }, 5000);
        }
        
        // Update sidebar unread count and last message
        function updateSidebarChat(bookingId, patientName, message, time, patientImage) {
            const chatItem = document.querySelector(`.chat-user-item[data-booking-id="${bookingId}"]`);
            
            if (chatItem) {
                // Update last message
                const lastMessageEl = chatItem.querySelector('.last-message-text');
                if (lastMessageEl) {
                    lastMessageEl.textContent = message.length > 30 ? message.substring(0, 27) + '...' : message;
                }
                
                // Update time
                const timeEl = chatItem.querySelector('.last-message-time');
                if (timeEl) {
                    const now = new Date();
                    const timeString = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                    timeEl.textContent = timeString;
                }
                
                // Update unread badge if not currently viewing this chat
                if (currentBookingId != bookingId) {
                    const badgeContainer = chatItem.querySelector('.last-chat-time');
                    let badge = chatItem.querySelector('.unread-badge');
                    
                    if (badge) {
                        let count = parseInt(badge.textContent) || 0;
                        badge.textContent = count + 1;
                    } else {
                        const newBadge = document.createElement('div');
                        newBadge.className = 'new-message-count unread-badge';
                        newBadge.textContent = '1';
                        badgeContainer.appendChild(newBadge);
                    }
                    
                    // Highlight the chat item
                    chatItem.classList.add('new-message-highlight');
                    setTimeout(() => {
                        chatItem.classList.remove('new-message-highlight');
                    }, 3000);
                    
                    // Show notification
                    showToastNotification(patientName, message, patientImage);
                    playNotificationSound();
                    
                    // Update page title with notification
                    updatePageTitle(true);
                }
                
                // Update data attribute
                chatItem.dataset.unread = parseInt(chatItem.dataset.unread || 0) + 1;
            }
        }
        
        // Update page title with notification indicator
        function updatePageTitle(hasNotification) {
            if (hasNotification) {
                document.title = '🔴 New Message - Doctor Chat';
            } else {
                document.title = 'Doctor Chat';
            }
        }
        
        // Reset page title
        function resetPageTitle() {
            document.title = 'Doctor Chat';
        }
        
        // Fetch new messages for all chats
        function fetchAllUnreadMessages() {
            fetch('/doctor/chat/unread-messages', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        const bookingId = msg.booking_id;
                        const patientName = msg.sender?.name || 'Patient';
                        const patientImage = msg.sender?.profile_image 
                            ? '/storage/' + msg.sender.profile_image 
                            : '{{ asset("images/default.jpeg") }}';
                        const message = msg.message;
                        
                        updateSidebarChat(bookingId, patientName, message, msg.created_at, patientImage);
                        
                        // If this is the currently open chat, add message to container
                        if (currentBookingId == bookingId) {
                            addMessageToContainer(msg);
                            
                            // Mark as read immediately
                            markMessagesAsRead(bookingId);
                        }
                    });
                }
            })
            .catch(error => console.error('Error fetching unread messages:', error));
        }
        
        // Add message to chat container
        function addMessageToContainer(msg) {
            const messagesContainer = document.querySelector('.messages');
            if (!messagesContainer) return;
            
            // Remove "No messages" placeholder if exists
            const noMessages = messagesContainer.querySelector('.no-messages');
            if (noMessages) noMessages.remove();
            
            const isCurrentUser = msg.sender_id == {{ Auth::id() }};
            const messageDiv = document.createElement('div');
            messageDiv.className = isCurrentUser ? 'chats chats-right' : 'chats';
            
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
            
            const senderName = isCurrentUser ? '{{ Auth::user()->name }}' : msg.sender.name;
            const senderImage = isCurrentUser 
                ? '{{ Auth::user()->profile_image ? asset("storage/" . Auth::user()->profile_image) : asset("images/default.jpeg") }}'
                : (msg.sender.profile_image ? `/storage/${msg.sender.profile_image}` : '{{ asset("images/default.jpeg") }}');
            
            if (isCurrentUser) {
                messageDiv.innerHTML = `
                    <div class="chat-content">
                        <div class="chat-profile-name text-end justify-content-end">
                            <h6>${senderName} <span>${timeString}</span></h6>
                        </div>
                        <div class="message-content">
                            ${msg.message}
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
                            ${msg.message}
                        </div>
                    </div>
                `;
            }
            
            messagesContainer.appendChild(messageDiv);
            
            // Scroll to bottom
            const chatBody = document.querySelector('.chat-body');
            if (chatBody) {
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        }
        
        // Mark messages as read
        function markMessagesAsRead(bookingId) {
            const token = document.querySelector('input[name="_token"]')?.value || '';
            
            fetch(`/doctor/chat/mark-read/${bookingId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Remove unread badge from sidebar
                const chatItem = document.querySelector(`.chat-user-item[data-booking-id="${bookingId}"]`);
                if (chatItem) {
                    const badge = chatItem.querySelector('.unread-badge');
                    if (badge) badge.remove();
                    chatItem.dataset.unread = '0';
                }
                
                // Reset page title if this was the only unread
                resetPageTitle();
            })
            .catch(error => console.error('Error marking messages as read:', error));
        }
        
        // Get current booking ID from URL
        function getCurrentBookingId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('booking');
        }

        // Function to handle chat click
        function handleChatClick(bookingId) {
            // Change URL without page reload
            const url = new URL(window.location);
            url.searchParams.set('booking', bookingId);
            window.history.pushState({}, '', url);
            
            // Reload the page to show the chat
            window.location.href = window.location.href;
        }

        // Function to show sidebar on mobile
        function showSidebarOnMobile() {
            // Remove booking ID from URL
            const url = new URL(window.location);
            url.searchParams.delete('booking');
            window.history.pushState({}, '', url);
            
            // Reload the page to show sidebar
            window.location.href = window.location.href;
        }

        // On page load
        document.addEventListener('DOMContentLoaded', function() {
            const currentBookingIdFromUrl = getCurrentBookingId();
            currentBookingId = currentBookingIdFromUrl;
            
            if (window.innerWidth < 992) {
                if (currentBookingIdFromUrl) {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-block');
                    
                    const activeChat = document.querySelector(`[data-booking-id="${currentBookingIdFromUrl}"]`);
                    if (activeChat) {
                        activeChat.classList.add('active');
                    }
                    
                    // Mark messages as read when opening chat
                    markMessagesAsRead(currentBookingIdFromUrl);
                } else {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-none');
                }
            } else {
                document.getElementById('chatSidebar').classList.remove('d-none');
                document.getElementById('chatMessages').classList.remove('d-none');
                document.getElementById('chatMessages').classList.add('d-block');
                
                if (currentBookingIdFromUrl) {
                    markMessagesAsRead(currentBookingIdFromUrl);
                }
            }

            // Scroll to bottom of messages
            const chatBody = document.querySelector('.chat-body');
            if (chatBody) {
                chatBody.scrollTop = chatBody.scrollHeight;
            }
            
            // Initialize chat search
            const searchInput = document.getElementById('chatSearchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const chatItems = document.querySelectorAll('.user-list-item');
                    
                    chatItems.forEach(item => {
                        const patientName = item.querySelector('h5')?.textContent.toLowerCase() || '';
                        if (patientName.includes(searchTerm)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
            
            // Emoji picker
            document.querySelectorAll('[data-emoji]').forEach(emoji => {
                emoji.addEventListener('click', function(e) {
                    e.preventDefault();
                    const emojiChar = this.getAttribute('data-emoji');
                    const input = document.getElementById('messageInput');
                    if (input) {
                        input.value += emojiChar;
                        input.focus();
                    }
                });
            });
            
            // ============================================
            // START REAL-TIME MESSAGE FETCHING
            // ============================================
            
            // Initial fetch
            fetchAllUnreadMessages();
            
            // Set up interval to fetch messages every 3 seconds
            refreshInterval = setInterval(fetchAllUnreadMessages, 3000);
            
            // Stop fetching when page is hidden
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    if (refreshInterval) {
                        clearInterval(refreshInterval);
                        refreshInterval = null;
                    }
                } else {
                    if (!refreshInterval) {
                        refreshInterval = setInterval(fetchAllUnreadMessages, 3000);
                    }
                }
            });
            
            // Reset page title
            resetPageTitle();
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                document.getElementById('chatSidebar').classList.remove('d-none');
                document.getElementById('chatMessages').classList.remove('d-none');
                document.getElementById('chatMessages').classList.add('d-block');
            } else {
                const currentBookingIdFromUrl = getCurrentBookingId();
                if (currentBookingIdFromUrl) {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').classList.remove('d-none');
                } else {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-none');
                }
            }
        });
        
        // Clean up on page unload
        window.addEventListener('beforeunload', function() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        });
    </script>

    <script type="module">
        import Echo from 'laravel-echo';
        window.Pusher = require('pusher-js');

        // Echo instance for Pusher
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
            // Listen for messages via Pusher
            window.Echo.channel(`chat.${bookingId}`)
                .listen('.MessageSent', (e) => {
                    const messagesContainer = document.querySelector('.messages');
                    if (messagesContainer && e.message.booking_id == bookingId) {
                        // Add message to container
                        const isCurrentUser = e.message.sender_id === {{ Auth::id() }};
                        const messageDiv = document.createElement('div');
                        messageDiv.className = isCurrentUser ? 'chats chats-right' : 'chats';
                        
                        const now = new Date();
                        const timeString = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                        
                        const senderName = isCurrentUser ? '{{ Auth::user()->name }}' : e.message.sender.name;
                        const senderImage = isCurrentUser 
                            ? '{{ Auth::user()->profile_image ? asset("storage/" . Auth::user()->profile_image) : asset("images/default.jpeg") }}'
                            : (e.message.sender.profile_image ? `/storage/${e.message.sender.profile_image}` : '{{ asset("images/default.jpeg") }}');
                        
                        if (isCurrentUser) {
                            messageDiv.innerHTML = `
                                <div class="chat-content">
                                    <div class="chat-profile-name text-end justify-content-end">
                                        <h6>${senderName} <span>${timeString}</span></h6>
                                    </div>
                                    <div class="message-content">
                                        ${e.message.message}
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
                                        ${e.message.message}
                                    </div>
                                </div>
                            `;
                            
                            // Play notification sound for incoming messages
                            if (window.playNotificationSound) {
                                window.playNotificationSound();
                            }
                            
                            // Show toast notification
                            if (window.showToastNotification) {
                                window.showToastNotification(senderName, e.message.message, senderImage);
                            }
                        }
                        
                        messagesContainer.appendChild(messageDiv);
                        
                        // Scroll to bottom
                        const chatBody = document.querySelector('.chat-body');
                        if (chatBody) {
                            chatBody.scrollTop = chatBody.scrollHeight;
                        }
                        
                        // Mark as read
                        if (!isCurrentUser && window.markMessagesAsRead) {
                            window.markMessagesAsRead(bookingId);
                        }
                    }
                });
        }

        // Handle form submission
        const chatForm = document.getElementById('chatForm');
        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                // Form will submit normally, which reloads the page
                // This is fine for now
                setTimeout(function() {
                    document.getElementById('messageInput').value = '';
                }, 100);
            });
        }
    </script>

    <!-- Add this route to web.php -->
    <!--
    Route::get('/doctor/chat/unread-messages', function() {
        $messages = App\Models\Chat::where('receiver_id', Auth::id())
            ->where('is_read', 0)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(['messages' => $messages]);
    })->middleware('auth');
    
    Route::post('/doctor/chat/mark-read/{bookingId}', function($bookingId) {
        App\Models\Chat::where('booking_id', $bookingId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
        return response()->json(['success' => true]);
    })->middleware('auth');
    -->

    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/ResizeSensor.js')}}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/daterangepicker.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>

</body>

</html>