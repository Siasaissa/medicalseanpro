<?php echo $__env->make('layouts.adminhead', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="g-sidenav-show bg-gray-100">
  <?php echo $__env->make('layouts.aside', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- End Navbar -->
    
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Order Details (ID: <?php echo e($order->id); ?>)</h6>
              </div>
            </div>
            
            <div class="card-body p-4">
              <p><strong>Customer:</strong> <?php echo e($order->name); ?></p>
              <p><strong>Phone:</strong> <?php echo e($order->phone); ?></p>
              <p><strong>Total:</strong> <?php echo e(number_format($order->total, 2)); ?> Tsh</p>
              <p><strong>Status:</strong> <span class="badge bg-<?php echo e($order->status == 'completed' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst($order->status)); ?></span></p>

              <h5 class="mt-4">Items</h5>
              <p>
                <?php if(!empty($order->items)): ?>
                    <?php echo e(collect($order->items)->pluck('name')->join(', ')); ?>

                <?php else: ?>
                    N/A
                <?php endif; ?>
              </p>

              <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary mt-3">Back to Orders</a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Footer -->
      <?php echo $__env->make('layouts.adminfooter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
  </main>

  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  
  <script>
    // Scrollbar initialization for sidenav
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      };
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  
  <!-- Control Center for Material Dashboard -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>
</html><?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/orders/show.blade.php ENDPATH**/ ?>