<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Form Service Advisor</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 4px; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">FORM SERVICE ADVISOR</h3>

    <p><strong>Nama Konsumen:</strong> {{ $advisor->booking->customer_name }}</p>
    <p><strong>No. Polisi:</strong> {{ $advisor->booking->plate_number }}</p>
    <p><strong>Tanggal Booking:</strong> {{ $advisor->booking->booking_date }}</p>

    <h4>Pekerjaan</h4>
<p>{{ $advisor->booking->service->name }}
   (Rp {{ number_format($advisor->booking->service->price,0,',','.') }})
</p>


    <h4>Suku Cadang</h4>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
   @foreach($advisor->spareparts as $part)
    <tr>
        <td>{{ $part['name'] }}</td>
        <td>Rp {{ number_format($part['price'], 0, ',', '.') }}</td>
    </tr>
    @endforeach
    </tbody>
    </table>

    <h4>Total Estimasi</h4>
    <p><strong>Rp {{ number_format($advisor->total_estimation,0,',','.') }}</strong></p>

    <h4>Keluhan Konsumen</h4>
    <p>{{ $advisor->customer_complaint }}</p>

    <h4>Analisa Service Advisor</h4>
    <p>{{ $advisor->advisor_notes }}</p>
</body>
</html>
