<?php echo $__env->make('layouts.adminHead', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body>
    <div class="main-wrapper">
        <?php echo $__env->make('layouts.adminHeader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.adminSidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Add Product</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Admin</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.pharmacy')); ?>">Pharmacy</a></li>
                                <li class="breadcrumb-item active">Add Product</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">New Pharmacy Product</h5>
                            </div>
                            <div class="card-body">
                                <?php if($errors->any()): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <form action="<?php echo e(route('products.store')); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Brand Name</label>
                                            <input type="text" name="brand_name" value="<?php echo e(old('brand_name')); ?>" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Category</label>
                                            <input type="text" name="category" value="<?php echo e(old('category')); ?>" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Price</label>
                                            <input type="number" step="0.01" min="0" name="Price" value="<?php echo e(old('Price')); ?>" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" min="0" name="quantity" value="<?php echo e(old('quantity')); ?>" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Discount (%)</label>
                                            <input type="number" step="0.01" min="0" name="discount" value="<?php echo e(old('discount')); ?>" class="form-control">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" rows="4" class="form-control"><?php echo e(old('description')); ?></textarea>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <label class="form-label">Product Images</label>
                                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                                            <small class="text-muted">You can upload multiple JPG, PNG, or GIF files.</small>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">Save Product</button>
                                        <a href="<?php echo e(route('admin.pharmacy')); ?>" class="btn btn-outline-secondary">Back to Pharmacy</a>
                                    </div>
                                </form>
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
<?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/addproduct.blade.php ENDPATH**/ ?>