
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
								<li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a>
								</li>
								<li class="breadcrumb-item" aria-current="page">Patient</li>
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
		<div class="content doctor-content">
			<div class="container">

				<div class="row">

					<!-- Profile Sidebar -->


					<!-- Profile Sidebar -->
					<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<!-- /Profile Sidebar -->


					<!-- / Profile Sidebar -->

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
										<a href="patient-appointments.html" class="active"><i
												class="isax isax-grid-7"></i></a>
									</div>
								</li>
								<li>
									<div class="view-icons">
										<a href="patient-appointments-grid.html"><i class="fa-solid fa-th"></i></a>
									</div>
								</li>
							</ul>
						</div>
						<div class="appointment-tab-head">
							<div class="appointment-tabs">
								<ul class="nav nav-pills inner-tab " id="pills-tab" role="tablist">
									<li class="nav-item" role="presentation">
										<button class="nav-link active" id="pills-upcoming-tab" data-bs-toggle="pill"
											data-bs-target="#pills-upcoming" type="button" role="tab"
											aria-controls="pills-upcoming"
											aria-selected="false">Upcoming<span><?php echo e($counts); ?></span></button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link" id="pills-complete-tab" data-bs-toggle="pill"
											data-bs-target="#pills-complete" type="button" role="tab"
											aria-controls="pills-complete"
											aria-selected="true">Completed<span><?php echo e($completed); ?></span></button>
									</li>
								</ul>
							</div>
							<div class="filter-head">
								<div class="position-relative daterange-wraper me-2">
									<div class="input-groupicon calender-input">
										<input type="text" class="form-control  date-range bookingrange"
											placeholder="From Date - To Date ">
									</div>
									<i class="isax isax-calendar-1"></i>
								</div>
								<div class="form-sorts dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" id="table-filter"><i
											class="isax isax-filter me-2"></i>Filter By</a>
									<div class="filter-dropdown-menu">
										<div class="filter-set-view">
											<div class="accordion" id="accordionExample">
												<div class="filter-set-content">
													<div class="filter-set-content-head">
														<a href="#" data-bs-toggle="collapse"
															data-bs-target="#collapseTwo" aria-expanded="false"
															aria-controls="collapseTwo">Name<i
																class="fa-solid fa-chevron-right"></i></a>
													</div>
													<div class="filter-set-contents accordion-collapse collapse show"
														id="collapseTwo" data-bs-parent="#accordionExample">
														<ul>
															<li>
																<div class="input-block dash-search-input w-100">
																	<input type="text" class="form-control"
																		placeholder="Search">
																	<span class="search-icon"><i
																			class="fa-solid fa-magnifying-glass"></i></span>
																</div>
															</li>
														</ul>
													</div>
												</div>
												<div class="filter-set-content">
													<div class="filter-set-content-head">
														<a href="#" data-bs-toggle="collapse"
															data-bs-target="#collapseOne" aria-expanded="true"
															aria-controls="collapseOne">Appointment Type<i
																class="fa-solid fa-chevron-right"></i></a>
													</div>
													<div class="filter-set-contents accordion-collapse collapse show"
														id="collapseOne" data-bs-parent="#accordionExample">
														<ul>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox" checked="">
																		<span class="checkmarks"></span>
																		<span class="check-title">All Type</span>
																	</label>
																</div>
															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Video Call</span>
																	</label>
																</div>
															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Audio Call</span>
																	</label>
																</div>
															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Chat</span>
																	</label>
																</div>
															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Direct Visit</span>
																	</label>
																</div>
															</li>
														</ul>
													</div>
												</div>
												<div class="filter-set-content">
													<div class="filter-set-content-head">
														<a href="#" data-bs-toggle="collapse"
															data-bs-target="#collapseThree" aria-expanded="false"
															aria-controls="collapseThree">Visit Type<i
																class="fa-solid fa-chevron-right"></i></a>
													</div>
													<div class="filter-set-contents accordion-collapse collapse show"
														id="collapseThree" data-bs-parent="#accordionExample">
														<ul>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox" checked="">
																		<span class="checkmarks"></span>
																		<span class="check-title">All Visit</span>
																	</label>
																</div>

															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">General</span>
																	</label>
																</div>

															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Consultation</span>
																	</label>
																</div>

															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Follow-up</span>
																	</label>
																</div>

															</li>
															<li>
																<div class="filter-checks">
																	<label class="checkboxs">
																		<input type="checkbox">
																		<span class="checkmarks"></span>
																		<span class="check-title">Direct Visit</span>
																	</label>
																</div>

															</li>
														</ul>
													</div>
												</div>
											</div>

											<div class="filter-reset-btns">
												<a href="appointments.html"
													class="btn btn-md btn-light rounded-pill">Reset</a>
												<a href="appointments.html"
													class="btn btn-md btn-primary-gradient rounded-pill">Filter Now</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-content appointment-tab-content">
							<div class="tab-pane fade show active" id="pills-upcoming" role="tabpanel"
								aria-labelledby="pills-upcoming-tab">
								<!-- Appointment List -->
								 <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

								<?php
									$appointmentStart = Carbon\Carbon::parse($booking->appointment_datetime);
									$appointmentEnd = $appointmentStart->copy()->addMinutes((int) $booking->service_time);
								?>

						<?php if(Carbon\Carbon::now()->lt($appointmentEnd)): ?>
							<div class="appointment-wrap">
								<ul>
									<li>
										<div class="patinet-information">
											<a href="#">
												<img src="<?php echo e(asset($booking->doctor->profile->dp ?? 'images/profile-06.jpg')); ?>" alt="User Image">
											</a>
											<div class="patient-info">
												<p>#Apt000<?php echo e($booking->id); ?></p>
												<h6><a href="#"><?php echo e($booking->doctor->name); ?></a></h6>
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

									<?php if(Carbon\Carbon::now()->between($appointmentStart, $appointmentEnd)): ?>
										<li class="appointment-detail-btn">
											<a href="
												<?php if($booking->appointment_type == 'chat'): ?>
													<?php echo e(route('chat.index', ['booking' => $booking->id])); ?>

												<?php elseif($booking->appointment_type == 'video'): ?>
													<?php echo e(route('patient.video', ['booking' => $booking->id])); ?>

												<?php elseif($booking->appointment_type == 'voice'): ?>
													<?php echo e(route('patient.voice', ['booking' => $booking->id])); ?>

												<?php endif; ?>
											" class="btn btn-md btn-primary-gradient">
												<i class="isax isax-calendar-tick5 me-1"></i> Attend
											</a>
										</li>
									<?php else: ?>
										<span class="text-danger">
											<?php if(Carbon\Carbon::now()->lt($appointmentStart)): ?>
												Appointment not started yet
											<?php else: ?>
												Appointment ended
											<?php endif; ?>
										</span>
									<?php endif; ?>

								</ul>
							</div>
						<?php endif; ?>
								 
								 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<!-- Pagination -->
								
								<!-- /Pagination -->

							</div>
							<div class="tab-pane fade" id="pills-cancel" role="tabpanel"
								aria-labelledby="pills-cancel-tab">
								<!-- Appointment List -->
								<div class="appointment-wrap">
									<ul>
										<li>
											<div class="patinet-information">
												<a href="patient-cancelled-appointment.html">
													<img src="images/doctor-thumb-21.jpg" alt="User Image">
												</a>
												<div class="patient-info">
													<p>#Apt00011</p>
													<h6><a href="patient-cancelled-appointment.html">Dr Edalin</a></h6>
												</div>
											</div>
										</li>
										<li class="appointment-info">
											<p><i class="isax isax-clock5"></i>11 Nov 2024 10.45 AM</p>
											<ul class="d-flex apponitment-types">
												<li>General Visit</li>
												<li>Video Call</li>
											</ul>

										</li>

										<li class="mail-info-patient">
											<ul>
												<li><i class="isax isax-sms5"></i><a href="/cdn-cgi/l/email-protection"
														class="__cf_email__"
														data-cfemail="503534313c393e103528313d203c357e333f3d">[email�protected]</a>
												</li>
												<li><i class="isax isax-call5"></i>+1 504 368 6874</li>
											</ul>
										</li>
										<li class="appointment-detail-btn">
											<a href="patient-cancelled-appointment.html"
												class="btn btn-md btn-primary-gradient"><i
													class="isax isax-calendar-tick5 me-1"></i>Reschedule</a>
										</li>
									</ul>
								</div>
								<!-- /Appointment List -->

								<!-- Appointment List -->
								
								<!-- /Appointment List -->

								<!-- Pagination -->
								<div class="pagination dashboard-pagination">
									<ul>
										<li>
											<a href="#" class="page-link prev">Prev</a>
										</li>
										<li>
											<a href="#" class="page-link active">1</a>
										</li>
										<li>
											<a href="#" class="page-link ">2</a>
										</li>
										<li>
											<a href="#" class="page-link">3</a>
										</li>
										<li>
											<a href="#" class="page-link">4</a>
										</li>
										<li>
											<a href="#" class="page-link">...</a>
										</li>
										<li>
											<a href="#" class="page-link next">Next</a>
										</li>
									</ul>
								</div>
								<!-- /Pagination -->
							</div>
							
							<div class="tab-pane fade" id="pills-complete" role="tabpanel"
								aria-labelledby="pills-complete-tab">
								<div id="completed-bookings-container">
									<?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if(Carbon\Carbon::parse($booking->appointment_datetime)->lt(Carbon\Carbon::now())): ?>
											<div class="appointment-wrap">
												<ul>
													<li>
														<div class="patinet-information">
															<a href="patient-completed-appointment.html">
																<img src="<?php echo e(asset($booking->doctor->profile->dp) ?? asset('images/profile-06.jp')); ?>"
																	alt="User Image">
															</a>
															<div class="patient-info">
																<p>#Apt000<?php echo e($booking->id); ?></p>
																<h6><a
																		href="patient-completed-appointment.html"><?php echo e($booking->doctor->name); ?></a>
																</h6>
															</div>
														</div>
													</li>
													<li class="appointment-info">
														<p><i class="isax isax-clock5"></i><?php echo e($booking->appointment_datetime); ?>

														</p>
														<ul class="d-flex apponitment-types">
															<li>General Visit</li>
															<li>Video Call</li>
														</ul>
													</li>
													<li>
														<a href="#" class="text-decoration-underline" data-bs-toggle="modal"
															data-bs-target="#add_review">Add Review</a>
													</li>
													<li
														class="appointment-detail-btn d-flex align-items-center gap-3 flex-wrap">
														<a href="#" class="btn btn-md btn-dark">Book Again<i
																class="isax isax-arrow-right-3 ms-1"></i></a>
														<a href="#" class="btn btn-md btn-primary-gradient">View Details<i
																class="isax isax-arrow-right-3 ms-1"></i></a>
													</li>
												</ul>
											</div>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>

								<!-- Pagination -->
								<div class="pagination dashboard-pagination">
									<ul id="completed-pagination" class="pagination-list"></ul>
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

	<!-- Edit Dependent Modal-->
	<div class="modal fade custom-modals" id="add_review">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Add Review</h3>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						<i class="fa-solid fa-xmark"></i>
					</button>
				</div>
				<form action="#">
					<div class="add-dependent">
						<div class="modal-body pb-0">
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">Rating <span class="text-danger">*</span></label>
										<div class="selection-wrap">
											<div class="d-inline-block">
												<div class="rating-selction">
													<input type="radio" name="rating" value="5" id="rating5">
													<label for="rating5"><i class="fa-solid fa-star"></i></label>
													<input type="radio" name="rating" value="4" id="rating4">
													<label for="rating4"><i class="fa-solid fa-star"></i></label>
													<input type="radio" name="rating" value="3" id="rating3">
													<label for="rating3"><i class="fa-solid fa-star"></i></label>
													<input type="radio" name="rating" value="2" id="rating2" checked="">
													<label for="rating2"><i class="fa-solid fa-star"></i></label>
													<input type="radio" name="rating" value="1" id="rating1" checked="">
													<label for="rating1"><i class="fa-solid fa-star"></i></label>
												</div>
											</div>
										</div>
									</div>
									<div class="mb-3">
										<label class="form-label">Comments <span class="text-danger">*</span></label>
										<textarea class="form-control" rows="3"></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="modal-btn text-end">
							<a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-toggle="modal"
								data-bs-dismiss="modal">Cancel</a>
							<button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Add
								Review</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /Edit Dependent Modal-->

	<!-- Edit Dependent Modal-->
	<div class="modal fade custom-modals" id="view_review">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Review Details</h3>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						<i class="fa-solid fa-xmark"></i>
					</button>
				</div>
				<form action="#">
					<div class="modal-body pb-0">
						<div class="mb-3">
							<div class="d-flex justify-content-between flex-wrap gap-3">
								<div>
									<label class="form-label text-gray-6">Review for</label>
									<div class="d-flex align-items-center">
										<span class="user-avatar me-2">
											<img src="images/doctor-thumb-01.jpg" alt="img">
										</span>
										<h6 class="fs-16 fw-medium">Dr Edalin</h6>
									</div>
								</div>
								<div>
									<label class="form-label text-gray-6">Review By </label>
									<div class="d-flex align-items-center">
										<span class="user-avatar me-2">
											<img src="images/profile-06.jpg" alt="img">
										</span>
										<h6 class="fs-16 fw-medium">Hendrita</h6>
									</div>
								</div>
								<div>
									<label class="form-label text-gray-6">Rating</label>
									<div class="d-flex align-items-center rating-list">
										<i class="fa-solid fa-star selected"></i>
										<i class="fa-solid fa-star selected"></i>
										<i class="fa-solid fa-star selected"></i>
										<i class="fa-solid fa-star selected"></i>
										<i class="fa-solid fa-star"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="mb-0">
							<div class="review-wrap">
								<label class="form-label text-gray-6">Review</label>
								<p class="mb-0">Dr. Edalin provided exceptional care and took the time to listen to my
									concerns. I’m feeling better than ever and highly recommend him!"</p>
							</div>
						</div>
					</div>
				</form>
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

	<!-- /Edit Dependent Modal-->

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
</body>

</html><?php /**PATH /Users/dope/Documents/sean/sean/resources/views/patient/appointment.blade.php ENDPATH**/ ?>