<header class="header header-custom header-fixed inner-header relative">
				<div class="container">
					<nav class="navbar navbar-expand-lg header-nav">
						<div class="navbar-header">
							<a id="mobile_btn" href="javascript:void(0);">
								<span class="bar-icon">
									<span></span>
									<span></span>
									<span></span>
								</span>
							</a>
							<a href="<?php echo e(route('welcome')); ?>" class="navbar-brand logo">
								<img src="<?php echo e(asset('images/logo.svg')); ?>" class="img-fluid" alt="Logo">
							</a>
						</div>
						<div class="header-menu">
							<div class="main-menu-wrapper">
								<div class="menu-header">
									<a href="<?php echo e(route('welcome')); ?>" class="menu-logo">
										<img src="<?php echo e(asset('images/logo.svg')); ?>" class="img-fluid" alt="Logo">
									</a>
									<a id="menu_close" class="menu-close" href="javascript:void(0);">
										<i class="fas fa-times"></i>
									</a>
								</div>
								<ul class="main-nav">
									<li class="menu <?php echo e(Route::is('patient.doctor-grid') ? 'active' : ''); ?>">
										<a href="<?php echo e(route('patient.doctor-grid')); ?>">Doctors</a>
									</li>
									<li class="menu <?php echo e(Route::is('pharmacy.product') ? 'active' : ''); ?>">
										<a href="<?php echo e(route('pharmacy.product')); ?>">Pharmacy</i></a>
									</li>
									<li class="menu">
										<a href="#">About Us</a>
									</li>
									<li class="menu">
										<a href="#">Blog Grid</i></a>
									</li>
									<li class="menu">
										<a href="#">
										<form method="POST" action="<?php echo e(route('logout')); ?>">
											<?php echo csrf_field(); ?>
											<button type="submit" style="background:none;border:none;padding:0;color:inherit;cursor:pointer;">
												Logout
											</button>
										</form>
										</a>
									</li>

									<li class="menu">
										<a href="<?php echo e(route('dashboard')); ?>">Home</i></a>
									</li>
									
								</ul>
							</div>
							<ul class="nav header-navbar-rht">
								<li class="searchbar">
									<a href="javascript:void(0);"><i class="feather-search"></i></a>
									<div class="togglesearch">
										<form action="search.html">
											<div class="input-group">
												<input type="text" class="form-control">
												<button type="submit" class="btn">Search</button>
											</div>
										</form>
									</div>
								</li>
								<li>
									<a href="<?php echo e(route('logout')); ?>" 
										class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill"
										onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										<i class="isax isax-lock-1 me-1"></i> Logout
                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>

								</li>
								<li>
									<a href="<?php echo e(route('dashboard')); ?>" class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
										<i class="isax isax-user-tick me-1"></i>Home
									</a>
								</li>
							</ul>
						</div>
					</nav>
				</div>
				<?php echo $__env->make('layouts.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				<?php if(session('success')): ?>
				<div class="toast align-items-center text-white bg-success border-0 show">
					<div class="d-flex">
						<div class="toast-body">
							<?php echo e(session('success')); ?>

						</div>
						<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
					</div>
				</div>
				<?php endif; ?>

				<?php if(session('error')): ?>
				<div class="toast align-items-center text-white bg-danger border-0 show">
					<div class="d-flex">
						<div class="toast-body">
							<?php echo e(session('error')); ?>

						</div>
						<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
					</div>
				</div>
				<?php endif; ?>
			</header><?php /**PATH /Users/dope/Downloads/public_htm/resources/views/layouts/header.blade.php ENDPATH**/ ?>