<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan - {{ $order->order_number }}</title>
    <link rel="stylesheet" href="{{ asset('css/apple.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: var(--canvas-parchment);
            padding: 40px 24px;
        }
        .receipt-container {
            max-width: 480px;
            margin: 0 auto;
            background: var(--canvas);
            padding: 48px 32px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 2px dashed var(--hairline);
        }
        .receipt-body {
            margin-bottom: 32px;
        }
        .receipt-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .receipt-total {
            border-top: 2px dashed var(--hairline);
            padding-top: 16px;
            margin-top: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .qr-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 32px;
            border-top: 2px dashed var(--hairline);
        }
        @media print {
            body { background: white; padding: 0; }
            .receipt-container { box-shadow: none; border-radius: 0; padding: 24px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Print Button (Hidden when printing) -->
        <div class="text-center mb-6 no-print">
            <button onclick="window.print()" class="btn btn-primary" style="padding: 10px 24px;"><i class="fa-solid fa-print mr-2"></i> Cetak Struk</button>
            <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary ml-2" style="padding: 10px 24px;">Kembali</a>
        </div>

        <div class="receipt-header">
            <i class="fa-solid fa-apple-whole" style="font-size: 40px; color: var(--primary); margin-bottom: 16px;"></i>
            <h1 class="display-md" style="font-size: 24px;">Toko Buah Nayla</h1>
            <p class="caption text-muted mt-2">Jl. Contoh Alamat No. 123, Kota</p>
            <p class="caption text-muted">Telp: 081234567890</p>
        </div>

        <div class="receipt-body">
            <div style="margin-bottom: 24px;">
                <p class="caption"><strong>No. Pesanan:</strong> {{ $order->order_number }}</p>
                <p class="caption"><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p class="caption"><strong>Pelanggan:</strong> {{ $order->customer_name }}</p>
                <p class="caption"><strong>Metode:</strong> {{ $order->payment_method ?? '-' }}</p>
                <p class="caption"><strong>Status:</strong> {{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum Dibayar' }}</p>
            </div>

            <div style="margin-bottom: 16px;">
                <h3 class="body-strong mb-4">Item Pesanan:</h3>
                @foreach($order->items as $item)
                    <div class="receipt-item">
                        <div style="flex: 1;">
                            <p class="body-strong" style="font-size: 14px;">{{ $item->product_name }}</p>
                            <p class="caption text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="body-strong" style="font-size: 14px;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="receipt-total">
                <h2 class="display-md" style="font-size: 20px;">Total</h2>
                <h2 class="display-md" style="font-size: 20px;">Rp {{ number_format($order->total, 0, ',', '.') }}</h2>
            </div>
        </div>

        <div class="qr-section">
            <h3 class="body-strong mb-2">Scan QR Code</h3>
            <p class="caption text-muted mb-4">Tunjukkan QR Code ini kepada petugas kami</p>
            <div style="background: white; padding: 16px; display: inline-block; border-radius: 8px;">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate(route('admin.orders.show', $order)) !!}
            </div>
        </div>
    </div>
</body>
</html>
