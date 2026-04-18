@include('layouts.adminhead')

<body class="g-sidenav-show bg-gray-100">
  @include('layouts.aside')
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    @include('layouts.navbar')
    <!-- End Navbar -->
    
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-warning shadow-warning border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Edit Invoice {{ $invoice->invoice_number }}</h6>
              </div>
            </div>
            
            <div class="card-body">
              @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
              @endif

              <form method="POST" action="{{ route('invoices.update', $invoice->id) }}" id="invoiceForm">
                @csrf
                @method('PUT')

                <!-- Customer Information -->
                <div class="card mb-4">
                  <div class="card-header bg-gradient-info">
                    <h6 class="text-white mb-0">Customer Information</h6>
                  </div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <div class="input-group input-group-outline">
                          <label class="form-label">Customer Name *</label>
                          <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" 
                                 value="{{ old('customer_name', $invoice->customer_name) }}" required>
                          @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="input-group input-group-outline">
                          <label class="form-label">Customer Phone *</label>
                          <input type="text" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" 
                                 value="{{ old('customer_phone', $invoice->customer_phone) }}" required>
                          @error('customer_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="mb-3">
                      <div class="input-group input-group-outline">
                        <label class="form-label">Customer Address *</label>
                        <textarea name="customer_address" class="form-control @error('customer_address') is-invalid @enderror" rows="2" required>{{ old('customer_address', $invoice->customer_address) }}</textarea>
                        @error('customer_address')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="mb-3">
                      <div class="input-group input-group-outline">
                        <label class="form-label">Customer Email (Optional)</label>
                        <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" 
                               value="{{ old('customer_email', $invoice->customer_email) }}">
                        @error('customer_email')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Invoice Details -->
                <div class="card mb-4">
                  <div class="card-header bg-gradient-info">
                    <h6 class="text-white mb-0">Invoice Details</h6>
                  </div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-md-4">
                        <div class="input-group input-group-outline">
                          <label class="form-label">Invoice Date *</label>
                          <input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" 
                                 value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}" required>
                          @error('invoice_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group input-group-outline">
                          <label class="form-label">Due Date *</label>
                          <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" 
                                 value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required>
                          @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group input-group-outline">
                          <label class="form-label">Reference Number</label>
                          <input type="text" name="reference" class="form-control @error('reference') is-invalid @enderror" 
                                 value="{{ old('reference', $invoice->reference) }}">
                          @error('reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Products Section -->
                <div class="card mb-4">
                  <div class="card-header bg-gradient-info">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="text-white mb-0">Products / Services</h6>
                      <button type="button" class="btn btn-sm btn-outline-white" id="addItemBtn">
                        Add Item
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table align-items-center mb-0" id="itemsTable">
                        <thead>
                          <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description *</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity *</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price (Tsh) *</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount (Tsh)</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                          </tr>
                        </thead>
                        <tbody id="invoiceItems">
                          @foreach($invoice->items as $index => $item)
                          <tr class="item-row">
                            <td>
                              <div class="input-group input-group-outline">
                                <input type="text" name="items[{{ $index }}][product]" 
                                       class="form-control item-product" 
                                       value="{{ $item->product }}" required>
                              </div>
                            </td>
                            <td>
                              <div class="input-group input-group-outline">
                                <input type="number" name="items[{{ $index }}][qty]" 
                                       class="form-control item-qty" step="0.01" 
                                       value="{{ $item->qty }}" min="0.01" required>
                              </div>
                            </td>
                            <td>
                              <div class="input-group input-group-outline">
                                <input type="number" name="items[{{ $index }}][rate]" 
                                       class="form-control item-rate" step="0.01" 
                                       value="{{ $item->rate }}" min="0" required>
                              </div>
                            </td>
                            <td>
                              <div class="input-group input-group-outline">
                                <input type="text" class="form-control item-amount" 
                                       value="{{ $item->amount }}" readonly>
                              </div>
                            </td>
                            <td class="text-center">
                              <button type="button" class="btn btn-sm btn-outline-danger remove-item" {{ $loop->first && $invoice->items->count() == 1 ? 'disabled' : '' }}>
                                <i class="material-symbols-rounded opacity-10">delete</i>
                              </button>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <!-- Additional Information -->
                <div class="card mb-4">
                  <div class="card-header bg-gradient-info">
                    <h6 class="text-white mb-0">Additional Information</h6>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <div class="input-group input-group-outline">
                            <label class="form-label">Shipping Charges (Tsh)</label>
                            <input type="number" name="shipping_charges" id="shipping_charges" 
                                   class="form-control" step="0.01" 
                                   value="{{ old('shipping_charges', $invoice->shipping_charges) }}" min="0">
                          </div>
                        </div>
                        <div class="mb-3">
                          <div class="input-group input-group-outline">
                            <label class="form-label">Tax Rate (%)</label>
                            <input type="number" name="tax_rate" id="tax_rate" 
                                   class="form-control" step="0.01" 
                                   value="{{ old('tax_rate', $invoice->tax_rate) }}" min="0" max="100">
                          </div>
                        </div>
                        <div class="mb-3">
                          <div class="input-group input-group-outline">
                            <label class="form-label">Notes (Optional)</label>
                            <textarea name="note" class="form-control" rows="3">{{ old('note', $invoice->note) }}</textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="p-4 bg-gradient-light rounded">
                          <h6 class="mb-3">Invoice Summary</h6>
                          <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong id="subtotal">{{ number_format($invoice->subtotal, 2) }}</strong>
                          </div>
                          <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <strong id="tax_amount">{{ number_format($invoice->tax_amount, 2) }}</strong>
                          </div>
                          <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <strong id="shipping_display">{{ number_format($invoice->shipping_charges, 2) }}</strong>
                          </div>
                          <hr>
                          <div class="d-flex justify-content-between">
                            <span class="fw-bold">Grand Total:</span>
                            <strong class="text-primary fs-5" id="grand_total">{{ number_format($invoice->grand_total, 2) }}</strong>
                          </div>
                          @if($invoice->paid_amount > 0)
                          <hr>
                          <div class="d-flex justify-content-between text-success">
                            <span>Paid Amount:</span>
                            <strong>{{ number_format($invoice->paid_amount, 2) }}</strong>
                          </div>
                          <div class="d-flex justify-content-between text-danger">
                            <span>Balance:</span>
                            <strong>{{ number_format($invoice->balance, 2) }}</strong>
                          </div>
                          @endif
                          <div class="mt-3 text-muted">
                            <small>Amounts in Tanzanian Shillings</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="d-flex justify-content-between">
                  <a href="{{ route('admin.Invoice.index') }}" class="btn btn-outline-secondary">
                    Back to List
                  </a>
                  <button type="submit" class="btn btn-warning">
                    Update Invoice
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Footer -->
      @include('layouts.adminfooter')
    </div>
  </main>

  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      let itemCounter = {{ $invoice->items->count() }};
      const itemsContainer = document.getElementById('invoiceItems');
      const addItemBtn = document.getElementById('addItemBtn');

      // Add new item row
      addItemBtn.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        newRow.innerHTML = `
          <td>
            <div class="input-group input-group-outline">
              <input type="text" name="items[${itemCounter}][product]" class="form-control item-product" required>
            </div>
          </td>
          <td>
            <div class="input-group input-group-outline">
              <input type="number" name="items[${itemCounter}][qty]" class="form-control item-qty" step="0.01" value="1" min="0.01" required>
            </div>
          </td>
          <td>
            <div class="input-group input-group-outline">
              <input type="number" name="items[${itemCounter}][rate]" class="form-control item-rate" step="0.01" min="0" required>
            </div>
          </td>
          <td>
            <div class="input-group input-group-outline">
              <input type="text" class="form-control item-amount" readonly>
            </div>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger remove-item">
              <i class="material-symbols-rounded opacity-10">delete</i>
            </button>
          </td>
        `;
        itemsContainer.appendChild(newRow);
        itemCounter++;
        
        // Enable delete button for first item if there are multiple items
        if (document.querySelectorAll('.item-row').length > 1) {
          document.querySelectorAll('.remove-item').forEach(btn => btn.disabled = false);
        }
        
        attachCalculationListeners();
        calculateTotals();
      });

      // Remove item row
      document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
          const row = e.target.closest('.item-row');
          if (document.querySelectorAll('.item-row').length > 1) {
            row.remove();
            updateItemNames();
            
            // Disable delete button for first item if only one item remains
            if (document.querySelectorAll('.item-row').length === 1) {
              document.querySelector('.item-row .remove-item').disabled = true;
            }
            
            calculateTotals();
          }
        }
      });

      // Update item names after removal
      function updateItemNames() {
        document.querySelectorAll('.item-row').forEach((row, index) => {
          row.querySelector('.item-product').name = `items[${index}][product]`;
          row.querySelector('.item-qty').name = `items[${index}][qty]`;
          row.querySelector('.item-rate').name = `items[${index}][rate]`;
        });
        itemCounter = document.querySelectorAll('.item-row').length;
      }

      // Attach calculation listeners
      function attachCalculationListeners() {
        document.querySelectorAll('.item-qty, .item-rate').forEach(input => {
          input.removeEventListener('input', calculateItemAmount);
          input.addEventListener('input', calculateItemAmount);
        });
        
        document.getElementById('shipping_charges').removeEventListener('input', calculateTotals);
        document.getElementById('tax_rate').removeEventListener('input', calculateTotals);
        
        document.getElementById('shipping_charges').addEventListener('input', calculateTotals);
        document.getElementById('tax_rate').addEventListener('input', calculateTotals);
      }

      // Calculate item amount
      function calculateItemAmount(e) {
        const row = e.target.closest('.item-row');
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const rate = parseFloat(row.querySelector('.item-rate').value) || 0;
        const amount = qty * rate;
        row.querySelector('.item-amount').value = amount.toFixed(2);
        calculateTotals();
      }

      // Calculate totals
      function calculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.item-amount').forEach(input => {
          subtotal += parseFloat(input.value) || 0;
        });
        
        const shipping = parseFloat(document.getElementById('shipping_charges').value) || 0;
        const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
        const taxAmount = (subtotal * taxRate) / 100;
        const grandTotal = subtotal + taxAmount + shipping;
        
        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('tax_amount').textContent = taxAmount.toFixed(2);
        document.getElementById('shipping_display').textContent = shipping.toFixed(2);
        document.getElementById('grand_total').textContent = grandTotal.toFixed(2);
      }

      // Form validation
      document.getElementById('invoiceForm').addEventListener('submit', function(e) {
        const items = document.querySelectorAll('.item-row');
        if (items.length === 0) {
          e.preventDefault();
          alert('Please add at least one item to the invoice.');
          return false;
        }
        
        calculateTotals();
      });

      // Initialize calculations
      attachCalculationListeners();
      calculateTotals();
    });
  </script>
  
  <!-- Control Center for Material Dashboard -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>
</html>