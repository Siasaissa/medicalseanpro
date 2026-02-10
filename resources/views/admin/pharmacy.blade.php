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
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Products</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active">Products</li>
								</ul>
							</div>
							<div class="col-sm-5 col">
								<a href="{{ route('admin.addproduct') }}" class="btn btn-primary float-end mt-2">Add New</a>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="row">
						<div class="col-md-12">
						
							<!-- Recent Orders -->
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>#</th>
													<th>Product Name</th>
													<th>Category</th>
													<th>Price</th>
													<th>Quantity</th>
													<th>Discount</th>
													<th>Description</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
                                                @foreach ($products as $product)

												<tr>
													<td>{{ $loop->iteration }}</td>
													<td>
														<h2 class="table-avatar">
															<span class="avatar avatar-sm me-2"><img src="{{ asset('storage/' . $product->images[0]) }}" alt="Product image"></span>
															{{ $product->brand_name }}
														</h2>
													</td>
													<td>{{ $product->category }}</td>
													<td>{{ $product->price }}</td>
													<td>{{ $product->quantity }}</td>
													<td>{{ $product->discount }}%</td>
													<td><span class="btn btn-sm bg-success-light">{{ $product->description }}</span></td>
													<td>
														<div class="actions">
															<a class="btn btn-sm bg-success-light" href="#">
																<i class="fe fe-pencil"></i> Edit
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-danger-light" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal{{ $product->id }}">
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
							<!-- /Recent Orders -->
							
						</div>
					</div>
				</div>			
			</div>
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->

		<!-- Model -->
         @foreach ( $products as $product )

		<div class="modal fade" id="deleteConfirmModal{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="acc_title">Delete</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p id="acc_msg">Are you sure you want to delete <span class="text-danger"> {{ $product->brand_name }}</span>?</p>
					</div>
					<div class="modal-footer">
						<a href="javascript:void(0)" class="btn btn-success si_accept_confirm">Yes</a>
						<button type="button" class="btn btn-danger si_accept_cancel" data-bs-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
         @endforeach
		<!-- /Modele -->

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
		
    <script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="d2241dbc8fbf4e82f8c24724-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"="" crossorigin="anonymous"></script>

</body></html>