@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-box-open me-2"></i> Paket / Layanan yang Dipilih
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">Nama Layanan</th>
                            <th class="px-4 text-end">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking->services as $service)
                            <tr>
                                <td class="px-4">
                                    <strong>{{ $service->name }}</strong>
                                    @if ($service->description)
                                        <div class="text-muted small">{{ $service->description }}</div>
                                    @endif
                                </td>
                                <td class="px-4 text-end">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="fw-bold bg-light">
                        <tr>
                            <td class="px-4 text-end">TOTAL ESTIMASI</td>
                            <td class="px-4 text-end text-primary">
                                Rp {{ number_format($booking->services->sum('price'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST" class="mt-3">
            @csrf
            <label for="status">Update Status:</label>
            <select name="status" class="form-select">
                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="on_progress" {{ $booking->status == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                <option value="done" {{ $booking->status == 'done' ? 'selected' : '' }}>Done</option>
                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Update Status</button> --}}
            <a href="{{ route('booking.index') }}" class="btn btn-primary mt-2">Kembali</a>
        {{-- </form> --}}
    </div>
@endsection
