@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="tile-parchment" style="min-height: 80vh; padding: 64px 24px;">
    <div class="container" style="max-width: 980px;">
        <div class="flex justify-between items-center mb-8">
            <h1 class="display-lg">Pesanan {{ $order->order_number }}.</h1>
            <a href="{{ route('orders.index') }}" class="caption text-muted"><i class="fa-solid fa-chevron-left"></i> Kembali</a>
        </div>

        <div class="grid" style="grid-template-columns: 2fr 1fr; gap: 48px;">
            <!-- Rincian Item -->
            <div>
                <h2 class="display-md mb-6" style="font-size: 24px;">Item Pesanan</h2>
                <div class="flex-col gap-4 mb-8">
                    @foreach($order->items as $item)
                        <div class="product-card flex items-center gap-6" style="padding: 16px 24px;">
                            <div style="width: 80px; height: 80px; background: #f5f5f7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" style="max-width: 100%; max-height: 100%; border-radius: 6px;">
                                @else
                                    <i class="fa-solid fa-apple-whole" style="font-size: 32px; color: #d2d2d7;"></i>
                                @endif
                            </div>
                            <div style="flex: 1;">
                                <h3 class="body-strong">{{ $item->product_name }}</h3>
                                <p class="caption text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="body-strong">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Ringkasan Info -->
            <div>
                <div class="product-card mb-6 text-center">
                    <h2 class="display-md mb-4" style="font-size: 20px;">Struk Digital & Kode QR</h2>
                    <p class="caption text-muted mb-4">Tunjukkan kode QR ini kepada admin toko untuk dipindai.</p>
                    <div style="background: white; padding: 16px; display: inline-block; border-radius: 12px; margin-bottom: 16px;">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate(route('admin.orders.show', $order)) !!}
                    </div>
                    <div>
                        <a href="{{ route('orders.print', $order) }}" target="_blank" class="btn btn-secondary w-full" style="padding: 12px;"><i class="fa-solid fa-print mr-2"></i> Cetak / Buka Struk</a>
                    </div>
                </div>

                <div class="product-card mb-6">
                    <h2 class="display-md mb-4" style="font-size: 20px;">Status</h2>
                    <div class="flex-col gap-2">
                        <div class="flex justify-between">
                            <span class="caption text-muted">Pesanan</span>
                            <span style="color: {{ $order->status_color }}; font-weight: 600; font-size: 14px;">{{ $order->status_label }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="caption text-muted">Pembayaran</span>
                            <span style="color: {{ $order->payment_status == 'paid' ? '#10b981' : '#f59e0b' }}; font-weight: 600; font-size: 14px;">
                                {{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum Dibayar' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="caption text-muted">Metode</span>
                            <span class="body-strong" style="font-size: 14px;">{{ $order->payment_method ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="product-card mb-6">
                    <h2 class="display-md mb-4" style="font-size: 20px;">Informasi Pengambilan</h2>
                    <p class="body-strong">{{ $order->customer_name }}</p>
                    <p class="caption text-muted mb-2">{{ $order->customer_phone }}</p>
                    <p class="caption text-muted mb-2">Ambil di Toko Buah Nayla</p>
                    @if($order->notes)
                        <div class="mt-4 pt-4" style="border-top: 1px solid var(--hairline);">
                            <span class="caption text-muted block mb-1">Catatan:</span>
                            <p class="caption">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>

                <div class="product-card">
                    <h2 class="display-md mb-4" style="font-size: 20px;">Ringkasan Biaya</h2>
                    <div class="flex justify-between items-center pb-4 mb-4" style="border-bottom: 1px solid var(--hairline);">
                        <span class="body-strong">Subtotal</span>
                        <span class="body-strong">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="display-md" style="font-size: 24px;">Total</span>
                        <span class="display-md" style="font-size: 24px;">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
