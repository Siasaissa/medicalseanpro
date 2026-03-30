<div class="header">
    <div class="header-left">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo">
            <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="Logo">
        </a>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo logo-small">
            <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="Logo" width="30" height="30">
        </a>
    </div>

    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fe fe-text-align-left"></i>
    </a>

    <div class="top-nav-search">
        <form action="<?php echo e(route('admin.appointment')); ?>" method="GET">
            <input type="text" name="q" class="form-control" placeholder="Search bookings, users, transactions">
            <button class="btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>

    <a class="mobile_btn" id="mobile_btn">
        <i class="fa fa-bars"></i>
    </a>

    <ul class="nav user-menu">
        <li class="nav-item dropdown noti-dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <i class="fe fe-bell"></i>
                <?php if(($adminUnreadCount ?? 0) > 0): ?>
                    <span class="badge rounded-pill"><?php echo e($adminUnreadCount); ?></span>
                <?php endif; ?>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Live Notifications</span>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        <?php $__empty_1 = true; $__currentLoopData = ($adminNotifications ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="notification-message">
                                <a href="<?php echo e($notification['url'] ?? '#'); ?>">
                                    <div class="notify-block d-flex">
                                        <span class="avatar avatar-sm flex-shrink-0">
                                            <img class="avatar-img rounded-circle" alt="Alert" src="<?php echo e(asset('images/icon-message.png')); ?>">
                                        </span>
                                        <div class="media-body flex-grow-1">
                                            <p class="noti-details">
                                                <span class="noti-title"><?php echo e($notification['title'] ?? 'Notification'); ?></span>
                                                <?php echo e($notification['message'] ?? ''); ?>

                                            </p>
                                            <p class="noti-time">
                                                <span class="notification-time"><?php echo e($notification['time'] ?? 'just now'); ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="notification-message text-center p-3 text-muted">No recent notifications.</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="<?php echo e(route('admin.appointment')); ?>">Review Bookings</a> |
                    <a href="<?php echo e(route('admin.Transaction')); ?>">Review Transactions</a>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="<?php echo e(asset($profile->dp ?? 'images/default.jpeg')); ?>" width="31" alt="Admin">
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="<?php echo e(asset($profile->dp ?? 'images/default.jpeg')); ?>" alt="Admin" class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6><?php echo e(Auth::user()->name); ?></h6>
                        <p class="text-muted mb-0">Administrator</p>
                    </div>
                </div>
                <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
                <a class="dropdown-item" href="<?php echo e(route('admin.doctorList')); ?>">User Controls</a>
                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </div>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
        </li>
    </ul>
</div>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/layouts/adminHeader.blade.php ENDPATH**/ ?>