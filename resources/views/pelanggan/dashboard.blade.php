@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* CSS Khusus untuk Stepper / Progress Tracker */
        .stepper-wrapper {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
        }

        .stepper-wrapper::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: #e9ecef;
            z-index: 0;
        }

        /* Garis Hijau yang berjalan sesuai status */
        .progress-line {
            position: absolute;
            top: 15px;
            left: 0;
            height: 4px;
            background-color: #198754;
            /* Warna Hijau Sukses */
            z-index: 1;
            transition: width 0.5s ease;
        }

        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            z-index: 2;
        }

        .step-counter {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #fff;
            border: 3px solid #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
            font-weight: bold;
            color: #6c757d;
            transition: all 0.3s;
        }

        .step-name {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 600;
            text-align: center;
        }

        /* Status Aktif / Selesai */
        .stepper-item.completed .step-counter,
        .stepper-item.active .step-counter {
            border-color: #198754;
            background-color: #198754;
            color: #fff;
        }

        .stepper-item.active .step-name {
            color: #198754;
            font-weight: 800;
        }

        .pulse {
            animation: pulse-animation 2s infinite;
        }

        @keyframes pulse-animation {
            0% {
                box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(25, 135, 84, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(25, 135, 84, 0);
            }
        }
    </style>

    <main class="py-4">
        <div class="container">
            {{-- Header --}}
            <div class="mb-4">
                <h3 class="fw-bold text-dark">Halo, {{ Auth::user()->name }}</h3>
                <p class="text-muted">Selamat datang di dashboard pelanggan.</p>
            </div>

            {{-- JIKA BELUM ADA BOOKING SAMA SEKALI --}}
            @if (!$lastBooking)
                <div class="alert alert-info border-0 shadow-sm rounded-4 p-4 text-center">
                    <i class="fas fa-motorcycle fa-3x mb-3 text-info opacity-50"></i>
                    <h5>Belum ada riwayat service</h5>
                    <p>Kendaraan Anda belum pernah diservis di sini. Yuk booking sekarang!</p>
                    <a href="{{ route('booking.create') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                        Booking Service Baru
                    </a>
                </div>
            @else
                {{-- JIKA ADA BOOKING --}}

                {{-- CARD UTAMA: STATUS TRACKER --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-history me-2"></i>Status Service Terakhir
                        </h6>
                        <span class="badge bg-light text-dark border">
                            {{ $lastBooking->booking_date ? \Carbon\Carbon::parse($lastBooking->booking_date)->translatedFormat('d F Y') : '-' }}
                        </span>
                    </div>
                    <div class="card-body p-4">

                        {{-- Info Kendaraan Singkat --}}
                        <div class="row align-items-center mb-4">
                            <div class="col-md-6">
                                <h4 class="fw-bold mb-1">{{ $lastBooking->vehicle_type }}</h4>
                                <span class="badge bg-warning text-dark text-uppercase px-3 py-2 rounded-pill">
                                    {{ $lastBooking->plate_number }}
                                </span>
                            </div>
                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                <div class="text-muted small">Layanan</div>
                                <div class="fw-bold fs-5">{{ $lastBooking->service->name ?? 'Service Umum' }}</div>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- LOGIKA PROGRESS BAR (INTI DARI PERMINTAAN ANDA) --}}
                        @php
                            $status = $lastBooking->status;
                            $progressWidth = '0%';

                            // Tentukan Lebar Garis Hijau & Status Step
                            if ($status == 'pending') {
                                $progressWidth = '15%';
                            } elseif ($status == 'approved') {
                                $progressWidth = '50%';
                            } elseif ($status == 'on_progress') {
                                $progressWidth = '80%';
                            } elseif ($status == 'done') {
                                $progressWidth = '100%';
                            }
                        @endphp

                        <div class="stepper-wrapper">
                            {{-- Garis Hijau Dinamis --}}
                            <div class="progress-line" style="width: {{ $progressWidth }}"></div>

                            {{-- STEP 1: MENUNGGU --}}
                            <div
                                class="stepper-item {{ in_array($status, ['pending', 'approved', 'on_progress', 'done']) ? 'completed' : '' }}">
                                <div class="step-counter"><i class="fas fa-clock"></i></div>
                                <div class="step-name">Menunggu</div>
                            </div>

                            {{-- STEP 2: DITERIMA --}}
                            <div
                                class="stepper-item {{ in_array($status, ['approved', 'on_progress', 'done']) ? 'completed' : '' }}">
                                <div class="step-counter"><i class="fas fa-clipboard-check"></i></div>
                                <div class="step-name">Diterima</div>
                            </div>

                            {{-- STEP 3: DIKERJAKAN --}}
                            <div
                                class="stepper-item {{ in_array($status, ['on_progress', 'done']) ? 'active pulse' : (in_array($status, ['done']) ? 'completed' : '') }}">
                                <div class="step-counter"><i class="fas fa-wrench"></i></div>
                                <div class="step-name">Dikerjakan</div>
                            </div>

                            {{-- STEP 4: SELESAI --}}
                            <div class="stepper-item {{ $status == 'done' ? 'completed' : '' }}">
                                <div class="step-counter"><i class="fas fa-flag-checkered"></i></div>
                                <div class="step-name">Selesai</div>
                            </div>
                        </div>

                        {{-- INFO ESTIMASI WAKTU (Jika sedang dikerjakan) --}}
                        @if ($status == 'on_progress' && $lastBooking->estimation_duration)
                            @php
                                $startTime = \Carbon\Carbon::parse($lastBooking->booking_date);
                                $endTime = $startTime->copy()->addMinutes($lastBooking->estimation_duration);
                            @endphp
                            <div class="alert alert-primary d-flex align-items-center mt-4 border-0 rounded-3 fade show"
                                role="alert">
                                <i
                                    class="fas fa-hourglass-half fa-2x me-3 animate__animated animate__pulse animate__infinite"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Sedang Dikerjakan!</h6>
                                    <p class="mb-0 small">
                                        Motor sedang ditangani mekanik. Estimasi selesai pada pukul:
                                        <span class="badge bg-white text-primary fs-6 ms-1">{{ $endTime->format('H:i') }}
                                            WIB</span>
                                    </p>
                                </div>
                            </div>
                        @elseif($status == 'done')
                            <div class="alert alert-success d-flex align-items-center mt-4 border-0 rounded-3"
                                role="alert">
                                <i class="fas fa-check-circle fa-2x me-3"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Service Selesai!</h6>
                                    <p class="mb-0 small">Kendaraan Anda sudah siap diambil. Silakan menuju kasir.</p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Action Button (Misal: Riwayat Lengkap) --}}
                {{-- <div class="text-center">
                    <a href="#" class="btn btn-outline-secondary rounded-pill">Lihat Semua Riwayat</a>
                </div> --}}
            @endif
        </div>
    </main>
@endsection
