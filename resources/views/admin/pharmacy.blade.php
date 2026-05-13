@include('layouts.adminHead')

@php
    $orderBadgeMap = [
        'pending' => 'warning',
        'processing' => 'info',
        'paid' => 'success',
        'failed' => 'danger',
        'cancelled' => 'dark',
        'refunded' => 'secondary',
    ];
@endphp

<body>
    <div class="main-wrapper">
        @include('layouts.adminHeader')
        @include('layouts.adminSidebar')

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Pharmacy Admin</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                                <li class="breadcrumb-item active">Pharmacy</li>
                            </ul>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.addproduct') }}" class="btn btn-primary">Add Product</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-7 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Products</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Stock</th>
                                                <th>Price</th>
                                                <th>Discount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($products as $product)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $product->brand_name }}</strong><br>
                                                        <small class="text-muted">{{ $product->description ? \Illuminate\Support\Str::limit($product->description, 60) : 'No description' }}</small>
                                                    </td>
                                                    <td>{{ $product->category }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>TSh {{ number_format((float) ($product->price ?? 0), 0) }}</td>
                                                    <td>{{ (float) ($product->discount ?? 0) }}%</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">No products available.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Recent Orders</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Customer</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($orders as $order)
                                                <tr>
                                                    <td>#ORD{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                    <td>{{ $order->user->name ?? 'Guest User' }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $orderBadgeMap[$order->status ?? ''] ?? 'secondary' }}-light">
                                                            {{ ucfirst($order->status ?? 'unknown') }}
                                                        </span>
                                                    </td>
                                                    <td>TSh {{ number_format((float) ($order->total ?? 0), 0) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">No recent orders found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('admin.Transaction', ['source' => 'pharmacy']) }}" class="btn btn-outline-primary w-100">Open Transaction Manager</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admincss/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admincss/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admincss/js/feather.min.js') }}"></script>
    <script src="{{ asset('admincss/js/script.js') }}"></script>
</body>
</html>
