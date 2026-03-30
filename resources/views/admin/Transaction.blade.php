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
                        <h3 class="page-title">Transactions Hub</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Transactions</li>
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

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted mb-1">Booking Revenue</h6>
                            <h4 class="mb-0">Tsh {{ number_format($totals['booking'] ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted mb-1">Pharmacy Revenue</h6>
                            <h4 class="mb-0">Tsh {{ number_format($totals['pharmacy'] ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted mb-1">Combined Revenue</h6>
                            <h4 class="mb-0">Tsh {{ number_format(($totals['booking'] ?? 0) + ($totals['pharmacy'] ?? 0), 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.Transaction') }}" class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="q" class="form-control" value="{{ $filters['q'] ?? '' }}" placeholder="Search by ID, name, email, phone">
                        </div>
                        <div class="col-md-2">
                            <select name="source" class="form-control">
                                <option value="all" @selected(($filters['source'] ?? 'all') === 'all')>All Sources</option>
                                <option value="booking" @selected(($filters['source'] ?? '') === 'booking')>Booking Only</option>
                                <option value="pharmacy" @selected(($filters['source'] ?? '') === 'pharmacy')>Pharmacy Only</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="booking_status" class="form-control">
                                <option value="">Booking Status</option>
                                @foreach($bookingStatusOptions as $statusOption)
                                    <option value="{{ $statusOption }}" @selected(strtoupper($filters['booking_status'] ?? '') === $statusOption)>{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="pharmacy_status" class="form-control">
                                <option value="">Pharmacy Status</option>
                                @foreach($transactionStatusOptions as $statusOption)
                                    <option value="{{ $statusOption }}" @selected(($filters['pharmacy_status'] ?? '') === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.Transaction') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            @if($bookingTransactions)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Booking Transactions</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Type</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookingTransactions as $booking)
                                        @php
                                            $status = strtoupper((string) $booking->status);
                                            $statusClass = in_array($status, ['SUCCESS', 'PAID', 'COMPLETED'], true)
                                                ? 'bg-success'
                                                : (in_array($status, ['PENDING', 'PROCESSING', 'ACTIVE'], true) ? 'bg-warning text-dark' : 'bg-danger');
                                        @endphp
                                        <tr>
                                            <td>#APT{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $booking->patient?->name ?? 'N/A' }}</td>
                                            <td>Dr. {{ $booking->doctor?->name ?? 'N/A' }}</td>
                                            <td><span class="badge bg-info">{{ strtoupper((string) $booking->appointment_type) }}</span></td>
                                            <td>Tsh {{ number_format((float) $booking->total, 2) }}</td>
                                            <td><span class="badge rounded-pill {{ $statusClass }}">{{ $status }}</span></td>
                                            <td>
                                                <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="d-flex gap-2 align-items-center">
                                                    @csrf
                                                    <select name="status" class="form-select form-select-sm" style="min-width: 145px;">
                                                        @foreach($bookingStatusOptions as $statusOption)
                                                            <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ $statusOption }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center text-muted">No booking transactions found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $bookingTransactions->links() }}
                        </div>
                    </div>
                </div>
            @endif

            @if($pharmacyTransactions)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pharmacy Transactions</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Phone</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pharmacyTransactions as $trans)
                                        @php
                                            $status = strtolower((string) $trans->status);
                                            $statusClass = $status === 'paid'
                                                ? 'bg-success'
                                                : (in_array($status, ['pending', 'processing'], true) ? 'bg-warning text-dark' : 'bg-danger');
                                        @endphp
                                        <tr>
                                            <td>#ORD{{ str_pad($trans->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $trans->user?->name ?? 'Guest User' }}</td>
                                            <td>{{ $trans->phone ?? 'N/A' }}</td>
                                            <td>Tsh {{ number_format((float) $trans->total, 2) }}</td>
                                            <td><span class="badge rounded-pill {{ $statusClass }}">{{ strtoupper($status) }}</span></td>
                                            <td>
                                                <div class="d-flex flex-column gap-2">
                                                    <form method="POST" action="{{ route('admin.transactions.status', $trans) }}" class="d-flex gap-2 align-items-center">
                                                        @csrf
                                                        <select name="status" class="form-select form-select-sm" style="min-width: 145px;">
                                                            @foreach($transactionStatusOptions as $statusOption)
                                                                <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('admin.transactions.destroy', $trans) }}" onsubmit="return confirm('Delete this pharmacy transaction permanently?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center text-muted">No pharmacy transactions found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $pharmacyTransactions->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
