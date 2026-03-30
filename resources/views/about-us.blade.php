@include('layouts.head')

<body>
    <div class="main-wrapper">
        <header class="header header-custom header-fixed inner-header relative">
            <div class="container">
                <nav class="navbar navbar-expand-lg header-nav">
                    <div class="navbar-header">
                        <a id="mobile_btn" href="javascript:void(0);">
                            <span class="bar-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </a>
                        <a href="{{ route('welcome') }}" class="navbar-brand logo">
                            <img src="{{ asset('images/logo.svg') }}" class="img-fluid" alt="MedicalSean Logo">
                        </a>
                    </div>
                    <div class="header-menu">
                        <div class="main-menu-wrapper">
                            <div class="menu-header">
                                <a href="{{ route('welcome') }}" class="menu-logo">
                                    <img src="{{ asset('images/logo.svg') }}" class="img-fluid" alt="MedicalSean Logo">
                                </a>
                                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                            <ul class="main-nav">
                                <li class="menu"><a href="{{ route('welcome') }}">Home</a></li>
                                <li class="menu active"><a href="{{ route('about.us') }}">About Us</a></li>
                                <li class="menu"><a href="{{ route('blog.grid') }}">Blog Grid</a></li>
                                <li class="menu"><a href="{{ route('login') }}">Login</a></li>
                                <li class="menu"><a href="{{ route('register') }}">Register</a></li>
                            </ul>
                        </div>
                        <ul class="nav header-navbar-rht">
                            <li>
                                <a href="{{ route('login') }}"
                                    class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill">
                                    <i class="isax isax-lock-1 me-1"></i>Login
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}"
                                    class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
                                    <i class="isax isax-user-tick me-1"></i>Register
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('welcome') }}"><i class="isax isax-home-15"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">About Us</li>
                            </ol>
                            <h2 class="breadcrumb-title">About MedicalSean</h2>
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

        <div class="content">
            <div class="container">
                <div class="row align-items-center mb-5">
                    <div class="col-lg-6">
                        <h3 class="mb-3">Trusted Digital Healthcare for Tanzania</h3>
                        <p class="mb-3">MedicalSean helps patients book and complete consultations through video call, voice call, chat,
                            and home visits from verified doctors.</p>
                        <p class="mb-4">Our goal is simple: fast access to quality care, secure communication, reliable payment flow, and
                            better follow-up for both doctors and patients.</p>
                        <a href="{{ route('register') }}" class="btn btn-primary-gradient rounded-pill">Get Started</a>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0">
                        <img src="{{ asset('images/about-us.png') }}" alt="About MedicalSean" class="img-fluid rounded-3"
                            onerror="this.src='{{ asset('images/login-banner.png') }}'">
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-4 d-flex">
                        <div class="card border-0 shadow-sm w-100">
                            <div class="card-body">
                                <h5>Our Mission</h5>
                                <p class="mb-0">Make healthcare reachable from any location through telemedicine and coordinated care.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex mt-3 mt-md-0">
                        <div class="card border-0 shadow-sm w-100">
                            <div class="card-body">
                                <h5>Our Vision</h5>
                                <p class="mb-0">Build a professional and patient-centered digital clinic network across East Africa.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex mt-3 mt-md-0">
                        <div class="card border-0 shadow-sm w-100">
                            <div class="card-body">
                                <h5>Our Promise</h5>
                                <p class="mb-0">Transparent bookings, secure communication, and responsive support for every consultation.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-center mb-5">
                    <div class="col-sm-6 col-lg-3">
                        <h3 class="mb-1">1K+</h3>
                        <p>Consultations Completed</p>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <h3 class="mb-1">250+</h3>
                        <p>Verified Doctors</p>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <h3 class="mb-1">15K+</h3>
                        <p>Patients Served</p>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <h3 class="mb-1">24/7</h3>
                        <p>Digital Access</p>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <a href="{{ route('blog.grid') }}" class="btn btn-dark rounded-pill me-2">Read Health Blog</a>
                    <a href="{{ route('login') }}" class="btn btn-primary-gradient rounded-pill">Book Consultation</a>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
