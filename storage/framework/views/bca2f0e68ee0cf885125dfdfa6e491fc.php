<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $posts = [
        [
            'category' => 'Telemedicine',
            'date' => 'March 24, 2026',
            'title' => 'How To Prepare For A Successful Video Consultation',
            'excerpt' => 'Learn practical steps before joining your doctor online: internet setup, room privacy, and medical records checklist.',
        ],
        [
            'category' => 'Pharmacy',
            'date' => 'March 18, 2026',
            'title' => 'Safe Online Medicine Ordering: What Patients Should Check',
            'excerpt' => 'Understand prescription flow, product verification, and secure payment handling before checkout.',
        ],
        [
            'category' => 'Home Care',
            'date' => 'March 12, 2026',
            'title' => 'When A Home Visit Is Better Than A Clinic Visit',
            'excerpt' => 'Explore common conditions where home consultation is helpful and what to expect during a scheduled visit.',
        ],
        [
            'category' => 'Wellness',
            'date' => 'March 06, 2026',
            'title' => 'Daily Habits That Improve Blood Pressure And Heart Health',
            'excerpt' => 'Simple lifestyle choices that can improve long-term heart outcomes with support from your care team.',
        ],
        [
            'category' => 'Patient Guide',
            'date' => 'February 28, 2026',
            'title' => 'How To Track Symptoms Before Chatting With Your Doctor',
            'excerpt' => 'A short symptom journal can improve diagnosis quality and reduce back-and-forth during online chat.',
        ],
        [
            'category' => 'Digital Health',
            'date' => 'February 21, 2026',
            'title' => 'Why Secure Messaging Matters In Modern Healthcare',
            'excerpt' => 'See how protected communication helps keep patient data private while improving speed of care.',
        ],
    ];
?>

<body>
    <div class="main-wrapper">
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
                        <a href="<?php echo e(route('welcome')); ?>" class="navbar-brand logo">
                            <img src="<?php echo e(asset('images/logo.svg')); ?>" class="img-fluid" alt="MedicalSean Logo">
                        </a>
                    </div>
                    <div class="header-menu">
                        <div class="main-menu-wrapper">
                            <div class="menu-header">
                                <a href="<?php echo e(route('welcome')); ?>" class="menu-logo">
                                    <img src="<?php echo e(asset('images/logo.svg')); ?>" class="img-fluid" alt="MedicalSean Logo">
                                </a>
                                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                            <ul class="main-nav">
                                <li class="menu"><a href="<?php echo e(route('welcome')); ?>">Home</a></li>
                                <li class="menu"><a href="<?php echo e(route('about.us')); ?>">About Us</a></li>
                                <li class="menu active"><a href="<?php echo e(route('blog.grid')); ?>">Blog Grid</a></li>
                                <li class="menu"><a href="<?php echo e(route('login')); ?>">Login</a></li>
                                <li class="menu"><a href="<?php echo e(route('register')); ?>">Register</a></li>
                            </ul>
                        </div>
                        <ul class="nav header-navbar-rht">
                            <li>
                                <a href="<?php echo e(route('login')); ?>"
                                    class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill">
                                    <i class="isax isax-lock-1 me-1"></i>Login
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('register')); ?>"
                                    class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
                                    <i class="isax isax-user-tick me-1"></i>Register
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('welcome')); ?>"><i class="isax isax-home-15"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Blog Grid</li>
                            </ol>
                            <h2 class="breadcrumb-title">Health Insights & Updates</h2>
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

        <div class="content">
            <div class="container">
                <div class="row">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4 d-flex mb-4">
                            <div class="card border-0 shadow-sm w-100 h-100">
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-light text-dark mb-2"><?php echo e($post['category']); ?></span>
                                    <p class="text-muted mb-2"><i class="feather-calendar me-1"></i><?php echo e($post['date']); ?></p>
                                    <h5 class="mb-2"><?php echo e($post['title']); ?></h5>
                                    <p class="mb-4"><?php echo e($post['excerpt']); ?></p>
                                    <div class="mt-auto">
                                        <a href="<?php echo e(route('about.us')); ?>" class="btn btn-sm btn-outline-primary me-2">Learn More</a>
                                        <a href="<?php echo e(route('register')); ?>" class="btn btn-sm btn-primary-gradient">Book Doctor</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/blog-grid.blade.php ENDPATH**/ ?>