<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
<body class="main-chat-blk">

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

										<!-- Left Chat Title -->
										<div class="d-flex justify-content-between align-items-center ps-0 pe-0">
											<div class="fav-title pin-chat">
												<h6>Recent Chat</h6>
											</div>
										</div>
										<!-- /Left Chat Title -->
										<ul class="user-list">
											<?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bId => $chatMessages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													$booking = $chatMessages->first()->booking;
													$doctor = $booking?->doctor;
												?>
												<?php if($doctor): ?>
													<li class="user-list-item">
														<a
															href="<?php echo e(route('chat.index', ['booking' => $chatMessages->first()->booking_id])); ?>">
															<div class="avatar avatar-online">
																<img src="<?php echo e(asset('images/default.jpeg')); ?>" alt="image">
															</div>
															<div class="users-list-body">
																<div>
																	<h5><?php echo e($doctor?->name ?? 'Unknown Doctor'); ?></h5>
																	<p><?php echo e($chatMessages->last()->message); ?></p>
																</div>
																<div class="last-chat-time">
																	<small class="text-muted">
																		<?php echo e($chatMessages->last()->created_at->format('h:i A')); ?>

																	</small>
																	<div class="new-message-count">
																		<?php echo e($chatMessages->where('sender_id', Auth::id())->count()); ?>

																	</div>
																</div>
															</div>
														</a>
													</li>
												<?php endif; ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
												<img src="<?php echo e(asset('images/default.jpeg')); ?>" alt="image">
											</figure>
											<div class="mt-1">
												<h5>
													<h5><?php echo e($messages[1]?->booking?->doctor?->name ?? 'Unknown Doctor'); ?>

													</h5>
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

										<?php
											$lastDate = null;
										?>

										<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php
												$msgDoctor = $msg->booking?->doctor;
												$currentDate = $msg->created_at->format('F d, Y');
											?>

											
											<?php if($lastDate !== $currentDate): ?>
												<div class="chat-line">
													<span class="chat-date"><?php echo e($currentDate); ?></span>
												</div>
												<?php
													$lastDate = $currentDate;
												?>
											<?php endif; ?>

											<?php if($msg->sender_id == Auth::id()): ?>
												
												<div class="chats chats-right">
													<div class="chat-avatar">
														<img src="<?php echo e(asset('images/default.jpeg')); ?>" class="dreams_chat"
															alt="image">
													</div>
													<div class="chat-content">
														<div class="chat-profile-name text-end justify-content-end">
															<h6><?php echo e(Auth::user()->name); ?>

																<span><?php echo e($msg->created_at->format('h:i A')); ?></span>
															</h6>
														</div>
														<div class="message-content">
															<?php echo e($msg->message); ?>

														</div>
													</div>
												</div>
											<?php else: ?>
												
												<div class="chats">
													<div class="chat-avatar">
														<img src="<?php echo e(asset('images/default.jpeg')); ?>" class="dreams_chat"
															alt="image">
													</div>
													<div class="chat-content">
														<div class="chat-profile-name">
															<h6><?php echo e($msgDoctor?->name ?? 'Unknown Doctor'); ?>

																<span><?php echo e($msg->created_at->format('h:i A')); ?></span>
															</h6>
														</div>
														<div class="message-content">
															<?php echo e($msg->message); ?>

														</div>
													</div>
												</div>
											<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

									</div>

								</div>

							</div>
							<div class="chat-footer">
								<form action="<?php echo e(route('chat.store1')); ?>" method="POST">
									<?php echo csrf_field(); ?>

									<!-- Hidden fields -->
									<input type="hidden" name="receiver_id" value="<?php echo e($doctor?->id ?? ''); ?>">
									<input type="hidden" name="booking_id" value="<?php echo e($booking?->id ?? ''); ?>">


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
															src="<?php echo e(asset('images/emoj-icon-01.svg')); ?>" alt="Icon"></a>
												</li>
												<li><a href="javascript:void(0);"><img
															src="<?php echo e(asset('images/emoj-icon-02.svg')); ?>" alt="Icon"></a>
												</li>
												<li><a href="javascript:void(0);"><img
															src="<?php echo e(asset('images/emoj-icon-03.svg')); ?>" alt="Icon"></a>
												</li>
												<li><a href="javascript:void(0);"><img
															src="<?php echo e(asset('images/emoj-icon-04.svg')); ?>" alt="Icon"></a>
												</li>
												<li><a href="javascript:void(0);"><img
															src="<?php echo e(asset('images/emoj-icon-05.svg')); ?>" alt="Icon"></a>
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
									<img alt="User Image" src="<?php echo e(asset('images/doctor-thumb-02.jpg')); ?>"
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
									<img class="call-avatar" src="<?php echo e(asset('images/doctor-thumb-02.jpg')); ?>"
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

    const res = await fetch("<?php echo e(route('chat.store')); ?>", {
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
	<script src="js/jquery-3.7.1.min.js" type="adb2f76b2b117580fbcae61a-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="js/bootstrap.bundle.min.js" type="adb2f76b2b117580fbcae61a-text/javascript"></script>

	<!-- Swiper JS -->
	<script src="js/swiper.min.js" type="adb2f76b2b117580fbcae61a-text/javascript"></script>

	<!-- Custom JS -->
	<script src="js/script.js" type="adb2f76b2b117580fbcae61a-text/javascript"></script>

	<script src="js/rocket-loader.min.js" data-cf-settings="adb2f76b2b117580fbcae61a-|49" defer=""></script>
	<script defer=""
		src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
		data-cf-beacon="{"
		rayid":"97c5f4406db6d596","servertiming":{"name":{"cfextpri":true,"cfedge":true,"cforigin":true,"cfl4":true,"cfspeedbrain":true,"cfcachestatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}"=""
		crossorigin="anonymous"></script>

</body>

</html><?php /**PATH /Users/dope/Documents/sean/sean/resources/views/patient/chat.blade.php ENDPATH**/ ?>