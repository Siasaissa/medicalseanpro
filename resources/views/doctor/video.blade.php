@include('layouts.head')
@vite('resources/js/app.js')

<body class="call-page">

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		@include('layouts.doctorHeader')
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
				<img src="{{ asset('images/breadcrumb-bg-01.png') }}" alt="img" class="breadcrumb-bg-01">
				<img src="{{ asset('images/breadcrumb-bg-02.png') }}" alt="img" class="breadcrumb-bg-02">
				<img src="{{ asset('images/breadcrumb-icon.webp') }}" alt="img" class="breadcrumb-bg-03">
				<img src="{{ asset('images/breadcrumb-icon.webp') }}" alt="img" class="breadcrumb-bg-04">
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
															<span>Doctor: {{ $booking->doctor->name }}</span>
															<span>Patient: {{ $booking->patient->name }}</span>
														</div>
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
		@include('layouts.footer')
		<!-- /Footer Section -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
	<!-- Bootstrap Core JS -->
	<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
	<!-- Custom JS -->
	<script src="{{ asset('js/script.js') }}"></script>

	<!-- Zego UIKit -->
	<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>

	<script>
		document.addEventListener('DOMContentLoaded', async () => {
			try {
				console.log('🎥 Starting direct Zego call init...');

				// Variables from Laravel
				const appID = {{ env('ZEGO_APP_ID') }};
				const serverSecret = "{{ env('ZEGO_SERVER_SECRET') }}";
				const roomID = "booking_{{ $booking->id }}";
				const userID = "{{ auth()->id() ?? rand(1000, 9999) }}";
				const userName = "{{ auth()->user()->name ?? 'Guest_' . rand(1000, 9999) }}";

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
						window.location.href = "{{ route('doctor.appointment') }}";
					},
				});

			} catch (error) {
				console.error('❌ Zego init error:', error);
				document.getElementById('loading-message').innerHTML = `
					<div style="color: red; padding: 20px;">
						<h5>Failed to start video call</h5>
						<p>${error.message}</p>
						<a href="{{ route('doctor.appointment') }}" class="btn btn-primary mt-2">← Back to Appointments</a>
					</div>`;
			}
		});
	</script>

</body>
</html>
