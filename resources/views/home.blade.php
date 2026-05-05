@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<!-- Hero Section -->
<section class="tile-dark" style="min-height: 80vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 120px 24px;">
    <div class="container">
        <h1 class="display-hero mb-4">Kesegaran Alam<br>di Tangan Anda.</h1>
        <p class="lead mb-8 text-muted" style="max-width: 600px; margin-left: auto; margin-right: auto;">
            Toko Buah Nayla menghadirkan buah-buahan premium segar dan es buah spesial langsung ke pintu rumah Anda.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 14px 28px;">Beli Sekarang</a>
            <a href="#kategori" class="btn btn-secondary" style="padding: 14px 28px; border-color: white; color: white;">Lihat Kategori</a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section tile-light">
    <div class="container">
        <div class="text-center mb-8">
            <h2 class="display-lg mb-2">Pilihan Terbaik Nayla.</h2>
            <p class="tagline text-muted">Buah pilihan dengan kualitas premium minggu ini.</p>
        </div>

        <div class="grid grid-cols-3 gap-6">
            @foreach($featuredProducts as $product)
                <div class="product-card text-center flex-col items-center">
                    <a href="{{ route('products.show', $product->slug) }}">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image product-image-shadow">
                        @else
                            <div class="product-image flex items-center justify-center" style="background:#f5f5f7;">
                                <i class="fa-solid fa-apple-whole" style="font-size:48px; color:#d2d2d7;"></i>
                            </div>
                        @endif
                        <h3 class="body-strong mt-4" style="color:var(--ink);">{{ $product->name }}</h3>
                        <p class="mt-2" style="color:var(--ink-muted-80);">{{ $product->formatted_price }} <span class="caption">/ {{ $product->unit }}</span></p>
                    </a>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-6 w-full">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-primary w-full" style="font-size: 14px; padding: 8px;">Tambah ke Keranjang</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Categories -->
<section id="kategori" class="section tile-parchment">
    <div class="container">
        <div class="text-center mb-8">
            <h2 class="display-lg mb-2">Jelajahi Kategori.</h2>
            <p class="tagline text-muted">Dari buah utuh hingga sajian segar.</p>
        </div>

        <div class="grid grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="product-card text-center" style="display:block;">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width:100%; height:150px; object-fit:cover; border-radius:8px; margin-bottom:16px;">
                    @else
                        <div style="width:100%; height:150px; background:var(--canvas-parchment); border-radius:8px; margin-bottom:16px; display:flex; align-items:center; justify-content:center;">
                            <i class="fa-solid fa-leaf" style="font-size:32px; color:var(--primary);"></i>
                        </div>
                    @endif
                    <h3 class="body-strong" style="color:var(--ink);">{{ $category->name }}</h3>
                    <p class="caption mt-2" style="color:var(--ink-muted-80);">{{ $category->products_count }} Produk</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Es Buah Promotion -->
<section class="section tile-dark text-center" style="padding: 120px 24px;">
    <div class="container">
        <h2 class="display-hero mb-4">Segar.<br>Manis. Sempurna.</h2>
        <p class="lead text-muted mb-8" style="max-width: 600px; margin: 0 auto;">
            Nikmati kesegaran es buah racikan khusus Nayla dengan sirup asli dan buah segar.
        </p>
        <a href="{{ route('products.index', ['category' => 'es-buah']) }}" class="btn btn-primary" style="padding: 14px 28px;">Pesan Es Buah</a>
    </div>
</section>

@endsection
