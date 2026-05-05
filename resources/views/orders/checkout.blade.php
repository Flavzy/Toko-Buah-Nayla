@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="tile-parchment" style="min-height: 80vh; padding: 64px 24px;">
    <div class="container" style="max-width: 980px;">
        <h1 class="display-lg mb-8 text-center">Checkout.</h1>

        <div class="grid" style="grid-template-columns: 3fr 2fr; gap: 48px;">
            <!-- Form Pengiriman -->
            <div class="product-card">
                <h2 class="display-md mb-6" style="font-size: 24px;">Informasi Pengiriman</h2>
                <form action="{{ route('orders.store') }}" method="POST" id="checkoutForm" class="flex-col gap-4">
                    @csrf
                    <div>
                        <label for="customer_name" class="form-label">Nama Lengkap</label>
                        <input type="text" id="customer_name" name="customer_name" class="form-input" value="{{ old('customer_name', $user->name) }}" required>
                        @error('customer_name') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="customer_phone" class="form-label">Nomor Telepon</label>
                        <input type="text" id="customer_phone" name="customer_phone" class="form-input" value="{{ old('customer_phone', $user->phone) }}" required>
                        @error('customer_phone') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">Metode Pembayaran</label>
                        <div class="flex-col gap-2 mt-2">
                            <label class="flex items-center gap-2" style="padding: 12px; border: 1px solid var(--hairline); border-radius: 8px; cursor: pointer;">
                                <input type="radio" name="payment_method" value="Virtual Account" required style="accent-color: var(--primary);">
                                <span class="body-strong">Virtual Account (Transfer Bank)</span>
                            </label>
                            <label class="flex items-center gap-2" style="padding: 12px; border: 1px solid var(--hairline); border-radius: 8px; cursor: pointer;">
                                <input type="radio" name="payment_method" value="E-Wallet" required style="accent-color: var(--primary);">
                                <span class="body-strong">E-Wallet (OVO, GoPay, DANA)</span>
                            </label>
                            <label class="flex items-center gap-2" style="padding: 12px; border: 1px solid var(--hairline); border-radius: 8px; cursor: pointer;">
                                <input type="radio" name="payment_method" value="QRIS" required style="accent-color: var(--primary);">
                                <span class="body-strong">QRIS (Semua Pembayaran)</span>
                            </label>
                        </div>
                        @error('payment_method') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea id="notes" name="notes" class="form-input" rows="2" style="resize: vertical;">{{ old('notes') }}</textarea>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Pesanan -->
            <div>
                <h2 class="display-md mb-6" style="font-size: 24px;">Ringkasan Pesanan</h2>
                <div class="flex-col gap-4 mb-6">
                    @foreach($cart as $item)
                        <div class="flex justify-between items-start pb-4" style="border-bottom: 1px solid var(--hairline);">
                            <div>
                                <p class="body-strong">{{ $item['name'] }}</p>
                                <p class="caption text-muted">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <p class="body-strong">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center mb-6 pt-4" style="border-top: 1px solid var(--ink);">
                    <span class="display-md" style="font-size: 24px;">Total</span>
                    <span class="display-md" style="font-size: 24px;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <p class="caption text-muted mb-6">Pajak dan ongkos kirim akan dihitung saat konfirmasi oleh admin.</p>

                <button type="submit" form="checkoutForm" class="btn btn-primary w-full text-center" style="padding: 16px; font-size: 18px;">Buat Pesanan</button>
            </div>
        </div>
    </div>
</div>
@endsection
