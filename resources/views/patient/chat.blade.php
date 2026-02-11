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

                                        <ul class="user-list">
                                            @foreach ($patients as $bookingId => $chatMessages)
                                                @php
                                                    $firstMessage = $chatMessages->first();
                                                    $patient = $firstMessage->sender_id == Auth::id()
                                                        ? $firstMessage->receiver
                                                        : $firstMessage->sender;
                                                    $patientImage = $patient?->profile_image ? asset('storage/' . $patient->profile_image) : asset('images/default.jpeg');
                                                    $lastMessage = $chatMessages->last();
                                                    $unreadCount = $chatMessages->where('sender_id', $patient?->id)->where('receiver_id', Auth::id())->where('is_read', 0)->count();
                                                    $isActive = request()->get('booking') == $bookingId;
                                                @endphp

                                                <li class="user-list-item chat-user-item {{ $isActive ? 'active' : '' }}" 
                                                    data-booking-id="{{ $bookingId }}"
                                                    data-patient-id="{{ $patient?->id }}"
                                                    data-patient-name="{{ $patient?->name ?? 'Unknown Patient' }}"
                                                    data-patient-image="{{ $patientImage }}">
                                                    <a href="javascript:void(0);"
                                                       onclick="loadChat({{ $bookingId }}, {{ $patient?->id }}, '{{ $patient?->name ?? 'Unknown Patient' }}', '{{ $patientImage }}')">
                                                        <div class="avatar avatar-online">
                                                            <img src="{{ $patientImage }}" alt="{{ $patient?->name ?? 'Patient' }}">
                                                        </div>
                                                        <div class="users-list-body">
                                                            <div>
                                                                <h5>{{ $patient->name ?? 'Unknown Patient' }}</h5>
                                                                <p>{{ Str::limit($lastMessage->message ?? 'No messages yet', 30) }}</p>
                                                            </div>
                                                            <div class="last-chat-time">
                                                                <small class="text-muted">
                                                                    {{ $lastMessage->created_at?->format('h:i A') ?? '' }}
                                                                </small>
                                                                @if($unreadCount > 0)
                                                                    <div class="new-message-count">
                                                                        {{ $unreadCount }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        
                                        <!-- No results message -->
                                        <div id="noSearchResults" class="text-center text-muted p-4 d-none">
                                            <p>No chats found</p>
                                        </div>
                                        
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
                                                $currentBookingId = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking_id : null;
                                            @endphp
                                            <figure class="avatar avatar-online">
                                                <img id="currentPatientAvatar" src="{{ $currentPatientImage }}" alt="{{ $currentPatient?->name ?? 'Patient' }}">
                                            </figure>
                                            <div class="mt-1">
                                                <h5 id="currentPatientName">{{ $currentPatient?->name ?? 'Select a chat' }}</h5>
                                                <small class="last-seen" id="currentPatientStatus">
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
                                                    <div class="chats chats-right">
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
                                                    <div class="chats">
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
                                            <div class="text-center text-muted p-5">
                                                <p>No messages yet. Start the conversation!</p>
                                            </div>
                                        @endif

                                    </div>
                                    
                                    <!-- Typing indicator -->
                                    <div id="typingIndicator" class="typing-indicator d-none">
                                        <div class="chats">
                                            <div class="chat-avatar">
                                                <img id="typingPatientImage" src="{{ $currentPatientImage ?? asset('images/default.jpeg') }}" class="dreams_chat" alt="Patient">
                                            </div>
                                            <div class="chat-content">
                                                <div class="typing-dots">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="chat-footer">
                                <form onsubmit="sendMessage(event)" id="chatForm">
                                    @csrf

                                    <!-- Hidden fields -->
                                    @php
                                        $currentBooking = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking : null;
                                        $currentPatientId = $currentBooking?->patient?->id ?? '';
                                        $currentBookingId = $currentBooking?->id ?? '';
                                    @endphp
                                    <input type="hidden" name="receiver_id" id="receiverIdField" value="{{ $currentPatientId }}">
                                    <input type="hidden" name="booking_id" id="bookingIdField" value="{{ $currentBookingId }}">

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

    <!-- Voice Call Modal -->
    <div class="modal fade call-modal" id="voice_call">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Outgoing Call -->
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
                    <!-- Outgoing Call -->

                </div>
            </div>
        </div>
    </div>
    <!-- /Voice Call Modal -->

    <!-- Video Call Modal -->
    <div class="modal fade call-modal" id="video_call">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <!-- Incoming Call -->
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
                    <!-- /Incoming Call -->

                </div>
            </div>
        </div>
    </div>
    <!-- Video Call Modal -->

    <style>
        /* Typing indicator */
        .typing-dots {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 12px 16px;
            background: #f0f0f0;
            border-radius: 18px;
            width: fit-content;
        }
        
        .typing-dots span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #999;
            display: inline-block;
            animation: typing 1.4s infinite ease-in-out both;
        }
        
        .typing-dots span:nth-child(1) {
            animation-delay: -0.32s;
        }
        
        .typing-dots span:nth-child(2) {
            animation-delay: -0.16s;
        }
        
        @keyframes typing {
            0%, 80%, 100% { transform: scale(0.6); opacity: 0.6; }
            40% { transform: scale(1); opacity: 1; }
        }
        
        /* Active chat highlight */
        .user-list-item.active {
            background-color: rgba(13, 110, 253, 0.05);
            border-left: 3px solid #0d6efd;
        }
        
        .user-list-item.active h5 {
            color: #0d6efd;
        }
        
        /* Mobile styles */
        @media (max-width: 991.98px) {
            .chat_sidebar.d-none {
                display: none !important;
            }
            
            .chat-messages {
                display: block !important;
            }
            
            .chat-messages.d-none {
                display: none !important;
            }
        }
    </style>

    <script>
        // Store current chat state
        let currentBookingId = '{{ request()->get('booking') }}';
        let currentPatientId = '{{ $currentPatientId ?? '' }}';
        let currentPatientName = '{{ $currentPatient?->name ?? '' }}';
        let currentPatientImage = '{{ $currentPatientImage ?? asset('images/default.jpeg') }}';
        
        // Get current booking ID from URL
        function getCurrentBookingId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('booking');
        }

        // Function to load chat via AJAX
        function loadChat(bookingId, patientId, patientName, patientImage) {
            // Prevent default link behavior
            event?.preventDefault();
            
            // Update current state
            currentBookingId = bookingId;
            currentPatientId = patientId;
            currentPatientName = patientName;
            currentPatientImage = patientImage;
            
            // Update URL without page reload
            const url = new URL(window.location);
            url.searchParams.set('booking', bookingId);
            window.history.pushState({}, '', url);
            
            // Update header
            document.getElementById('currentPatientAvatar').src = patientImage;
            document.getElementById('currentPatientName').innerHTML = patientName;
            document.getElementById('currentPatientStatus').innerHTML = 'Online';
            document.getElementById('typingPatientImage').src = patientImage;
            
            // Update hidden fields
            document.getElementById('receiverIdField').value = patientId;
            document.getElementById('bookingIdField').value = bookingId;
            
            // Enable message input and send button
            document.getElementById('messageInput').disabled = false;
            document.getElementById('sendMessageBtn').disabled = false;
            
            // Show chat messages, hide sidebar on mobile
            if (window.innerWidth < 992) {
                document.getElementById('chatSidebar').classList.add('d-none');
                document.getElementById('chatMessages').style.display = 'block';
                document.getElementById('chatMessages').classList.remove('d-none');
            }
            
            // Remove active class from all chats
            document.querySelectorAll('.user-list-item').forEach(el => {
                el.classList.remove('active');
            });
            
            // Add active class to clicked chat
            const activeChat = document.querySelector(`[data-booking-id="${bookingId}"]`);
            if (activeChat) {
                activeChat.classList.add('active');
            }
            
            // Fetch messages for this booking
            fetch(`/doctor/chat/messages/${bookingId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                const messagesContainer = document.getElementById('messagesContainer');
                messagesContainer.innerHTML = '';
                
                if (data.messages && data.messages.length > 0) {
                    let lastDate = null;
                    
                    data.messages.forEach(msg => {
                        const msgDate = new Date(msg.created_at);
                        const dateStr = msgDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        const isToday = new Date(msg.created_at).toDateString() === new Date().toDateString();
                        const isYesterday = new Date(msg.created_at).toDateString() === new Date(Date.now() - 86400000).toDateString();
                        
                        // Add date divider
                        if (lastDate !== dateStr) {
                            const dateDiv = document.createElement('div');
                            dateDiv.className = 'chat-line';
                            let dateText = dateStr;
                            if (isToday) dateText = 'Today';
                            else if (isYesterday) dateText = 'Yesterday';
                            dateDiv.innerHTML = `<span class="chat-date">${dateText}</span>`;
                            messagesContainer.appendChild(dateDiv);
                            lastDate = dateStr;
                        }
                        
                        // Add message
                        const isCurrentUser = msg.sender_id == {{ Auth::id() }};
                        const messageDiv = document.createElement('div');
                        messageDiv.className = isCurrentUser ? 'chats chats-right' : 'chats';
                        
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
                                    <div class="message-content">${msg.message}</div>
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
                                    <div class="message-content">${msg.message}</div>
                                </div>
                            `;
                        }
                        
                        messagesContainer.appendChild(messageDiv);
                    });
                } else {
                    messagesContainer.innerHTML = '<div class="text-center text-muted p-5"><p>No messages yet. Start the conversation!</p></div>';
                }
                
                // Scroll to bottom
                const chatBody = document.getElementById('chatMessagesBody');
                if (chatBody) {
                    setTimeout(() => {
                        chatBody.scrollTop = chatBody.scrollHeight;
                    }, 100);
                }
                
                // Mark messages as read
                markMessagesAsRead(bookingId);
            })
            .catch(error => console.error('Error loading messages:', error));
            
            // Re-initialize Echo for new booking
            if (window.Echo) {
                initializeEcho(bookingId);
            }
        }

        // Function to mark messages as read
        function markMessagesAsRead(bookingId) {
            fetch(`/doctor/chat/mark-read/${bookingId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update unread count in sidebar
                const chatItem = document.querySelector(`[data-booking-id="${bookingId}"]`);
                if (chatItem) {
                    const badge = chatItem.querySelector('.new-message-count');
                    if (badge) {
                        badge.remove();
                    }
                }
            })
            .catch(error => console.error('Error marking messages as read:', error));
        }

        // Function to send message via AJAX
        function sendMessage(event) {
            event.preventDefault();
            
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();
            
            if (!message || !currentBookingId || !currentPatientId) {
                return false;
            }
            
            const formData = new FormData();
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('receiver_id', currentPatientId);
            formData.append('booking_id', currentBookingId);
            formData.append('message', message);
            
            // Clear input immediately
            messageInput.value = '';
            messageInput.focus();
            
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
                if (data.success) {
                    // Message will appear via Echo
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                // Put message back on error
                messageInput.value = message;
            });
            
            return false;
        }

        // Function to show sidebar on mobile
        function showSidebarOnMobile() {
            document.getElementById('chatSidebar').classList.remove('d-none');
            document.getElementById('chatMessages').style.display = 'none';
            document.getElementById('chatMessages').classList.add('d-none');
            
            // Remove booking from URL
            const url = new URL(window.location);
            url.searchParams.delete('booking');
            window.history.pushState({}, '', url);
            
            currentBookingId = null;
        }

        // Initialize Echo for real-time messages
        function initializeEcho(bookingId) {
            if (window.Echo && bookingId) {
                // Leave previous channel
                if (window.currentChannel) {
                    window.currentChannel.stopListening('.MessageSent');
                    window.Echo.leave(`chat.${window.currentBookingId}`);
                }
                
                window.currentBookingId = bookingId;
                
                // Listen for messages
                window.currentChannel = window.Echo.channel(`chat.${bookingId}`);
                window.currentChannel.listen('.MessageSent', (e) => {
                    const messagesContainer = document.getElementById('messagesContainer');
                    if (messagesContainer && e.message.booking_id == currentBookingId) {
                        const isCurrentUser = e.message.sender_id === {{ Auth::id() }};
                        
                        // Remove "No messages" placeholder if exists
                        const noMessages = messagesContainer.querySelector('.text-center.text-muted.p-5');
                        if (noMessages) {
                            noMessages.remove();
                        }
                        
                        const messageDiv = document.createElement('div');
                        messageDiv.className = isCurrentUser ? 'chats chats-right' : 'chats';
                        
                        const now = new Date();
                        const timeString = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                        
                        const senderName = isCurrentUser ? '{{ Auth::user()->name }}' : currentPatientName;
                        const senderImage = isCurrentUser 
                            ? '{{ Auth::user()->profile_image ? asset("storage/" . Auth::user()->profile_image) : asset("images/default.jpeg") }}'
                            : currentPatientImage;
                        
                        if (isCurrentUser) {
                            messageDiv.innerHTML = `
                                <div class="chat-content">
                                    <div class="chat-profile-name text-end justify-content-end">
                                        <h6>${senderName} <span>${timeString}</span></h6>
                                    </div>
                                    <div class="message-content">${e.message.message}</div>
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
                                    <div class="message-content">${e.message.message}</div>
                                </div>
                            `;
                        }
                        
                        messagesContainer.appendChild(messageDiv);
                        
                        // Scroll to bottom
                        const chatBody = document.getElementById('chatMessagesBody');
                        if (chatBody) {
                            chatBody.scrollTop = chatBody.scrollHeight;
                        }
                        
                        // Mark as read if it's from patient
                        if (!isCurrentUser) {
                            markMessagesAsRead(currentBookingId);
                        }
                    }
                });
            }
        }

        // On page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlBookingId = getCurrentBookingId();
            
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Check if we're on mobile
            if (window.innerWidth < 992) {
                if (urlBookingId) {
                    // Find the chat item and load it
                    const activeChat = document.querySelector(`[data-booking-id="${urlBookingId}"]`);
                    if (activeChat) {
                        const patientId = activeChat.dataset.patientId;
                        const patientName = activeChat.dataset.patientName;
                        const patientImage = activeChat.dataset.patientImage;
                        loadChat(urlBookingId, patientId, patientName, patientImage);
                    }
                }
            }
            
            // Scroll to bottom of messages
            const chatBody = document.getElementById('chatMessagesBody');
            if (chatBody) {
                chatBody.scrollTop = chatBody.scrollHeight;
            }
            
            // Initialize Echo if booking exists
            if (urlBookingId && window.Echo) {
                setTimeout(() => {
                    initializeEcho(urlBookingId);
                }, 500);
            }
            
            // Chat search functionality
            const searchInput = document.getElementById('chatSearchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const chatItems = document.querySelectorAll('.user-list-item');
                    let visibleCount = 0;
                    
                    chatItems.forEach(item => {
                        const patientName = item.querySelector('h5')?.textContent.toLowerCase() || '';
                        const lastMessage = item.querySelector('p')?.textContent.toLowerCase() || '';
                        
                        if (patientName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
                            item.classList.remove('d-none');
                            visibleCount++;
                        } else {
                            item.classList.add('d-none');
                        }
                    });
                    
                    const noResults = document.getElementById('noSearchResults');
                    if (noResults) {
                        if (visibleCount === 0) {
                            noResults.classList.remove('d-none');
                        } else {
                            noResults.classList.add('d-none');
                        }
                    }
                });
            }
            
            // Emoji toggle
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
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                // Desktop: show both
                document.getElementById('chatSidebar').classList.remove('d-none');
                document.getElementById('chatMessages').style.display = 'block';
                document.getElementById('chatMessages').classList.remove('d-none');
            } else {
                // Mobile: show based on selection
                if (currentBookingId) {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').style.display = 'block';
                    document.getElementById('chatMessages').classList.remove('d-none');
                } else {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatMessages').style.display = 'none';
                    document.getElementById('chatMessages').classList.add('d-none');
                }
            }
        });

        // Handle browser back/forward
        window.addEventListener('popstate', function() {
            const bookingId = getCurrentBookingId();
            
            if (bookingId) {
                const chatItem = document.querySelector(`[data-booking-id="${bookingId}"]`);
                if (chatItem) {
                    const patientId = chatItem.dataset.patientId;
                    const patientName = chatItem.dataset.patientName;
                    const patientImage = chatItem.dataset.patientImage;
                    loadChat(bookingId, patientId, patientName, patientImage);
                }
            } else {
                if (window.innerWidth < 992) {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatMessages').style.display = 'none';
                    document.getElementById('chatMessages').classList.add('d-none');
                }
                currentBookingId = null;
            }
        });
    </script>

    <script type="module">
        import Echo from 'laravel-echo';
        window.Pusher = require('pusher-js');

        // Echo instance
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: import.meta.env.VITE_PUSHER_APP_KEY || 'local',
            wsHost: import.meta.env.VITE_PUSHER_HOST || '127.0.0.1',
            wsPort: import.meta.env.VITE_PUSHER_PORT || 6001,
            forceTLS: false,
            disableStats: true,
        });
        
        // Initialize Echo if booking exists
        const initialBookingId = document.querySelector('input[name="booking_id"]')?.value;
        if (initialBookingId && window.initializeEcho) {
            setTimeout(() => {
                window.initializeEcho(initialBookingId);
            }, 500);
        }
    </script>

    <!-- Add these routes to your web.php -->
    <!--
    Route::get('/doctor/chat/messages/{bookingId}', function($bookingId) {
        $messages = App\Models\Chat::where('booking_id', $bookingId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
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