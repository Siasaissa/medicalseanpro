@include('layouts.head')

<body>
    <div class="main-wrapper">
        @include('layouts.header')

        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="isax isax-home-15"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Patient</li>
                                <li class="breadcrumb-item active">Vitals</li>
                            </ol>
                            <h2 class="breadcrumb-title">Vitals</h2>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-bg">
                <img src="{{ asset('images/breadcrumb-bg-01.png') }}" alt="img" class="breadcrumb-bg-01">
                <img src="{{ asset('images/breadcrumb-bg-02.png') }}" alt="img" class="breadcrumb-bg-02">
                <img src="{{ asset('images/breadcrumb-icon.png') }}" alt="img" class="breadcrumb-bg-03">
                <img src="{{ asset('images/breadcrumb-icon.png') }}" alt="img" class="breadcrumb-bg-04">
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row">
                    @include('layouts.sidebar')

                    <div class="col-lg-8 col-xl-9">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="dashboard-header d-flex align-items-center justify-content-between">
                            <h3>Vitals</h3>
                            <a href="#addVitalModal" class="btn btn-md btn-primary-gradient rounded-pill" data-bs-toggle="modal">
                                Add Vitals
                            </a>
                        </div>

                        <div class="dashboard-card w-100 medical-details-item mb-4">
                            <div class="dashboard-card-head medical-detail-head">
                                <div class="header-title">
                                    <h6>Latest Updated Vitals</h6>
                                </div>
                                <div class="latest-update">
                                    <p>
                                        <i class="isax isax-calendar-tick5 me-2"></i>
                                        Last update on:
                                        {{ $latest?->recorded_at ? $latest->recorded_at->format('d M Y h:i A') : 'No record yet' }}
                                    </p>
                                </div>
                            </div>

                            <div class="dashboard-card-body">
                                <div class="row row-gap-3">
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-red mb-0">
                                            <span>Blood Pressure</span>
                                            <h3>{{ $latest?->blood_pressure ?? '-' }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-orange mb-0">
                                            <span>Heart Rate</span>
                                            <h3>{{ $latest?->heart_rate ? $latest->heart_rate . ' bpm' : '-' }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-dark-blue mb-0">
                                            <span>Glucose</span>
                                            <h3>{{ $latest?->glucose_level ?? '-' }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-amber mb-0">
                                            <span>Temperature</span>
                                            <h3>{{ $latest?->body_temperature ? $latest->body_temperature . ' C' : '-' }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-purple mb-0">
                                            <span>BMI</span>
                                            <h3>{{ $latest?->bmi ?? '-' }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-blue mb-0">
                                            <span>SPo2</span>
                                            <h3>{{ $latest?->spo2 ? $latest->spo2 . '%' : '-' }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="custom-table">
                            <div class="table-responsive">
                                <table class="table table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>BMI</th>
                                            <th>Heart Rate</th>
                                            <th>FBC</th>
                                            <th>Weight (kg)</th>
                                            <th>Recorded At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($vitals as $vital)
                                            <tr>
                                                <td>#VT{{ str_pad($vital->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $vital->bmi ?? '-' }}</td>
                                                <td>{{ $vital->heart_rate ?? '-' }}</td>
                                                <td>{{ $vital->fbc_status ?? '-' }}</td>
                                                <td>{{ $vital->weight ?? '-' }}</td>
                                                <td>{{ $vital->recorded_at ? $vital->recorded_at->format('d M Y h:i A') : '-' }}</td>
                                                <td>
                                                    <form action="{{ route('patient.vitals.destroy', $vital->id) }}" method="POST" onsubmit="return confirm('Delete this vital record?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">No vitals recorded yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-3">
                            {{ $vitals->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <div class="modal fade custom-modals" id="addVitalModal">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Vitals</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form action="{{ route('patient.vitals.store') }}" method="POST">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">BMI</label>
                                <input type="number" step="0.01" name="bmi" class="form-control" value="{{ old('bmi') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Heart Rate (bpm)</label>
                                <input type="number" name="heart_rate" class="form-control" value="{{ old('heart_rate') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Weight (kg)</label>
                                <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">FBC Status</label>
                                <input type="text" name="fbc_status" class="form-control" value="{{ old('fbc_status') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Blood Pressure</label>
                                <input type="text" name="blood_pressure" class="form-control" placeholder="120/80" value="{{ old('blood_pressure') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Glucose Level</label>
                                <input type="text" name="glucose_level" class="form-control" value="{{ old('glucose_level') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Body Temperature (C)</label>
                                <input type="number" step="0.1" name="body_temperature" class="form-control" value="{{ old('body_temperature') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SPo2 (%)</label>
                                <input type="number" name="spo2" class="form-control" value="{{ old('spo2') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Recorded At</label>
                                <input type="datetime-local" name="recorded_at" class="form-control" value="{{ old('recorded_at') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Vitals</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modalEl = document.getElementById('addVitalModal');
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            });
        </script>
    @endif
</body>
</html>
