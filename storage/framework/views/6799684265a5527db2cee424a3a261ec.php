<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
			<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
									<li class="breadcrumb-item active">Settings</li>
								</ol>
								<h2 class="breadcrumb-title">Settings</h2>
							</nav>
						</div>
					</div>
				</div>
				<div class="breadcrumb-bg">
					<img src="<?php echo e(asset('images/breadcrumb-bg-01.png')); ?>" alt="img" class="breadcrumb-bg-01">
					<img src="<?php echo e(asset('images/breadcrumb-bg-02.png')); ?>" alt="img" class="breadcrumb-bg-02">
					<img src="<?php echo e(asset('images/breadcrumb-icon.png')); ?>" alt="img" class="breadcrumb-bg-03">
					<img src="<?php echo e(asset('images/breadcrumb-icon.png')); ?>" alt="img" class="breadcrumb-bg-04">
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">
					<div class="row">
					
						
							
							<!-- Profile Sidebar -->
							<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							<!-- /Profile Sidebar -->						
							
						
						
						<div class="col-lg-8 col-xl-9">
							<nav class="settings-tab mb-1">
								<ul class="nav nav-tabs-bottom" role="tablist">
									 <li class="nav-item" role="presentation">
										<a class="nav-link active" href="profile-settings.html">Profile</a>
									 </li>
									 <li class="nav-item" role="presentation">
										<a class="nav-link" href="change-password.html">Change Password</a>
									 </li>
									 <li class="nav-item" role="presentation">
										 <a class="nav-link" href="delete-account.html">Delete Account</a>
									 </li>
								</ul>
							</nav>
							<div class="card">
								<div class="card-body">
									<div class="border-bottom pb-3 mb-3">
										<h5>Profile Settings</h5>
									</div>
									<form action="<?php echo e(route('profile.store')); ?>" method="POST" enctype="multipart/form-data">
										<?php echo csrf_field(); ?>

										<div class="setting-card">
											<label class="form-label mb-2">Profile Photo</label>
											<div class="change-avatar img-upload">
												<div class="profile-img">
													<i class="fa-solid fa-file-image"></i>
												</div>
												<div class="upload-img">
													<div class="imgs-load d-flex align-items-center">
														<div class="change-photo">
															Upload New 
															<input type="file" name="dp" class="upload">
														</div>
														<a href="#" class="upload-remove">Remove</a>
													</div>
													<p>Your Image should Below 4 MB, Accepted format jpg,png,svg</p>
												</div>			
											</div>			
										</div>
										<div class="setting-title">
											<h6>Information</h6>
										</div>
										<div class="setting-card">
											<div class="row">
												<div class="col-lg-4 col-md-6">
													<div class="mb-3">
														<label class="form-label">Sex <span class="text-danger">*</span></label>
														<input type="text" name="sex" class="form-control">
													</div>
												</div>
												<div class="col-lg-4 col-md-6">
													<div class="mb-3">
														<label class="form-label">Date of Birth <span class="text-danger">*</span></label>
														<div class="form-icon">
															<input type="text" name="dob" class="form-control datetimepicker" placeholder="dd/mm/yyyy">
															<span class="icon"><i class="isax isax-calendar-1"></i></span>
														</div>
													</div>
												</div>
												<div class="col-lg-4 col-md-6">
													<div class="mb-3">
														<label class="form-label">Blood Group <span class="text-danger">*</span></label>
														<select class="select" name="blood_group">
															<option>Select</option>
															<option value="B+ve">B+ve</option>
															<option value="AB+ve">AB+ve</option>
															<option value="B-ve">B-ve</option>
															<option value="O+ve">O+ve</option>
															<option value="O-ve">O-ve</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="setting-title">
											<h6>Address</h6>
										</div>
										<div class="setting-card">
											<div class="row">
												<div class="col-lg-12">
													<div class="mb-3">
														<label class="form-label">Address <span class="text-danger">*</span></label>
														<input type="text" name="address" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<div class="modal-btn text-end">
											<button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Changes</button>
										</div>
									</form>
								</div>
							</div>
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
		<script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>" type="5781a9257a1645c29c1a662f-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>" type="5781a9257a1645c29c1a662f-text/javascript"></script>
		
		<!-- Select2 JS -->
		<script src="<?php echo e(asset('js/select2.min.js')); ?>" type="5781a9257a1645c29c1a662f-text/javascript"></script>
		
		<!-- Datetimepicker JS -->
		<script src="<?php echo e(asset('js/moment.min.js')); ?>" type="5781a9257a1645c29c1a662f-text/javascript"></script>
		<script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>" type="5781a9257a1645c29c1a662f-text/javascript"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="<?php echo e(asset('js/ResizeSensor.js')); ?>" type="5781a9257a1645c29c1a662f-text/javascript"></script>
        <script src="<?php echo e(asset('js/theia-sticky-sidebar.js')); ?>" type="5781a9257a1645c29c1a662f-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="<?php echo e(asset('js/script.js')); ?>" type="5781a9257a1645c29c1a662f-text/javascript"></script>
		
	<script src="<?php echo e(asset('js/rocket-loader.min.js')); ?>" data-cf-settings="5781a9257a1645c29c1a662f-|49" defer=""></script>
</body></html><?php /**PATH /home/u881803686/domains/medicalsean.org/public_html/resources/views/patient/settings.blade.php ENDPATH**/ ?>