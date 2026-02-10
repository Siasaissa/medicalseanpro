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
									<li class="breadcrumb-item active">Dashboard</li>
								</ol>
								<h2 class="breadcrumb-title">Dashboard</h2>
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
						<div class="col-lg-4 col-xl-3 theiaStickySidebar">
							
							<!-- Profile Sidebar -->
							<?php echo $__env->make('layouts.doctorSidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							<!-- /Profile Sidebar -->
							
						</div>
						
						<div class="col-lg-8 col-xl-9">

							<div class="row">
								<div class="col-xl-12 d-flex">
									<div class="dashboard-box-col w-100">
										<div class="dashboard-widget-box">
											<div class="dashboard-content-info">
												<h6>Total Patient</h6>
												<h4><?php echo e($data1 ?? 'No data'); ?></h4>
												<span class="text-success"><i class="fa-solid fa-arrow-up"></i>15% From Last Week</span>
											</div>
											<div class="dashboard-widget-icon">
												<span class="dash-icon-box"><i class="fa-solid fa-user-injured"></i></span>
											</div>
										</div>
										<div class="dashboard-widget-box">
											<div class="dashboard-content-info">
												<h6>Total Appointment</h6>
												<h4><?php echo e($data2 ?? 'No data'); ?></h4>
												<span class="text-danger"><i class="fa-solid fa-arrow-up"></i>15% From Yesterday</span>
											</div>
											<div class="dashboard-widget-icon">
												<span class="dash-icon-box"><i class="fa-solid fa-user-clock"></i></span>
											</div>
										</div>
										<div class="dashboard-widget-box">
											<div class="dashboard-content-info">
												<h6>Upcoming Appointment</h6>
												<h4><?php echo e($data3 ?? 'No data'); ?></h4>
												<span class="text-success"><i class="fa-solid fa-arrow-up"></i>20% From Yesterday</span>
											</div>
											<div class="dashboard-widget-icon">
												<span class="dash-icon-box"><i class="fa-solid fa-calendar-days"></i></span>
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
			<?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<!-- /Footer Section -->
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="js/jquery-3.7.1.min.js" type="15c239e1b4380c5c6c5e5ca6-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="js/bootstrap.bundle.min.js" type="15c239e1b4380c5c6c5e5ca6-text/javascript"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="js/ResizeSensor.js" type="15c239e1b4380c5c6c5e5ca6-text/javascript"></script>
        <script src="js/theia-sticky-sidebar.js" type="15c239e1b4380c5c6c5e5ca6-text/javascript"></script>

		<!-- select JS -->
		<script src="js/select2.min.js" type="15c239e1b4380c5c6c5e5ca6-text/javascript"></script>

		<!-- Apexchart JS -->
		<script src="js/apexcharts.min.js" type="15c239e1b4380c5c6c5e5ca6-text/javascript"></script>
		<script src="js/chart-data.js" type="15c239e1b4380c5c6c5e5ca6-text/javascript"></script>
		
		<!-- Circle Progress JS -->
		<script src="js/circle-progress.min.js" type="15c239e1b4380c5c6c5e5ca6-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="js/script.js" type="15c239e1b4380c5c6c5e5ca6-text/javascript"></script>
		
	<script src="js/rocket-loader.min.js" data-cf-settings="15c239e1b4380c5c6c5e5ca6-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" rayid":"97cd82f759a29fe2","servertiming":{"name":{"cfextpri":true,"cfedge":true,"cforigin":true,"cfl4":true,"cfspeedbrain":true,"cfcachestatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}"="" crossorigin="anonymous"></script>

</body></html><?php /**PATH /home/u881803686/domains/medicalsean.org/public_html/resources/views/doctor-dashboard.blade.php ENDPATH**/ ?>