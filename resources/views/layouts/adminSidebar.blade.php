<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li class="menu-title">
					<span>Main</span>
				</li>
				<li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
					<a href="{{ route('admin.dashboard') }}"><i class="fe fe-home"></i> <span>Dashboard</span></a>
				</li>
				<li class="{{ Route::is('admin.appointment') ? 'active' : '' }}">
					<a href="{{ route('admin.appointment') }}"><i class="fe fe-layout"></i>
						<span>Appointments</span>
						@if(($adminPendingCounts['bookings'] ?? 0) > 0)
							<small class="badge bg-warning ms-2">{{ $adminPendingCounts['bookings'] }}</small>
						@endif
					</a>
				</li>

				<li class="{{ Route::is('admin.doctorList') ? 'active' : '' }}">
					<a href="{{ route('admin.doctorList') }}"><i class="fe fe-user-plus"></i> <span>Doctors</span>
						@if(($adminPendingCounts['doctors'] ?? 0) > 0)
							<small class="badge bg-danger ms-2">{{ $adminPendingCounts['doctors'] }}</small>
						@endif
					</a>
				</li>
				<li class="{{ Route::is('admin.patientList') ? 'active' : '' }}">
					<a href="{{ route('admin.patientList') }}"><i class="fe fe-user"></i> <span>Patients</span></a>
				</li>

				<li class="{{ Route::is('admin.Transaction') ? 'active' : '' }}">
					<a href="{{ route('admin.Transaction') }}"><i class="fe fe-activity"></i>
						<span>Transactions</span>
						@if(($adminPendingCounts['orders'] ?? 0) > 0)
							<small class="badge bg-warning ms-2">{{ $adminPendingCounts['orders'] }}</small>
						@endif
					</a>
				</li>

				<li class="submenu">
					<a href="#">
						<i class="fe fe-shopping-bag"></i>
						<span>Pharmacy</span>
						<span class="menu-arrow"></span>
					</a>
					<ul style="display: none;">
						<li class="{{ Route::is('admin.pharmacy') ? 'active' : '' }}">
							<a href="{{ route('admin.pharmacy') }}">Products</a>
						</li>
						<li class="{{ Route::is('admin.addproduct') ? 'active' : '' }}">
							<a href="{{ route('admin.addproduct') }}">Add Products</a>
						</li>
					</ul>
				</li>

			</ul>
		</div>
	</div>
</div>
