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
									<li class="breadcrumb-item active">Vitals</li>
								</ol>
								<h2 class="breadcrumb-title">Vitals</h2>
							</nav>
						</div>
					</div>
				</div>
				<div class="breadcrumb-bg">
					<img src="images/breadcrumb-bg-01.png" alt="img" class="breadcrumb-bg-01">
					<img src="images/breadcrumb-bg-02.png" alt="img" class="breadcrumb-bg-02">
					<img src="images/breadcrumb-icon.png" alt="img" class="breadcrumb-bg-03">
					<img src="images/breadcrumb-icon.png" alt="img" class="breadcrumb-bg-04">
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						
						<!-- Profile Sidebar -->
						<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
						<!-- / Profile Sidebar -->
						
						<div class="col-lg-8 col-xl-9">
							<div class="dashboard-header">
								<h3>Vitals</h3>
							</div>		
							<div class="dashboard-card w-100 medical-details-item">
								<div class="dashboard-card-head medical-detail-head">
									<div class="header-title">
										<h6>Latest Updated Vitals</h6>
									</div>
									<div class="latest-update">
										<p><i class="isax isax-calendar-tick5 me-2"></i>Last update on : 24Mar 2023</p>
									</div>
									
								</div>
								<div class="dashboard-card-body">
									<div class="row row-gap-3">
										<div class="col-xl-2 col-lg-4 col-md-6">
											<div class="health-records icon-red mb-0">
												<span><i class="fa-solid fa-syringe"></i>Blood Pressure</span>
												<h3>100 mg/dl</h3>
											</div>
										</div>
										<div class="col-xl-2 col-lg-4 col-md-6">
											<div class="health-records icon-orange mb-0">
												<span><i class="fa-solid fa-heart"></i>Heart Rate</span>
												<h3>140 Bpm</h3>
											</div>
										</div>
										<div class="col-xl-2 col-lg-4 col-md-6">
											<div class="health-records icon-dark-blue mb-0">
												<span><i class="fa-solid fa-notes-medical"></i>Glucose Level</span>
												<h3>70 - 90</h3>
											</div>
										</div>
										<div class="col-xl-2 col-lg-4 col-md-6">
											<div class="health-records icon-amber mb-0">
												<span><i class="fa-solid fa-temperature-high"></i>Body Temprature</span>
												<h3>37.5 C</h3>
											</div>
										</div>
										<div class="col-xl-2 col-lg-4 col-md-6">
											<div class="health-records icon-purple mb-0">
												<span><i class="fa-solid fa-user-pen"></i>BMI </span>
												<h3>20.1 kg/m2</h3>
											</div>
										</div>
										<div class="col-xl-2 col-lg-4 col-md-6">
											<div class="health-records icon-blue mb-0">
												<span><i class="fa-solid fa-highlighter"></i>SPo2</span>
												<h3>96%</h3>
											</div>
										</div>																		
									</div>
								</div>
								
							</div>	
							<div class="dashboard-header border-0 m-0">
								<ul class="header-list-btns">
									<li>
										<div class="input-block dash-search-input">
											<input type="text" class="form-control" placeholder="Search">
											<span class="search-icon"><i class="isax isax-search-normal"></i></span>
										</div>
									</li>
								</ul>
								<a href="#add-med-record" class="btn btn-md btn-primary-gradient rounded-pill" data-bs-toggle="modal">Add Vitals</a>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="custom-table">
										<div class="table-responsive">
											<table class="table table-center mb-0">
												<thead>
													<tr>
														<th>ID</th>
														<th>Patient Name</th>
														<th>BMI</th>
														<th>Heart Rate</th>
														<th>FBC Status</th>
														<th>Weight</th>
														<th>Added on</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><a class="link-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#med-detail">#MD1236</a></td>
														<td>
															<h2 class="table-avatar">
																<a href="patient-profile.html" class="avatar avatar-sm me-2">
																	<img class="avatar-img rounded-3" src="images/profile-06.jpg" alt="User Image">
																</a>
																<a href="doctor-profile.html">Hendrita Kearns</a>
															</h2>
														</td>
														<td>23.5</td>
														<td>89</td>
														<td>140</td>
														<td>74Kg</td>
														<td>22 Mar 2024</td>
														<td>
															<div class="action-item">
																<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#med-detail">
																	<i class="isax isax-link-2"></i>
																</a>
																<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit-med-record">
																	<i class="isax isax-edit-2"></i>
																</a>
																<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal">
																	<i class="isax isax-trash"></i>
																</a>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
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

        <!-- Add Medical Detail -->
		<div class="modal fade custom-modals" id="add-med-record">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Vitals</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<form action="medical-details.html">
						<div class="modal-body pb-0">
							<div class="timing-modal">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">BMI <span class="text-danger">*</span></label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">Heart Rate <span class="text-danger">*</span></label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">Weight <span class="text-danger">*</span></label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">FBC <span class="text-danger">*</span></label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-md-12">
										<div class="mb-3">
											<label class="col-form-label">Date <span class="text-danger">*</span></label>
											<div class="form-icon">
												<input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy">
												<span class="icon"><i class="isax isax-calendar-1"></i></span>
											</div>
										</div>	
									</div>
								</div>	
							</div>
						</div>
						<div class="modal-footer">	
							<div class="modal-btn text-end">
								<a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
								<button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Add Details</button>
							</div>			
						</div>
					</form>
				</div>
			</div>
		</div>
        <!-- /Add Medical Detail -->

		<!-- Edit Medical Detail -->
		<div class="modal fade custom-modals" id="edit-med-record">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit Medical Details</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<form action="medical-details.html">
						<div class="modal-body">
							<div class="timing-modal">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">BMI <span class="text-danger">*</span></label>
											<input type="text" class="form-control" value="20.1 kg/m2">
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">Heart Rate <span class="text-danger">*</span></label>
											<input type="text" class="form-control" value="140 Bpm">
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">Weight <span class="text-danger">*</span></label>
											<input type="text" class="form-control" value="300">
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">FBC <span class="text-danger">*</span></label>
											<input type="text" class="form-control" value="70 - 90">
										</div>
									</div>
									<div class="col-md-12">
										<div class="mb-3">
											<label class="col-form-label">Date <span class="text-danger">*</span></label>
											<div class="form-icon">
												<input type="text" class="form-control datetimepicker" value="23/12/2024">
												<span class="icon"><i class="isax isax-calendar-1"></i></span>
											</div>
										</div>	
									</div>
								</div>	
							</div>
						</div>
						<div class="modal-footer">		
							<div class="modal-btn text-end">
								<a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
								<button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Details</button>
							</div>			
						</div>
					</form>
				</div>
			</div>
		</div>
        <!-- /Edit Medical Detail -->

		<!-- Medical Detail -->
		<div class="modal fade custom-modals" id="med-detail">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Vital Details</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<form action="medical-details.html">
						<div class="modal-body pb-0">
							<div class="med-detail-patient">
								<div class="med-patient">
									<span><img src="images/profile-06.jpg" alt="Img"></span>
									<div class="name-detail">
										<h5>Hendrita Kearns</h5>
										<ul>
											<li>Age : 42 </li>
											<li>Female</li>
											<li>AB+ve</li>
										</ul>
									</div>
								</div>
								<div class="date-cal">
									<p><span><i class="isax isax-calendar-tick5 me-1"></i>Last Updated</span>24 Mar 2024</p>
								</div>
							</div>
							<div class="med-detail-item pb-3">
								<div class="row">
									<div class="col-md-6 col-lg-4">
										<div class="health-records icon-red">
											<span><i class="fa-solid fa-syringe"></i>Blood Pressure</span>
											<h3>100 mg/dl</h3>
										</div>
									</div>
									<div class="col-md-6 col-lg-4">
										<div class="health-records icon-orange">
											<span><i class="fa-solid fa-heart"></i>Heart Rate</span>
											<h3>140 Bpm</h3>
										</div>
									</div>
									<div class="col-md-6 col-lg-4">
										<div class="health-records icon-dark-blue">
											<span><i class="fa-solid fa-notes-medical"></i>Glucose Level</span>
											<h3>70 - 90</h3>
										</div>
									</div>
									<div class="col-md-6 col-lg-4">
										<div class="health-records icon-amber mb-0">
											<span><i class="fa-solid fa-temperature-high"></i>Body Temprature</span>
											<h3>37.5 C</h3>
										</div>
									</div>
									<div class="col-md-6 col-lg-4">
										<div class="health-records icon-purple mb-0">
											<span><i class="fa-solid fa-user-pen"></i>BMI </span>
											<h3>20 kg/m2</h3>
										</div>
									</div>
									<div class="col-md-6 col-lg-4">
										<div class="health-records icon-blue mb-0">
											<span><i class="fa-solid fa-highlighter"></i>SPo2</span>
											<h3>96%</h3>
										</div>
									</div>
								</div>																
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
        <!-- /Medical Detail -->		

		<!-- Delete -->
		<div class="modal fade custom-modals" id="delete_modal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body p-4 text-center">
						<form action="medical-details.html">
							<span class="del-icon mb-2 mx-auto">
								<i class="isax isax-trash"></i>
							</span>
							<h3 class="mb-2">Delete Vital</h3>
							<p class="mb-3">Are you sure you want to delete this vital?</p>
							<div class="d-flex justify-content-center flex-wrap gap-3">
								<a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-dismiss="modal">Cancel</a>
								<button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Yes Delete</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /Delete -->

		<!-- jQuery -->
		<script src="js/jquery-3.7.1.min.js" type="f4c3ecd564047f814e484e58-text/javascript"></script>
		<script src="js/jquery-ui.min.js" type="f4c3ecd564047f814e484e58-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="js/bootstrap.bundle.min.js" type="f4c3ecd564047f814e484e58-text/javascript"></script>

		<!-- Datepicker JS -->
		<script src="js/moment.min.js" type="f4c3ecd564047f814e484e58-text/javascript"></script>
		<script src="js/bootstrap-datetimepicker.min.js" type="f4c3ecd564047f814e484e58-text/javascript"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="js/ResizeSensor.js" type="f4c3ecd564047f814e484e58-text/javascript"></script>
        <script src="js/theia-sticky-sidebar.js" type="f4c3ecd564047f814e484e58-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="js/script.js" type="f4c3ecd564047f814e484e58-text/javascript"></script>
		
	<script src="js/rocket-loader.min.js" data-cf-settings="f4c3ecd564047f814e484e58-|49" defer=""></script>
</body></html><?php /**PATH /home/u881803686/domains/medicalsean.org/public_html/resources/views/patient/vitals.blade.php ENDPATH**/ ?>