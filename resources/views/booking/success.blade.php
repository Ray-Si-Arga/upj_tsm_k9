@extends('layouts.app')

@section('content')
<div class="container text-center" style="max-width: 400px;">
    <h3 class="fw-bold">Selamat, Anda berhasil melakukan booking!</h3>

    <div class="mb-3">
        <div class="rounded-circle d-inline-flex justify-content-center align-items-center"
             style="width: 80px; height: 80px; background-color: #e6f9ec;">
            <i class="bi bi-check-lg" style="font-size: 40px; color: #28a745;"></i>
        </div>
    </div>

    <h5 class="fw-bold">Nomor Antrian</h5>
    <h1 class="display-4 text-primary fw-bold">{{ $booking->queue_number }}</h1>

    <div class="card mt-3 text-start shadow-sm">
        <div class="card-body">
            <p><strong>Jenis Service:</strong> {{ $booking->service->name }}</p>
            <p><strong>Waktu Booking:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('H:i') }} WIB</p>
            @php
                $bookingTime = \Carbon\Carbon::parse($booking->booking_date);
                $endTime = $bookingTime->copy()->addMinutes(75)->format('H:i');
            @endphp
            <p><strong>Estimasi Layanan:</strong> {{ $bookingTime->format('H:i') }} - {{ $endTime }} WIB</p>

            <p><strong>Status:</strong> <span class="text-danger fw-bold">{{ $booking->status }}</span></p>
        </div>
    </div>

    <p class="mt-3 text-muted">
        Silakan datang 15 menit sebelum waktu estimasi layanan.<br>
        Kami akan mengirimkan notifikasi WhatsApp saat giliran Anda.
    </p>

    <div class="mt-3">
        <a href="{{ route('booking.queue') }}" class="btn btn-primary">Lihat Daftar Antrian</a>
        <a href="{{ route('booking.create') }}" class="btn btn-secondary">Booking Lagi</a>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection
