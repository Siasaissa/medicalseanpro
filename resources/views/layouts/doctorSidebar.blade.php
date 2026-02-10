<div class="profile-sidebar doctor-sidebar profile-sidebar-new">
	<div class="widget-profile pro-widget-content">
		<div class="profile-info-widget">
			<a href="{{ route('doctor-dashboard') }}" class="booking-doc-img">
				@if(Auth::user()->profile && Auth::user()->profile->dp)
					<img src="{{ asset(Auth::user()->profile->dp) }}" alt="Profile Photo" class="img-fluid rounded-circle">
				@else
					<img src="{{ asset('images/profile-06.jpg') }}" alt="Default Avatar" class="img-fluid rounded-circle">
				@endif
			</a>

			<div class="profile-det-info">
				<h3><a href="doctor-profile.html">Dr. {{ Auth::user()->name }}</a></h3>
				<div class="patient-details">
					<h5 class="mb-0">{{ $doctor_service ?? 'No service Data' }}</h5>
				</div>
				<span class="badge doctor-role-badge"><i
						class="fa-solid fa-circle"></i>{{$doctor_speciality ?? 'No speciality Data'}}</span>
			</div>
		</div>
	</div>
	<div class="doctor-available-head">
		<div class="input-block input-block-new">
			<label class="form-label">Availability <span class="text-danger">*</span></label>
			<select class="select form-control" id="availabilitySelect">
				<option value="available" {{ ($availability == 'available') ? 'selected' : '' }}>I am Available Now</option>
<option value="not_available" {{ ($availability == 'not_available') ? 'selected' : '' }}>Not Available</option>

			</select>
		</div>
	</div>
	<div class="dashboard-widget">
		<nav class="dashboard-menu">
			<ul>
				<li class="{{ Route::is('doctor-dashboard') ? 'active' : '' }}">
					<a href="{{ route('doctor-dashboard') }}">
						<i class="isax isax-category-2"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li class="{{ Route::is('doctor.appointment') ? 'active' : ''}}">
					<a href="{{ route('doctor.appointment') }}">
						<i class="isax isax-calendar-1"></i>
						<span>Appointments</span>
					</a>
				</li>
				<li class="{{ Route::is('doctor.mypatients') ? 'active' : '' }}">
					<a href="{{ route('doctor.mypatients') }}">
						<i class="fa-solid fa-user-injured"></i>
						<span>My Patients</span>
					</a>
				</li>
				<li class="{{ Route::is('doctor.specialities') ? 'active' : '' }}">
					<a href="{{ route('doctor.specialities') }}">
						<i class="isax isax-clock"></i>
						<span>Specialties & Services</span>
					</a>
				</li>

				<li>
					<a href="{{ route('doctor.chat') }}">
						<i class="isax isax-messages-1"></i>
						<span>Message</span>
						<small class="unread-msg">7</small>
					</a>
				</li>
				<li class="{{ Route::is('doctor.profilesettings') ? 'active' : '' }}">
					<a href="{{ route('doctor.profilesettings') }}">
						<i class="isax isax-setting-2"></i>
						<span>Profile Settings</span>
					</a>
				</li>
				<li class="{{ Route::is('doctor.changePassword') ? 'active' : '' }}">
					<a href="{{ route('doctor.changePassword') }}">
						<i class="isax isax-key"></i>
						<span>Change Password</span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
<script>
document.getElementById('availabilitySelect').addEventListener('change', function () {
    let availability = this.value;

    fetch("{{ route('doctor.updateAvailability') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ availability })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // ✅ Show success message (non-blocking)
            const msg = document.createElement('div');
            msg.innerText = `Availability updated to: ${data.availability.replace('_', ' ')}`;
            msg.style.position = 'fixed';
            msg.style.bottom = '20px';
            msg.style.right = '20px';
            msg.style.background = '#28a745';
            msg.style.color = 'white';
            msg.style.padding = '10px 15px';
            msg.style.borderRadius = '8px';
            msg.style.zIndex = '9999';
            msg.style.transition = 'opacity 0.5s ease';
            document.body.appendChild(msg);

            setTimeout(() => msg.style.opacity = '0', 2000);
            setTimeout(() => msg.remove(), 2500);
        } else {
            alert('Something went wrong.');
        }
    })
    .catch(err => console.error(err));
});
</script>
