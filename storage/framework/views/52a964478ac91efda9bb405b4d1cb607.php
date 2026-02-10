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
                                            <h6>Specialty</h6>
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
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <!--  Form starts here -->
                        <form action="<?php echo e(route('patient.booking.store', $doctor->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">
                            <input type="hidden" name="doctor_id" value="<?php echo e($doctor->id); ?>">
                            <input type="hidden" name="appointment_datetime" id="appointment-datetime-input">
                            <input type="hidden" name="service_price" id="service-price-input">
                            <input type="hidden" name="fees" id="fees-input">
                            <input type="hidden" name="tax" id="tax-input">
                            <input type="hidden" name="discount" id="discount-input">
                            <input type="hidden" name="total" id="total-input">
                            <input type="hidden" id="payment_gateway" name="payment_gateway" value="">
                            <input type="hidden" id="phone-hidden" name="phone" value="">
                            <input type="hidden" name="service" id="service-input" value="">
                            <input type="hidden" name="service_time" id="service-time-input" value="">

                            <div class="booking-widget multistep-form mb-5">

                                <!-- STEP 1: Service Time -->
                                <fieldset id="first">
                                    <div class="card booking-card mb-0">
                                        <div class="card-header">
                                            <div class="booking-header pb-0">
                                                <div class="card mb-0">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center flex-wrap">
                                                            <span class="avatar avatar-xxxl avatar-rounded me-2"><img src="<?php echo e(asset($doctor->profile->dp)); ?>" alt="User Image">></span>
                                                            <div>
                                                                <h4 class="mb-1"><?php echo e($doctor->name); ?>

                                                                    <span class="badge bg-orange fs-12"><i
                                                                            class="fa-solid fa-star me-1"></i>5.0</span>
                                                                </h4>
                                                                <p class="text-indigo mb-3 fw-medium"><?php echo e($doctor->profile->speciality ?? 'No speciality'); ?></p>
                                                                <p class="mb-0"><i
                                                                        class="isax isax-location me-2"></i><?php echo e($doctor->profile->address ?? 'No Addrress'); ?></p>
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
                                                            data-price="310" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service20">
                                                            <span class="service-title d-block mb-1">20 minutes</span>
                                                            <span class="fs-14 d-block">Tsh 310</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service40" value="40"
                                                            data-price="754" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service40">
                                                            <span class="service-title d-block mb-1">40 minutes</span>
                                                            <span class="fs-14 d-block">Tsh 754</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">

                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service60" value="60"
                                                            data-price="1050" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service60">
                                                            <span class="service-title d-block mb-1">1 hour</span>
                                                            <span class="fs-14 d-block">Tsh 1050</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">

                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service80" value="80"
                                                            data-price="1300" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service80">
                                                            <span class="service-title d-block mb-1">1 hour 20 minutes</span>
                                                            <span class="fs-14 d-block">Tsh 1300</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">

                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service100" value="100"
                                                            data-price="1500" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service100">
                                                            <span class="service-title d-block mb-1">1 hour 40 minutes</span>
                                                            <span class="fs-14 d-block">Tsh 1500</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">

                                                    <div class="service-item">
                                                        <input class="form-check-input ms-0 mt-0" type="radio"
                                                            name="service_time" id="service120" value="120"
                                                            data-price="2000" data-fees="20" data-tax="18"
                                                            data-discount="15">
                                                        <label class="form-check-label ms-2" for="service120">
                                                            <span class="service-title d-block mb-1">2 hours</span>
                                                            <span class="fs-14 d-block">Tsh 2000</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-md btn-dark rounded-pill"><i
                                                        class="isax isax-arrow-left-2 me-1"></i>Back</a>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-md btn-primary-gradient next_btns rounded-pill">Select
                                                    Appointment Type <i class="isax isax-arrow-right-3 ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- STEP 2: Appointment Type -->
                                <fieldset>
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
                                                            name="appointment_type" id="Home" value="Home">
                                                        <label class="form-check-label" for="Home">
                                                            <i class="isax isax-home-15"></i>
                                                            <span class="service-title d-block">Home visit</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- repeat audio, chat, home visit -->
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-md btn-dark prev_btns rounded-pill"><i
                                                        class="isax isax-arrow-left-2 me-1"></i>Back</a>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-md btn-primary-gradient next_btns rounded-pill">Payment
                                                    <i class="isax isax-arrow-right-3 ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- STEP 3: Payment -->
                                <!-- STEP 3: Payment -->
                                <fieldset>
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
                                                                    <button class="nav-link active" id="pills-home-tab"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#pills-home" type="button"
                                                                        role="tab">
                                                                        <img src="images/payment-icon-05.svg"
                                                                            class="me-2" alt=""> M-Pesa
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item col-sm-4" role="presentation">
                                                                    <button class="nav-link" id="pills-profile-tab"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#pills-profile" type="button"
                                                                        role="tab">
                                                                        <img src="images/payment-icon-06.svg"
                                                                            class="me-2" alt=""> Mix by Yas
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item col-sm-4" role="presentation">
                                                                    <button class="nav-link" id="pills-contact-tab"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#pills-contact" type="button"
                                                                        role="tab">
                                                                        <img src="images/payment-icon-07.svg"
                                                                            class="me-2" alt=""> Halopesa
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content" id="pills-tabContent">
                                                                <div class="tab-pane fade show active" id="pills-home"
                                                                    role="tabpanel">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Phone Number</label>
                                                                        <div class="position-relative input-icon">
                                                                            <input type="number" class="form-control"
                                                                                id="payment-phone-1">
                                                                            <span><i class="isax isax-user"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="pills-profile"
                                                                    role="tabpanel">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Phone Number</label>
                                                                        <div class="position-relative input-icon">
                                                                            <input type="number" class="form-control"
                                                                                id="payment-phone-2">
                                                                            <span><i class="isax isax-user"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="pills-contact"
                                                                    role="tabpanel">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Phone Number</label>
                                                                        <div class="position-relative input-icon">
                                                                            <input type="number" class="form-control"
                                                                                id="payment-phone-3">
                                                                            <span><i class="isax isax-user"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="appointment-picker">Select Appointment Date & Time</label>
                                                                <input type="text" id="appointment-picker" class="form-control">
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
                                                        <p><strong>Service:</strong> <span id="booking-service">-</span>
                                                        </p>
                                                        <p><strong>Appointment Type:</strong> <span
                                                                id="booking-type">-</span></p>
                                                        <p><strong>Date & Time:</strong> <span
                                                                id="booking-datetime">-</span></p>
                                                        <p><strong>Payment Method:</strong> <span
                                                                id="booking-payment">-</span></p>

                                                        <h6 class="pt-3 border-top mb-2">Payment Info</h6>
                                                        <ul class="list-unstyled">
                                                            <li>Service: <span id="booking-service-price">-</span></li>
                                                            <li>Booking Fees: <span id="booking-fees">-</span></li>
                                                            <li>Tax: <span id="booking-tax">-</span></li>
                                                            <li>Discount: <span id="booking-discount">-</span></li>
                                                            <li>Total: <span id="booking-total">-</span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-footer d-flex justify-content-between">
                                                        <a href="#"
                                                            class="btn btn-dark prev_btns">Back</a>
                                                        <button type="submit" class="btn btn-primary-gradient">Confirm &
                                                            Pay</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </fieldset>


                                <!-- STEP 4: Confirmation -->
                                <fieldset>
                                    <div class="card booking-card">
                                        <div class="card-body">
                                            <h5 class="text-success"><i class="isax isax-tick-circle5 me-2"></i>Booking
                                                Confirmed</h5>
                                            <p>Your booking with Dr. <?php echo e($doctor->name); ?> is confirmed.</p>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>

                        <div class="text-center">
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

    // Initialize datetime picker for user selection
