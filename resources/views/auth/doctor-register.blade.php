@include ('layouts.head')
	<body class="account-page">

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
			@include ('layouts.header')
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
										<img src="{{asset('images/login-banner.png')}}" class="img-fluid" alt="Doccure Login">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Doctor Register <a href="{{ route('register') }}">Not a Doctor?</a></h3>
										</div>
										<form method="POST" action="{{ route('doctor') }}">
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
			@include ('layouts.footer')
			<!-- /Footer Section -->
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="js/jquery-3.7.1.min.js" type="66109ad8880d20f3f04492dd-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="js/bootstrap.bundle.min.js" type="66109ad8880d20f3f04492dd-text/javascript"></script>

		<!-- Mobile Input -->
		<script src="js/intlTelInput.js" type="66109ad8880d20f3f04492dd-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="js/script.js" type="66109ad8880d20f3f04492dd-text/javascript"></script>
		
	<script src="js/rocket-loader.min.js" data-cf-settings="66109ad8880d20f3f04492dd-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" rayid":"97c66751ce3266a9","servertiming":{"name":{"cfextpri":true,"cfedge":true,"cforigin":true,"cfl4":true,"cfspeedbrain":true,"cfcachestatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}"="" crossorigin="anonymous"></script>

</body></html>