@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Cetak QR - {{ $kendaraan->kode_qr }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .print-container {
            margin-top: 40px;
        }

        .qr-box {
            display: inline-block;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .plat {
            margin-top: 10px;
            font-weight: bold;
            font-size: 18px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="no-print">
        Cetak QR
    </button>

    <div class="print-container">
        <div class="qr-box">
            {!! QrCode::size(250)->generate(url($kendaraan->kode_qr)) !!}
            <div class="plat">
                {{ $kendaraan->nomor_kendaraan }}
            </div>
        </div>
    </div>

</body>
</html>
