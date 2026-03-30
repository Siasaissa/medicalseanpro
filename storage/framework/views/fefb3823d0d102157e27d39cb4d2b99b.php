<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body>
    <div class="main-wrapper">
        <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('pharmacy.product')); ?>"><i class="isax isax-home-15"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Pharmacy</li>
                                <li class="breadcrumb-item active">Order Payment</li>
                            </ol>
                            <h2 class="breadcrumb-title">Order Payment</h2>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="content success-page-cont">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card success-card">
                            <div class="card-body">
                                <?php
                                    $status = strtolower((string) ($order->status ?? 'processing'));
                                    $isPaid = $status === 'paid';
                                    $isFailed = $status === 'failed';
                                ?>

                                <div class="success-cont text-center">
                                    <i class="fas <?php echo e($isPaid ? 'fa-check text-success' : ($isFailed ? 'fa-times text-danger' : 'fa-clock text-warning')); ?>"></i>
                                    <h3>
                                        <?php if($isPaid): ?>
                                            Payment Completed
                                        <?php elseif($isFailed): ?>
                                            Payment Failed
                                        <?php else: ?>
                                            Payment Processing
                                        <?php endif; ?>
                                    </h3>
                                    <p class="mb-1">Order ID: <strong>#ORD<?php echo e(str_pad($order->id, 4, '0', STR_PAD_LEFT)); ?></strong></p>
                                    <p class="mb-3">Reference: <strong><?php echo e($order->payment_reference ?? '-'); ?></strong></p>
                                    <p class="mb-0">Total: <strong>Tsh <?php echo e(number_format((float) $order->total, 2)); ?></strong></p>
                                </div>

                                <?php if(session('success')): ?>
                                    <div class="alert alert-success mt-4"><?php echo e(session('success')); ?></div>
                                <?php endif; ?>
                                <?php if(session('warning')): ?>
                                    <div class="alert alert-warning mt-4"><?php echo e(session('warning')); ?></div>
                                <?php endif; ?>
                                <?php if(session('error')): ?>
                                    <div class="alert alert-danger mt-4"><?php echo e(session('error')); ?></div>
                                <?php endif; ?>

                                <div class="d-flex gap-2 flex-wrap mt-4 justify-content-center">
                                    <?php if(!$isPaid && !empty($order->payment_reference)): ?>
                                        <a href="<?php echo e(route('pharmacy.verify', $order->payment_reference)); ?>" class="btn btn-primary">
                                            Verify Payment Status
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('pharmacy.product')); ?>" class="btn btn-outline-primary">Continue Shopping</a>
                                    <a href="<?php echo e(route('pharmacy.cart')); ?>" class="btn btn-outline-secondary">Go To Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
</body>
</html>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/pharmacy/successfully.blade.php ENDPATH**/ ?>