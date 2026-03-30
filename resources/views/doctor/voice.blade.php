@include('layouts.head')

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
                                <li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Voice Call</li>
                            </ol>
                            <h2 class="breadcrumb-title">Voice Call</h2>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-bg">
                <img src="{{ asset('images/breadcrumb-bg-01.png') }}" alt="img" class="breadcrumb-bg-01">
                <img src="{{ asset('images/breadcrumb-bg-02.png') }}" alt="img" class="breadcrumb-bg-02">
                <img src="{{ asset('images/breadcrumb-icon.png') }}" alt="img" class="breadcrumb-bg-03">
                <img src="{{ asset('images/breadcrumb-icon.png') }}" alt="img" class="breadcrumb-bg-04">
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content">
            <div class="container">

                <div class="call-wrapper">
                    <div class="call-main-row">
                        <div class="call-main-wrapper">
                            <div class="call-view">
                                <div class="call-window">
                                    <!-- Header -->
                                    <div class="fixed-header">
                                        <div class="navbar d-flex justify-content-between align-items-center">
                                            <div class="user-details">
                                                <div class="user-info">
                                                    <span style="color: red;">Doctor:
                                                        {{ $booking->doctor->name }}</span> ||
                                                    <span>Patient: {{ $booking->patient->name }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <span>Time Remaining:</span>
                                                <span id="countdown"
                                                    style="color: #ff4444; font-weight: bold;">Loading...</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contents -->
                                    <div class="call-contents text-center">
                                        <div class="call-content-wrap">

                                            <div id="voice-call" style="width: 100%; height: 500px; background: #000;">
                                            </div>

                                        </div>

                                    </div>

                                    <!-- Footer -->
                                    <div class="call-footer text-center" id="loading-message" style="padding: 20px;">
                                        <p>Connecting to voice call...</p>
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
                console.log('🎧 Starting Zego Voice Call...');

                const roomID = "voice_booking_{{ $booking->id }}";
                const tokenRes = await fetch(`/api/zego-token?booking_id={{ $booking->id }}`);
                if (!tokenRes.ok) {
                    throw new Error('Failed to fetch secure call token');
                }
                const tokenData = await tokenRes.json();

                const appID = Number(tokenData.appId);
                const userID = String(tokenData.userId);
                const userName = tokenData.userName || 'Guest';
                const token = tokenData.kitToken;
                const kitToken = (typeof ZegoUIKitPrebuilt.generateKitTokenForProduction === 'function')
                    ? ZegoUIKitPrebuilt.generateKitTokenForProduction(appID, token, roomID, userID, userName)
                    : token;

                document.getElementById('loading-message').style.display = 'none';
                const zp = ZegoUIKitPrebuilt.create(kitToken);

                zp.joinRoom({
                    container: document.querySelector("#voice-call"),
                    scenario: {
                        mode: ZegoUIKitPrebuilt.OneONoneCall,
                    },
                    // 🎤 Voice only setup
                    turnOnCameraWhenJoining: false,
                    turnOnMicrophoneWhenJoining: true,
                    showMyCameraToggleButton: false,
                    showMyMicrophoneToggleButton: true,
                    showScreenSharingButton: false,
                    showTextChat: false,
                    showUserList: false,
                    layout: "Auto",
                    maxUsers: 2,
                    showLayoutButton: false,

                    onJoinRoom: () => console.log('🎉 Joined voice room:', roomID),
                    onLeaveRoom: () => {
                        console.log('👋 Left room');
                        window.location.href = "{{ route('doctor.appointment') }}";
                    },
                });
            } catch (error) {
                console.error('❌ Zego init error:', error);
                document.getElementById('loading-message').innerHTML = `
                    <div style="color: red; padding: 20px;">
                        <h5>Failed to start voice call</h5>
                        <p>${error.message}</p>
                        <a href="{{ route('patient.appointment') }}" class="btn btn-primary mt-2">← Back</a>
                    </div>`;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const serviceString = "{{ $booking->service_time }}"; // numeric like 20, 40, 60
            const appointmentStart = new Date("{{ $booking->appointment_datetime }}");
            const countdownEl = document.getElementById('countdown');

            const durationMs = parseInt(serviceString, 10) * 60 * 1000;
            const endTime = new Date(appointmentStart.getTime() + durationMs);

            function updateCountdown() {
                const now = new Date();

                if (now < appointmentStart) {
                    const diff = appointmentStart - now;
                    const minutes = Math.floor((diff / (1000 * 60)) % 60);
                    const seconds = Math.floor((diff / 1000) % 60);
                    countdownEl.innerText = `Starts in ${minutes}m ${seconds}s`;
                    return;
                }

                const remaining = endTime - now;
                if (remaining <= 0) {
                    countdownEl.innerText = "Time’s up!";
                    clearInterval(timerInterval);
                    alert("Your consultation time has ended.");
                    window.location.href = "{{ route('patient.appointment') }}";
                    return;
                }

                const minutes = Math.floor((remaining / (1000 * 60)) % 60);
                const seconds = Math.floor((remaining / 1000) % 60);
                countdownEl.innerText = `${minutes}:${seconds.toString().padStart(2, '0')} remaining`;
            }

            updateCountdown();
            const timerInterval = setInterval(updateCountdown, 1000);
        });
    </script>

</body>

</html>
