@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">

    <style>
        .form-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: white;
            overflow: hidden;
            max-width: 900px;
            margin: 0 auto;
        }

        .form-header {
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            /* Green Gradient */
            padding: 25px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-label-custom {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.15);
            border-color: #198754;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #6c757d;
        }

        .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .form-select {
            border-radius: 10px;
        }

        .btn-modern {
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: transform 0.2s;
        }

        .btn-modern:active {
            transform: scale(0.98);
        }

        .info-box {
            background-color: #e8f5e9;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
    </style>

    <main class="py-4">
        <div class="container">

            {{-- Notifikasi Error --}}
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3 mx-auto" style="max-width: 900px;">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-exclamation-circle fs-4 me-2"></i>
                        <h6 class="mb-0 fw-bold">Terjadi Kesalahan</h6>
                    </div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('booking.storeWalkIn') }}" method="POST">
                @csrf

                <div class="form-card">
                    {{-- Header --}}
                    <div class="form-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white bg-opacity-25 p-2 rounded-3">
                                <i class="fas fa-user-plus fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Booking Manual (Walk-In)</h5>
                                <small class="opacity-75">Input untuk customer yang datang langsung / Booking Admin</small>
                            </div>
                        </div>
                        <a href="{{ route('admin.dashboard') }}"
                            class="btn btn-light btn-sm fw-bold text-success shadow-sm">
                            <i class="fas fa-arrow-left me-1"></i> Dashboard
                        </a>
                    </div>

                    <div class="card-body p-4 p-md-5">

                        {{-- Info Box --}}
                        <div class="info-box shadow-sm">
                            <i class="fas fa-info-circle fs-4 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Informasi Antrian</h6>
                                <p class="mb-0 small">Booking ini akan dicek ketersediaan slotnya. Jika slot penuh, booking
                                    akan ditolak.</p>
                            </div>
                        </div>

                        <div class="row g-4">

                            {{-- BAGIAN 1: Data Customer --}}
                            <div class="col-md-12">
                                <h6 class="text-success fw-bold border-bottom pb-2 mb-3"><i
                                        class="fas fa-user me-2"></i>Data Pelanggan</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Nama Customer</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="customer_name" class="form-control"
                                        placeholder="Contoh: Pak Budi" value="{{ old('customer_name') }}" required
                                        autofocus>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">WhatsApp / HP <small
                                        class="text-muted fw-normal">(Opsional)</small></label>
                                <div class="input-group">
                                    <span class="input-group-text text-success"><i class="fab fa-whatsapp"></i></span>
                                    <input type="text" name="customer_whatsapp" class="form-control"
                                        placeholder="Kosongkan jika tidak ada" value="{{ old('customer_whatsapp') }}">
                                </div>
                            </div>

                            {{-- BAGIAN 2: Data Kendaraan & Waktu --}}
                            <div class="col-md-12 mt-4">
                                <h6 class="text-success fw-bold border-bottom pb-2 mb-3"><i
                                        class="fas fa-motorcycle me-2"></i>Data Kendaraan & Waktu</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Plat Nomor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                    <input type="text" name="plate_number" class="form-control text-uppercase"
                                        placeholder="B 1234 XYZ" value="{{ old('plate_number') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Jenis Kendaraan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-bicycle"></i></span>
                                    <input type="text" name="vehicle_type" class="form-control"
                                        placeholder="Contoh: Honda Beat 2020" value="{{ old('vehicle_type') }}" required>
                                </div>
                            </div>

                            {{-- INPUT PENTING YANG SEBELUMNYA HILANG --}}
                            <div class="col-md-6">
                                <label class="form-label-custom">Tanggal & Jam Booking</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    {{-- Value default: Waktu sekarang --}}
                                    <input type="datetime-local" name="booking_date" class="form-control" required
                                        value="{{ old('booking_date', now()->format('Y-m-d\TH:i')) }}">
                                </div>
                                <div class="form-text small text-primary"><i class="fas fa-exclamation-circle me-1"></i>
                                    Tentukan kapan motor akan dikerjakan.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Jenis Service</label>
                                <select name="service_id" class="form-select" required>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- BAGIAN 3: Estimasi Durasi --}}
                            <div class="col-md-12 mt-2">
                                <div class="p-3 bg-light rounded border">
                                    <label class="form-label-custom mb-2">Estimasi Durasi Pengerjaan <small
                                            class="text-muted fw-normal">(Opsional)</small></label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="input-group">
                                                <input type="number" name="estimation_hours" class="form-control"
                                                    placeholder="0" min="0"
                                                    value="{{ old('estimation_hours') }}">
                                                <span
                                                    class="input-group-text bg-white border-start-0 text-muted small">Jam</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                <input type="number" name="estimation_minutes" class="form-control"
                                                    placeholder="0" min="0" max="59"
                                                    value="{{ old('estimation_minutes') }}">
                                                <span
                                                    class="input-group-text bg-white border-start-0 text-muted small">Menit</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-text small mt-1"><i class="fas fa-clock me-1"></i> Isi jika Anda
                                        sudah tahu kira-kira berapa lama service akan berlangsung.</div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-3 mt-5">
                            <a href="{{ route('admin.dashboard') }}"
                                class="btn btn-light btn-modern text-secondary border">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success btn-modern px-5 shadow">
                                <i class="fas fa-check-circle me-2"></i> Proses Booking
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    {{-- Script Notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('success'))
                new Notify({
                    status: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                    effect: 'slide',
                    speed: 300,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 3000,
                    position: 'right top'
                });
            @endif

            @if (Session::has('error'))
                new Notify({
                    status: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                    effect: 'slide',
                    speed: 300,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 5000,
                    position: 'right top'
                });
            @endif
        });
    </script>
@endsection