$('#appointment-picker').datetimepicker({
    format: 'MMM DD, YYYY [at] hh:mm A', // 👈 matches your Carbon format
    sideBySide: true,
    minDate: moment()
});

    // Update booking summary and hidden inputs
    function updateBookingSummary() {
        // Service & price
        var serviceInput = $('input[name="service_time"]:checked');
        var serviceId = serviceInput.attr('id');
        var serviceLabel = $('label[for="' + serviceId + '"] .service-title').text() || '-';
        var servicePriceText = $('label[for="' + serviceId + '"] .fs-14').text() || 'Tsh 0';
        var servicePrice = parseInt(servicePriceText.replace(/[^\d]/g, '')) || 0;

        // Appointment type
        var appointmentInput = $('input[name="appointment_type"]:checked');
        var appointmentId = appointmentInput.attr('id');
        var appointmentType = $('label[for="' + appointmentId + '"] .service-title').text() || 'Not selected';
        var paymentMethod = $('#payment_gateway').val() || 'Not selected';

        // Appointment date & time from picker
        var datetime = $('#appointment-picker').val() || '';
        $('#booking-datetime').text(datetime);

        // Payment info (from data attributes)
        var fees = parseInt(serviceInput.data('fees')) || 0;
        var tax = parseInt(serviceInput.data('tax')) || 0;
        var discount = parseInt(serviceInput.data('discount')) || 0;
        var total = servicePrice + fees + tax - discount;

        // --- Update summary text (UI) ---
        $('#booking-service').text(serviceLabel);
        $('#booking-service-price').text('Tsh ' + servicePrice);
        $('#booking-type').text(appointmentType);
        $('#booking-fees').text('Tsh ' + fees);
        $('#booking-tax').text('Tsh ' + tax);
        $('#booking-discount').text('-Tsh ' + discount);
        $('#booking-total').text('Tsh ' + total);
        $('#booking-payment').text(paymentMethod);
        $('#service-time-input').val(serviceInput.val());

        // --- Update hidden inputs (form submission) ---
        $('#appointment-datetime-input').val(datetime);
        $('#service-price-input').val(servicePrice);
        $('#fees-input').val(fees);
        $('#tax-input').val(tax);
        $('#discount-input').val(discount);
        $('#total-input').val(total);
        $('#service-input').val(serviceLabel);
    }

    // Update summary when entering Step 3
    $('.next_btns').click(function () {
        var currentStep = $(this).closest('fieldset').index();
        if (currentStep === 1) { // Step 2 → Step 3
            updateBookingSummary();
        }
    });

    // Handle payment gateway selection
    $('#pills-tab button').on('shown.bs.tab', function (e) {
        var selectedText = $(e.target).text().trim();
        $('#payment_gateway').val(selectedText);
    });

    // Update hidden phone input
    $('input[id^="payment-phone"]').on('input', function () {
        $('#phone-hidden').val($(this).val());
    });

    // Whenever a service radio button changes, update hidden input immediately
    $('input[name="service_time"]').change(function () {
        var serviceId = $(this).attr('id');
        var serviceLabel = $('label[for="' + serviceId + '"] .service-title').text() || '-';
        $('#service-input').val(serviceLabel);
    });

    // Live update if service or appointment type changes
    $('input[name="service_time"], input[name="appointment_type"]').change(updateBookingSummary);

    // Ensure all hidden fields are updated before submitting the form
    $('form').on('submit', function () {
        updateBookingSummary();
    });

    // -------------------
    // Countdown timer
    // -------------------
    function startCountdown() {
        const serviceMinutes = parseInt($('input[name="service_time"]:checked').val()) || 0;
        const appointmentDateStr = $('#appointment-picker').val();
        if (!appointmentDateStr) return;

        const appointmentStart = new Date(appointmentDateStr);
        const endTime = new Date(appointmentStart.getTime() + serviceMinutes * 60 * 1000);
        const countdownEl = document.getElementById('countdown');

        function updateCountdown() {
            const now = new Date();
            const remaining = endTime - now;

            if (remaining <= 0) {
                countdownEl.innerText = "Time’s up! Ending call...";
                setTimeout(() => {
                    alert("Your consultation time has ended.");
                    window.location.href = "<?php echo e(route('patient.appointment')); ?>";
                }, 2000);
                clearInterval(timerInterval);
                return;
            }

            const hours = Math.floor((remaining / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((remaining / (1000 * 60)) % 60);
            const seconds = Math.floor((remaining / 1000) % 60);

            countdownEl.innerText =
                `${hours > 0 ? hours + 'h ' : ''}${minutes}m ${seconds}s`;
        }

        updateCountdown(); // run once immediately
        const timerInterval = setInterval(updateCountdown, 1000);
    }

    // Start countdown whenever service or appointment time changes
    $('input[name="service_time"], #appointment-picker').change(startCountdown);
});
</script>


</body>

</html><?php /**PATH /Users/dope/Documents/sean/sean/resources/views/patient/booking.blade.php ENDPATH**/ ?>