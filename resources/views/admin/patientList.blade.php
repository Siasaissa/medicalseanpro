@include('layouts.adminHead')
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Header -->
            @include('layouts.adminHeader')
			<!-- /Header -->
			
			<!-- Sidebar -->
          @include('layouts.adminSidebar')
			<!-- /Sidebar -->
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">List of Patient</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item"><a href="javascript:(0);">Users</a></li>
									<li class="breadcrumb-item active">Patient</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Patient ID</th>
													<th>Patient Name</th>
													<th>Age</th>
													<th>Address</th>
													<th>Phone</th>
													<th>Last Visit</th>
													<th>Paid</th>
												</tr>
											</thead>
											<tbody>
                                                @foreach ($patient as $pat)
												<tr>
													<td>#PT00{{ $pat->user->id }}</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="{{ asset($pat->dp) }}" alt="User Image"></a>
															<a href="profile.html">{{ $pat->user->name }} </a>
														</h2>
													</td>
													<td>{{ $pat->dob }}</td>
													<td>{{ $pat->address }}</td>
													<td>{{ $pat->phone_numbers }}</td>
                                                    <!--this not well implemented-->
													<td>{{ $pat->user->bookings->last()->appointment_datetime ?? 'No bookings yet' }}</td>
													<td>{{  number_format($pat->user->bookings->sum('total'), 2) }}</td>
                                                    <!--this not well implemented-->
												</tr>
												 @endforeach
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
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="{{asset('js/jquery-3.7.1.min.js')}}" type="19470c6f2889598125eb9c58-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{asset('js/bootstrap.bundle.min.js')}}" type="19470c6f2889598125eb9c58-text/javascript"></script>
		
		<!-- Slimscroll JS -->
        <script src="{{asset('js/jquery.slimscroll.min.js')}}" type="19470c6f2889598125eb9c58-text/javascript"></script>
		
		<!-- Datatables JS -->
		<script src="{{asset('js/jquery.dataTables.min.js')}}" type="19470c6f2889598125eb9c58-text/javascript"></script>
		<script src="{{asset('js/datatables.min.js')}}" type="19470c6f2889598125eb9c58-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="{{asset('js/script.js')}}" type="19470c6f2889598125eb9c58-text/javascript"></script>
		
    <script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="19470c6f2889598125eb9c58-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"="" crossorigin="anonymous"></script>

</body></html>