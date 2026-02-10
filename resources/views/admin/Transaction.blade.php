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
							<h3 class="page-title">Transactions</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
								<li class="breadcrumb-item active">Transactions</li>
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
												<th>Invoice Number</th>
												<th>Patient ID</th>
												<th>Patient Name</th>
												<th>Total Amount</th>
												<th>Status</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($transactions as $trans)
																				<tr>
																					<td>
																						<a href="">#ORD{{ str_pad($trans->id, 4, '0', STR_PAD_LEFT) }}</a>
																					</td>

																					<td>
																						@if($trans->user_id)
																							#USR{{ str_pad($trans->user_id, 3, '0', STR_PAD_LEFT) }}
																						@else
																							Guest
																						@endif
																					</td>

																					<td>
																						<h2 class="table-avatar">
																							<a href="profile.html" class="avatar avatar-sm me-2">
																								<img class="avatar-img rounded-circle"
																									src="{{ asset($trans->profile->dp) }}"
																									alt="User Image">
																							</a>
																							<a href="profile.html">
																								{{ $trans->user->name ?? 'Guest User' }}
																							</a>
																						</h2>
																					</td>

																					<td>
																						Tsh. {{ number_format($trans->total, 0) }}
																					</td>

																					<td>
																						<span class="badge rounded-pill 
																							@if($trans->status == 'paid') bg-success 
																							@elseif($trans->status == 'pending') bg-warning 
																							@else bg-danger @endif">
																							{{ ucfirst($trans->status) }}
																						</span>
																					</td>

																					<td>
																						<div class="actions">
																							<a href="#" class="btn btn-sm bg-success-light">
																								<i class="fe fe-eye"></i> View
																							</a>
																							<a href="#" class="btn btn-sm bg-danger-light"
																								data-bs-toggle="modal"
																								data-bs-target="#delete_modal_{{ $trans->id }}">
																								<i class="fe fe-trash"></i> Delete
																							</a>
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

		<!-- Delete Modal -->
		<div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div class="form-content p-2">
							<h4 class="modal-title">Delete</h4>
							<p class="mb-4">Are you sure want to delete?</p>
							<button type="button" class="btn btn-primary">Save </button>
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Delete Modal -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="{{asset('js/jquery-3.7.1.min.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{asset('js/bootstrap.bundle.min.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>

	<!-- Slimscroll JS -->
	<script src="{{asset('js/jquery.slimscroll.min.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>

	<!-- Datatables JS -->
	<script src="{{asset('js/jquery.dataTables.min.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>
	<script src="{{asset('js/datatables.min.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>

	<!-- Custom JS -->
	<script src="{{asset('js/script.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>

	<script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="d2241dbc8fbf4e82f8c24724-|49"
		defer=""></script>
	<script defer=""
		src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
		data-cf-beacon="{"
		version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"=""
		crossorigin="anonymous"></script>

</body>

</html>