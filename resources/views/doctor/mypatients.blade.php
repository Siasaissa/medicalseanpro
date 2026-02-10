@include('layouts.head')

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
								<li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a>
								</li>
								<li class="breadcrumb-item" aria-current="page">Doctor</li>
								<li class="breadcrumb-item active">My Patients</li>
							</ol>
							<h2 class="breadcrumb-title">My Patients</h2>
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
		<div class="content doctor-content">
			<div class="container">

				<div class="row">
					<div class="col-lg-4 col-xl-3 theiaStickySidebar">

						<!-- Profile Sidebar -->
						@include('layouts.doctorSidebar')
						<!-- /Profile Sidebar -->

					</div>
					<div class="col-lg-8 col-xl-9">

						<div class="dashboard-header">
							<h3>My Patients</h3>
							<ul class="header-list-btns">
								<li>
									<div class="input-block dash-search-input">
										<input type="text" class="form-control" placeholder="Search">
										<span class="search-icon"><i class="isax isax-search-normal"></i></span>
									</div>
								</li>
							</ul>
						</div>
						<div class="appointment-tab-head">
							<div class="appointment-tabs">
								<ul class="nav nav-pills inner-tab " id="pills-tab" role="tablist">
									<li class="nav-item" role="presentation">
										<button class="nav-link active" id="pills-upcoming-tab" data-bs-toggle="pill"
											data-bs-target="#pills-upcoming" type="button" role="tab"
											aria-controls="pills-upcoming"
											aria-selected="false">Active<span>{{ $total }}</span></button>
									</li>
								</ul>
							</div>
							<div class="filter-head">
								<div class="position-relative daterange-wraper me-2">
									<div class="input-groupicon calender-input">
										<input type="text" class="form-control  date-range bookingrange"
											placeholder="From Date - To Date ">
									</div>
									<i class="isax isax-calendar-1"></i>
								</div>
								<div class="form-sorts dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" id="table-filter"><i
											class="isax isax-filter me-2"></i>Filter By</a>
									<div class="filter-dropdown-menu">
										<div class="filter-set-view">
											<div class="accordion" id="accordionExample">
												<div class="filter-set-content">
													<div class="filter-set-content-head">
														<a href="#" data-bs-toggle="collapse"
															data-bs-target="#collapseTwo" aria-expanded="false"
															aria-controls="collapseTwo">Name<i
																class="fa-solid fa-chevron-right"></i></a>
													</div>
													<div class="filter-set-contents accordion-collapse collapse show"
														id="collapseTwo" data-bs-parent="#accordionExample">
														<ul>
															<li>
																<div class="input-block dash-search-input w-100">
																	<input type="text" class="form-control"
																		placeholder="Search">
																	<span class="search-icon"><i
																			class="fa-solid fa-magnifying-glass"></i></span>
																</div>
															</li>
														</ul>
													</div>
												</div>
												<div class="filter-set-content">
													<div class="filter-set-content-head">
														<a href="#" data-bs-toggle="collapse"
															data-bs-target="#collapseOne" aria-expanded="true"
															aria-controls="collapseOne">Appointment Type<i
																class="fa-solid fa-chevron-right"></i></a>
													</div>
													<div class="filter-set-contents accordion-collapse collapse show"
														id="collapseOne" data-bs-parent="#accordionExample">
														<ul>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox" checked="">
																		<span class="checkmarks"></span>
																		<span class="check-title">All Type</span>
																	</label>
																</div>
															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Video Call</span>
																	</label>
																</div>
															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Audio Call</span>
																	</label>
																</div>
															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Chat</span>
																	</label>
																</div>
															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Direct Visit</span>
																	</label>
																</div>
															</li>
														</ul>
													</div>
												</div>
												<div class="filter-set-content">
													<div class="filter-set-content-head">
														<a href="#" data-bs-toggle="collapse"
															data-bs-target="#collapseThree" aria-expanded="false"
															aria-controls="collapseThree">Visit Type<i
																class="fa-solid fa-chevron-right"></i></a>
													</div>
													<div class="filter-set-contents accordion-collapse collapse show"
														id="collapseThree" data-bs-parent="#accordionExample">
														<ul>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox" checked="">
																		<span class="checkmarks"></span>
																		<span class="check-title">All Visit</span>
																	</label>
																</div>

															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">General</span>
																	</label>
																</div>

															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Consultation</span>
																	</label>
																</div>

															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Follow-up</span>
																	</label>
																</div>

															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Direct Visit</span>
																	</label>
																</div>

															</li>
														</ul>
													</div>
												</div>
											</div>

											<div class="filter-reset-btns">
												<a href="#" class="btn btn-light">Reset</a>
												<a href="#" class="btn btn-primary">Filter Now</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-content appointment-tab-content grid-patient">
							<div class="tab-pane fade show active" id="pills-upcoming" role="tabpanel"
								aria-labelledby="pills-upcoming-tab">
								<div class="row">

									<!-- Appointment Grid -->
									@foreach ($Mypatient as $patient)
									<div class="col-xl-6 col-lg-8 col-md-8 d-flex">
										<div class="appointment-wrap appointment-grid-wrap">
											<ul>
												<li>
													<div class="appointment-grid-head">
														<div class="patinet-information">
															<a href="patient-profile.html">
																<img src="{{ isset($patient->patient->profile->dp) && file_exists(public_path($patient->patient->profile->dp))
																? asset($patient->patient->profile->dp)
																: asset('images/default.jpeg') }}" alt="User Image">
															</a>


															<div class="patient-info">
																<p>#Apt000{{ $patient->patient->id }}</p>
																<h6><a
																		href="patient-profile.html">{{ $patient->patient->name }}</a>
																</h6>
																<ul>
																	@php
																		$dob = $patient->patient->profile->dob ?? null;
																		$ageText = 'Not set';

																		if ($dob) {
																			try {
																				$dobDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dob);
																			} catch (\Exception $e) {
																				$dobDate = \Carbon\Carbon::parse($dob);
																			}

																			$years = (int) $dobDate->diffInYears(now());
																			$months = (int) $dobDate->copy()->addYears($years)->diffInMonths(now());
																			$ageText = "{$years} Years {$months} Month";
																		}
																	@endphp

																	<li>Age : {{ $ageText }}</li>
																	<li>Sex: {{ $patient->patient->profile->sex ?? 'Not set' }}
																	</li>
																	<li>Blood Group: {{ $patient->patient->profile->blood_group ?? 'Not set' }}
																	</li>
																</ul>
															</div>

														</div>
													</div>
												</li>
												<li class="appointment-info">
													<p><i class="isax isax-clock5"></i>Join : {{ $patient->patient->created_at }}</p>
													<p class="mb-0"><i class="isax isax-location5"></i>{{ $patient->patient->profile->address }}</p>
												</li>
												<li class="appointment-action">
													<div class="patient-book">
														<p><i class="isax isax-calendar-1"></i>Last Booking <span>{{ \Carbon\Carbon::parse($patient->last_appointment)->format('M d, Y h:i A') }}</span></p>
													</div>
												</li>
											</ul>
										</div>
									</div>
									@endforeach
									<!-- /Appointment Grid -->


									<div class="col-md-12">
										<div class="loader-item text-center">
											<a href="javascript:void(0);" class="btn btn-load">Load More</a>
										</div>
									</div>

								</div>
							</div>
							<div class="tab-pane fade" id="pills-cancel" role="tabpanel"
								aria-labelledby="pills-cancel-tab">
								<div class="row">
									<!-- Appointment Grid -->
									<div class="col-xl-4 col-lg-6 col-md-6 d-flex">
										<div class="appointment-wrap appointment-grid-wrap">
											<ul>
												<li>
													<div class="appointment-grid-head">
														<div class="patinet-information">
															<a href="patient-profile.html">
																<img src="images/profile-06.jpg" alt="User Image">
															</a>
															<div class="patient-info">
																<p>#Apt0006</p>
																<h6><a href="patient-profile.html">Anderea Kearns</a>
																</h6>
																<ul>
																	<li>Age : 40</li>
																	<li>Female</li>
																	<li>B-</li>
																</ul>
															</div>
														</div>
													</div>
												</li>
												<li class="appointment-info">
													<p><i class="isax isax-clock5"></i>26 Sep 2024 10.20 AM</p>
													<p class="mb-0"><i class="isax isax-location5"></i>San Francisco,
														USA</p>
												</li>
												<li class="appointment-action">
													<div class="patient-book">
														<p><i class="isax isax-calendar-1"></i>Last Booking<span>11 Feb
																2024</span></p>

													</div>
												</li>
											</ul>
										</div>
									</div>
									<!-- /Appointment Grid -->

									<!-- Appointment Grid -->
									<div class="col-xl-4 col-lg-6 col-md-6 d-flex">
										<div class="appointment-wrap appointment-grid-wrap">
											<ul>
												<li>
													<div class="appointment-grid-head">
														<div class="patinet-information">
															<a href="patient-profile.html">
																<img src="images/profile-01.jpg" alt="User Image">
															</a>
															<div class="patient-info">
																<p>#Apt0009</p>
																<h6><a href="patient-profile.html">Darrell Tan</a></h6>
																<ul>
																	<li>Age : 31</li>
																	<li>Male</li>
																	<li>AB+</li>
																</ul>
															</div>
														</div>
													</div>
												</li>
												<li class="appointment-info">
													<p><i class="isax isax-clock5"></i>25 Aug 2024 10.45 AM</p>
													<p class="mb-0"><i class="isax isax-location5"></i>San Antonio, USA
													</p>
												</li>
												<li class="appointment-action">
													<div class="patient-book">
														<p><i class="isax isax-calendar-1"></i>Last Booking<span>03 Jan
																2024</span></p>

													</div>
												</li>
											</ul>
										</div>
									</div>
									<!-- /Appointment Grid -->

									<!-- Appointment Grid -->
									<div class="col-xl-4 col-lg-6 col-md-6 d-flex">
										<div class="appointment-wrap appointment-grid-wrap">
											<ul>
												<li>
													<div class="appointment-grid-head">
														<div class="patinet-information">
															<a href="patient-profile.html">
																<img src="images/profile-04.jpg" alt="User Image">
															</a>
															<div class="patient-info">
																<p>#Apt0004</p>
																<h6><a href="patient-profile.html">Catherine Gracey</a>
																</h6>
																<ul>
																	<li>Age : 36</li>
																	<li>Female</li>
																	<li>AB-</li>
																</ul>
															</div>
														</div>
													</div>
												</li>
												<li class="appointment-info">
													<p><i class="isax isax-clock5"></i>18 Oct 2024 12.20 PM</p>
													<p class="mb-0"><i class="isax isax-location5"></i>Los Angeles, USA
													</p>
												</li>
												<li class="appointment-action">
													<div class="patient-book">
														<p><i class="isax isax-calendar-1"></i>Last Booking<span>27 Feb
																2024</span></p>

													</div>
												</li>
											</ul>
										</div>
									</div>
									<!-- /Appointment Grid -->

									<div class="col-md-12">
										<div class="loader-item text-center">
											<a href="javascript:void(0);" class="btn btn-load">Load More</a>
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
	<script src="js/jquery-3.7.1.min.js" type="9feca4b212392c17146fe5c8-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="js/bootstrap.bundle.min.js" type="9feca4b212392c17146fe5c8-text/javascript"></script>

	<!-- Sticky Sidebar JS -->
	<script src="js/ResizeSensor.js" type="9feca4b212392c17146fe5c8-text/javascript"></script>
	<script src="js/theia-sticky-sidebar.js" type="9feca4b212392c17146fe5c8-text/javascript"></script>

	<!-- Datetimepicker JS -->
	<script src="js/moment.min.js" type="9feca4b212392c17146fe5c8-text/javascript"></script>
	<script src="js/bootstrap-datetimepicker.min.js" type="9feca4b212392c17146fe5c8-text/javascript"></script>

	<!-- Select2 JS -->
	<script src="js/select2.min.js" type="9feca4b212392c17146fe5c8-text/javascript"></script>

	<!-- Daterangepikcer JS -->
	<script src="js/moment.min.js" type="9feca4b212392c17146fe5c8-text/javascript"></script>
	<script src="js/daterangepicker.js" type="9feca4b212392c17146fe5c8-text/javascript"></script>

	<!-- Custom JS -->
	<script src="js/script.js" type="9feca4b212392c17146fe5c8-text/javascript"></script>

	<script src="js/rocket-loader.min.js" data-cf-settings="9feca4b212392c17146fe5c8-|49" defer=""></script>
	<script defer=""
		src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
		data-cf-beacon="{"
		version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"=""
		crossorigin="anonymous"></script>


</body>

</html>ß