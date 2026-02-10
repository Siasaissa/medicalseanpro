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
								<h3 class="page-title">List of Doctors</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item"><a href="javascript:(0);">Users</a></li>
									<li class="breadcrumb-item active">Doctor</li>
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
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Doctor Name</th>
													<th>Speciality</th>
													<th>Member Since</th>
													<th>Earned</th>
													<th>Account Status</th>
												</tr>
											</thead>
											<tbody>
                                                @foreach ( $doctor as $doc)

												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="{{asset($doc->dp)}}" alt="User Image"></a>
															<a href="profile.html">Dr.{{ $doc->user->name }}</a>
														</h2>
													</td>
													<td>{{ $doc->speciality }}</td>
													
													<td>{{ $doc->user->created_at }}</td>
													
													<td>{{ number_format($doc->user->bookings->sum('total'), 2) }}</td>

													
													<td>
														<div class="status-toggle">
															<input type="checkbox" id="status_{{ $doc->user->id }}" class="check" checked="">
															<label for="status_{{ $doc->user->id }}" class="checktoggle">checkbox</label>
														</div>
													</td>
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
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="{{asset('js/jquery-3.7.1.min.js')}}" type="0c2b779c6675905b93f86060-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{asset('js/bootstrap.bundle.min.js')}}" type="0c2b779c6675905b93f86060-text/javascript"></script>
		
		<!-- Slimscroll JS -->
        <script src="{{asset('js/jquery.slimscroll.min.js')}}" type="0c2b779c6675905b93f86060-text/javascript"></script>
		
		<!-- Datatables JS -->
		<script src="{{asset('js/jquery.dataTables.min.js')}}" type="0c2b779c6675905b93f86060-text/javascript"></script>
		<script src="{{asset('js/datatables.min.js')}}" type="0c2b779c6675905b93f86060-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="{{asset('js/script.js')}}" type="0c2b779c6675905b93f86060-text/javascript"></script>
		
    <script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="0c2b779c6675905b93f86060-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"="" crossorigin="anonymous"></script>

</body></html>