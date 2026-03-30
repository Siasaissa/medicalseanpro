@include('layouts.adminHead')
<body>
<div class="main-wrapper">
    @include('layouts.adminHeader')
    @include('layouts.adminSidebar')

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="page-title">Admin Control Center</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-primary border-primary"><i class="fe fe-users"></i></span>
                                <div class="dash-count"><h3>{{ $doctor }}</h3></div>
                            </div>
                            <div class="dash-widget-info"><h6 class="text-muted">Doctors</h6></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-success border-success"><i class="fe fe-user"></i></span>
                                <div class="dash-count"><h3>{{ $patient }}</h3></div>
                            </div>
                            <div class="dash-widget-info"><h6 class="text-muted">Patients</h6></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-danger border-danger"><i class="fe fe-calendar"></i></span>
                                <div class="dash-count"><h3>{{ $booking }}</h3></div>
                            </div>
                            <div class="dash-widget-info"><h6 class="text-muted">Bookings</h6></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-warning border-warning"><i class="fe fe-dollar-sign"></i></span>
                                <div class="dash-count"><h6>Tsh {{ number_format((float) $revenue, 2) }}</h6></div>
                            </div>
                            <div class="dash-widget-info"><h6 class="text-muted">Total Revenue</h6></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Quick Controls</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.doctorList') }}" class="btn btn-outline-primary">Manage Doctors</a>
                                <a href="{{ route('admin.patientList') }}" class="btn btn-outline-primary">Manage Patients</a>
                                <a href="{{ route('admin.appointment') }}" class="btn btn-outline-primary">Manage Bookings</a>
                                <a href="{{ route('admin.Transaction') }}" class="btn btn-outline-primary">Manage Transactions</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0">Recent Bookings</h5></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Doctor</th>
                                            <th>Patient</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentBookings as $b)
                                            @php $status = strtoupper((string) $b->status); @endphp
                                            <tr>
                                                <td>#APT{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $b->doctor?->name ?? 'N/A' }}</td>
                                                <td>{{ $b->patient?->name ?? 'N/A' }}</td>
                                                <td>{{ $status }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-muted text-center">No bookings yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0">Recent Transactions</h5></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentTransactions as $t)
                                            <tr>
                                                <td>#ORD{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $t->user?->name ?? 'Guest' }}</td>
                                                <td>Tsh {{ number_format((float) $t->total, 2) }}</td>
                                                <td>{{ strtoupper((string) $t->status) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-muted text-center">No transactions yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
<script src="{{ asset('admincss/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('admincss/js/script.js') }}"></script>
</body>
</html>
