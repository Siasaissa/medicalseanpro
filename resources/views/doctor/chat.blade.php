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
                                                           onclick="loadChat({{ $chatMessages->first()->booking_id }}, {{ $patient->id }}, '{{ addslashes($patient->name) }}', '{{ $patientImage }}')">
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
                        <div class="chat chat-messages" id="chatMessages" style="{{ !request()->get('booking') ? 'display: none;' : '' }}">
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
                                        <!-- Messages will be loaded dynamically via AJAX -->
                                        <div class="text-center text-muted p-5">
                                            <p>Select a chat to start messaging</p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="chat-footer">
                                <form onsubmit="sendMessage(event)" id="chatForm">
                                    @csrf

                                    <!-- Hidden fields -->
                                    <input type="hidden" name="receiver_id" id="receiverId" value="">
                                    <input type="hidden" name="booking_id" id="bookingId" value="">

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
                                        <div class="emoj-group-list-foot down-emoji-circle d-none">
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
                                        placeholder="Type your message here..." autocomplete="off" required disabled>

                                    <div class="form-buttons">
                                        <button class="btn send-btn" type="submit" id="sendMessageBtn" disabled>
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
        
        .user-list-item.active h5 {
            color: #0d6efd;
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
        
        /* Mobile styles */
        @media (max-width: 991.98px) {
            .chat_sidebar.d-none {
                display: none !important;
            }
            
            #chatMessages {
                display: none;
            }
            
            #chatMessages.d-block {
                display: block !important;
            }
        }
    </style>

    <script>
        // ============================================
        // COMPLETE AJAX CHAT SYSTEM - NO PAGE RELOADS
        // ============================================
        
        let currentBookingId = null;
        let currentPatientId = null;
        let currentPatientName = null;
        let currentPatientImage = null;
        let refreshInterval = null;
        let notificationSound = null;
        
        // Initialize notification sound
        document.addEventListener('DOMContentLoaded', function() {
            notificationSound = document.getElementById('notificationSound');
            
            // Check URL for existing booking ID
            const urlParams = new URLSearchParams(window.location.search);
            const bookingId = urlParams.get('booking');
            
            if (bookingId) {
                const chatItem = document.querySelector(`[data-booking-id="${bookingId}"]`);
                if (chatItem) {
                    const patientId = chatItem.dataset.patientId;
                    const patientName = chatItem.dataset.patientName;
                    const patientImage = chatItem.dataset.patientImage;
                    
                    // Load the chat automatically
                    loadChat(bookingId, patientId, patientName, patientImage);
                }
            }
            
            // Initialize emoji picker
            initEmojiPicker();
            
            // Initialize search
            initSearch();
            
            // Start polling for new messages
            startPolling();
        });
        
        // ============================================
        // LOAD CHAT - NO PAGE RELOAD
        // ============================================
        function loadChat(bookingId, patientId, patientName, patientImage) {
            event?.preventDefault();
            
            console.log('Loading chat:', bookingId, patientName);
            
            // Update current state
            currentBookingId = bookingId;
            currentPatientId = patientId;
            currentPatientName = patientName;
            currentPatientImage = patientImage;
            
            // Update URL without page reload
            const url = new URL(window.location);
            url.searchParams.set('booking', bookingId);
            window.history.pushState({}, '', url);
            
            // Update chat header
            document.getElementById('currentChatAvatar').src = patientImage;
            document.getElementById('currentChatName').textContent = patientName;
            document.getElementById('currentChatStatus').innerHTML = 'Online';
            
            // Update form fields
            document.getElementById('receiverId').value = patientId;
            document.getElementById('bookingId').value = bookingId;
            
            // Enable input and send button
            document.getElementById('messageInput').disabled = false;
            document.getElementById('sendMessageBtn').disabled = false;
            document.getElementById('messageInput').focus();
            
            // Show chat messages container
            document.getElementById('chatMessages').style.display = 'block';
            
            // Mobile: hide sidebar, show chat
            if (window.innerWidth < 992) {
                document.getElementById('chatSidebar').classList.add('d-none');
                document.getElementById('chatMessages').classList.add('d-block');
            }
            
            // Remove active class from all chats
            document.querySelectorAll('.user-list-item').forEach(el => {
                el.classList.remove('active');
            });
            
            // Add active class to current chat
            const activeChat = document.querySelector(`[data-booking-id="${bookingId}"]`);
            if (activeChat) {
                activeChat.classList.add('active');
            }
            
            // Fetch messages for this chat
            fetchMessages(bookingId, patientName, patientImage);
            
            // Mark messages as read
            markMessagesAsRead(bookingId);
        }
        
        // ============================================
        // FETCH MESSAGES VIA AJAX
        // ============================================
        function fetchMessages(bookingId, patientName, patientImage) {
            fetch(`/doctor/chat/messages/${bookingId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('messagesContainer');
                container.innerHTML = '';
                
                if (data.messages && data.messages.length > 0) {
                    let lastDate = null;
                    
                    data.messages.forEach(msg => {
                        const msgDate = new Date(msg.created_at);
                        const dateStr = msgDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        const isToday = msgDate.toDateString() === new Date().toDateString();
                        const isYesterday = msgDate.toDateString() === new Date(Date.now() - 86400000).toDateString();
                        
                        // Add date divider
                        if (lastDate !== dateStr) {
                            const dateDiv = document.createElement('div');
                            dateDiv.className = 'chat-line';
                            
                            let dateText = dateStr;
                            if (isToday) dateText = 'Today';
                            else if (isYesterday) dateText = 'Yesterday';
                            
                            dateDiv.innerHTML = `<span class="chat-date">${dateText}</span>`;
                            container.appendChild(dateDiv);
                            lastDate = dateStr;
                        }
                        
                        // Add message
                        appendMessageToContainer(msg, patientName, patientImage);
                    });
                } else {
                    container.innerHTML = '<div class="text-center text-muted p-5"><p>No messages yet. Start the conversation!</p></div>';
                }
                
                // Scroll to bottom
                scrollToBottom();
            })
            .catch(error => console.error('Error fetching messages:', error));
        }
        
        // ============================================
        // APPEND MESSAGE TO CONTAINER
        // ============================================
        function appendMessageToContainer(msg, patientName, patientImage) {
            const container = document.getElementById('messagesContainer');
            
            // Remove "No messages" placeholder if exists
            const noMessages = container.querySelector('.text-center.text-muted.p-5');
            if (noMessages) noMessages.remove();
            
            const isCurrentUser = msg.sender_id == {{ Auth::id() }};
            const messageDiv = document.createElement('div');
            messageDiv.className = isCurrentUser ? 'chats chats-right' : 'chats';
            
            const msgDate = new Date(msg.created_at);
            const timeString = msgDate.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
            
            const senderName = isCurrentUser ? '{{ Auth::user()->name }}' : patientName;
            const senderImage = isCurrentUser 
                ? '{{ Auth::user()->profile_image ? asset("storage/" . Auth::user()->profile_image) : asset("images/default.jpeg") }}'
                : patientImage;
            
            if (isCurrentUser) {
                messageDiv.innerHTML = `
                    <div class="chat-content">
                        <div class="chat-profile-name text-end justify-content-end">
                            <h6>${senderName} <span>${timeString}</span></h6>
                        </div>
                        <div class="message-content">
                            ${escapeHtml(msg.message)}
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
                            ${escapeHtml(msg.message)}
                        </div>
                    </div>
                `;
            }
            
            container.appendChild(messageDiv);
            scrollToBottom();
        }
        
        // ============================================
        // SEND MESSAGE VIA AJAX
        // ============================================
        function sendMessage(event) {
            event.preventDefault();
            
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            
            if (!message || !currentBookingId || !currentPatientId) {
                return false;
            }
            
            const token = document.querySelector('input[name="_token"]')?.value || '';
            
            const formData = new FormData();
            formData.append('_token', token);
            formData.append('receiver_id', currentPatientId);
            formData.append('booking_id', currentBookingId);
            formData.append('message', message);
            
            // Clear input immediately
            input.value = '';
            input.focus();
            
            // Create optimistic message
            const optimisticMsg = {
                sender_id: {{ Auth::id() }},
                message: message,
                created_at: new Date().toISOString()
            };
            
            appendMessageToContainer(optimisticMsg, '{{ Auth::user()->name }}', 
                '{{ Auth::user()->profile_image ? asset("storage/" . Auth::user()->profile_image) : asset("images/default.jpeg") }}');
            
            // Send to server
            fetch('{{ route("chat.store") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Failed to send message');
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                input.value = message;
            });
            
            return false;
        }
        
        // ============================================
        // FETCH UNREAD MESSAGES (POLLING)
        // ============================================
        function fetchUnreadMessages() {
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
                        
                        updateSidebarChat(bookingId, patientName, msg.message, msg.created_at, patientImage);
                        
                        // If this is the current chat, add message and mark as read
                        if (currentBookingId == bookingId) {
                            appendMessageToContainer(msg, patientName, patientImage);
                            markMessagesAsRead(bookingId);
                        } else {
                            // Show notification
                            showNotification(patientName, msg.message, patientImage);
                        }
                    });
                }
            })
            .catch(error => console.error('Error fetching unread messages:', error));
        }
        
        // ============================================
        // UPDATE SIDEBAR CHAT
        // ============================================
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
                    const msgDate = new Date(time);
                    const timeString = msgDate.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                    timeEl.textContent = timeString;
                }
                
                // Update unread badge if not current chat
                if (currentBookingId != bookingId) {
                    let badge = chatItem.querySelector('.unread-badge');
                    const badgeContainer = chatItem.querySelector('.last-chat-time');
                    
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
                    
                    // Update unread count in data attribute
                    const currentUnread = parseInt(chatItem.dataset.unread || 0);
                    chatItem.dataset.unread = currentUnread + 1;
                }
            }
        }
        
        // ============================================
        // MARK MESSAGES AS READ
        // ============================================
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
                // Remove unread badge
                const chatItem = document.querySelector(`.chat-user-item[data-booking-id="${bookingId}"]`);
                if (chatItem) {
                    const badge = chatItem.querySelector('.unread-badge');
                    if (badge) badge.remove();
                    chatItem.dataset.unread = '0';
                }
            })
            .catch(error => console.error('Error marking messages as read:', error));
        }
        
        // ============================================
        // SHOW NOTIFICATION
        // ============================================
        function showNotification(patientName, message, patientImage) {
            // Play sound
            try {
                if (notificationSound) {
                    notificationSound.play().catch(e => console.log('Sound play failed:', e));
                }
            } catch (e) {
                console.log('Sound error:', e);
            }
            
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
                    <div class="message-toast-text">${escapeHtml(message)}</div>
                </div>
                <span class="message-toast-close" onclick="this.parentElement.remove()">&times;</span>
            `;
            
            document.body.appendChild(toast);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) toast.remove();
            }, 5000);
            
            // Update page title
            document.title = '🔴 New Message - Doctor Chat';
            
            // Reset title after 3 seconds if no more notifications
            setTimeout(() => {
                const hasUnread = document.querySelector('.unread-badge');
                if (!hasUnread) {
                    document.title = 'Doctor Chat';
                }
            }, 3000);
        }
        
        // ============================================
        // SHOW SIDEBAR ON MOBILE
        // ============================================
        function showSidebarOnMobile() {
            document.getElementById('chatSidebar').classList.remove('d-none');
            document.getElementById('chatMessages').classList.remove('d-block');
            document.getElementById('chatMessages').style.display = 'none';
            
            // Remove booking from URL
            const url = new URL(window.location);
            url.searchParams.delete('booking');
            window.history.pushState({}, '', url);
            
            // Clear current chat state
            currentBookingId = null;
            currentPatientId = null;
            
            // Disable input
            document.getElementById('messageInput').disabled = true;
            document.getElementById('sendMessageBtn').disabled = true;
        }
        
        // ============================================
        // SCROLL TO BOTTOM
        // ============================================
        function scrollToBottom() {
            const chatBody = document.getElementById('chatMessagesBody');
            if (chatBody) {
                setTimeout(() => {
                    chatBody.scrollTop = chatBody.scrollHeight;
                }, 50);
            }
        }
        
        // ============================================
        // START POLLING
        // ============================================
        function startPolling() {
            // Initial fetch
            fetchUnreadMessages();
            
            // Set up interval
            refreshInterval = setInterval(fetchUnreadMessages, 3000);
        }
        
        // ============================================
        // STOP POLLING
        // ============================================
        function stopPolling() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
                refreshInterval = null;
            }
        }
        
        // ============================================
        // INIT EMOJI PICKER
        // ============================================
        function initEmojiPicker() {
            const emojiToggle = document.querySelector('.emoji-toggle');
            if (emojiToggle) {
                emojiToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const emojiPanel = document.querySelector('.emoj-group-list-foot');
                    if (emojiPanel) {
                        emojiPanel.classList.toggle('d-none');
                    }
                });
            }
            
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
        }
        
        // ============================================
        // INIT SEARCH
        // ============================================
        function initSearch() {
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
        }
        
        // ============================================
        // ESCAPE HTML
        // ============================================
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // ============================================
        // WINDOW EVENT HANDLERS
        // ============================================
        
        // Handle popstate (back/forward buttons)
        window.addEventListener('popstate', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const bookingId = urlParams.get('booking');
            
            if (bookingId) {
                const chatItem = document.querySelector(`[data-booking-id="${bookingId}"]`);
                if (chatItem) {
                    const patientId = chatItem.dataset.patientId;
                    const patientName = chatItem.dataset.patientName;
                    const patientImage = chatItem.dataset.patientImage;
                    loadChat(bookingId, patientId, patientName, patientImage);
                }
            } else {
                // No booking ID, show sidebar on mobile
                if (window.innerWidth < 992) {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatMessages').style.display = 'none';
                    document.getElementById('chatMessages').classList.remove('d-block');
                }
                
                // Clear current chat state
                currentBookingId = null;
                currentPatientId = null;
                
                // Disable input
                document.getElementById('messageInput').disabled = true;
                document.getElementById('sendMessageBtn').disabled = true;
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                // Desktop: show both
                document.getElementById('chatSidebar').classList.remove('d-none');
                document.getElementById('chatMessages').style.display = 'block';
                document.getElementById('chatMessages').classList.add('d-block');
            } else {
                // Mobile: show based on current chat state
                if (currentBookingId) {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').style.display = 'block';
                    document.getElementById('chatMessages').classList.add('d-block');
                } else {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatMessages').style.display = 'none';
                    document.getElementById('chatMessages').classList.remove('d-block');
                }
            }
        });
        
        // Handle page visibility change
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                stopPolling();
            } else {
                startPolling();
                document.title = 'Doctor Chat';
            }
        });
        
        // Clean up on page unload
        window.addEventListener('beforeunload', function() {
            stopPolling();
        });
    </script>

    <!-- Add these routes to web.php -->
    <!--
    Route::get('/doctor/chat/messages/{bookingId}', function($bookingId) {
        $messages = App\Models\Chat::where('booking_id', $bookingId)
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json(['messages' => $messages]);
    })->middleware('auth');
    
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