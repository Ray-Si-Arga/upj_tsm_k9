@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> Input Booking Manual</h4>
                    <small>Gunakan fitur ini untuk customer yang datang langsung / tidak punya HP.</small>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('booking.store') }}">
                        @csrf

                        {{-- Info Antrian --}}
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                            <div>
                                {{-- Antrian aktif hari ini: <strong>{{ $todayActive }} Kendaraan</strong>. --}}
                                Booking ini akan otomatis masuk ke antrian hari ini.
                            </div>
                        </div>

                        <div class="row">
                            {{-- Data Customer --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nama Customer</label>
                                <input type="text" name="customer_name" class="form-control form-control-lg" placeholder="Contoh: Pak Budi (Vario Merah)" required autofocus>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor WhatsApp / HP</label>
                                <input type="text" name="customer_whatsapp" class="form-control" placeholder="Kosongkan jika tidak punya HP">
                                <small class="text-muted text-danger">* Boleh dikosongkan</small>
                            </div>

                            {{-- Data Kendaraan --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Plat Nomor</label>
                                <input type="text" name="plate_number" class="form-control text-uppercase" placeholder="B 1234 XYZ" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kendaraan</label>
                                <input type="text" name="vehicle_type" class="form-control" placeholder="Contoh: Honda Beat 2020" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jenis Service</label>
                                <select name="service_id" class="form-select" required>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-save"></i> Buat Booking & Masuk Antrian
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection