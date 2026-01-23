@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Cetak QR - {{ $kendaraan->no_polisi }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/print-qr.css') }}">
</head>
<body>

    <div class="no-print">
        <a href="{{ route('operator.kendaraan.index') }}" class="btn-back">Kembali</a>
        <button id="printBtn" class="btn-print">Cetak Stiker</button>
    </div>

    <div class="sticker-card">
        <div class="qr-area">
            <div class="qr-wrapper">
                {!! QrCode::size(200)->style('round')->generate(url($kendaraan->kode_qr)) !!}
            </div>
        </div>

        <div class="card-footer">
            <div class="app-brand">ASET KENDARAAN DINAS</div>
        </div>
    </div>

    <script src="{{ asset('js/print-qr.js') }}"></script>
</body>
</html>
