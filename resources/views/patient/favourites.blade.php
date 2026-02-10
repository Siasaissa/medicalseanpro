@include ('layouts.head')
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
			@include ('layouts.header')
			<!-- /Header -->

			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container">
					<div class="row align-items-center inner-banner">
						<div class="col-md-12 col-12 text-center">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a></li>
									<li class="breadcrumb-item" aria-current="page">Patient</li>
									<li class="breadcrumb-item active">Favourites</li>
								</ol>
								<h2 class="breadcrumb-title">Favourites</h2>
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
			<div class="content doctor-content">
				<div class="container">
					<div class="row">

						<!-- Profile Sidebar -->
						@include ('layouts.sidebar')
						<!-- / Profile Sidebar -->

						<div class="col-lg-8 col-xl-9">

							<div class="dashboard-header">
								<h3>Favourites</h3>
								<ul class="header-list-btns">
									<li>
										<div class="input-block dash-search-input">
											<input type="text" class="form-control" placeholder="Search">
											<span class="search-icon"><i class="isax isax-search-normal"></i></span>
										</div>
									</li>
								</ul>
							</div>

							<!-- Favourites -->
							<div class="row">
								@foreach ($favourite as $fav )
								<div class="col-md-8 col-lg-6 d-flex">
									<div class="profile-widget patient-favour flex-fill">
										<div class="fav-head">
											<a href="javascript:void(0)" class="fav-btn favourite-btn">
												<span class="favourite-icon favourite"><i class="isax isax-heart5"></i></span>
											</a>
											<div class="doc-img">
												<a href="doctor-profile.html">
													<img class="img-fluid" alt="User Image" src="{{ asset($fav->doctor->profile->dp) ?? asset('images/profile-06.jp') }}">
												</a>
											</div>
											<div class="pro-content">
												<h3 class="title">
													<a href="doctor-profile.html">{{ $fav->doctor->name }}</a> 
													<i class="isax isax-tick-circle5 verified"></i>
												</h3>
												<p class="speciality">{{ $fav->doctor->profile->service }}</p>
												<div class="rating">
													<i class="fas fa-star filled"></i>
													<i class="fas fa-star filled"></i>
													<i class="fas fa-star filled"></i>
													<i class="fas fa-star filled"></i>
													<i class="fas fa-star filled"></i>
													<span class="d-inline-block average-rating">5.0</span>
												</div>
												<ul class="available-info">
													<li>
														<i class="isax isax-calendar5 me-1"></i><span>Total Booking :</span> {{ $fav->total }}
													</li>
													<li>
														<i class="isax isax-location5 me-1"></i><span>Location :</span> {{ $fav->doctor->profile->address ?? 'Not filled' }}
													</li>
												</ul>
												<div class="last-book">
													<p>Last Book on {{ \Carbon\Carbon::parse($fav->last_appointment)->format('M d, Y h:i A') }}</p>
												</div>
											</div>
										</div>
										<div class="fav-footer">
											<div class="row row-sm">
												<div class="col-6">
													<a href="doctor-profile.html" class="btn btn-md btn-light w-100">View Details</a>
												</div>
												<div class="col-6">
													<a href="{{ route('patient.booking', ['doctor' => $fav->doctor_id]) }}" class="btn btn-md btn-outline-primary w-100">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								@endforeach
								
								
							</div>
							<!-- /Favourites -->

							<div class="col-md-12">
								<div class="loader-item text-center mt-0">
									<a href="javascript:void(0);" class="btn btn-outline-primary rounded-pill">Load More</a>
								</div>
							</div>	

						</div>
					</div>
				</div>

			</div>		
			<!-- /Page Content -->
   
			<!-- Footer Section -->
			@include ('layouts.footer')
			<!-- /Footer Section -->
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="js/jquery-3.7.1.min.js" type="c57b5dba41739cec7fe2f995-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="js/bootstrap.bundle.min.js" type="c57b5dba41739cec7fe2f995-text/javascript"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="js/ResizeSensor.js" type="c57b5dba41739cec7fe2f995-text/javascript"></script>
        <script src="js/theia-sticky-sidebar.js" type="c57b5dba41739cec7fe2f995-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="js/script.js" type="c57b5dba41739cec7fe2f995-text/javascript"></script>
		
	<script src="js/rocket-loader.min.js" data-cf-settings="c57b5dba41739cec7fe2f995-|49" defer=""></script>
</body></html>