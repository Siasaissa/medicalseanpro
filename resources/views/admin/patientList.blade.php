@include('layouts.adminHead')

<body>
    <div class="main-wrapper">
        @include('layouts.adminHeader')
        @include('layouts.adminSidebar')

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Patients</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                                <li class="breadcrumb-item active">Patient Directory</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.patientList') }}" class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Search</label>
                                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Name, email, phone, address">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($statusOptions as $status)
                                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Go</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Patient Accounts</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Bookings</th>
                                        <th>Status</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($patients as $patient)
                                        <tr>
                                            <td>
                                                <strong>{{ $patient->name }}</strong><br>
                                                <small class="text-muted">{{ $patient->email }}</small>
                                            </td>
                                            <td>{{ $patient->profile?->phone_numbers ?? 'Not set' }}</td>
                                            <td>{{ $patient->profile?->address ?? 'Not set' }}</td>
                                            <td>{{ $patient->patientBookings->count() }}</td>
                                            <td>
                                                <span class="badge bg-{{ ($patient->profile?->status ?? 'inactive') === 'active' ? 'success' : (($patient->profile?->status ?? 'inactive') === 'suspended' ? 'danger' : 'warning') }}-light">
                                                    {{ ucfirst($patient->profile?->status ?? 'inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.users.status', $patient) }}" method="POST" class="d-flex gap-2">
                                                    @csrf
                                                    <select name="status" class="form-control form-control-sm">
                                                        @foreach ($statusOptions as $status)
                                                            <option value="{{ $status }}" @selected(($patient->profile?->status ?? 'inactive') === $status)>{{ ucfirst($status) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button class="btn btn-sm btn-primary">Save</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No patients found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $patients->links() }}
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
