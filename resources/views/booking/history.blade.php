@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Service</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Polisi</th>
                <th>Jenis Kendaraan</th>
                <th>Service</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_date }}</td>
                    <td>{{ $booking->plate_number }}</td>
                    <td>{{ $booking->vehicle_type }}</td>
                    <td>{{ $booking->service->name }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                    <td>
                        <a href="{{ route('booking.history.detail', [$booking->customer_whatsapp, $booking->id]) }}" class="btn btn-primary btn-sm">
                            Detail
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">← Kembali ke Daftar Pelanggan</a>
</div>
@endsection
