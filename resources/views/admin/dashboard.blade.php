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
                            <h3 class="page-title">Admin Dashboard</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row">
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-primary border-primary">
                                        <i class="fe fe-user-plus"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ number_format($doctor ?? 0) }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Doctors</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary w-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-success">
                                        <i class="fe fe-users"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ number_format($patient ?? 0) }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Patients</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success w-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-warning border-warning">
                                        <i class="fe fe-calendar"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ number_format($booking ?? 0) }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Bookings</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning w-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-danger border-danger">
                                        <i class="fe fe-credit-card"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>TSh {{ number_format((float) ($revenue ?? 0), 0) }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Revenue</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger w-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-8 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Recent Bookings</h5>
                                    <a href="{{ route('admin.appointment') }}" class="btn btn-sm btn-primary">View all</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Patient</th>
                                                <th>Doctor</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($recentBookings ?? [] as $item)
                                                <tr>
                                                    <td>#{{ $item->id }}</td>
                                                    <td>{{ $item->patient->name ?? 'N/A' }}</td>
                                                    <td>{{ $item->doctor->name ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge bg-info-light">{{ $item->status ?? 'N/A' }}</span>
                                                    </td>
                                                    <td>{{ optional($item->created_at)->format('d M Y, h:i A') ?? 'N/A' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">No recent bookings found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Recent Transactions</h5>
                                    <a href="{{ route('admin.Transaction') }}" class="btn btn-sm btn-outline-primary">Open ledger</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    @forelse ($recentTransactions ?? [] as $transaction)
                                        <div class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">Order #{{ $transaction->id }}</h6>
                                                    <p class="mb-1 text-muted small">
                                                        {{ $transaction->user->name ?? $transaction->name ?? 'Guest customer' }}
                                                    </p>
                                                    <span class="badge bg-secondary-light">{{ $transaction->status ?? 'pending' }}</span>
                                                </div>
                                                <strong>TSh {{ number_format((float) ($transaction->total ?? 0), 0) }}</strong>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-4">No recent transactions found.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <a href="{{ route('admin.appointment') }}" class="btn btn-outline-primary w-100">Manage Appointments</a>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <a href="{{ route('admin.doctorList') }}" class="btn btn-outline-primary w-100">Review Doctors</a>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <a href="{{ route('admin.patientList') }}" class="btn btn-outline-primary w-100">Browse Patients</a>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <a href="{{ route('admin.pharmacy') }}" class="btn btn-outline-primary w-100">Open Pharmacy Admin</a>
                                    </div>
                                </div>
                            </div>
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
