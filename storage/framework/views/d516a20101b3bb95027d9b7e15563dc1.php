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
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <h6 class="text-white text-capitalize ps-3">Manage Orders</h6>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card-body px-0 pb-2">
              <!-- Orders Table -->
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Items</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total (Tsh)</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">#<?php echo e($order->id); ?></h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo e($order->name); ?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo e($order->phone); ?></p>
                      </td>
                      <td>
                        <div class="d-flex flex-column">
                          <?php if(!empty($order->items)): ?>
                            <?php
                              $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
                            ?>
                            <span class="text-xs text-secondary mb-0">
                              <?php echo e(collect($items)->pluck('name')->join(', ')); ?>

                            </span>
                          <?php else: ?>
                            <span class="text-xs text-muted">N/A</span>
                          <?php endif; ?>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-sm font-weight-bold">Tsh <?php echo e(number_format($order->total, 2)); ?></span>
                      </td>
                      <td class="align-middle text-center">
                        <!-- View Button -->
                        <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-outline-info me-1">
                          <i class="material-symbols-rounded opacity-10">visibility</i>
                        </a>

                        <!-- Delete Form -->
                        <form action="<?php echo e(route('admin.orders.destroy', $order->id)); ?>" method="POST" class="d-inline-block">
                          <?php echo csrf_field(); ?>
                          <?php echo method_field('DELETE'); ?>
                          <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this order?')">
                            <i class="material-symbols-rounded opacity-10">delete</i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                      <td colspan="6" class="text-center py-4">
                        <div class="d-flex flex-column align-items-center">
                          <div class="icon icon-lg icon-shape bg-gradient-secondary shadow text-center border-radius-lg mb-2">
                            <i class="material-symbols-rounded opacity-10 text-white">receipt_long</i>
                          </div>
                          <h6 class="mb-0 text-sm">No Orders Found</h6>
                          <p class="text-xs text-secondary mb-0">All customer orders will appear here</p>
                        </div>
                      </td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              
              <!-- Pagination -->
              <?php if(isset($orders) && $orders->hasPages()): ?>
              <div class="card-footer d-flex justify-content-center pt-0">
                <nav aria-label="Page navigation">
                  <ul class="pagination pagination-dark justify-content-center text-white">
                    <?php echo e($orders->links('pagination::bootstrap-4')); ?>

                  </ul>
                </nav>
              </div>
              <?php endif; ?>
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
    // Confirm delete function
    function confirmDelete() {
      return confirm('Delete this order?');
    }

    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });

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
</html><?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>