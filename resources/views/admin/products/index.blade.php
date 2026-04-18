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
              <div class="bg-gradient-dark  shadow-dark border-radius-lg pt-4 pb-3">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <h6 class="text-white text-capitalize ps-3">Manage Products</h6>
                  </div>
                  <div class="col-md-6 text-end pe-4">
                    <!-- Add Single Product Button -->
                    <button class="btn btn-outline-white btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addProductModal">
                      <i class="material-symbols-rounded me-1">add</i> Add Product
                    </button>
                    <!-- Upload Excel Button -->
                    <button class="btn btn-outline-white btn-sm" data-bs-toggle="modal" data-bs-target="#uploadExcelModal">
                      <i class="material-symbols-rounded me-1">upload</i> Upload Excel
                    </button>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card-body px-0 pb-2">
              <!-- Products Table -->
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Units</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($products ?? [] as $product)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <div class="icon icon-sm icon-shape bg-gradient-info shadow text-center border-radius-md">
                              <i class="material-symbols-rounded opacity-10 text-white">inventory</i>
                            </div>
                          </div>
                          <div class="d-flex flex-column justify-content-center ms-3">
                            <h6 class="mb-0 text-sm">{{ $product->name }}</h6>
                            <p class="text-xs text-secondary mb-0">ID: {{ $product->id ?? 'N/A' }}</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">Tsh {{ number_format($product->price, 2) }}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                          {{ $product->stock ?? 'N/A' }}
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $product->unit ?? 'N/A' }}</span>
                      </td>
                      <td class="align-middle text-center">
                        @if($product->image)
                          <div class="avatar avatar-sm me-3">
                            <img src="{{ $product->image ? url('storage/' . $product->image) : url('img/defaultmedical.jpg') }}" alt="{{ $product->name }}" class="border-radius-sm" style="width: 60px; height: 60px; object-fit: cover;">
                          </div>
                        @else
                          <span class="badge badge-sm bg-gradient-secondary">
                            <i class="material-symbols-rounded opacity-10">no_photography</i>
                          </span>
                        @endif
                      </td>
                      <td class="align-middle text-center">
                        <!-- Edit Button -->
                        <button 
                          class="btn btn-sm btn-outline-warning me-1 edit-product-btn" 
                          data-bs-toggle="modal" 
                          data-bs-target="#editProductModal"
                          data-product-id="{{ $product->id }}"
                          data-product-name="{{ $product->name }}"
                          data-product-price="{{ $product->price }}"
                          data-product-stock="{{ $product->stock }}"
                          data-product-unit="{{ $product->unit }}"
                          data-product-image="{{ $product->image }}"
                          data-update-url="{{ route('admin.products.update', $product->id) }}">
                          <i class="material-symbols-rounded opacity-10">edit</i>
                        </button>

                        <!-- Delete Form -->
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline-block delete-form">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirmDelete()">
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
                            <i class="material-symbols-rounded opacity-10 text-white">inventory_2</i>
                          </div>
                          <h6 class="mb-0 text-sm">No Products Found</h6>
                          <p class="text-xs text-secondary mb-0">Add your first product to get started</p>
                        </div>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              
              <!-- Pagination -->
              @if(isset($products) && $products->hasPages())
              <div class="card-footer d-flex justify-content-center pt-0">
                <nav aria-label="Page navigation text-white">
                  <ul class="pagination pagination-dark justify-content-center text-white">
                    {{ $products->links('pagination::bootstrap-4') }}
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

  <!-- ========== MODALS (PLACE OUTSIDE TABLE) ========== -->
  
  <!-- Upload Excel Modal -->
  <div class="modal fade" id="uploadExcelModal" tabindex="-1" aria-labelledby="uploadExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="{{ route('admin.products.uploadExcel') }}" method="POST" enctype="multipart/form-data" id="uploadExcelForm">
          @csrf
          <div class="modal-header bg-gradient-success">
            <h5 class="modal-title text-white" id="uploadExcelModalLabel">
              <i class="material-symbols-rounded me-2">upload_file</i> Upload Products via Excel
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Upload an Excel file (.xlsx or .csv) with the following columns: <strong>name, price, stock, unit</strong>.</p>
            <div class="input-group input-group-outline mb-4">
              <input type="file" name="excel_file" class="form-control" accept=".xlsx,.csv,.xls" required>
            </div>
            <div class="alert alert-info">
              <small>
                <i class="material-symbols-rounded me-1">info</i>
                Download <a href="{{ asset('templates/products_template.xlsx') }}" class="text-primary">Excel template</a> for proper formatting
              </small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success" id="uploadExcelBtn">
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
              Upload
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Add Product Modal -->
  <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
          @csrf
          <div class="modal-header bg-gradient-primary">
            <h5 class="modal-title text-white" id="addProductModalLabel">
              <i class="material-symbols-rounded me-2">add_circle</i> Add New Product
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="input-group input-group-outline my-3">
              <input type="text" name="name" class="form-control" placeholder="Product Name *" required >
            </div>
            <div class="input-group input-group-outline my-3">
              <input type="number" name="price" class="form-control" placeholder="Price (Tsh) *" required>
            </div>
            <div class="input-group input-group-outline my-3">
              <input type="number" name="stock" class="form-control" placeholder="Stock Quantity">
            </div>
            <div class="input-group input-group-outline my-3">
              <input type="text" name="unit" class="form-control" placeholder="Units (e.g., kg, pcs, liters)">
            </div>
            <div class="input-group input-group-outline my-3">
              <input type="file" name="image" class="form-control" accept="image/*" placeholder="Max size: 2MB. Supported: JPG, PNG, JPEG">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="addProductBtn">
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
              Add Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Product Modal (SINGLE MODAL FOR ALL PRODUCTS) -->
  <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="POST" enctype="multipart/form-data" id="editProductForm">
          @csrf
          @method('PUT')
          <div class="modal-header bg-gradient-warning">
            <h5 class="modal-title text-white" id="editProductModalLabel">
              <i class="material-symbols-rounded me-2">edit</i> Edit Product
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="edit_product_id" name="product_id">
            <div class="input-group input-group-outline my-3">
              
              <input type="text" name="name" id="edit_product_name" class="form-control" required>
            </div>
            <div class="input-group input-group-outline my-3">

              <input type="number" name="price" id="edit_product_price" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="input-group input-group-outline my-3">
              <input type="number" name="stock" id="edit_product_stock" class="form-control" min="0">
            </div>
            <div class="input-group input-group-outline my-3">
              <input type="text" name="unit" id="edit_product_unit" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div id="currentImageContainer" class="mb-3 d-none">
              <div class="mt-2">
                <img id="currentProductImage" src="{{ $product->image ? url('storage/' . $product->image) : url('img/defaultmedical.jpg') }}" alt="Current Image" class="img-thumbnail" style="max-width: 100px;">
                <a href="#" id="viewImageLink" target="_blank" class="ms-2 text-info">View Full Size</a>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-warning" id="updateProductBtn">
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
              Update Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap & jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  
  <script>
    // Confirm delete function
    function confirmDelete() {
      return confirm('Are you sure you want to delete this product? This action cannot be undone.');
    }

    // Handle edit button clicks
    document.addEventListener('DOMContentLoaded', function() {
      // Edit product modal handler
      const editButtons = document.querySelectorAll('.edit-product-btn');
      const editModal = document.getElementById('editProductModal');
      const editForm = document.getElementById('editProductForm');
      const currentImageContainer = document.getElementById('currentImageContainer');
      const currentProductImage = document.getElementById('currentProductImage');
      const viewImageLink = document.getElementById('viewImageLink');
      
      editButtons.forEach(button => {
        button.addEventListener('click', function() {
          const productId = this.getAttribute('data-product-id');
          const productName = this.getAttribute('data-product-name');
          const productPrice = this.getAttribute('data-product-price');
          const productStock = this.getAttribute('data-product-stock');
          const productUnit = this.getAttribute('data-product-unit');
          const productImage = this.getAttribute('data-product-image');
          const updateUrl = this.getAttribute('data-update-url');
          
          // Fill form fields
          document.getElementById('edit_product_id').value = productId;
          document.getElementById('edit_product_name').value = productName;
          document.getElementById('edit_product_price').value = productPrice;
          document.getElementById('edit_product_stock').value = productStock;
          document.getElementById('edit_product_unit').value = productUnit;
          
          // Set form action
          editForm.action = updateUrl;
          
          // Handle image display
          if (productImage) {
            const imageUrl = "{{ asset('storage/') }}/" + productImage;
            currentProductImage.src = imageUrl;
            viewImageLink.href = imageUrl;
            currentImageContainer.classList.remove('d-none');
          } else {
            currentImageContainer.classList.add('d-none');
          }
        });
      });

      // Form submission handlers with loading states
      const forms = ['addProductForm', 'editProductForm', 'uploadExcelForm'];
      const buttons = ['addProductBtn', 'updateProductBtn', 'uploadExcelBtn'];
      
      forms.forEach((formId, index) => {
        const form = document.getElementById(formId);
        const button = document.getElementById(buttons[index]);
        
        if (form) {
          form.addEventListener('submit', function(e) {
            // Basic validation
            const requiredInputs = this.querySelectorAll('input[required]');
            let isValid = true;
            
            requiredInputs.forEach(input => {
              if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');
              } else {
                input.classList.remove('is-invalid');
              }
            });
            
            if (!isValid) {
              e.preventDefault();
              alert('Please fill in all required fields.');
              return;
            }
            
            // Show loading state
            if (button) {
              const spinner = button.querySelector('.spinner-border');
              const buttonText = button.innerHTML;
              button.disabled = true;
              button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
              
              // Re-enable button if form submission fails
              setTimeout(() => {
                button.disabled = false;
                button.innerHTML = buttonText;
              }, 5000);
            }
          });
        }
      });

      // File input preview for add/edit modals
      const fileInputs = document.querySelectorAll('input[type="file"][accept="image/*"]');
      fileInputs.forEach(input => {
        input.addEventListener('change', function() {
          const file = this.files[0];
          if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
              alert('File size must be less than 2MB');
              this.value = '';
              return;
            }
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
              alert('Only JPG, JPEG, and PNG files are allowed');
              this.value = '';
              return;
            }
            
            // Show preview if it's in edit modal
            if (this.closest('#editProductModal')) {
              const reader = new FileReader();
              reader.onload = function(e) {
                currentProductImage.src = e.target.result;
                currentImageContainer.classList.remove('d-none');
              };
              reader.readAsDataURL(file);
            }
          }
        });
      });

      // Initialize Bootstrap tooltips
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });

      // Clear form on modal hide
      const addProductModal = document.getElementById('addProductModal');
      if (addProductModal) {
        addProductModal.addEventListener('hidden.bs.modal', function() {
          document.getElementById('addProductForm').reset();
        });
      }

      // Clear edit form on hide
      if (editModal) {
        editModal.addEventListener('hidden.bs.modal', function() {
          document.getElementById('editProductForm').reset();
          currentImageContainer.classList.add('d-none');
        });
      }
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