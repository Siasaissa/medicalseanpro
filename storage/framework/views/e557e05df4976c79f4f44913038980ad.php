<?php echo $__env->make('layouts.adminHead', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body>
<div class="main-wrapper">
    <?php echo $__env->make('layouts.adminHeader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.adminSidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Appointments Control Panel</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Appointments</li>
                        </ul>
                    </div>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('admin.appointment')); ?>" class="row g-2 mb-3">
                        <div class="col-md-4">
                            <input type="text" name="q" class="form-control" placeholder="Search booking ID / doctor / patient" value="<?php echo e($filters['q'] ?? ''); ?>">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <?php $__currentLoopData = $bookingStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($statusOption); ?>" <?php if(strtoupper($filters['status'] ?? '') === $statusOption): echo 'selected'; endif; ?>><?php echo e($statusOption); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="type" class="form-control">
                                <option value="">All Types</option>
                                <?php $__currentLoopData = ['video','voice','chat','home']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($typeOption); ?>" <?php if(($filters['type'] ?? '') === $typeOption): echo 'selected'; endif; ?>><?php echo e(ucfirst($typeOption)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="from" class="form-control" value="<?php echo e($filters['from'] ?? ''); ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="to" class="form-control" value="<?php echo e($filters['to'] ?? ''); ?>">
                        </div>
                        <div class="col-12 d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="<?php echo e(route('admin.appointment')); ?>" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Booking</th>
                                    <th>Doctor</th>
                                    <th>Patient</th>
                                    <th>Type</th>
                                    <th>Appointment Time</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $doctorAvatar = $appo->doctor?->profile?->dp ? asset($appo->doctor->profile->dp) : asset('images/default.jpeg');
                                        $patientAvatar = $appo->patient?->profile?->dp ? asset($appo->patient->profile->dp) : asset('images/default.jpeg');
                                        $status = strtoupper((string) $appo->status);
                                    ?>
                                    <tr>
                                        <td>#APT<?php echo e(str_pad($appo->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="<?php echo e($doctorAvatar); ?>" alt="Doctor"></a>
                                                <a href="javascript:void(0);">Dr. <?php echo e($appo->doctor?->name ?? 'N/A'); ?></a>
                                            </h2>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="<?php echo e($patientAvatar); ?>" alt="Patient"></a>
                                                <a href="javascript:void(0);"><?php echo e($appo->patient?->name ?? 'N/A'); ?></a>
                                            </h2>
                                        </td>
                                        <td><span class="badge bg-info"><?php echo e(strtoupper($appo->appointment_type)); ?></span></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($appo->appointment_datetime)->format('d M Y h:i A')); ?></td>
                                        <td>Tsh <?php echo e(number_format((float) $appo->total, 2)); ?></td>
                                        <td>
                                            <span class="badge rounded-pill <?php echo e(in_array($status, ['SUCCESS','PAID','COMPLETED']) ? 'bg-success' : (in_array($status, ['PENDING','PROCESSING','ACTIVE']) ? 'bg-warning text-dark' : 'bg-danger')); ?>">
                                                <?php echo e($status); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="<?php echo e(route('admin.bookings.status', $appo)); ?>" class="d-flex gap-2 align-items-center">
                                                <?php echo csrf_field(); ?>
                                                <select name="status" class="form-select form-select-sm" style="min-width: 150px;">
                                                    <?php $__currentLoopData = $bookingStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($statusOption); ?>" <?php if($status === $statusOption): echo 'selected'; endif; ?>><?php echo e($statusOption); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No appointments found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <?php echo e($appointment->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.slimscroll.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/script.js')); ?>"></script>
</body>
</html>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/appointment.blade.php ENDPATH**/ ?>