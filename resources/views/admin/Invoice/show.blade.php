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
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <h6 class="text-white text-capitalize ps-3">Invoice {{ $invoice->invoice_number }}</h6>
                  </div>
                  <div class="col-md-6 text-end pe-4">
                    <a href="{{ route('admin.Invoice.index') }}" class="btn btn-outline-white btn-sm me-2">
                      Back to List
                    </a>
                    <a href="{{ route('invoices.print', $invoice->id) }}" class="btn btn-outline-white btn-sm me-2" target="_blank">
                      Print PDF
                    </a>
                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-outline-white btn-sm">
                      Edit
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card-body p-4">
              <!-- Status Badge -->
              <div class="text-center mb-4">
                <span class="badge badge-lg bg-gradient-{{ $invoice->status_color }}">
                  {{ ucfirst($invoice->status) }}
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
                      @if($company)
                      <h6 class="text-dark fw-bold mb-2">{{ $company->company_name ?? 'Your Company' }}</h6>
                      <p class="text-sm mb-1">{{ $company->address ?? '' }}</p>
                      <p class="text-sm mb-1">Phone: {{ $company->phone ?? '' }}</p>
                      <p class="text-sm mb-1">Email: {{ $company->email ?? '' }}</p>
                      @if($company->tin)
                      <p class="text-sm mb-0">TIN: {{ $company->tin }}</p>
                      @endif
                      @else
                      <h6 class="text-dark fw-bold mb-2">Greatcare Medics</h6>
                      <p class="text-sm text-muted">Add company details in settings</p>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card border-radius-lg mb-4">
                    <div class="card-header bg-gradient-info">
                      <h6 class="text-white mb-0">Bill To</h6>
                    </div>
                    <div class="card-body">
                      <h6 class="text-dark fw-bold mb-2">{{ $invoice->customer_name }}</h6>
                      <p class="text-sm mb-1">{{ $invoice->customer_address }}</p>
                      <p class="text-sm mb-1">Phone: {{ $invoice->customer_phone }}</p>
                      @if($invoice->customer_email)
                      <p class="text-sm mb-0">Email: {{ $invoice->customer_email }}</p>
                      @endif
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
                        <span class="text-sm font-weight-bold">{{ $invoice->invoice_date->format('M d, Y') }}</span>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Due Date:</span>
                        <span class="text-sm font-weight-bold">{{ $invoice->due_date->format('M d, Y') }}</span>
                      </div>
                      @if($invoice->reference)
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Reference:</span>
                        <span class="text-sm font-weight-bold">{{ $invoice->reference }}</span>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  @if($invoice->isOverdue())
                  <div class="alert alert-danger">
                    <strong>{{ $invoice->days_until_due }}</strong>
                  </div>
                  @elseif($invoice->status !== 'paid')
                  <div class="alert alert-warning">
                    {{ $invoice->days_until_due }}
                  </div>
                  @endif
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
                        @foreach($invoice->items as $index => $item)
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <p class="text-sm font-weight-bold mb-0">{{ $item->product }}</p>
                          </td>
                          <td>
                            <p class="text-sm font-weight-bold mb-0">{{ number_format($item->qty, 2) }}</p>
                          </td>
                          <td>
                            <p class="text-sm font-weight-bold mb-0">Tsh {{ number_format($item->rate, 2) }}</p>
                          </td>
                          <td>
                            <p class="text-sm font-weight-bold mb-0">Tsh {{ number_format($item->amount, 2) }}</p>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- Notes and Totals -->
              <div class="row">
                <div class="col-md-6">
                  @if($invoice->note)
                  <div class="card border-radius-lg mb-4">
                    <div class="card-header bg-gradient-info">
                      <h6 class="text-white mb-0">Notes</h6>
                    </div>
                    <div class="card-body">
                      <p class="text-sm">{{ $invoice->note }}</p>
                    </div>
                  </div>
                  @endif
                </div>
                <div class="col-md-6">
                  <div class="card border-radius-lg">
                    <div class="card-header bg-gradient-info">
                      <h6 class="text-white mb-0">Invoice Summary</h6>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Subtotal:</span>
                        <span class="text-sm font-weight-bold">Tsh {{ number_format($invoice->subtotal, 2) }}</span>
                      </div>
                      @if($invoice->tax_rate > 0)
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Tax ({{ number_format($invoice->tax_rate, 2) }}%):</span>
                        <span class="text-sm font-weight-bold">Tsh {{ number_format($invoice->tax_amount, 2) }}</span>
                      </div>
                      @endif
                      @if($invoice->shipping_charges > 0)
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Shipping:</span>
                        <span class="text-sm font-weight-bold">Tsh {{ number_format($invoice->shipping_charges, 2) }}</span>
                      </div>
                      @endif
                      <hr>
                      <div class="d-flex justify-content-between">
                        <span class="text-sm font-weight-bold">Grand Total:</span>
                        <span class="text-sm font-weight-bold text-primary">Tsh {{ number_format($invoice->grand_total, 2) }}</span>
                      </div>
                      @if($invoice->paid_amount > 0)
                      <hr>
                      <div class="d-flex justify-content-between text-success mb-2">
                        <span class="text-sm">Paid Amount:</span>
                        <span class="text-sm font-weight-bold">Tsh {{ number_format($invoice->paid_amount, 2) }}</span>
                      </div>
                      <div class="d-flex justify-content-between text-danger">
                        <span class="text-sm font-weight-bold">Balance Due:</span>
                        <span class="text-sm font-weight-bold">Tsh {{ number_format($invoice->balance, 2) }}</span>
                      </div>
                      @endif
                      
                      @if($invoice->status === 'paid')
                      <div class="alert alert-success text-center mt-3">
                        <strong>PAID IN FULL</strong>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>

              <!-- Payment Info -->
              @if($company && $company->bank_details)
              <div class="card border-radius-lg mt-4">
                <div class="card-header bg-gradient-info">
                  <h6 class="text-white mb-0">Payment Information</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    @php
                      $banks = json_decode($company->bank_details, true);
                    @endphp
                    @if($banks)
                      @foreach($banks as $bank)
                      <div class="col-md-6 mb-3">
                        <p class="text-sm mb-1"><strong>Bank:</strong> {{ $bank['bank_name'] ?? '' }}</p>
                        <p class="text-sm mb-1"><strong>Account:</strong> {{ $bank['account_number'] ?? '' }}</p>
                        <p class="text-sm mb-0"><strong>Branch:</strong> {{ $bank['branch'] ?? '' }}</p>
                      </div>
                      @endforeach
                    @endif
                  </div>
                </div>
              </div>
              @endif
            </div>

            <!-- Footer -->
            <div class="card-footer text-center text-muted">
              <p class="text-sm mb-0">Thank you for your business!</p>
              <small class="text-xs">Generated on {{ now()->format('M d, Y H:i:s') }}</small>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Footer -->
      @include('layouts.adminfooter')
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
        <form method="POST" action="{{ route('invoices.markAsPaid', $invoice->id) }}">
          @csrf
          <div class="modal-body">
            <div class="alert alert-info">
              <strong>Balance Due:</strong> Tsh {{ number_format($invoice->balance, 2) }}
            </div>
            
            <div class="mb-3">
              <div class="input-group input-group-outline">
                <label class="form-label">Payment Amount (Tsh) *</label>
                <input type="number" name="amount" class="form-control" 
                       step="0.01" min="0.01" max="{{ $invoice->balance }}" 
                       value="{{ $invoice->balance }}" required>
              </div>
              <small class="text-muted">Maximum: Tsh {{ number_format($invoice->balance, 2) }}</small>
            </div>

            <div class="mb-3">
              <div class="input-group input-group-outline">
                <label class="form-label">Payment Date</label>
                <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}">
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
    @if(session('success'))
      setTimeout(function() {
        const alert = document.querySelector('.alert-success');
        if (alert) {
          new bootstrap.Alert(alert).close();
        }
      }, 5000);
    @endif
  </script>
  
  <!-- Control Center for Material Dashboard -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>
</html>