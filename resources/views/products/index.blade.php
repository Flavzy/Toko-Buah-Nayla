@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<!-- Sub Nav Frosted -->
<div class="sub-nav">
    <div class="container w-full">
        <div class="flex justify-between items-center w-full mb-2 sm:mb-0">
            <h2 class="tagline">Store</h2>
        </div>
        <div class="nav-scroll">
            @foreach($categories as $cat)
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" style="font-size: 14px; {{ request('category') == $cat->slug ? 'font-weight:600; color:var(--ink);' : 'color:var(--ink-muted-80);' }}">{{ $cat->name }}</a>
            @endforeach
            @if(request('category') || request('search'))
                <a href="{{ route('products.index') }}" style="font-size: 14px; color:var(--primary);">Semua</a>
            @endif
        </div>
    </div>
</div>

<div style="background-color: var(--canvas-parchment); min-height: 80vh; padding-bottom: 80px;">
    <div class="container pt-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
            <h1 class="display-lg">
                @if(request('category'))
                    Kategori: {{ $categories->where('slug', request('category'))->first()->name ?? 'Produk' }}
                @elseif(request('search'))
                    Pencarian: "{{ request('search') }}"
                @else
                    Semua Produk. <span style="color:var(--ink-muted-48); display: block; font-size: 0.6em; margin-top: 4px;">Segar untuk Anda.</span>
                @endif
            </h1>

            <!-- Search & Filter -->
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative w-full sm:w-[250px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buah..." class="form-input pill w-full">
                </div>
                <select name="sort" onchange="this.form.submit()" class="form-input pill w-full sm:w-auto" style="padding-right: 32px;">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                </select>
            </form>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="product-card flex-col">
                        <a href="{{ route('products.show', $product->slug) }}" class="flex-col" style="flex: 1;">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                            @else
                                <div class="product-image flex items-center justify-center">
                                    <i class="fa-solid fa-apple-whole" style="font-size:48px; color:#d2d2d7;"></i>
                                </div>
                            @endif
                            <h3 class="body-strong" style="color:var(--ink);">{{ $product->name }}</h3>
                            <p class="caption mt-2 text-muted" style="flex:1;">{{ Str::limit($product->description, 60) }}</p>
                            <p class="mt-4" style="color:var(--ink); font-weight:600;">{{ $product->formatted_price }} <span class="caption" style="font-weight:400;">/ {{ $product->unit }}</span></p>
                        </a>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-full" style="font-size: 14px; padding: 8px;">Tambah</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center" style="padding: 120px 0;">
                <i class="fa-solid fa-box-open" style="font-size: 48px; color: var(--hairline); margin-bottom: 24px;"></i>
                <h3 class="display-md text-muted">Produk tidak ditemukan.</h3>
                <p class="mt-4 text-muted">Silakan coba kata kunci lain atau bersihkan filter.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-6">Kembali ke Store</a>
            </div>
        @endif
    </div>
</div>
@endsection
