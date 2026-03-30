<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body>
<div class="main-wrapper">
    <?php echo $__env->make('layouts.doctorHeader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Home Visit Details</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3">Appointment #APT000<?php echo e($booking->id); ?></h4>
                    <p><strong>Doctor:</strong> <?php echo e($booking->doctor->name); ?></p>
                    <p><strong>Patient:</strong> <?php echo e($booking->patient->name); ?></p>
                    <p><strong>Date & Time:</strong> <?php echo e(\Carbon\Carbon::parse($booking->appointment_datetime)->format('d M Y h:i A')); ?></p>
                    <p><strong>Type:</strong> Home Visit</p>
                    <p><strong>Status:</strong> <?php echo e(strtoupper($booking->status ?? 'PENDING')); ?></p>
                    <p class="mb-4"><strong>Patient Contact:</strong> <?php echo e($booking->patient->phone ?? $booking->patient->profile?->phone_numbers ?? 'Not provided'); ?></p>

                    <a href="<?php echo e(route('doctor.appointment')); ?>" class="btn btn-primary">Back to Appointments</a>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
</body>
</html>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/doctor/home.blade.php ENDPATH**/ ?>