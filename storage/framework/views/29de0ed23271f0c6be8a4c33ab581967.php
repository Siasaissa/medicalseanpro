<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php
    use Carbon\Carbon;
?>

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
									<li class="breadcrumb-item active">Appointments</li>
								</ol>
								<h2 class="breadcrumb-title">Appointments</h2>
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
							<div class="dashboard-header">
								<h3>Appointments</h3>
								<ul class="header-list-btns">
									<li>
										<div class="input-block dash-search-input">
											<input type="text" class="form-control" placeholder="Search">
											<span class="search-icon"><i class="isax isax-search-normal"></i></span>
										</div>
									</li>
									<li>
										<div class="view-icons">
											<a href="#" class="active"><i class="isax isax-grid-7"></i></a>
										</div>
									</li>
									<li>
										<div class="view-icons">
											<a href="#"><i class="fa-solid fa-th"></i></a>
										</div>
									</li>
									<li>
										<div class="view-icons">
											<a href="#"><i class="isax isax-calendar-tick"></i></a>
										</div>
									</li>
								</ul>
							</div>
							<div class="appointment-tab-head">
								<div class="appointment-tabs">
									<ul class="nav nav-pills inner-tab " id="pills-tab" role="tablist">
										<li class="nav-item" role="presentation">
											<button class="nav-link active" id="pills-upcoming-tab" data-bs-toggle="pill" data-bs-target="#pills-upcoming" type="button" role="tab" aria-controls="pills-upcoming" aria-selected="false">Upcoming<span><?php echo e($counts); ?></span></button>
										</li>	
										
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="pills-complete-tab" data-bs-toggle="pill" data-bs-target="#completed-bookings-container" type="button" role="tab" aria-controls="pills-complete" aria-selected="true">Completed<span><?php echo e($completed); ?></span></button>
										</li>
									</ul>
								</div>
								<div class="filter-head">
									<div class="position-relative daterange-wraper me-2">
										<div class="input-groupicon calender-input">
											<input type="text" class="form-control  date-range bookingrange" placeholder="From Date - To Date ">
										</div>
										<i class="isax isax-calendar-1"></i>
									</div>
									
									
								</div>
							</div>

							<div class="tab-content appointment-tab-content">
								<div class="tab-pane fade show active" id="pills-upcoming" role="tabpanel" aria-labelledby="pills-upcoming-tab">
									<!-- Appointment List -->

