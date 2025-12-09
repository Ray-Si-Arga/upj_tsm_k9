@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Form Booking Antrian Service</h3>

    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp

    @if($todayActive >= 50)
        <div class="alert alert-danger">
            Kuota antrian untuk hari ini sudah penuh (maksimal 50).
        </div>
    @else

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Jenis Kendaraan</label>
                <select name="vehicle_type" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="matic">Matic</option>
                    <option value="bebek">Bebek</option>
                    <option value="cup">Cup</option>
                    <option value="sport">Sport</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Plat Nomor</label>
                <input type="text" name="plate_number" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tanggal & Jam Booking</label>
                <input type="datetime-local" name="booking_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jenis Service</label>
                <select name="service_id" class="form-select" required>
                    <option value="">-- Pilih Service --</option>
                    @foreach(\App\Models\Service::all() as $service)
                        <option value="{{ $service->id }}">
                            {{ $service->name }} - Rp {{ number_format($service->price,0,',','.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Nama Customer</label>
                <input type="text" name="customer_name" class="form-control" value="{{ $user->name }}" readonly required>
            </div>

            <div class="mb-3">
                <label>No. WhatsApp</label>
                <input type="text" name="customer_whatsapp" class="form-control" value="{{ $user->phone ?? '' }}" required>
            </div>

            <input type="hidden" name="quota" value="1">
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <button type="submit" class="btn btn-primary">Booking</button>
        </form>
    @endif
</div>
@endsection
