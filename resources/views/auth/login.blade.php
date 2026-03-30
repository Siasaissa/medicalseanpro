@include('layouts.head')
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
							<a href="{{ route('welcome') }}" class="navbar-brand logo">
								<img src="images/logo.svg" class="img-fluid" alt="Logo">
							</a>
						</div>
						<div class="header-menu">
							<div class="main-menu-wrapper">
								<div class="menu-header">
									<a href="{{ route('welcome') }}" class="menu-logo">
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
										<a href="{{ route('about.us') }}">About Us</a>
									</li>
									<li class="has-submenu">
										<a href="{{ route('blog.grid') }}">Blog Grid</a>
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
									<a href="{{ route('register')  }}" class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
										<i class="isax isax-user-tick me-1"></i>Register
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
										<img src="images/login-banner.png" class="img-fluid" alt="MedicalSean Login">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Login <span>MedicalSean</span></h3>
										</div>
										<form method="POST" action="{{ route('login') }}">
                                            @csrf

											<div class="mb-3">
												<label class="form-label">E-mail</label>
												<input id="email"  type="email" name="email" required autofocus autocomplete="username" class="form-control">
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
											</div>
											<div class="mb-3">
												<div class="form-group-flex">
													<label class="form-label">Password</label>
													<a href="forgot-password.html" class="forgot-link">Forgot password?</a>
												</div>
												<div class="pass-group">
													<input type="password"  id="password" name="password" required autocomplete="current-password" class="form-control pass-input">
                                                     <x-input-error :messages="$errors->get('password')" class="mt-2" />
													<span class="feather-eye-off toggle-password"></span>
												</div>
											</div>
											<div class="mb-3 form-check-box">
												<div class="form-group-flex">
													<div class="form-check mb-0">
														<input class="form-check-input" type="checkbox" id="remember" checked="">
														<label class="form-check-label" for="remember">
															Remember Me  
														</label>
													</div>												
													<div class="form-check mb-0">
														<input class="form-check-input" type="checkbox" id="remember1">
														<label class="form-check-label" for="remember1">
															Login with OTP  
														</label>
													</div>
												</div>
											</div>
											<div class="mb-3">
												<button class="btn btn-primary-gradient w-100" type="submit">Sign in</button>
											</div>
											<div class="login-or">
												<span class="or-line"></span>
												<span class="span-or">or</span>
											</div>
											<div class="social-login-btn">
												<a href="{{ route('google.patient') }}" class="btn w-100">
													<img src="images/google-icon.svg" alt="google-icon">Sign In for patient
												</a>
												<!--<a href="javascript:void(0);" class="btn w-100">
													<img src="images/facebook-icon.svg" alt="fb-icon">Sign in With Facebook
												</a>-->
											</div>
											<div class="account-signup">
												<p>Don't have an account ? <a href="{{ route('register') }}">Sign up</a></p>
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
			@include('layouts.footer')
			<!-- /Footer Section -->
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="js/jquery-3.7.1.min.js" type="edc3d497d6ab314fddf6bd34-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="js/bootstrap.bundle.min.js" type="edc3d497d6ab314fddf6bd34-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="js/script.js" type="edc3d497d6ab314fddf6bd34-text/javascript"></script>
		
	<script src="js/rocket-loader.min.js" data-cf-settings="edc3d497d6ab314fddf6bd34-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" rayid":"97c65d02ddf766a9","servertiming":{"name":{"cfextpri":true,"cfedge":true,"cforigin":true,"cfl4":true,"cfspeedbrain":true,"cfcachestatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}"="" crossorigin="anonymous"></script>

</body></html>
