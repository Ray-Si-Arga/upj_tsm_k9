@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* --- Styles untuk Stepper (Sama seperti sebelumnya) --- */
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

        /* --- Style Baru untuk History Card --- */
        .card-history {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .status-badge-done {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .status-badge-cancelled {
            background-color: #f8d7da;
            color: #842029;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }
    </style>

    <main class="py-4">
        <div class="container">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h3 class="fw-bold text-dark">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-muted mb-0">Pantau status servis dan riwayat kendaraan Anda.</p>
                </div>
                <a href="{{ route('pelanggan.service') }}" class="btn btn-primary rounded-pill shadow-sm">
                    <i class="fas fa-plus me-2"></i>Booking Baru
                </a>
            </div>

            {{-- ================================================= --}}
            {{-- BAGIAN 1: STATUS AKTIF (Menunggu / Dikerjakan)    --}}
            {{-- ================================================= --}}

            @if ($activeBookings->isNotEmpty())
                <h5 class="fw-bold text-primary mb-3"><i class="fas fa-bolt me-2"></i>Sedang Berjalan</h5>

                @foreach ($activeBookings as $booking)
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div
                            class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold text-dark">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d F Y') }}
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

                            {{-- Logic Progress Bar --}}
                            @php
                                $status = $booking->status;
                                $progressWidth = '15%'; // Default Pending
                                if ($status == 'approved') {
                                    $progressWidth = '50%';
                                } elseif ($status == 'on_progress') {
                                    $progressWidth = '80%';
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
                                <div class="stepper-item {{ $status == 'on_progress' ? 'active pulse' : '' }}">
                                    <div class="step-counter"><i class="fas fa-wrench"></i></div>
                                    <div class="step-name">Dikerjakan</div>
                                </div>
                                <div class="stepper-item">
                                    <div class="step-counter"><i class="fas fa-flag-checkered"></i></div>
                                    <div class="step-name">Selesai</div>
                                </div>
                            </div>

                            {{-- Pesan Estimasi jika sedang dikerjakan --}}
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
            @else
                {{-- Jika tidak ada service aktif --}}
                {{-- Kita sembunyikan alert besar jika user punya history (biar ga penuh) --}}
                @if ($historyBookings->isEmpty())
                    <div class="alert alert-info border-0 shadow-sm rounded-4 p-5 text-center mb-5">
                        <i class="fas fa-motorcycle fa-3x mb-3 text-info opacity-50"></i>
                        <h5>Belum ada aktivitas servis</h5>
                        <p>Booking servis sekarang untuk perawatan motor Anda.</p>
                    </div>
                @endif
            @endif


            {{-- ================================================= --}}
            {{-- BAGIAN 2: RIWAYAT SERVIS (Selesai / Batal)        --}}
            {{-- ================================================= --}}

            <h5 class="fw-bold text-secondary mb-3 mt-5"><i class="fas fa-history me-2"></i>Riwayat Servis</h5>

            @if ($historyBookings->isEmpty())
                <p class="text-muted fst-italic">Belum ada riwayat servis.</p>
            @else
                <div class="card card-history">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4">Tanggal</th>
                                        <th class="py-3 px-4">Kendaraan</th>
                                        <th class="py-3 px-4">Layanan</th>
                                        <th class="py-3 px-4 text-center">Status</th>
                                        {{-- <th class="py-3 px-4 text-center">Nota</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historyBookings as $history)
                                        <tr>
                                            <td class="px-4">
                                                <div class="fw-bold text-dark">
                                                    {{ \Carbon\Carbon::parse($history->booking_date)->translatedFormat('d M Y') }}
                                                </div>
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($history->booking_date)->format('H:i') }}
                                                    WIB</small>
                                            </td>
                                            <td class="px-4">
                                                <div class="fw-semibold">{{ $history->vehicle_type }}</div>
                                                <small class="text-muted">{{ strtoupper($history->plate_number) }}</small>
                                            </td>
                                            <td class="px-4">
                                                {{ $history->service->name }}
                                            </td>
                                            <td class="px-4 text-center">
                                                @if ($history->status == 'done')
                                                    <span class="status-badge-done"><i class="fas fa-check-circle me-1"></i>
                                                        Selesai</span>
                                                @else
                                                    <span class="status-badge-cancelled"><i
                                                            class="fas fa-times-circle me-1"></i> Dibatalkan</span>
                                                @endif
                                            </td>
                                            {{-- <td class="px-4 text-center">
                                                @if ($history->status == 'done')
                                                    <button class="btn btn-sm btn-outline-secondary rounded-circle" title="Download Nota"><i class="fas fa-download"></i></button>
                                                @else
                                                    -
                                                @endif
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection
