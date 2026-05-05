<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session()->get('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    public function index()
    {
        $cart  = $this->getCart();
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        if (!$product->is_active || $product->stock < 1) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $qty  = (int) $request->quantity;
        $cart = $this->getCart();
        $id   = (string) $product->id;

        if (isset($cart[$id])) {
            $newQty = $cart[$id]['quantity'] + $qty;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $cart[$id]['quantity'] = $newQty;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => (float) $product->price,
                'unit'     => $product->unit,
                'quantity' => $qty,
                'image'    => $product->image,
            ];
        }

        $this->saveCart($cart);
        return back()->with('success', $product->name . ' ditambahkan ke keranjang.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $cart = $this->getCart();
        if (isset($cart[$id])) {
            $product = Product::find($id);
            if ($product && $request->quantity > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $cart[$id]['quantity'] = (int) $request->quantity;
            $this->saveCart($cart);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(string $id)
    {
        $cart = $this->getCart();
        unset($cart[$id]);
        $this->saveCart($cart);
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
