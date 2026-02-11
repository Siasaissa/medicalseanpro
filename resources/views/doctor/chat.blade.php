@include ('layouts.head')
@vite('resources/js/app.js')
<body class="main-chat-blk">

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include ('layouts.header')
        <!-- /Header -->

        <div class="page-wrapper chat-page-wrapper">
            <div class="container-fluid px-0">

                <div class="content doctor-content">

                    <div class="chat-sec d-flex">

                        <!-- sidebar group -->
                        <div class="sidebar-group left-sidebar chat_sidebar col-lg-3 col-md-4 px-0" id="chatSidebar">

                            <!-- Chats sidebar -->
                            <div id="chats" class="left-sidebar-wrap sidebar active h-100 border-end">

                                <div class="h-100 d-flex flex-column">

                                    <!-- Left Chat Title -->
                                    <div class="left-chat-title all-chats p-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="setting-title-head">
                                                <h4 class="mb-0">All Chats</h4>
                                            </div>
                                        </div>
                                        <div class="add-section">
                                            <!-- Chat Search -->
                                            <form action="" method="">
                                                @csrf
                                                <div class="position-relative">
                                                    <span class="position-absolute start-0 top-50 translate-middle-y ms-3">
                                                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                                    </span>
                                                    <input type="text" id="chatSearchInput" name="chat-search"
                                                        placeholder="Search" class="form-control ps-5">
                                                </div>
                                            </form>
                                            <!-- /Chat Search -->
                                        </div>
                                    </div>
                                    <!-- /Left Chat Title -->

                                    <div class="sidebar-body chat-body flex-grow-1 overflow-auto" id="chatsidebar">

                                        <!-- Left Chat Title -->
                                        <div class="d-flex justify-content-between align-items-center p-3 pb-0">
                                            <div class="fav-title pin-chat">
                                                <h6 class="fw-bold mb-0">Recent Chat</h6>
                                            </div>
                                        </div>
                                        <!-- /Left Chat Title -->

                                        <ul class="list-unstyled user-list px-2">
                                            @foreach ($doctors as $bookingId => $chatMessages)
                                                @php
                                                    $firstMessage = $chatMessages->first();
                                                    $booking = $firstMessage->booking;
                                                    $doctor = $booking?->doctor;
                                                    $doctorImage = $doctor?->profile_image 
                                                        ? asset('storage/' . $doctor->profile_image) 
                                                        : asset('images/default.jpeg');
                                                    $lastMessage = $chatMessages->last();
                                                    $unreadCount = $chatMessages
                                                        ->where('sender_id', $doctor?->id)
                                                        ->where('receiver_id', Auth::id())
                                                        ->where('is_read', 0)
                                                        ->count();
                                                @endphp

                                                @if($doctor)
                                                    <li class="user-list-item mb-2 rounded-3 {{ request()->get('booking') == $bookingId ? 'bg-light' : '' }}" 
                                                        data-booking-id="{{ $bookingId }}">
                                                        <a href="{{ route('chat.index', ['booking' => $bookingId]) }}"
                                                            onclick="handleChatClick(event, {{ $bookingId }})"
                                                            class="text-decoration-none text-dark d-flex p-2">
                                                            <div class="avatar avatar-online position-relative me-2">
                                                                <img src="{{ $doctorImage }}" alt="{{ $doctor->name }}"
                                                                    class="rounded-circle" width="48" height="48">
                                                                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-2 border-white"></span>
                                                            </div>
                                                            <div class="users-list-body flex-grow-1 min-w-0">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <h5 class="mb-0 text-truncate fw-semibold">{{ $doctor->name }}</h5>
                                                                    <small class="text-muted ms-2 text-nowrap">
                                                                        {{ $lastMessage->created_at?->format('h:i A') ?? '' }}
                                                                    </small>
                                                                </div>
                                                                <div class="d-flex justify-content-between align-items-center mt-1">
                                                                    <p class="text-muted mb-0 text-truncate small">
                                                                        {{ Str::limit($lastMessage->message ?? 'No messages yet', 25) }}
                                                                    </p>
                                                                    @if($unreadCount > 0)
                                                                        <span class="badge bg-primary rounded-pill ms-2">
                                                                            {{ $unreadCount }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>

                                        <!-- No results message -->
                                        <div id="noSearchResults" class="text-center text-muted p-4 d-none">
                                            <i class="fa-regular fa-message fa-2x mb-2"></i>
                                            <p class="mb-0">No chats found</p>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- / Chats sidebar -->
                        </div>
                        <!-- /Sidebar group -->

                        <!-- Chat -->
                        <div class="chat chat-messages col-lg-9 col-md-8 px-0 {{ request()->get('booking') ? 'd-block' : 'd-none d-md-block' }}" id="chatMessages">
                            <div class="d-flex flex-column h-100">
                                <div class="chat-inner-header border-bottom">
                                    <div class="chat-header p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="user-details d-flex align-items-center">
                                                <div class="d-md-none me-2">
                                                    <a class="text-muted" href="javascript:void(0);"
                                                        onclick="showSidebarOnMobile()">
                                                        <i class="fas fa-arrow-left fs-5"></i>
                                                    </a>
                                                </div>
                                                @php
                                                    $currentDoctor = isset($messages) && $messages->isNotEmpty() 
                                                        ? $messages->first()->booking?->doctor 
                                                        : null;
                                                    $currentDoctorImage = $currentDoctor?->profile_image 
                                                        ? asset('storage/' . $currentDoctor->profile_image) 
                                                        : asset('images/default.jpeg');
                                                @endphp
                                                <figure class="avatar avatar-online mb-0 me-2">
                                                    <img src="{{ $currentDoctorImage }}"
                                                        alt="{{ $currentDoctor?->name ?? 'Doctor' }}"
                                                        class="rounded-circle" width="48" height="48">
                                                </figure>
                                                <div>
                                                    <h5 class="mb-0 fw-semibold">{{ $currentDoctor?->name ?? 'Select a chat' }}</h5>
                                                    @if($currentDoctor)
                                                        <small class="text-muted">
                                                            <span class="text-success">●</span> Online
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="chat-options">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-sm btn-outline-secondary rounded-circle p-2"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Search">
                                                            <i class="fa-solid fa-magnifying-glass"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="btn btn-sm btn-outline-secondary rounded-circle p-2" href="#"
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
                                </div>

                                <div class="chat-body flex-grow-1 overflow-auto p-3" id="chatMessagesBody" style="background-color: #f8f9fa;">
                                    <div class="messages" id="messagesContainer">

                                        @php
                                            $lastDate = null;
                                        @endphp

                                        @if(isset($messages) && $messages->isNotEmpty())
                                            @foreach($messages as $msg)
                                                @php
                                                    $msgDoctor = $msg->booking?->doctor;
                                                    $currentDate = $msg->created_at->format('F d, Y');

                                                    if ($msg->sender_id == Auth::id()) {
                                                        $senderImage = Auth::user()->profile_image 
                                                            ? asset('storage/' . Auth::user()->profile_image) 
                                                            : asset('images/default.jpeg');
                                                        $senderName = Auth::user()->name;
                                                    } else {
                                                        $senderImage = $msgDoctor?->profile_image 
                                                            ? asset('storage/' . $msgDoctor->profile_image) 
                                                            : asset('images/default.jpeg');
                                                        $senderName = $msgDoctor?->name ?? 'Doctor';
                                                    }
                                                @endphp

                                                @if ($lastDate !== $currentDate)
                                                    <div class="d-flex justify-content-center my-3">
                                                        <span class="bg-light text-muted px-3 py-1 rounded-pill small">
                                                            @if ($msg->created_at->isToday())
                                                                Today
                                                            @elseif ($msg->created_at->isYesterday())
                                                                Yesterday
                                                            @else
                                                                {{ $currentDate }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                    @php $lastDate = $currentDate; @endphp
                                                @endif

                                                @if($msg->sender_id == Auth::id())
                                                    <!-- Patient message (right side) -->
                                                    <div class="d-flex justify-content-end mb-3" data-message-id="{{ $msg->id }}">
                                                        <div class="d-flex align-items-end">
                                                            <div class="text-end me-2">
                                                                <div class="d-flex justify-content-end align-items-center mb-1">
                                                                    <small class="text-muted me-2">{{ $msg->created_at->format('h:i A') }}</small>
                                                                    <h6 class="mb-0 fw-semibold">{{ $senderName }}</h6>
                                                                </div>
                                                                <div class="bg-primary text-white p-3 rounded-4 rounded-bottom-end-0 shadow-sm" 
                                                                     style="max-width: 400px; word-wrap: break-word;">
                                                                    {{ $msg->message }}
                                                                </div>
                                                            </div>
                                                            <div class="chat-avatar flex-shrink-0">
                                                                <img src="{{ $senderImage }}" class="rounded-circle"
                                                                    alt="{{ $senderName }}" width="36" height="36">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <!-- Doctor message (left side) -->
                                                    <div class="d-flex mb-3" data-message-id="{{ $msg->id }}">
                                                        <div class="d-flex align-items-end">
                                                            <div class="chat-avatar flex-shrink-0 me-2">
                                                                <img src="{{ $senderImage }}" class="rounded-circle"
                                                                    alt="{{ $senderName }}" width="36" height="36">
                                                            </div>
                                                            <div>
                                                                <div class="d-flex align-items-center mb-1">
                                                                    <h6 class="mb-0 fw-semibold me-2">{{ $senderName }}</h6>
                                                                    <small class="text-muted">{{ $msg->created_at->format('h:i A') }}</small>
                                                                </div>
                                                                <div class="bg-white p-3 rounded-4 rounded-bottom-start-0 shadow-sm border" 
                                                                     style="max-width: 400px; word-wrap: break-word;">
                                                                    {{ $msg->message }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="text-center text-muted py-5">
                                                <i class="fa-regular fa-message fa-3x mb-3"></i>
                                                <p class="mb-0">No messages yet. Start the conversation!</p>
                                            </div>
                                        @endif

                                    </div>

                                    <!-- Typing indicator (hidden by default) -->
                                    <div id="typingIndicator" class="d-none mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <img src="{{ $currentDoctorImage ?? asset('images/default.jpeg') }}"
                                                    class="rounded-circle" width="36" height="36" alt="Doctor">
                                            </div>
                                            <div class="bg-light p-3 rounded-4">
                                                <div class="d-flex gap-1">
                                                    <span class="bg-secondary rounded-circle" style="width: 8px; height: 8px; animation: pulse 1.4s infinite;"></span>
                                                    <span class="bg-secondary rounded-circle" style="width: 8px; height: 8px; animation: pulse 1.4s infinite; animation-delay: 0.2s;"></span>
                                                    <span class="bg-secondary rounded-circle" style="width: 8px; height: 8px; animation: pulse 1.4s infinite; animation-delay: 0.4s;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="chat-footer border-top p-3 bg-white">
                                    <form action="{{ route('chat.store1') }}" method="POST" id="chatForm" class="d-flex align-items-center gap-2">
                                        @csrf

                                        <!-- Hidden fields -->
                                        @php
                                            $currentBooking = isset($messages) && $messages->isNotEmpty() 
                                                ? $messages->first()->booking 
                                                : null;
                                            $currentDoctorId = $currentBooking?->doctor?->id ?? '';
                                            $currentBookingId = $currentBooking?->id ?? '';
                                        @endphp
                                        <input type="hidden" name="receiver_id" id="receiverIdField"
                                            value="{{ $currentDoctorId }}">
                                        <input type="hidden" name="booking_id" id="bookingIdField"
                                            value="{{ $currentBookingId }}">

                                        <!-- Attachment dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-light rounded-circle p-2" type="button" data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-paperclip"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="#" class="dropdown-item"><span><i class="fa-solid fa-file-lines me-2"></i></span>Document</a>
                                                <a href="#" class="dropdown-item"><span><i class="fa-solid fa-camera me-2"></i></span>Camera</a>
                                                <a href="#" class="dropdown-item"><span><i class="fa-solid fa-image me-2"></i></span>Gallery</a>
                                                <a href="#" class="dropdown-item"><span><i class="fa-solid fa-volume-high me-2"></i></span>Audio</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="#" class="dropdown-item"><span><i class="fa-solid fa-location-dot me-2"></i></span>Location</a>
                                                <a href="#" class="dropdown-item"><span><i class="fa-solid fa-user me-2"></i></span>Contact</a>
                                            </div>
                                        </div>

                                        <!-- Emoji picker -->
                                        <div class="dropdown">
                                            <button class="btn btn-light rounded-circle p-2" type="button" data-bs-toggle="dropdown">
                                                <i class="fa-regular fa-face-smile"></i>
                                            </button>
                                            <div class="dropdown-menu p-2" style="min-width: 200px;">
                                                <div class="d-flex flex-wrap gap-2">
                                                    <a href="javascript:void(0);" class="text-decoration-none fs-4" data-emoji="😊">😊</a>
                                                    <a href="javascript:void(0);" class="text-decoration-none fs-4" data-emoji="😂">😂</a>
                                                    <a href="javascript:void(0);" class="text-decoration-none fs-4" data-emoji="❤️">❤️</a>
                                                    <a href="javascript:void(0);" class="text-decoration-none fs-4" data-emoji="👍">👍</a>
                                                    <a href="javascript:void(0);" class="text-decoration-none fs-4" data-emoji="🎉">🎉</a>
                                                    <a href="javascript:void(0);" class="text-decoration-none fs-4" data-emoji="😢">😢</a>
                                                    <a href="javascript:void(0);" class="text-decoration-none fs-4" data-emoji="😎">😎</a>
                                                    <a href="javascript:void(0);" class="text-decoration-none fs-4" data-emoji="🔥">🔥</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Voice message -->
                                        <button class="btn btn-light rounded-circle p-2" type="button">
                                            <i class="fa-solid fa-microphone"></i>
                                        </button>

                                        <!-- Message input -->
                                        <input type="text" name="message" class="form-control form-control-lg" 
                                            id="messageInput" placeholder="Type your message here..." 
                                            autocomplete="off" required {{ !$currentDoctorId ? 'disabled' : '' }}>

                                        <!-- Send button -->
                                        <button class="btn btn-primary rounded-circle p-2" type="submit" id="sendMessageBtn" {{ !$currentDoctorId ? 'disabled' : '' }}>
                                            <i class="fa-regular fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <!-- /Chat -->

                    </div>

                </div>

            </div>
        </div>

    </div>
    <!-- /Main Wrapper -->

    <!-- Modals -->
    <!-- Mute Notification Modal -->
    <div class="modal fade" id="mute-notification" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mute Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to mute notifications for this chat?</p>
                    <div class="mt-3">
                        <label class="d-flex align-items-center">
                            <input type="radio" name="mute_duration" class="me-2" checked>
                            <span>1 hour</span>
                        </label>
                        <label class="d-flex align-items-center mt-2">
                            <input type="radio" name="mute_duration" class="me-2">
                            <span>8 hours</span>
                        </label>
                        <label class="d-flex align-items-center mt-2">
                            <input type="radio" name="mute_duration" class="me-2">
                            <span>24 hours</span>
                        </label>
                        <label class="d-flex align-items-center mt-2">
                            <input type="radio" name="mute_duration" class="me-2">
                            <span>Always</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mute</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Clear Chat Modal -->
    <div class="modal fade" id="clear-chat" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Clear Chat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to clear all messages in this chat?</p>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Clear</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Chat Modal -->
    <div class="modal fade" id="change-chat" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Chat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this chat?</p>
                    <p class="text-danger small mb-0">This will permanently delete the conversation.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Block User Modal -->
    <div class="modal fade" id="block-user" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Block User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to block this user?</p>
                    <p class="text-muted small mb-0">You won't receive any messages from them.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Block</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Report User Modal -->
    <div class="modal fade" id="report-user" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Report User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Why are you reporting this user?</p>
                    <select class="form-select mt-2">
                        <option>Spam or fake account</option>
                        <option>Inappropriate behavior</option>
                        <option>Harassment</option>
                        <option>Other reason</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Report</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Voice Call Modal -->
    <div class="modal fade" id="voice_call" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="call-box">
                        <div class="call-wrapper">
                            <div class="mb-4">
                                <img alt="User Image" src="{{ asset('images/doctor-thumb-02.jpg') }}"
                                    class="rounded-circle mb-3" width="100" height="100">
                                <h4 class="fw-bold">{{ $currentDoctor?->name ?? 'Doctor' }}</h4>
                                <span class="text-muted">Connecting...</span>
                            </div>
                            <div class="d-flex justify-content-center gap-3">
                                <button class="btn btn-danger rounded-circle p-3" data-bs-dismiss="modal">
                                    <i class="material-icons fs-4">call_end</i>
                                </button>
                                <a href="voice-call.html" class="btn btn-success rounded-circle p-3">
                                    <i class="material-icons fs-4">call</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Call Modal -->
    <div class="modal fade" id="video_call" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="call-box">
                        <div class="call-wrapper">
                            <div class="mb-4">
                                <img alt="User Image" src="{{ asset('images/doctor-thumb-02.jpg') }}"
                                    class="rounded-circle mb-3" width="100" height="100">
                                <h4 class="fw-bold">{{ $currentDoctor?->name ?? 'Doctor' }}</h4>
                                <span class="text-muted">Calling...</span>
                            </div>
                            <div class="d-flex justify-content-center gap-3">
                                <button class="btn btn-danger rounded-circle p-3" data-bs-dismiss="modal">
                                    <i class="material-icons fs-4">call_end</i>
                                </button>
                                <a href="video-call.html" class="btn btn-success rounded-circle p-3">
                                    <i class="material-icons fs-4">videocam</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Toggle JavaScript -->
    <script>
        // Get current booking ID from URL
        function getCurrentBookingId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('booking');
        }

        // Function to handle chat click
        function handleChatClick(event, bookingId) {
            if (window.innerWidth < 768) {
                setTimeout(function() {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatSidebar').classList.remove('d-block');
                    document.getElementById('chatMessages').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-block');
                }, 50);
            }
        }

        // Function to show sidebar on mobile
        function showSidebarOnMobile() {
            document.getElementById('chatSidebar').classList.remove('d-none');
            document.getElementById('chatSidebar').classList.add('d-block');
            document.getElementById('chatMessages').classList.add('d-none');
            document.getElementById('chatMessages').classList.remove('d-block');
            
            // Remove booking ID from URL
            const url = new URL(window.location);
            url.searchParams.delete('booking');
            window.history.pushState({}, '', url);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const currentBookingId = getCurrentBookingId();
            
            if (window.innerWidth < 768) {
                if (currentBookingId) {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-block');
                } else {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatSidebar').classList.add('d-block');
                    document.getElementById('chatMessages').classList.add('d-none');
                }
            }

            // Scroll to bottom
            const chatBody = document.getElementById('chatMessagesBody');
            if (chatBody) {
                chatBody.scrollTop = chatBody.scrollHeight;
            }

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Chat search functionality
            const searchInput = document.getElementById('chatSearchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const chatItems = document.querySelectorAll('.user-list-item');
                    let visibleCount = 0;
                    
                    chatItems.forEach(item => {
                        const doctorName = item.querySelector('h5')?.textContent.toLowerCase() || '';
                        const lastMessage = item.querySelector('p')?.textContent.toLowerCase() || '';
                        
                        if (doctorName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
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
            const currentBookingId = getCurrentBookingId();
            
            if (window.innerWidth >= 768) {
                document.getElementById('chatSidebar').classList.remove('d-none');
                document.getElementById('chatSidebar').classList.add('d-block');
                document.getElementById('chatMessages').classList.remove('d-none');
                document.getElementById('chatMessages').classList.add('d-block');
            } else {
                if (currentBookingId) {
                    document.getElementById('chatSidebar').classList.add('d-none');
                    document.getElementById('chatMessages').classList.remove('d-none');
                    document.getElementById('chatMessages').classList.add('d-block');
                } else {
                    document.getElementById('chatSidebar').classList.remove('d-none');
                    document.getElementById('chatSidebar').classList.add('d-block');
                    document.getElementById('chatMessages').classList.add('d-none');
                }
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

        const bookingId = document.querySelector('input[name="booking_id"]')?.value;

        if (bookingId) {
            // Listen for messages
            window.Echo.channel(`chat.${bookingId}`)
                .listen('.MessageSent', (e) => {
                    const messagesContainer = document.getElementById('messagesContainer');
                    if (messagesContainer) {
                        const isCurrentUser = e.message.sender_id === {{ Auth::id() }};
                        
                        const now = new Date();
                        const timeString = now.toLocaleTimeString('en-US', { 
                            hour: 'numeric', 
                            minute: '2-digit', 
                            hour12: true 
                        });
                        
                        const senderName = isCurrentUser 
                            ? '{{ Auth::user()->name }}' 
                            : e.message.sender.name;
                        
                        const senderImage = isCurrentUser 
                            ? '{{ Auth::user()->profile_image ? asset("storage/" . Auth::user()->profile_image) : asset("images/default.jpeg") }}'
                            : (e.message.sender.profile_image ? `/storage/${e.message.sender.profile_image}` : '{{ asset("images/default.jpeg") }}');
                        
                        let messageHtml = '';
                        
                        if (isCurrentUser) {
                            messageHtml = `
                                <div class="d-flex justify-content-end mb-3">
                                    <div class="d-flex align-items-end">
                                        <div class="text-end me-2">
                                            <div class="d-flex justify-content-end align-items-center mb-1">
                                                <small class="text-muted me-2">${timeString}</small>
                                                <h6 class="mb-0 fw-semibold">${senderName}</h6>
                                            </div>
                                            <div class="bg-primary text-white p-3 rounded-4 rounded-bottom-end-0 shadow-sm"
                                                 style="max-width: 400px; word-wrap: break-word;">
                                                ${e.message.message}
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="${senderImage}" class="rounded-circle"
                                                alt="${senderName}" width="36" height="36">
                                        </div>
                                    </div>
                                </div>
                            `;
                        } else {
                            messageHtml = `
                                <div class="d-flex mb-3">
                                    <div class="d-flex align-items-end">
                                        <div class="flex-shrink-0 me-2">
                                            <img src="${senderImage}" class="rounded-circle"
                                                alt="${senderName}" width="36" height="36">
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <h6 class="mb-0 fw-semibold me-2">${senderName}</h6>
                                                <small class="text-muted">${timeString}</small>
                                            </div>
                                            <div class="bg-white p-3 rounded-4 rounded-bottom-start-0 shadow-sm border"
                                                 style="max-width: 400px; word-wrap: break-word;">
                                                ${e.message.message}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        
                        messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                        
                        // Scroll to bottom
                        const chatBody = document.getElementById('chatMessagesBody');
                        if (chatBody) {
                            chatBody.scrollTop = chatBody.scrollHeight;
                        }
                    }
                });
        }

        // Clear input after sending
        const chatForm = document.getElementById('chatForm');
        if (chatForm) {
            chatForm.addEventListener('submit', function() {
                setTimeout(function() {
                    document.getElementById('messageInput').value = '';
                }, 100);
            });
        }
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <style>
        @keyframes pulse {
            0%, 80%, 100% { opacity: 0.6; transform: scale(0.8); }
            40% { opacity: 1; transform: scale(1); }
        }
        
        .rounded-bottom-end-0 {
            border-bottom-right-radius: 0 !important;
        }
        
        .rounded-bottom-start-0 {
            border-bottom-left-radius: 0 !important;
        }
    </style>

</body>

</html>