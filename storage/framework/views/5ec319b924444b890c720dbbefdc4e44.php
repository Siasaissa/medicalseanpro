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
                    <h6 class="text-white text-capitalize ps-3">Invoice <?php echo e($invoice->invoice_number); ?></h6>
                  </div>
                  <div class="col-md-6 text-end pe-4">
                    <a href="<?php echo e(route('admin.Invoice.index')); ?>" class="btn btn-outline-white btn-sm me-2">
                      Back to List
                    </a>
                    <a href="<?php echo e(route('invoices.print', $invoice->id)); ?>" class="btn btn-outline-white btn-sm me-2" target="_blank">
                      Print PDF
                    </a>
                    <a href="<?php echo e(route('invoices.edit', $invoice->id)); ?>" class="btn btn-outline-white btn-sm">
                      Edit
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card-body p-4">
              <!-- Status Badge -->
              <div class="text-center mb-4">
                <span class="badge badge-lg bg-gradient-<?php echo e($invoice->status_color); ?>">
                  <?php echo e(ucfirst($invoice->status)); ?>

                </span>
              </div>

              <!-- Company and Customer Info -->
              <div class="row mb-4">
                <div class="col-md-6">
                  <div class="card border-radius-lg mb-4">
                    <div class="card-header bg-gradient-info">
                      <h6 class="text-white mb-0">From</h6>
                    </div>
                    <div class="card-body">
                      <?php if($company): ?>
                      <h6 class="text-dark fw-bold mb-2"><?php echo e($company->company_name ?? 'Your Company'); ?></h6>
                      <p class="text-sm mb-1"><?php echo e($company->address ?? ''); ?></p>
                      <p class="text-sm mb-1">Phone: <?php echo e($company->phone ?? ''); ?></p>
                      <p class="text-sm mb-1">Email: <?php echo e($company->email ?? ''); ?></p>
                      <?php if($company->tin): ?>
                      <p class="text-sm mb-0">TIN: <?php echo e($company->tin); ?></p>
                      <?php endif; ?>
                      <?php else: ?>
                      <h6 class="text-dark fw-bold mb-2">Greatcare Medics</h6>
                      <p class="text-sm text-muted">Add company details in settings</p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card border-radius-lg mb-4">
                    <div class="card-header bg-gradient-info">
                      <h6 class="text-white mb-0">Bill To</h6>
                    </div>
                    <div class="card-body">
                      <h6 class="text-dark fw-bold mb-2"><?php echo e($invoice->customer_name); ?></h6>
                      <p class="text-sm mb-1"><?php echo e($invoice->customer_address); ?></p>
                      <p class="text-sm mb-1">Phone: <?php echo e($invoice->customer_phone); ?></p>
                      <?php if($invoice->customer_email): ?>
                      <p class="text-sm mb-0">Email: <?php echo e($invoice->customer_email); ?></p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Invoice Details -->
              <div class="row mb-4">
                <div class="col-md-6">
                  <div class="card border-radius-lg">
                    <div class="card-body">
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Invoice Date:</span>
                        <span class="text-sm font-weight-bold"><?php echo e($invoice->invoice_date->format('M d, Y')); ?></span>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Due Date:</span>
                        <span class="text-sm font-weight-bold"><?php echo e($invoice->due_date->format('M d, Y')); ?></span>
                      </div>
                      <?php if($invoice->reference): ?>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Reference:</span>
                        <span class="text-sm font-weight-bold"><?php echo e($invoice->reference); ?></span>
                      </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <?php if($invoice->isOverdue()): ?>
                  <div class="alert alert-danger">
                    <strong><?php echo e($invoice->days_until_due); ?></strong>
                  </div>
                  <?php elseif($invoice->status !== 'paid'): ?>
                  <div class="alert alert-warning">
                    <?php echo e($invoice->days_until_due); ?>

                  </div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Items Table -->
              <div class="card border-radius-lg mb-4">
                <div class="card-header bg-gradient-info">
                  <h6 class="text-white mb-0">Items</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm"><?php echo e($index + 1); ?></h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <p class="text-sm font-weight-bold mb-0"><?php echo e($item->product); ?></p>
                          </td>
                          <td>
                            <p class="text-sm font-weight-bold mb-0"><?php echo e(number_format($item->qty, 2)); ?></p>
                          </td>
                          <td>
                            <p class="text-sm font-weight-bold mb-0">Tsh <?php echo e(number_format($item->rate, 2)); ?></p>
                          </td>
                          <td>
                            <p class="text-sm font-weight-bold mb-0">Tsh <?php echo e(number_format($item->amount, 2)); ?></p>
                          </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- Notes and Totals -->
              <div class="row">
                <div class="col-md-6">
                  <?php if($invoice->note): ?>
                  <div class="card border-radius-lg mb-4">
                    <div class="card-header bg-gradient-info">
                      <h6 class="text-white mb-0">Notes</h6>
                    </div>
                    <div class="card-body">
                      <p class="text-sm"><?php echo e($invoice->note); ?></p>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
                <div class="col-md-6">
                  <div class="card border-radius-lg">
                    <div class="card-header bg-gradient-info">
                      <h6 class="text-white mb-0">Invoice Summary</h6>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Subtotal:</span>
                        <span class="text-sm font-weight-bold">Tsh <?php echo e(number_format($invoice->subtotal, 2)); ?></span>
                      </div>
                      <?php if($invoice->tax_rate > 0): ?>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Tax (<?php echo e(number_format($invoice->tax_rate, 2)); ?>%):</span>
                        <span class="text-sm font-weight-bold">Tsh <?php echo e(number_format($invoice->tax_amount, 2)); ?></span>
                      </div>
                      <?php endif; ?>
                      <?php if($invoice->shipping_charges > 0): ?>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Shipping:</span>
                        <span class="text-sm font-weight-bold">Tsh <?php echo e(number_format($invoice->shipping_charges, 2)); ?></span>
                      </div>
                      <?php endif; ?>
                      <hr>
                      <div class="d-flex justify-content-between">
                        <span class="text-sm font-weight-bold">Grand Total:</span>
                        <span class="text-sm font-weight-bold text-primary">Tsh <?php echo e(number_format($invoice->grand_total, 2)); ?></span>
                      </div>
                      <?php if($invoice->paid_amount > 0): ?>
                      <hr>
                      <div class="d-flex justify-content-between text-success mb-2">
                        <span class="text-sm">Paid Amount:</span>
                        <span class="text-sm font-weight-bold">Tsh <?php echo e(number_format($invoice->paid_amount, 2)); ?></span>
                      </div>
                      <div class="d-flex justify-content-between text-danger">
                        <span class="text-sm font-weight-bold">Balance Due:</span>
                        <span class="text-sm font-weight-bold">Tsh <?php echo e(number_format($invoice->balance, 2)); ?></span>
                      </div>
                      <?php endif; ?>
                      
                      <?php if($invoice->status === 'paid'): ?>
                      <div class="alert alert-success text-center mt-3">
                        <strong>PAID IN FULL</strong>
                      </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Payment Info -->
              <?php if($company && $company->bank_details): ?>
              <div class="card border-radius-lg mt-4">
                <div class="card-header bg-gradient-info">
                  <h6 class="text-white mb-0">Payment Information</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <?php
                      $banks = json_decode($company->bank_details, true);
                    ?>
                    <?php if($banks): ?>
                      <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div class="col-md-6 mb-3">
                        <p class="text-sm mb-1"><strong>Bank:</strong> <?php echo e($bank['bank_name'] ?? ''); ?></p>
                        <p class="text-sm mb-1"><strong>Account:</strong> <?php echo e($bank['account_number'] ?? ''); ?></p>
                        <p class="text-sm mb-0"><strong>Branch:</strong> <?php echo e($bank['branch'] ?? ''); ?></p>
                      </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <?php endif; ?>
            </div>

            <!-- Footer -->
            <div class="card-footer text-center text-muted">
              <p class="text-sm mb-0">Thank you for your business!</p>
              <small class="text-xs">Generated on <?php echo e(now()->format('M d, Y H:i:s')); ?></small>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Footer -->
      <?php echo $__env->make('layouts.adminfooter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
  </main>

  <!-- Payment Modal -->
  <div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-gradient-success">
          <h5 class="modal-title text-white">Record Payment</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="<?php echo e(route('invoices.markAsPaid', $invoice->id)); ?>">
          <?php echo csrf_field(); ?>
          <div class="modal-body">
            <div class="alert alert-info">
              <strong>Balance Due:</strong> Tsh <?php echo e(number_format($invoice->balance, 2)); ?>

            </div>
            
            <div class="mb-3">
              <div class="input-group input-group-outline">
                <label class="form-label">Payment Amount (Tsh) *</label>
                <input type="number" name="amount" class="form-control" 
                       step="0.01" min="0.01" max="<?php echo e($invoice->balance); ?>" 
                       value="<?php echo e($invoice->balance); ?>" required>
              </div>
              <small class="text-muted">Maximum: Tsh <?php echo e(number_format($invoice->balance, 2)); ?></small>
            </div>

            <div class="mb-3">
              <div class="input-group input-group-outline">
                <label class="form-label">Payment Date</label>
                <input type="date" name="payment_date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
              </div>
            </div>

            <div class="mb-3">
              <div class="input-group input-group-outline">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" class="form-control">
                  <option value="">Select method...</option>
                  <option value="cash">Cash</option>
                  <option value="bank_transfer">Bank Transfer</option>
                  <option value="mobile_money">Mobile Money</option>
                  <option value="cheque">Cheque</option>
                  <option value="other">Other</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <div class="input-group input-group-outline">
                <label class="form-label">Payment Note</label>
                <textarea name="payment_note" class="form-control" rows="2" placeholder="Optional notes..."></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">
              Record Payment
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  
  <script>
    // Success messages
    <?php if(session('success')): ?>
      setTimeout(function() {
        const alert = document.querySelector('.alert-success');
        if (alert) {
          new bootstrap.Alert(alert).close();
        }
      }, 5000);
    <?php endif; ?>
  </script>
  
  <!-- Control Center for Material Dashboard -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>
</html><?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/Invoice/show.blade.php ENDPATH**/ ?>