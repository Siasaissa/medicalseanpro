<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li class="menu-title">
					<span>Main</span>
				</li>
				<li class="<?php echo e(Route::is('admin.dashboard') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fe fe-home"></i> <span>Dashboard</span></a>
				</li>
				<li class="<?php echo e(Route::is('admin.appointment') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('admin.appointment')); ?>"><i class="fe fe-layout"></i>
						<span>Appointments</span>
						<?php if(($adminPendingCounts['bookings'] ?? 0) > 0): ?>
							<small class="badge bg-warning ms-2"><?php echo e($adminPendingCounts['bookings']); ?></small>
						<?php endif; ?>
					</a>
				</li>

				<li class="<?php echo e(Route::is('admin.doctorList') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('admin.doctorList')); ?>"><i class="fe fe-user-plus"></i> <span>Doctors</span>
						<?php if(($adminPendingCounts['doctors'] ?? 0) > 0): ?>
							<small class="badge bg-danger ms-2"><?php echo e($adminPendingCounts['doctors']); ?></small>
						<?php endif; ?>
					</a>
				</li>
				<li class="<?php echo e(Route::is('admin.patientList') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('admin.patientList')); ?>"><i class="fe fe-user"></i> <span>Patients</span></a>
				</li>

				<li class="<?php echo e(Route::is('admin.Transaction') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('admin.Transaction')); ?>"><i class="fe fe-activity"></i>
						<span>Transactions</span>
						<?php if(($adminPendingCounts['orders'] ?? 0) > 0): ?>
							<small class="badge bg-warning ms-2"><?php echo e($adminPendingCounts['orders']); ?></small>
						<?php endif; ?>
					</a>
				</li>

				<li class="submenu">
					<a href="#">
						<i class="fe fe-shopping-bag"></i>
						<span>Pharmacy</span>
						<span class="menu-arrow"></span>
					</a>
					<ul style="display: none;">
						<li class="<?php echo e(Route::is('admin.pharmacy') ? 'active' : ''); ?>">
							<a href="<?php echo e(route('admin.pharmacy')); ?>">Products</a>
						</li>
						<li class="<?php echo e(Route::is('admin.addproduct') ? 'active' : ''); ?>">
							<a href="<?php echo e(route('admin.addproduct')); ?>">Add Products</a>
						</li>
					</ul>
				</li>

			</ul>
		</div>
	</div>
</div>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/layouts/adminSidebar.blade.php ENDPATH**/ ?>