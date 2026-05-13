<?php echo $__env->make('layouts.adminHead', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $orderBadgeMap = [
        'pending' => 'warning',
        'processing' => 'info',
        'paid' => 'success',
        'failed' => 'danger',
        'cancelled' => 'dark',
        'refunded' => 'secondary',
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
                            <h3 class="page-title">Pharmacy Admin</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Admin</a></li>
                                <li class="breadcrumb-item active">Pharmacy</li>
                            </ul>
                        </div>
                        <div class="col-auto">
                            <a href="<?php echo e(route('admin.addproduct')); ?>" class="btn btn-primary">Add Product</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-7 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Products</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Stock</th>
                                                <th>Price</th>
                                                <th>Discount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td>
                                                        <strong><?php echo e($product->brand_name); ?></strong><br>
                                                        <small class="text-muted"><?php echo e($product->description ? \Illuminate\Support\Str::limit($product->description, 60) : 'No description'); ?></small>
                                                    </td>
                                                    <td><?php echo e($product->category); ?></td>
                                                    <td><?php echo e($product->quantity); ?></td>
                                                    <td>TSh <?php echo e(number_format((float) ($product->price ?? 0), 0)); ?></td>
                                                    <td><?php echo e((float) ($product->discount ?? 0)); ?>%</td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">No products available.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Recent Orders</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Customer</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td>#ORD<?php echo e(str_pad($order->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                                    <td><?php echo e($order->user->name ?? 'Guest User'); ?></td>
                                                    <td>
                                                        <span class="badge bg-<?php echo e($orderBadgeMap[$order->status ?? ''] ?? 'secondary'); ?>-light">
                                                            <?php echo e(ucfirst($order->status ?? 'unknown')); ?>

                                                        </span>
                                                    </td>
                                                    <td>TSh <?php echo e(number_format((float) ($order->total ?? 0), 0)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">No recent orders found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3">
                                    <a href="<?php echo e(route('admin.Transaction', ['source' => 'pharmacy'])); ?>" class="btn btn-outline-primary w-100">Open Transaction Manager</a>
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
    <script src="<?php echo e(asset('admincss/js/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admincss/js/script.js')); ?>"></script>
</body>
</html>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/pharmacy.blade.php ENDPATH**/ ?>