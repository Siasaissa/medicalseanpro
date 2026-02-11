@include ('layouts.head')

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
       <!-- @include('layouts.doctorHeader')
        <!-- /Header -->

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Doctor</li>
                                <li class="breadcrumb-item active">Doctor Profile</li>
                            </ol>
                            <h2 class="breadcrumb-title">Doctor Profile</h2>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-bg">
                <img src="{{ asset('images/breadcrumb-bg-01.png') }}" alt="img" class="breadcrumb-bg-01">
                <img src="{{ asset('images/breadcrumb-bg-02.png') }}" alt="img" class="breadcrumb-bg-02">
                <img src="{{ asset('images/breadcrumb-icon.webp') }}" alt="img" class="breadcrumb-bg-03">
                <img src="{{ asset('images/breadcrumb-icon.webp') }}" alt="img" class="breadcrumb-bg-04">
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content doctor-content">
            <div class="container">

                <div class="row">
                    <div class="col-lg-4 col-xl-3 theiaStickySidebar">

                        <!-- Profile Sidebar -->
                        @include('layouts.doctorSidebar')
                        <!-- /Profile Sidebar -->

                    </div>
                     
                    <div class="col-lg-8 col-xl-9">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Profile Settings -->
                        <div class="dashboard-header">
                            <h3>Profile Settings</h3>
                        </div>

                        <!-- Settings List -->
                        <div class="setting-tab">
                            <div class="appointment-tabs">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">Basic Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Speciality & Services</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Availability</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Consultation Modes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Payment & Fees</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /Settings List -->

                        <!-- Speciality & Services Section -->
                        <div class="setting-title">
                            <h5>Speciality & Services</h5>
                        </div>

                        <form action="{{ route('doctor.speciality.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="setting-card">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Primary Speciality</label>
                                            <select class="form-control" name="primary_speciality">
                                                <option value="">Select Speciality</option>
                                                <option value="Cardiology">Cardiology</option>
                                                <option value="Dermatology">Dermatology</option>
                                                <option value="Pediatrics">Pediatrics</option>
                                                <option value="Orthopedics">Orthopedics</option>
                                                <option value="Neurology">Neurology</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Secondary Specialities</label>
                                            <input type="text" name="secondary_specialities" class="form-control" placeholder="e.g., Diabetes Care, General Medicine">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-wrap">
                                            <label class="form-label">Services Offered</label>
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" value="video_call">
                                                    <label class="form-check-label">Video Consultation</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" value="voice_call">
                                                    <label class="form-check-label">Voice Call</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" value="chat">
                                                    <label class="form-check-label">Chat Consultation</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" value="home_visit">
                                                    <label class="form-check-label">Home Visit</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-btn text-end">
                                <button type="submit" class="btn btn-primary prime-btn">Save Speciality Settings</button>
                            </div>
                        </form>
                        <!-- /Speciality & Services Section -->

                        <!-- Availability Section -->
                        <div class="setting-title">
                            <h5>Availability Schedule</h5>
                        </div>

                        <form action="{{ route('doctor.availability.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="setting-card">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Working Days</label>
                                            <select class="form-control" name="working_days[]" multiple>
                                                <option value="monday">Monday</option>
                                                <option value="tuesday">Tuesday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                                <option value="sunday">Sunday</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Start Time</label>
                                            <input type="time" name="start_time" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">End Time</label>
                                            <input type="time" name="end_time" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Session Duration (minutes)</label>
                                            <input type="number" name="session_duration" class="form-control" placeholder="e.g., 30">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Break Time</label>
                                            <input type="text" name="break_time" class="form-control" placeholder="e.g., 13:00-14:00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-btn text-end">
                                <button type="submit" class="btn btn-primary prime-btn">Save Availability</button>
                            </div>
                        </form>
                        <!-- /Availability Section -->

                        <!-- Consultation Modes Section -->
                        <div class="setting-title">
                            <h5>Consultation Modes Setup</h5>
                        </div>

                        <form action="{{ route('doctor.consultation.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="setting-card">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Video Call Platform</label>
                                            <input type="text" name="video_platform" class="form-control" placeholder="e.g., Zoom, Google Meet">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Voice Call Number</label>
                                            <input type="text" name="voice_call_number" class="form-control" placeholder="Phone number for calls">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Home Visit Radius (km)</label>
                                            <input type="number" name="home_visit_radius" class="form-control" placeholder="e.g., 10">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Chat Response Time</label>
                                            <input type="text" name="chat_response_time" class="form-control" placeholder="e.g., Within 2 hours">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Emergency Contact</label>
                                            <input type="text" name="emergency_contact" class="form-control" placeholder="Emergency contact number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-btn text-end">
                                <button type="submit" class="btn btn-primary prime-btn">Save Consultation Settings</button>
                            </div>
                        </form>
                        <!-- /Consultation Modes Section -->

                        <!-- Payment & Fees Section -->
                        <div class="setting-title">
                            <h5>Payment & Fees Configuration</h5>
                        </div>

                        <form action="{{ route('doctor.payment.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="setting-card">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Video Call Fee</label>
                                            <input type="text" name="video_fee" class="form-control" placeholder="e.g., 15000 TZS">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Voice Call Fee</label>
                                            <input type="text" name="voice_fee" class="form-control" placeholder="e.g., 10000 TZS">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Chat Fee</label>
                                            <input type="text" name="chat_fee" class="form-control" placeholder="e.g., 5000 TZS">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Home Visit Fee</label>
                                            <input type="text" name="home_visit_fee" class="form-control" placeholder="e.g., 30000 TZS">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Payment Methods</label>
                                            <input type="text" name="payment_methods" class="form-control" placeholder="e.g., M-Pesa, Tigo Pesa">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Bank Account</label>
                                            <input type="text" name="bank_account" class="form-control" placeholder="Bank account details">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-btn text-end">
                                <button type="submit" class="btn btn-primary prime-btn">Save Payment Settings</button>
                            </div>
                        </form>
                        <!-- /Payment & Fees Section -->

                        <div class="setting-title">
                            <h5>Profile</h5>
                        </div>

                        <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="setting-card">
                                <div class="change-avatar img-upload">
                                    <div class="profile-img">
                                        <i class="fa-solid fa-file-image"></i>
                                    </div>
                                    <div class="upload-img">
                                        <h5>Profile Image</h5>
                                        <div class="imgs-load d-flex align-items-center">
                                            <div class="change-photo">
                                                Upload New
                                                <input type="file" name="dp" class="upload"
                                                    accept=".jpg,.jpeg,.png,.svg">
                                            </div>
                                            <a href="#" class="upload-remove">Remove</a>
                                        </div>
                                        <p class="form-text">
                                            Your image should be below 4 MB. Accepted formats: JPG, PNG, SVG.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-title">
                                <h5>Information</h5>
                            </div>

                            <div class="setting-card">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Sex <span class="text-danger">*</span></label>
                                            <input type="text" name="sex" class="form-control"
                                                placeholder="e.g., Male / Female / Other">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Date of Birth <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="dob" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Blood Group <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="blood_group" class="form-control"
                                                placeholder="e.g., A+, O-, B+">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Marital Status <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="marital_status" class="form-control"
                                                placeholder="e.g., Single, Married, Divorced">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Address <span class="text-danger">*</span></label>
                                            <input type="text" name="address" class="form-control"
                                                placeholder="Enter your residential address">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Phone Number(s) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="phone_numbers" class="form-control"
                                                placeholder="e.g., +255 700 123 456">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-wrap">
                                            <label class="form-label">Known Languages <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-block input-block-new mb-0">
                                                <input class="input-tags form-control" id="inputBox3" type="text"
                                                    name="known_languages" data-role="tagsinput"
                                                    placeholder="e.g., English, Swahili, French">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-title">
                                <h5>Experience</h5>
                            </div>

                            <div class="setting-card">
                                <div class="add-info membership-infos">
                                    <div class="row membership-content">
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">Title <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="title" class="form-control"
                                                    placeholder="e.g., Senior Surgeon">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">Hospital <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="hospital" class="form-control"
                                                    placeholder="e.g., Aga Khan Hospital">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">Years of Experience <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="year_of_experience" class="form-control"
                                                    placeholder="e.g., 10">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">Location <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="location" class="form-control"
                                                    placeholder="e.g., Dar es Salaam, Tanzania">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-9">
                                            <div class="form-wrap">
                                                <label class="form-label">Job Description <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="job_description" class="form-control"
                                                    placeholder="Briefly describe your role and duties"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">Start Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="start_date" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">End Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="end_date" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="form-wrap w-100">
                                                    <label class="form-label">About Membership</label>
                                                    <input type="text" name="about_membership" class="form-control"
                                                        placeholder="e.g., Member of Medical Association of Tanzania">
                                                </div>
                                                <div class="form-wrap ms-2">
                                                    <label class="col-form-label d-block">&nbsp;</label>
                                                    <a href="javascript:void(0);" class="trash-icon trash">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <a href="#" class="add-membership-info more-item">Add New</a>
                                </div>
                            </div>

                            <div class="modal-btn text-end">
                                <a href="#" class="btn btn-gray">Cancel</a>
                                <button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
                            </div>
                        </form>
                        <!-- /Profile Settings -->

                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Footer Section -->
        @include('layouts.footer')
        <!-- /Footer Section -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{asset('js/jquery-3.7.1.min.js')}}" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Sticky Sidebar JS -->
    <script src="{{asset('js/ResizeSensor.js')}}" type="150aa4ebfdefddf1a928273b-text/javascript"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Select2 JS -->
    <script src="{{asset('js/select2.min.js')}}" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Bootstrap Tagsinput JS -->
    <script src="{{asset('js/bootstrap-tagsinput.js')}}" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Profile Settings JS -->
    <script src="{{asset('js/profile-settings.js')}}" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Custom JS -->
    <script src="{{asset('js/script.js')}}" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="150aa4ebfdefddf1a928273b-|49"
        defer=""></script>
    <script defer=""
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        data-cf-beacon="{"
        version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"=""
        crossorigin="anonymous"></script>

</body>

</html>