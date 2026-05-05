@extends('layouts.admin')

@section('header_title', 'Tambah Produk')

@section('content')
<div class="card" style="max-width: 800px;">
    <div class="flex justify-between items-center mb-6">
        <h2 class="display-md" style="font-size: 20px;">Form Produk</h2>
        <a href="{{ route('admin.products.index') }}" class="caption text-muted"><i class="fa-solid fa-chevron-left"></i> Kembali</a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="flex-col gap-4">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                @error('name') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="category_id" class="form-label">Kategori</label>
                <select id="category_id" name="category_id" class="form-input" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="description" class="form-label">Deskripsi Produk</label>
            <textarea id="description" name="description" class="form-input" rows="4">{{ old('description') }}</textarea>
            @error('description') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label for="price" class="form-label">Harga (Rp)</label>
                <input type="number" id="price" name="price" class="form-input" value="{{ old('price') }}" min="0" required>
                @error('price') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="unit" class="form-label">Satuan (kg, pack, dll)</label>
                <input type="text" id="unit" name="unit" class="form-input" value="{{ old('unit', 'kg') }}" required>
                @error('unit') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="stock" class="form-label">Stok</label>
                <input type="number" id="stock" name="stock" class="form-input" value="{{ old('stock', 0) }}" min="0" required>
                @error('stock') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="image" class="form-label">Gambar Produk (Opsional)</label>
            <input type="file" id="image" name="image" class="form-input" accept="image/*" style="padding: 9px 16px;">
            @error('image') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-6 mt-2">
            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="accent-color: var(--primary);">
                <label for="is_active" class="form-label" style="margin: 0;">Status Aktif</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="accent-color: var(--primary);">
                <label for="is_featured" class="form-label" style="margin: 0;">Produk Unggulan (Tampil di Beranda)</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4" style="padding: 12px;">Simpan Produk</button>
    </form>
</div>
@endsection
