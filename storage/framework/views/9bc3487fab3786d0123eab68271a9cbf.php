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
                            <h3 class="page-title">Doctors Control Panel</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Doctors</li>
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

            <div class="card">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('admin.doctorList')); ?>" class="row g-2 mb-3">
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control" placeholder="Search name, email, ID, speciality, phone" value="<?php echo e($filters['q'] ?? ''); ?>">
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
                            <a href="<?php echo e(route('admin.doctorList')); ?>" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Speciality</th>
                                    <th>Phone</th>
                                    <th>Member Since</th>
                                    <th>Total Earned</th>
                                    <th>Current Status</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $profile = $doc->profile;
                                        $avatar = $profile?->dp ? asset($profile->dp) : asset('images/default.jpeg');
                                        $currentStatus = strtolower($profile?->status ?? 'inactive');
                                        $earned = $doc->doctorBookings
                                            ->whereIn('status', ['SUCCESS', 'PAID'])
                                            ->sum('total');
                                    ?>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript:void(0);" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="<?php echo e($avatar); ?>" alt="Doctor Image">
                                                </a>
                                                <a href="javascript:void(0);">Dr. <?php echo e($doc->name); ?><br><small><?php echo e($doc->email); ?></small></a>
                                            </h2>
                                        </td>
                                        <td><?php echo e($profile?->speciality ?? 'Not set'); ?></td>
                                        <td><?php echo e($profile?->phone_numbers ?? 'Not set'); ?></td>
                                        <td><?php echo e(optional($doc->created_at)->format('d M Y')); ?></td>
                                        <td>Tsh <?php echo e(number_format($earned, 2)); ?></td>
                                        <td>
                                            <span class="badge rounded-pill <?php echo e($currentStatus === 'active' ? 'bg-success' : ($currentStatus === 'suspended' ? 'bg-danger' : 'bg-secondary')); ?>">
                                                <?php echo e(ucfirst($currentStatus)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="<?php echo e(route('admin.users.status', $doc)); ?>" class="d-flex gap-2 align-items-center">
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
                                        <td colspan="7" class="text-center text-muted">No doctors found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <?php echo e($doctors->links()); ?>

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
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/doctorList.blade.php ENDPATH**/ ?>