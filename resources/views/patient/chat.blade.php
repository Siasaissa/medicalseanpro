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

                                                @if($patient)
                                                    <li class="user-list-item chat-user-item {{ $isActive ? 'active' : '' }}" 
                                                        data-booking-id="{{ $bookingId }}"
                                                        data-patient-id="{{ $patient->id }}"
                                                        data-patient-name="{{ $patient->name }}"
                                                        data-patient-image="{{ $patientImage }}">
                                                        <div onclick="loadChat({{ $bookingId }}, {{ $patient->id }}, '{{ addslashes($patient->name) }}', '{{ $patientImage }}')" style="cursor: pointer; display: flex; width: 100%; padding: 10px;">
                                                            <div class="avatar avatar-online">
                                                                <img src="{{ $patientImage }}" alt="{{ $patient->name }}" width="48" height="48" style="border-radius: 50%;">
                                                            </div>
                                                            <div class="users-list-body" style="flex: 1; margin-left: 10px;">
                                                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                                                    <h5 style="margin: 0; font-weight: 600;">{{ $patient->name }}</h5>
                                                                    <small class="text-muted" style="white-space: nowrap;">
                                                                        {{ $lastMessage->created_at?->format('h:i A') ?? '' }}
                                                                    </small>
                                                                </div>
                                                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px;">
                                                                    <p style="margin: 0; color: #6c757d; font-size: 14px; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                        {{ Str::limit($lastMessage->message ?? 'No messages yet', 30) }}
                                                                    </p>
                                                                    @if($unreadCount > 0)
                                                                        <span style="background-color: #0d6efd; color: white; border-radius: 50%; padding: 2px 8px; font-size: 12px; font-weight: 600;">
                                                                            {{ $unreadCount }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        
                                        <!-- No results message -->
                                        <div id="noSearchResults" class="text-center text-muted p-4" style="display: none;">
                                            <p>No chats found</p>
                                        </div>
                                        
                                    </div>

                                </div>

                            </div>
                            <!-- / Chats sidebar -->
                        </div>
                        <!-- /Sidebar group -->

                        <!-- Chat -->
                        <div class="chat chat-messages" id="chatMessages" style="{{ !request()->get('booking') ? 'display: none;' : 'display: block;' }}">
                            <div class="slimscroll">
                                <div class="chat-inner-header">
                                    <div class="chat-header">
                                        <div class="user-details" style="display: flex; align-items: center;">
                                            <div class="d-lg-none" style="margin-right: 10px;">
                                                <a class="text-muted" href="javascript:void(0);" onclick="showSidebarOnMobile()" style="font-size: 20px;">
                                                    <i class="fas fa-arrow-left"></i>
                                                </a>
                                            </div>
                                            @php
                                                $currentPatient = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking?->patient : null;
                                                $currentPatientImage = $currentPatient?->profile_image ? asset('storage/' . $currentPatient->profile_image) : asset('images/default.jpeg');
                                                $currentBookingId = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking_id : null;
                                            @endphp
                                            <figure class="avatar avatar-online" style="margin-right: 10px;">
                                                <img id="currentPatientAvatar" src="{{ $currentPatientImage }}" alt="{{ $currentPatient?->name ?? 'Patient' }}" width="48" height="48" style="border-radius: 50%;">
                                            </figure>
                                            <div>
                                                <h5 id="currentPatientName" style="margin: 0; font-weight: 600;">{{ $currentPatient?->name ?? 'Select a chat' }}</h5>
                                                <small class="last-seen" id="currentPatientStatus" style="color: #6c757d;">
                                                    {{ $currentPatient ? 'Online' : '' }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="chat-options">
                                            <ul class="list-inline" style="margin: 0; display: flex; list-style: none;">
                                                <li style="margin-right: 5px;">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-light"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Search" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-outline-light" href="#"
                                                        data-bs-toggle="dropdown" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
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
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal"
                                                            data-bs-target="#change-chat">Delete Chat</a>
                                                        <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal"
                                                            data-bs-target="#block-user">Block</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="chat-body" id="chatMessagesBody" style="height: calc(100vh - 250px); overflow-y: auto; padding: 20px; background-color: #f8f9fa;">

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
                                                    <div style="display: flex; justify-content: center; margin: 20px 0;">
                                                        <span style="background-color: #e9ecef; color: #6c757d; padding: 5px 15px; border-radius: 20px; font-size: 12px;">
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
                                                    <div style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
                                                        <div style="display: flex; align-items: flex-end;">
                                                            <div style="text-align: right; margin-right: 10px;">
                                                                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 5px;">
                                                                    <small style="color: #6c757d; margin-right: 10px;">{{ $msg->created_at->format('h:i A') }}</small>
                                                                    <h6 style="margin: 0; font-weight: 600;">{{ $senderName }}</h6>
                                                                </div>
                                                                <div style="background-color: #0d6efd; color: white; padding: 12px 16px; border-radius: 18px 18px 0 18px; max-width: 400px; word-wrap: break-word; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                                                    {{ $msg->message }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <img src="{{ $senderImage }}" alt="{{ $senderName }}" width="36" height="36" style="border-radius: 50%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    {{-- Patient message (left side) --}}
                                                    <div style="display: flex; margin-bottom: 15px;">
                                                        <div style="display: flex; align-items: flex-end;">
                                                            <div style="margin-right: 10px;">
                                                                <img src="{{ $senderImage }}" alt="{{ $senderName }}" width="36" height="36" style="border-radius: 50%;">
                                                            </div>
                                                            <div>
                                                                <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                                                    <h6 style="margin: 0; font-weight: 600; margin-right: 10px;">{{ $senderName }}</h6>
                                                                    <small style="color: #6c757d;">{{ $msg->created_at->format('h:i A') }}</small>
                                                                </div>
                                                                <div style="background-color: white; padding: 12px 16px; border-radius: 18px 18px 18px 0; max-width: 400px; word-wrap: break-word; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #dee2e6;">
                                                                    {{ $msg->message }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div style="text-align: center; color: #6c757d; padding: 50px;">
                                                <p>No messages yet. Start the conversation!</p>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                            </div>
                            
                            <div class="chat-footer" style="border-top: 1px solid #dee2e6; padding: 15px; background-color: white;">
                                <form onsubmit="sendMessage(event)" id="chatForm" style="display: flex; align-items: center; gap: 10px;">
                                    @csrf

                                    <!-- Hidden fields -->
                                    @php
                                        $currentBooking = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking : null;
                                        $currentPatientId = $currentBooking?->patient?->id ?? '';
                                        $currentBookingId = $currentBooking?->id ?? '';
                                    @endphp
                                    <input type="hidden" name="receiver_id" id="receiverIdField" value="{{ $currentPatientId }}">
                                    <input type="hidden" name="booking_id" id="bookingIdField" value="{{ $currentBookingId }}">

                                    <!-- Attachment -->
                                    <div class="dropdown">
                                        <button class="btn btn-light" type="button" data-bs-toggle="dropdown" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa-solid fa-paperclip"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item"><i class="fa-solid fa-file-lines me-2"></i>Document</a>
                                            <a href="#" class="dropdown-item"><i class="fa-solid fa-camera me-2"></i>Camera</a>
                                            <a href="#" class="dropdown-item"><i class="fa-solid fa-image me-2"></i>Gallery</a>
                                            <a href="#" class="dropdown-item"><i class="fa-solid fa-volume-high me-2"></i>Audio</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item"><i class="fa-solid fa-location-dot me-2"></i>Location</a>
                                            <a href="#" class="dropdown-item"><i class="fa-solid fa-user me-2"></i>Contact</a>
                                        </div>
                                    </div>

                                    <!-- Emoji -->
                                    <div class="dropdown">
                                        <button class="btn btn-light emoji-toggle" type="button" data-bs-toggle="dropdown" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa-regular fa-face-smile"></i>
                                        </button>
                                        <div class="dropdown-menu p-2" style="min-width: 200px;">
                                            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                <a href="javascript:void(0);" class="text-decoration-none" data-emoji="😊" style="font-size: 24px;">😊</a>
                                                <a href="javascript:void(0);" class="text-decoration-none" data-emoji="😂" style="font-size: 24px;">😂</a>
                                                <a href="javascript:void(0);" class="text-decoration-none" data-emoji="❤️" style="font-size: 24px;">❤️</a>
                                                <a href="javascript:void(0);" class="text-decoration-none" data-emoji="👍" style="font-size: 24px;">👍</a>
                                                <a href="javascript:void(0);" class="text-decoration-none" data-emoji="🎉" style="font-size: 24px;">🎉</a>
                                                <a href="javascript:void(0);" class="text-decoration-none" data-emoji="😢" style="font-size: 24px;">😢</a>
                                                <a href="javascript:void(0);" class="text-decoration-none" data-emoji="😎" style="font-size: 24px;">😎</a>
                                                <a href="javascript:void(0);" class="text-decoration-none" data-emoji="🔥" style="font-size: 24px;">🔥</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Microphone -->
                                    <button class="btn btn-light" type="button" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-microphone"></i>
                                    </button>

                                    <!-- Message input -->
                                    <input type="text" name="message" class="form-control" id="messageInput"
                                        placeholder="Type your message here..." autocomplete="off" required
                                        style="flex: 1; height: 40px; border-radius: 20px; padding: 0 15px;"
                                        {{ !$currentPatientId ? 'disabled' : '' }}>

                                    <!-- Send button -->
                                    <button class="btn btn-primary" type="submit" id="sendMessageBtn" 
                                        style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                        {{ !$currentPatientId ? 'disabled' : '' }}>
                                        <i class="fa-regular fa-paper-plane"></i>
                                    </button>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="mb-4">
                        <img alt="User Image" src="{{asset('images/doctor-thumb-02.jpg')}}"
                            class="rounded-circle mb-3" width="100" height="100">
                        <h4 class="fw-bold" id="callPatientName">Darren Elder</h4>
                        <span class="text-muted">Connecting...</span>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-danger rounded-circle p-3" data-bs-dismiss="modal">
                            <i class="material-icons">call_end</i>
                        </button>
                        <a href="voice-call.html" class="btn btn-success rounded-circle p-3">
                            <i class="material-icons">call</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Call Modal -->
    <div class="modal fade call-modal" id="video_call">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="mb-4">
                        <img alt="User Image" src="{{asset('images/doctor-thumb-02.jpg')}}"
                            class="rounded-circle mb-3" width="100" height="100">
                        <h4 class="fw-bold" id="videoCallPatientName">Darren Elder</h4>
                        <span class="text-muted">Calling...</span>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-danger rounded-circle p-3" data-bs-dismiss="modal">
                            <i class="material-icons">call_end</i>
                        </button>
                        <a href="video-call.html" class="btn btn-success rounded-circle p-3">
                            <i class="material-icons">videocam</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ============================================
        // DOCTOR CHAT SYSTEM - COMPLETE SOLUTION
        // ============================================
        
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

        // ============================================
        // MAIN FUNCTION: Load chat WITHOUT page reload
        // ============================================
        function loadChat(bookingId, patientId, patientName, patientImage) {
            console.log('Loading chat:', bookingId, patientId, patientName);
            
            // CRITICAL: Prevent any default behavior and stop propagation
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            // Update current state
            currentBookingId = bookingId;
            currentPatientId = patientId;
            currentPatientName = patientName;
            currentPatientImage = patientImage;
            
            // Update URL without page reload
            try {
                const url = new URL(window.location);
                url.searchParams.set('booking', bookingId);
                window.history.pushState({}, '', url);
            } catch (e) {
                console.error('URL update error:', e);
            }
            
            // Update header with patient info
            const avatarEl = document.getElementById('currentPatientAvatar');
            const nameEl = document.getElementById('currentPatientName');
            const statusEl = document.getElementById('currentPatientStatus');
            const typingImgEl = document.getElementById('typingPatientImage');
            
            if (avatarEl) avatarEl.src = patientImage;
            if (nameEl) nameEl.innerHTML = patientName;
            if (statusEl) statusEl.innerHTML = 'Online';
            if (typingImgEl) typingImgEl.src = patientImage;
            
            // Update hidden form fields
            const receiverField = document.getElementById('receiverIdField');
            const bookingField = document.getElementById('bookingIdField');
            const messageInput = document.getElementById('messageInput');
            const sendBtn = document.getElementById('sendMessageBtn');
            
            if (receiverField) receiverField.value = patientId;
            if (bookingField) bookingField.value = bookingId;
            if (messageInput) {
                messageInput.disabled = false;
                messageInput.focus();
            }
            if (sendBtn) sendBtn.disabled = false;
            
            // MOBILE: Hide sidebar, show chat
            if (window.innerWidth < 992) {
                const sidebar = document.getElementById('chatSidebar');
                const chatMessages = document.getElementById('chatMessages');
                if (sidebar) sidebar.classList.add('d-none');
                if (chatMessages) {
                    chatMessages.style.display = 'block';
                    chatMessages.classList.remove('d-none');
                }
            }
            
            // Update active state in sidebar
            document.querySelectorAll('.user-list-item').forEach(el => {
                el.classList.remove('active');
            });
            const activeChat = document.querySelector(`[data-booking-id="${bookingId}"]`);
            if (activeChat) {
                activeChat.classList.add('active');
            }
            
            // ============================================
            // FETCH MESSAGES VIA AJAX - NO PAGE RELOAD
            // ============================================
            const token = document.querySelector('input[name="_token"]')?.value || '';
            
            fetch(`/doctor/chat/messages/${bookingId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                const messagesContainer = document.getElementById('messagesContainer');
                if (!messagesContainer) return;
                
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
                            dateDiv.style.display = 'flex';
                            dateDiv.style.justifyContent = 'center';
                            dateDiv.style.margin = '20px 0';
                            
                            let dateText = dateStr;
                            if (isToday) dateText = 'Today';
                            else if (isYesterday) dateText = 'Yesterday';
                            
                            dateDiv.innerHTML = `<span style="background-color: #e9ecef; color: #6c757d; padding: 5px 15px; border-radius: 20px; font-size: 12px;">${dateText}</span>`;
                            messagesContainer.appendChild(dateDiv);
                            lastDate = dateStr;
                        }
                        
                        // Add message
                        const isCurrentUser = msg.sender_id == {{ Auth::id() }};
                        const messageDiv = document.createElement('div');
                        
                        const timeString = msgDate.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                        const senderName = isCurrentUser ? '{{ Auth::user()->name }}' : patientName;
                        const senderImage = isCurrentUser 
                            ? '{{ Auth::user()->profile_image ? asset("storage/" . Auth::user()->profile_image) : asset("images/default.jpeg") }}'
                            : patientImage;
                        
                        if (isCurrentUser) {
                            // Doctor message - right side
                            messageDiv.style.display = 'flex';
                            messageDiv.style.justifyContent = 'flex-end';
                            messageDiv.style.marginBottom = '15px';
                            
                            messageDiv.innerHTML = `
                                <div style="display: flex; align-items: flex-end;">
                                    <div style="text-align: right; margin-right: 10px;">
                                        <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 5px;">
                                            <small style="color: #6c757d; margin-right: 10px;">${timeString}</small>
                                            <h6 style="margin: 0; font-weight: 600;">${senderName}</h6>
                                        </div>
                                        <div style="background-color: #0d6efd; color: white; padding: 12px 16px; border-radius: 18px 18px 0 18px; max-width: 400px; word-wrap: break-word; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                            ${msg.message}
                                        </div>
                                    </div>
                                    <div>
                                        <img src="${senderImage}" alt="${senderName}" width="36" height="36" style="border-radius: 50%;">
                                    </div>
                                </div>
                            `;
                        } else {
                            // Patient message - left side
                            messageDiv.style.display = 'flex';
                            messageDiv.style.marginBottom = '15px';
                            
                            messageDiv.innerHTML = `
                                <div style="display: flex; align-items: flex-end;">
                                    <div style="margin-right: 10px;">
                                        <img src="${senderImage}" alt="${senderName}" width="36" height="36" style="border-radius: 50%;">
                                    </div>
                                    <div>
                                        <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                            <h6 style="margin: 0; font-weight: 600; margin-right: 10px;">${senderName}</h6>
                                            <small style="color: #6c757d;">${timeString}</small>
                                        </div>
                                        <div style="background-color: white; padding: 12px 16px; border-radius: 18px 18px 18px 0; max-width: 400px; word-wrap: break-word; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #dee2e6;">
                                            ${msg.message}
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        
                        messagesContainer.appendChild(messageDiv);
                    });
                } else {
                    messagesContainer.innerHTML = '<div style="text-align: center; color: #6c757d; padding: 50px;"><p>No messages yet. Start the conversation!</p></div>';
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
            .catch(error => {
                console.error('Error loading messages:', error);
            });
            
            // Re-initialize Echo for new booking
            if (window.Echo) {
                initializeEcho(bookingId);
            }
            
            return false; // CRITICAL: Prevent any default behavior
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
                // Update unread count in sidebar
                const chatItem = document.querySelector(`[data-booking-id="${bookingId}"]`);
                if (chatItem) {
                    const badge = chatItem.querySelector('.new-message-count, span[style*="background-color: #0d6efd"]');
                    if (badge) {
                        badge.remove();
                    }
                }
            })
            .catch(error => console.error('Error marking messages as read:', error));
        }

        // Send message via AJAX
        function sendMessage(event) {
            event.preventDefault();
            
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();
            
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
                if (!data.success) {
                    console.error('Error sending message');
                    messageInput.value = message;
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                messageInput.value = message;
            });
            
            return false;
        }

        // Show sidebar on mobile
        function showSidebarOnMobile() {
            const sidebar = document.getElementById('chatSidebar');
            const chatMessages = document.getElementById('chatMessages');
            
            if (sidebar) sidebar.classList.remove('d-none');
            if (chatMessages) {
                chatMessages.style.display = 'none';
                chatMessages.classList.add('d-none');
            }
            
            // Remove booking from URL
            try {
                const url = new URL(window.location);
                url.searchParams.delete('booking');
                window.history.pushState({}, '', url);
            } catch (e) {}
            
            currentBookingId = null;
        }

        // Initialize Echo
        function initializeEcho(bookingId) {
            if (!window.Echo || !bookingId) return;
            
            try {
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
                    if (!messagesContainer || e.message.booking_id != currentBookingId) return;
                    
                    const isCurrentUser = e.message.sender_id === {{ Auth::id() }};
                    
                    // Remove "No messages" placeholder
                    const noMessages = messagesContainer.querySelector('div[style*="text-align: center"]');
                    if (noMessages) noMessages.remove();
                    
                    const messageDiv = document.createElement('div');
                    
                    const now = new Date();
                    const timeString = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                    
                    const senderName = isCurrentUser ? '{{ Auth::user()->name }}' : currentPatientName;
                    const senderImage = isCurrentUser 
                        ? '{{ Auth::user()->profile_image ? asset("storage/" . Auth::user()->profile_image) : asset("images/default.jpeg") }}'
                        : currentPatientImage;
                    
                    if (isCurrentUser) {
                        // Doctor message - right side
                        messageDiv.style.display = 'flex';
                        messageDiv.style.justifyContent = 'flex-end';
                        messageDiv.style.marginBottom = '15px';
                        
                        messageDiv.innerHTML = `
                            <div style="display: flex; align-items: flex-end;">
                                <div style="text-align: right; margin-right: 10px;">
                                    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 5px;">
                                        <small style="color: #6c757d; margin-right: 10px;">${timeString}</small>
                                        <h6 style="margin: 0; font-weight: 600;">${senderName}</h6>
                                    </div>
                                    <div style="background-color: #0d6efd; color: white; padding: 12px 16px; border-radius: 18px 18px 0 18px; max-width: 400px; word-wrap: break-word; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                        ${e.message.message}
                                    </div>
                                </div>
                                <div>
                                    <img src="${senderImage}" alt="${senderName}" width="36" height="36" style="border-radius: 50%;">
                                </div>
                            </div>
                        `;
                    } else {
                        // Patient message - left side
                        messageDiv.style.display = 'flex';
                        messageDiv.style.marginBottom = '15px';
                        
                        messageDiv.innerHTML = `
                            <div style="display: flex; align-items: flex-end;">
                                <div style="margin-right: 10px;">
                                    <img src="${senderImage}" alt="${senderName}" width="36" height="36" style="border-radius: 50%;">
                                </div>
                                <div>
                                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                        <h6 style="margin: 0; font-weight: 600; margin-right: 10px;">${senderName}</h6>
                                        <small style="color: #6c757d;">${timeString}</small>
                                    </div>
                                    <div style="background-color: white; padding: 12px 16px; border-radius: 18px 18px 18px 0; max-width: 400px; word-wrap: break-word; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #dee2e6;">
                                        ${e.message.message}
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    
                    messagesContainer.appendChild(messageDiv);
                    
                    // Scroll to bottom
                    const chatBody = document.getElementById('chatMessagesBody');
                    if (chatBody) {
                        chatBody.scrollTop = chatBody.scrollHeight;
                    }
                    
                    // Mark as read if from patient
                    if (!isCurrentUser) {
                        markMessagesAsRead(currentBookingId);
                    }
                });
            } catch (e) {
                console.error('Echo error:', e);
            }
        }

        // ============================================
        // PAGE LOAD INITIALIZATION
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            const urlBookingId = getCurrentBookingId();
            
            // Initialize tooltips
            try {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            } catch (e) {}
            
            // Check if there's a booking ID in URL
            if (urlBookingId) {
                const activeChat = document.querySelector(`[data-booking-id="${urlBookingId}"]`);
                if (activeChat) {
                    const patientId = activeChat.dataset.patientId;
                    const patientName = activeChat.dataset.patientName;
                    const patientImage = activeChat.dataset.patientImage;
                    
                    // Directly call loadChat without waiting for click
                    setTimeout(() => {
                        loadChat(urlBookingId, patientId, patientName, patientImage);
                    }, 100);
                }
            } else {
                // No booking selected, show sidebar on mobile
                if (window.innerWidth < 992) {
                    const chatMessages = document.getElementById('chatMessages');
                    if (chatMessages) {
                        chatMessages.style.display = 'none';
                        chatMessages.classList.add('d-none');
                    }
                }
            }
            
            // Chat search functionality
            const searchInput = document.getElementById('chatSearchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const chatItems = document.querySelectorAll('.user-list-item');
                    let visibleCount = 0;
                    
                    chatItems.forEach(item => {
                        const nameEl = item.querySelector('h5');
                        const msgEl = item.querySelector('p');
                        
                        const patientName = nameEl?.textContent.toLowerCase() || '';
                        const lastMessage = msgEl?.textContent.toLowerCase() || '';
                        
                        if (patientName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
                            item.style.display = '';
                            visibleCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });
                    
                    const noResults = document.getElementById('noSearchResults');
                    if (noResults) {
                        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
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
                const sidebar = document.getElementById('chatSidebar');
                const chatMessages = document.getElementById('chatMessages');
                
                if (sidebar) sidebar.classList.remove('d-none');
                if (chatMessages) {
                    chatMessages.style.display = 'block';
                    chatMessages.classList.remove('d-none');
                }
            } else {
                // Mobile: show based on selection
                if (currentBookingId) {
                    const sidebar = document.getElementById('chatSidebar');
                    const chatMessages = document.getElementById('chatMessages');
                    
                    if (sidebar) sidebar.classList.add('d-none');
                    if (chatMessages) {
                        chatMessages.style.display = 'block';
                        chatMessages.classList.remove('d-none');
                    }
                } else {
                    const sidebar = document.getElementById('chatSidebar');
                    const chatMessages = document.getElementById('chatMessages');
                    
                    if (sidebar) sidebar.classList.remove('d-none');
                    if (chatMessages) {
                        chatMessages.style.display = 'none';
                        chatMessages.classList.add('d-none');
                    }
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
                    const sidebar = document.getElementById('chatSidebar');
                    const chatMessages = document.getElementById('chatMessages');
                    
                    if (sidebar) sidebar.classList.remove('d-none');
                    if (chatMessages) {
                        chatMessages.style.display = 'none';
                        chatMessages.classList.add('d-none');
                    }
                }
                currentBookingId = null;
            }
        });
    </script>

    <script type="module">
        import Echo from 'laravel-echo';
        window.Pusher = require('pusher-js');

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: import.meta.env.VITE_PUSHER_APP_KEY || 'local',
            wsHost: import.meta.env.VITE_PUSHER_HOST || '127.0.0.1',
            wsPort: import.meta.env.VITE_PUSHER_PORT || 6001,
            forceTLS: false,
            disableStats: true,
        });
        
        // Initialize Echo if booking exists
        setTimeout(() => {
            if (window.currentBookingId && window.initializeEcho) {
                window.initializeEcho(window.currentBookingId);
            }
        }, 1000);
    </script>

    <!-- ADD THESE ROUTES TO web.php -->
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