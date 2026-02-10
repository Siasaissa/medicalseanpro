@include ('layouts.head')
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
			@include ('layouts.header')
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
									<li class="breadcrumb-item active">Dashboard</li>
								</ol>
								<h2 class="breadcrumb-title">Patient Dashboard</h2>
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
						@include ('layouts.sidebar')
						<!-- / Profile Sidebar -->
						
						<div class="col-lg-8 col-xl-9">
							<div class="dashboard-header">
								<h3>Dashboard</h3>
								<div class="book-appointment-head">
									<h3><span >Book a new Appointment </span></h3>
									<span class="add-icon" style="margin-left: 0.2%;"><a href="{{ route('patient.doctor-grid') }}"><i class="fa-solid fa-circle-plus fs-10 " ></i></a></span>
								</div>							
							</div>
							<div class="col-lg-12 col-xl-12">

							<div class="row">
								<div class="col-xl-12 d-flex">
									<div class="dashboard-box-col w-100">
										<div class="dashboard-widget-box">
											<div class="dashboard-content-info">
												<h6>Total Available Doctor</h6>
												<h4>{{ $data1 ?? 'No data' }}</h4>
												<span class="text-success"><i class="fa-solid fa-arrow-up"></i>15% From Last Week</span>
											</div>
											<div class="dashboard-widget-icon">
												<span class="dash-icon-box"><i class="fa-solid fa-user-injured"></i></span>
											</div>
										</div>
										<div class="dashboard-widget-box">
											<div class="dashboard-content-info">
												<h6>Total Appointment</h6>
												<h4>{{ $data2 ?? 'No data'}}</h4>
												<span class="text-danger"><i class="fa-solid fa-arrow-up"></i>15% From Yesterday</span>
											</div>
											<div class="dashboard-widget-icon">
												<span class="dash-icon-box"><i class="fa-solid fa-user-clock"></i></span>
											</div>
										</div>
										<div class="dashboard-widget-box">
											<div class="dashboard-content-info">
												<h6>Upcoming Appointment</h6>
												<h4>{{ $data3 ?? 'No data' }}</h4>
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

			</div>		
			<!-- /Page Content -->
   
			<!-- Footer Section -->
			@include ('layouts.footer')
			<!-- /Footer Section -->
		   
		</div>
		<!-- /Main Wrapper -->

		<!-- Add Dependent Modal-->
		<div class="modal fade custom-modals" id="add_dependent">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Add Dependant</h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<form action="#">					
						<div class="add-dependent">
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-wrap pb-0">
											<div class="change-avatar img-upload">
												<div class="profile-img">
													<i class="fa-solid fa-file-image"></i>
												</div>
												<div class="upload-img">
													<h5>Profile Image</h5>
													<div class="imgs-load d-flex align-items-center">
														<div class="change-photo">
															Upload New 
															<input type="file" class="upload">
														</div>
														<a href="#" class="upload-remove">Remove</a>
													</div>
													<p>Your Image should Below 4 MB, Accepted format jpg,png,svg</p>
												</div>			
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-wrap">
											<label class="col-form-label">Name</label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-wrap">
											<label class="col-form-label">Relationship</label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-wrap">
											<label class="col-form-label">DOB <span class="text-danger">*</span></label>
											<div class="form-icon">
												<input type="text" class="form-control datetimepicker">
												<span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-wrap">
											<label class="col-form-label">Select Gender</label>
											<select class="select">
												<option>Select</option>
												<option>Male</option>
												<option>Female</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">					
							<div class="modal-btn text-end">
								<a href="#" class="btn btn-gray" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
								<button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Add Dependent Modal-->

		<!--View Invoice -->
		<div class="modal fade custom-modals" id="invoice_view">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">View Invoice</h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>				
					<div class="modal-body pb-0">
						<div class="prescribe-download">
							<h5>21 Mar  2024</h5>
							<ul>
								<li><a href="javascript:void(0);" class="print-link"><i class="isax isax-printer"></i></a></li>
								<li><a href="#" class="btn btn-md btn-primary-gradient rounded-pill">Download</a></li>
							</ul>							
						</div>
						<div class="view-prescribe invoice-content mb-0">
							<div class="invoice-item">
								<div class="row">
									<div class="col-md-6">
										<div class="invoice-logo">
											<img src="images/logo.svg" alt="logo">
										</div>
									</div>
									<div class="col-md-6">
										<p class="invoice-details">
											Invoice No : <span> #INV005</span><br>
											Issued: <span>21 Mar 2024</span>
										</p>
									</div>
								</div>
							</div>
							
							<!-- Invoice Item -->
							<div class="invoice-item">
								<div class="row">
									<div class="col-md-4">
										<div class="invoice-info">
											<h6 class="customer-text">Billing From</h6>
											<p class="invoice-details invoice-details-two">
												Edalin Hendry <br>
												806 Twin Willow Lane, <br>
												Newyork, USA <br>
											</p>
										</div>
									</div>
									<div class="col-md-4">
										<div class="invoice-info">
											<h6 class="customer-text">Billing To</h6>
											<p class="invoice-details invoice-details-two">
												Richard Wilson <br>
												299 Star Trek Drive<br>
												Florida, 32405, USA<br>
											</p>
										</div>
									</div>
									<div class="col-md-4">
										<div class="invoice-info invoice-info2">
											<h6 class="customer-text">Payment Method</h6>
											<p class="invoice-details">
												Debit Card <br>
												XXXXXXXXXXXX-2541<br>
												HDFC Bank<br>
											</p>
										</div>
									</div>
								</div>
							</div>
							<!-- /Invoice Item -->
							
							<!-- Invoice Item -->
							<div class="invoice-item invoice-table-wrap">
								<div class="row">
									<div class="col-md-12">
										<h6>Invoice Details</h6>
										<div class="invoice-table">
											<div class="table-responsive">
												<table class="table table-bordered">
													<thead>
														<tr>
															<th>Description</th>
															<th>Quatity</th>
															<th>VAT</th>
															<th>Total</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="text-gray-9">General Consultation</td>
															<td>1</td>
															<td>$0</td>
															<td>$150</td>
														</tr>
														<tr>
															<td class="text-gray-9">Video Call</td>
															<td>1</td>
															<td>$0</td>
															<td>$100</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xl-4 ms-auto">
										<div class="table-responsive">
											<table class="invoice-table-two table">
												<tbody>
												<tr>
													<th>Subtotal:</th>
													<td><span>$350</span></td>
												</tr>
												<tr>
													<th>Discount:</th>
													<td><span>-10%</span></td>
												</tr>
												<tr>
													<th>Total Amount:</th>
													<td><span>$315</span></td>
												</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- /Invoice Item -->
							
							<!-- Invoice Information -->
							<div class="other-info mb-0">
								<h6 class="mb-2">Other information</h6>
								<p class="text-gray-9 mb-0">An account of the present illness, which includes the circumstances surrounding the onset of recent health changes and the chronology of subsequent events that have led the patient to seek medicine</p>
							</div>
							<!-- /Invoice Information -->
							
						</div>	
					</div>
				</div>
			</div>
		</div>
		<!-- /View Invoice -->			

		 <!--View Report -->
		 <div class="modal fade custom-modals" id="view_report">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">View Report</h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>				
					<div class="modal-body pb-0">
						<div class="prescribe-download gap-2">
							<h5>21 Mar  2024</h5>
							<ul>
								<li><a href="javascript:void(0);" class="print-link"><i class="fa-solid fa-print"></i></a></li>
								<li><a href="#" class="btn btn-md btn-primary-gradient rounded-pill">Download</a></li>
							</ul>							
						</div>
						<div class="view-prescribe-details p-0 border-0">
							
							<!-- Invoice Item -->
							<div class="invoice-item">
								<div class="row">
									<div class="col-md-6">
										<div class="invoice-info d-flex align-items-center">
											<div class="clinic-image d-inline-flex align-items-center justify-content-center">
												<img src="images/vtaplus.svg" alt="img">
											</div>
											<div>
												<h6 class="fs-16 fw-semibold">Vitalplus Clinic</h6>
												<p class="fs-14 fw-medium">Dr. Sandy Maria</p>
												<p class="fs-14">MBLS,MS</p>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="invoice-info2">
											<p><span>Test Type : </span>CBC</p>
											<p><span>Collected On : </span>20 Mar 2024, 10:00 AM</p>
											<p><span>Reported On :  </span>21 Mar 2024, 11:00 AM</p>
										</div>
									</div>
									<div class="col-md-12">
										<div class="patient-infos d-flex align-items-center justify-content-between gap-3 flex-wrap">
											<div class="d-flex align-items-center">
												<span class="avatar me-2">
													<img src="images/profile-06.jpg" class="rounded" alt="img">
												</span>
												<div>
													<h6 class="fs-14 fw-medium">Hendrita Kearns</h6>
													<p>Patient ID : PT254654</p>
												</div>
											</div>
											<div>
												<h6 class="fs-14 fw-medium">Gender</h6>
												<p>Female</p>
											</div>
											<div>
												<h6 class="fs-14 fw-medium">Age</h6>
												<p>32 years </p>
											</div>
											<div>
												<h6 class="fs-14 fw-medium">Blood</h6>
												<p>O+</p>
											</div>
											<div>
												<h6 class="fs-14 fw-medium">Type</h6>
												<p>Outpatient</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Invoice Item -->
							
							<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
								<h6>Complete Blood Count(CBC)</h6>
								<p class="fs-14 mb-0"><span class="text-gray-9">Primary Test Type :</span> Blood</p>
							</div>

							<!-- Invoice Item -->
							<div class="invoice-item invoice-table-wrap">
								<div class="row">
									<div class="col-md-12">
										<div class="table-responsive inv-table">
											<table class="invoice-table table table-bordered">
												<thead>
													<tr>
														<th>Investigation</th>
														<th>Result</th>
														<th>Reference Value</th>
														<th>Unit</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="report-title" colspan="4">HEMOGLOBIN</td>
													</tr>
													<tr>
														<td>Hemoglobin (Hb)</td>
														<td>12.5<span class="badge badge-info-transparent text-xs d-inline-block rounded-pill ms-1">Low</span></td>
														<td>13.0 - 17.0</td>
														<td>g/dL</td>
													</tr>
													<tr>
														<td class="report-title" colspan="4">RBC COUNT</td>
													</tr>
													<tr>
														<td>Total RBC Count</td>
														<td>5.2</td>
														<td>4.5 - 5.5</td>
														<td>million cells/µL</td>
													</tr>
													<tr>
														<td class="report-title" colspan="4">BLOOD INDICES</td>
													</tr>
													<tr>
														<td>Packed Cell Volume (PCV)</td>
														<td class="text-danger">57.5<span class="badge badge-danger-transparent text-xs d-inline-block rounded-pill ms-1">High</span></td>
														<td>40 - 50</td>
														<td>%</td>
													</tr>
													<tr>
														<td>Mean Corpuscular Volume (MCV) <span class="fs-10 text-gray-6">Calculated</span></td>
														<td>87.75</td>
														<td>83 - 101</td>
														<td>fL</td>
													</tr>
													<tr>
														<td>MCH Calculated</td>
														<td>27.72</td>
														<td>27 - 32</td>
														<td>pg</td>
													</tr>
													<tr>
														<td>MCHC Calculated</td>
														<td>32.8</td>
														<td>32.5 - 34.5</td>
														<td>g/dL</td>
													</tr>
													<tr>
														<td>RDW</td>
														<td>13.6</td>
														<td>11.6 - 14.0</td>
														<td>%</td>
													</tr>
													<tr>
														<td class="report-title" colspan="4">WBC COUNT</td>
													</tr>
													<tr>
														<td>Total WBC Count</td>
														<td>9000</td>
														<td>4000 - 11000</td>
														<td>cells/µL</td>
													</tr>
													<tr>
														<td class="report-title" colspan="4">DIFFERENTIAL WBC COUNT</td>
													</tr>
													<tr>
														<td>Neutrophils</td>
														<td>60</td>
														<td>50 - 62</td>
														<td>%</td>
													</tr>
													<tr>
														<td>Lymphocytes</td>
														<td>31</td>
														<td>20 - 40</td>
														<td>%</td>
													</tr>
													<tr>
														<td>Eosinophils</td>
														<td>01</td>
														<td>00 - 06</td>
														<td>%</td>
													</tr>
													<tr>
														<td>Monocytes</td>
														<td>07</td>
														<td>00 - 10</td>
														<td>%</td>
													</tr>
													<tr>
														<td>Basophils</td>
														<td>01</td>
														<td>00 - 02</td>
														<td>%</td>
													</tr>
													<tr>
														<td>Platelet Count</td>
														<td>248157</td>
														<td>150000 - 410000</td>
														<td>µL</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- /Invoice Item -->

							<p class="mb-2"><span class="text-gray-9 fw-medium">Instruments :</span> Fully Automated Cell Counter - Mindray 300</p>
							<p class="mb-3"><span class="text-gray-9 fw-medium">Interpretation :</span> Further confirm for Anemia</p>

							<div class="row align-items-center">
								<div class="col-md-6">
									<div class="scan-wrap">
										<h6>Scan to download report</h6>
										<img src="images/scan.png" alt="scan">
									</div>
								</div>
								<div class="col-md-6">
									<div class="prescriber-info">
										<h6>Dr. Edalin Hendry</h6>
										<p>Dept of Cardiology</p>
									</div>
								</div>
							</div>

							<ul class="nav inv-paginate justify-content-center">
								<li>Page 01 of <a href="#" data-bs-toggle="modal" data-bs-target="#view_prescription2" data-bs-dismiss="modal">02</a></li>
							</ul>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<!-- /View Report -->

		<!--View Prescription -->
		<div class="modal fade custom-modals" id="view_prescription">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">View Prescription</h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>				
					<div class="modal-body pb-0">
						<div class="prescribe-download">
							<h5>21 Mar  2024</h5>
							<ul>
								<li><a href="javascript:void(0);" class="print-link"><i class="isax isax-printer"></i></a></li>
								<li><a href="#" class="btn btn-primary-gradient rounded-pill">Download</a></li>
							</ul>							
						</div>
						<div class="view-prescribe invoice-content mb-0">
							<div class="invoice-item">
								<div class="row">
									<div class="col-md-6">
										<div class="invoice-logo">
											<img src="images/logo.svg" alt="logo">
										</div>
									</div>
									<div class="col-md-6">
										<p class="invoice-details">
											<strong>Prescription ID :</strong> #PR-123 <br>
											<strong>Issued:</strong> 21 Mar 2024
										</p>
									</div>
								</div>
							</div>
							
							<!-- Invoice Item -->
							<div class="invoice-item">
								<div class="row">
									<div class="col-md-6">
										<div class="invoice-info">
											<h6 class="customer-text">Doctor Details</h6>
											<p class="invoice-details invoice-details-two">
												Edalin Hendry <br>
												806 Twin Willow Lane, <br>
												Newyork, USA <br>
											</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="invoice-info invoice-info2">
											<h6 class="customer-text">Patient Details</h6>
											<p class="invoice-details">
												Adrian Marshall <br>
												299 Star Trek Drive,<br>
												Florida, 32405, USA <br>
											</p>
										</div>
									</div>
								</div>
							</div>
							<!-- /Invoice Item -->
							
							<!-- Invoice Item -->
							<div class="invoice-item invoice-table-wrap">
								<div class="row">
									<div class="col-md-12">
										<h6>Prescription  Details</h6>
										<div class="table-responsive">
											<table class="invoice-table table table-bordered">
												<thead>
													<tr>
														<th>Medicine Name</th>
														<th>Dosage</th>
														<th>Frequency</th>
														<th>Duration</th>
														<th>Timings</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Ecosprin 75MG [Asprin 75 MG Oral Tab]</td>
														<td>75 mg <span>Oral Tab</span></td>
														<td>1-0-0-1</td>
														<td>1 month</td>
														<td>Before Meal</td>
													</tr>
													<tr>
														<td>Alexer 90MG Tab</td>
														<td>90 mg <span>Oral Tab</span></td>
														<td>1-0-0-1</td>
														<td>1 month</td>
														<td>Before Meal</td>
													</tr>
													<tr>
														<td>Ramistar XL2.5</td>
														<td>60 mg <span>Oral Tab</span></td>
														<td>1-0-0-0</td>
														<td>1 month</td>
														<td>After Meal</td>
													</tr>
													<tr>
														<td>Metscore</td>
														<td>90 mg <span>Oral Tab</span></td>
														<td>1-0-0-1</td>
														<td>1 month</td>
														<td>After Meal</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- /Invoice Item -->
							
							<!-- Invoice Information -->
							<div class="other-info">
								<h4>Other information</h4>
								<p class="mb-0">An account of the present illness, which includes the circumstances surrounding the onset of recent health changes and the chronology of subsequent events that have led the patient to seek medicine</p>
							</div>
							<div class="other-info">
								<h4>Follow Up</h4>
								<p class="mb-0">Follow up after 3 months, Have to come on empty stomach</p>
							</div>
							<div class="prescriber-info">
								<h6>Dr. Edalin Hendry</h6>
								<p>Dept of Cardiology</p>
							</div>
							<!-- /Invoice Information -->
							
						</div>	
					</div>
				</div>
			</div>
		</div>
		<!-- /View Prescription -->

		<!-- Delete -->
		<div class="modal fade custom-modals" id="delete_modal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body p-4 text-center">
						<form action="patient-dashboard.html">
							<span class="del-icon mb-2 mx-auto">
								<i class="isax isax-trash"></i>
							</span>
							<h3 class="mb-2">Delete Record</h3>
							<p class="mb-3">Are you sure you want to delete this record?</p>
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
		<script src="js/jquery-3.7.1.min.js" type="6bc50912cf75392d43113219-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="js/bootstrap.bundle.min.js" type="6bc50912cf75392d43113219-text/javascript"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="js/ResizeSensor.js" type="6bc50912cf75392d43113219-text/javascript"></script>
        <script src="js/theia-sticky-sidebar.js" type="6bc50912cf75392d43113219-text/javascript"></script>

		<!-- select JS -->
		<script src="js/select2.min.js" type="6bc50912cf75392d43113219-text/javascript"></script>

		<!-- Owl Carousel JS -->
		<script src="js/owl.carousel.min.js" type="6bc50912cf75392d43113219-text/javascript"></script>

		<!-- Apexchart JS -->
		<script src="js/apexcharts.min.js" type="6bc50912cf75392d43113219-text/javascript"></script>
		<script src="js/chart-data.js" type="6bc50912cf75392d43113219-text/javascript"></script>

		<!-- Datepicker JS -->
		<script src="js/moment.min.js" type="6bc50912cf75392d43113219-text/javascript"></script>
		<script src="js/bootstrap-datetimepicker.min.js" type="6bc50912cf75392d43113219-text/javascript"></script>

		<!-- Circle Progress JS -->
		<script src="js/circle-progress.min.js" type="6bc50912cf75392d43113219-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="js/script.js" type="6bc50912cf75392d43113219-text/javascript"></script>
		
	<script src="js/rocket-loader.min.js" data-cf-settings="6bc50912cf75392d43113219-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" rayid":"97d5704dcc429a64","servertiming":{"name":{"cfextpri":true,"cfedge":true,"cforigin":true,"cfl4":true,"cfspeedbrain":true,"cfcachestatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}"="" crossorigin="anonymous"></script>

</body></html>