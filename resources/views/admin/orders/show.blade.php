@extends('layouts.admin')

@section('header_title', 'Detail Pesanan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('admin.orders.index') }}" class="caption text-muted"><i class="fa-solid fa-chevron-left"></i> Kembali ke Daftar Pesanan</a>
    
    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini secara permanen?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-utility" style="background: rgba(239,68,68,0.1); color: #ef4444 !important;"><i class="fa-solid fa-trash mr-2"></i> Hapus Pesanan</button>
    </form>
</div>

<div class="grid" style="grid-template-columns: 2fr 1fr; gap: 32px;">
    <!-- Rincian Item -->
    <div class="flex-col gap-6">
        <div class="card">
            <h2 class="display-md mb-6" style="font-size: 20px;">Daftar Item ({{ $order->order_number }})</h2>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th style="text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-4">
                                        <div style="width: 48px; height: 48px; background: var(--canvas-parchment); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="" style="max-width: 100%; max-height: 100%; border-radius: 6px;">
                                            @else
                                                <i class="fa-solid fa-apple-whole" style="color: var(--hairline);"></i>
                                            @endif
                                        </div>
                                        <span class="body-strong">{{ $item->product_name }}</span>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td style="text-align: right; font-weight: 600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: 600;">Total Pesanan</td>
                            <td style="text-align: right; font-weight: 600; font-size: 20px; color: var(--primary);">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Info Pelanggan & Status -->
    <div class="flex-col gap-6">
        <div class="card">
            <h2 class="display-md mb-4" style="font-size: 20px;">Update Status</h2>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex-col gap-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="status" class="form-label">Status Pesanan</label>
                    <select name="status" id="status" class="form-input">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Diterima</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                
                <div>
                    <label for="payment_status" class="form-label">Status Pembayaran</label>
                    <select name="payment_status" id="payment_status" class="form-input">
                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary mt-2" style="padding: 10px;">Simpan Perubahan</button>
            </form>
        </div>

        <div class="card">
            <h2 class="display-md mb-4" style="font-size: 20px;">Informasi Pembayaran & Pengambilan</h2>
            <div class="flex-col gap-2">
                <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method ?? '-' }}</p>
                <div style="margin: 8px 0; border-top: 1px dashed var(--hairline);"></div>
                <p><strong>Nama Pelanggan:</strong> {{ $order->customer_name }}</p>
                <p><strong>Telepon:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Metode Penerimaan:</strong> Ambil di Toko</p>
                @if($order->notes)
                    <div class="mt-2 pt-2" style="border-top: 1px solid var(--hairline);">
                        <p class="caption text-muted"><strong>Catatan Pelanggan:</strong></p>
                        <p class="caption">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <h2 class="display-md mb-4" style="font-size: 20px;">Info Akun</h2>
            <div class="flex-col gap-2">
                <p><strong>Nama Akun:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p class="caption text-muted">Mendaftar pada: {{ $order->user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
