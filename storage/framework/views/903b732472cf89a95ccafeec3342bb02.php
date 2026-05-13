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
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <h6 class="text-white text-capitalize ps-3">Invoice List</h6>
                  </div>
                  <div class="col-md-6 text-end pe-4">
                    <a href="<?php echo e(route('admin.Invoices.create')); ?>" class="btn btn-outline-white btn-sm">
                      <i class="material-symbols-rounded me-1">add</i> Create New Invoice
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card-body">
              <!-- Search and Filter Section -->
              <form method="GET" action="<?php echo e(route('admin.Invoice.index')); ?>" id="filterForm">
                <div class="row mb-4">
                  <div class="col-md-4">
                    <div class="input-group input-group-outline">
                      <input type="text" name="search" id="searchInput" class="form-control" 
                             placeholder="Search by customer, invoice number..." 
                             value="<?php echo e(request('search')); ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group input-group-outline">
                      <select name="status" id="statusFilter" class="form-control">
                        <option value="">All Status</option>
                        <option value="paid" <?php echo e(request('status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="overdue" <?php echo e(request('status') == 'overdue' ? 'selected' : ''); ?>>Overdue</option>
                        <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group input-group-outline">
                      <select name="date_filter" id="dateFilter" class="form-control">
                        <option value="">All Time</option>
                        <option value="today" <?php echo e(request('date_filter') == 'today' ? 'selected' : ''); ?>>Today</option>
                        <option value="week" <?php echo e(request('date_filter') == 'week' ? 'selected' : ''); ?>>This Week</option>
                        <option value="month" <?php echo e(request('date_filter') == 'month' ? 'selected' : ''); ?>>This Month</option>
                        <option value="year" <?php echo e(request('date_filter') == 'year' ? 'selected' : ''); ?>>This Year</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                      Reset
                    </button>
                  </div>
                </div>
              </form>

              <!-- Success/Error Messages -->
              <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?php echo e(session('success')); ?>

                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
              <?php endif; ?>

              <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo e(session('error')); ?>

                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
              <?php endif; ?>

              <!-- Invoice Table -->
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Invoice #</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Due Date</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount (Tsh)</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm text-primary"><?php echo e($invoice->invoice_number); ?></h6>
                            <?php if($invoice->reference): ?>
                              <p class="text-xs text-secondary mb-0">Ref: <?php echo e($invoice->reference); ?></p>
                            <?php endif; ?>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo e($invoice->customer_name); ?></p>
                        <p class="text-xs text-secondary mb-0"><?php echo e($invoice->customer_phone); ?></p>
                      </td>
                      <td>
                        <p class="text-sm mb-0"><?php echo e($invoice->invoice_date->format('M d, Y')); ?></p>
                      </td>
                      <td>
                        <p class="text-sm mb-0"><?php echo e($invoice->due_date->format('M d, Y')); ?></p>
                        <?php if($invoice->isOverdue()): ?>
                          <p class="text-xs text-danger mb-0">Overdue</p>
                        <?php endif; ?>
                      </td>
                      <td class="align-middle text-center">
                        <p class="text-sm font-weight-bold mb-0"><?php echo e(number_format($invoice->grand_total, 2)); ?></p>
                        <?php if($invoice->paid_amount > 0): ?>
                          <p class="text-xs text-success mb-0">Paid: <?php echo e(number_format($invoice->paid_amount, 2)); ?></p>
                        <?php endif; ?>
                      </td>
                      <td class="align-middle text-center">
                        <span class="badge badge-sm bg-<?php echo e($invoice->status_color); ?>">
                          <?php echo e(ucfirst($invoice->status)); ?>

                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="<?php echo e(route('invoices.show', $invoice->id)); ?>" 
                           class="btn btn-sm btn-outline-info me-1">
                          <i class="material-symbols-rounded opacity-10">visibility</i>
                        </a>
                        <a href="<?php echo e(route('invoices.edit', $invoice->id)); ?>" 
                           class="btn btn-sm btn-outline-warning me-1">
                          <i class="material-symbols-rounded opacity-10">edit</i>
                        </a>
                        <a href="<?php echo e(route('invoices.print', $invoice->id)); ?>" 
                           class="btn btn-sm btn-outline-secondary me-1" target="_blank">
                          <i class="material-symbols-rounded opacity-10">print</i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                onclick="deleteInvoice(<?php echo e($invoice->id); ?>)">
                          <i class="material-symbols-rounded opacity-10">delete</i>
                        </button>
                      </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                      <td colspan="7" class="text-center py-4">
                        <div class="d-flex flex-column align-items-center">
                          <div class="icon icon-lg icon-shape bg-gradient-secondary shadow text-center border-radius-lg mb-2">
                            <i class="material-symbols-rounded opacity-10 text-white">receipt</i>
                          </div>
                          <h6 class="mb-0 text-sm">No Invoices Found</h6>
                          <p class="text-xs text-secondary mb-0">Create your first invoice to get started</p>
                          <a href="<?php echo e(route('admin.Invoices.create')); ?>" class="btn btn-sm btn-primary mt-2">
                            Create Your First Invoice
                          </a>
                        </div>
                      </td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              
              <!-- Pagination -->
              <?php if(isset($invoices) && $invoices->hasPages()): ?>
              <div class="card-footer d-flex justify-content-between align-items-center pt-0">
                <div class="text-muted text-sm">
                  Showing <?php echo e($invoices->firstItem()); ?> to <?php echo e($invoices->lastItem()); ?> of <?php echo e($invoices->total()); ?> invoices
                </div>
                <nav aria-label="Page navigation">
                  <ul class="pagination pagination-primary justify-content-center">
                    <?php echo e($invoices->links('pagination::bootstrap-4')); ?>

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

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-gradient-danger">
          <h5 class="modal-title text-white">Confirm Deletion</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this invoice? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <form id="deleteForm" method="POST" style="display: inline;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger">
              Delete Invoice
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  
  <script>
    // Auto-submit form on filter change
    document.getElementById('statusFilter').addEventListener('change', function() {
      document.getElementById('filterForm').submit();
    });

    document.getElementById('dateFilter').addEventListener('change', function() {
      document.getElementById('filterForm').submit();
    });

    // Search with debounce
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        document.getElementById('filterForm').submit();
      }, 500);
    });

    // Reset filters
    function resetFilters() {
      window.location.href = '<?php echo e(route("admin.Invoice.index")); ?>';
    }

    // Delete invoice
    function deleteInvoice(invoiceId) {
      const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
      const deleteForm = document.getElementById('deleteForm');
      deleteForm.action = `/admin/invoices/${invoiceId}`;
      deleteModal.show();
    }

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
          const bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        });
      }, 5000);
    });
  </script>
  
  <!-- Control Center for Material Dashboard -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>
</html><?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/Invoice/index.blade.php ENDPATH**/ ?>