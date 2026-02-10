@include ('layouts.head')

<body>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		@include ('layouts.header')
		<!-- /Header -->

		<!-- Breadcrumb -->
		<div class="breadcrumb-bar overflow-visible">
			<div class="container">
				<div class="row align-items-center inner-banner">
					<div class="col-md-12 col-12 text-center">
						<nav aria-label="breadcrumb" class="page-breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a></li>
								<li class="breadcrumb-item">Doctor</li>
								<li class="breadcrumb-item active">Doctor Grid</li>
							</ol>
							<h2 class="breadcrumb-title">Doctor Grid</h2>
						</nav>
					</div>
				</div>
				<div class="bg-primary-gradient rounded-pill doctors-search-box">
					<div class="search-box-one rounded-pill">
						<form action="search-2.html"> 
							<div class="search-input search-line">
								<i class="isax isax-hospital5 bficon"></i>
								<div class=" mb-0">
									<input type="text" class="form-control" placeholder="Search for Doctors, Hospitals, Clinics">
								</div>
							</div>
							<div class="search-input search-map-line">
								<i class="isax isax-location5"></i>
								<div class=" mb-0">
									<input type="text" class="form-control" placeholder="Location"> 
								</div>
							</div>
							<div class="search-input search-calendar-line">
								<i class="isax isax-calendar-tick5"></i>
								<div class=" mb-0">
									<input type="text" class="form-control datetimepicker" placeholder="Date">
								</div>
							</div>
							<div class="form-search-btn">
								<button class="btn btn-primary d-inline-flex align-items-center rounded-pill" type="submit"><i class="isax isax-search-normal-15 me-2"></i>Search</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="breadcrumb-bg">
				<img src="{{asset('images/breadcrumb-bg-01.pn')}}g" alt="img" class="breadcrumb-bg-01">
				<img src="{{asset('images/breadcrumb-bg-02.png')}}" alt="img" class="breadcrumb-bg-02">
				<img src="{{asset('images/breadcrumb-icon.webp')}}" alt="img" class="breadcrumb-bg-03">
				<img src="{{asset('images/breadcrumb-icon.webp')}}" alt="img" class="breadcrumb-bg-04">
			</div>
		</div>
		<!-- /Breadcrumb -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
		<div class="content mt-5">
			<div class="container">
				<div class="row">
					<div class="col-xl-3">
						<div class="card filter-lists">
							<div class="card-header">
								<div class="d-flex align-items-center filter-head justify-content-between">
									<h4>Filter</h4>
									<a href="#" class="text-secondary text-decoration-underline">Clear All</a>
								</div>
								<div class="filter-input">
									<div class="position-relative input-icon">
										<input type="text" class="form-control">
										<span><i class="isax isax-search-normal-1"></i></span>
									</div>
								</div>
							</div>
							<div class="card-body p-0">
								<div class="accordion-item border-bottom">
									<div class="accordion-header" id="heading1">
										<div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-controls="collapse1" role="button">
											<div class="d-flex align-items-center w-100">
												<h5>Specialities</h5>
												<div class="ms-auto">
													<span><i class="fas fa-chevron-down"></i></span>
												</div>
											</div>
										</div>
									</div>
									<div id="collapse1" class="accordion-collapse show" aria-labelledby="heading1">
										<div class="accordion-body pt-3">
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm2" checked="">
													<label class="form-check-label" for="checkebox-sm2">
														Urology
													</label>
												</div>
												<span class="filter-badge">21</span>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm3">
													<label class="form-check-label" for="checkebox-sm3">
														Psychiatry
													</label>
												</div>
												<span class="filter-badge">21</span>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm4">
													<label class="form-check-label" for="checkebox-sm4">
														Cardiology
													</label>
												</div>
												<span class="filter-badge">21</span>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm5">
													<label class="form-check-label" for="checkebox-sm5">
														Pediatrics
													</label>
												</div>
												<span class="filter-badge">21</span>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm6">
													<label class="form-check-label" for="checkebox-sm6">
														Urology
													</label>
												</div>
												<span class="filter-badge">21</span>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm7">
													<label class="form-check-label" for="checkebox-sm7">
														Neurology
													</label>
												</div>
												<span class="filter-badge">21</span>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm8">
													<label class="form-check-label" for="checkebox-sm8">
														Pulmonology
													</label>
												</div>
												<span class="filter-badge">21</span>
											</div>
											<div class="view-content">
												<div class="viewall-one">
													<div class="d-flex align-items-center justify-content-between mb-2">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="" id="checkebox-sm9">
															<label class="form-check-label" for="checkebox-sm9">
																Orthopedics
															</label>
														</div>
														<span class="filter-badge">21</span>
													</div>
													<div class="d-flex align-items-center justify-content-between mb-2">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="" id="checkebox-sm10">
															<label class="form-check-label" for="checkebox-sm10">
																Endocrinology
															</label>
														</div>
														<span class="filter-badge">21</span>
													</div>
												</div>
												<div class="view-all">
													<a href="javascript:void(0);" class="viewall-button-one text-secondary text-decoration-underline">View More</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="accordion-item border-bottom">
									<div class="accordion-header" id="heading2">
										<div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-controls="collapse2" role="button">
											<div class="d-flex align-items-center w-100">
												<h5>Gender</h5>
												<div class="ms-auto">
													<span><i class="fas fa-chevron-down"></i></span>
												</div>
											</div>
										</div>
									</div>
									<div id="collapse2" class="accordion-collapse show" aria-labelledby="heading2">
										<div class="accordion-body pt-3">
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm11" checked="">
													<label class="form-check-label" for="checkebox-sm11">
														Male
													</label>
												</div>
												<span class="filter-badge">21</span>
											</div>
											<div class="d-flex align-items-center justify-content-between">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm12">
													<label class="form-check-label" for="checkebox-sm12">
														Female
													</label>
												</div>
												<span class="filter-badge">21</span>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="accordion-item border-bottom">
									<div class="accordion-header" id="heading6">
										<div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-controls="collapse6" role="button">
											<div class="d-flex align-items-center w-100">
												<h5>Clinics</h5>
												<div class="ms-auto">
													<span><i class="fas fa-chevron-down"></i></span>
												</div>
											</div>
										</div>
									</div>
									<div id="collapse6" class="accordion-collapse show" aria-labelledby="heading6">
										<div class="accordion-body pt-3">
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm25" checked="">
													<label class="form-check-label" for="checkebox-sm25">
														Bright Smiles Dental Clinic
													</label>
												</div>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm26">
													<label class="form-check-label" for="checkebox-sm26">
														Family Care Clinic
													</label>
												</div>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm27">
													<label class="form-check-label" for="checkebox-sm27">
														Express Health Clinic
													</label>
												</div>
											</div>
											<div class="view-content">
												<div class="viewall-4">
													<div class="d-flex align-items-center justify-content-between mb-2">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="" id="checkebox-sm28">
															<label class="form-check-label" for="checkebox-sm28">
																Restore Physical Therapy
															</label>
														</div>
													</div>
													<div class="d-flex align-items-center justify-content-between mb-2">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="" id="checkebox-sm29">
															<label class="form-check-label" for="checkebox-sm29">
																Blossom Women’s Health Clinic
															</label>
														</div>
													</div>
												</div>
												<div class="view-all">
													<a href="javascript:void(0);" class="viewall-button-4 text-secondary text-decoration-underline">View More</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="accordion-item border-bottom">
									<div class="accordion-header" id="heading7">
										<div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-controls="collapse7" role="button">
											<div class="d-flex align-items-center w-100">
												<h5>Consultation type</h5>
												<div class="ms-auto">
													<span><i class="fas fa-chevron-down"></i></span>
												</div>
											</div>
										</div>
									</div>
									<div id="collapse7" class="accordion-collapse show" aria-labelledby="heading7">
										<div class="accordion-body pt-3">
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm30" checked="">
													<label class="form-check-label" for="checkebox-sm30">
														Audio Call
													</label>
												</div>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm31">
													<label class="form-check-label" for="checkebox-sm31">
														Video Call
													</label>
												</div>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm32">
													<label class="form-check-label" for="checkebox-sm32">
														Instant Counseling
													</label>
												</div>
											</div>
											<div class="d-flex align-items-center justify-content-between">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm33">
													<label class="form-check-label" for="checkebox-sm33">
														Chat
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="accordion-item border-bottom">
									<div class="accordion-header" id="heading8">
										<div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-controls="collapse8" role="button">
											<div class="d-flex align-items-center w-100">
												<h5>Languages</h5>
												<div class="ms-auto">
													<span><i class="fas fa-chevron-down"></i></span>
												</div>
											</div>
										</div>
									</div>
									<div id="collapse8" class="accordion-collapse show" aria-labelledby="heading8">
										<div class="accordion-body pt-3">
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm34" checked="">
													<label class="form-check-label" for="checkebox-sm34">
														English
													</label>
												</div>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkebox-sm35">
													<label class="form-check-label" for="checkebox-sm35">
														Swahili
													</label>
												</div>
											</div>
											
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<div class="col-xl-9">
						<div class="row align-items-center">
							<div class="col-md-6">
								<div class="mb-4">
									<h3>Showing <span class="text-secondary">450</span> Doctors For You</h3>
								</div>
							</div>
							<div class="col-md-6">
								<div class="d-flex align-items-center justify-content-end mb-4">
									<div class="doctor-filter-availability me-2">
    <p>Availability</p>
    <div class="status-toggle status-tog">
        <input type="checkbox" id="availabilityFilter" class="check">
        <label for="availabilityFilter" class="checktoggle">checkbox</label>
    </div>
