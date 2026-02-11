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

                    <div class="chat-sec" style="display: flex; height: calc(100vh - 100px);">

                        <!-- SIDEBAR - CHAT LIST -->
                        <div class="chat_sidebar" id="chatSidebar" style="width: 350px; border-right: 1px solid #dee2e6; overflow-y: auto; background: white;">
                            
                            <div style="padding: 20px;">
                                <h4 style="margin-bottom: 20px;">All Chats</h4>
                                
                                <!-- Search -->
                                <div style="margin-bottom: 20px;">
                                    <input type="text" id="chatSearchInput" placeholder="Search" style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 5px;">
                                </div>
                                
                                <h6 style="margin-bottom: 15px; font-weight: 600;">Recent Chat</h6>
                                
                                <ul style="list-style: none; padding: 0; margin: 0;" id="chatUserList">
                                    @foreach ($patients as $bookingId => $chatMessages)
                                        @php
                                            $firstMessage = $chatMessages->first();
                                            $patient = $firstMessage->sender_id == Auth::id() ? $firstMessage->receiver : $firstMessage->sender;
                                            $patientImage = $patient?->profile_image ? asset('storage/' . $patient->profile_image) : asset('images/default.jpeg');
                                            $lastMessage = $chatMessages->last();
                                            $unreadCount = $chatMessages->where('sender_id', $patient?->id)->where('receiver_id', Auth::id())->where('is_read', 0)->count();
                                        @endphp
                                        
                                        @if($patient)
                                            <li class="chat-item" 
                                                data-booking-id="{{ $bookingId }}"
                                                data-patient-id="{{ $patient->id }}"
                                                data-patient-name="{{ $patient->name }}"
                                                data-patient-image="{{ $patientImage }}"
                                                onclick="openChat(this)"
                                                style="padding: 10px; margin-bottom: 5px; border-radius: 5px; cursor: pointer; display: flex; align-items: center; {{ request()->get('booking') == $bookingId ? 'background-color: #e3f2fd;' : '' }}"
                                                onmouseover="this.style.backgroundColor='#f8f9fa'"
                                                onmouseout="this.style.backgroundColor='{{ request()->get('booking') == $bookingId ? '#e3f2fd' : 'transparent' }}'">
                                                
                                                <img src="{{ $patientImage }}" style="width: 48px; height: 48px; border-radius: 50%; margin-right: 12px;">
                                                
                                                <div style="flex: 1;">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <h5 style="margin: 0; font-size: 16px; font-weight: 600;">{{ $patient->name }}</h5>
                                                        <small style="color: #6c757d;">{{ $lastMessage->created_at?->format('h:i A') ?? '' }}</small>
                                                    </div>
                                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px;">
                                                        <p style="margin: 0; color: #6c757d; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                                            {{ Str::limit($lastMessage->message ?? 'No messages yet', 30) }}
                                                        </p>
                                                        @if($unreadCount > 0)
                                                            <span style="background: #0d6efd; color: white; border-radius: 50%; padding: 2px 8px; font-size: 12px; font-weight: 600;">{{ $unreadCount }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                
                                <div id="noSearchResults" style="display: none; text-align: center; padding: 40px; color: #6c757d;">
                                    <p>No chats found</p>
                                </div>
                            </div>
                        </div>

                        <!-- CHAT AREA -->
                        <div id="chatMessages" style="flex: 1; display: {{ request()->get('booking') ? 'flex' : 'none' }}; flex-direction: column; background: #f8f9fa; position: relative;">
                            
                            @php
                                $currentPatient = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking?->patient : null;
                                $currentPatientImage = $currentPatient?->profile_image ? asset('storage/' . $currentPatient->profile_image) : asset('images/default.jpeg');
                                $currentBookingId = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking_id : null;
                                $currentPatientId = $currentPatient?->id ?? '';
                            @endphp
                            
                            <!-- CHAT HEADER -->
                            <div style="padding: 15px 20px; background: white; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; align-items: center;">
                                    <!-- Back button for mobile -->
                                    <button onclick="showSidebar()" style="display: none; margin-right: 15px; background: none; border: none; font-size: 20px;" class="mobile-back-btn">
                                        <i class="fas fa-arrow-left"></i>
                                    </button>
                                    
                                    <img id="currentPatientAvatar" src="{{ $currentPatientImage }}" style="width: 48px; height: 48px; border-radius: 50%; margin-right: 12px;">
                                    <div>
                                        <h5 id="currentPatientName" style="margin: 0; font-weight: 600;">{{ $currentPatient?->name ?? 'Select a chat' }}</h5>
                                        <small id="currentPatientStatus" style="color: #28a745;">{{ $currentPatient ? '● Online' : '' }}</small>
                                    </div>
                                </div>
                                
                                <div>
                                    <button style="background: none; border: 1px solid #dee2e6; border-radius: 50%; width: 40px; height: 40px; margin-right: 5px;" title="Search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                    <div style="display: inline-block; position: relative;">
                                        <button style="background: none; border: 1px solid #dee2e6; border-radius: 50%; width: 40px; height: 40px;" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">Close Chat</a>
                                            <a href="#" class="dropdown-item">Mute Notification</a>
                                            <a href="#" class="dropdown-item">Clear Message</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger">Delete Chat</a>
                                            <a href="#" class="dropdown-item text-danger">Block</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MESSAGES AREA -->
                            <div id="chatMessagesBody" style="flex: 1; overflow-y: auto; padding: 20px;">
                                <div id="messagesContainer">
                                    @php $lastDate = null; @endphp
                                    
                                    @if(isset($messages) && $messages->isNotEmpty())
                                        @foreach($messages as $msg)
                                            @php
                                                $msgPatient = $msg->booking?->patient;
                                                $currentDate = $msg->created_at->format('F d, Y');
                                                
                                                if($msg->sender_id == Auth::id()) {
                                                    $senderImage = Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default.jpeg');
                                                    $senderName = Auth::user()->name;
                                                } else {
                                                    $senderImage = $msgPatient?->profile_image ? asset('storage/' . $msgPatient->profile_image) : asset('images/default.jpeg');
                                                    $senderName = $msgPatient?->name ?? 'Patient';
                                                }
                                            @endphp

                                            @if ($lastDate !== $currentDate)
                                                <div style="display: flex; justify-content: center; margin: 20px 0;">
                                                    <span style="background: #e9ecef; color: #6c757d; padding: 5px 15px; border-radius: 20px; font-size: 12px;">
                                                        @if ($msg->created_at->isToday()) Today
                                                        @elseif ($msg->created_at->isYesterday()) Yesterday
                                                        @else {{ $currentDate }} @endif
                                                    </span>
                                                </div>
                                                @php $lastDate = $currentDate; @endphp
                                            @endif

                                            @if($msg->sender_id == Auth::id())
                                                <!-- DOCTOR MESSAGE - RIGHT -->
                                                <div style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
                                                    <div style="display: flex; align-items: flex-end;">
                                                        <div style="text-align: right; margin-right: 10px;">
                                                            <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 5px;">
                                                                <small style="color: #6c757d; margin-right: 10px;">{{ $msg->created_at->format('h:i A') }}</small>
                                                                <h6 style="margin: 0; font-weight: 600;">{{ $senderName }}</h6>
                                                            </div>
                                                            <div style="background: #0d6efd; color: white; padding: 12px 16px; border-radius: 18px 18px 0 18px; max-width: 400px; word-wrap: break-word;">
                                                                {{ $msg->message }}
                                                            </div>
                                                        </div>
                                                        <img src="{{ $senderImage }}" style="width: 36px; height: 36px; border-radius: 50%;">
                                                    </div>
                                                </div>
                                            @else
                                                <!-- PATIENT MESSAGE - LEFT -->
                                                <div style="display: flex; margin-bottom: 15px;">
                                                    <div style="display: flex; align-items: flex-end;">
                                                        <img src="{{ $senderImage }}" style="width: 36px; height: 36px; border-radius: 50%; margin-right: 10px;">
                                                        <div>
                                                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                                                <h6 style="margin: 0; font-weight: 600; margin-right: 10px;">{{ $senderName }}</h6>
                                                                <small style="color: #6c757d;">{{ $msg->created_at->format('h:i A') }}</small>
                                                            </div>
                                                            <div style="background: white; padding: 12px 16px; border-radius: 18px 18px 18px 0; max-width: 400px; word-wrap: break-word; border: 1px solid #dee2e6;">
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

                            <!-- CHAT FOOTER - INPUT -->
                            <div style="padding: 15px; background: white; border-top: 1px solid #dee2e6;">
                                <form id="chatForm" style="display: flex; align-items: center; gap: 10px;">
                                    @csrf
                                    <input type="hidden" name="receiver_id" id="receiverIdField" value="{{ $currentPatientId }}">
                                    <input type="hidden" name="booking_id" id="bookingIdField" value="{{ $currentBookingId }}">

                                    <button type="button" style="background: none; border: 1px solid #dee2e6; border-radius: 50%; width: 40px; height: 40px;">
                                        <i class="fa-solid fa-paperclip"></i>
                                    </button>
                                    
                                    <button type="button" style="background: none; border: 1px solid #dee2e6; border-radius: 50%; width: 40px; height: 40px;">
                                        <i class="fa-regular fa-face-smile"></i>
                                    </button>
                                    
                                    <button type="button" style="background: none; border: 1px solid #dee2e6; border-radius: 50%; width: 40px; height: 40px;">
                                        <i class="fa-solid fa-microphone"></i>
                                    </button>

                                    <input type="text" name="message" id="messageInput" placeholder="Type your message here..." 
                                        style="flex: 1; padding: 10px 15px; border: 1px solid #dee2e6; border-radius: 20px; outline: none;"
                                        {{ !$currentPatientId ? 'disabled' : '' }}>

                                    <button type="submit" id="sendMessageBtn" 
                                        style="background: #0d6efd; color: white; border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                        {{ !$currentPatientId ? 'disabled' : '' }}>
                                        <i class="fa-regular fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .chat_sidebar {
                width: 100% !important;
                display: block;
            }
            .chat_sidebar.hide {
                display: none !important;
            }
            #chatMessages {
                width: 100% !important;
                display: none;
            }
            #chatMessages.show {
                display: flex !important;
            }
            .mobile-back-btn {
                display: block !important;
            }
        }
        
        .chat-item:hover {
            background-color: #f8f9fa;
        }
        .chat-item.active {
            background-color: #e3f2fd;
        }
    </style>

    <script>
        // ============== SIMPLE CHAT SYSTEM - NO PAGE RELOADS ==============
        
        let currentBookingId = '{{ $currentBookingId ?? '' }}';
        let currentPatientId = '{{ $currentPatientId ?? '' }}';
        let currentPatientName = '{{ $currentPatient?->name ?? '' }}';
        let currentPatientImage = '{{ $currentPatientImage ?? asset('images/default.jpeg') }}';
        
        // OPEN CHAT - NO PAGE RELOAD
        function openChat(element) {
            // Get data from clicked element
            const bookingId = element.dataset.bookingId;
            const patientId = element.dataset.patientId;
            const patientName = element.dataset.patientName;
            const patientImage = element.dataset.patientImage;
            
            console.log('Opening chat:', bookingId, patientName);
            
            // Update current state
            currentBookingId = bookingId;
            currentPatientId = patientId;
            currentPatientName = patientName;
            currentPatientImage = patientImage;
            
            // Update UI
            document.getElementById('currentPatientAvatar').src = patientImage;
            document.getElementById('currentPatientName').textContent = patientName;
            document.getElementById('currentPatientStatus').innerHTML = '● Online';
            
            // Update form fields
            document.getElementById('receiverIdField').value = patientId;
            document.getElementById('bookingIdField').value = bookingId;
            document.getElementById('messageInput').disabled = false;
            document.getElementById('sendMessageBtn').disabled = false;
            
            // Remove active class from all
            document.querySelectorAll('.chat-item').forEach(el => {
                el.classList.remove('active');
                el.style.backgroundColor = '';
            });
            
            // Add active class to clicked
            element.classList.add('active');
            element.style.backgroundColor = '#e3f2fd';
            
            // Update URL without reload
            const url = new URL(window.location);
            url.searchParams.set('booking', bookingId);
            window.history.pushState({}, '', url);
            
            // MOBILE: Hide sidebar, show chat
            if (window.innerWidth <= 768) {
                document.querySelector('.chat_sidebar').classList.add('hide');
                document.getElementById('chatMessages').classList.add('show');
                document.getElementById('chatMessages').style.display = 'flex';
            }
            
            // LOAD MESSAGES VIA AJAX
            fetchMessages(bookingId, patientName, patientImage);
        }
        
        // FETCH MESSAGES
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
                if (!container) return;
                
                container.innerHTML = '';
                
                if (data.messages && data.messages.length > 0) {
                    let lastDate = null;
                    
                    data.messages.forEach(msg => {
                        const msgDate = new Date(msg.created_at);
                        const dateStr = msgDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        const isToday = msgDate.toDateString() === new Date().toDateString();
                        const isYesterday = msgDate.toDateString() === new Date(Date.now() - 86400000).toDateString();
                        
                        // Date divider
                        if (lastDate !== dateStr) {
                            const dateDiv = document.createElement('div');
                            dateDiv.style.display = 'flex';
                            dateDiv.style.justifyContent = 'center';
                            dateDiv.style.margin = '20px 0';
                            
                            let dateText = dateStr;
                            if (isToday) dateText = 'Today';
                            else if (isYesterday) dateText = 'Yesterday';
                            
                            dateDiv.innerHTML = `<span style="background: #e9ecef; color: #6c757d; padding: 5px 15px; border-radius: 20px; font-size: 12px;">${dateText}</span>`;
                            container.appendChild(dateDiv);
                            lastDate = dateStr;
                        }
                        
                        // Message
                        const isCurrentUser = msg.sender_id == {{ Auth::id() }};
                        const timeString = msgDate.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                        const senderName = isCurrentUser ? '{{ Auth::user()->name }}' : patientName;
                        const senderImage = isCurrentUser 
                            ? '{{ Auth::user()->profile_image ? asset("storage/" . Auth::user()->profile_image) : asset("images/default.jpeg") }}'
                            : patientImage;
                        
                        const msgDiv = document.createElement('div');
                        
                        if (isCurrentUser) {
                            msgDiv.style.display = 'flex';
                            msgDiv.style.justifyContent = 'flex-end';
                            msgDiv.style.marginBottom = '15px';
                            msgDiv.innerHTML = `
                                <div style="display: flex; align-items: flex-end;">
                                    <div style="text-align: right; margin-right: 10px;">
                                        <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 5px;">
                                            <small style="color: #6c757d; margin-right: 10px;">${timeString}</small>
                                            <h6 style="margin: 0; font-weight: 600;">${senderName}</h6>
                                        </div>
                                        <div style="background: #0d6efd; color: white; padding: 12px 16px; border-radius: 18px 18px 0 18px; max-width: 400px;">
                                            ${msg.message}
                                        </div>
                                    </div>
                                    <img src="${senderImage}" style="width: 36px; height: 36px; border-radius: 50%;">
                                </div>
                            `;
                        } else {
                            msgDiv.style.display = 'flex';
                            msgDiv.style.marginBottom = '15px';
                            msgDiv.innerHTML = `
                                <div style="display: flex; align-items: flex-end;">
                                    <img src="${senderImage}" style="width: 36px; height: 36px; border-radius: 50%; margin-right: 10px;">
                                    <div>
                                        <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                            <h6 style="margin: 0; font-weight: 600; margin-right: 10px;">${senderName}</h6>
                                            <small style="color: #6c757d;">${timeString}</small>
                                        </div>
                                        <div style="background: white; padding: 12px 16px; border-radius: 18px 18px 18px 0; max-width: 400px; border: 1px solid #dee2e6;">
                                            ${msg.message}
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        
                        container.appendChild(msgDiv);
                    });
                } else {
                    container.innerHTML = '<div style="text-align: center; color: #6c757d; padding: 50px;"><p>No messages yet. Start the conversation!</p></div>';
                }
                
                // Scroll to bottom
                const chatBody = document.getElementById('chatMessagesBody');
                if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
                
                // Mark as read
                markAsRead(bookingId);
            })
            .catch(error => console.error('Error:', error));
        }
        
        // MARK AS READ
        function markAsRead(bookingId) {
            const token = document.querySelector('input[name="_token"]')?.value || '';
            
            fetch(`/doctor/chat/mark-read/${bookingId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Remove badge
                const chatItem = document.querySelector(`[data-booking-id="${bookingId}"]`);
                if (chatItem) {
                    const badge = chatItem.querySelector('span[style*="background: #0d6efd"]');
                    if (badge) badge.remove();
                }
            })
            .catch(error => console.error('Error:', error));
        }
        
        // SEND MESSAGE
        document.getElementById('chatForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            
            if (!message || !currentBookingId || !currentPatientId) return false;
            
            const token = document.querySelector('input[name="_token"]')?.value || '';
            
            const formData = new FormData();
            formData.append('_token', token);
            formData.append('receiver_id', currentPatientId);
            formData.append('booking_id', currentBookingId);
            formData.append('message', message);
            
            // Clear input
            input.value = '';
            
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
                    // Add message to UI immediately
                    const container = document.getElementById('messagesContainer');
                    const now = new Date();
                    const timeString = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                    
                    const msgDiv = document.createElement('div');
                    msgDiv.style.display = 'flex';
                    msgDiv.style.justifyContent = 'flex-end';
                    msgDiv.style.marginBottom = '15px';
                    msgDiv.innerHTML = `
                        <div style="display: flex; align-items: flex-end;">
                            <div style="text-align: right; margin-right: 10px;">
                                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 5px;">
                                    <small style="color: #6c757d; margin-right: 10px;">${timeString}</small>
                                    <h6 style="margin: 0; font-weight: 600;">{{ Auth::user()->name }}</h6>
                                </div>
                                <div style="background: #0d6efd; color: white; padding: 12px 16px; border-radius: 18px 18px 0 18px; max-width: 400px;">
                                    ${message}
                                </div>
                            </div>
                            <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default.jpeg') }}" style="width: 36px; height: 36px; border-radius: 50%;">
                        </div>
                    `;
                    
                    container.appendChild(msgDiv);
                    
                    // Scroll to bottom
                    const chatBody = document.getElementById('chatMessagesBody');
                    if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                input.value = message;
            });
        });
        
        // SHOW SIDEBAR ON MOBILE
        function showSidebar() {
            document.querySelector('.chat_sidebar').classList.remove('hide');
            document.getElementById('chatMessages').classList.remove('show');
            document.getElementById('chatMessages').style.display = 'none';
            
            // Remove booking from URL
            const url = new URL(window.location);
            url.searchParams.delete('booking');
            window.history.pushState({}, '', url);
        }
        
        // INITIALIZE ON PAGE LOAD
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL for booking ID
            const urlParams = new URLSearchParams(window.location.search);
            const bookingId = urlParams.get('booking');
            
            if (bookingId) {
                const chatItem = document.querySelector(`[data-booking-id="${bookingId}"]`);
                if (chatItem) {
                    openChat(chatItem);
                }
            }
            
            // Mobile check
            if (window.innerWidth <= 768) {
                if (!bookingId) {
                    document.querySelector('.chat_sidebar').classList.remove('hide');
                    document.getElementById('chatMessages').style.display = 'none';
                }
            }
            
            // Search functionality
            const searchInput = document.getElementById('chatSearchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const term = this.value.toLowerCase();
                    const items = document.querySelectorAll('.chat-item');
                    let visible = 0;
                    
                    items.forEach(item => {
                        const name = item.querySelector('h5')?.textContent.toLowerCase() || '';
                        if (name.includes(term)) {
                            item.style.display = 'flex';
                            visible++;
                        } else {
                            item.style.display = 'none';
                        }
                    });
                    
                    document.getElementById('noSearchResults').style.display = visible === 0 ? 'block' : 'none';
                });
            }
        });
        
        // RESPONSIVE RESIZE
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 768) {
                if (!currentBookingId) {
                    document.querySelector('.chat_sidebar').classList.remove('hide');
                    document.getElementById('chatMessages').style.display = 'none';
                }
            } else {
                document.querySelector('.chat_sidebar').classList.remove('hide');
                document.getElementById('chatMessages').style.display = 'flex';
            }
        });
    </script>

    <!-- ADD THESE ROUTES TO web.php -->
    <!--
    Route::get('/doctor/chat/messages/{bookingId}', function($bookingId) {
        $messages = App\Models\Chat::where('booking_id', $bookingId)
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
    <script src="{{asset('js/script.js')}}"></script>

</body>

</html>