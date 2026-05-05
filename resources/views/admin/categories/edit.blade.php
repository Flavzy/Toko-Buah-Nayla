@extends('layouts.admin')

@section('header_title', 'Edit Kategori')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="flex justify-between items-center mb-6">
        <h2 class="display-md" style="font-size: 20px;">Form Edit Kategori</h2>
        <a href="{{ route('admin.categories.index') }}" class="caption text-muted"><i class="fa-solid fa-chevron-left"></i> Kembali</a>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="flex-col gap-4">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $category->name) }}" required>
            @error('name') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="form-label">Deskripsi</label>
            <textarea id="description" name="description" class="form-input" rows="4">{{ old('description', $category->description) }}</textarea>
            @error('description') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Gambar Saat Ini</label>
            <div class="mb-2">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="Current Image" style="max-width: 150px; border-radius: 8px;">
                @else
                    <p class="caption text-muted">Tidak ada gambar.</p>
                @endif
            </div>
            <label for="image" class="form-label mt-4">Ganti Gambar (Opsional)</label>
            <input type="file" id="image" name="image" class="form-input" accept="image/*" style="padding: 9px 16px;">
            @error('image') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-2 mt-2">
            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} style="accent-color: var(--primary);">
            <label for="is_active" class="form-label" style="margin: 0;">Status Aktif</label>
        </div>

        <button type="submit" class="btn btn-primary mt-4" style="padding: 12px;">Perbarui Kategori</button>
    </form>
</div>
@endsection
