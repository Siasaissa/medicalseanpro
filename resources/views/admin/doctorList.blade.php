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
                            <h3 class="page-title">Doctors Control Panel</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Doctors</li>
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

            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.doctorList') }}" class="row g-2 mb-3">
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control" placeholder="Search name, email, ID, speciality, phone" value="{{ $filters['q'] ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                @foreach($statusOptions as $statusOption)
                                    <option value="{{ $statusOption }}" @selected(($filters['status'] ?? '') === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.doctorList') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Speciality</th>
                                    <th>Phone</th>
                                    <th>Member Since</th>
                                    <th>Total Earned</th>
                                    <th>Current Status</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($doctors as $doc)
                                    @php
                                        $profile = $doc->profile;
                                        $avatar = $profile?->dp ? asset($profile->dp) : asset('images/default.jpeg');
                                        $currentStatus = strtolower($profile?->status ?? 'inactive');
                                        $earned = $doc->doctorBookings
                                            ->whereIn('status', ['SUCCESS', 'PAID'])
                                            ->sum('total');
                                    @endphp
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript:void(0);" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="{{ $avatar }}" alt="Doctor Image">
                                                </a>
                                                <a href="javascript:void(0);">Dr. {{ $doc->name }}<br><small>{{ $doc->email }}</small></a>
                                            </h2>
                                        </td>
                                        <td>{{ $profile?->speciality ?? 'Not set' }}</td>
                                        <td>{{ $profile?->phone_numbers ?? 'Not set' }}</td>
                                        <td>{{ optional($doc->created_at)->format('d M Y') }}</td>
                                        <td>Tsh {{ number_format($earned, 2) }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $currentStatus === 'active' ? 'bg-success' : ($currentStatus === 'suspended' ? 'bg-danger' : 'bg-secondary') }}">
                                                {{ ucfirst($currentStatus) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.users.status', $doc) }}" class="d-flex gap-2 align-items-center">
                                                @csrf
                                                <select name="status" class="form-select form-select-sm" style="min-width: 130px;">
                                                    @foreach($statusOptions as $statusOption)
                                                        <option value="{{ $statusOption }}" @selected($currentStatus === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No doctors found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $doctors->links() }}
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
