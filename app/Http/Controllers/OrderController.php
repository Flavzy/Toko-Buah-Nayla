<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function print(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) abort(403);
        $order->load('items.product', 'user');
        return view('orders.print', compact('order'));
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $user  = Auth::user();
        return view('orders.checkout', compact('cart', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:100',
            'customer_phone'   => 'required|string|max:20',
            'payment_method'   => 'required|string',
            'notes'            => 'nullable|string|max:500',
        ], [
            'customer_name.required'    => 'Nama penerima wajib diisi.',
            'customer_phone.required'   => 'Nomor telepon wajib diisi.',
            'payment_method.required'   => 'Metode pembayaran wajib dipilih.',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');

        // Validate stock
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product || $product->stock < $item['quantity']) {
                return back()->with('error', "Stok {$item['name']} tidak mencukupi.");
            }
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id'          => Auth::id(),
            'order_number'     => 'TBN-' . strtoupper(Str::random(8)),
            'customer_name'    => $request->customer_name,
            'customer_phone'   => $request->customer_phone,
            'customer_address' => 'Ambil di Toko',
            'payment_method'   => $request->payment_method,
            'notes'            => $request->notes,
            'subtotal'         => $subtotal,
            'total'            => $subtotal,
            'status'           => 'pending',
            'payment_status'   => 'unpaid',
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $id,
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'quantity'     => $item['quantity'],
                'subtotal'     => $item['price'] * $item['quantity'],
            ]);

            // Decrease stock
            Product::find($id)?->decrement('stock', $item['quantity']);
        }

        session()->forget('cart');
        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);
    }
}
