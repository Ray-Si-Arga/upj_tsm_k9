<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Service - {{ $advisor->booking->plate_number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }

        .header h3 {
            margin: 0;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 3px;
            vertical-align: top;
        }

        /* Table Style untuk Barang */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .data-table th {
            background-color: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .grand-total {
            font-size: 14px;
            font-weight: bold;
            background-color: #ddd;
        }
    </style>
</head>

<body>

    <div class="header">
        <h3>Form Service & Invoice</h3>
        <p>Bengkel "Masbro" - Jaminan Servis Terbaik</p>
    </div>

    {{-- Informasi Customer & Kendaraan --}}
    <table class="info-table">
        <tr>
            <td width="15%"><strong>No. Antrian</strong></td>
            <td width="35%">: {{ $advisor->booking->queue_number }}</td>
            <td width="15%"><strong>Tanggal</strong></td>
            <td width="35%">: {{ date('d-m-Y', strtotime($advisor->booking->booking_date)) }}</td>
        </tr>
        <tr>
            <td><strong>Nama Customer</strong></td>
            <td>: {{ $advisor->booking->customer_name }}</td>
            <td><strong>Kendaraan</strong></td>
            <td>: {{ $advisor->booking->vehicle_type }}</td>
        </tr>
        <tr>
            {{-- Menampilkan Nama Mekanik yang baru kita tambahkan --}}
            <td><strong>Mekanik</strong></td>
            <td colspan="3">: {{ $advisor->nama_mekanik ?? '-' }}</td>
        </tr>
    </table>

    <h4>A. Jasa Service</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th>Deskripsi Pekerjaan</th>
                <th width="20%" class="text-right">Biaya</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $advisor->booking->service->name }}</td>
                <td class="text-right">Rp {{ number_format($advisor->booking->service->price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h4>B. Suku Cadang (Spareparts)</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th width="10%" class="text-center">Qty</th>
                <th width="20%" class="text-right">Harga Satuan</th>
                <th width="20%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @if ($advisor->spareparts && count($advisor->spareparts) > 0)
                @foreach ($advisor->spareparts as $part)
                    <tr>
                        <td>{{ $part['name'] }}</td>
                        <td class="text-center">{{ $part['qty'] }}</td>
                        <td class="text-right">Rp {{ number_format($part['price'], 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($part['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">Tidak ada penggantian sparepart.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <h4>C. Total Pembayaran</h4>
    <table class="data-table">
        <tr class="grand-total">
            <td width="80%" class="text-right">TOTAL ESTIMASI BIAYA</td>
            <td class="text-right">Rp {{ number_format($advisor->total_estimation, 0, ',', '.') }}</td>
        </tr>
    </table>

    <br>

    <h4>Catatan & Keluhan</h4>
    <table class="data-table">
        <tr>
            <th width="50%">Keluhan Konsumen</th>
            <th width="50%">Catatan Mekanik/Advisor</th>
        </tr>
        <tr>
            <td style="height: 60px;">{{ $advisor->customer_complaint ?? '-' }}</td>
            <td>{{ $advisor->advisor_notes ?? '-' }}</td>
        </tr>
    </table>

</body>

</html>
