@include('layouts.adminHead')

@php
    $statusColors = [
        'PENDING' => 'warning',
        'PROCESSING' => 'info',
        'SUCCESS' => 'success',
        'FAILED' => 'danger',
        'PAID' => 'primary',
        'ACTIVE' => 'secondary',
        'COMPLETED' => 'success',
        'CANCELLED' => 'dark',
    ];
@endphp

<body>
    <div class="main-wrapper">
        @include('layouts.adminHeader')
        @include('layouts.adminSidebar')

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Appointments</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                                <li class="breadcrumb-item active">Appointments</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.appointment') }}" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Booking ID, name, email">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($bookingStatusOptions as $status)
                                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-control">
                                    <option value="">All</option>
                                    <option value="video" @selected(($filters['type'] ?? '') === 'video')>Video</option>
                                    <option value="voice" @selected(($filters['type'] ?? '') === 'voice')>Voice</option>
                                    <option value="home" @selected(($filters['type'] ?? '') === 'home')>Home</option>
                                    <option value="chat" @selected(($filters['type'] ?? '') === 'chat')>Chat</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">From</label>
                                <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">To</label>
                                <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="form-control">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Appointment List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Booking</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Type</th>
                                        <th>Schedule</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($appointment as $item)
                                        <tr>
                                            <td>#APT{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td>
                                                <strong>{{ $item->patient->name ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $item->patient->email ?? 'No email' }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $item->doctor->name ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $item->doctor->email ?? 'No email' }}</small>
                                            </td>
                                            <td>{{ ucfirst($item->appointment_type ?? 'N/A') }}</td>
                                            <td>{{ $item->appointment_datetime ? \Carbon\Carbon::parse($item->appointment_datetime)->format('d M Y, h:i A') : 'N/A' }}</td>
                                            <td>TSh {{ number_format((float) ($item->total ?? 0), 0) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $statusColors[$item->status ?? ''] ?? 'secondary' }}-light">
                                                    {{ $item->status ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.bookings.status', $item) }}" method="POST" class="d-flex gap-2">
                                                    @csrf
                                                    <select name="status" class="form-control form-control-sm">
                                                        @foreach ($bookingStatusOptions as $status)
                                                            <option value="{{ $status }}" @selected(($item->status ?? '') === $status)>{{ $status }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button class="btn btn-sm btn-primary">Save</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">No appointments matched your filters.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $appointment->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admincss/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admincss/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admincss/js/feather.min.js') }}"></script>
    <script src="{{ asset('admincss/js/script.js') }}"></script>
</body>
</html>