</div>

									<div class="dropdown header-dropdown me-2">
										<a class="dropdown-toggle sort-dropdown" data-bs-toggle="dropdown" href="javascript:void(0);" aria-expanded="false">
											<span>Sort By</span>Price (Low to High)
										</a>
										<div class="dropdown-menu dropdown-menu-end">
											<a href="javascript:void(0);" class="dropdown-item">
												Price (Low to High)
											</a>
											<a href="javascript:void(0);" class="dropdown-item">
												Price (High to Low)
											</a>
										</div>
									</div>
									<a href="doctor-grid.html" class="btn btn-sm head-icon active me-2"><i class="isax isax-grid-7"></i></a>
									<a href="search-2.html" class="btn btn-sm head-icon me-2"><i class="isax isax-row-vertical"></i></a>
									<a href="map-list.html" class="btn btn-sm head-icon"><i class="isax isax-location"></i></a>
								</div>
							</div>
						</div>
						<div class="row">
                            @foreach ( $doctor as $doctors)
							<div class="col-xxl-4 col-md-6">
								<div class="card">
									<div class="card-img card-img-hover">
										<img src="{{asset($doctors->profile->dp)}}" alt="">
										<div class="grid-overlay-item d-flex align-items-center justify-content-between">
											<span class="badge bg-orange"><i class="fa-solid fa-star me-1"></i>5.0</span>
											<a href="javascript:void(0)" class="fav-icon">
												<i class="fa fa-heart"></i>
											</a>
										</div>
									</div>
									<div class="card-body p-0">
										<div class="d-flex active-bar align-items-center justify-content-between p-3">
											<a href="#" class="text-indigo fw-medium fs-14">{{ $doctors->profile->speciality }}</a>
											@if ($doctors->profile->availability == 'available')
											<span class="badge bg-success-light d-inline-flex align-items-center">
												<i class="fa-solid fa-circle fs-5 me-1"></i>
												Available
											</span>
											@elseif($doctors->profile->availability == 'not_available')
											<span class="badge bg-danger-light d-inline-flex align-items-center">
												<i class="fa-solid fa-circle fs-5 me-1"></i>
												Not Available
											</span>
											@endif
										</div>
										<div class="p-3 pt-0">
											<div class="doctor-info-detail mb-3 pb-3">
												<h3 class="mb-1">Dr.{{ $doctors->name }}</h3>
												<div class="d-flex align-items-center">
													<p class="d-flex align-items-center mb-0 fs-14"><i class="isax isax-location me-2"></i>{{ $doctors->profile->address ?? 'Not yet' }}</p>
													<i class="fa-solid fa-circle fs-5 text-primary mx-2 me-1"></i>
													<span class="fs-14 fw-medium">30 Min</span>
												</div>
											</div>
											<div class="d-flex align-items-center justify-content-between">
												<div>
													<p class="mb-1">Consultation Fees</p>
													<h3 class="text-orange">Tsh 650</h3>
												</div>
												<a href="{{ route('patient.booking', ['doctor' => $doctors->id]) }}" 
                                                class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
                                                <i class="isax isax-calendar-1 me-2"></i>
                                                Book Now
                                                </a>
											</div>
										</div>
									</div>
								</div>
							</div>
                            @endforeach

							<div class="col-md-12">
								<div class="text-center mb-4">
									<a href="login.html" class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill">
										<i class="isax isax-d-cube-scan5 me-2"></i>
										Load More 425 Doctors
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Footer Section -->
		@include('layouts.footer')
		<!-- /Footer Section -->

		<!-- Cursor -->
		<div class="mouse-cursor cursor-outer"></div>
		<div class="mouse-cursor cursor-inner"></div>
		<!-- /Cursor -->

	</div>
	<!-- /Main Wrapper -->

	</script>

	<!-- /Edit Dependent Modal-->

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
		defer="">
	    
	</script>

<script src="js/rocket-loader.min.js" data-cf-settings="07376c6329b84ec49a5fbc3b-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" rayid":"97c5dceedd5c6650","servertiming":{"name":{"cfextpri":true,"cfedge":true,"cforigin":true,"cfl4":true,"cfspeedbrain":true,"cfcachestatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}"="" crossorigin="anonymous"></script>


</body></html>