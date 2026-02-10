@include('layouts.head')

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include('layouts.doctorHeader')
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
                                <li class="breadcrumb-item active">Spaciality & Services</li>
                            </ol>
                            <h2 class="breadcrumb-title">Spaciality & Services</h2>
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

                        <div class="dashboard-header">
                            <h3>Speciality & Services</h3>

                        </div>

                        <div class="accordions" id="list-accord">

                            <!-- Spaciality Item -->
                            <div class="user-accordion-item">
                                <a href="#" class="accordion-wrap" data-bs-toggle="collapse"
                                    data-bs-target="#cardiology">Cardiology</a>
                                <div class="accordion-collapse collapse show" id="cardiology"
                                    data-bs-parent="#list-accord">
                                    <div class="content-collapse">
                                        <div class="add-service-info">
                                            <form method="POST" action="{{ route('specialities.store') }}">
                                                @csrf
                                                	
                                                <div class="add-info">
                                                    
                                                    <div class="row">
                                                        
                                                        <div class="col-md-4">
                                                            <div class="form-wrap">
                                                                <label class="form-label">Speciality <span
                                                                        class="text-danger">*</span></label>
                                                                <select class="select form-control" name="speciality">
                                                                    <option>Select Speciality</option>
                                                                    <option value="Cardiology">Cardiology</option>
                                                                    <option value="Neurology">Neurology</option>
                                                                    <option value="Urology">Urology</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row service-cont">
                                                        <div class="col-md-3">
                                                            <div class="form-wrap">
                                                                <label class="form-label">Service <span
                                                                        class="text-danger">*</span></label>
                                                                <select class="select form-control" name="service">
                                                                    <option>Select Service</option>
                                                                    <option value="Surgery">Surgery</option>
                                                                    <option value="General Checkup">General Checkup</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-wrap w-100">
                                                                    <label class="form-label">About Service</label>
                                                                    <input type="text" class="form-control"
                                                                        name="about_service">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-btn text-end">
                                                    <button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



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
    <script src="{{asset('js/jquery-3.7.1.min.js')}}" type="c8b21093f66fafa8aee5be31-text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}" type="c8b21093f66fafa8aee5be31-text/javascript"></script>

    <!-- Sticky Sidebar JS -->
    <script src="{{asset('js/ResizeSensor.js')}}" type="c8b21093f66fafa8aee5be31-text/javascript"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}" type="c8b21093f66fafa8aee5be31-text/javascript"></script>

    <!-- Select2 JS -->
    <script src="{{asset('js/select2.min.js')}}" type="c8b21093f66fafa8aee5be31-text/javascript"></script>

    <!-- Datepicker JS -->
    <script src="{{asset('js/moment.min.js')}}" type="c8b21093f66fafa8aee5be31-text/javascript"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"
        type="c8b21093f66fafa8aee5be31-text/javascript"></script>

    <!-- Custom JS -->
    <script src="{{asset('js/profile-settings.js')}}" type="c8b21093f66fafa8aee5be31-text/javascript"></script>
    <script src="{{asset('js/script.js')}}" type="c8b21093f66fafa8aee5be31-text/javascript"></script>

    <script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="c8b21093f66fafa8aee5be31-|49"
        defer=""></script>
    <script defer=""
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        data-cf-beacon="{"
        version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"=""
        crossorigin="anonymous"></script>

</body>

</html>