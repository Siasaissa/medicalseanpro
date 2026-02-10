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
											<input type="text" class="form-control" placeholder="Search">
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
									<ul class="nav nav-pills inner-tab " id="pills-tab" role="tablist">
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
											<input type="text" class="form-control  date-range bookingrange" placeholder="From Date - To Date ">
										</div>
										<i class="isax isax-calendar-1"></i>
									</div>
									
									
								</div>
							</div>

							<div class="tab-content appointment-tab-content">
								<div class="tab-pane fade show active" id="pills-upcoming" role="tabpanel" aria-labelledby="pills-upcoming-tab">
									<!-- Appointment List -->

@foreach ($bookings as $booking)

    @php
        $appointmentStart = Carbon::parse($booking->appointment_datetime);
        $appointmentEnd = $appointmentStart->copy()->addMinutes((int)$booking->service_time);
        $now = Carbon::now();
    @endphp

    {{-- SHOW ONLY UPCOMING & CURRENT --}}
    @if ($now->lt($appointmentEnd))

        <div class="appointment-wrap">
            <ul>

                <li>
                    <div class="patinet-information">
                        <a href="#">
                            <img src="{{ asset($booking->doctor->profile->dp ?? 'images/profile-06.jpg') }}" alt="User Image">
                        </a>
                        <div class="patient-info">
                            <p>#Apt000{{ $booking->id }}</p>
                            <h6>{{ $booking->doctor->name }}</h6>
                        </div>
                    </div>
                </li>

                <li class="appointment-info">
                    <p><i class="isax isax-clock5"></i>{{ $booking->appointment_datetime }}</p>
                    <ul class="d-flex apponitment-types">
                        <li>General Visit</li>
                        <li>{{ $booking->appointment_type }}</li>
                    </ul>
                </li>

                <li class="mail-info-patient">
                    <ul>
                        <li><i class="isax isax-sms5"></i>{{ $booking->doctor->email }}</li>
                        <li><i class="isax isax-call5"></i>{{ $booking->phone }}</li>
                    </ul>
                </li>

                <li class="appointment-action">
                    <ul>
                        <li><a href="#"><i class="isax isax-eye4"></i></a></li>
                        <li><a href="#"><i class="isax isax-messages-25"></i></a></li>
                        <li><a href="#"><i class="isax isax-close-circle5"></i></a></li>
                    </ul>
                </li>

                {{-- IF APPOINTMENT IS CURRENT --}}
                @if ($now->between($appointmentStart, $appointmentEnd))
                    <li class="appointment-detail-btn">
                        <a href="
                            @if ($booking->appointment_type == 'chat')
                                {{ route('chat.index', ['booking' => $booking->id]) }}
                            @elseif ($booking->appointment_type == 'video')
                                {{ route('doctor.video', ['booking' => $booking->id]) }}
                            @elseif ($booking->appointment_type == 'voice')
                                {{ route('doctor.voice', ['booking' => $booking->id]) }}
                            @endif
                        " class="btn btn-md btn-primary-gradient">
                            <i class="isax isax-calendar-tick5 me-1"></i> Attend
                        </a>
                    </li>

                {{-- APPOINTMENT NOT STARTED --}}
                @elseif ($now->lt($appointmentStart))
                    <li><span class="text-warning">Appointment not started yet</span></li>

                @endif

            </ul>
        </div>

    @endif

@endforeach

								</div>
								</div>



								<div class="tab-pane fade" id="completed-bookings-container" role="tabpanel" aria-labelledby="pills-complete-tab">
									<!-- Appointment List -->
									 @foreach ($bookings as $booking)
										@if (Carbon::parse($booking->appointment_datetime)->lt(Carbon::now()))
									<div class="appointment-wrap">
										<ul>
											<li>
												<div class="patinet-information">
													<a href="doctor-completed-appointment.html">
														<img src="{{asset('images/profile-01.jpg')}}" alt="User Image">
													</a>
													<div class="patient-info">
														<p>#Apt000{{ $booking->id }}</p>
														<h6><a href="doctor-completed-appointment.html">{{ $booking->patient->name }}</a></h6>
													</div>
												</div>
											</li>
											<li class="appointment-info">
												<p><i class="isax isax-clock5"></i>{{ $booking->appointment_datetime }}</p>
												<ul class="d-flex apponitment-types">
													<li>General Visit</li>
													<li>{{ $booking->appointment_type }}</li>
												</ul>
												
											</li>
											<li class="appointment-detail-btn">
												<a href="#" class="start-link">View Details</a>
											</li>
										</ul>
									</div>
										@endif
									@endforeach
									</div>
									<!-- /Appointment List -->

									<!-- Appointment List -->
									
									<!-- /Appointment List -->

									<!-- Pagination -->
									
								</div>
									<!-- /Pagination -->
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
		
		<!-- Appointment Details Modal -->
		<div class="modal fade custom-modal" id="appt_details">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Appointment Details</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<ul class="info-details">
							<li>
								<div class="details-header">
									<div class="row">
										<div class="col-md-6">
											<span class="title">#APT0001</span>
											<span class="text">21 Oct 2023 10:00 AM</span>
										</div>
										<div class="col-md-6">
											<div class="text-end">
												<button type="button" class="btn bg-success-light btn-sm" id="topup_status">Completed</button>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li>
								<span class="title">Status:</span>
								<span class="text">Completed</span>
							</li>
							<li>
								<span class="title">Confirm Date:</span>
								<span class="text">29 Jun 2023</span>
							</li>
							<li>
								<span class="title">Paid Amount</span>
								<span class="text">$450</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<script>
		document.addEventListener('DOMContentLoaded', function () {
			const container = document.getElementById('completed-bookings-container');
			const items = Array.from(container.children); // all appointment-wrap divs
			const paginationContainer = document.getElementById('completed-pagination');
			const itemsPerPage = 5;
			let currentPage = 1;

			function renderPage(page = 1) {
				const start = (page - 1) * itemsPerPage;
				const end = start + itemsPerPage;

				// hide all items
				items.forEach(item => item.style.display = 'none');

				// show items for this page
				items.slice(start, end).forEach(item => item.style.display = 'block');

				renderPagination(page);
			}

			function renderPagination(page) {
				const totalPages = Math.ceil(items.length / itemsPerPage);
				let html = '';

				html += `<li><a href="#" class="page-link prev" ${page === 1 ? 'style="pointer-events:none;opacity:0.5;"' : ''}>Prev</a></li>`;

				for (let i = 1; i <= totalPages; i++) {
					html += `<li><a href="#" class="page-link ${i === page ? 'active' : ''}" data-page="${i}">${i}</a></li>`;
				}

				html += `<li><a href="#" class="page-link next" ${page === totalPages ? 'style="pointer-events:none;opacity:0.5;"' : ''}>Next</a></li>`;

				paginationContainer.innerHTML = html;

				// attach click events
				paginationContainer.querySelectorAll('.page-link').forEach(link => {
					link.addEventListener('click', function (e) {
						e.preventDefault();
						if (this.classList.contains('prev')) {
							if (currentPage > 1) currentPage--;
						} else if (this.classList.contains('next')) {
							if (currentPage < totalPages) currentPage++;
						} else {
							currentPage = parseInt(this.dataset.page);
						}
						renderPage(currentPage);
					});
				});
			}

			// initial render
			renderPage(currentPage);
		});
	</script>

		<!-- /Appointment Details Modal -->
	  
		<!-- jQuery -->
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

</body></html>