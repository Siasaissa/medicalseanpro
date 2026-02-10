<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <header class="header header-custom header-fixed inner-header relative">
            <div class="container">
                <nav class="navbar navbar-expand-lg header-nav">
                    <div class="navbar-header">
                        <a id="mobile_btn" href="javascript:void(0);">
                            <span class="bar-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </a>
                        <a href="index.html" class="navbar-brand logo">
                            <img src="<?php echo e(asset('images/logo.svg')); ?>" class="img-fluid" alt="Logo">
                        </a>
                    </div>
                    <div class="header-menu">
                        <div class="main-menu-wrapper">
                            <div class="menu-header">
                                <a href="#" class="menu-logo">
                                    <img src="<?php echo e(asset('images/logo.svg')); ?>" class="img-fluid" alt="Logo">
                                </a>
                                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                            <ul class="main-nav">
                                <li class="has-submenu <?php echo e(Route::is('patient.doctor-grid') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('patient.doctor-grid')); ?>">Doctors</a>
                                </li>
                                <li class="has-submenu <?php echo e(Route::is('pharmacy.product') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('pharmacy.product')); ?>">Pharmacy</i></a>
                                </li>
                                <li class="has-submenu">
                                    <a href="about-us.html">About Us</a>
                                </li>
                                <li class="has-submenu">
                                    <a href="blog-grid.html">Blog Grid</i></a>
                                </li>

                            </ul>
                        </div>
                        <ul class="nav header-navbar-rht">
                            <li class="searchbar">
                                <a href="javascript:void(0);"><i class="feather-search"></i></a>
                                <div class="togglesearch">
                                    <form action="search.html">
                                        <div class="input-group">
                                            <input type="text" class="form-control">
                                            <button type="submit" class="btn">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li>
                                <a href="login.html"
                                    class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill"><i
                                        class="isax isax-lock-1 me-1"></i>Logout</a>
                            </li>
                            <li>
                                <a href="index01.html"
                                    class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
                                    <i class="isax isax-user-tick me-1"></i>Home
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <div class="shopping-cart-list">
                            <ul class="nav">
                                <li>
                                    <div class="shopping-cart-amount">

                                        <div class="shopping-cart-icon">
                                            <a href="<?php echo e(route('pharmacy.cart')); ?>">
                                                <img src="<?php echo e(asset('images/bag-2.svg')); ?>" alt="Cart">
                                                <span id="cart-count">0</span>
                                            </a>
                                        </div>

                                        <div class="shopping-cart-content">
                                            <p>Shopping cart</p>
                                            <h6 id="cart-total">Tsh 0</h6>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- /Header -->

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Pharmacy</li>
                                <li class="breadcrumb-item active">Medicine</li>
                            </ol>
                            <h2 class="breadcrumb-title">Medicine</h2>
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

                <div class="row">
                    <div class="col-md-10 col-lg-12 col-xl-12">

                        <div class="row align-items-center pb-3">
                            <div class="col-md-8 col-12 d-md-block d-none custom-short-by">
                                <h3 class="title pharmacy-title fs-24 mb-2">Medlife Medical</h3>
                                <p class="doc-location mb-2 text-ellipse pharmacy-location"><i
                                        class="isax isax-location5 me-1"></i> Dar es Salaam, Tanzania </p>
                                <span class="sort-title">Showing 6 of 98 products</span>
                            </div>
                            <div class="col-md-4 col-12 d-md-block d-none custom-short-by justify-content-end">
                                <form action="#">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control">
                                        <button type="submit" class="btn">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="col-md-12 col-lg-4 col-xl-4 product-custom d-flex">
                                    <div class="profile-widget w-100">
                                        <div class="doc-img">
                                            <a href="product-description.html" tabindex="-1">
                                                <img class="img-fluid" alt="Product image"
                                                    src="<?php echo e(asset('storage/' . $product->images[0])); ?>">
                                            </a>
                                            <a href="javascript:void(0)" class="fav-btn" tabindex="-1">
                                                <i class="far fa-bookmark"></i>
                                            </a>
                                        </div>
                                        <div class="pro-content">
                                            <h3 class="title">
                                                <a href="product-description.html"
                                                    tabindex="-1"><?php echo e($product->brand_name); ?></a>
                                            </h3>
                                            <div class="row align-items-center">
                                                <div class="col-lg-6">
                                                    <span class="price">Tsh <?php echo e($product->price); ?></span>
                                                </div>
                                                <div class="col-lg-6 text-end">
                                                    <a href="javascript:void(0)" class="cart-icon add-to-cart"
                                                        data-id="<?php echo e($product->id); ?>" data-name="<?php echo e($product->brand_name); ?>"
                                                        data-price="<?php echo e($product->price); ?>">
                                                        <i class="fas fa-shopping-cart"></i>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </div>
                        <div class="col-md-12 text-center">
                            <a href="#" class="btn book-btn1 mb-4">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer Section -->
        <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- /Footer Section -->

    </div>
    <!-- jQuery -->
    <script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>"></script>

    <!-- Then your cart script -->
    <script>
$(document).ready(function () {
    $('.add-to-cart').on('click', function () {
        const product = {
            id: $(this).data('id'),
            name: $(this).data('name'),
            price: parseFloat($(this).data('price')),
        };

        $.ajax({
            url: "<?php echo e(route('cart.add')); ?>",
            method: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                product: product
            },
            success: function (response) {
                $('#cart-count').text(response.count);
                $('#cart-total').text('Tsh ' + response.total.toLocaleString());
            }
        });
    });
});

    </script>


    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <!--<script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>" type="563bf692b8fb34588a7e357b-text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>" type="563bf692b8fb34588a7e357b-text/javascript"></script>

    <!-- Sticky Sidebar JS -->
    <script src="<?php echo e(asset('js/ResizeSensor.js')); ?>" type="563bf692b8fb34588a7e357b-text/javascript"></script>
    <script src="<?php echo e(asset('js/theia-sticky-sidebar.js')); ?>" type="563bf692b8fb34588a7e357b-text/javascript"></script>

    <!-- Select2 JS -->
    <script src="<?php echo e(asset('js/select2.min.js')); ?>" type="563bf692b8fb34588a7e357b-text/javascript"></script>

    <!-- Datetimepicker JS -->
    <script src="<?php echo e(asset('js/moment.min.js')); ?>" type="563bf692b8fb34588a7e357b-text/javascript"></script>
    <script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"
        type="563bf692b8fb34588a7e357b-text/javascript"></script>

    <!-- Fancybox JS -->
    <script src="<?php echo e(asset('js/jquery.fancybox.min.js')); ?>" type="563bf692b8fb34588a7e357b-text/javascript"></script>

    <!-- Custom JS -->
    <script src="<?php echo e(asset('js/script.js')); ?>" type="563bf692b8fb34588a7e357b-text/javascript"></script>

    <script src="<?php echo e(asset('js/rocket-loader.min.js')); ?>" data-cf-settings="563bf692b8fb34588a7e357b-|49"
        defer=""></script>
    <script defer=""
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        data-cf-beacon="{"
        rayid":"97d88d4bdaebb926","servertiming":{"name":{"cfextpri":true,"cfedge":true,"cforigin":true,"cfl4":true,"cfspeedbrain":true,"cfcachestatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}"=""
        crossorigin="anonymous"></script>

</body>

</html><?php /**PATH /Users/dope/Documents/sean/sean/resources/views/pharmacy/product.blade.php ENDPATH**/ ?>