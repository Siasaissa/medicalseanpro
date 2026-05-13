<?php echo $__env->make('layouts.adminHead', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $statusColors = [
        'PENDING' => 'warning',
        'PROCESSING' => 'info',
        'SUCCESS' => 'success',
        'FAILED' => 'danger',
        'PAID' => 'primary',
        'ACTIVE' => 'secondary',
        'COMPLETED' => 'success',
        'CANCELLED' => 'dark',
    ];
?>

<body>
    <div class="main-wrapper">
        <?php echo $__env->make('layouts.adminHeader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.adminSidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Appointments</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Admin</a></li>
                                <li class="breadcrumb-item active">Appointments</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="<?php echo e(route('admin.appointment')); ?>" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" class="form-control" placeholder="Booking ID, name, email">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $bookingStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php if(($filters['status'] ?? '') === $status): echo 'selected'; endif; ?>><?php echo e($status); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-control">
                                    <option value="">All</option>
                                    <option value="video" <?php if(($filters['type'] ?? '') === 'video'): echo 'selected'; endif; ?>>Video</option>
                                    <option value="voice" <?php if(($filters['type'] ?? '') === 'voice'): echo 'selected'; endif; ?>>Voice</option>
                                    <option value="home" <?php if(($filters['type'] ?? '') === 'home'): echo 'selected'; endif; ?>>Home</option>
                                    <option value="chat" <?php if(($filters['type'] ?? '') === 'chat'): echo 'selected'; endif; ?>>Chat</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">From</label>
                                <input type="date" name="from" value="<?php echo e($filters['from'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">To</label>
                                <input type="date" name="to" value="<?php echo e($filters['to'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Appointment List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Booking</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Type</th>
                                        <th>Schedule</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>#APT<?php echo e(str_pad($item->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                            <td>
                                                <strong><?php echo e($item->patient->name ?? 'N/A'); ?></strong><br>
                                                <small class="text-muted"><?php echo e($item->patient->email ?? 'No email'); ?></small>
                                            </td>
                                            <td>
                                                <strong><?php echo e($item->doctor->name ?? 'N/A'); ?></strong><br>
                                                <small class="text-muted"><?php echo e($item->doctor->email ?? 'No email'); ?></small>
                                            </td>
                                            <td><?php echo e(ucfirst($item->appointment_type ?? 'N/A')); ?></td>
                                            <td><?php echo e($item->appointment_datetime ? \Carbon\Carbon::parse($item->appointment_datetime)->format('d M Y, h:i A') : 'N/A'); ?></td>
                                            <td>TSh <?php echo e(number_format((float) ($item->total ?? 0), 0)); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($statusColors[$item->status ?? ''] ?? 'secondary'); ?>-light">
                                                    <?php echo e($item->status ?? 'N/A'); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <form action="<?php echo e(route('admin.bookings.status', $item)); ?>" method="POST" class="d-flex gap-2">
                                                    <?php echo csrf_field(); ?>
                                                    <select name="status" class="form-control form-control-sm">
                                                        <?php $__currentLoopData = $bookingStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($status); ?>" <?php if(($item->status ?? '') === $status): echo 'selected'; endif; ?>><?php echo e($status); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <button class="btn btn-sm btn-primary">Save</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">No appointments matched your filters.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <?php echo e($appointment->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('admincss/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admincss/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admincss/js/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admincss/js/script.js')); ?>"></script>
</body>
</html>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/appointment.blade.php ENDPATH**/ ?>