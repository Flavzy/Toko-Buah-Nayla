@extends('layouts.admin')

@section('header_title', 'Kategori')

@section('content')
<div class="card">
    <div class="flex justify-between items-center mb-6">
        <h2 class="display-md" style="font-size: 20px;">Daftar Kategori</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 14px;"><i class="fa-solid fa-plus mr-2"></i> Tambah Kategori</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Jml Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td style="width: 80px;">
                            <div style="width: 48px; height: 48px; background: var(--canvas-parchment); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="" style="max-width: 100%; max-height: 100%; border-radius: 6px;">
                                @else
                                    <i class="fa-solid fa-image" style="color: var(--hairline);"></i>
                                @endif
                            </div>
                        </td>
                        <td>
                            <p class="body-strong">{{ $category->name }}</p>
                            <p class="caption text-muted">{{ $category->slug }}</p>
                        </td>
                        <td>
                            @if($category->is_active)
                                <span style="background: rgba(16,185,129,0.1); color: #10b981; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">Aktif</span>
                            @else
                                <span style="background: rgba(239,68,68,0.1); color: #ef4444; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">Nonaktif</span>
                            @endif
                        </td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-utility" style="background: var(--canvas-parchment); color: var(--ink) !important;"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-utility" style="background: rgba(239,68,68,0.1); color: #ef4444 !important;"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
