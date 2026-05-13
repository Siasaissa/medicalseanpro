@include('layouts.adminHead')

@php
    $pharmacyStatusColors = [
        'pending' => 'warning',
        'processing' => 'info',
        'paid' => 'success',
        'failed' => 'danger',
        'cancelled' => 'dark',
        'refunded' => 'secondary',
    ];

    $bookingStatusColors = [
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
                            <h3 class="page-title">Transactions</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                                <li class="breadcrumb-item active">Transactions</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-muted">Pharmacy Revenue</h6>
                                <h3 class="mb-0">TSh {{ number_format((float) ($totals['pharmacy'] ?? 0), 0) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-muted">Booking Revenue</h6>
                                <h3 class="mb-0">TSh {{ number_format((float) ($totals['booking'] ?? 0), 0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.Transaction') }}" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="ID, name, email, phone">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Source</label>
                                <select name="source" class="form-control">
                                    <option value="all" @selected(($filters['source'] ?? 'all') === 'all')>All</option>
                                    <option value="pharmacy" @selected(($filters['source'] ?? '') === 'pharmacy')>Pharmacy</option>
                                    <option value="booking" @selected(($filters['source'] ?? '') === 'booking')>Booking</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pharmacy Status</label>
                                <select name="pharmacy_status" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($transactionStatusOptions as $status)
                                        <option value="{{ $status }}" @selected(($filters['pharmacy_status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Booking Status</label>
                                <select name="booking_status" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($bookingStatusOptions as $status)
                                        <option value="{{ $status }}" @selected(($filters['booking_status'] ?? '') === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Go</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if ($pharmacyTransactions)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pharmacy Orders</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Customer</th>
                                            <th>Phone</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Update</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pharmacyTransactions as $order)
                                            <tr>
                                                <td>#ORD{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td>
                                                    <strong>{{ $order->user->name ?? 'Guest User' }}</strong><br>
                                                    <small class="text-muted">{{ $order->user->email ?? 'No email' }}</small>
                                                </td>
                                                <td>{{ $order->phone ?? 'N/A' }}</td>
                                                <td>TSh {{ number_format((float) ($order->total ?? 0), 0) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $pharmacyStatusColors[$order->status ?? ''] ?? 'secondary' }}-light">
                                                        {{ ucfirst($order->status ?? 'unknown') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.transactions.status', $order) }}" method="POST" class="d-flex gap-2">
                                                        @csrf
                                                        <select name="status" class="form-control form-control-sm">
                                                            @foreach ($transactionStatusOptions as $status)
                                                                <option value="{{ $status }}" @selected(($order->status ?? '') === $status)>{{ ucfirst($status) }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button class="btn btn-sm btn-primary">Save</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.transactions.destroy', $order) }}" method="POST" onsubmit="return confirm('Delete this pharmacy transaction?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">No pharmacy transactions found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $pharmacyTransactions->links() }}
                            </div>
                        </div>
                    </div>
                @endif

                @if ($bookingTransactions)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Booking Payments</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Booking</th>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bookingTransactions as $booking)
                                            <tr>
                                                <td>#APT{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $booking->patient->name ?? 'N/A' }}</td>
                                                <td>{{ $booking->doctor->name ?? 'N/A' }}</td>
                                                <td>TSh {{ number_format((float) ($booking->total ?? 0), 0) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $bookingStatusColors[$booking->status ?? ''] ?? 'secondary' }}-light">
                                                        {{ $booking->status ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="d-flex gap-2">
                                                        @csrf
                                                        <select name="status" class="form-control form-control-sm">
                                                            @foreach ($bookingStatusOptions as $status)
                                                                <option value="{{ $status }}" @selected(($booking->status ?? '') === $status)>{{ $status }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button class="btn btn-sm btn-primary">Save</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">No booking transactions found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $bookingTransactions->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('admincss/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admincss/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admincss/js/feather.min.js') }}"></script>
    <script src="{{ asset('admincss/js/script.js') }}"></script>
</body>
</html>
