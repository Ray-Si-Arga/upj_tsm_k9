@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Detail Booking</h3>
        <p><strong>Nama:</strong> {{ $booking->customer_name }}</p>
        <p><strong>Motor:</strong> {{ $booking->vehicle_type }} - {{ $booking->plate_number }}</p>
        <p><strong>Tanggal Booking:</strong> {{ $booking->booking_date }}</p>
        <p><strong>Komplain:</strong> {{ $booking->complaint }}</p>
        <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($booking->status) }}</span></p>

        <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST" class="mt-3">
            @csrf
            <label for="status">Update Status:</label>
            <select name="status" class="form-select">
                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="on_progress" {{ $booking->status == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                <option value="done" {{ $booking->status == 'done' ? 'selected' : '' }}>Done</option>
                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Update Status</button>
            <a href="{{ route('booking.index') }}" class="btn btn-primary mt-2">Kembali</a>
        </form>
    </div>
@endsection
