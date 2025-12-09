@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Antrian Hari Ini</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No. Antrian</th>
                <th>Nama Customer</th>
                <th>Service</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($queueBookings as $booking)
                <tr>
                    <td><strong>{{ $booking->queue_number }}</strong></td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->service->name ?? '-' }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada booking</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
