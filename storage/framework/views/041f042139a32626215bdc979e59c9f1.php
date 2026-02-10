<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
			<?php echo $__env->make('layouts.doctorHeader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
									<li class="breadcrumb-item active">Change Password</li>
								</ol>
								<h2 class="breadcrumb-title">Change Password</h2>
							</nav>
						</div>
					</div>
				</div>
            <div class="breadcrumb-bg">
                <img src="<?php echo e(asset('images/breadcrumb-bg-01.png')); ?>" alt="img" class="breadcrumb-bg-01">
                <img src="<?php echo e(asset('images/breadcrumb-bg-02.png')); ?>" alt="img" class="breadcrumb-bg-02">
                <img src="<?php echo e(asset('images/breadcrumb-icon.webp')); ?>" alt="img" class="breadcrumb-bg-03">
                <img src="<?php echo e(asset('images/breadcrumb-icon.webp')); ?>" alt="img" class="breadcrumb-bg-04">
            </div>
			</div>
			<!-- /Breadcrumb -->
			<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

			<!-- Page Content -->
			<div class="content doctor-content">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 col-xl-3 theiaStickySidebar">
							
							<!-- Profile Sidebar -->
							<?php echo $__env->make('layouts.doctorSidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							<!-- /Profile Sidebar -->
							
						</div>
						
						<div class="col-lg-8 col-xl-9">
							<div class="dashboard-header">
								<h3>Change Password</h3>
							</div>
							<form action="<?php echo e(route('doctor.updatePassword')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="card pass-card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <!-- Old Password -->
                    <div class="input-block input-block-new">
                        <label class="form-label">Old Password</label>
                        <input type="password" name="old_password" class="form-control" required>
                        <?php $__errorArgs = ['old_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- New Password -->
                    <div class="input-block input-block-new">
                        <label class="form-label">New Password</label>
                        <div class="pass-group">
                            <input type="password" name="new_password" class="form-control pass-input" required>
                            <span class="feather-eye-off toggle-password"></span>
                        </div>
                        <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Confirm Password -->
                    <div class="input-block input-block-new mb-0">
                        <label class="form-label">Confirm Password</label>
                        <div class="pass-group">
                            <input type="password" name="new_password_confirmation" class="form-control pass-input-sub" required>
                            <span class="feather-eye-off toggle-password-sub"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="form-set-button">
        <button class="btn btn-primary" type="submit">Save Changes</button>
    </div>
</form>

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
		<script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>" type="71c8024a7b85cbfe95ba97a6-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>" type="71c8024a7b85cbfe95ba97a6-text/javascript"></script>

		<!-- Select2 JS -->
		<script src="<?php echo e(asset('js/select2.min.js')); ?>" type="71c8024a7b85cbfe95ba97a6-text/javascript"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="<?php echo e(asset('js/ResizeSensor.js')); ?>" type="71c8024a7b85cbfe95ba97a6-text/javascript"></script>
        <script src="<?php echo e(asset('js/theia-sticky-sidebar.js')); ?>" type="71c8024a7b85cbfe95ba97a6-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="<?php echo e(asset('js/script.js')); ?>" type="71c8024a7b85cbfe95ba97a6-text/javascript"></script>
		
	<script src="<?php echo e(asset('js/rocket-loader.min.js')); ?>" data-cf-settings="71c8024a7b85cbfe95ba97a6-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"="" crossorigin="anonymous"></script>

</body></html><?php /**PATH /home/u881803686/domains/medicalsean.org/public_html/resources/views/doctor/changePassword.blade.php ENDPATH**/ ?>