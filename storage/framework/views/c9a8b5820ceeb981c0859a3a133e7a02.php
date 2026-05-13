<?php echo $__env->make('layouts.adminHead', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body>
    <div class="main-wrapper">
        <?php echo $__env->make('layouts.adminHeader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.adminSidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Patients</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Admin</a></li>
                                <li class="breadcrumb-item active">Patient Directory</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="<?php echo e(route('admin.patientList')); ?>" class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Search</label>
                                <input type="text" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" class="form-control" placeholder="Name, email, phone, address">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php if(($filters['status'] ?? '') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Go</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Patient Accounts</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Bookings</th>
                                        <th>Status</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo e($patient->name); ?></strong><br>
                                                <small class="text-muted"><?php echo e($patient->email); ?></small>
                                            </td>
                                            <td><?php echo e($patient->profile?->phone_numbers ?? 'Not set'); ?></td>
                                            <td><?php echo e($patient->profile?->address ?? 'Not set'); ?></td>
                                            <td><?php echo e($patient->patientBookings->count()); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e(($patient->profile?->status ?? 'inactive') === 'active' ? 'success' : (($patient->profile?->status ?? 'inactive') === 'suspended' ? 'danger' : 'warning')); ?>-light">
                                                    <?php echo e(ucfirst($patient->profile?->status ?? 'inactive')); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <form action="<?php echo e(route('admin.users.status', $patient)); ?>" method="POST" class="d-flex gap-2">
                                                    <?php echo csrf_field(); ?>
                                                    <select name="status" class="form-control form-control-sm">
                                                        <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($status); ?>" <?php if(($patient->profile?->status ?? 'inactive') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <button class="btn btn-sm btn-primary">Save</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No patients found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <?php echo e($patients->links()); ?>

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
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/patientList.blade.php ENDPATH**/ ?>