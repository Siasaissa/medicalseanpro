<?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php echo $__env->make('layouts.doctorHeader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                                <li class="breadcrumb-item" aria-current="page">Doctor</li>
                                <li class="breadcrumb-item active">Doctor Profile</li>
                            </ol>
                            <h2 class="breadcrumb-title">Doctor Profile</h2>
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
        <div class="content doctor-content">
            <div class="container">

                <div class="row">
                    <div class="col-lg-4 col-xl-3 theiaStickySidebar">

                        <!-- Profile Sidebar -->
                        <?php echo $__env->make('layouts.doctorSidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <!-- /Profile Sidebar -->

                    </div>
                     
                    <div class="col-lg-8 col-xl-9">
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <!-- Profile Settings -->
                        <div class="dashboard-header">
                            <h3>Profile Settings</h3>
                        </div>

                        <!-- Settings List -->
                        <div class="setting-tab">
                            <div class="appointment-tabs">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">Basic Details</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /Settings List -->

                        <div class="setting-title">
                            <h5>Profile</h5>
                        </div>

                        <form action="<?php echo e(route('doctor.profile.update')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="setting-card">
                                <div class="change-avatar img-upload">
                                    <div class="profile-img">
                                        <i class="fa-solid fa-file-image"></i>
                                    </div>
                                    <div class="upload-img">
                                        <h5>Profile Image</h5>
                                        <div class="imgs-load d-flex align-items-center">
                                            <div class="change-photo">
                                                Upload New
                                                <input type="file" name="dp" class="upload"
                                                    accept=".jpg,.jpeg,.png,.svg">
                                            </div>
                                            <a href="#" class="upload-remove">Remove</a>
                                        </div>
                                        <p class="form-text">
                                            Your image should be below 4 MB. Accepted formats: JPG, PNG, SVG.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-title">
                                <h5>Information</h5>
                            </div>

                            <div class="setting-card">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Sex <span class="text-danger">*</span></label>
                                            <input type="text" name="sex" class="form-control"
                                                placeholder="e.g., Male / Female / Other">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Date of Birth <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="dob" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Blood Group <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="blood_group" class="form-control"
                                                placeholder="e.g., A+, O-, B+">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Marital Status <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="marital_status" class="form-control"
                                                placeholder="e.g., Single, Married, Divorced">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Address <span class="text-danger">*</span></label>
                                            <input type="text" name="address" class="form-control"
                                                placeholder="Enter your residential address">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="form-label">Phone Number(s) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="phone_numbers" class="form-control"
                                                placeholder="e.g., +255 700 123 456">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-wrap">
                                            <label class="form-label">Known Languages <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-block input-block-new mb-0">
                                                <input class="input-tags form-control" id="inputBox3" type="text"
                                                    name="known_languages" data-role="tagsinput"
                                                    placeholder="e.g., English, Swahili, French">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-title">
                                <h5>Experience</h5>
                            </div>

                            <div class="setting-card">
                                <div class="add-info membership-infos">
                                    <div class="row membership-content">
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">Title <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="title" class="form-control"
                                                    placeholder="e.g., Senior Surgeon">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">Hospital <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="hospital" class="form-control"
                                                    placeholder="e.g., Aga Khan Hospital">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">Years of Experience <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="year_of_experience" class="form-control"
                                                    placeholder="e.g., 10">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">Location <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="location" class="form-control"
                                                    placeholder="e.g., Dar es Salaam, Tanzania">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-9">
                                            <div class="form-wrap">
                                                <label class="form-label">Job Description <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="job_description" class="form-control"
                                                    placeholder="Briefly describe your role and duties"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">Start Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="start_date" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-wrap">
                                                <label class="form-label">End Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="end_date" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="form-wrap w-100">
                                                    <label class="form-label">About Membership</label>
                                                    <input type="text" name="about_membership" class="form-control"
                                                        placeholder="e.g., Member of Medical Association of Tanzania">
                                                </div>
                                                <div class="form-wrap ms-2">
                                                    <label class="col-form-label d-block">&nbsp;</label>
                                                    <a href="javascript:void(0);" class="trash-icon trash">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <a href="#" class="add-membership-info more-item">Add New</a>
                                </div>
                            </div>

                            <div class="modal-btn text-end">
                                <a href="#" class="btn btn-gray">Cancel</a>
                                <button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
                            </div>
                        </form>
                        <!-- /Profile Settings -->

                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Footer Section -->
        <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- /Footer Section -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Sticky Sidebar JS -->
    <script src="<?php echo e(asset('js/ResizeSensor.js')); ?>" type="150aa4ebfdefddf1a928273b-text/javascript"></script>
    <script src="<?php echo e(asset('js/theia-sticky-sidebar.js')); ?>" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Select2 JS -->
    <script src="<?php echo e(asset('js/select2.min.js')); ?>" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Bootstrap Tagsinput JS -->
    <script src="<?php echo e(asset('js/bootstrap-tagsinput.js')); ?>" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Profile Settings JS -->
    <script src="<?php echo e(asset('js/profile-settings.js')); ?>" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <!-- Custom JS -->
    <script src="<?php echo e(asset('js/script.js')); ?>" type="150aa4ebfdefddf1a928273b-text/javascript"></script>

    <script src="<?php echo e(asset('js/rocket-loader.min.js')); ?>" data-cf-settings="150aa4ebfdefddf1a928273b-|49"
        defer=""></script>
    <script defer=""
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        data-cf-beacon="{"
        version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"=""
        crossorigin="anonymous"></script>

</body>

</html><?php /**PATH /home/u881803686/domains/medicalsean.org/public_html/resources/views/doctor/profilesettings.blade.php ENDPATH**/ ?>