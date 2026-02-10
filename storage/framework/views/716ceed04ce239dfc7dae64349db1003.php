<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body>
    <div class="main-wrapper">
        <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <!-- Booking Steps -->
        <div class="doctor-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="booking-wizard">
                            <ul class="form-wizard-steps d-sm-flex align-items-center justify-content-center"
                                id="progressbar2">
                                <li class="progress-active">
                                    <div class="profile-step"><span class="multi-steps">1</span>
                                        <div class="step-section">
                                            <h6>Service Time</h6>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="profile-step"><span class="multi-steps">2</span>
                                        <div class="step-section">
                                            <h6>Appointment Type</h6>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="profile-step"><span class="multi-steps">3</span>
                                        <div class="step-section">
                                            <h6>Payment</h6>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="profile-step"><span class="multi-steps">4</span>
                                        <div class="step-section">
                                            <h6>Confirmation</h6>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Alert Container for AJAX responses -->
                        <div id="ajax-alert-container"></div>
                        
                        <!-- Form starts here -->
                        <form action="<?php echo e(route('patient.booking.store', $doctor->id)); ?>" method="POST" id="booking-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">
                            <input type="hidden" name="doctor_id" value="<?php echo e($doctor->id); ?>">
                            <input type="hidden" name="appointment_datetime" id="appointment-datetime-input">
                            <input type="hidden" name="appointment_type" id="appointment-type-input">
                            <input type="hidden" name="service_price" id="service-price-input">
                            <input type="hidden" name="fees" id="fees-input">
                            <input type="hidden" name="tax" id="tax-input">
                            <input type="hidden" name="discount" id="discount-input">
                            <input type="hidden" name="total" id="total-input">
                            <input type="hidden" id="payment_gateway" name="payment_gateway" value="Airtel-Money">
                            <input type="hidden" id="phone-hidden" name="phone" value="<?php echo e(Auth::user()->phone ?? ''); ?>">
                            <input type="hidden" name="service" id="service-input" value="">
                            <input type="hidden" name="service_time" id="service-time-input" value="">

                            <div class="booking-widget multistep-form mb-5">

                                <!-- STEP 1: Service Time -->
                                <fieldset id="first" class="step-fieldset">
                                    <div class="card booking-card mb-0">
                                        <div class="card-header">
                                            <div class="booking-header pb-0">
                                                <div class="card mb-0">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center flex-wrap">
                                                            <span class="avatar avatar-xxxl avatar-rounded me-2">
                                                                <img src="<?php echo e(asset($doctor->profile->dp)); ?>" alt="User Image">
                                                            </span>
                                                            <div>
                                                                <h4 class="mb-1"><?php echo e($doctor->name); ?>

                                                                    <span class="badge bg-orange fs-12">
                                                                        <i class="fa-solid fa-star me-1"></i>5.0
                                                                    </span>
                                                                </h4>
                                                                <p class="text-indigo mb-3 fw-medium"><?php echo e($doctor->profile->speciality ?? 'No speciality'); ?></p>
                                                                <p class="mb-0">
                                                                    <i class="isax isax-location me-2"></i><?php echo e($doctor->profile->address ?? 'No Address'); ?>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body booking-body">
                                            <h6 class="mb-3">Services Per Time</h6>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service20" value="20" checked
                                                            data-price="2000" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service20">
                                                            <span class="service-title d-block mb-1">20 minutes</span>
                                                            <span class="fs-14 d-block">Tsh 2000</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service40" value="40"
                                                            data-price="4000" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service40">
                                                            <span class="service-title d-block mb-1">40 minutes</span>
                                                            <span class="fs-14 d-block">Tsh 4000</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service60" value="60"
                                                            data-price="6000" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service60">
                                                            <span class="service-title d-block mb-1">1 hour</span>
                                                            <span class="fs-14 d-block">Tsh 6000</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service80" value="80"
                                                            data-price="8000" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service80">
                                                            <span class="service-title d-block mb-1">1 hour 20 minutes</span>
                                                            <span class="fs-14 d-block">Tsh 8000</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service100" value="100"
                                                            data-price="10000" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service100">
                                                            <span class="service-title d-block mb-1">1 hour 40 minutes</span>
                                                            <span class="fs-14 d-block">Tsh 10000</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service120" value="120"
                                                            data-price="12000" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service120">
                                                            <span class="service-title d-block mb-1">2 hours</span>
                                                            <span class="fs-14 d-block">Tsh 12000</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between">
                                                <a href="<?php echo e(url()->previous()); ?>" class="btn btn-md btn-dark rounded-pill">
                                                    <i class="isax isax-arrow-left-2 me-1"></i>Back to Doctors
                                                </a>
                                                <button type="button" class="btn btn-md btn-primary-gradient next_btn rounded-pill">
                                                    Select Appointment Type <i class="isax isax-arrow-right-3 ms-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- STEP 2: Appointment Type -->
                                <fieldset class="step-fieldset">
                                    <div class="card booking-card mb-0">
                                        <div class="card-body booking-body">
                                            <h6 class="mb-3">Select Appointment Type</h6>
                                            <div class="row">
                                                <div class="col-xl col-md-3 col-sm-4">
                                                    <div class="radio-select text-center">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="appointment_type" id="video" value="video">
                                                        <label class="form-check-label" for="video">
                                                            <i class="isax isax-video5"></i>
                                                            <span class="service-title d-block">Video Call</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-xl col-md-3 col-sm-4">
                                                    <div class="radio-select text-center">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="appointment_type" id="voice" value="voice">
                                                        <label class="form-check-label" for="voice">
                                                            <i class="isax isax-call5"></i>
                                                            <span class="service-title d-block">Voice Call</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-xl col-md-3 col-sm-4">
                                                    <div class="radio-select text-center">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="appointment_type" id="chat" value="chat">
                                                        <label class="form-check-label" for="chat">
                                                            <i class="isax isax-messages-15"></i>
                                                            <span class="service-title d-block">Chat</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-xl col-md-3 col-sm-4">
                                                    <div class="radio-select text-center">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="appointment_type" id="Home" value="home">
                                                        <label class="form-check-label" for="Home">
                                                            <i class="isax isax-home-15"></i>
                                                            <span class="service-title d-block">Home visit</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-md btn-dark prev_btn rounded-pill">
                                                    <i class="isax isax-arrow-left-2 me-1"></i>Back
                                                </button>
                                                <button type="button" class="btn btn-md btn-primary-gradient next_btn rounded-pill">
                                                    Payment <i class="isax isax-arrow-right-3 ms-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- STEP 3: Payment -->
                                <fieldset class="step-fieldset">
                                    <div class="card booking-card mb-0">
                                        <div class="card-body booking-body">
                                            <div class="row">
                                                <!-- Payment Gateway -->
                                                <div class="col-lg-6 d-flex">
                                                    <div class="card flex-fill mb-3 mb-lg-0">
                                                        <div class="card-body">
                                                            <h6 class="mb-3">Payment Gateway</h6>
                                                            <div class="payment-tabs">
                                                                <ul class="nav nav-pills mb-3 row" id="pills-tab"
                                                                    role="tablist">
                                                                    <li class="nav-item col-sm-4" role="presentation">
                                                                        <button class="nav-link active" id="pills-mpesa-tab"
                                                                            data-bs-toggle="pill"
                                                                            data-bs-target="#pills-mpesa" type="button"
                                                                            role="tab" data-gateway="Airtel-Money">
                                                                            Airtel-Money
                                                                        </button>
                                                                    </li>
                                                                    <li class="nav-item col-sm-4" role="presentation">
                                                                        <button class="nav-link" id="pills-mix-tab"
                                                                            data-bs-toggle="pill"
                                                                            data-bs-target="#pills-mix" type="button"
                                                                            role="tab" data-gateway="Mix by Yas">
                                                                            Mix by Yas
                                                                        </button>
                                                                    </li>
                                                                    
                                                                </ul>
                                                                <div class="tab-content" id="pills-tabContent">
                                                                    <div class="tab-pane fade show active" id="pills-mpesa"
                                                                        role="tabpanel">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Phone Number</label>
                                                                            <div class="position-relative input-icon">
                                                                                <input type="tel" class="form-control payment-phone"
                                                                                    id="payment-phone-1" required
                                                                                    placeholder="255713693315"
                                                                                    value="<?php echo e(Auth::user()->phone ?? ''); ?>">
                                                                                <span><i class="isax isax-user"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="pills-mix"
                                                                        role="tabpanel">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Phone Number</label>
                                                                            <div class="position-relative input-icon">
                                                                                <input type="tel" class="form-control payment-phone"
                                                                                    id="payment-phone-2" required
                                                                                    placeholder="255713693315"
                                                                                    value="<?php echo e(Auth::user()->phone ?? ''); ?>">
                                                                                <span><i class="isax isax-user"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="appointment-picker">Select Appointment Date & Time</label>
                                                                    <input type="text" id="appointment-picker" class="form-control" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Booking Info Summary -->
                                                <div class="col-lg-6 d-flex">
                                                    <div class="card flex-fill mb-0">
                                                        <div class="card-body">
                                                            <h6 class="mb-3">Booking Info</h6>
                                                            <p><strong>Service:</strong> <span id="booking-service">-</span></p>
                                                            <p><strong>Appointment Type:</strong> <span id="booking-type">-</span></p>
                                                            <p><strong>Date & Time:</strong> <span id="booking-datetime">-</span></p>
                                                            <p><strong>Payment Method:</strong> <span id="booking-payment">Airtel-Money</span></p>

                                                            <h6 class="pt-3 border-top mb-2">Payment Info</h6>
                                                            <ul class="list-unstyled">
                                                                <li>Service: <span id="booking-service-price">-</span></li>
                                                                <li>Booking Fees: <span id="booking-fees">-</span></li>
                                                                <li>Tax: <span id="booking-tax">-</span></li>
                                                                <li>Discount: <span id="booking-discount">-</span></li>
                                                                <li class="fw-bold">Total: <span id="booking-total">-</span></li>
                                                            </ul>
                                                        </div>
                                                        <div class="card-footer d-flex justify-content-between">
                                                            <button type="button" class="btn btn-dark prev_btn">
                                                                <i class="isax isax-arrow-left-2 me-1"></i>Back
                                                            </button>
                                                            <button type="button" class="btn btn-primary-gradient" id="confirm-pay-btn">
                                                                <i class="isax isax-wallet me-1"></i>Confirm & Pay
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- STEP 4: Confirmation -->
                                <fieldset class="step-fieldset">
                                    <div class="card booking-card">
                                        <div class="card-body text-center">
                                            <div class="mb-4">
                                                <div class="success-icon">
                                                    <i class="isax isax-tick-circle5 text-success" style="font-size: 80px;"></i>
                                                </div>
                                                <h3 class="text-success mt-3">Payment Initiated!</h3>
                                                <p class="lead">Your appointment with Dr. <?php echo e($doctor->name); ?> is being processed.</p>
                                                <div class="alert alert-info mt-3">
                                                    <i class="isax isax-info-circle me-2"></i>
                                                    Please check your phone for USSD prompt to complete the payment.
                                                </div>
                                            </div>
                                            
                                            <div class="booking-details card mb-4">
                                                <div class="card-body">
                                                    <h5 class="mb-3">Appointment Details</h5>
                                                    <div class="row text-start">
                                                        <div class="col-md-6">
                                                            <p><strong>Doctor:</strong> Dr. <?php echo e($doctor->name); ?></p>
                                                            <p><strong>Date & Time:</strong> <span id="confirmation-datetime">-</span></p>
                                                            <p><strong>Service:</strong> <span id="confirmation-service">-</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Appointment Type:</strong> <span id="confirmation-type">-</span></p>
                                                            <p><strong>Total Amount:</strong> <span id="confirmation-total">-</span></p>
                                                            <p><strong>Payment Status:</strong> <span class="badge bg-warning">Pending</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="actions mt-4">
                                                <a href="<?php echo e(route('patient.appointment')); ?>" class="btn btn-primary btn-lg">
                                                    <i class="isax isax-calendar me-2"></i>View My Appointments
                                                </a>
                                                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary btn-lg ms-2">
                                                    <i class="isax isax-home me-2"></i>Back to Home
                                                </a>
                                            </div>
                                            
                                            <div class="mt-4">
                                                <p class="text-muted">
                                                    <i class="isax isax-info-circle me-1"></i>
                                                    You will receive a confirmation SMS once payment is completed.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0">Copyright © 2025. All Rights Reserved, Medical Sean</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/script.js')); ?>"></script>

   <script>
