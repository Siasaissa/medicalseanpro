<div class="col-lg-4 col-xl-3 theiaStickySidebar">
    <!-- Profile Sidebar -->
    <div class="profile-sidebar patient-sidebar profile-sidebar-new">
        <div class="widget-profile pro-widget-content">
            <div class="profile-info-widget">
                <a href="<?php echo e(route('patient.settings')); ?>" class="booking-doc-img">

                    <?php if(Auth::user()->profile && Auth::user()->profile->dp): ?>
                        <img src="<?php echo e(asset(Auth::user()->profile->dp)); ?>"
                             alt="Profile Photo"
                             class="img-fluid rounded-circle">
                    <?php else: ?>
                        <img src="<?php echo e(asset('images/profile-06.jpg')); ?>"
                             alt="Default Avatar"
                             class="img-fluid rounded-circle">
                    <?php endif; ?>
                </a>
                <div class="profile-det-info">
                    <h3><a href="<?php echo e(route('patient.settings')); ?>"><?php echo e(Auth::user()->name); ?></a></h3>
                    <div class="patient-details">
                        <h5 class="mb-0">Patient ID : PT000<?php echo e(Auth::user()->id); ?></h5>
                    </div>
                    <span> <?php echo e(Auth::user()->profile->sex ?? 'not set'); ?> <i class="fa-solid fa-circle"></i> 
                        <?php if($age): ?>
                            
                            <?php
                                // Split the string into years and months
                                preg_match('/([\d.]+) years ([\d.]+) months/', $age, $matches);
                                $years = isset($matches[1]) ? floor($matches[1]) : 0;
                                $months = isset($matches[2]) ? floor($matches[2]) : 0;
                            ?>
                            <?php echo e($years); ?> years <?php echo e($months); ?> months
                        <?php else: ?>
                            Not set
                        <?php endif; ?>
                        <i class="fa-solid fa-circle"></i>
                    </span>


                </div>
            </div>
        </div>
        <div class="dashboard-widget">
            <nav class="dashboard-menu">
                <ul>
                    <li class="<?php echo e(request()->is('dashboard') ? 'active' : ''); ?>">
                        <a href="<?php echo e(url('dashboard')); ?>">
                            <i class="isax isax-category-2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="<?php echo e(Route::is('patient.appointment') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('patient.appointment')); ?>">
                            <i class="isax isax-calendar-1"></i>
                            <span>My Appointments</span>
                        </a>
                    </li>

                    <li class="<?php echo e(Route::is('patient.favourites') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('patient.favourites')); ?>">
                            <i class="isax isax-star-1"></i>
                            <span>Favourites</span>
                        </a>
                    </li>

                    <li class="<?php echo e(Route::is('patient.wallet') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('patient.wallet')); ?>">
                            <i class="isax isax-wallet-2"></i>
                            <span>Wallet</span>
                        </a>
                    </li>

                    <li class="<?php echo e(Route::is('patient.chat') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('chat.index')); ?>">
                            <i class="isax isax-messages-1"></i>
                            <span>Message</span>
                            <small class="unread-msg">7</small>
                        </a>
                    </li>

                    <li class="<?php echo e(Route::is('patient.vitals') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('patient.vitals')); ?>">
                            <i class="isax isax-note-1"></i>
                            <span>Vitals</span>
                        </a>
                    </li>

                    <li class="<?php echo e(Route::is('patient.settings') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('patient.settings')); ?>">
                            <i class="isax isax-setting-2"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- /Profile Sidebar -->
</div><?php /**PATH /home/u881803686/domains/medicalsean.org/public_html/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>