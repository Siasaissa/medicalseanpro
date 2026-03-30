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
                        <h3 class="page-title">Transactions Control Panel</h3>
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

            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.Transaction') }}" class="row g-2 mb-3">
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control" placeholder="Search order ID / user / email / phone" value="{{ $filters['q'] ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                @foreach($transactionStatusOptions as $statusOption)
                                    <option value="{{ $statusOption }}" @selected(($filters['status'] ?? '') === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.Transaction') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>User</th>
                                    <th>Phone</th>
                                    <th>Total</th>
                                    <th>Current Status</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trans)
                                    @php
                                        $avatar = $trans->user?->profile?->dp ? asset($trans->user->profile->dp) : asset('images/default.jpeg');
                                        $status = strtolower((string) $trans->status);
                                        $statusClass = $status === 'paid'
                                            ? 'bg-success'
                                            : (in_array($status, ['pending','processing']) ? 'bg-warning text-dark' : 'bg-danger');
                                    @endphp
                                    <tr>
                                        <td>#ORD{{ str_pad($trans->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="{{ $avatar }}" alt="User"></a>
                                                <a href="javascript:void(0);">{{ $trans->user?->name ?? 'Guest User' }}<br><small>{{ $trans->user?->email ?? 'No email' }}</small></a>
                                            </h2>
                                        </td>
                                        <td>{{ $trans->phone ?? 'N/A' }}</td>
                                        <td>Tsh {{ number_format((float) $trans->total, 2) }}</td>
                                        <td><span class="badge rounded-pill {{ $statusClass }}">{{ strtoupper($status) }}</span></td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <form method="POST" action="{{ route('admin.transactions.status', $trans) }}" class="d-flex gap-2 align-items-center">
                                                    @csrf
                                                    <select name="status" class="form-select form-select-sm" style="min-width: 150px;">
                                                        @foreach($transactionStatusOptions as $statusOption)
                                                            <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.transactions.destroy', $trans) }}" onsubmit="return confirm('Delete this transaction permanently?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No transactions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $transactions->links() }}
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
