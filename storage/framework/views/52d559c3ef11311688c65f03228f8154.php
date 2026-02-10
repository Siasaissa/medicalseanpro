<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

<body class="call-page">

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<!-- /Header -->

		<!-- Breadcrumb -->
		<div class="breadcrumb-bar">
			<div class="container">
				<div class="row align-items-center inner-banner">
					<div class="col-md-12 col-12 text-center">
						<nav aria-label="breadcrumb" class="page-breadcrumb">
							<ol class="breadcrumb">
								
								<li class="breadcrumb-item active">Video Call</li>
							</ol>
							<h2 class="breadcrumb-title">Video Call</h2>
						</nav>
					</div>
				</div>
			</div>
			<div class="breadcrumb-bg">
				<img src="<?php echo e(asset('images/breadcrumb-bg-01.png')); ?>" alt="img" class="breadcrumb-bg-01">
				<img src="<?php echo e(asset('images/breadcrumb-bg-02.png')); ?>" alt="img" class="breadcrumb-bg-02">
				<img src="<?php echo e(asset('images/breadcrumb-icon.webp')); ?>" alt="img" class="breadcrumb-bg-03">
				<img src="<?php echo e(asset('images/breadcrumb-icon.webp')); ?>" alt="img" class="breadcrumb-bg-04">
			</div>
		</div>
		<!-- /Breadcrumb -->

		<!-- Page Content -->
		<div class="content">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 mx-auto">
						<div class="call-wrapper">
							<div class="call-main-row">
								<div class="call-main-wrapper">
									<div class="call-view">
										<div class="call-window">
											
											<!-- Header -->
											<div class="fixed-header">
												<div class="navbar">
													<div class="user-details">
														<div class="user-info float-start">
															<span>Doctor: <?php echo e($booking->doctor->name); ?></span>||
															<span>Patient: <?php echo e($booking->patient->name); ?></span>
														</div>

													</div>
															<div class="text-end mt-3">
															<span>Call Time Remaining:</span>
															<span id="countdown" style=" color: #ff4444; font-weight: bold;">Loading...</span>
														</div>
												</div>
											</div>

											<!-- Contents -->
											<div class="call-contents">
												<div class="call-content-wrap">
													<div class="user-video">
														<div id="video-call" style="width: 100%; height: 600px; background: #000;"></div>
													</div>
												</div>
												

											</div>

											<!-- Footer -->
											<div class="call-footer text-center" id="loading-message" style="padding: 20px;">
												<p>Connecting to call...</p>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
		<!-- /Page Content -->

		<!-- Footer Section -->
		<?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<!-- /Footer Section -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>"></script>
	<!-- Bootstrap Core JS -->
	<script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
	<!-- Custom JS -->
	<script src="<?php echo e(asset('js/script.js')); ?>"></script>

	<!-- Zego UIKit -->
	<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>

	<script>
		

		document.addEventListener('DOMContentLoaded', async () => {
			try {
				console.log('🎥 Starting direct Zego call init...');

				// Variables from Laravel
				const appID = <?php echo e(env('ZEGO_APP_ID')); ?>;
				const serverSecret = "<?php echo e(env('ZEGO_SERVER_SECRET')); ?>";
				const roomID = "booking_<?php echo e($booking->id); ?>";
				const userID = "<?php echo e(auth()->id() ?? rand(1000, 9999)); ?>";
				const userName = "<?php echo e(auth()->user()->name ?? 'Guest_' . rand(1000, 9999)); ?>";

				console.log('⚙️ Config:', { appID, roomID, userID, userName });

				// Generate Kit Token directly (for dev/demo use)
				const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
					appID,
					serverSecret,
					roomID,
					userID,
					userName
				);

				console.log('✅ Kit Token generated successfully');

				// Hide "Connecting..." text
				document.getElementById('loading-message').style.display = 'none';

				// Create Zego instance
				const zp = ZegoUIKitPrebuilt.create(kitToken);

				// Join the call
				zp.joinRoom({
					container: document.querySelector("#video-call"),
					sharedLinks: [{
						name: 'Call Link',
						url: window.location.href,
					}],
					scenario: {
						mode: ZegoUIKitPrebuilt.OneONoneCall,
					},
					turnOnCameraWhenJoining: true,
					turnOnMicrophoneWhenJoining: true,
					showScreenSharingButton: false,
					showMyCameraToggleButton: true,
					showMyMicrophoneToggleButton: true,
					showTextChat: true,
					showUserList: false,
					layout: "Auto",
					maxUsers: 2,
					showLayoutButton: false,
					onJoinRoom: () => console.log('🎉 Joined room:', roomID),
					onLeaveRoom: () => {
						console.log('👋 Left room');
						window.location.href = "<?php echo e(route('patient.appointment')); ?>";
					},
				});

			} catch (error) {
				console.error('❌ Zego init error:', error);
				document.getElementById('loading-message').innerHTML = `
					<div style="color: red; padding: 20px;">
						<h5>Failed to start video call</h5>
						<p>${error.message}</p>
						<a href="<?php echo e(route('patient.appointment')); ?>" class="btn btn-primary mt-2">← Back to Appointments</a>
					</div>`;
			}
		});
	</script>



	<script>
document.addEventListener('DOMContentLoaded', () => {
    const serviceString = "<?php echo e($booking->service_time); ?>"; // e.g. numeric: 20, 40, 60
    const appointmentStart = new Date("<?php echo e($booking->appointment_datetime); ?>"); // MySQL format
    const countdownEl = document.getElementById('countdown');

    // Convert numeric service_time (in minutes) to milliseconds
    const durationMs = parseInt(serviceString, 10) * 60 * 1000;
    const endTime = new Date(appointmentStart.getTime() + durationMs);

    function updateCountdown() {
        const now = new Date();

        // Case 1: Appointment not started yet
        if (now < appointmentStart) {
            const diff = appointmentStart - now;
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / (1000 * 60)) % 60);
            const seconds = Math.floor((diff / 1000) % 60);
            countdownEl.innerText =
                `Appointment starts in ${hours > 0 ? hours + 'h ' : ''}${minutes}m ${seconds}s`;
            return; // Don't start the countdown yet
        }

        // Case 2: Appointment started – calculate remaining time
        const remaining = endTime - now;

        if (remaining <= 0) {
            countdownEl.innerText = "Time’s up! Ending call...";
            clearInterval(timerInterval);

            setTimeout(() => {
                alert("Your consultation time has ended.");
                window.location.href = "<?php echo e(route('patient.appointment')); ?>";
            }, 2000);

            return;
        }

        const hours = Math.floor((remaining / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((remaining / (1000 * 60)) % 60);
        const seconds = Math.floor((remaining / 1000) % 60);

        countdownEl.innerText =
            `${hours > 0 ? hours + 'h ' : ''}${minutes}m ${seconds}s remaining`;
    }

    updateCountdown(); // run immediately
    const timerInterval = setInterval(updateCountdown, 1000);
});
</script>



</body>
</html>
<?php /**PATH /home/u881803686/domains/medicalsean.org/public_html/resources/views/patient/video.blade.php ENDPATH**/ ?>