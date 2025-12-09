@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Booking</h2>
    <table class="table">
        <tr><th>Nama Customer</th><td>{{ $booking->customer_name }}</td></tr>
        <tr><th>No. WhatsApp</th><td>{{ $booking->customer_whatsapp }}</td></tr>
        <tr><th>Jenis Kendaraan</th><td>{{ $booking->vehicle_type }}</td></tr>
        <tr><th>No. Polisi</th><td>{{ $booking->plate_number }}</td></tr>
        <tr><th>Tanggal Booking</th><td>{{ $booking->booking_date }}</td></tr>
        <tr><th>Service</th><td>{{ $booking->service->name ?? '-' }}</td></tr>
        <tr><th>Status</th><td>{{ ucfirst($booking->status) }}</td></tr>
    </table>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">← Kembali ke Daftar Pelanggan</a>
</div>
@endsection
