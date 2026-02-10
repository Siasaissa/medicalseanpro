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
						<span>Appointments</span></a>
				</li>

				<li class="{{ Route::is('admin.doctorList') ? 'active' : '' }}">
					<a href="{{ route('admin.doctorList') }}"><i class="fe fe-user-plus"></i> <span>Doctors</span></a>
				</li>
				<li class="{{ Route::is('admin.patientList') ? 'active' : '' }}">
					<a href="{{ route('admin.patientList') }}"><i class="fe fe-user"></i> <span>Patients</span></a>
				</li>

				<li class="{{ Route::is('admin.Transaction') ? 'active' : '' }}">
					<a href="{{ route('admin.Transaction') }}"><i class="fe fe-activity"></i>
						<span>Transactions</span></a>
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


				<li>
					<a href="settings.html"><i class="fe fe-vector"></i> <span>Settings</span></a>
				</li>
				<li class="submenu">
					<a href="#"><i class="fe fe-document"></i> <span> Reports</span> <span
							class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="invoice-report.html">Invoice Reports</a></li>
					</ul>
				</li>
				<li class="menu-title">
					<span>Pages</span>
				</li>
				<li>
					<a href="profile.html"><i class="fe fe-user-plus"></i> <span>Profile</span></a>
				</li>

				<li>
					<a href="blank-page.html"><i class="fe fe-file"></i> <span>Blank Page</span></a>
				</li>

				<li>
					<a href="components.html"><i class="fe fe-vector"></i> <span>Components</span></a>
				</li>
			</ul>
		</div>
	</div>
</div>