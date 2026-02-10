@include('layouts.head')

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include('layouts.header')
        <!-- /Header -->

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Pharmacy</li>
                                <li class="breadcrumb-item active">Cart</li>
                            </ol>
                            <h2 class="breadcrumb-title">Cart</h2>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-bg">
                <img src="{{ asset('images/breadcrumb-bg-01.png') }}" alt="img" class="breadcrumb-bg-01">
                <img src="{{ asset('images/breadcrumb-bg-02.png') }}" alt="img" class="breadcrumb-bg-02">
                <img src="{{ asset('images/breadcrumb-icon.webp') }}" alt="img" class="breadcrumb-bg-03">
                <img src="{{ asset('images/breadcrumb-icon.webp') }}" alt="img" class="breadcrumb-bg-04">
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content">
            <div class="container">

                <div class="card card-table">
                    <div class="card-body">

                        @if(count($cart) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $item)
                                    <tr data-id="{{ $item['id'] }}">
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="product-description.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img"
                                                        src="{{ isset($item['image']) ? asset('storage/'.$item['image']) : asset('images/product.jpg') }}"
                                                        alt="{{ $item['name'] }}">
                                                </a>
                                            </h2>
                                            <a href="product-description.html">{{ $item['name'] }}</a>
                                        </td>

                                        <td>Tsh {{ number_format($item['price']) }}</td>
                                        <td class="text-center">
                                            <div class="custom-increment cart">
                                                <div class="input-group1">
                                                    <span class="input-group-btn">
                                                        <button type="button"
                                                            class="quantity-left-minus btn btn-danger btn-number">
                                                            <span><i class="fas fa-minus"></i></span>
                                                        </button>
                                                    </span>
                                                    <input type="text" name="quantity"
                                                        class="input-number quantity-input"
                                                        value="{{ $item['quantity'] ?? 1 }}" readonly>
                                                    <span class="input-group-btn">
                                                        <button type="button"
                                                            class="quantity-right-plus btn btn-success btn-number">
                                                            <span><i class="fas fa-plus"></i></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="item-total">
                                            Tsh {{ number_format($item['price'] * ($item['quantity'] ?? 1)) }}
                                        </td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-sm bg-danger-light remove-from-cart">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7 col-lg-8"></div>

                    <div class="col-md-5 col-lg-4">

                        <!-- Booking Summary -->
                        <div class="card booking-card">
                            <div class="card-header">
                                <h4 class="card-title">Cart Total</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('pharmacy.checkout') }}" method="POST">
                                    @csrf
                                <div class="booking-summary">
                                    <div class="booking-item-wrap">
                                        <ul class="booking-date d-block pb-0">
                                            <li>Subtotal <span id="subtotal">Tsh {{ number_format($total) }}</span></li>
                                            <li>Shipping <span>Tsh 5000.00</span></li>
                                        </ul>
                                        <ul class="booking-fee pt-4">
                                            <li>Tax <span>Tsh 0.00</span></li>
                                        </ul>
                                        <div class="booking-total">
                                            <ul class="booking-total-list">
                                                <li>
                                                    <span>Total</span>
                                                    <span class="total-cost" id="grand-total">
                                                        Tsh {{ number_format($total + 5000) }}
                                                    </span>
                                                </li>
                                                <li>
                                                    <div class="clinic-booking pt-4">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('pharmacy.checkout', ['total' =>$total , 'cart' =>$cart ])}}" type="submit">Proceed to checkout</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <!-- /Booking Summary -->
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <h4>Your cart is empty.</h4>
                    <a href="{{ route('pharmacy.product') }}" class="btn btn-primary mt-3">Continue Shopping</a>
                </div>
                @endif

            </div>
        </div>
        <!-- /Page Content -->

        <!-- Footer Section -->
        @include('layouts.footer')
        <!-- /Footer Section -->

    </div>
    <!-- /Main Wrapper -->


    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap Core JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- Fancybox JS -->
    <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        $(document).ready(function () {

            // Remove from cart
            $('.remove-from-cart').click(function () {
                const row = $(this).closest('tr');
                const id = row.data('id');

                $.ajax({
                    url: "{{ route('cart.remove') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function (response) {
                        row.remove();
                        $('#cart-count').text(response.count);
                        $('#subtotal').text('Tsh ' + response.total.toLocaleString());
                        $('#grand-total').text('Tsh ' + (response.total + 25).toLocaleString());
                        if (response.count === 0) {
                            location.reload();
                        }
                    }
                });
            });

            // Quantity increment/decrement
            $('.quantity-right-plus').click(function () {
                let input = $(this).closest('.input-group1').find('.quantity-input');
                input.val(parseInt(input.val()) + 1).trigger('change');
            });

            $('.quantity-left-minus').click(function () {
                let input = $(this).closest('.input-group1').find('.quantity-input');
                if (parseInt(input.val()) > 1) {
                    input.val(parseInt(input.val()) - 1).trigger('change');
                }
            });

            // Update quantity in session
            $('.quantity-input').change(function () {
                const row = $(this).closest('tr');
                const id = row.data('id');
                const quantity = $(this).val();

                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        quantity: quantity
                    },
                    success: function (response) {
                        row.find('.item-total').text('Tsh ' + response.itemTotal.toLocaleString());
                        $('#subtotal').text('Tsh ' + response.total.toLocaleString());
                        $('#grand-total').text('Tsh ' + (response.total + 5000).toLocaleString());
                    }
                });
            });
        });
    </script>

</body>

</html>
