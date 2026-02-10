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
								<li class="breadcrumb-item" aria-current="page">Pharmacy</li>
								<li class="breadcrumb-item active">Checkout</li>
							</ol>
							<h2 class="breadcrumb-title">Checkout</h2>
						</nav>
					</div>
				</div>
			</div>
			<div class="breadcrumb-bg">
				<img src="<?php echo e(asset('images/breadcrumb-bg-01.png')); ?>" alt="img" class="breadcrumb-bg-01">
				<img src="<?php echo e(asset('images/breadcrumb-bg-02.png')); ?>" alt="img" class="breadcrumb-bg-02">
				<img src="<?php echo e(asset('images/breadcrumb-icon.webp')); ?>" alt="img" class="breadcrumb-bg-03">
				<img src="<?php echo e(asset('images/breadcrumb-icon.webp')); ?>" alt="img" class="breadcrumb-bg-04">
			</div>
		</div>
		<!-- /Breadcrumb -->

		<!-- Page Content -->
		<div class="content">
			<div class="container">

				<div class="row">
					<div class="col-md-6 col-lg-7">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Billing details</h3>
							</div>
							<div class="card-body">

								<!-- Checkout Form -->
								<form action="<?php echo e(route('pharmacy.successfully')); ?>" method="POST">
									<?php echo csrf_field(); ?>

									<input type="hidden" name="total" value="<?php echo e($total + 5000); ?>">

									<?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<input type="hidden" name="items[<?php echo e($item['id']); ?>][name]"
											value="<?php echo e($item['name']); ?>">
										<input type="hidden" name="items[<?php echo e($item['id']); ?>][price]"
											value="<?php echo e($item['price']); ?>">
										<input type="hidden" name="items[<?php echo e($item['id']); ?>][quantity]"
											value="<?php echo e($item['quantity'] ?? 1); ?>">
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

									<div class="info-widget">
										<h4 class="card-title">Shipping Details</h4>
										<div class="terms-accept">
											<div class="custom-checkbox">
												<input type="checkbox" id="terms_accept">
												<label for="terms_accept">Ship to a different address?</label>
											</div>
										</div>

										<div class="mb-3 card-label">
											<label class="ps-0 ms-0 mb-2">Your shipping address</label>
											<textarea rows="5" class="form-control" name="shipping"
												placeholder="Paste your address from Google Maps"></textarea>
										</div>
									</div>
									<!-- /Shipping Details -->

									<div class="payment-widget">
										<h4 class="card-title">Payment Method</h4>

										<!-- Halopesa -->
										<div class="payment-list">
											<label class="payment-radio credit-card-option">
												<input type="radio" name="payment_method" value="halopesa" checked>
												<span class="checkmark"></span>
												Halopesa
											</label>
											<div class="row">
												<div class="col-lg-6 col-md-12">
													<div class="mb-3 card-label">
														<label for="halopesa_phone">Phone Number</label>
														<input class="form-control" id="halopesa_phone"
															name="halopesa_phone" type="number">
													</div>
												</div>
											</div>
										</div>
										<!-- /Halopesa -->

										<!-- Tigo Pesa -->
										<div class="payment-list">
											<label class="payment-radio paypal-option">
												<input type="radio" name="payment_method" value="tigopesa">
												<span class="checkmark"></span>
												Tigo Pesa
											</label>
											<div class="row">
												<div class="col-lg-6 col-md-12">
													<div class="mb-3 card-label">
														<label for="tigopesa_phone">Phone Number</label>
														<input class="form-control" id="tigopesa_phone"
															name="tigopesa_phone" type="number">
													</div>
												</div>
											</div>
										</div>
										<!-- /Tigo Pesa -->

										<div class="terms-accept">
											<div class="custom-checkbox">
												<input type="checkbox" id="terms_accept1" required>
												<label for="terms_accept1">I have read and accept
													<a href="terms-condition.html">Terms & Conditions</a>
												</label>
											</div>
										</div>

										<div class="submit-section mt-4">
											<button type="submit" class="btn btn-primary submit-btn">Confirm and
												Pay</button>
										</div>
									</div>
								</form>

								<!-- /Checkout Form -->

							</div>
						</div>

					</div>

					<div class="col-md-6 col-lg-5 theiaStickySidebar">

						<!-- Booking Summary -->
						<div class="card booking-card">
							<div class="card-header">
								<h3 class="card-title">Your Order</h3>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-center mb-0">
										<tbody>
											<tr>
												<th>Product</th>
												<th class="text-end">Total</th>
											</tr>
										</tbody>
										<tbody>

										</tbody>
									</table>
								</div>
								<div class="booking-summary pt-5">
									<div class="booking-item-wrap">
										<ul class="booking-date d-block pb-0">
											<?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<li><?php echo e($item['name']); ?> <span> Tsh. <?php echo e($item['price']); ?></span></li>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

											<li>Shipping <span>Tsh 5000.00</span></li>

										</ul>
										<ul class="booking-fee">
											<li>Tax <span>Tsh. 0.00</span></li>
										</ul>
										<div class="booking-total">
											<ul class="booking-total-list">
												<li>
													<span>Total</span>
													<span class="total-cost">Tsh.
														<?php echo e(number_format($total + 5000)); ?></span>
												</li>
												<li>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Booking Summary -->

					</div>
				</div>

			</div>

		</div>
		<!-- /Page Content -->

		<!-- Footer Section -->
		<?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<!-- /Footer Section -->

	</div>
	<script>
