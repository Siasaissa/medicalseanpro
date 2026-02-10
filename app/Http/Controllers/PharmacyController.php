<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;

class PharmacyController extends Controller
{
    public function pharmacy(){
         $products = Product::all();

        return view('pharmacy.product',compact('products'));
    }
    public function product(){
         $products = Product::all();

        return view('admin.pharmacy',compact('products'));
    }

    public function view(){

            $cart = session()->get('cart', []);
            $total = collect($cart)->sum('price');
        return view('pharmacy.cart', compact('cart','total'));
    }

    public function add(Request $request)
{
    $cart = session()->get('cart', []);

    $product = $request->product;
    $cart[$product['id']] = $product;

    session()->put('cart', $cart);

    $total = collect($cart)->sum('price');
    return response()->json(['count' => count($cart), 'total' => $total]);
}

public function remove(Request $request)
{
    $cart = session()->get('cart', []);
    unset($cart[$request->id]);
    session()->put('cart', $cart);
    $total = collect($cart)->sum(fn($item) => $item['price'] * ($item['quantity'] ?? 1));
    return response()->json(['count' => count($cart), 'total' => $total]);
}

public function update(Request $request)
{
    $cart = session()->get('cart', []);
    if (isset($cart[$request->id])) {
        $cart[$request->id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);
    }
    $itemTotal = $cart[$request->id]['price'] * $cart[$request->id]['quantity'];
    $total = collect($cart)->sum(fn($item) => $item['price'] * ($item['quantity'] ?? 1));
    return response()->json(['itemTotal' => $itemTotal, 'total' => $total]);
}

    public function AddProduct(){
        return view('admin.addproduct');
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'brand_name' => 'required|string|max:255',
            'category' => 'required|string',
            'Price' => 'required|numeric',
            'quantity' => 'required|integer',
            'discount' => 'nullable|numeric',
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

    public function checkout(Request $request){
    $cart = session('cart', []);
    $total = collect($cart)->sum(fn($item) => $item['price'] * ($item['quantity'] ?? 1));
           
        return view('pharmacy.checkout', compact('total', 'cart'));
    }

public function payment(Request $request)
{
    $validated = $request->validate([
        'items' => 'required|array',
        'total' => 'required|numeric',
        'shipping' => 'nullable|string',
        'payment_method' => 'required|string|in:halopesa,tigopesa',
        'halopesa_phone' => 'nullable|numeric',
        'tigopesa_phone' => 'nullable|numeric',
    ]);

    $method = $validated['payment_method'];
    $phone = $method === 'halopesa'
        ? $validated['halopesa_phone']
        : $validated['tigopesa_phone'];

    $order = \App\Models\Order::create([
        'user_id' => auth()->id(),
        'items' => $validated['items'],
        'total' => $validated['total'],
        'shipping_address' => $validated['shipping'] ?? null,
        'payment_method' => $method,
        'phone' => $phone,
        'status' => 'pending',
    ]);

    // Here, integrate with ClickPesa or mobile money API later

    return view('pharmacy.successfully', [
        'order' => $order,
        'method' => ucfirst($method),
        'phone' => $phone,
    ]);
}

}