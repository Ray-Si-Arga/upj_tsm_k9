@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Booking</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No. Polisi</th>
                <th>Tgl Booking</th>
                <th>Service</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->plate_number }}</td>
                    <td>{{ $booking->booking_date }}</td>
                    <td>{{ $booking->service->name ?? '-' }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                    <td>
                        <a href="{{ route('booking.history.detail', $booking->id) }}" class="btn btn-primary btn-sm">
                            Detail
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">← Kembali ke Pelanggan</a>
</div>
@endsection
