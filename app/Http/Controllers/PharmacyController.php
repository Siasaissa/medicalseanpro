<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Support\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PharmacyController extends Controller
{
    private const SHIPPING_FEE = 5000;

    public function pharmacy()
    {
        $products = Product::latest()->get();
        $cart = session()->get('cart', []);
        $cartTotal = collect($cart)->sum(fn ($item) => ((float) $item['price']) * ((int) ($item['quantity'] ?? 1)));

        return view('pharmacy.product', [
            'products' => $products,
            'cartCount' => count($cart),
            'cartTotal' => $cartTotal,
        ]);
    }

    public function product()
    {
        $products = Product::latest()->get();
        $orders = Order::with('user')->latest()->limit(30)->get();
        $orderStatusOptions = ['pending', 'processing', 'paid', 'failed', 'cancelled', 'refunded'];

        return view('admin.pharmacy', compact('products', 'orders', 'orderStatusOptions'));
    }

    public function view()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn ($item) => ((float) $item['price']) * ((int) ($item['quantity'] ?? 1)));

        return view('pharmacy.cart', [
            'cart' => $cart,
            'total' => $total,
            'shippingFee' => self::SHIPPING_FEE,
            'grandTotal' => $total + self::SHIPPING_FEE,
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $nextQty = ((int) ($cart[$product->id]['quantity'] ?? 1)) + 1;
            if ($nextQty > (int) $product->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock for this product.',
                ], 422);
            }
            $cart[$product->id]['quantity'] = $nextQty;
        } else {
            if ((int) $product->quantity < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is out of stock.',
                ], 422);
            }

            $cart[$product->id] = [
                'id' => $product->id,
                'product_id' => $product->id,
                'name' => $product->brand_name,
                'price' => (float) $product->price,
                'quantity' => 1,
                'image' => $product->images[0] ?? null,
            ];
        }

        session()->put('cart', $cart);

        $total = collect($cart)->sum(fn ($item) => ((float) $item['price']) * ((int) ($item['quantity'] ?? 1)));

        return response()->json([
            'success' => true,
            'count' => count($cart),
            'total' => $total,
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $cart = session()->get('cart', []);
        unset($cart[$request->id]);
        session()->put('cart', $cart);

        $total = collect($cart)->sum(fn ($item) => ((float) $item['price']) * ((int) ($item['quantity'] ?? 1)));

        return response()->json([
            'success' => true,
            'count' => count($cart),
            'total' => $total,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        if (!isset($cart[$validated['id']])) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart.',
            ], 404);
        }

        $product = Product::findOrFail($validated['id']);
        if ($validated['quantity'] > (int) $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Requested quantity exceeds available stock.',
            ], 422);
        }

        $cart[$validated['id']]['quantity'] = $validated['quantity'];
        session()->put('cart', $cart);

        $itemTotal = ((float) $cart[$validated['id']]['price']) * ((int) $cart[$validated['id']]['quantity']);
        $total = collect($cart)->sum(fn ($item) => ((float) $item['price']) * ((int) ($item['quantity'] ?? 1)));

        return response()->json([
            'success' => true,
            'itemTotal' => $itemTotal,
            'total' => $total,
        ]);
    }

    public function AddProduct()
    {
        return view('admin.addproduct');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|string|max:255',
            'category' => 'required|string',
            'Price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
        }

        Product::create([
            'brand_name' => $validated['brand_name'],
            'category' => $validated['category'],
            'price' => $validated['Price'],
            'quantity' => $validated['quantity'],
            'discount' => $validated['discount'] ?? 0,
            'description' => $validated['description'] ?? '',
            'images' => $imagePaths,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('pharmacy.cart')->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(fn ($item) => ((float) $item['price']) * ((int) ($item['quantity'] ?? 1)));

        return view('pharmacy.checkout', [
            'total' => $total,
            'shippingFee' => self::SHIPPING_FEE,
            'grandTotal' => $total + self::SHIPPING_FEE,
            'cart' => $cart,
        ]);
    }

    public function payment(Request $request)
    {
        $validated = $request->validate([
            'shipping' => 'nullable|string|max:500',
            'payment_method' => 'required|string|in:halopesa,tigopesa',
            'halopesa_phone' => 'nullable|string|max:20',
            'tigopesa_phone' => 'nullable|string|max:20',
        ]);

        $phone = $validated['payment_method'] === 'halopesa'
            ? ($validated['halopesa_phone'] ?? '')
            : ($validated['tigopesa_phone'] ?? '');

        if ($phone === '') {
            return back()->withInput()->with('error', 'Phone number is required for selected payment method.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('pharmacy.cart')->with('error', 'Your cart is empty.');
        }

        $preparedItems = [];
        $subtotal = 0.0;

        foreach ($cart as $cartItem) {
            $product = Product::find($cartItem['id'] ?? null);
            if (!$product) {
                return redirect()->route('pharmacy.cart')->with('error', 'One of the products is no longer available.');
            }

            $qty = (int) ($cartItem['quantity'] ?? 1);
            if ($qty < 1 || $qty > (int) $product->quantity) {
                return redirect()->route('pharmacy.cart')->with('error', "Stock issue for {$product->brand_name}. Please review your cart.");
            }

            $price = (float) $product->price;
            $lineTotal = $price * $qty;

            $preparedItems[] = [
                'product_id' => $product->id,
                'name' => $product->brand_name,
                'price' => $price,
                'quantity' => $qty,
                'line_total' => $lineTotal,
            ];

            $subtotal += $lineTotal;
        }

        $grandTotal = $subtotal + self::SHIPPING_FEE;
        $orderReference = 'PHARM' . time() . (Auth::id() ?? '0');

        $order = Order::create([
            'user_id' => Auth::id(),
            'items' => $preparedItems,
            'total' => $grandTotal,
            'shipping_address' => $validated['shipping'] ?? null,
            'payment_method' => $validated['payment_method'],
            'payment_gateway' => $validated['payment_method'],
            'phone' => $phone,
            'status' => 'processing',
            'payment_reference' => $orderReference,
        ]);

        try {
            $paymentResponse = $this->initiateClickPesaPush($grandTotal, $phone, $orderReference);
            $normalized = $this->normalizePaymentStatus($paymentResponse['status'] ?? null);

            $order->update([
                'status' => strtolower($normalized === 'SUCCESS' ? 'paid' : ($normalized === 'FAILED' ? 'failed' : 'processing')),
                'transaction_id' => $paymentResponse['transactionId'] ?? ($paymentResponse['id'] ?? null),
                'payment_response' => json_encode($paymentResponse),
            ]);

            if ($normalized === 'SUCCESS') {
                $this->finalizeOrderStockAndCart($order);
                session(['last_pharmacy_order_id' => $order->id]);
                return redirect()->route('pharmacy.successfully', $order->id)
                    ->with('success', 'Payment completed and order confirmed.');
            }

            if ($normalized === 'FAILED') {
                session(['last_pharmacy_order_id' => $order->id]);
                return redirect()->route('pharmacy.successfully', $order->id)
                    ->with('error', $paymentResponse['message'] ?? 'Payment failed. Please top up and try again.');
            }

            session(['last_pharmacy_order_id' => $order->id]);
            return redirect()->route('pharmacy.successfully', $order->id)
                ->with('warning', 'Order created. Please complete payment on your phone, then verify status.');
        } catch (\Throwable $e) {
            Log::error('Pharmacy payment initiation failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            $order->update([
                'status' => 'failed',
                'payment_response' => json_encode(['error' => $e->getMessage()]),
            ]);

            session(['last_pharmacy_order_id' => $order->id]);
            return redirect()->route('pharmacy.successfully', $order->id)
                ->with('error', 'Payment initiation failed. Please try again.');
        }
    }

    public function success(Order $order)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role !== 'admin' && $order->user_id && (int) $order->user_id !== (int) $user->id) {
                abort(403, 'Unauthorized order access.');
            }
        } else {
            if ((int) session('last_pharmacy_order_id') !== (int) $order->id) {
                abort(403, 'Unauthorized order access.');
            }
        }

        return view('pharmacy.successfully', compact('order'));
    }

    public function verifyPayment(string $payment_reference)
    {
        $order = Order::where('payment_reference', $payment_reference)->firstOrFail();

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role !== 'admin' && $order->user_id && (int) $order->user_id !== (int) $user->id) {
                abort(403, 'Unauthorized order access.');
            }
        }

        try {
            $token = $this->getClickPesaToken();
            $response = Http::withToken($token)
                ->timeout(30)
                ->get("https://api.clickpesa.com/third-parties/payments/{$payment_reference}");

            $paymentData = [];
            $normalizedStatus = 'PROCESSING';

            if ($response->successful()) {
                $data = $response->json();
                $paymentData = is_array($data) && isset($data[0]) ? $data[0] : $data;
                $normalizedStatus = $this->normalizePaymentStatus($paymentData['status'] ?? null);

                $order->update([
                    'status' => strtolower($normalizedStatus === 'SUCCESS' ? 'paid' : ($normalizedStatus === 'FAILED' ? 'failed' : 'processing')),
                    'transaction_id' => $paymentData['id'] ?? $order->transaction_id,
                    'payment_gateway' => $paymentData['channel'] ?? $order->payment_gateway,
                    'payment_response' => json_encode($paymentData ?? []),
                ]);

                if ($normalizedStatus === 'SUCCESS') {
                    $this->finalizeOrderStockAndCart($order);
                    return redirect()->route('pharmacy.successfully', $order->id)
                        ->with('success', 'Payment verified successfully. Order confirmed.');
                }

                if ($normalizedStatus === 'FAILED') {
                    return redirect()->route('pharmacy.successfully', $order->id)
                        ->with('error', $paymentData['message'] ?? 'Payment failed.');
                }
            }

            return redirect()->route('pharmacy.successfully', $order->id)
                ->with('warning', 'Payment is still processing. Please check again shortly.');
        } catch (\Throwable $e) {
            Log::error('Pharmacy payment verification failed', [
                'payment_reference' => $payment_reference,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('pharmacy.successfully', $order->id)
                ->with('error', 'Unable to verify payment at the moment.');
        }
    }

    private function finalizeOrderStockAndCart(Order $order): void
    {
        if (strtolower((string) $order->status) !== 'paid') {
            return;
        }

        if (!is_null($order->fulfilled_at)) {
            session()->forget('cart');
            return;
        }

        DB::transaction(function () use ($order) {
            $items = is_array($order->items) ? $order->items : [];
            foreach ($items as $item) {
                $productId = (int) ($item['product_id'] ?? 0);
                $qty = (int) ($item['quantity'] ?? 0);
                if ($productId < 1 || $qty < 1) {
                    continue;
                }

                $product = Product::lockForUpdate()->find($productId);
                if (!$product) {
                    continue;
                }

                $newQty = max(0, (int) $product->quantity - $qty);
                $product->update(['quantity' => $newQty]);
            }

            $order->update(['fulfilled_at' => now()]);
        });

        session()->forget('cart');
    }

    private function normalizePaymentStatus(?string $status): string
    {
        return PaymentStatus::normalize($status);
    }

    private function getClickPesaToken(): string
    {
        $response = Http::withHeaders([
            'api-key' => config('services.clickpesa.api_key'),
            'client-id' => config('services.clickpesa.client_id'),
            'Accept' => 'application/json',
        ])->post('https://api.clickpesa.com/third-parties/generate-token');

        if (!$response->successful()) {
            throw new \RuntimeException('Failed to generate ClickPesa token: ' . $response->body());
        }

        return str_replace('Bearer ', '', (string) $response->json('token'));
    }

    private function initiateClickPesaPush(float $amount, string $phone, string $orderReference): array
    {
        $token = $this->getClickPesaToken();

        $payload = [
            'amount' => (string) round($amount, 2),
            'currency' => 'TZS',
            'orderReference' => $orderReference,
            'phoneNumber' => $phone,
            'checksum' => (string) round($amount, 2),
        ];

        $response = Http::withToken($token)
            ->timeout(30)
            ->post('https://api.clickpesa.com/third-parties/payments/initiate-ussd-push-request', $payload);

        $result = $response->json() ?? [];
        if (!$response->successful()) {
            $result['status'] = 'FAILED';
        }

        return $result;
    }
}
