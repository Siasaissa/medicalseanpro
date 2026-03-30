@include('layouts.adminHead')
<body>
<div class="main-wrapper">
    @include('layouts.adminHeader')
    @include('layouts.adminSidebar')

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Appointments Control Panel</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Appointments</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.appointment') }}" class="row g-2 mb-3">
                        <div class="col-md-4">
                            <input type="text" name="q" class="form-control" placeholder="Search booking ID / doctor / patient" value="{{ $filters['q'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                @foreach($bookingStatusOptions as $statusOption)
                                    <option value="{{ $statusOption }}" @selected(strtoupper($filters['status'] ?? '') === $statusOption)>{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="type" class="form-control">
                                <option value="">All Types</option>
                                @foreach(['video','voice','chat','home'] as $typeOption)
                                    <option value="{{ $typeOption }}" @selected(($filters['type'] ?? '') === $typeOption)>{{ ucfirst($typeOption) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="from" class="form-control" value="{{ $filters['from'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="to" class="form-control" value="{{ $filters['to'] ?? '' }}">
                        </div>
                        <div class="col-12 d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.appointment') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Booking</th>
                                    <th>Doctor</th>
                                    <th>Patient</th>
                                    <th>Type</th>
                                    <th>Appointment Time</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointment as $appo)
                                    @php
                                        $doctorAvatar = $appo->doctor?->profile?->dp ? asset($appo->doctor->profile->dp) : asset('images/default.jpeg');
                                        $patientAvatar = $appo->patient?->profile?->dp ? asset($appo->patient->profile->dp) : asset('images/default.jpeg');
                                        $status = strtoupper((string) $appo->status);
                                    @endphp
                                    <tr>
                                        <td>#APT{{ str_pad($appo->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="{{ $doctorAvatar }}" alt="Doctor"></a>
                                                <a href="javascript:void(0);">Dr. {{ $appo->doctor?->name ?? 'N/A' }}</a>
                                            </h2>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="{{ $patientAvatar }}" alt="Patient"></a>
                                                <a href="javascript:void(0);">{{ $appo->patient?->name ?? 'N/A' }}</a>
                                            </h2>
                                        </td>
                                        <td><span class="badge bg-info">{{ strtoupper($appo->appointment_type) }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($appo->appointment_datetime)->format('d M Y h:i A') }}</td>
                                        <td>Tsh {{ number_format((float) $appo->total, 2) }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ in_array($status, ['SUCCESS','PAID','COMPLETED']) ? 'bg-success' : (in_array($status, ['PENDING','PROCESSING','ACTIVE']) ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.bookings.status', $appo) }}" class="d-flex gap-2 align-items-center">
                                                @csrf
                                                <select name="status" class="form-select form-select-sm" style="min-width: 150px;">
                                                    @foreach($bookingStatusOptions as $statusOption)
                                                        <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ $statusOption }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No appointments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $appointment->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
