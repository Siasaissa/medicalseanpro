@include('layouts.adminHead')

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include('layouts.adminHeader')
        <!-- /Header -->

        <!-- Sidebar -->
        @include('layouts.adminSidebar')
        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Add Product</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Product</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body custom-edit-service">


                                <!-- Add Medicine -->
                                <form enctype="multipart/form-data" autocomplete="off" id="update_service"
                                    action="{{ route('products.store') }}" method="POST">
                                    @csrf

                                    <div class="service-fields mb-3">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="mb-2">Product Name<span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="brand_name"
                                                        id="brand_name2" placeholder="Enter product name" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="mb-2">Category <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select form-control" name="category" required>
                                                        <option value="">Select category</option>
                                                        <option value="Family Care">Family Care</option>
                                                        <option value="Cancer">Cancer</option>
                                                        <option value="Fitness & Wellness">Fitness & Wellness</option>
                                                        <option value="Hair care">Hair care</option>
                                                        <option value="Skin care">Skin care</option>
                                                        <option value="Neoplasms">Neoplasms</option>
                                                        <option value="Women's Care">Women's Care</option>
                                                        <option value="Sleep disorders">Sleep disorders</option>
                                                        <option value="Baby care">Baby care</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="service-fields mb-3">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="mb-2">Price<span class="text-danger">*</span></label>
                                                    <input class="form-control" type="number" name="Price" id="Price2"
                                                        placeholder="Enter price (TZS)" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="mb-2">Quantity<span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control" type="number" name="quantity"
                                                        id="quantity2" placeholder="Enter quantity" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="service-fields mb-3">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="mb-2">Discount (%)</label>
                                                    <input class="form-control" type="number" name="discount"
                                                        id="discount2" placeholder="Enter discount %" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="service-fields mb-3">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="mb-2">Description<span
                                                            class="text-danger">*</span></label>
                                                    <textarea id="about" class="form-control service-desc" name="description"
                                                        placeholder="Write a short product description"
                                                        required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="service-fields mb-3">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="service-upload">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <span>Upload Product Images *</span>
                                                    <input type="file" name="images[]" id="images" multiple
                                                        accept="image/jpeg, image/png, image/gif" required>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn" type="submit" name="form_submit"
                                            value="submit">Submit</button>
                                    </div>
                                </form>

                                <!-- /Add Medicine -->


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{asset('js/jquery-3.7.1.min.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>

    <!-- Slimscroll JS -->
    <script src="{{asset('js/jquery.slimscroll.min.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>

    <!-- Datatables JS -->
    <script src="{{asset('js/jquery.dataTables.min.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>
    <script src="{{asset('js/datatables.min.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>

    <!-- Custom JS -->
    <script src="{{asset('js/script.js')}}" type="d2241dbc8fbf4e82f8c24724-text/javascript"></script>

    <script src="{{asset('js/rocket-loader.min.js')}}" data-cf-settings="d2241dbc8fbf4e82f8c24724-|49"
        defer=""></script>
    <script defer=""
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        data-cf-beacon="{"
        version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfcachestatus":true,"cfedge":true,"cfextpri":true,"cfl4":true,"cforigin":true,"cfspeedbrain":true},"location_startswith":null}}"=""
        crossorigin="anonymous"></script>
    <script>
        $('#images').on('change', function () {
            $('#uploadPreview ul').html(''); // clear old previews
            const files = this.files;
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#uploadPreview ul').append(
                        `<li><div class="upload-images"><img src="${e.target.result}" alt="Preview"></div></li>`
                    );
                }
                reader.readAsDataURL(files[i]);
            }
        });
    </script>
</body>

</html>