$(document).ready(function() {
    console.log('Document ready - initializing booking form');
    
    // Multi-step form navigation
    var currentStep = 0;
    var steps = $('.step-fieldset');
    var progressBar = $('#progressbar2 li');
    
    // Show current step
    function showStep(n) {
        console.log('Showing step:', n);
        steps.hide();
        $(steps[n]).show();
        
        // Update progress bar
        progressBar.removeClass('progress-active');
        $(progressBar[n]).addClass('progress-active');
        currentStep = n;
        
        // Scroll to top of form when changing steps
        $('html, body').animate({
            scrollTop: $('.booking-wizard').offset().top - 20
        }, 300);
    }
    
    // Next button click
    $('.next_btn').click(function() {
        console.log('Next button clicked, current step:', currentStep);
        // Validate current step before proceeding
        if (validateStep(currentStep)) {
            if (currentStep < steps.length - 1) {
                // Update booking summary before showing step 3
                if (currentStep === 1) {
                    console.log('Updating booking summary before step 3');
                    updateBookingSummary();
                }
                showStep(currentStep + 1);
            }
        }
    });
    
    // Previous button click
    $('.prev_btn').click(function() {
        console.log('Previous button clicked, current step:', currentStep);
        if (currentStep > 0) {
            showStep(currentStep - 1);
        }
    });
    
    // Validate step
    function validateStep(step) {
        console.log('Validating step:', step);
        var isValid = true;
        
        // Step 1 validation: Service time selected
        if (step === 0) {
            if (!$('input[name="service_time"]:checked').length) {
                showAlert('Please select a service time');
                isValid = false;
            }
        }
        
        // Step 2 validation: Appointment type selected
        if (step === 1) {
            if (!$('input[name="appointment_type"]:checked').length) {
                showAlert('Please select an appointment type');
                isValid = false;
            }
        }
        
        console.log('Step validation result:', isValid);
        return isValid;
    }
    
    // Validate payment step
    function validatePaymentStep() {
        console.log('Validating payment step');
        var isValid = true;
        var errorMessages = [];
        
        // Check appointment date/time
        var appointmentTime = $('#appointment-picker').val();
        if (!appointmentTime) {
            errorMessages.push('Please select appointment date and time');
            isValid = false;
        }
        
        // Check phone number for selected payment method
        var activeTab = $('.nav-link.active');
        var activeTabId = activeTab.attr('id');
        var phoneInputId = '';
        
        switch(activeTabId) {
            case 'pills-mpesa-tab':
                phoneInputId = '#payment-phone-1';
                break;
            case 'pills-mix-tab':
                phoneInputId = '#payment-phone-2';
                break;
            
        }
        
        if (phoneInputId) {
            var phoneValue = $(phoneInputId).val();
            if (!phoneValue) {
                errorMessages.push('Please enter your phone number for payment');
                isValid = false;
            } else if (!validatePhoneNumber(phoneValue)) {
                errorMessages.push('Please enter a valid phone number (format: 255XXXXXXXXX)');
                isValid = false;
            }
        }
        
        if (errorMessages.length > 0) {
            showAlert(errorMessages.join('<br>'));
        }
        
        console.log('Payment validation result:', isValid);
        return isValid;
    }
    
    // Validate phone number format
    function validatePhoneNumber(phone) {
        // Tanzanian phone number format: 255 followed by 9 digits
        var regex = /^255\d{9}$/;
        return regex.test(phone);
    }
    
    // Show alert message
    function showAlert(message, type = 'danger') {
        console.log('Showing alert:', message);
        // Remove any existing alerts
        $('#ajax-alert-container').empty();
        
        // Create new alert
        var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        var iconClass = type === 'success' ? 'isax-tick-circle' : 'isax-close-circle';
        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                        '<i class="isax ' + iconClass + ' me-2"></i>' +
                        message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';
        
        // Insert in alert container
        $('#ajax-alert-container').html(alertHtml);
        
        // Auto-remove after 5 seconds
        setTimeout(function() {
            $('#ajax-alert-container .alert').alert('close');
        }, 5000);
    }
    
    // Initialize datetime picker with SIMPLE format
    if ($.fn.datetimepicker) {
        $('#appointment-picker').datetimepicker({
            format: 'MM/DD/YYYY hh:mm A', // SIMPLER FORMAT
            sideBySide: true,
            minDate: moment(),
            icons: {
                time: 'fas fa-clock',
                date: 'fas fa-calendar',
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-calendar-check',
                clear: 'fas fa-trash',
                close: 'fas fa-times'
            }
        }).on('dp.change', function(e) {
            console.log('Date changed to:', e.date ? e.date.format('MM/DD/YYYY hh:mm A') : 'none');
            // Update hidden input when date changes
            if (e.date) {
                var formattedDate = e.date.format('MMM DD, YYYY [at] hh:mm A');
                $('#appointment-datetime-input').val(formattedDate);
                // Also update the summary if we're on step 3
                if (currentStep === 2) {
                    updateBookingSummary();
                }
            } else {
                $('#appointment-datetime-input').val('');
            }
        });
        console.log('Datetime picker initialized');
    } else {
        console.error('Datetime picker plugin not loaded');
    }
    
    // Update booking summary
    function updateBookingSummary() {
        console.log('Updating booking summary');
        
        // Service & price
        var serviceInput = $('input[name="service_time"]:checked');
        var serviceId = serviceInput.attr('id');
        var serviceLabel = $('label[for="' + serviceId + '"] .service-title').text() || '-';
        var servicePriceText = $('label[for="' + serviceId + '"] .fs-14').text() || 'Tsh 0';
        var servicePrice = parseInt(servicePriceText.replace(/[^\d]/g, '')) || 0;
        
        // Fix for service100 price display
        if (serviceId === 'service100') {
            servicePrice = 10000;
        }

        // Appointment type
        var appointmentInput = $('input[name="appointment_type"]:checked');
        var appointmentType = appointmentInput.val() ? 
            $('label[for="' + appointmentInput.attr('id') + '"] .service-title').text() : 'Not selected';
        var appointmentTypeValue = appointmentInput.val() || '';
        
        // Payment method
        var paymentMethod = $('#payment_gateway').val() || 'Airtel-Money';

        // Appointment date & time - GET FROM PICKER AND FORMAT PROPERLY
        var datetime = $('#appointment-picker').val() || '';
        // Convert to the format expected by backend
        if (datetime) {
            var momentDate = moment(datetime, 'MM/DD/YYYY hh:mm A');
            var formattedDateTime = momentDate.format('MMM DD, YYYY [at] hh:mm A');
            $('#appointment-datetime-input').val(formattedDateTime);
            $('#booking-datetime').text(formattedDateTime);
        } else {
            $('#appointment-datetime-input').val('');
            $('#booking-datetime').text('-');
        }
        
        // Payment info
        var fees = parseInt(serviceInput.data('fees')) || 0;
        var tax = parseInt(serviceInput.data('tax')) || 0;
        var discount = parseInt(serviceInput.data('discount')) || 0;
        var total = servicePrice + fees + tax - discount;

        // Update summary UI
        $('#booking-service').text(serviceLabel);
        $('#booking-service-price').text('Tsh ' + servicePrice.toLocaleString());
        $('#booking-type').text(appointmentType);
        $('#booking-payment').text(paymentMethod);
        $('#booking-fees').text('Tsh ' + fees.toLocaleString());
        $('#booking-tax').text('Tsh ' + tax.toLocaleString());
        $('#booking-discount').text('-Tsh ' + discount.toLocaleString());
        $('#booking-total').text('Tsh ' + total.toLocaleString());

        // Update hidden inputs
        $('#appointment-type-input').val(appointmentTypeValue);
        $('#service-price-input').val(servicePrice);
        $('#fees-input').val(fees);
        $('#tax-input').val(tax);
        $('#discount-input').val(discount);
        $('#total-input').val(total);
        $('#service-input').val(serviceLabel);
        $('#service-time-input').val(serviceInput.val());
        
        console.log('Booking summary updated:', {
            service: serviceLabel,
            price: servicePrice,
            total: total,
            datetime: datetime,
            formattedDateTime: $('#appointment-datetime-input').val(),
            appointmentType: appointmentTypeValue
        });
    }
    
    // Update confirmation details
    function updateConfirmationDetails() {
        $('#confirmation-service').text($('#booking-service').text());
        $('#confirmation-type').text($('#booking-type').text());
        $('#confirmation-datetime').text($('#booking-datetime').text());
        $('#confirmation-total').text($('#booking-total').text());
    }
    
    // Handle payment gateway selection
    $('#pills-tab button').on('shown.bs.tab', function(e) {
        var gateway = $(this).data('gateway');
        $('#payment_gateway').val(gateway);
        $('#booking-payment').text(gateway);
        
        // Update phone hidden field with value from active tab
        var activeTabId = $(this).attr('id');
        var phoneInputId = '';
        
        switch(activeTabId) {
            case 'pills-mpesa-tab':
                phoneInputId = '#payment-phone-1';
                break;
            case 'pills-mix-tab':
                phoneInputId = '#payment-phone-2';
                break;
            
        }
        
        if (phoneInputId) {
            $('#phone-hidden').val($(phoneInputId).val());
        }
        console.log('Payment gateway changed to:', gateway);
    });
    
    // Update phone number input
    $('.payment-phone').on('input', function() {
        var activeTab = $('.nav-link.active');
        var activeTabId = activeTab.attr('id');
        var currentPhoneInputId = '#' + $(this).attr('id');
        var phoneInputId = '';
        
        switch(activeTabId) {
            case 'pills-mpesa-tab':
                phoneInputId = '#payment-phone-1';
                break;
            case 'pills-mix-tab':
                phoneInputId = '#payment-phone-2';
                break;
            
        }
        
        // Only update if this is the active phone input
        if (currentPhoneInputId === phoneInputId) {
            $('#phone-hidden').val($(this).val());
        }
    });
    
    // Live updates when service or appointment type changes
    $('input[name="service_time"], input[name="appointment_type"]').change(function() {
        console.log('Service or appointment type changed');
        if (currentStep === 2) {
            updateBookingSummary();
        }
    });
    
    // Form submission - show loading and handle response
    $('#confirm-pay-btn').click(function(e) {
        e.preventDefault();
        console.log('Confirm & Pay button clicked');
        
        // If we're on step 3 (payment), validate payment step
        if (currentStep === 2) {
            if (!validatePaymentStep()) {
                // Stay on current step if validation fails
                console.log('Payment validation failed');
                return false;
            }
            
            // Ensure all hidden fields are updated before submission
            updateBookingSummary();
            
            // Double-check that all required fields are set
            var appointmentDatetime = $('#appointment-datetime-input').val();
            var phone = $('#phone-hidden').val();
            var total = $('#total-input').val();
            
            console.log('Final check before submission:', {
                appointmentDatetime: appointmentDatetime,
                phone: phone,
                total: total
            });
            
            if (!appointmentDatetime || !phone || !total) {
                showAlert('Please complete all required fields');
                return false;
            }
            
            // Show loading state on the submit button
            var submitBtn = $(this);
            var originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing Payment...'
            );
            
            // Get form data as regular form submission (not FormData)
            var form = $('#booking-form');
            var formData = form.serialize();
            
            console.log('Submitting form data:', formData);
            
            // Submit form via AJAX
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('AJAX success response:', response);
                    
                    if (response.success) {
                        // Show success message
                        showAlert(response.message || 'Booking created successfully!', 'success');
                        
                        // Update confirmation details
                        updateConfirmationDetails();
                        
                        // Show confirmation step
                        showStep(3);
                        
                        // If there's a redirect, navigate after delay
                        if (response.redirect) {
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 3000);
                        }
                    } else {
                        // Show error messages from response
                        var errorMessages = [];
                        if (response.errors) {
                            for (var field in response.errors) {
                                if (Array.isArray(response.errors[field])) {
                                    errorMessages.push(response.errors[field].join('<br>'));
                                } else {
                                    errorMessages.push(response.errors[field]);
                                }
                            }
                        }
                        showAlert(errorMessages.length > 0 ? errorMessages.join('<br>') : 'An error occurred.', 'danger');
                        
                        // Reset button state
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', xhr, status, error);
                    console.error('Response text:', xhr.responseText);
                    
                    // Reset button state
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    var errorMessage = 'An error occurred while processing your payment. Please try again.';
                    
                    try {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = [];
                            
                            for (var field in errors) {
                                if (Array.isArray(errors[field])) {
                                    errorMessages.push(errors[field].join('<br>'));
                                } else {
                                    errorMessages.push(errors[field]);
                                }
                            }
                            
                            if (errorMessages.length > 0) {
                                errorMessage = errorMessages.join('<br>');
                            }
                        } else if (xhr.status === 422) {
                            var response = JSON.parse(xhr.responseText);
                            var errors = response.errors || {};
                            var errorMessages = [];
                            for (var field in errors) {
                                if (Array.isArray(errors[field])) {
                                    errorMessages.push(errors[field].join('<br>'));
                                } else {
                                    errorMessages.push(errors[field]);
                                }
                            }
                            errorMessage = errorMessages.join('<br>') || 'Validation failed.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Server error. Please try again later. Check console for details.';
                        }
                    } catch (e) {
                        console.error('Error parsing error response:', e);
                    }
                    
                    showAlert(errorMessage, 'danger');
                }
            });
            
            return false;
        }
        
        // If not on step 3, go to step 3 first
        if (currentStep < 2) {
            console.log('Not on payment step, moving to step 3');
            showStep(2);
            return false;
        }
    });
    
    // Initialize the form
    showStep(0);
    
    // Auto-select first appointment type if none selected
    if (!$('input[name="appointment_type"]:checked').length) {
        $('input[name="appointment_type"]:first').prop('checked', true);
        console.log('Auto-selected first appointment type');
    }
    
    // Set initial phone value from hidden field
    var initialPhone = $('#phone-hidden').val();
    if (initialPhone) {
        $('#payment-phone-1').val(initialPhone);
        $('#payment-phone-2').val(initialPhone);
        $('#payment-phone-3').val(initialPhone);
        console.log('Pre-filled phone numbers');
    }
    
    console.log('Booking form initialized successfully');
});
</script>
</body>
</html><?php /**PATH /home/u881803686/domains/medicalsean.org/public_html/resources/views/patient/booking.blade.php ENDPATH**/ ?>