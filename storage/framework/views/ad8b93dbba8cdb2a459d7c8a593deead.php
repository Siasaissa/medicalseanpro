<?php echo $__env->make('layouts.adminHead', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $pharmacyStatusColors = [
        'pending' => 'warning',
        'processing' => 'info',
        'paid' => 'success',
        'failed' => 'danger',
        'cancelled' => 'dark',
        'refunded' => 'secondary',
    ];

    $bookingStatusColors = [
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
                            <h3 class="page-title">Transactions</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Admin</a></li>
                                <li class="breadcrumb-item active">Transactions</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-muted">Pharmacy Revenue</h6>
                                <h3 class="mb-0">TSh <?php echo e(number_format((float) ($totals['pharmacy'] ?? 0), 0)); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-muted">Booking Revenue</h6>
                                <h3 class="mb-0">TSh <?php echo e(number_format((float) ($totals['booking'] ?? 0), 0)); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="<?php echo e(route('admin.Transaction')); ?>" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" class="form-control" placeholder="ID, name, email, phone">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Source</label>
                                <select name="source" class="form-control">
                                    <option value="all" <?php if(($filters['source'] ?? 'all') === 'all'): echo 'selected'; endif; ?>>All</option>
                                    <option value="pharmacy" <?php if(($filters['source'] ?? '') === 'pharmacy'): echo 'selected'; endif; ?>>Pharmacy</option>
                                    <option value="booking" <?php if(($filters['source'] ?? '') === 'booking'): echo 'selected'; endif; ?>>Booking</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pharmacy Status</label>
                                <select name="pharmacy_status" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $transactionStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php if(($filters['pharmacy_status'] ?? '') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Booking Status</label>
                                <select name="booking_status" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $bookingStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php if(($filters['booking_status'] ?? '') === $status): echo 'selected'; endif; ?>><?php echo e($status); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Go</button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if($pharmacyTransactions): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pharmacy Orders</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Customer</th>
                                            <th>Phone</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Update</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $pharmacyTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td>#ORD<?php echo e(str_pad($order->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                                <td>
                                                    <strong><?php echo e($order->user->name ?? 'Guest User'); ?></strong><br>
                                                    <small class="text-muted"><?php echo e($order->user->email ?? 'No email'); ?></small>
                                                </td>
                                                <td><?php echo e($order->phone ?? 'N/A'); ?></td>
                                                <td>TSh <?php echo e(number_format((float) ($order->total ?? 0), 0)); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo e($pharmacyStatusColors[$order->status ?? ''] ?? 'secondary'); ?>-light">
                                                        <?php echo e(ucfirst($order->status ?? 'unknown')); ?>

                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="<?php echo e(route('admin.transactions.status', $order)); ?>" method="POST" class="d-flex gap-2">
                                                        <?php echo csrf_field(); ?>
                                                        <select name="status" class="form-control form-control-sm">
                                                            <?php $__currentLoopData = $transactionStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($status); ?>" <?php if(($order->status ?? '') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <button class="btn btn-sm btn-primary">Save</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="<?php echo e(route('admin.transactions.destroy', $order)); ?>" method="POST" onsubmit="return confirm('Delete this pharmacy transaction?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">No pharmacy transactions found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <?php echo e($pharmacyTransactions->links()); ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($bookingTransactions): ?>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Booking Payments</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Booking</th>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $bookingTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td>#APT<?php echo e(str_pad($booking->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                                <td><?php echo e($booking->patient->name ?? 'N/A'); ?></td>
                                                <td><?php echo e($booking->doctor->name ?? 'N/A'); ?></td>
                                                <td>TSh <?php echo e(number_format((float) ($booking->total ?? 0), 0)); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo e($bookingStatusColors[$booking->status ?? ''] ?? 'secondary'); ?>-light">
                                                        <?php echo e($booking->status ?? 'N/A'); ?>

                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="<?php echo e(route('admin.bookings.status', $booking)); ?>" method="POST" class="d-flex gap-2">
                                                        <?php echo csrf_field(); ?>
                                                        <select name="status" class="form-control form-control-sm">
                                                            <?php $__currentLoopData = $bookingStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($status); ?>" <?php if(($booking->status ?? '') === $status): echo 'selected'; endif; ?>><?php echo e($status); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <button class="btn btn-sm btn-primary">Save</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">No booking transactions found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <?php echo e($bookingTransactions->links()); ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('admincss/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admincss/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admincss/js/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admincss/js/script.js')); ?>"></script>
</body>
</html>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/Transaction.blade.php ENDPATH**/ ?>