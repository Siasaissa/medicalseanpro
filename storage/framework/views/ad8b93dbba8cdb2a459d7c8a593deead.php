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
                        <h3 class="page-title">Transactions Hub</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Transactions</li>
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

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted mb-1">Booking Revenue</h6>
                            <h4 class="mb-0">Tsh <?php echo e(number_format($totals['booking'] ?? 0, 2)); ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted mb-1">Pharmacy Revenue</h6>
                            <h4 class="mb-0">Tsh <?php echo e(number_format($totals['pharmacy'] ?? 0, 2)); ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted mb-1">Combined Revenue</h6>
                            <h4 class="mb-0">Tsh <?php echo e(number_format(($totals['booking'] ?? 0) + ($totals['pharmacy'] ?? 0), 2)); ?></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('admin.Transaction')); ?>" class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="q" class="form-control" value="<?php echo e($filters['q'] ?? ''); ?>" placeholder="Search by ID, name, email, phone">
                        </div>
                        <div class="col-md-2">
                            <select name="source" class="form-control">
                                <option value="all" <?php if(($filters['source'] ?? 'all') === 'all'): echo 'selected'; endif; ?>>All Sources</option>
                                <option value="booking" <?php if(($filters['source'] ?? '') === 'booking'): echo 'selected'; endif; ?>>Booking Only</option>
                                <option value="pharmacy" <?php if(($filters['source'] ?? '') === 'pharmacy'): echo 'selected'; endif; ?>>Pharmacy Only</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="booking_status" class="form-control">
                                <option value="">Booking Status</option>
                                <?php $__currentLoopData = $bookingStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($statusOption); ?>" <?php if(strtoupper($filters['booking_status'] ?? '') === $statusOption): echo 'selected'; endif; ?>><?php echo e($statusOption); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="pharmacy_status" class="form-control">
                                <option value="">Pharmacy Status</option>
                                <?php $__currentLoopData = $transactionStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($statusOption); ?>" <?php if(($filters['pharmacy_status'] ?? '') === $statusOption): echo 'selected'; endif; ?>><?php echo e(ucfirst($statusOption)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="<?php echo e(route('admin.Transaction')); ?>" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <?php if($bookingTransactions): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Booking Transactions</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Type</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $bookingTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $status = strtoupper((string) $booking->status);
                                            $statusClass = in_array($status, ['SUCCESS', 'PAID', 'COMPLETED'], true)
                                                ? 'bg-success'
                                                : (in_array($status, ['PENDING', 'PROCESSING', 'ACTIVE'], true) ? 'bg-warning text-dark' : 'bg-danger');
                                        ?>
                                        <tr>
                                            <td>#APT<?php echo e(str_pad($booking->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                            <td><?php echo e($booking->patient?->name ?? 'N/A'); ?></td>
                                            <td>Dr. <?php echo e($booking->doctor?->name ?? 'N/A'); ?></td>
                                            <td><span class="badge bg-info"><?php echo e(strtoupper((string) $booking->appointment_type)); ?></span></td>
                                            <td>Tsh <?php echo e(number_format((float) $booking->total, 2)); ?></td>
                                            <td><span class="badge rounded-pill <?php echo e($statusClass); ?>"><?php echo e($status); ?></span></td>
                                            <td>
                                                <form method="POST" action="<?php echo e(route('admin.bookings.status', $booking)); ?>" class="d-flex gap-2 align-items-center">
                                                    <?php echo csrf_field(); ?>
                                                    <select name="status" class="form-select form-select-sm" style="min-width: 145px;">
                                                        <?php $__currentLoopData = $bookingStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($statusOption); ?>" <?php if($status === $statusOption): echo 'selected'; endif; ?>><?php echo e($statusOption); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="7" class="text-center text-muted">No booking transactions found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <?php echo e($bookingTransactions->links()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($pharmacyTransactions): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pharmacy Transactions</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Phone</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $pharmacyTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $status = strtolower((string) $trans->status);
                                            $statusClass = $status === 'paid'
                                                ? 'bg-success'
                                                : (in_array($status, ['pending', 'processing'], true) ? 'bg-warning text-dark' : 'bg-danger');
                                        ?>
                                        <tr>
                                            <td>#ORD<?php echo e(str_pad($trans->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                            <td><?php echo e($trans->user?->name ?? 'Guest User'); ?></td>
                                            <td><?php echo e($trans->phone ?? 'N/A'); ?></td>
                                            <td>Tsh <?php echo e(number_format((float) $trans->total, 2)); ?></td>
                                            <td><span class="badge rounded-pill <?php echo e($statusClass); ?>"><?php echo e(strtoupper($status)); ?></span></td>
                                            <td>
                                                <div class="d-flex flex-column gap-2">
                                                    <form method="POST" action="<?php echo e(route('admin.transactions.status', $trans)); ?>" class="d-flex gap-2 align-items-center">
                                                        <?php echo csrf_field(); ?>
                                                        <select name="status" class="form-select form-select-sm" style="min-width: 145px;">
                                                            <?php $__currentLoopData = $transactionStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($statusOption); ?>" <?php if($status === $statusOption): echo 'selected'; endif; ?>><?php echo e(ucfirst($statusOption)); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                                    </form>
                                                    <form method="POST" action="<?php echo e(route('admin.transactions.destroy', $trans)); ?>" onsubmit="return confirm('Delete this pharmacy transaction permanently?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="6" class="text-center text-muted">No pharmacy transactions found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <?php echo e($pharmacyTransactions->links()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.slimscroll.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/script.js')); ?>"></script>
</body>
</html>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/Transaction.blade.php ENDPATH**/ ?>