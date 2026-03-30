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
                                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><i class="isax isax-home-15"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Patient</li>
                                <li class="breadcrumb-item active">Vitals</li>
                            </ol>
                            <h2 class="breadcrumb-title">Vitals</h2>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-bg">
                <img src="<?php echo e(asset('images/breadcrumb-bg-01.png')); ?>" alt="img" class="breadcrumb-bg-01">
                <img src="<?php echo e(asset('images/breadcrumb-bg-02.png')); ?>" alt="img" class="breadcrumb-bg-02">
                <img src="<?php echo e(asset('images/breadcrumb-icon.png')); ?>" alt="img" class="breadcrumb-bg-03">
                <img src="<?php echo e(asset('images/breadcrumb-icon.png')); ?>" alt="img" class="breadcrumb-bg-04">
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row">
                    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <div class="col-lg-8 col-xl-9">
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="dashboard-header d-flex align-items-center justify-content-between">
                            <h3>Vitals</h3>
                            <a href="#addVitalModal" class="btn btn-md btn-primary-gradient rounded-pill" data-bs-toggle="modal">
                                Add Vitals
                            </a>
                        </div>

                        <div class="dashboard-card w-100 medical-details-item mb-4">
                            <div class="dashboard-card-head medical-detail-head">
                                <div class="header-title">
                                    <h6>Latest Updated Vitals</h6>
                                </div>
                                <div class="latest-update">
                                    <p>
                                        <i class="isax isax-calendar-tick5 me-2"></i>
                                        Last update on:
                                        <?php echo e($latest?->recorded_at ? $latest->recorded_at->format('d M Y h:i A') : 'No record yet'); ?>

                                    </p>
                                </div>
                            </div>

                            <div class="dashboard-card-body">
                                <div class="row row-gap-3">
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-red mb-0">
                                            <span>Blood Pressure</span>
                                            <h3><?php echo e($latest?->blood_pressure ?? '-'); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-orange mb-0">
                                            <span>Heart Rate</span>
                                            <h3><?php echo e($latest?->heart_rate ? $latest->heart_rate . ' bpm' : '-'); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-dark-blue mb-0">
                                            <span>Glucose</span>
                                            <h3><?php echo e($latest?->glucose_level ?? '-'); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-amber mb-0">
                                            <span>Temperature</span>
                                            <h3><?php echo e($latest?->body_temperature ? $latest->body_temperature . ' C' : '-'); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-purple mb-0">
                                            <span>BMI</span>
                                            <h3><?php echo e($latest?->bmi ?? '-'); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6">
                                        <div class="health-records icon-blue mb-0">
                                            <span>SPo2</span>
                                            <h3><?php echo e($latest?->spo2 ? $latest->spo2 . '%' : '-'); ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="custom-table">
                            <div class="table-responsive">
                                <table class="table table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>BMI</th>
                                            <th>Heart Rate</th>
                                            <th>FBC</th>
                                            <th>Weight (kg)</th>
                                            <th>Recorded At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $vitals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vital): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td>#VT<?php echo e(str_pad($vital->id, 4, '0', STR_PAD_LEFT)); ?></td>
                                                <td><?php echo e($vital->bmi ?? '-'); ?></td>
                                                <td><?php echo e($vital->heart_rate ?? '-'); ?></td>
                                                <td><?php echo e($vital->fbc_status ?? '-'); ?></td>
                                                <td><?php echo e($vital->weight ?? '-'); ?></td>
                                                <td><?php echo e($vital->recorded_at ? $vital->recorded_at->format('d M Y h:i A') : '-'); ?></td>
                                                <td>
                                                    <form action="<?php echo e(route('patient.vitals.destroy', $vital->id)); ?>" method="POST" onsubmit="return confirm('Delete this vital record?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">No vitals recorded yet.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-3">
                            <?php echo e($vitals->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <div class="modal fade custom-modals" id="addVitalModal">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Vitals</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('patient.vitals.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">BMI</label>
                                <input type="number" step="0.01" name="bmi" class="form-control" value="<?php echo e(old('bmi')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Heart Rate (bpm)</label>
                                <input type="number" name="heart_rate" class="form-control" value="<?php echo e(old('heart_rate')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Weight (kg)</label>
                                <input type="number" step="0.01" name="weight" class="form-control" value="<?php echo e(old('weight')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">FBC Status</label>
                                <input type="text" name="fbc_status" class="form-control" value="<?php echo e(old('fbc_status')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Blood Pressure</label>
                                <input type="text" name="blood_pressure" class="form-control" placeholder="120/80" value="<?php echo e(old('blood_pressure')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Glucose Level</label>
                                <input type="text" name="glucose_level" class="form-control" value="<?php echo e(old('glucose_level')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Body Temperature (C)</label>
                                <input type="number" step="0.1" name="body_temperature" class="form-control" value="<?php echo e(old('body_temperature')); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SPo2 (%)</label>
                                <input type="number" name="spo2" class="form-control" value="<?php echo e(old('spo2')); ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Recorded At</label>
                                <input type="datetime-local" name="recorded_at" class="form-control" value="<?php echo e(old('recorded_at')); ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" rows="3" class="form-control"><?php echo e(old('notes')); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Vitals</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
    <?php if($errors->any()): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modalEl = document.getElementById('addVitalModal');
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            });
        </script>
    <?php endif; ?>
</body>
</html>
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/patient/vitals.blade.php ENDPATH**/ ?>