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
						<div class="sidebar-group left-sidebar chat_sidebar">

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
											<form>
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
												@endphp

												<li class="user-list-item">
													<a
														href="{{ route('doctor.chat', ['booking' => $chatMessages->first()->booking_id]) }}">
														<div class="avatar avatar-online">
															<img src="{{ asset('images/default.jpeg') }}" alt="image">
														</div>
														<div class="users-list-body">
															<div>
																<h5>{{ $patient->name ?? 'Unknown Patient' }}</h5>
																<p>{{ $chatMessages->last()->message ?? '' }}</p>
															</div>
															<div class="last-chat-time">
																<small class="text-muted">
																	{{ $chatMessages->last()->created_at?->format('h:i A') ?? '' }}
																</small>
																<div class="new-message-count">
																	{{ $chatMessages->where('receiver_id', Auth::id())->count() }}
																</div>
															</div>
														</div>
													</a>
												</li>
											@endforeach
										</ul>

									</div>

								</div>

							</div>
							<!-- / Chats sidebar -->
						</div>
						<!-- /Sidebar group -->

						<!-- Chat -->
						<div class="chat chat-messages" id="middle">
							<div class="slimscroll">
								<div class="chat-inner-header">
									<div class="chat-header">
										<div class="user-details">
											<div class="d-lg-none">
												<ul class="list-inline mt-2 me-2">
													<li class="list-inline-item">
														<a class="text-muted px-0 left_sides" href="#" data-chat="open">
															<i class="fas fa-arrow-left"></i>
														</a>
													</li>
												</ul>
											</div>
											<figure class="avatar avatar-online">
												<img src="{{asset('images/default.jpeg')}}" alt="image">
											</figure>
											<div class="mt-1">
												<h5>{{ $messages[1]?->booking?->patient?->name ?? 'Unknown patient' }}
												</h5>
												<small class="last-seen">
													Online
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
											$currentDate = null;
										@endphp

										@foreach($messages as $msg)
											@php
												$msgDate = $msg->created_at->toDateString();
											@endphp

											{{-- Show date divider when the day changes --}}
											@if ($currentDate !== $msgDate)
												<div class="chat-line">
													<span class="chat-date">
														@if ($msg->created_at->isToday())
															Today
														@elseif ($msg->created_at->isYesterday())
															Yesterday
														@else
															{{ $msg->created_at->format('F d, Y') }}
														@endif
													</span>
												</div>
												@php
													$currentDate = $msgDate;
												@endphp
											@endif

											{{-- Outgoing (right) --}}
											@if($msg->sender_id == Auth::id())
												<div class="chats chats-right">
													<div class="chat-avatar">
														<img src="{{ asset('images/default.jpeg') }}" class="dreams_chat"
															alt="image">
													</div>
													<div class="chat-content">
														<div class="chat-profile-name text-end justify-content-end">
															<h6>{{ Auth::user()->name }}
																<span>{{ $msg->created_at->format('h:i A') }}</span>
															</h6>
														</div>
														<div class="message-content">{{ $msg->message }}</div>
													</div>
												</div>
											@else
												{{-- Incoming (left) --}}
												<div class="chats">
													<div class="chat-avatar">
														<img src="{{ asset('images/default.jpeg') }}" class="dreams_chat"
															alt="image">
													</div>
													<div class="chat-content">
														<div class="chat-profile-name">
															<h6>
																{{ $messages[1]?->booking?->patient?->name ?? 'Unknown patient' }}
																<span>{{ $msg->created_at->format('h:i A') }}</span>
															</h6>
														</div>
														<div class="message-content">{{ $msg->message }}</div>
													</div>
												</div>
											@endif
										@endforeach

									</div>

								</div>

							</div>
							<div class="chat-footer">
								<form action="{{ route('chat.store') }}" method="POST">
									@csrf

									<!-- Hidden fields -->
									<input type="hidden" name="receiver_id" value="{{ $patient?->id ?? ''}}">
									<input type="hidden" name="booking_id" value="{{ $booking?->id ?? '' }}">

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
									<input type="text" name="message" class="form-control chat_form"
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

const bookingId = document.querySelector('#booking-id').value;

// Listen for messages
window.Echo.channel(`chat.${bookingId}`)
    .listen('.MessageSent', (e) => {
        const chat = document.querySelector('#chat-messages');
        const div = document.createElement('div');
        div.innerHTML = `<b>${e.message.sender.name}:</b> ${e.message.message}`;
        chat.appendChild(div);
        chat.scrollTop = chat.scrollHeight;
    });

// Handle sending message
document.querySelector('#chat-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    const res = await fetch("{{ route('chat.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    });

    form.reset();
});
</script>
	<!-- jQuery -->
	<script src="{{asset('js/jquery-3.7.1.min.js')}}" type="adb2f76b2b117580fbcae61a-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{asset('js/bootstrap.bundle.min.js')}}" type="adb2f76b2b117580fbcae61a-text/javascript"></script>

	<!-- Swiper JS -->
	<script src="{{asset('js/swiper.min.js')}}" type="adb2f76b2b117580fbcae61a-text/javascript"></script>

	<!-- Custom JS -->
	<script src="{{asset('js/script.js')}}" type="adb2f76b2b117580fbcae61a-text/javascript"></script>

	<script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="adb2f76b2b117580fbcae61a-|49" defer=""></script>
	<script defer=""
		src="{{asset('https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015')}}"
		data-cf-beacon="{"
		rayid":"97c5f4406db6d596","servertiming":{"name":{"cfextpri":true,"cfedge":true,"cforigin":true,"cfl4":true,"cfspeedbrain":true,"cfcachestatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}"=""
		crossorigin="anonymous"></script>

</body>

</html>