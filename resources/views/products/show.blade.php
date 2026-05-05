@extends('layouts.app')

@section('title', $product->name)

@section('content')
<!-- Sub Nav Frosted -->
<div class="sub-nav">
    <div class="container flex justify-between items-center w-full">
        <h2 class="tagline">{{ $product->name }}</h2>
        <div class="flex items-center gap-4">
            <span style="font-size: 14px;">{{ $product->formatted_price }}</span>
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary" style="padding: 6px 16px; font-size: 14px;">Beli</button>
            </form>
        </div>
    </div>
</div>

<div class="tile-light pt-8 pb-8">
    <div class="container">
        <a href="{{ route('products.index') }}" class="caption text-muted mb-8" style="display:inline-block;"><i class="fa-solid fa-chevron-left"></i> Kembali ke Store</a>

        <div class="grid grid-cols-2 gap-8 items-center">
            <!-- Product Image -->
            <div class="text-center" style="background-color: #f5f5f7; border-radius: 24px; padding: 48px;">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image-shadow" style="max-width: 100%; height: auto; border-radius: 12px;">
                @else
                    <i class="fa-solid fa-apple-whole" style="font-size: 120px; color: #d2d2d7;"></i>
                @endif
            </div>

            <!-- Product Details -->
            <div>
                <span class="caption text-muted mb-2" style="display:block;">{{ $product->category->name }}</span>
                <h1 class="display-lg mb-4">{{ $product->name }}.</h1>
                <p class="lead text-muted mb-6">{{ $product->description }}</p>

                <div style="border-top: 1px solid var(--hairline); padding-top: 24px; margin-bottom: 24px;">
                    <p class="display-md">{{ $product->formatted_price }} <span class="body-strong" style="color:var(--ink-muted-80);">/ {{ $product->unit }}</span></p>
                    <p class="caption mt-2 {{ $product->stock > 0 ? 'text-muted' : 'text-danger' }}">
                        {{ $product->stock > 0 ? 'Stok tersedia: ' . $product->stock : 'Stok Habis' }}
                    </p>
                </div>

                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center gap-4">
                        @csrf
                        <div style="background: var(--canvas-parchment); border-radius: 9999px; padding: 4px 16px; display: flex; align-items: center; gap: 16px;">
                            <label for="quantity" class="caption" style="font-weight:600;">Jumlah</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 50px; background: transparent; border: none; text-align: center; font-size: 17px; outline: none;">
                        </div>
                        <button type="submit" class="btn btn-primary" style="padding: 14px 32px; font-size: 17px;">Tambahkan ke Keranjang</button>
                    </form>
                @else
                    <button class="btn btn-utility w-full" disabled style="opacity: 0.5; padding: 14px;">Stok Habis</button>
                @endif
            </div>
        </div>
    </div>
</div>

@if($related->count() > 0)
<section class="section tile-parchment">
    <div class="container">
        <h2 class="display-md text-center mb-8">Anda mungkin juga suka.</h2>
        <div class="grid grid-cols-4 gap-6">
            @foreach($related as $rel)
                <a href="{{ route('products.show', $rel->slug) }}" class="product-card text-center" style="display:block;">
                    @if($rel->image)
                        <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}" class="product-image">
                    @else
                        <div class="product-image flex items-center justify-center">
                            <i class="fa-solid fa-apple-whole" style="font-size:32px; color:#d2d2d7;"></i>
                        </div>
                    @endif
                    <h3 class="body-strong" style="color:var(--ink);">{{ $rel->name }}</h3>
                    <p class="caption mt-2 text-muted">{{ $rel->formatted_price }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
