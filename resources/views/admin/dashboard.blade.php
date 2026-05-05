@extends('layouts.admin')

@section('header_title', 'Dashboard')

@section('content')
<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="card flex items-center gap-6">
        <div style="width: 64px; height: 64px; background: rgba(0,102,204,0.1); color: var(--primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
        <div>
            <p class="caption text-muted">Total Pesanan</p>
            <h3 class="display-md">{{ $stats['orders'] }}</h3>
        </div>
    </div>
    
    <div class="card flex items-center gap-6">
        <div style="width: 64px; height: 64px; background: rgba(16,185,129,0.1); color: #10b981; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
        <div>
            <p class="caption text-muted">Pendapatan (Selesai)</p>
            <h3 class="display-md" style="font-size: 24px;">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</h3>
        </div>
    </div>
    
    <div class="card flex items-center gap-6">
        <div style="width: 64px; height: 64px; background: rgba(245,158,11,0.1); color: #f59e0b; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>
        <div>
            <p class="caption text-muted">Pesanan Pending</p>
            <h3 class="display-md">{{ $stats['pending'] }}</h3>
        </div>
    </div>

    <div class="card flex items-center gap-6">
        <div style="width: 64px; height: 64px; background: rgba(139,92,246,0.1); color: #8b5cf6; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="fa-solid fa-box"></i>
        </div>
        <div>
            <p class="caption text-muted">Total Produk</p>
            <h3 class="display-md">{{ $stats['products'] }}</h3>
        </div>
    </div>
    
    <div class="card flex items-center gap-6">
        <div style="width: 64px; height: 64px; background: rgba(236,72,153,0.1); color: #ec4899; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="fa-solid fa-tags"></i>
        </div>
        <div>
            <p class="caption text-muted">Kategori</p>
            <h3 class="display-md">{{ $stats['categories'] }}</h3>
        </div>
    </div>

    <div class="card flex items-center gap-6">
        <div style="width: 64px; height: 64px; background: rgba(99,102,241,0.1); color: #6366f1; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <p class="caption text-muted">Pelanggan</p>
            <h3 class="display-md">{{ $stats['users'] }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="display-md" style="font-size: 20px;">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" class="caption" style="color: var(--primary);">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}" style="color:var(--primary); font-weight:600;">{{ $order->order_number }}</a></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>
                                <span style="background: {{ $order->status_color }}20; color: {{ $order->status_color }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td style="font-weight: 600;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="card">
        <h2 class="display-md mb-6" style="font-size: 20px;">Produk Terlaris</h2>
        <div class="flex-col gap-4">
            @forelse($topProducts as $product)
                <div class="flex items-center gap-4 pb-4" style="border-bottom: 1px solid var(--hairline);">
                    <div style="width: 48px; height: 48px; background: var(--canvas-parchment); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" style="max-width: 100%; max-height: 100%; border-radius: 6px;">
                        @else
                            <i class="fa-solid fa-apple-whole" style="color: var(--hairline);"></i>
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <p class="body-strong">{{ $product->name }}</p>
                        <p class="caption text-muted">{{ $product->formatted_price }}</p>
                    </div>
                    <div>
                        <span style="background: var(--surface-tile-1); color: var(--body-on-dark); padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600;">
                            {{ $product->order_items_count }} Terjual
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada data penjualan</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
