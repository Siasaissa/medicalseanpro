<div class="profile-sidebar doctor-sidebar profile-sidebar-new">
	<div class="widget-profile pro-widget-content">
		<div class="profile-info-widget">
			<a href="<?php echo e(route('doctor-dashboard')); ?>" class="booking-doc-img">
				<?php if(Auth::user()->profile && Auth::user()->profile->dp): ?>
					<img src="<?php echo e(asset(Auth::user()->profile->dp)); ?>" alt="Profile Photo" class="img-fluid rounded-circle">
				<?php else: ?>
					<img src="<?php echo e(asset('images/profile-06.jpg')); ?>" alt="Default Avatar" class="img-fluid rounded-circle">
				<?php endif; ?>
			</a>

			<div class="profile-det-info">
				<h3><a href="doctor-profile.html">Dr. <?php echo e(Auth::user()->name); ?></a></h3>
				<div class="patient-details">
					<h5 class="mb-0"><?php echo e($doctor_service ?? 'No service Data'); ?></h5>
				</div>
				<span class="badge doctor-role-badge"><i
						class="fa-solid fa-circle"></i><?php echo e($doctor_speciality ?? 'No speciality Data'); ?></span>
			</div>
		</div>
	</div>

	<div class="dashboard-widget">
		<nav class="dashboard-menu">
			<ul>
				<li class="<?php echo e(Route::is('doctor-dashboard') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('doctor-dashboard')); ?>">
						<i class="isax isax-category-2"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li class="<?php echo e(Route::is('doctor.appointment') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('doctor.appointment')); ?>">
						<i class="isax isax-calendar-1"></i>
						<span>Appointments</span>
					</a>
				</li>
				<li class="<?php echo e(Route::is('doctor.mypatients') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('doctor.mypatients')); ?>">
						<i class="fa-solid fa-user-injured"></i>
						<span>My Patients</span>
					</a>
				</li>
				<li class="<?php echo e(Route::is('doctor.specialities') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('doctor.specialities')); ?>">
						<i class="isax isax-clock"></i>
						<span>Specialties & Services</span>
					</a>
				</li>

				<li class="<?php echo e(Route::is('doctor.chat') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('doctor.chat')); ?>">
						<i class="isax isax-messages-1"></i>
						<span>Message</span>
						<small class="unread-msg d-none js-chat-unread-badge" data-chat-unread-badge>0</small>
					</a>
				</li>
				<li class="<?php echo e(Route::is('doctor.profilesettings') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('doctor.profilesettings')); ?>">
						<i class="isax isax-setting-2"></i>
						<span>Profile Settings</span>
					</a>
				</li>
				<li class="<?php echo e(Route::is('doctor.changePassword') ? 'active' : ''); ?>">
					<a href="<?php echo e(route('doctor.changePassword')); ?>">
						<i class="isax isax-key"></i>
						<span>Change Password</span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/layouts/doctorSidebar.blade.php ENDPATH**/ ?>