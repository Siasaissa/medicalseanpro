@include('layouts.head')

<body>
<div class="main-wrapper">
    @include('layouts.header')

    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Home Visit Details</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3">Appointment #APT000{{ $booking->id }}</h4>
                    <p><strong>Doctor:</strong> {{ $booking->doctor->name }}</p>
                    <p><strong>Patient:</strong> {{ $booking->patient->name }}</p>
                    <p><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($booking->appointment_datetime)->format('d M Y h:i A') }}</p>
                    <p><strong>Type:</strong> Home Visit</p>
                    <p><strong>Status:</strong> {{ strtoupper($booking->status ?? 'PENDING') }}</p>
                    <p class="mb-4"><strong>Doctor Contact:</strong> {{ $booking->doctor->profile?->phone_numbers ?? $booking->doctor->phone ?? 'Not provided' }}</p>

                    <a href="{{ route('patient.appointment') }}" class="btn btn-primary">Back to Appointments</a>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
</div>
</body>
</html>
