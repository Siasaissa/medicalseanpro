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
                    @forelse($orders ?? [] as $order)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">#{{ $order->id }}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">{{ $order->name }}</p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">{{ $order->phone }}</p>
                      </td>
                      <td>
                        <div class="d-flex flex-column">
                          @if(!empty($order->items))
                            @php
                              $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
                            @endphp
                            <span class="text-xs text-secondary mb-0">
                              {{ collect($items)->pluck('name')->join(', ') }}
                            </span>
                          @else
                            <span class="text-xs text-muted">N/A</span>
                          @endif
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-sm font-weight-bold">Tsh {{ number_format($order->total, 2) }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <!-- View Button -->
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-info me-1">
                          <i class="material-symbols-rounded opacity-10">visibility</i>
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline-block">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this order?')">
                            <i class="material-symbols-rounded opacity-10">delete</i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    @empty
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
                    @endforelse
                  </tbody>
                </table>
              </div>
              
              <!-- Pagination -->
              @if(isset($orders) && $orders->hasPages())
              <div class="card-footer d-flex justify-content-center pt-0">
                <nav aria-label="Page navigation">
                  <ul class="pagination pagination-dark justify-content-center text-white">
                    {{ $orders->links('pagination::bootstrap-4') }}
                  </ul>
                </nav>
              </div>
              @endif
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
</html>