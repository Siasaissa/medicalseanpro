<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- /Header -->

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Pharmacy</li>
                                <li class="breadcrumb-item active">Cart</li>
                            </ol>
                            <h2 class="breadcrumb-title">Cart</h2>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-bg">
                <img src="<?php echo e(asset('images/breadcrumb-bg-01.png')); ?>" alt="img" class="breadcrumb-bg-01">
                <img src="<?php echo e(asset('images/breadcrumb-bg-02.png')); ?>" alt="img" class="breadcrumb-bg-02">
                <img src="<?php echo e(asset('images/breadcrumb-icon.webp')); ?>" alt="img" class="breadcrumb-bg-03">
                <img src="<?php echo e(asset('images/breadcrumb-icon.webp')); ?>" alt="img" class="breadcrumb-bg-04">
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content">
            <div class="container">

                <div class="card card-table">
                    <div class="card-body">

                        <?php if(count($cart) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($item['id']); ?>">
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="product-description.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img"
                                                        src="<?php echo e(isset($item['image']) ? asset('storage/'.$item['image']) : asset('images/product.jpg')); ?>"
                                                        alt="<?php echo e($item['name']); ?>">
                                                </a>
                                            </h2>
                                            <a href="product-description.html"><?php echo e($item['name']); ?></a>
                                        </td>

                                        <td>Tsh <?php echo e(number_format($item['price'])); ?></td>
                                        <td class="text-center">
                                            <div class="custom-increment cart">
                                                <div class="input-group1">
                                                    <span class="input-group-btn">
                                                        <button type="button"
                                                            class="quantity-left-minus btn btn-danger btn-number">
                                                            <span><i class="fas fa-minus"></i></span>
                                                        </button>
                                                    </span>
                                                    <input type="text" name="quantity"
                                                        class="input-number quantity-input"
                                                        value="<?php echo e($item['quantity'] ?? 1); ?>" readonly>
                                                    <span class="input-group-btn">
                                                        <button type="button"
                                                            class="quantity-right-plus btn btn-success btn-number">
                                                            <span><i class="fas fa-plus"></i></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="item-total">
                                            Tsh <?php echo e(number_format($item['price'] * ($item['quantity'] ?? 1))); ?>

                                        </td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-sm bg-danger-light remove-from-cart">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7 col-lg-8"></div>

                    <div class="col-md-5 col-lg-4">

                        <!-- Booking Summary -->
                        <div class="card booking-card">
                            <div class="card-header">
                                <h4 class="card-title">Cart Total</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo e(route('pharmacy.checkout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                <div class="booking-summary">
                                    <div class="booking-item-wrap">
                                        <ul class="booking-date d-block pb-0">
                                            <li>Subtotal <span id="subtotal">Tsh <?php echo e(number_format($total)); ?></span></li>
                                            <li>Shipping <span>Tsh 5000.00</span></li>
                                        </ul>
                                        <ul class="booking-fee pt-4">
                                            <li>Tax <span>Tsh 0.00</span></li>
                                        </ul>
                                        <div class="booking-total">
                                            <ul class="booking-total-list">
                                                <li>
                                                    <span>Total</span>
                                                    <span class="total-cost" id="grand-total">
                                                        Tsh <?php echo e(number_format($total + 5000)); ?>

                                                    </span>
                                                </li>
                                                <li>
                                                    <div class="clinic-booking pt-4">
                                                        <a class="btn btn-primary"
                                                            href="<?php echo e(route('pharmacy.checkout', ['total' =>$total , 'cart' =>$cart ])); ?>" type="submit">Proceed to checkout</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <!-- /Booking Summary -->
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <h4>Your cart is empty.</h4>
                    <a href="<?php echo e(route('pharmacy.product')); ?>" class="btn btn-primary mt-3">Continue Shopping</a>
                </div>
                <?php endif; ?>

            </div>
        </div>
        <!-- /Page Content -->

        <!-- Footer Section -->
        <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- /Footer Section -->

    </div>
    <!-- /Main Wrapper -->


    <!-- jQuery -->
    <script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>"></script>
    <!-- Bootstrap Core JS -->
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- Fancybox JS -->
    <script src="<?php echo e(asset('js/jquery.fancybox.min.js')); ?>"></script>
    <!-- Custom JS -->
    <script src="<?php echo e(asset('js/script.js')); ?>"></script>

    <script>
        $(document).ready(function () {

            // Remove from cart
            $('.remove-from-cart').click(function () {
                const row = $(this).closest('tr');
                const id = row.data('id');

                $.ajax({
                    url: "<?php echo e(route('cart.remove')); ?>",
                    method: "POST",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        id: id
                    },
                    success: function (response) {
                        row.remove();
                        $('#cart-count').text(response.count);
                        $('#subtotal').text('Tsh ' + response.total.toLocaleString());
                        $('#grand-total').text('Tsh ' + (response.total + 25).toLocaleString());
                        if (response.count === 0) {
                            location.reload();
                        }
                    }
                });
            });

            // Quantity increment/decrement
            $('.quantity-right-plus').click(function () {
                let input = $(this).closest('.input-group1').find('.quantity-input');
                input.val(parseInt(input.val()) + 1).trigger('change');
            });

            $('.quantity-left-minus').click(function () {
                let input = $(this).closest('.input-group1').find('.quantity-input');
                if (parseInt(input.val()) > 1) {
                    input.val(parseInt(input.val()) - 1).trigger('change');
                }
            });

            // Update quantity in session
            $('.quantity-input').change(function () {
                const row = $(this).closest('tr');
                const id = row.data('id');
                const quantity = $(this).val();

                $.ajax({
                    url: "<?php echo e(route('cart.update')); ?>",
                    method: "POST",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        id: id,
                        quantity: quantity
                    },
                    success: function (response) {
                        row.find('.item-total').text('Tsh ' + response.itemTotal.toLocaleString());
                        $('#subtotal').text('Tsh ' + response.total.toLocaleString());
                        $('#grand-total').text('Tsh ' + (response.total + 5000).toLocaleString());
                    }
                });
            });
        });
    </script>

</body>

</html>
<?php /**PATH /Users/dope/Documents/sean/sean/resources/views/pharmacy/cart.blade.php ENDPATH**/ ?>