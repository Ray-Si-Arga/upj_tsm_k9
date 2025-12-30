@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* CSS Stepper */
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

        .progress-line {
            position: absolute;
            top: 15px;
            left: 0;
            height: 4px;
            background-color: #198754;
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
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h3 class="fw-bold text-dark">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-muted mb-0">Pantau status servis kendaraan Anda.</p>
                </div>

                {{-- Tombol Navigasi (Penting: Ini pengganti tabel history lama) --}}
                <div class="d-flex gap-2">
                    {{-- Link ke halaman Riwayat baru --}}
                    <a href="{{ route('pelanggan.history') }}" class="btn btn-outline-secondary rounded-pill shadow-sm">
                        <i class="fas fa-history me-2"></i>Riwayat
                    </a>
                </div>
            </div>

            {{-- LOOPING STATUS AKTIF (Hanya pakai $activeBookings) --}}
            @if ($activeBookings->isEmpty())
                <div class="alert alert-info border-0 shadow-sm rounded-4 p-5 text-center">
                    <i class="fas fa-motorcycle fa-3x mb-3 text-info opacity-50"></i>
                    <h5>Tidak ada servis aktif</h5>
                    <p>Kendaraan Anda sedang tidak dalam antrian servis.</p>
                    <a href="{{ route('pelanggan.history') }}" class="text-decoration-none fw-bold">Cek Riwayat Servis</a>
                </div>
            @else
                @foreach ($activeBookings as $booking)
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div
                            class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold text-dark">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->translatedFormat('l, d F Y') }}
                                <span class="text-muted ms-2 fw-normal">Jam
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('H:i') }}</span>
                            </h6>
                            <span class="badge bg-primary rounded-pill">Antrian #{{ $booking->queue_number }}</span>
                        </div>

                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="fw-bold mb-1">{{ $booking->vehicle_type }}</h4>
                                    <span
                                        class="badge bg-warning text-dark text-uppercase px-3 py-2 rounded-pill">{{ $booking->plate_number }}</span>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <div class="text-muted small">Layanan</div>
                                    <div class="fw-bold fs-5">{{ $booking->service->name ?? 'Service Umum' }}</div>
                                </div>
                            </div>

                            @php
                                $status = $booking->status;
                                $progressWidth = '13%';
                                if ($status == 'approved') {
                                    $progressWidth = '50%';
                                } elseif ($status == 'on_progress') {
                                    $progressWidth = '75%';
                                }
                            @endphp

                            <div class="stepper-wrapper">
                                <div class="progress-line" style="width: {{ $progressWidth }}"></div>
                                <div
                                    class="stepper-item {{ in_array($status, ['pending', 'approved', 'on_progress']) ? 'completed' : '' }}">
                                    <div class="step-counter"><i class="fas fa-clock"></i></div>
                                    <div class="step-name">Menunggu</div>
                                </div>
                                <div
                                    class="stepper-item {{ in_array($status, ['approved', 'on_progress']) ? 'completed' : '' }}">
                                    <div class="step-counter"><i class="fas fa-clipboard-check"></i></div>
                                    <div class="step-name">Diterima</div>
                                </div>
                                <div class="stepper-item {{ $status == 'on_progress' ? 'completed' : '' }}">
                                    <div class="step-counter"><i class="fas fa-wrench"></i></div>
                                    <div class="step-name">Dikerjakan</div>
                                </div>
                                <div class="stepper-item">
                                    <div class="step-counter"><i class="fas fa-flag-checkered"></i></div>
                                    <div class="step-name">Selesai</div>
                                </div>
                            </div>

                            @if ($status == 'on_progress' && $booking->estimation_duration)
                                @php
                                    $estTime = \Carbon\Carbon::parse($booking->booking_date)->addMinutes(
                                        $booking->estimation_duration,
                                    );
                                @endphp
                                <div class="alert alert-primary d-flex align-items-center mt-4 border-0 rounded-3">
                                    <i
                                        class="fas fa-hourglass-half fa-2x me-3 animate__animated animate__pulse animate__infinite"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Sedang Dikerjakan Mekanik</h6>
                                        <p class="mb-0 small">Estimasi selesai pukul: <strong>{{ $estTime->format('H:i') }}
                                                WIB</strong></p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>
@endsection
