<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
									<a href="<?php echo e(route('register')); ?>" class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
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
										<form method="POST" action="<?php echo e(route('login')); ?>">
                                            <?php echo csrf_field(); ?>

											<div class="mb-3">
												<label class="form-label">E-mail</label>
												<input id="email"  type="email" name="email" required autofocus autocomplete="username" class="form-control">
                                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('email'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
											</div>
											<div class="mb-3">
												<div class="form-group-flex">
													<label class="form-label">Password</label>
													<a href="forgot-password.html" class="forgot-link">Forgot password?</a>
												</div>
												<div class="pass-group">
													<input type="password"  id="password" name="password" required autocomplete="current-password" class="form-control pass-input">
                                                     <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('password'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('password')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
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
												<a href="<?php echo e(route('google.patient')); ?>" class="btn w-100">
													<img src="images/google-icon.svg" alt="google-icon">Sign In for patient
												</a>
												<!--<a href="javascript:void(0);" class="btn w-100">
													<img src="images/facebook-icon.svg" alt="fb-icon">Sign in With Facebook
												</a>-->
											</div>
											<div class="account-signup">
												<p>Don't have an account ? <a href="<?php echo e(route('register')); ?>">Sign up</a></p>
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
			<?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

</body></html><?php /**PATH /Users/dope/Downloads/public_htm/resources/views/auth/login.blade.php ENDPATH**/ ?>