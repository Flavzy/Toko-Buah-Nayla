@extends('layouts.admin')

@section('header_title', 'Scan QR Pelanggan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="card text-center" style="max-width: 600px; margin: 0 auto; width: 100%;">
        <h2 class="display-md mb-2" style="font-size: 20px;">Arahkan ke QR Code</h2>
        <p class="caption text-muted mb-6">Pindai kode QR dari layar atau struk pelanggan untuk melihat detail pesanannya secara otomatis.</p>
        
        <div id="reader" style="width: 100%; max-width: 500px; margin: 0 auto; border-radius: 12px; overflow: hidden; border: 2px dashed var(--hairline);"></div>
        
        <p id="scan-result" class="mt-4 body-strong text-muted" style="min-height: 24px;"></p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const html5QrCode = new Html5Qrcode("reader");
        const resultDisplay = document.getElementById('scan-result');
        let isScanning = true;

        const qrCodeSuccessCallback = (decodedText, decodedResult) => {
            if (isScanning) {
                isScanning = false;
                resultDisplay.innerHTML = `<span style="color:var(--primary);">Menemukan pesanan. Mengalihkan...</span>`;
                
                // Hentikan scanner saat berhasil
                html5QrCode.stop().then((ignore) => {
                    // Redirect ke URL yang discan (seharusnya adalah url detail pesanan)
                    window.location.href = decodedText;
                }).catch((err) => {
                    // Jika gagal menghentikan, tetap alihkan
                    window.location.href = decodedText;
                });
            }
        };

        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        // Mulai scanning menggunakan kamera belakang (jika ada)
        html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback)
        .catch((err) => {
            console.error("Error memulai scanner:", err);
            resultDisplay.innerHTML = `<span style="color:#ef4444;">Gagal mengakses kamera. Harap pastikan browser memiliki izin kamera.</span>`;
        });
    });
</script>
@endpush
