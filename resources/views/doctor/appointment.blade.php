@include('layouts.head')
@php
    use Carbon\Carbon;
@endphp

<body>

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
                                <li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Doctor</li>
                                <li class="breadcrumb-item active">Appointments</li>
                            </ol>
                            <h2 class="breadcrumb-title">Appointments</h2>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-bg">
                <img src="{{asset('images/breadcrumb-bg-01.png')}}" alt="img" class="breadcrumb-bg-01">
                <img src="{{asset('images/breadcrumb-bg-02.png')}}" alt="img" class="breadcrumb-bg-02">
                <img src="{{asset('images/breadcrumb-icon.png')}}" alt="img" class="breadcrumb-bg-03">
                <img src="{{asset('images/breadcrumb-icon.png')}}" alt="img" class="breadcrumb-bg-04">
            </div>
        </div>
        <!-- /Breadcrumb -->
        
        <!-- Page Content -->
        <div class="content">
            <div class="container">

                <div class="row">
                    <div class="col-lg-4 col-xl-3 theiaStickySidebar">
                        
                        <!-- Profile Sidebar -->
                        @include('layouts.doctorSidebar')
                        <!-- /Profile Sidebar -->
                        
                    </div>
                    
                    <div class="col-lg-8 col-xl-9">
                        <div class="dashboard-header">
                            <h3>Appointments</h3>
                            <ul class="header-list-btns">
                                <li>
                                    <div class="input-block dash-search-input">
                                        <input type="text" id="appointmentSearch" class="form-control" placeholder="Search by patient name or ID">
                                        <span class="search-icon"><i class="isax isax-search-normal"></i></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="view-icons">
                                        <a href="#" class="active"><i class="isax isax-grid-7"></i></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="view-icons">
                                        <a href="#"><i class="fa-solid fa-th"></i></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="view-icons">
                                        <a href="#"><i class="isax isax-calendar-tick"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="appointment-tab-head">
                            <div class="appointment-tabs">
                                <ul class="nav nav-pills inner-tab" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-upcoming-tab" data-bs-toggle="pill" data-bs-target="#pills-upcoming" type="button" role="tab" aria-controls="pills-upcoming" aria-selected="false">Upcoming<span>{{ $counts }}</span></button>
                                    </li>   
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-complete-tab" data-bs-toggle="pill" data-bs-target="#completed-bookings-container" type="button" role="tab" aria-controls="pills-complete" aria-selected="true">Completed<span>{{ $completed }}</span></button>
                                    </li>
                                </ul>
                            </div>
                            <div class="filter-head">
                                <div class="position-relative daterange-wraper me-2">
                                    <div class="input-groupicon calender-input">
                                        <input type="text" class="form-control date-range bookingrange" placeholder="From Date - To Date" id="dateRangePicker">
                                    </div>
                                    <i class="isax isax-calendar-1"></i>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content appointment-tab-content">
                            <!-- UPCOMING APPOINTMENTS TAB -->
                            <div class="tab-pane fade show active" id="pills-upcoming" role="tabpanel" aria-labelledby="pills-upcoming-tab">
                                <div id="upcoming-appointments-list">
                                    @php $hasUpcoming = false; @endphp
                                    @foreach ($bookings as $booking)
                                        @php
                                            $appointmentStart = Carbon::parse($booking->appointment_datetime);
                                            $appointmentEnd = $appointmentStart->copy()->addMinutes((int)$booking->service_time);
                                            $now = Carbon::now();
                                            $patient = $booking->patient;
                                            $patientImage = $patient?->profile_image 
                                                ? asset('storage/' . $patient->profile_image) 
                                                : asset('images/default.jpeg');
                                            $bookingId = str_pad($booking->id, 4, '0', STR_PAD_LEFT);
                                        @endphp

                                        {{-- SHOW ONLY UPCOMING & CURRENT --}}
                                        @if ($now->lt($appointmentEnd))
                                            @php $hasUpcoming = true; @endphp
                                            <div class="appointment-wrap upcoming-appointment-item" 
                                                 data-patient-name="{{ strtolower($patient->name ?? '') }}" 
                                                 data-booking-id="apt000{{ $booking->id }}"
                                                 data-appointment-date="{{ $booking->appointment_datetime }}">
                                                <ul>
                                                    <li>
                                                        <div class="patinet-information">
                                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#appointmentDetailsModal{{ $booking->id }}">
                                                                <img src="{{ $patientImage }}" alt="{{ $patient->name ?? 'Patient' }}" onerror="this.src='{{ asset('images/default.jpeg') }}'">
                                                            </a>
                                                            <div class="patient-info">
                                                                <p>#APT000{{ $booking->id }}</p>
                                                                <h6>
                                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#appointmentDetailsModal{{ $booking->id }}">
                                                                        {{ $patient->name ?? 'Unknown Patient' }}
                                                                    </a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class="appointment-info">
                                                        <p><i class="isax isax-clock5"></i>{{ Carbon::parse($booking->appointment_datetime)->format('d M Y h:i A') }}</p>
                                                        <ul class="d-flex apponitment-types">
                                                            <li>{{ $booking->service_name ?? 'General Visit' }}</li>
                                                            <li><span class="badge bg-{{ $booking->appointment_type == 'video' ? 'primary' : ($booking->appointment_type == 'voice' ? 'info' : 'success') }}">{{ ucfirst($booking->appointment_type) }}</span></li>
                                                        </ul>
                                                    </li>

                                                    <li class="mail-info-patient">
                                                        <ul>
                                                            <li><i class="isax isax-sms5"></i>{{ $patient->email ?? 'No email' }}</li>
                                                            <li><i class="isax isax-call5"></i>{{ $patient->phone ?? 'No phone' }}</li>
                                                        </ul>
                                                    </li>

                                                    <li class="appointment-action">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#appointmentDetailsModal{{ $booking->id }}" data-bs-toggle="tooltip" title="View Details">
                                                                    <i class="isax isax-eye4"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('doctor.chat', ['booking' => $booking->id]) }}" data-bs-toggle="tooltip" title="Chat">
                                                                    <i class="isax isax-messages-25"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>

                                                    {{-- IF APPOINTMENT IS CURRENT --}}
                                                    @if ($now->between($appointmentStart, $appointmentEnd))
                                                        <li class="appointment-detail-btn">
                                                            <a href="
                                                                @if ($booking->appointment_type == 'chat')
                                                                    {{ route('doctor.chat', ['booking' => $booking->id]) }}
                                                                @elseif ($booking->appointment_type == 'video')
                                                                    {{ route('doctor.video', ['booking' => $booking->id]) }}
                                                                @elseif ($booking->appointment_type == 'voice')
                                                                    {{ route('doctor.voice', ['booking' => $booking->id]) }}
                                                                @endif
                                                            " class="btn btn-md btn-primary-gradient">
                                                                <i class="isax isax-calendar-tick5 me-1"></i> Attend Now
                                                            </a>
                                                        </li>
                                                    {{-- APPOINTMENT NOT STARTED --}}
                                                    @elseif ($now->lt($appointmentStart))
                                                        <li class="appointment-time-status">
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="isax isax-timer-1 me-1"></i> Starts in {{ $now->diffInHours($appointmentStart) }}h
                                                            </span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>

                                            <!-- APPOINTMENT DETAILS MODAL - UPCOMING -->
                                            <div class="modal fade custom-modal" id="appointmentDetailsModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Appointment Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex align-items-center mb-4">
                                                                        <img src="{{ $patientImage }}" alt="{{ $patient->name ?? 'Patient' }}" 
                                                                             style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-right: 20px; border: 3px solid #0d6efd;"
                                                                             onerror="this.src='{{ asset('images/default.jpeg') }}'">
                                                                        <div>
                                                                            <h4 class="mb-1">{{ $patient->name ?? 'Unknown Patient' }}</h4>
                                                                            <p class="text-muted mb-1">Patient ID: #PAT{{ str_pad($patient->id ?? '0', 4, '0', STR_PAD_LEFT) }}</p>
                                                                            @if ($now->between($appointmentStart, $appointmentEnd))
                                                                                <span class="badge bg-warning">In Progress</span>
                                                                            @elseif ($now->lt($appointmentStart))
                                                                                <span class="badge bg-primary">Upcoming</span>
                                                                            @else
                                                                                <span class="badge bg-success">Completed</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <hr>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6 class="fw-bold mb-3">Appointment Information</h6>
                                                                    <ul class="info-details">
                                                                        <li>
                                                                            <span class="title">Booking ID:</span>
                                                                            <span class="text">#APT000{{ $booking->id }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Date:</span>
                                                                            <span class="text">{{ Carbon::parse($booking->appointment_datetime)->format('F d, Y') }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Time:</span>
                                                                            <span class="text">{{ Carbon::parse($booking->appointment_datetime)->format('h:i A') }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Duration:</span>
                                                                            <span class="text">{{ $booking->service_time ?? 30 }} minutes</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Service:</span>
                                                                            <span class="text">{{ $booking->service_name ?? 'General Consultation' }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Type:</span>
                                                                            <span class="text"><span class="badge bg-{{ $booking->appointment_type == 'video' ? 'primary' : ($booking->appointment_type == 'voice' ? 'info' : 'success') }}">{{ strtoupper($booking->appointment_type) }}</span></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <h6 class="fw-bold mb-3">Patient Information</h6>
                                                                    <ul class="info-details">
                                                                        <li>
                                                                            <span class="title">Full Name:</span>
                                                                            <span class="text">{{ $patient->name ?? 'N/A' }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Email:</span>
                                                                            <span class="text">{{ $patient->email ?? 'N/A' }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Phone:</span>
                                                                            <span class="text">{{ $patient->phone ?? 'N/A' }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Gender:</span>
                                                                            <span class="text">{{ $patient->gender ?? 'N/A' }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Age:</span>
                                                                            <span class="text">
                                                                                @if($patient->date_of_birth)
                                                                                    {{ Carbon::parse($patient->date_of_birth)->age }} years
                                                                                @else
                                                                                    N/A
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            
                                                            @if($booking->notes)
                                                                <div class="row mt-3">
                                                                    <div class="col-md-12">
                                                                        <h6 class="fw-bold mb-2">Additional Notes</h6>
                                                                        <p class="text-muted p-3 bg-light rounded">{{ $booking->notes }}</p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            
                                                            <hr>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex justify-content-end gap-2">
                                                                        @if ($now->lt($appointmentEnd))
                                                                            <a href="
                                                                                @if ($booking->appointment_type == 'chat')
                                                                                    {{ route('doctor.chat', ['booking' => $booking->id]) }}
                                                                                @elseif ($booking->appointment_type == 'video')
                                                                                    {{ route('doctor.video', ['booking' => $booking->id]) }}
                                                                                @elseif ($booking->appointment_type == 'voice')
                                                                                    {{ route('doctor.voice', ['booking' => $booking->id]) }}
                                                                                @endif
                                                                            " class="btn btn-primary">
                                                                                <i class="isax isax-calendar-tick5 me-1"></i> Attend
                                                                            </a>
                                                                        @endif
                                                                        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                                                                            <i class="isax isax-printer me-1"></i> Print
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    
                                    @if(!$hasUpcoming)
                                        <div class="text-center py-5">
                                            <img src="{{ asset('images/no-appointments.svg') }}" alt="No appointments" style="width: 150px; opacity: 0.5;">
                                            <p class="mt-3 text-muted">No upcoming appointments</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Upcoming Pagination -->
                                @if($hasUpcoming)
                                <div class="pagination mt-4" id="upcoming-pagination-container"></div>
                                @endif
                            </div>

                            <!-- COMPLETED APPOINTMENTS TAB -->
                            <div class="tab-pane fade" id="completed-bookings-container" role="tabpanel" aria-labelledby="pills-complete-tab">
                                <div id="completed-appointments-list">
                                    @php $hasCompleted = false; @endphp
                                    @foreach ($bookings as $booking)
                                        @if (Carbon::parse($booking->appointment_datetime)->lt(Carbon::now()))
                                            @php 
                                                $hasCompleted = true;
                                                $patient = $booking->patient;
                                                $patientImage = $patient?->profile_image 
                                                    ? asset('storage/' . $patient->profile_image) 
                                                    : asset('images/default.jpeg');
                                                $bookingId = str_pad($booking->id, 4, '0', STR_PAD_LEFT);
                                            @endphp
                                            <div class="appointment-wrap completed-appointment-item"
                                                 data-patient-name="{{ strtolower($patient->name ?? '') }}"
                                                 data-booking-id="apt000{{ $booking->id }}"
                                                 data-appointment-date="{{ $booking->appointment_datetime }}">
                                                <ul>
                                                    <li>
                                                        <div class="patinet-information">
                                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#completedAppointmentModal{{ $booking->id }}">
                                                                <img src="{{ asset($booking->doctor->profile->dp ?? 'images/profile-06.jpg') }}" onerror="this.src='{{ asset('images/default.jpeg') }}'">
                                                            </a>
                                                            <div class="patient-info">
                                                                <p>#APT000{{ $booking->id }}</p>
                                                                <h6>
                                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#completedAppointmentModal{{ $booking->id }}">
                                                                        {{ $patient->name ?? 'Unknown Patient' }}
                                                                    </a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="appointment-info">
                                                        <p><i class="isax isax-clock5"></i>{{ Carbon::parse($booking->appointment_datetime)->format('d M Y h:i A') }}</p>
                                                        <ul class="d-flex apponitment-types">
                                                            <li>{{ $booking->service_name ?? 'General Visit' }}</li>
                                                            <li><span class="badge bg-secondary">{{ ucfirst($booking->appointment_type) }}</span></li>
                                                            <li><span class="badge bg-success">Completed</span></li>
                                                        </ul>
                                                    </li>
                                                    <li class="appointment-detail-btn">
                                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#completedAppointmentModal{{ $booking->id }}" class="btn btn-outline-primary btn-sm">
                                                            <i class="isax isax-eye4 me-1"></i> View Details
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- APPOINTMENT DETAILS MODAL - COMPLETED -->
                                            <div class="modal fade custom-modal" id="completedAppointmentModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Appointment Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex align-items-center mb-4">
                                                                        <img src="{{ $patientImage }}" alt="{{ $patient->name ?? 'Patient' }}" 
                                                                             style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-right: 20px; border: 3px solid #28a745;"
                                                                             onerror="this.src='{{ asset('images/default.jpeg') }}'">
                                                                        <div>
                                                                            <h4 class="mb-1">{{ $patient->name ?? 'Unknown Patient' }}</h4>
                                                                            <p class="text-muted mb-1">Patient ID: #PAT{{ str_pad($patient->id ?? '0', 4, '0', STR_PAD_LEFT) }}</p>
                                                                            <span class="badge bg-success">Completed</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <hr>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6 class="fw-bold mb-3">Appointment Information</h6>
                                                                    <ul class="info-details">
                                                                        <li>
                                                                            <span class="title">Booking ID:</span>
                                                                            <span class="text">#APT000{{ $booking->id }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Date:</span>
                                                                            <span class="text">{{ Carbon::parse($booking->appointment_datetime)->format('F d, Y') }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Time:</span>
                                                                            <span class="text">{{ Carbon::parse($booking->appointment_datetime)->format('h:i A') }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Duration:</span>
                                                                            <span class="text">{{ $booking->service_time ?? 30 }} minutes</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Service:</span>
                                                                            <span class="text">{{ $booking->service_name ?? 'General Consultation' }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Type:</span>
                                                                            <span class="text"><span class="badge bg-secondary">{{ strtoupper($booking->appointment_type) }}</span></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <h6 class="fw-bold mb-3">Patient Information</h6>
                                                                    <ul class="info-details">
                                                                        <li>
                                                                            <span class="title">Full Name:</span>
                                                                            <span class="text">{{ $patient->name ?? 'N/A' }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Email:</span>
                                                                            <span class="text">{{ $patient->email ?? 'N/A' }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Phone:</span>
                                                                            <span class="text">{{ $patient->phone ?? 'N/A' }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Gender:</span>
                                                                            <span class="text">{{ $patient->gender ?? 'N/A' }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="title">Age:</span>
                                                                            <span class="text">
                                                                                @if($patient->date_of_birth)
                                                                                    {{ Carbon::parse($patient->date_of_birth)->age }} years
                                                                                @else
                                                                                    N/A
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            
                                                            @if($booking->notes)
                                                                <div class="row mt-3">
                                                                    <div class="col-md-12">
                                                                        <h6 class="fw-bold mb-2">Additional Notes</h6>
                                                                        <p class="text-muted p-3 bg-light rounded">{{ $booking->notes }}</p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            
                                                            <hr>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex justify-content-end gap-2">
                                                                        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                                                                            <i class="isax isax-printer me-1"></i> Print
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    
                                    @if(!$hasCompleted)
                                        <div class="text-center py-5">
                                            <img src="{{ asset('images/no-appointments.svg') }}" alt="No appointments" style="width: 150px; opacity: 0.5;">
                                            <p class="mt-3 text-muted">No completed appointments</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Completed Pagination -->
                                @if($hasCompleted)
                                <div class="pagination mt-4" id="completed-pagination"></div>
                                @endif
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

    <style>
        /* Appointment Card Styling */
        .appointment-wrap {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .appointment-wrap:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .appointment-wrap ul {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .patinet-information {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 250px;
        }
        
        .patinet-information img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        
        .patient-info p {
            color: #6c757d;
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .patient-info h6 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .patient-info h6 a {
            color: #2c3e50;
            text-decoration: none;
            cursor: pointer;
        }
        
        .patient-info h6 a:hover {
            color: #0d6efd;
        }
        
        .appointment-info {
            min-width: 200px;
        }
        
        .appointment-info p {
            margin-bottom: 8px;
            color: #495057;
            font-size: 14px;
        }
        
        .appointment-info p i {
            margin-right: 8px;
            color: #0d6efd;
        }
        
        .apponitment-types {
            gap: 10px;
        }
        
        .apponitment-types li {
            font-size: 13px;
            color: #6c757d;
        }
        
        .mail-info-patient ul {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .mail-info-patient li {
            font-size: 13px;
            color: #6c757d;
        }
        
        .mail-info-patient li i {
            margin-right: 8px;
            color: #0d6efd;
        }
        
        .appointment-action ul {
            gap: 10px;
        }
        
        .appointment-action li a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f8f9fa;
            color: #495057;
            transition: all 0.3s ease;
        }
        
        .appointment-action li a:hover {
            background: #0d6efd;
            color: white;
        }
        
        .appointment-detail-btn {
            margin-left: auto;
        }
        
        .appointment-time-status {
            margin-left: auto;
        }
        
        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 15px;
        }
        
        .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 20px 25px;
        }
        
        .modal-body {
            padding: 25px;
        }
        
        .info-details {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .info-details li {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-details li:last-child {
            border-bottom: none;
        }
        
        .info-details .title {
            width: 140px;
            font-weight: 600;
            color: #495057;
        }
        
        .info-details .text {
            flex: 1;
            color: #6c757d;
        }
        
        .details-header {
            width: 100%;
        }
        
        /* Badge styling */
        .badge {
            padding: 5px 10px;
            font-weight: 500;
            font-size: 12px;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .appointment-wrap ul {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .patinet-information {
                min-width: 100%;
            }
            
            .appointment-detail-btn {
                margin-left: 0;
                width: 100%;
            }
            
            .appointment-time-status {
                margin-left: 0;
                width: 100%;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .appointment-wrap {
            animation: fadeIn 0.5s ease;
        }
    </style>

    <script>
        // ============================================
        // APPOINTMENT MANAGEMENT - PURE BOOTSTRAP MODALS
        // ============================================
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeTooltips();
            initializeDateRangePicker();
            initializeSearch();
            
            // Initialize pagination for upcoming appointments
            initializePagination('upcoming');
            
            // Initialize pagination for completed appointments
            initializePagination('completed');
        });
        
        // ============================================
        // INITIALIZE TOOLTIPS
        // ============================================
        function initializeTooltips() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
        
        // ============================================
        // INITIALIZE DATE RANGE PICKER
        // ============================================
        function initializeDateRangePicker() {
            if (typeof $ !== 'undefined' && $.fn.daterangepicker) {
                $('.date-range').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        format: 'DD/MM/YYYY',
                        cancelLabel: 'Clear'
                    }
                });
                
                $('.date-range').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                    filterAppointmentsByDate(picker.startDate, picker.endDate);
                });
                
                $('.date-range').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    resetAppointmentFilters();
                });
            }
        }
        
        // ============================================
        // FILTER APPOINTMENTS BY DATE
        // ============================================
        function filterAppointmentsByDate(startDate, endDate) {
            const activeTab = document.querySelector('.tab-pane.active');
            if (activeTab.id === 'pills-upcoming') {
                filterItems('upcoming-appointment-item', startDate, endDate);
            } else {
                filterItems('completed-appointment-item', startDate, endDate);
            }
        }
        
        function filterItems(className, startDate, endDate) {
            const items = document.querySelectorAll(`.${className}`);
            
            items.forEach(item => {
                const dateStr = item.dataset.appointmentDate;
                const itemDate = new Date(dateStr);
                
                if (itemDate >= startDate && itemDate <= endDate) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        
        function resetAppointmentFilters() {
            const items = document.querySelectorAll('.upcoming-appointment-item, .completed-appointment-item');
            items.forEach(item => {
                item.style.display = '';
            });
        }
        
        // ============================================
        // INITIALIZE SEARCH
        // ============================================
        function initializeSearch() {
            const searchInput = document.getElementById('appointmentSearch');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const activeTab = document.querySelector('.tab-pane.active');
                    
                    if (activeTab.id === 'pills-upcoming') {
                        filterAppointmentsBySearch('upcoming-appointment-item', searchTerm);
                    } else {
                        filterAppointmentsBySearch('completed-appointment-item', searchTerm);
                    }
                });
            }
        }
        
        function filterAppointmentsBySearch(className, searchTerm) {
            const items = document.querySelectorAll(`.${className}`);
            let visibleCount = 0;
            
            items.forEach(item => {
                const patientName = item.dataset.patientName || '';
                const bookingId = item.dataset.bookingId || '';
                
                if (patientName.includes(searchTerm) || bookingId.includes(searchTerm)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show no results message if needed
            const container = document.getElementById(className === 'upcoming-appointment-item' ? 'upcoming-appointments-list' : 'completed-appointments-list');
            let noResultsMsg = container.querySelector('.no-results-message');
            
            if (visibleCount === 0) {
                if (!noResultsMsg) {
                    noResultsMsg = document.createElement('div');
                    noResultsMsg.className = 'text-center py-5 no-results-message';
                    noResultsMsg.innerHTML = `
                        <i class="isax isax-search-normal-1" style="font-size: 48px; color: #dee2e6;"></i>
                        <p class="mt-3 text-muted">No appointments found matching "${searchTerm}"</p>
                    `;
                    container.appendChild(noResultsMsg);
                }
            } else {
                if (noResultsMsg) {
                    noResultsMsg.remove();
                }
            }
        }
        
        // ============================================
        // INITIALIZE PAGINATION
        // ============================================
        function initializePagination(type) {
            const itemsPerPage = 5;
            const containerId = type === 'upcoming' ? 'upcoming-appointments-list' : 'completed-appointments-list';
            const paginationId = type === 'upcoming' ? 'upcoming-pagination-container' : 'completed-pagination';
            
            const container = document.getElementById(containerId);
            const paginationContainer = document.getElementById(paginationId);
            
            if (!container || !paginationContainer) return;
            
            const items = Array.from(container.children).filter(el => 
                el.classList.contains(type === 'upcoming' ? 'upcoming-appointment-item' : 'completed-appointment-item')
            );
            
            if (items.length === 0) return;
            
            let currentPage = 1;
            const totalPages = Math.ceil(items.length / itemsPerPage);
            
            function renderPage(page) {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                
                items.forEach((item, index) => {
                    item.style.display = index >= start && index < end ? '' : 'none';
                });
                
                renderPagination(page);
            }
            
            function renderPagination(page) {
                let html = '<nav><ul class="pagination justify-content-center">';
                
                html += `<li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="changePage('${type}', ${page - 1})">Prev</a>
                </li>`;
                
                for (let i = 1; i <= totalPages; i++) {
                    html += `<li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);" onclick="changePage('${type}', ${i})">${i}</a>
                    </li>`;
                }
                
                html += `<li class="page-item ${page === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="changePage('${type}', ${page + 1})">Next</a>
                </li>`;
                
                html += '</ul></nav>';
                paginationContainer.innerHTML = html;
            }
            
            window.changePage = function(type, page) {
                if (page < 1 || page > totalPages) return;
                currentPage = page;
                renderPage(page);
            };
            
            renderPage(1);
        }
    </script>

    <!-- jQuery -->
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

    <!-- Sticky Sidebar JS -->
    <script src="{{asset('js/ResizeSensor.js')}}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>

    <!-- select JS -->
    <script src="{{asset('js/select2.min.js')}}"></script>

    <!-- Daterangepikcer JS -->
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/daterangepicker.js')}}"></script>

    <!-- Custom JS -->
    <script src="{{asset('js/script.js')}}"></script>

</body>
</html>