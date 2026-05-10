<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }
        $orders = $query->latest()->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
        $categories = Category::where('is_active', true)->get();
        return view('admin.orders.create', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:100',
            'customer_phone' => 'nullable|string|max:20',
            'payment_method' => 'required|in:Virtual Akun,Cash,E-Wallet,Qris',
            'products'       => 'required|array|min:1',
            'products.*.id'  => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $subtotal = 0;
                $itemsData = [];

                foreach ($request->products as $item) {
                    $product = Product::findOrFail($item['id']);
                    
                    if ($product->stock < $item['qty']) {
                        throw new \Exception("Stok {$product->name} tidak mencukupi.");
                    }

                    $itemSubtotal = $product->price * $item['qty'];
                    $subtotal += $itemSubtotal;

                    $itemsData[] = [
                        'product_id'   => $product->id,
                        'product_name' => $product->name,
                        'price'        => $product->price,
                        'quantity'     => $item['qty'],
                        'subtotal'     => $itemSubtotal,
                    ];
                }

                $order = Order::create([
                    'user_id'          => Auth::id(),
                    'order_number'     => 'TBN-' . strtoupper(Str::random(8)),
                    'customer_name'    => $request->customer_name,
                    'customer_phone'   => $request->customer_phone ?? '-',
                    'customer_address' => 'Ambil di Toko (Walk-in)',
                    'payment_method'   => $request->payment_method,
                    'subtotal'         => $subtotal,
                    'total'            => $subtotal,
                    'status'           => 'delivered', // Walk-in usually delivered immediately
                    'payment_status'   => 'paid',      // Walk-in usually paid immediately
                ]);

                foreach ($itemsData as $item) {
                    $item['order_id'] = $order->id;
                    OrderItem::create($item);
                    Product::find($item['product_id'])->decrement('stock', $item['quantity']);
                }

                return redirect()->route('admin.orders.show', $order)->with('success', 'Pesanan berhasil dibuat.');
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function scan()
    {
        return view('admin.orders.scan');
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status'         => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:unpaid,paid',
        ]);
        $order->update($request->only('status', 'payment_status'));
        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