$(document).ready(function () {
    // Hide both phone inputs initially
    $('#halopesa_phone').closest('.row').hide();
    $('#tigopesa_phone').closest('.row').hide();

    // Show the one that matches the selected payment method
    function togglePaymentFields() {
        const method = $('input[name="payment_method"]:checked').val();
        if (method === 'halopesa') {
            $('#halopesa_phone').closest('.row').show();
            $('#tigopesa_phone').closest('.row').hide();
        } else if (method === 'tigopesa') {
            $('#tigopesa_phone').closest('.row').show();
            $('#halopesa_phone').closest('.row').hide();
        }
    }

    togglePaymentFields(); // initialize

    $('input[name="payment_method"]').change(function () {
        togglePaymentFields();
    });

    // Prevent submitting both phone numbers
    $('form').on('submit', function () {
        const method = $('input[name="payment_method"]:checked').val();
        if (method === 'halopesa') {
            $('#tigopesa_phone').removeAttr('name');
        } else if (method === 'tigopesa') {
            $('#halopesa_phone').removeAttr('name');
        }
    });
});
</script>

	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>" type="fd3b17be20ca06d8e1a6b747-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>" type="fd3b17be20ca06d8e1a6b747-text/javascript"></script>

	<!-- Sticky Sidebar JS -->
	<script src="<?php echo e(asset('js/ResizeSensor.js')); ?>" type="fd3b17be20ca06d8e1a6b747-text/javascript"></script>
	<script src="<?php echo e(asset('js/theia-sticky-sidebar.js')); ?>" type="fd3b17be20ca06d8e1a6b747-text/javascript"></script>

	<!-- Custom JS -->
	<script src="<?php echo e(asset('js/script.js')); ?>" type="fd3b17be20ca06d8e1a6b747-text/javascript"></script>

	<script src="<?php echo e(asset('js/rocket-loader.min.js')); ?>" data-cf-settings="fd3b17be20ca06d8e1a6b747-|49"
		defer=""></script>
	<script defer=""
		src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
		data-cf-beacon="{"
		version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"=""
		crossorigin="anonymous"></script>

</body>

</html><?php /**PATH /Users/dope/Documents/sean/sean/resources/views/pharmacy/checkout.blade.php ENDPATH**/ ?>