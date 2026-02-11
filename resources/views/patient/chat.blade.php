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
											<h4> All Chats</h4>
										</div>
										<div class="add-section">
											<!-- Chat Search -->
											<form action="" method="">
												@csrf
												<div class="user-chat-search">
													<span class="form-control-feedback"><i
															class="fa-solid fa-magnifying-glass"></i></span>
													<input type="text" name="chat-search" placeholder="Search"
														class="form-control">
												</div>
											</form>
											<!-- /Chat Search -->
										</div>
									</div>
									<!-- /Left Chat Title -->


									<div class="sidebar-body chat-body" id="chatsidebar">

										<!-- Left Chat Title -->

										<!-- Left Chat Title -->
										<div class="d-flex justify-content-between align-items-center ps-0 pe-0">
											<div class="fav-title pin-chat">
												<h6>Recent Chat</h6>
											</div>
										</div>
										<!-- /Left Chat Title -->
										<ul class="user-list">
											@foreach ($patients as $bId => $chatMessages)
												@php
													$booking = $chatMessages->first()->booking;
													$doctor = $booking?->doctor;
													$doctorImage = $doctor?->profile_image ? asset('storage/' . $doctor->profile_image) : asset('images/default.jpeg');
												@endphp
												@if($doctor)
													<li class="user-list-item chat-user-item" data-booking-id="{{ $chatMessages->first()->booking_id }}">
														<a href="{{ route('chat.index', ['booking' => $chatMessages->first()->booking_id]) }}"
														   onclick="handleChatClick(event, {{ $chatMessages->first()->booking_id }})">
															<div class="avatar avatar-online">
																<img src="{{ $doctorImage }}" alt="{{ $doctor->name }}">
															</div>
															<div class="users-list-body">
																<div>
																	<h5>{{ $doctor->name }}</h5>
																	<p>{{ Str::limit($chatMessages->last()->message, 30) }}</p>
																</div>
																<div class="last-chat-time">
																	<small class="text-muted">
																		{{ $chatMessages->last()->created_at->format('h:i A') }}
																	</small>
																	@php
																		$unreadCount = $chatMessages->where('sender_id', '!=', Auth::id())->where('is_read', 0)->count();
																	@endphp
																	@if($unreadCount > 0)
																		<div class="new-message-count">
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
												$currentDoctor = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking?->doctor : null;
												$currentDoctorImage = $currentDoctor?->profile_image ? asset('storage/' . $currentDoctor->profile_image) : asset('images/default.jpeg');
											@endphp
											<figure class="avatar avatar-online">
												<img src="{{ $currentDoctorImage }}" alt="{{ $currentDoctor?->name ?? 'Doctor' }}">
											</figure>
											<div class="mt-1">
												<h5>{{ $currentDoctor?->name ?? 'Select a chat' }}</h5>
												<small class="last-seen">
													{{ $currentDoctor ? 'Online' : '' }}
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
								<div class="chat-body">


									<div class="messages">

										@php
											$lastDate = null;
										@endphp

										@if(isset($messages) && $messages->isNotEmpty())
											@foreach($messages as $msg)
												@php
													$msgDoctor = $msg->booking?->doctor;
													$msgPatient = $msg->booking?->patient;
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
													{{-- Doctor message (left side) --}}
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

								</div>

							</div>
							<div class="chat-footer">
								<form action="{{ route('chat.store1') }}" method="POST" id="chatForm">
									@csrf

									<!-- Hidden fields -->
									@php
										$currentBooking = isset($messages) && $messages->isNotEmpty() ? $messages->first()->booking : null;
										$currentDoctorId = $currentBooking?->doctor?->id ?? '';
										$currentBookingId = $currentBooking?->id ?? '';
									@endphp
									<input type="hidden" name="receiver_id" value="{{ $currentDoctorId }}">
									<input type="hidden" name="booking_id" value="{{ $currentBookingId }}">


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
										<a href="#" class="action-circle"><i class="fa-regular fa-face-smile"></i></a>
										<div class="emoj-group-list-foot down-emoji-circle">
											<ul>
												<li><a href="javascript:void(0);"><img
															src="{{asset('images/emoj-icon-01.svg')}}" alt="Icon"></a>
												</li>
												<li><a href="javascript:void(0);"><img
															src="{{asset('images/emoj-icon-02.svg')}}" alt="Icon"></a>
												</li>
												<li><a href="javascript:void(0);"><img
															src="{{asset('images/emoj-icon-03.svg')}}" alt="Icon"></a>
												</li>
												<li><a href="javascript:void(0);"><img
															src="{{asset('images/emoj-icon-04.svg')}}" alt="Icon"></a>
												</li>
												<li><a href="javascript:void(0);"><img
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

									<!-- Message input (fixed) -->
									<input type="text" name="message" class="form-control chat_form" id="messageInput"
										placeholder="Type your message here..." required>

									<div class="form-buttons">
										<button class="btn send-btn" type="submit">
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

	<!-- Mobile Chat Toggle Script -->
	<script>
		// Get current booking ID from URL
		function getCurrentBookingId() {
			const urlParams = new URLSearchParams(window.location.search);
			return urlParams.get('booking');
		}

		// Function to handle chat click (from sidebar or "Attend" button)
		function handleChatClick(event, bookingId) {
			// Check if we're on mobile (screen width less than 992px)
			if (window.innerWidth < 992) {
				// Don't prevent default - let the link navigate
				// But hide sidebar and show chat with a slight delay
				setTimeout(function() {
					document.getElementById('chatSidebar').classList.add('d-none');
					document.getElementById('chatMessages').classList.remove('d-none');
					document.getElementById('chatMessages').classList.add('d-block');
				}, 50);
			}
		}

		// Function to show sidebar on mobile when back arrow is clicked
		function showSidebarOnMobile() {
			// Hide chat messages
			document.getElementById('chatMessages').classList.add('d-none');
			document.getElementById('chatMessages').classList.remove('d-block');
			
			// Show sidebar
			document.getElementById('chatSidebar').classList.remove('d-none');
		}

		// On page load, check if we're on mobile and handle visibility
		document.addEventListener('DOMContentLoaded', function() {
			const currentBookingId = getCurrentBookingId();
			
			if (window.innerWidth < 992) {
				// Check if there's a booking ID in URL (meaning user clicked "Attend" or a chat)
				if (currentBookingId) {
					// User came from "Attend" button or clicked a chat
					// Hide sidebar, show chat messages
					document.getElementById('chatSidebar').classList.add('d-none');
					document.getElementById('chatMessages').classList.remove('d-none');
					document.getElementById('chatMessages').classList.add('d-block');
					
					// Highlight the active chat in sidebar
					const activeChat = document.querySelector(`[data-booking-id="${currentBookingId}"]`);
					if (activeChat) {
						activeChat.classList.add('active');
					}
				} else {
					// No booking selected, show sidebar
					document.getElementById('chatSidebar').classList.remove('d-none');
					document.getElementById('chatMessages').classList.add('d-none');
				}
			} else {
				// Desktop view - show both
				document.getElementById('chatSidebar').classList.remove('d-none');
				document.getElementById('chatMessages').classList.remove('d-none');
				document.getElementById('chatMessages').classList.add('d-block');
			}

			// Scroll to bottom of messages
			const chatBody = document.querySelector('.chat-body');
			if (chatBody) {
				chatBody.scrollTop = chatBody.scrollHeight;
			}
		});

		// Handle window resize
		window.addEventListener('resize', function() {
			if (window.innerWidth >= 992) {
				// On desktop, show both sidebar and chat
				document.getElementById('chatSidebar').classList.remove('d-none');
				document.getElementById('chatMessages').classList.remove('d-none');
				document.getElementById('chatMessages').classList.add('d-block');
			} else {
				// On mobile, maintain current state
				const currentBookingId = getCurrentBookingId();
				if (currentBookingId) {
					// If chat is open, keep it that way
					document.getElementById('chatSidebar').classList.add('d-none');
					document.getElementById('chatMessages').classList.remove('d-none');
				} else {
					// If no chat open, show sidebar
					document.getElementById('chatSidebar').classList.remove('d-none');
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
					const messagesContainer = document.querySelector('.messages');
					if (messagesContainer) {
						// Create new message element
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
						}
						
						messagesContainer.appendChild(messageDiv);
						
						// Scroll to bottom
						const chatBody = document.querySelector('.chat-body');
						if (chatBody) {
							chatBody.scrollTop = chatBody.scrollHeight;
						}
					}
				});
		}

		// Handle form submission to clear input after sending
		const chatForm = document.getElementById('chatForm');
		if (chatForm) {
			chatForm.addEventListener('submit', function() {
				setTimeout(function() {
					document.getElementById('messageInput').value = '';
				}, 100);
			});
		}
	</script>

	<script data-cfasync="false" src="{{asset('js/email-decode.min.js')}}"></script>
	<script src="{{asset('js/jquery-3.7.1.min.js')}}" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{asset('js/bootstrap.bundle.min.js')}}" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<!-- Sticky Sidebar JS -->
	<script src="{{asset('js/ResizeSensor.js')}}" type="87d100b3f0de52923242b24d-text/javascript"></script>
	<script src="{{asset('js/theia-sticky-sidebar.js')}}" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<!-- select JS -->
	<script src="{{asset('js/select2.min.js')}}" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<!-- Daterangepikcer JS -->
	<script src="{{asset('js/moment.min.js')}}" type="87d100b3f0de52923242b24d-text/javascript"></script>
	<script src="{{asset('js/daterangepicker.js')}}" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<!-- Custom JS -->
	<script src="{{asset('js/script.js')}}" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="87d100b3f0de52923242b24d-|49"
		defer=""></script>
	<script defer=""
		src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
		data-cf-beacon="{"
		rayid":"97c5f4406db6d596","servertiming":{"name":{"cfextpri":true,"cfedge":true,"cforigin":true,"cfl4":true,"cfspeedbrain":true,"cfcachestatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}"=""
		crossorigin="anonymous"></script>

</body>

</html>