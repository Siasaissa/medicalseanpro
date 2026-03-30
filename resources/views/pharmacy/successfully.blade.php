@include('layouts.head')
<body>
    <div class="main-wrapper">
        @include('layouts.header')

        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('pharmacy.product') }}"><i class="isax isax-home-15"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Pharmacy</li>
                                <li class="breadcrumb-item active">Order Payment</li>
                            </ol>
                            <h2 class="breadcrumb-title">Order Payment</h2>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="content success-page-cont">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card success-card">
                            <div class="card-body">
                                @php
                                    $status = strtolower((string) ($order->status ?? 'processing'));
                                    $isPaid = $status === 'paid';
                                    $isFailed = $status === 'failed';
                                @endphp

                                <div class="success-cont text-center">
                                    <i class="fas {{ $isPaid ? 'fa-check text-success' : ($isFailed ? 'fa-times text-danger' : 'fa-clock text-warning') }}"></i>
                                    <h3>
                                        @if($isPaid)
                                            Payment Completed
                                        @elseif($isFailed)
                                            Payment Failed
                                        @else
                                            Payment Processing
                                        @endif
                                    </h3>
                                    <p class="mb-1">Order ID: <strong>#ORD{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></p>
                                    <p class="mb-3">Reference: <strong>{{ $order->payment_reference ?? '-' }}</strong></p>
                                    <p class="mb-0">Total: <strong>Tsh {{ number_format((float) $order->total, 2) }}</strong></p>
                                </div>

                                @if(session('success'))
                                    <div class="alert alert-success mt-4">{{ session('success') }}</div>
                                @endif
                                @if(session('warning'))
                                    <div class="alert alert-warning mt-4">{{ session('warning') }}</div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger mt-4">{{ session('error') }}</div>
                                @endif

                                <div class="d-flex gap-2 flex-wrap mt-4 justify-content-center">
                                    @if(!$isPaid && !empty($order->payment_reference))
                                        <a href="{{ route('pharmacy.verify', $order->payment_reference) }}" class="btn btn-primary">
                                            Verify Payment Status
                                        </a>
                                    @endif
                                    <a href="{{ route('pharmacy.product') }}" class="btn btn-outline-primary">Continue Shopping</a>
                                    <a href="{{ route('pharmacy.cart') }}" class="btn btn-outline-secondary">Go To Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
