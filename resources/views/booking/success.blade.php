@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            /* Background abu muda yang nyaman */
        }

        .success-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: white;
            position: relative;
            max-width: 450px;
            margin: 0 auto;
        }

        /* Header Hijau Melengkung */
        .success-header {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%);
            padding: 40px 30px 50px;
            /* Padding bawah lebih besar untuk icon */
            color: white;
            text-align: center;
            border-radius: 0 0 50% 50% / 0 0 20px 20px;
        }

        /* Icon Centang Animasi */
        .success-icon-box {
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -45px auto 20px;
            /* Posisi naik ke atas header */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }

        .success-icon-box i {
            font-size: 45px;
            color: #198754;
            animation: popIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes popIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            80% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        /* Bagian Nomor Antrian */
        .queue-box {
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin: 10px 30px 25px;
        }

        .queue-number {
            font-size: 3.5rem;
            font-weight: 800;
            color: #212529;
            line-height: 1;
            letter-spacing: -2px;
        }

        .queue-label {
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #6c757d;
            margin-bottom: 5px;
        }

        /* List Detail */
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.95rem;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #6c757d;
            font-weight: 500;
        }

        .detail-value {
            font-weight: 600;
            color: #212529;
            text-align: right;
        }

        .info-alert {
            background-color: #fff3cd;
            color: #856404;
            border: none;
            border-radius: 12px;
            font-size: 0.85rem;
            padding: 15px;
            display: flex;
            align-items: start;
            gap: 10px;
            text-align: left;
        }

        .btn-dashboard {
            background: #0d6efd;
            border: none;
            border-radius: 50px;
            padding: 12px 0;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
            transition: transform 0.2s;
        }

        .btn-dashboard:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
        }

        .btn-outline-custom {
            border: 2px solid #e9ecef;
            color: #6c757d;
            border-radius: 50px;
            padding: 10px 0;
            font-weight: 600;
        }

        .btn-outline-custom:hover {
            background-color: #f8f9fa;
            color: #495057;
        }
    </style>

    <main class="py-5 d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="success-card animate__animated animate__fadeInUp">

                {{-- 1. Header Hijau --}}
                <div class="success-header">
                    <h4 class="fw-bold mb-0">Booking Berhasil!</h4>
                    <p class="small opacity-75 mb-0">Terima kasih telah melakukan reservasi.</p>
                </div>

                {{-- 2. Icon Centang --}}
                <div class="success-icon-box">
                    <i class="fas fa-check"></i>
                </div>

                <div class="card-body px-4 pb-4 pt-0">

                    {{-- 3. Nomor Antrian Besar --}}
                    <div class="queue-box">
                        <div class="queue-label">Nomor Antrian Anda</div>
                        <div class="queue-number">{{ $booking->queue_number }}</div>
                    </div>

                    {{-- 4. Detail Booking --}}
                    <div class="mb-4">
                        {{-- Layanan --}}
                        <div class="detail-item">
                            <span class="detail-label">Layanan</span>
                            <span class="detail-value text-primary">{{ $booking->service->name }}</span>
                        </div>

                        {{-- Tanggal --}}
                        <div class="detail-item">
                            <span class="detail-label">Tanggal</span>
                            <span class="detail-value">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->translatedFormat('l, d M Y') }}
                            </span>
                        </div>

                        {{-- Estimasi Waktu --}}
                        @php
                            $bookingTime = \Carbon\Carbon::parse($booking->booking_date);
                            // Cek apakah ada estimasi durasi dari database, jika tidak default 60 menit
                            $duration = $booking->estimation_duration ?? 60;
                            $endTime = $bookingTime->copy()->addMinutes($duration)->format('H:i');
                        @endphp
                        <div class="detail-item">
                            <span class="detail-label">Estimasi Pengerjaan</span>
                            <span class="detail-value">
                                {{ $bookingTime->format('H:i') }} - {{ $endTime }} WIB
                            </span>
                        </div>

                        {{-- Status --}}
                        <div class="detail-item">
                            <span class="detail-label">Status Saat Ini</span>
                            <span class="badge bg-warning text-dark px-3 rounded-pill fw-bold text-uppercase"
                                style="font-size: 0.75rem;">
                                {{ $booking->status == 'pending' ? 'Menunggu Konfirmasi' : $booking->status }}
                            </span>
                        </div>
                    </div>

                    {{-- 5. Informasi Penting --}}
                    <div class="info-alert mb-4">
                        <i class="fas fa-info-circle mt-1 fs-5"></i>
                        <div>
                            <strong>Mohon Datang Tepat Waktu</strong><br>
                            Silakan datang 15 menit sebelum jadwal. Tunjukkan nomor antrian ini kepada petugas saat tiba di
                            bengkel.
                        </div>
                    </div>

                    {{-- 6. Tombol Aksi --}}
                    <div class="d-grid gap-2">
                        {{-- Arahkan ke Dashboard Pelanggan untuk Tracking --}}
                        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-dashboard text-white">
                            <i class="fas fa-tachometer-alt me-2"></i>Pantau Status di Dashboard
                        </a>

                        {{-- Booking Lagi --}}
                        <a href="{{ route('pelanggan.service') }}" class="btn btn-outline-custom">
                            Booking Lagi
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection
