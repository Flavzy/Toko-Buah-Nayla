@extends('layouts.admin')

@section('header_title', 'Pesanan')

@section('content')
<div class="card">
    <div class="flex justify-between items-center mb-6">
        <h2 class="display-md" style="font-size: 20px;">Daftar Pesanan</h2>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 14px;">+ Buat Pesanan Toko</a>
    </div>

    <!-- Filter & Search -->
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-4 mb-6">
        <select name="status" class="form-input" style="width: 200px;">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Diterima</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor pesanan..." class="form-input" style="flex: 1;">
        <button type="submit" class="btn btn-secondary" style="border-radius: 8px; padding: 0 24px;">Cari</button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.orders.index') }}" class="btn btn-utility" style="background: var(--canvas-parchment); color: var(--ink) !important; padding: 12px;">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Waktu</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td style="font-weight: 600;">{{ $order->order_number }}</td>
                        <td class="caption text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>
                            <span style="color: {{ $order->payment_status == 'paid' ? '#10b981' : '#f59e0b' }}; font-weight: 600; font-size: 12px;">
                                {{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum Bayar' }}
                            </span>
                        </td>
                        <td>
                            <span style="background: {{ $order->status_color }}20; color: {{ $order->status_color }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-utility" style="background: var(--canvas-parchment); color: var(--ink) !important;"><i class="fa-solid fa-eye"></i> Detail</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
