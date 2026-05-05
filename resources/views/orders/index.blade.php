@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="tile-parchment" style="min-height: 80vh; padding: 64px 24px;">
    <div class="container" style="max-width: 980px;">
        <h1 class="display-lg mb-8">Pesanan Saya.</h1>

        @if($orders->count() > 0)
            <div class="flex-col gap-6">
                @foreach($orders as $order)
                    <div class="product-card flex justify-between items-center" style="padding: 24px 32px;">
                        <div>
                            <p class="caption text-muted mb-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            <h3 class="display-md mb-2" style="font-size: 20px;">{{ $order->order_number }}</h3>
                            <div class="flex gap-4">
                                <p class="body-strong">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                <span style="color: {{ $order->status_color }}; font-weight: 600; font-size: 14px;">{{ $order->status_label }}</span>
                                <span style="color: {{ $order->payment_status == 'paid' ? '#10b981' : '#f59e0b' }}; font-weight: 600; font-size: 14px;">
                                    {{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum Dibayar' }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary" style="padding: 8px 16px;">Detail</a>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center" style="padding: 64px 0;">
                <p class="lead text-muted mb-6">Belum ada pesanan.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 12px 24px;">Belanja Sekarang</a>
            </div>
        @endif
    </div>
</div>
@endsection
