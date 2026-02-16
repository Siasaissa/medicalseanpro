@include ('layouts.head')

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include ('layouts.header')
        <!-- /Header -->

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar overflow-visible">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a></li>
                                <li class="breadcrumb-item">Doctor</li>
                                <li class="breadcrumb-item active">Doctor Grid</li>
                            </ol>
                            <h2 class="breadcrumb-title">Doctor Grid</h2>
                        </nav>
                    </div>
                </div>
                <div class="bg-primary-gradient rounded-pill doctors-search-box">
                    <div class="search-box-one rounded-pill">
                        <form action="{{ route('patient.doctor-grid') }}" method="GET"> 
                            <div class="search-input search-line">
                                <i class="isax isax-hospital5 bficon"></i>
                                <div class="mb-0">
                                    <input type="text" name="search" class="form-control" placeholder="Search for Doctors, Hospitals, Clinics" value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="search-input search-map-line">
                                <i class="isax isax-location5"></i>
                                <div class="mb-0">
                                    <input type="text" name="location" class="form-control" placeholder="Location" value="{{ request('location') }}"> 
                                </div>
                            </div>
                            <div class="search-input search-calendar-line">
                                <i class="isax isax-calendar-tick5"></i>
                                <div class="mb-0">
                                    <input type="text" name="date" class="form-control datetimepicker" placeholder="Date" value="{{ request('date') }}">
                                </div>
                            </div>
                            <div class="form-search-btn">
                                <button class="btn btn-primary d-inline-flex align-items-center rounded-pill" type="submit">
                                    <i class="isax isax-search-normal-15 me-2"></i>Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-bg">
                <img src="{{asset('images/breadcrumb-bg-01.png')}}" alt="img" class="breadcrumb-bg-01">
                <img src="{{asset('images/breadcrumb-bg-02.png')}}" alt="img" class="breadcrumb-bg-02">
                <img src="{{asset('images/breadcrumb-icon.webp')}}" alt="img" class="breadcrumb-bg-03">
                <img src="{{asset('images/breadcrumb-icon.webp')}}" alt="img" class="breadcrumb-bg-04">
            </div>
        </div>
        <!-- /Breadcrumb -->

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="content mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card filter-lists">
                            <div class="card-header">
                                <div class="d-flex align-items-center filter-head justify-content-between">
                                    <h4>Filter</h4>
                                    <a href="{{ route('patient.doctor-grid') }}" class="text-secondary text-decoration-underline">Clear All</a>
                                </div>
                                <div class="filter-input">
                                    <div class="position-relative input-icon">
                                        <input type="text" id="filterSearch" class="form-control" placeholder="Search filters...">
                                        <span><i class="isax isax-search-normal-1"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <form id="filterForm" action="{{ route('patient.doctor-grid') }}" method="GET">
                                    <!-- Keep search parameters -->
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="location" value="{{ request('location') }}">
                                    <input type="hidden" name="date" value="{{ request('date') }}">

                                    <!-- Specialities Filter -->
                                    <div class="accordion-item border-bottom">
                                        <div class="accordion-header" id="heading1">
                                            <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-controls="collapse1" role="button">
                                                <div class="d-flex align-items-center w-100">
                                                    <h5>Specialities</h5>
                                                    <div class="ms-auto">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse1" class="accordion-collapse show" aria-labelledby="heading1">
                                            <div class="accordion-body pt-3">
                                                @php $selectedSpecialities = request('specialities', []) @endphp
                                                @foreach($specialities as $index => $speciality)
                                                    @if($loop->iteration <= 5)
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input speciality-filter" type="checkbox" 
                                                                       name="specialities[]" value="{{ $speciality }}" 
                                                                       id="speciality_{{ $loop->index }}" 
                                                                       {{ in_array($speciality, $selectedSpecialities) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="speciality_{{ $loop->index }}">
                                                                    {{ $speciality }}
                                                                </label>
                                                            </div>
                                                            <span class="filter-badge">{{ $specialityCounts[$speciality] ?? 0 }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach

                                                @if(count($specialities) > 5)
                                                    <div class="view-content">
                                                        <div class="viewall-one">
                                                            @foreach($specialities as $index => $speciality)
                                                                @if($loop->iteration > 5)
                                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input speciality-filter" type="checkbox" 
                                                                                   name="specialities[]" value="{{ $speciality }}" 
                                                                                   id="speciality_{{ $loop->index }}" 
                                                                                   {{ in_array($speciality, $selectedSpecialities) ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="speciality_{{ $loop->index }}">
                                                                                {{ $speciality }}
                                                                            </label>
                                                                        </div>
                                                                        <span class="filter-badge">{{ $specialityCounts[$speciality] ?? 0 }}</span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="view-all">
                                                            <a href="javascript:void(0);" class="viewall-button-one text-secondary text-decoration-underline">View More</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gender Filter -->
                                    <div class="accordion-item border-bottom">
                                        <div class="accordion-header" id="heading2">
                                            <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-controls="collapse2" role="button">
                                                <div class="d-flex align-items-center w-100">
                                                    <h5>Gender</h5>
                                                    <div class="ms-auto">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse2" class="accordion-collapse show" aria-labelledby="heading2">
                                            <div class="accordion-body pt-3">
                                                @php $selectedGenders = request('gender', []) @endphp
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input gender-filter" type="checkbox" name="gender[]" value="male" id="gender_male" {{ in_array('male', $selectedGenders) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="gender_male">Male</label>
                                                    </div>
                                                    <span class="filter-badge">{{ $genderCounts['male'] ?? 0 }}</span>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="form-check">
                                                        <input class="form-check-input gender-filter" type="checkbox" name="gender[]" value="female" id="gender_female" {{ in_array('female', $selectedGenders) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="gender_female">Female</label>
                                                    </div>
                                                    <span class="filter-badge">{{ $genderCounts['female'] ?? 0 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Consultation Type Filter -->
                                    <div class="accordion-item border-bottom">
                                        <div class="accordion-header" id="heading7">
                                            <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-controls="collapse7" role="button">
                                                <div class="d-flex align-items-center w-100">
                                                    <h5>Consultation type</h5>
                                                    <div class="ms-auto">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse7" class="accordion-collapse show" aria-labelledby="heading7">
                                            <div class="accordion-body pt-3">
                                                @php $selectedConsultationTypes = request('consultation_types', []) @endphp
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input consultation-filter" type="checkbox" name="consultation_types[]" value="voice" id="consult_voice" {{ in_array('voice', $selectedConsultationTypes) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="consult_voice">Audio Call</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input consultation-filter" type="checkbox" name="consultation_types[]" value="video" id="consult_video" {{ in_array('video_call', $selectedConsultationTypes) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="consult_video">Video Call</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input consultation-filter" type="checkbox" name="consultation_types[]" value="chat" id="consult_chat" {{ in_array('chat', $selectedConsultationTypes) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="consult_chat">Chat</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="form-check">
                                                        <input class="form-check-input consultation-filter" type="checkbox" name="consultation_types[]" value="home_visit" id="consult_home" {{ in_array('home_visit', $selectedConsultationTypes) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="consult_home">Home Visit</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Languages Filter -->
                                    <div class="accordion-item border-bottom">
                                        <div class="accordion-header" id="heading8">
                                            <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-controls="collapse8" role="button">
                                                <div class="d-flex align-items-center w-100">
                                                    <h5>Languages</h5>
                                                    <div class="ms-auto">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse8" class="accordion-collapse show" aria-labelledby="heading8">
                                            <div class="accordion-body pt-3">
                                                @php $selectedLanguages = request('known_languages', []) @endphp
                                                @foreach($languages as $language)
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input language-filter" type="checkbox" 
                                                                   name="languages[]" value="{{ $language }}" 
                                                                   id="lang_{{ Str::slug($language) }}" 
                                                                   {{ in_array($language, $selectedLanguages) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="lang_{{ Str::slug($language) }}">
                                                                {{ $language }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Apply Filters Button -->
                                    <div class="p-3">
                                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h3>Showing <span class="text-secondary">{{ $doctors->total() }}</span> Doctors For You</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    <div class="doctor-filter-availability me-2">
                                        <p>Availability</p>
                                        <div class="status-toggle status-tog">
                                            <input type="checkbox" id="availabilityFilter" class="check" name="available" form="filterForm" value="1" {{ request('available') ? 'checked' : '' }}>
                                            <label for="availabilityFilter" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>

                                    <div class="dropdown header-dropdown me-2">
                                        <a class="dropdown-toggle sort-dropdown" data-bs-toggle="dropdown" href="javascript:void(0);" aria-expanded="false">
                                            <span>Sort By</span> 
                                            @if(request('sort_by') == 'price_low_high')
                                                Price (Low to High)
                                            @elseif(request('sort_by') == 'price_high_low')
                                                Price (High to Low)
                                            @else
                                                Default
                                            @endif
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item sort-option" data-sort="price_low_high">
                                                Price (Low to High)
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item sort-option" data-sort="price_high_low">
                                                Price (High to Low)
                                            </a>
                                        </div>
                                    </div>
                                    <a href="{{ route('patient.doctor-grid') }}" class="btn btn-sm head-icon active me-2"><i class="isax isax-grid-7"></i></a>
                                    <a href="{{ route('doctor.list') }}" class="btn btn-sm head-icon me-2"><i class="isax isax-row-vertical"></i></a>
                                    <a href="{{ route('doctor.map') }}" class="btn btn-sm head-icon"><i class="isax isax-location"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @forelse ($doctors as $doctor)
                            <div class="col-xxl-4 col-md-6">
                                <div class="card">
                                    <div class="card-img card-img-hover">
                                        <img src="{{ asset($doctor->profile->dp ?? 'images/default-doctor.jpg') }}" alt="{{ $doctor->name }}">
                                        <div class="grid-overlay-item d-flex align-items-center justify-content-between">
                                            <span class="badge bg-orange"><i class="fa-solid fa-star me-1"></i>{{ $doctor->profile->rating ?? '5.0' }}</span>
                                            <a href="javascript:void(0)" class="fav-icon">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="d-flex active-bar align-items-center justify-content-between p-3">
                                            <a href="#" class="text-indigo fw-medium fs-14">{{ $doctor->profile->primary_speciality ?? $doctor->profile->speciality ?? 'General' }}</a>
                                            @php
												// Create an instance of DoctorController to check availability
												$doctorController = app('App\Http\Controllers\DoctorController');
												$isAvailable = $doctorController->checkDoctorAvailability($doctor->profile);
											@endphp

											@if($isAvailable)
												<span class="badge bg-success-light d-inline-flex align-items-center">
													<i class="fa-solid fa-circle fs-5 me-1"></i>
													Available Now
												</span>
											@else
												<span class="badge bg-danger-light d-inline-flex align-items-center">
													<i class="fa-solid fa-circle fs-5 me-1"></i>
													Not Available
												</span>
											@endif
                                        </div>
                                        <div class="p-3 pt-0">
                                            <div class="doctor-info-detail mb-3 pb-3">
                                                <h3 class="mb-1">Dr. {{ $doctor->name }}</h3>
                                                <div class="d-flex align-items-center">
                                                    <p class="d-flex align-items-center mb-0 fs-14">
                                                        <i class="isax isax-location me-2"></i>{{ $doctor->profile->location ?? $doctor->profile->address ?? 'Location not specified' }}
                                                    </p>
                                                    <i class="fa-solid fa-circle fs-5 text-primary mx-2 me-1"></i>
                                                    <span class="fs-14 fw-medium">{{ $doctor->profile->session_duration ?? '30' }} Min</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-1">Consultation Fees</p>
                                                    <h3 class="text-orange">Tsh {{ number_format($doctor->profile->video_fee ?? 650) }}</h3>
                                                </div>
                                                <a href="{{ route('patient.booking', ['doctor' => $doctor->id]) }}" 
                                                   class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
                                                    <i class="isax isax-calendar-1 me-2"></i>
                                                    Book Now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <h4>No doctors found matching your criteria</h4>
                                    <a href="{{ route('patient.doctor-grid') }}" class="btn btn-primary mt-3">Clear Filters</a>
                                </div>
                            </div>
                            @endforelse

                            @if($doctors->hasMorePages())
                            <div class="col-md-12">
                                <div class="text-center mb-4">
                                    <a href="{{ $doctors->nextPageUrl() }}" class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill">
                                        <i class="isax isax-d-cube-scan5 me-2"></i>
                                        Load More Doctors
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-md-12">
                                {{ $doctors->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        @include('layouts.footer')
        <!-- /Footer Section -->

        <!-- Cursor -->
        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>
        <!-- /Cursor -->

    </div>
    <!-- /Main Wrapper -->

    <!-- JavaScript -->
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/ResizeSensor.js')}}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/daterangepicker.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>

    <script>
        // Auto-submit filters when checkboxes change
        $(document).ready(function() {
            $('.speciality-filter, .gender-filter, .consultation-filter, .language-filter').change(function() {
                $('#filterForm').submit();
            });

            $('#availabilityFilter').change(function() {
                $('#filterForm').submit();
            });

            // Sort options
            $('.sort-option').click(function(e) {
                e.preventDefault();
                var sortValue = $(this).data('sort');
                
                // Add or update sort parameter in form
                var form = $('#filterForm');
                var sortInput = $('<input>').attr('type', 'hidden').attr('name', 'sort_by').val(sortValue);
                
                // Remove existing sort input if any
                form.find('input[name="sort_by"]').remove();
                form.append(sortInput);
                form.submit();
            });

            // Filter search functionality
            $('#filterSearch').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('.accordion-body .d-flex').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // View More/Less functionality
            $('.viewall-button-one').click(function() {
                var viewContent = $(this).closest('.view-content');
                viewContent.find('.viewall-one').toggle();
                $(this).text($(this).text() == 'View More' ? 'View Less' : 'View More');
            });
        });
    </script>

</body>
</html>