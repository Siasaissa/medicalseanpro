<!DOCTYPE html><html lang="en"><head>
		
		<meta charset="utf-8">
		<title>Doccure</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
		<meta name="keywords" content="practo clone, doccure, doctor appointment, Practo clone html template, doctor booking template">
		<meta name="author" content="Practo Clone HTML Template - Doctor Booking Template">
		<meta property="og:url" content="https://doccure.dreamstechnologies.com/html/">
		<meta property="og:type" content="website">
		<meta property="og:title" content="Doctors Appointment HTML Website Templates | Doccure">
		<meta property="og:description" content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
		<meta property="og:image" content="images/preview-banner.jpg">
		<meta name="twitter:card" content="summary_large_image">
		<meta property="twitter:domain" content="https://doccure.dreamstechnologies.com/html/">
		<meta property="twitter:url" content="https://doccure.dreamstechnologies.com/html/">
		<meta name="twitter:title" content="Doctors Appointment HTML Website Templates | Doccure">
		<meta name="twitter:description" content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
		<meta name="twitter:image" content="assets/img/preview-banner.jpg">	
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">

		<!-- Theme Settings Js -->
		<script src="js/theme-script.js" type="4b581727c1832abe60b6cf22-text/javascript"></script>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="css/fontawesome.min.css">
		<link rel="stylesheet" href="css/all.min.css">

		<!-- Iconsax CSS-->
		<link rel="stylesheet" href="css/iconsax.css">

		<!-- Feathericon CSS -->
    	<link rel="stylesheet" href="css/feather.css">

    	<!-- Mobile CSS-->
		<link rel="stylesheet" href="css/intlTelInput.css">
    	<link rel="stylesheet" href="css/demo.css">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="css/custom.css">
	
	</head>
	<body class="account-page">

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
			<header class="header header-custom header-fixed inner-header relative">
				<div class="container">
					<nav class="navbar navbar-expand-lg header-nav">
						<div class="navbar-header">
							<a id="mobile_btn" href="javascript:void(0);">
								<span class="bar-icon">
									<span></span>
									<span></span>
									<span></span>
								</span>
							</a>
							<a href="index.html" class="navbar-brand logo">
								<img src="images/logo.svg" class="img-fluid" alt="Logo">
							</a>
						</div>
						<div class="header-menu">
							<div class="main-menu-wrapper">
								<div class="menu-header">
									<a href="index.html" class="menu-logo">
										<img src="images/logo.svg" class="img-fluid" alt="Logo">
									</a>
									<a id="menu_close" class="menu-close" href="javascript:void(0);">
										<i class="fas fa-times"></i>
									</a>
								</div>
								<ul class="main-nav">
									<li class="has-submenu">
										<a href="doctor-grid01.html">Doctors</i></a>		
									</li>
									<li class="has-submenu">
										<a href="pharmacy-index.html">Pharmacy</i></a>
									</li>
									<li class="has-submenu">
										<a href="about-us.html">About Us</a>
									</li>
									<li class="has-submenu">
										<a href="blog-grid.html">Blog Grid</i></a>
									</li>
									
								</ul>
							</div>
							<ul class="nav header-navbar-rht">
								<li class="searchbar">
									<a href="javascript:void(0);"><i class="feather-search"></i></a>
									<div class="togglesearch">
										<form action="search.html">
											<div class="input-group">
												<input type="text" class="form-control">
												<button type="submit" class="btn">Search</button>
											</div>
										</form>
									</div>
								</li>
								
								<li>
									<a href="{{ route('login')  }}" class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
										<i class="isax isax-user-tick me-1"></i>Login
									</a>
								</li>
							</ul>
						</div>
					</nav>
				</div>
			</header>
			<!-- /Header -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
							
							<!-- Login Tab Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="images/login-banner.png" class="img-fluid" alt="Doccure Login">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Patient Register <a href="{{ route('doctor-register') }}">Are you a Doctor?</a></h3>
										</div>
										    <form method="POST" action="{{ route('register') }}">
                                              @csrf

											<div class="mb-3">
												<label class="form-label">Name</label>
												<input id="name" type="text" name="name" required autofocus autocomplete="name"  class="form-control">
                                                 <x-input-error :messages="$errors->get('name')" class="mt-2" />
											</div>
											<div class="mb-3">
												<label class="form-label">Email</label>
												<input class="form-control form-control-lg group_formcontrol form-control-phone" id="email" type="email" name="email" required autocomplete="username">
                                                 <x-input-error :messages="$errors->get('email')" class="mt-2" />
											</div>
											<div class="mb-3">
												<div class="form-group-flex">
													<label class="form-label">Create Password</label>
												</div>
												<div class="pass-group">
													<input type="password" id="password" name="password"  class="form-control pass-input" required autocomplete="new-password" >
                                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
													<span class="feather-eye-off toggle-password"></span>
												</div>
											</div>
                                            <div class="mb-3">
												<div class="form-group-flex">
													<label class="form-label">Confirm Password</label>
												</div>
												<div class="pass-group">
													<input type="password" id="password" name="password_confirmation" required autocomplete="new-password"  class="form-control pass-input">
                                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
													<span class="feather-eye-off toggle-password"></span>
												</div>
											</div>
											<div class="mb-3">
												<button class="btn btn-primary-gradient w-100" type="submit">Sign Up</button>
											</div>
											<div class="login-or">
												<span class="or-line"></span>
												<span class="span-or">or</span>
											</div>
											<div class="social-login-btn">
												<a href="javascript:void(0);" class="btn w-100">
													<img src="images/google-icon.svg" alt="google-icon">Sign in With Google
												</a>
												<a href="javascript:void(0);" class="btn w-100">
													<img src="images/facebook-icon.svg" alt="fb-icon">Sign in With Facebook
												</a>
											</div>
											<div class="account-signup">
												<p>Already have account? <a href="{{ route('login') }}">Sign In</a></p>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- /Login Tab Content -->
								
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
   
			<!-- Footer Section -->
			<footer class="footer inner-footer">
				<div class="footer-top">
					<div class="container">
						<div class="row">
							<div class="col-lg-8">
								<div class="row">
									<div class="col-lg-3 col-md-3">
										<div class="footer-widget footer-menu">
											<h6 class="footer-title">Company</h6>
											<ul>
												<li><a href="about-us.html">About</a></li>
												<li><a href="search.html">Features</a></li>
												<li><a href="javascript:void(0);">Works</a></li>
												<li><a href="javascript:void(0);">Careers</a></li>
												<li><a href="javascript:void(0);">Locations</a></li>
											</ul>
										</div>
									</div>
									<div class="col-lg-3 col-md-3">
										<div class="footer-widget footer-menu">
											<h6 class="footer-title">Treatments</h6>
											<ul>
												<li><a href="search.html">Dental</a></li>
												<li><a href="search.html">Cardiac</a></li>
												<li><a href="search.html">Spinal Cord</a></li>
												<li><a href="search.html">Hair Growth</a></li>
												<li><a href="search.html">Anemia & Disorder</a></li>
											</ul>
										</div>
									</div>
									<div class="col-lg-3 col-md-3">
										<div class="footer-widget footer-menu">
											<h6 class="footer-title">Specialities</h6>
											<ul>
												<li><a href="search.html">Transplant</a></li>
												<li><a href="search.html">Cardiologist</a></li>
												<li><a href="search.html">Oncology</a></li>
												<li><a href="search.html">Pediatrics</a></li>
												<li><a href="search.html">Gynacology</a></li>
											</ul>
										</div>
									</div>
									<div class="col-lg-3 col-md-3">
										<div class="footer-widget footer-menu">
											<h6 class="footer-title">Utilites</h6>
											<ul>
												<li><a href="pricing.html">Pricing</a></li>
												<li><a href="contact-us.html">Contact</a></li>
												<li><a href="contact-us.html">Request A Quote</a></li>
												<li><a href="javascript:void(0);">Premium Membership</a></li>
												<li><a href="javascript:void(0);">Integrations</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-7">
								<div class="footer-widget">
									<h6 class="footer-title">Newsletter</h6>
									<p class="mb-2">Subscribe & Stay Updated from the Doccure</p>
									<div class="subscribe-input">
										<form action="#">
											<input type="email" class="form-control" placeholder="Enter Email Address">
											<button type="submit" class="btn btn-md btn-primary-gradient d-inline-flex align-items-center"><i class="isax isax-send-25 me-1"></i>Send</button>
										</form>
									</div>
									<div class="social-icon">
										<h6 class="mb-3">Connect With Us</h6>
										<ul>
											<li>
												<a href="javascript:void(0);"><i class="fa-brands fa-facebook"></i></a>
											</li>
											<li>
												<a href="javascript:void(0);"><i class="fa-brands fa-x-twitter"></i></a>
											</li>
											<li>
												<a href="javascript:void(0);"><i class="fa-brands fa-instagram"></i></a>
											</li>
											<li>
												<a href="javascript:void(0);"><i class="fa-brands fa-linkedin"></i></a>
											</li>
											<li>
												<a href="javascript:void(0);"><i class="fa-brands fa-pinterest"></i></a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="footer-bg">
						<img src="images/footer-bg-01.png" alt="img" class="footer-bg-01">
						<img src="images/footer-bg-02.png" alt="img" class="footer-bg-02">
						<img src="images/footer-bg-03.png" alt="img" class="footer-bg-03">
						<img src="images/footer-bg-04.png" alt="img" class="footer-bg-04">
						<img src="images/footer-bg-05.png" alt="img" class="footer-bg-05">
					</div>
				</div>
				<div class="footer-bottom">
					<div class="container">
						<!-- Copyright -->
						<div class="copyright">
							<div class="copyright-text">
								<p class="mb-0">Copyright © 2025 Doccure. All Rights Reserved</p>
							</div>
							<!-- Copyright Menu -->
							<div class="copyright-menu">
								<ul class="policy-menu">
									<li><a href="javascript:void(0);">Legal Notice</a></li>
									<li><a href="privacy-policy.html">Privacy Policy</a></li>
									<li><a href="javascript:void(0);">Refund Policy</a></li>
								</ul>
							</div>
							<!-- /Copyright Menu -->
							<ul class="payment-method">
								<li><a href="javascript:void(0);"><img src="images/card-01.svg" alt="Img"></a></li>
								<li><a href="javascript:void(0);"><img src="images/card-02.svg" alt="Img"></a></li>
								<li><a href="javascript:void(0);"><img src="images/card-03.svg" alt="Img"></a></li>
								<li><a href="javascript:void(0);"><img src="images/card-04.svg" alt="Img"></a></li>
								<li><a href="javascript:void(0);"><img src="images/card-05.svg" alt="Img"></a></li>
								<li><a href="javascript:void(0);"><img src="images/card-06.svg" alt="Img"></a></li>
							</ul>
						</div>
						<!-- /Copyright -->					
					</div>
				</div>
			</footer>
			<!-- /Footer Section -->
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="js/jquery-3.7.1.min.js" type="4b581727c1832abe60b6cf22-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="js/bootstrap.bundle.min.js" type="4b581727c1832abe60b6cf22-text/javascript"></script>

		<!-- Mobile Input -->
		<script src="js/intlTelInput.js" type="4b581727c1832abe60b6cf22-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="js/script.js" type="4b581727c1832abe60b6cf22-text/javascript"></script>
		
	<script src="js/rocket-loader.min.js" data-cf-settings="4b581727c1832abe60b6cf22-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" rayid":"97c664b08b0666a9","servertiming":{"name":{"cfextpri":true,"cfedge":true,"cforigin":true,"cfl4":true,"cfspeedbrain":true,"cfcachestatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}"="" crossorigin="anonymous"></script>



		
					</body></html>