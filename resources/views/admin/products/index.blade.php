@extends('layouts.admin')

@section('header_title', 'Produk')

@section('content')
<div class="card">
    <div class="flex justify-between items-center mb-6">
        <h2 class="display-md" style="font-size: 20px;">Daftar Produk</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 14px;"><i class="fa-solid fa-plus mr-2"></i> Tambah Produk</a>
    </div>

    <!-- Filter & Search -->
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-4 mb-6">
        <select name="category" class="form-input" style="width: 200px;">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="form-input" style="flex: 1;">
        <button type="submit" class="btn btn-secondary" style="border-radius: 8px; padding: 0 24px;">Cari</button>
        @if(request('search') || request('category'))
            <a href="{{ route('admin.products.index') }}" class="btn btn-utility" style="background: var(--canvas-parchment); color: var(--ink) !important; padding: 12px;">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama & Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td style="width: 80px;">
                            <div style="width: 48px; height: 48px; background: var(--canvas-parchment); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="" style="max-width: 100%; max-height: 100%; border-radius: 6px;">
                                @else
                                    <i class="fa-solid fa-image" style="color: var(--hairline);"></i>
                                @endif
                            </div>
                        </td>
                        <td>
                            <p class="body-strong">{{ $product->name }}</p>
                            <p class="caption text-muted">{{ $product->category->name }}</p>
                        </td>
                        <td>
                            <p class="body-strong">{{ $product->formatted_price }}</p>
                            <p class="caption text-muted">per {{ $product->unit }}</p>
                        </td>
                        <td>
                            <span class="{{ $product->stock > 10 ? 'text-muted' : 'text-danger' }}" style="font-weight: 600;">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            @if($product->is_active)
                                <span style="background: rgba(16,185,129,0.1); color: #10b981; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">Aktif</span>
                            @else
                                <span style="background: rgba(239,68,68,0.1); color: #ef4444; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">Nonaktif</span>
                            @endif
                            @if($product->is_featured)
                                <span style="background: rgba(245,158,11,0.1); color: #f59e0b; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; margin-left: 4px;">Unggulan</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-utility" style="background: var(--canvas-parchment); color: var(--ink) !important;"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-utility" style="background: rgba(239,68,68,0.1); color: #ef4444 !important;"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
