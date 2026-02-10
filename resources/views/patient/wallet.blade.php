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
									<li class="breadcrumb-item active">Wallet</li>
								</ol>
								<h2 class="breadcrumb-title">Wallet</h2>
							</nav>
						</div>
					</div>
				</div>
				<div class="breadcrumb-bg">
				<img src="{{asset('images/breadcrumb-bg-01.png')}}" alt="img" class="breadcrumb-bg-01">
				<img src="{{asset('images/breadcrumb-bg-02.png')}}" alt="img" class="breadcrumb-bg-02">
				<img src="{{asset('images/breadcrumb-icon.png')}}" alt="img" class="breadcrumb-bg-03">
				<img src="{{asset('images/breadcrumb-icon.png')}}" alt="img" class="breadcrumb-bg-04">
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
							<div class="accunts-sec">
								<div class="dashboard-header">
									<div class="header-back">									
										<h3>Wallet</h3>
									</div>
								</div>
								<div class="account-details-box">
									<div class="row">
										<div class="col-xxl-7 col-lg-7">
											<div class="account-payment-info">
												<div class="row">
													<div class="col-lg-6 col-md-6">
														<div class="payment-amount">
															<h6><i class="isa isax-wallet-25 text-warning"></i>Total Balance</h6>
															<span>Tsh 1200</span>
														</div>
													</div>
													<div class="col-lg-6 col-md-6">
														<div class="payment-amount">
															<h6><i class="isax isax-document5 text-success"></i>Total Transaction</h6>
															<span>{{ number_format($total,2)}}</span>
														</div>
													</div>
												</div>
												<div class="payment-request">
													<span>Last Payment Request: {{ $history->first()->appointment_datetime }}</span>

													<a href="#payment_request" class="btn btn-md btn-primary-gradient rounded-pill" data-bs-toggle="modal">Add Payment</a>
												</div>
											</div>
										</div>
										<div class="col-xxl-5 col-lg-5">
											<div class="bank-details-info">
												<h3>Bank Details</h3>
												<ul>
													<li>
														<h6>Bank Name</h6>
														<h5>Citi Bank Inc</h5>
													</li>
													<li>
														<h6>Account Number</h6>
														<h5>5396 5250 1908 XXXX</h5>
													</li>
													<li>
														<h6>Branch Name</h6>
														<h5>London</h5>
													</li>
													<li>
														<h6>Account Name</h6>
														<h5>Darren</h5>
													</li>
												</ul>
												<div class="edit-detail-link d-flex align-items-center justify-content-between w-100">
													<div>
														<a href="#edit_card" data-bs-toggle="modal">Edit Details</a>
														<a href="#add_card" data-bs-toggle="modal">Add Cards</a>
													</div>
													<a href="#other_accounts" data-bs-toggle="modal">Other Accounts</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="account-detail-table">
										
										<div class="custom-new-table">
											<div class="table-responsive">
												<table class="table table-center mb-0">
													<thead>
														<tr>
															<th>ID</th>
															<th>Account No</th>
															<th>Appointment</th>
															<th>Debited / Credited On</th>
															<th>Amount(TZS)</th>
															<th>Status</th>
														</tr>
													</thead>
													<tbody>
														@foreach ($history as $transact )
														<tr>
															<td>
																<a href="javascript:void(0);" class="link-primary">#AC000{{ $loop->iteration }}</a>
															</td>
															<td class="text-gray-9">{{ $transact->phone }}</td>
															<td>{{ $transact->appointment_type }}</td>
															<td>{{ $transact->appointment_datetime }}</td>
														<td>{{ number_format($transact->service_price,2) }}</td>
														@if ( $transact->appointment_datetime < now() )
															<td>
																<span class="badge badge-success-transparent inline-flex align-items-center"><i class="fa-solid fa-circle me-1 fs-5"></i>Completed</span>
															</td>
															@else
															<td>
																<span class="badge badge-warning-transparent inline-flex align-items-center"><i class="fa-solid fa-circle me-1 fs-5"></i>Pending</span>
															</td>
														@endif
														</tr>
														@endforeach
													</tbody>
												</table>
												<div class="mt-3">
													{{ $history->links() }}
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

		<!-- Payment Moodal -->
		<div class="modal fade custom-modals" id="payment_request">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
					</div>
					<form action="patient-accounts.html">
						<div class="modal-body pb-0">
							<div class="mb-3">
								<label class="form-label">Enter Amount <span class="text-danger">*</span></label>
								<input type="text" class="form-control">
							</div>	
							<div class="mb-3">
								<label class="form-label">Select Payment Gateway <span class="text-danger">*</span></label>
								<select class="select">
									<option>Select</option>
									<option>Card</option>
									<option>Paypal</option>
								</select>
							</div>			
						</div>
						<div class="modal-footer">					
							<div class="modal-btn text-end">
								<a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
								<button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Add to Wallet</button>
							</div>
						</div>
					</form>		
				</div>
			</div>
		</div>
        <!-- /Payment Moodal -->

        <!-- Account Details Modal-->
        <div class="modal fade custom-modals" id="add_card">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Card</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
					</div>
					<form action="patient-accounts.html">
						<div class="modal-body pb-0">
							<div class="mb-3">
								<label class="form-label">Card Holder Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control">
							</div>	
							<div class="mb-3">
								<label class="form-label">Card Number <span class="text-danger">*</span></label>
								<input type="text" class="form-control">
							</div>
							<div class="mb-3">
								<label class="form-label">Expire Date <span class="text-danger">*</span></label>
								<div class="form-icon">
									<input type="text" class="form-control datetimepicker">
									<span class="icon"><i class="isax isax-calendar-1"></i></span>
								</div>
							</div>
							<div class="mb-3">
								<label class="form-label">CVV <span class="text-danger">*</span></label>
								<input type="text" class="form-control">
							</div>
							<div class="mb-3">
								<label class="form-label">Branch <span class="text-danger">*</span></label>
								<select class="select">
									<option>Select</option>
									<option>London</option>
									<option>Newyork</option>
								</select>
							</div>				
						</div>
						<div class="modal-footer">				
							<div class="modal-btn d-flex align-items-center justify-content-between flex-wrap gap-3 w-100">
								<div class="form-check d-flex">
									<input class="form-check-input" type="checkbox" id="mark">
									<label class="form-check-label fs-14 ms-2" for="mark">
										Mark as Default
									</label>
								</div>
								<div>
									<a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
									<button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Add Card</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
        <!-- /Account Details Modal-->

		 <!-- Account Details Modal-->
		 <div class="modal fade custom-modals" id="edit_card">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit Card</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
					</div>
					<form action="patient-accounts.html">
						<div class="modal-body pb-0">
							<div class="mb-3">
								<label class="form-label">Card Holder Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" value="Darren">
							</div>	
							<div class="mb-3">
								<label class="form-label">Card Number <span class="text-danger">*</span></label>
								<input type="text" class="form-control" value="5396 5250 1908 1647">
							</div>
							<div class="mb-3">
								<label class="form-label">Expire Date <span class="text-danger">*</span></label>
								<div class="form-icon">
									<input type="text" class="form-control datetimepicker" value="15-04-2026">
									<span class="icon"><i class="isax isax-calendar-1"></i></span>
								</div>
							</div>
							<div class="mb-3">
								<label class="form-label">CVV <span class="text-danger">*</span></label>
								<input type="text" class="form-control" value="556">
							</div>
							<div class="mb-3">
								<label class="form-label">Branch <span class="text-danger">*</span></label>
								<select class="select">
									<option>Select</option>
									<option selected="">London</option>
									<option>Newyork</option>
								</select>
							</div>				
						</div>
						<div class="modal-footer">					
							<div class="modal-btn d-flex align-items-center justify-content-between flex-wrap gap-3 w-100">
								<div class="form-check d-flex">
									<input class="form-check-input" type="checkbox" id="mark1" checked="">
									<label class="form-check-label fs-14 ms-2" for="mark1">
										Mark as Default
									</label>
								</div>
								<div>
									<a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
									<button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Changes</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
        <!-- /Account Details Modal-->

		<!-- Other Accounts Modal-->
        <div class="modal fade custom-modals modal-lg" id="other_accounts">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Other Accounts</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
					</div>
					<div class="modal-body">
						<div class="other-accounts-info">
							<ul>
								<li>
									<ul class="other-bank-info">
										<li>
											<h6>Name</h6>
											<span>Citi Bank Inc</span>
										</li>
										<li>
											<h6>Account No</h6>
											<span>5396 5250 1908 XXXX</span>
										</li>
										<li>
											<h6>Branch</h6>
											<span>London</span>
										</li>
										<li>
											<h6>Name on Bank Account</h6>
											<span>Edalin Hendry</span>
										</li>
										<li>
											<a href="#">Current</a>
										</li>
									</ul>
								</li>
								<li>
									<ul class="other-bank-info">
										<li>
											<h6>Name</h6>
											<span>HDFC Bank Inc</span>
										</li>
										<li>
											<h6>Account No</h6>
											<span>7382 4924 4924 XXXX</span>
										</li>
										<li>
											<h6>Branch</h6>
											<span>New York</span>
										</li>
										<li>
											<h6>Name on Bank Account</h6>
											<span>Edalin Hendry</span>
										</li>
										<li>
											<a href="#">Change to default</a>
										</li>
									</ul>
								</li>
								<li>
									<ul class="other-bank-info">
										<li>
											<h6>Name</h6>
											<span>Union Bank Inc</span>
										</li>
										<li>
											<h6>Account No</h6>
											<span>8934 4902 9024 XXXX</span>
										</li>
										<li>
											<h6>Branch</h6>
											<span>Chicago</span>
										</li>
										<li>
											<h6>Name on Bank Account</h6>
											<span>Edalin Hendry</span>
										</li>
										<li>
											<a href="#">Change to default</a>
										</li>
									</ul>
								</li>
								<li>
									<ul class="other-bank-info">
										<li>
											<h6>Name</h6>
											<span>KVB Bank Inc</span>
										</li>
										<li>
											<h6>Account No</h6>
											<span>5892 4920 4829 XXXX</span>
										</li>
										<li>
											<h6>Branch</h6>
											<span>Austin</span>
										</li>
										<li>
											<h6>Name on Bank Account</h6>
											<span>Edalin Hendry</span>
										</li>
										<li>
											<a href="#">Change to default</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
					<div class="modal-footer">					
						<div class="modal-btn text-end">
							<button type="submit" class="btn btn-md btn-primary-gradient rounded-pill" data-bs-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!-- /Other Accounts Modal-->

		<!-- Request Completed Modal-->
        <div class="modal fade custom-modal custom-modal-two" id="request_details_modal">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Request Details <span class="badge badge-success-bg">Completed</span></h5>
						<button type="button" data-bs-dismiss="modal" aria-label="Close">
							<span><i class="fa-solid fa-x"></i></span>
						</button>
					</div>
					<div class="modal-body">
						<div class="completed-request">
							<ul>
								<li>
									<h6>ID</h6>
									<span>#AC-1234</span>
								</li>
								<li>
									<h6>Requested on</h6>
									<span>24 Mar 2024</span>
								</li>
								<li>
									<h6>Credited Date</h6>
									<span>24 Mar 2024</span>
								</li>
								<li>
									<h6>Amount</h6>
									<span class="link-primary">Tsh 300</span>
								</li>
							</ul>
							<div class="bank-detail">
								<h4>Bank Details</h4>
								<div class="accont-information">
									<h6>Name</h6>
									<span>Citi Bank Inc</span>
								</div>
								<div class="accont-information">
									<h6>Account No</h6>
									<span>5396 5250 1908 XXXX</span>
								</div>
								<div class="accont-information">
									<h6>Branch</h6>
									<span>London</span>
								</div>
							</div>
							<div class="request-des">
								<h4>Reqeust Description</h4>
								<p>I recently completed a series of dental treatments with Dr.Edalin Hendry, 
									and I couldn't be more pleased with the results. From my very first appointment.
								</p>
							</div>
							<a href="#" class="btn btn-primary prime-btn w-100" data-bs-dismiss="modal">Close</a>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!-- /Request Completed Modal-->

		<!-- Request Cancel Modal-->
        <div class="modal fade custom-modal custom-modal-two" id="request_cancel_modal">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Request Details <span class="badge badge-danger-bg">Cancelled</span></h5>
						<button type="button" data-bs-dismiss="modal" aria-label="Close">
							<span><i class="fa-solid fa-x"></i></span>
						</button>
					</div>
					<div class="modal-body">
						<div class="cancelled-request">
							<div class="canceled-user-info d-flex align-items-center">
								<div class="patinet-information">
									<a href="doctor-upcoming-appointment.html">
										<img src="images/profile-01.jpg" alt="User Image">
									</a>
									<div class="patient-info">
										<p>#Apt0001</p>
										<h6><a href="doctor-upcoming-appointment.html">Adrian</a></h6>
									</div>
								</div>
								<div class="email-info">
									<ul>
										<li><i class="isax isax-sms5"></i><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="41202533202f012439202c312d246f222e2c">[email�protected]</a></li>
										<li><i class="isax isax-call5"></i>+1 504 368 6874</li>
									</ul>
								</div>
							</div>
							<div class="cancellation-fees">
								<h6>Consultation Fees : Tsh 200</h6>
								<div class="cancellation-info">
									<div class="appointment-type">
										<p class="md-text">Type of Appointment</p>
										<p><i class="fa-solid fa-building text-green"></i>Direct Visit</p>
									</div>
									<div class="appointment-type">
										<p class="md-text">Clinic Location</p>
										<p>Adrian’s Dentistry</p>
									</div>
								</div>
							</div>
							<div class="cancel-reason">
								<h5>Reason</h5>
								<p>I have an urgent surgery, while our Appointment so i am rejecting appointment </p>
								<span class="text-danger">Cancelled By You on 23 Mar 2024</span>
							</div>
							<div class="refund-status">
								<span class="link-primary refund">Status :  Initiated</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!-- /Request Cancel Modal-->

		<!-- Refund Request Modal-->
		<div class="modal fade info-modal" id="refund-request">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body">
						<div class="success-wrap text-center">
							<span class="icon-success"><i class="fa-solid fa-calendar-check"></i></span>
							<h3>Refund initiated Successfully</h3>
							<p>Your Payment will be credited in your bank account in 3 working days</p>
							<a href="#" class="btn btn-primary prime-btn" data-bs-dismiss="modal">Okay</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Refund Request Modal-->

		<!-- jQuery -->
		<script data-cfasync="false" src="js/email-decode.min.js"></script><script src="js/jquery-3.7.1.min.js" type="0e7fcd53f25f2f015208dcc9-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="js/bootstrap.bundle.min.js" type="0e7fcd53f25f2f015208dcc9-text/javascript"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="js/ResizeSensor.js" type="0e7fcd53f25f2f015208dcc9-text/javascript"></script>
        <script src="js/theia-sticky-sidebar.js" type="0e7fcd53f25f2f015208dcc9-text/javascript"></script>
		
		<!-- Select2 JS -->
		<script src="js/select2.min.js" type="0e7fcd53f25f2f015208dcc9-text/javascript"></script>
		
		<!-- Datepicker JS -->
		<script src="js/moment.min.js" type="0e7fcd53f25f2f015208dcc9-text/javascript"></script>
		<script src="js/bootstrap-datetimepicker.min.js" type="0e7fcd53f25f2f015208dcc9-text/javascript"></script>

        <!-- Custom JS -->
		<script src="js/script.js" type="0e7fcd53f25f2f015208dcc9-text/javascript"></script>
		
	<script src="js/rocket-loader.min.js" data-cf-settings="0e7fcd53f25f2f015208dcc9-|49" defer=""></script>
</body></html>