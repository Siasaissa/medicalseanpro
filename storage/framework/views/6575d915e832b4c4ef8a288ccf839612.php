<?php echo $__env->make('layouts.adminHead', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body>
<div class="main-wrapper">
    <?php echo $__env->make('layouts.adminHeader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.adminSidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="page-title">Admin Control Center</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-primary border-primary"><i class="fe fe-users"></i></span>
                                <div class="dash-count"><h3><?php echo e($doctor); ?></h3></div>
                            </div>
                            <div class="dash-widget-info"><h6 class="text-muted">Doctors</h6></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-success border-success"><i class="fe fe-user"></i></span>
                                <div class="dash-count"><h3><?php echo e($patient); ?></h3></div>
                            </div>
                            <div class="dash-widget-info"><h6 class="text-muted">Patients</h6></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-danger border-danger"><i class="fe fe-calendar"></i></span>
                                <div class="dash-count"><h3><?php echo e($booking); ?></h3></div>
                            </div>
                            <div class="dash-widget-info"><h6 class="text-muted">Bookings</h6></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-warning border-warning"><i class="fe fe-dollar-sign"></i></span>
                                <div class="dash-count"><h6>Tsh <?php echo e(number_format((float) $revenue, 2)); ?></h6></div>
                            </div>
                            <div class="dash-widget-info"><h6 class="text-muted">Total Revenue</h6></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Quick Controls</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="<?php echo e(route('admin.doctorList')); ?>" class="btn btn-outline-primary">Manage Doctors</a>
                                <a href="<?php echo e(route('admin.patientList')); ?>" class="btn btn-outline-primary">Manage Patients</a>
                                <a href="<?php echo e(route('admin.appointment')); ?>" class="btn btn-outline-primary">Manage Bookings</a>
                                <a href="<?php echo e(route('admin.Transaction')); ?>" class="btn btn-outline-primary">Manage Transactions</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0">Recent Bookings</h5></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Doctor</th>
                                            <th>Patient</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php $status = strtoupper((string) $b->status); ?>
                                            <tr>
                                                <td>#APT<?php echo e(str_pad($b->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                                <td><?php echo e($b->doctor?->name ?? 'N/A'); ?></td>
                                                <td><?php echo e($b->patient?->name ?? 'N/A'); ?></td>
                                                <td><?php echo e($status); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr><td colspan="4" class="text-muted text-center">No bookings yet.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0">Recent Transactions</h5></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td>#ORD<?php echo e(str_pad($t->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                                <td><?php echo e($t->user?->name ?? 'Guest'); ?></td>
                                                <td>Tsh <?php echo e(number_format((float) $t->total, 2)); ?></td>
                                                <td><?php echo e(strtoupper((string) $t->status)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr><td colspan="4" class="text-muted text-center">No transactions yet.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo e(asset('admincss/js/jquery-3.7.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('admincss/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('admincss/js/jquery.slimscroll.min.js')); ?>"></script>
<script src="<?php echo e(asset('admincss/js/script.js')); ?>"></script>
</body>
</html>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>