@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Main Content --}}
    <main>
        <div class="container mt-4">
            <div>
                <h1 class="h4 pb-2 mb-4 text-danger border-bottom border-danger">Daftar Booking</h1>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Motor</th>
                        <th>Tanggal</th>
                        <th>Estimasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        @php
                            $bookingTime = \Carbon\Carbon::parse($booking->booking_date);
                            $startTime = $bookingTime->copy()->addMinutes(15);
                            $endTime = $bookingTime->copy()->addMinutes(75);
                            $isOver = now()->greaterThan($endTime);
                        @endphp
                        <tr>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->vehicle_type }} - {{ $booking->plate_number }}</td>
                            <td>{{ $bookingTime->format('d-m-Y H:i') }}</td>
                            <td>
                                {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }} WIB
                                @if ($isOver)
                                    <br><span class="text-danger fw-bold">Sudah Melewati Estimasi!</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="on_progress"
                                            {{ $booking->status == 'on_progress' ? 'selected' : '' }}>
                                            On Progress</option>
                                        <option value="done" {{ $booking->status == 'done' ? 'selected' : '' }}>Done
                                        </option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-danger btn-sm">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-info">Kembali</a>

            <br>
            <br> --}}
        </div>
    </main>
@endsection
