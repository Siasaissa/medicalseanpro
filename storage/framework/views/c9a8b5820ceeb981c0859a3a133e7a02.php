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
                        <h3 class="page-title">Patients Control Panel</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Patients</li>
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
                    <form method="GET" action="<?php echo e(route('admin.patientList')); ?>" class="row g-2 mb-3">
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control" placeholder="Search name, email, ID, phone, address" value="<?php echo e($filters['q'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($statusOption); ?>" <?php if(($filters['status'] ?? '') === $statusOption): echo 'selected'; endif; ?>><?php echo e(ucfirst($statusOption)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="<?php echo e(route('admin.patientList')); ?>" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>Patient</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Last Booking</th>
                                    <th>Total Paid</th>
                                    <th>Current Status</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $profile = $pat->profile;
                                        $avatar = $profile?->dp ? asset($profile->dp) : asset('images/default.jpeg');
                                        $currentStatus = strtolower($profile?->status ?? 'inactive');
                                        $lastBooking = $pat->patientBookings->sortByDesc('appointment_datetime')->first();
                                        $paidTotal = $pat->patientBookings->whereIn('status', ['SUCCESS', 'PAID'])->sum('total');
                                    ?>
                                    <tr>
                                        <td>#PT<?php echo e(str_pad($pat->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript:void(0);" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="<?php echo e($avatar); ?>" alt="Patient Image">
                                                </a>
                                                <a href="javascript:void(0);"><?php echo e($pat->name); ?><br><small><?php echo e($pat->email); ?></small></a>
                                            </h2>
                                        </td>
                                        <td><?php echo e($profile?->phone_numbers ?? 'Not set'); ?></td>
                                        <td><?php echo e($profile?->address ?? 'Not set'); ?></td>
                                        <td><?php echo e($lastBooking ? \Carbon\Carbon::parse($lastBooking->appointment_datetime)->format('d M Y h:i A') : 'No bookings yet'); ?></td>
                                        <td>Tsh <?php echo e(number_format($paidTotal, 2)); ?></td>
                                        <td>
                                            <span class="badge rounded-pill <?php echo e($currentStatus === 'active' ? 'bg-success' : ($currentStatus === 'suspended' ? 'bg-danger' : 'bg-secondary')); ?>">
                                                <?php echo e(ucfirst($currentStatus)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="<?php echo e(route('admin.users.status', $pat)); ?>" class="d-flex gap-2 align-items-center">
                                                <?php echo csrf_field(); ?>
                                                <select name="status" class="form-select form-select-sm" style="min-width: 130px;">
                                                    <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($statusOption); ?>" <?php if($currentStatus === $statusOption): echo 'selected'; endif; ?>><?php echo e(ucfirst($statusOption)); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No patients found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <?php echo e($patients->links()); ?>

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
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/patientList.blade.php ENDPATH**/ ?>