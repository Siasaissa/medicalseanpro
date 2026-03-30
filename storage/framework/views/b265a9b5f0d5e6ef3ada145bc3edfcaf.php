<?php echo $__env->make('layouts.adminHead', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Header -->
                        <?php echo $__env->make('layouts.adminHeader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <?php echo $__env->make('layouts.adminSidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
								<a href="<?php echo e(route('admin.addproduct')); ?>" class="btn btn-primary float-end mt-2">Add New</a>
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
                                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

												<tr>
													<td><?php echo e($loop->iteration); ?></td>
													<td>
														<h2 class="table-avatar">
															<span class="avatar avatar-sm me-2"><img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="Product image"></span>
															<?php echo e($product->brand_name); ?>

														</h2>
													</td>
													<td><?php echo e($product->category); ?></td>
													<td><?php echo e($product->price); ?></td>
													<td><?php echo e($product->quantity); ?></td>
													<td><?php echo e($product->discount); ?>%</td>
													<td><span class="btn btn-sm bg-success-light"><?php echo e($product->description); ?></span></td>
													<td>
														<div class="actions">
															<a class="btn btn-sm bg-success-light" href="#">
																<i class="fe fe-pencil"></i> Edit
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-danger-light" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal<?php echo e($product->id); ?>">
																<i class="fe fe-trash"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
         <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

		<div class="modal fade" id="deleteConfirmModal<?php echo e($product->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="acc_title">Delete</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p id="acc_msg">Are you sure you want to delete <span class="text-danger"> <?php echo e($product->brand_name); ?></span>?</p>
					</div>
					<div class="modal-footer">
						<a href="javascript:void(0)" class="btn btn-success si_accept_confirm">Yes</a>
						<button type="button" class="btn btn-danger si_accept_cancel" data-bs-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<!-- /Modele -->

		<!-- jQuery -->
        <script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>
		
		<!-- Slimscroll JS -->
        <script src="<?php echo e(asset('js/jquery.slimscroll.min.js')); ?>" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>
		
		<!-- Datatables JS -->
		<script src="<?php echo e(asset('js/jquery.dataTables.min.js')); ?>" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>
		<script src="<?php echo e(asset('js/datatables.min.js')); ?>" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="<?php echo e(asset('js/script.js')); ?>" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>
		
    <script src="<?php echo e(asset('js/rocket-loader.min.js')); ?>" data-cf-settings="d2241dbc8fbf4e82f8c24724-|49" defer=""></script><script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" data-cf-beacon="{" version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"="" crossorigin="anonymous"></script>

</body></html><?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/pharmacy.blade.php ENDPATH**/ ?>