<?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php
        $appointmentStart = Carbon::parse($booking->appointment_datetime);
        $appointmentEnd = $appointmentStart->copy()->addMinutes((int)$booking->service_time);
        $now = Carbon::now();
    ?>

    
    <?php if($now->lt($appointmentEnd)): ?>

        <div class="appointment-wrap">
            <ul>

                <li>
                    <div class="patinet-information">
                        <a href="#">
                            <img src="<?php echo e(asset($booking->doctor->profile->dp ?? 'images/profile-06.jpg')); ?>" alt="User Image">
                        </a>
                        <div class="patient-info">
                            <p>#Apt000<?php echo e($booking->id); ?></p>
                            <h6><?php echo e($booking->doctor->name); ?></h6>
                        </div>
                    </div>
                </li>

                <li class="appointment-info">
                    <p><i class="isax isax-clock5"></i><?php echo e($booking->appointment_datetime); ?></p>
                    <ul class="d-flex apponitment-types">
                        <li>General Visit</li>
                        <li><?php echo e($booking->appointment_type); ?></li>
                    </ul>
                </li>

                <li class="mail-info-patient">
                    <ul>
                        <li><i class="isax isax-sms5"></i><?php echo e($booking->doctor->email); ?></li>
                        <li><i class="isax isax-call5"></i><?php echo e($booking->phone); ?></li>
                    </ul>
                </li>

                <li class="appointment-action">
                    <ul>
                        <li><a href="#"><i class="isax isax-eye4"></i></a></li>
                        <li><a href="#"><i class="isax isax-messages-25"></i></a></li>
                        <li><a href="#"><i class="isax isax-close-circle5"></i></a></li>
                    </ul>
                </li>

                
                <?php if($now->between($appointmentStart, $appointmentEnd)): ?>
                    <li class="appointment-detail-btn">
                        <a href="
                            <?php if($booking->appointment_type == 'chat'): ?>
                                <?php echo e(route('chat.index', ['booking' => $booking->id])); ?>

                            <?php elseif($booking->appointment_type == 'video'): ?>
                                <?php echo e(route('doctor.video', ['booking' => $booking->id])); ?>

                            <?php elseif($booking->appointment_type == 'voice'): ?>
                                <?php echo e(route('doctor.voice', ['booking' => $booking->id])); ?>

                            <?php endif; ?>
                        " class="btn btn-md btn-primary-gradient">
                            <i class="isax isax-calendar-tick5 me-1"></i> Attend
                        </a>
                    </li>

                
                <?php elseif($now->lt($appointmentStart)): ?>
                    <li><span class="text-warning">Appointment not started yet</span></li>

                <?php endif; ?>

            </ul>
        </div>

    <?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								</div>
								</div>



								<div class="tab-pane fade" id="completed-bookings-container" role="tabpanel" aria-labelledby="pills-complete-tab">
									<!-- Appointment List -->
									 <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if(Carbon::parse($booking->appointment_datetime)->lt(Carbon::now())): ?>
									<div class="appointment-wrap">
										<ul>
											<li>
												<div class="patinet-information">
													<a href="doctor-completed-appointment.html">
														<img src="<?php echo e(asset('images/profile-01.jpg')); ?>" alt="User Image">
													</a>
													<div class="patient-info">
														<p>#Apt000<?php echo e($booking->id); ?></p>
														<h6><a href="doctor-completed-appointment.html"><?php echo e($booking->patient->name); ?></a></h6>
													</div>
												</div>
											</li>
											<li class="appointment-info">
												<p><i class="isax isax-clock5"></i><?php echo e($booking->appointment_datetime); ?></p>
												<ul class="d-flex apponitment-types">
													<li>General Visit</li>
													<li><?php echo e($booking->appointment_type); ?></li>
												</ul>
												
											</li>
											<li class="appointment-detail-btn">
												<a href="#" class="start-link">View Details</a>
											</li>
										</ul>
									</div>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
									<!-- /Appointment List -->

									<!-- Appointment List -->
									
									<!-- /Appointment List -->

									<!-- Pagination -->
									
								</div>
									<!-- /Pagination -->
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
		
		<!-- Appointment Details Modal -->
		<div class="modal fade custom-modal" id="appt_details">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Appointment Details</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<ul class="info-details">
							<li>
								<div class="details-header">
									<div class="row">
										<div class="col-md-6">
											<span class="title">#APT0001</span>
											<span class="text">21 Oct 2023 10:00 AM</span>
										</div>
										<div class="col-md-6">
											<div class="text-end">
												<button type="button" class="btn bg-success-light btn-sm" id="topup_status">Completed</button>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li>
								<span class="title">Status:</span>
								<span class="text">Completed</span>
							</li>
							<li>
								<span class="title">Confirm Date:</span>
								<span class="text">29 Jun 2023</span>
							</li>
							<li>
								<span class="title">Paid Amount</span>
								<span class="text">$450</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<script>
		document.addEventListener('DOMContentLoaded', function () {
			const container = document.getElementById('completed-bookings-container');
			const items = Array.from(container.children); // all appointment-wrap divs
			const paginationContainer = document.getElementById('completed-pagination');
			const itemsPerPage = 5;
			let currentPage = 1;

			function renderPage(page = 1) {
				const start = (page - 1) * itemsPerPage;
				const end = start + itemsPerPage;

				// hide all items
				items.forEach(item => item.style.display = 'none');

				// show items for this page
				items.slice(start, end).forEach(item => item.style.display = 'block');

				renderPagination(page);
			}

			function renderPagination(page) {
				const totalPages = Math.ceil(items.length / itemsPerPage);
				let html = '';

				html += `<li><a href="#" class="page-link prev" ${page === 1 ? 'style="pointer-events:none;opacity:0.5;"' : ''}>Prev</a></li>`;

				for (let i = 1; i <= totalPages; i++) {
					html += `<li><a href="#" class="page-link ${i === page ? 'active' : ''}" data-page="${i}">${i}</a></li>`;
				}

				html += `<li><a href="#" class="page-link next" ${page === totalPages ? 'style="pointer-events:none;opacity:0.5;"' : ''}>Next</a></li>`;

				paginationContainer.innerHTML = html;

				// attach click events
				paginationContainer.querySelectorAll('.page-link').forEach(link => {
					link.addEventListener('click', function (e) {
						e.preventDefault();
						if (this.classList.contains('prev')) {
							if (currentPage > 1) currentPage--;
						} else if (this.classList.contains('next')) {
							if (currentPage < totalPages) currentPage++;
						} else {
							currentPage = parseInt(this.dataset.page);
						}
						renderPage(currentPage);
					});
				});
			}

			// initial render
			renderPage(currentPage);
		});
	</script>

		<!-- /Appointment Details Modal -->
	  
		<!-- jQuery -->
	<script data-cfasync="false" src="<?php echo e(asset('js/email-decode.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<!-- Sticky Sidebar JS -->
	<script src="<?php echo e(asset('js/ResizeSensor.js')); ?>" type="87d100b3f0de52923242b24d-text/javascript"></script>
	<script src="<?php echo e(asset('js/theia-sticky-sidebar.js')); ?>" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<!-- select JS -->
	<script src="<?php echo e(asset('js/select2.min.js')); ?>" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<!-- Daterangepikcer JS -->
	<script src="<?php echo e(asset('js/moment.min.js')); ?>" type="87d100b3f0de52923242b24d-text/javascript"></script>
	<script src="<?php echo e(asset('js/daterangepicker.js')); ?>" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<!-- Custom JS -->
	<script src="<?php echo e(asset('js/script.js')); ?>" type="87d100b3f0de52923242b24d-text/javascript"></script>

	<script src="<?php echo e(asset('js/rocket-loader.min.js')); ?>" data-cf-settings="87d100b3f0de52923242b24d-|49"
		defer=""></script>

</body></html><?php /**PATH /home/u881803686/domains/medicalsean.org/public_html/resources/views/doctor/appointment.blade.php ENDPATH**/ ?>