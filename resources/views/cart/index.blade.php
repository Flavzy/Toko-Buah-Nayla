@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="tile-light" style="min-height: 80vh; padding: 64px 24px;">
    <div class="container" style="max-width: 980px;">
        <h1 class="display-lg mb-8 text-center">Keranjang Belanja Anda.</h1>

        @if(count($cart) > 0)
            <div class="flex-col gap-6 mb-8">
                @foreach($cart as $id => $item)
                    <div style="display: flex; align-items: center; padding-bottom: 32px; border-bottom: 1px solid var(--hairline);">
                        <!-- Image -->
                        <div style="width: 120px; height: 120px; background: #f5f5f7; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 32px;">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" style="max-width: 100%; max-height: 100%; border-radius: 8px;">
                            @else
                                <i class="fa-solid fa-apple-whole" style="font-size: 40px; color: #d2d2d7;"></i>
                            @endif
                        </div>

                        <!-- Details -->
                        <div style="flex: 1;">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="display-md" style="font-size: 24px;">{{ $item['name'] }}</h3>
                                <p class="body-strong">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                            </div>

                            <div class="flex items-center gap-6 mt-4">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label for="qty_{{ $id }}" class="caption text-muted">Kuantitas</label>
                                    <input type="number" id="qty_{{ $id }}" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99" style="width: 60px; padding: 4px; border: 1px solid var(--hairline); border-radius: 4px; text-align: center;" onchange="this.form.submit()">
                                </form>

                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: transparent; border: none; color: var(--primary); cursor: pointer; font-size: 14px;">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div style="max-width: 480px; margin-left: auto;">
                <div class="flex justify-between items-center mb-4 pb-4" style="border-bottom: 1px solid var(--hairline);">
                    <span class="body-strong">Subtotal</span>
                    <span class="body-strong">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center mb-6">
                    <span class="display-md" style="font-size: 28px;">Total</span>
                    <span class="display-md" style="font-size: 28px;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <div class="flex-col gap-4">
                    <a href="{{ route('orders.checkout') }}" class="btn btn-primary w-full text-center" style="padding: 16px; font-size: 18px;">Checkout</a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn w-full" style="padding: 12px; background: transparent; color: var(--ink-muted-48);">Kosongkan Keranjang</button>
                    </form>
                </div>
            </div>
        @else
            <div class="text-center" style="padding: 64px 0;">
                <p class="lead text-muted mb-6">Keranjang Anda kosong.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 12px 24px;">Lanjut Berbelanja</a>
            </div>
        @endif
    </div>
</div>
@endsection
