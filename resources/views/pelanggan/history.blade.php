@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        :root {
            --honda-red: #B10000;
            --honda-red-dark: #8B0000;
            --honda-red-soft: rgba(177, 0, 0, 0.08);
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--gray-50) 0%, #fafbfc 100%);
            font-family: 'Inter', sans-serif;
        }

        /* ===== HEADER SECTION ===== */
        .history-header {
            margin-bottom: 2rem;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .history-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .history-title i {
            color: var(--honda-red);
            font-size: 2rem;
        }

        .history-subtitle {
            color: var(--gray-600);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: white;
            color: var(--gray-700);
            border: 1.5px solid var(--gray-200);
            border-radius: 0.75rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-top: 1rem;
        }

        .back-button:hover {
            background: var(--gray-50);
            border-color: var(--gray-300);
            transform: translateX(-4px);
            color: var(--gray-900);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            background: white;
            border-radius: 1rem;
            padding: 3rem 1.5rem;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--gray-300);
            margin-bottom: 1rem;
        }

        .empty-state-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .empty-state-text {
            color: var(--gray-600);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        /* ===== HISTORY CARDS (MOBILE-FIRST) ===== */
        .history-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            animation: fadeIn 0.5s ease-out;
        }

        .history-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .history-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
            border-color: var(--gray-200);
        }

        .history-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .history-date-badge {
            background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.85rem;
            min-width: fit-content;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
        }

        .history-date-badge .date {
            font-size: 1rem;
            font-weight: 800;
        }

        .history-date-badge .time {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .history-status {
            display: flex;
            gap: 0.5rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .status-badge.done {
            background: #d1fae5;
            color: var(--success-color);
        }

        .status-badge.cancelled {
            background: #fee2e2;
            color: var(--danger-color);
            border: none;
            cursor: pointer;
            padding: 0.5rem 1rem;
        }

        .status-badge i {
            font-size: 0.9rem;
        }

        /* ===== CARD CONTENT ===== */
        .history-card-content {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .card-section {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .card-section-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray-500);
        }

        .card-section-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .card-section-subtext {
            font-size: 0.85rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .vehicle-info {
            background: var(--gray-50);
            padding: 0.75rem;
            border-radius: 0.75rem;
            border-left: 3px solid var(--honda-red);
        }

        .vehicle-type {
            font-weight: 700;
            color: var(--gray-900);
            font-size: 0.95rem;
        }

        .plate-number {
            font-size: 0.85rem;
            color: var(--gray-600);
            font-family: 'Courier New', monospace;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 0.25rem;
        }

        .services-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .service-badge {
            background: linear-gradient(135deg, var(--honda-red-soft) 0%, rgba(177, 0, 0, 0.12) 100%);
            color: var(--honda-red);
            padding: 0.5rem 0.875rem;
            border-radius: 0.625rem;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid rgba(177, 0, 0, 0.2);
        }

        .complaint-box {
            background: #fef2f2;
            border-left: 3px solid var(--danger-color);
            padding: 0.75rem;
            border-radius: 0.75rem;
            color: var(--danger-color);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .complaint-box i {
            margin-right: 0.5rem;
        }

        /* ===== MODAL STYLING ===== */
        .modal-content {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
            color: white;
            border: none;
            border-radius: 1rem 1rem 0 0;
            padding: 1.5rem;
        }

        .modal-header .modal-title {
            font-weight: 800;
            font-size: 1.1rem;
        }

        .modal-body {
            padding: 2rem 1.5rem;
        }

        .rejection-alert {
            background: #fef2f2;
            border: 1.5px solid var(--danger-color);
            color: var(--danger-color);
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .rejection-alert i {
            margin-right: 0.5rem;
        }

        .rejection-message {
            font-size: 1rem;
            color: var(--gray-900);
            line-height: 1.6;
            font-weight: 500;
            font-style: italic;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 0.75rem;
            border-left: 3px solid var(--danger-color);
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--gray-200);
            gap: 0.75rem;
        }

        .btn-modal-close {
            background: var(--gray-100);
            color: var(--gray-700);
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-modal-close:hover {
            background: var(--gray-200);
            color: var(--gray-900);
        }

        .btn-rebook {
            background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-rebook:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(177, 0, 0, 0.3);
            color: white;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (min-width: 768px) {
            .history-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2.5rem;
            }

            .history-title {
                margin-bottom: 0;
            }

            .back-button {
                margin-top: 0;
            }

            .history-card {
                padding: 1.5rem;
            }

            .history-card-header {
                display: grid;
                grid-template-columns: auto 1fr auto;
                align-items: center;
                gap: 1.5rem;
            }

            .history-card-content {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            .card-section:nth-child(3),
            .card-section:nth-child(4) {
                grid-column: span 1;
            }

            .vehicle-info {
                grid-column: 1;
            }

            .services-container {
                grid-column: 2;
            }

            .complaint-box {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 767px) {
            .history-title {
                font-size: 1.5rem;
            }

            .history-card-header {
                margin-bottom: 1.25rem;
            }

            .back-button {
                width: 100%;
                justify-content: center;
            }

            .modal-body {
                padding: 1.5rem 1rem;
            }

            .modal-footer {
                flex-direction: column-reverse;
            }

            .modal-footer .btn {
                width: 100%;
            }
        }

        /* ===== LOADING & ANIMATION ===== */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .history-card {
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .history-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .history-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .history-card:nth-child(4) {
            animation-delay: 0.3s;
        }

        .history-card:nth-child(5) {
            animation-delay: 0.4s;
        }
    </style>
@endpush

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <main class="py-4 py-md-5">
        <div class="container-fluid px-3 px-md-4">
            {{-- HEADER SECTION --}}
            <div class="history-header">
                <div>
                    <h1 class="history-title">
                        <i class="fas fa-history"></i>
                        Riwayat Servis
                    </h1>
                    <p class="history-subtitle">
                        <i class="fas fa-info-circle" style="color: var(--gray-400); margin-right: 0.5rem;"></i>
                        Daftar kendaraan yang telah selesai diservis
                    </p>
                </div>
                <a href="{{ route('pelanggan.dashboard') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>

            {{-- CONTENT SECTION --}}
            @if ($historyBookings->isEmpty())
                {{-- EMPTY STATE --}}
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3 class="empty-state-title">Belum Ada Riwayat Servis</h3>
                    <p class="empty-state-text">
                        Anda belum memiliki transaksi servis yang selesai. Mulai booking servis sekarang untuk melihat riwayat di sini.
                    </p>
                    <a href="{{ route('pelanggan.service') }}" class="btn-rebook">
                        <i class="fas fa-plus me-2"></i>Booking Servis
                    </a>
                </div>
            @else
                {{-- HISTORY CARDS LIST --}}
                <div class="history-list">
                    @foreach ($historyBookings as $history)
                        <div class="history-card">
                            {{-- CARD HEADER: DATE, INFO, STATUS --}}
                            <div class="history-card-header">
                                {{-- DATE BADGE --}}
                                <div class="history-date-badge">
                                    <span class="date">
                                        {{ \Carbon\Carbon::parse($history->booking_date)->format('d') }}
                                    </span>
                                    <span class="time">
                                        {{ \Carbon\Carbon::parse($history->booking_date)->locale('id')->translatedFormat('M') }}
                                    </span>
                                </div>

                                {{-- MIDDLE INFO (Spacer) --}}
                                <div></div>

                                {{-- STATUS BADGE --}}
                                <div class="history-status">
                                    @if ($history->status == 'done')
                                        <span class="status-badge done">
                                            <i class="fas fa-check-circle"></i>
                                            Selesai
                                        </span>
                                    @elseif($history->status == 'cancelled')
                                        <button type="button"
                                            class="status-badge cancelled"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reasonModal{{ $history->id }}"
                                            style="border: none; background: none; padding: 0.5rem 1rem; cursor: pointer;">
                                            <i class="fas fa-times-circle"></i>
                                            Dibatalkan
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- CARD CONTENT --}}
                            <div class="history-card-content">
                                {{-- VEHICLE INFO --}}
                                <div class="card-section">
                                    <span class="card-section-label">
                                        <i class="fas fa-car me-1"></i>Kendaraan
                                    </span>
                                    <div class="vehicle-info">
                                        <div class="vehicle-type">{{ $history->vehicle_type }}</div>
                                        <div class="plate-number">
                                            <i class="fas fa-tag me-1"></i>{{ strtoupper($history->plate_number) }}
                                        </div>
                                    </div>
                                </div>

                                {{-- SERVICES --}}
                                <div class="card-section">
                                    <span class="card-section-label">
                                        <i class="fas fa-wrench me-1"></i>Layanan
                                    </span>
                                    <div class="services-container">
                                        @foreach ($history->services as $svc)
                                            <span class="service-badge">{{ $svc->name }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- COMPLAINT --}}
                                <div class="card-section" style="grid-column: 1 / -1;">
                                    <span class="card-section-label">
                                        <i class="fas fa-exclamation-circle me-1"></i>Keluhan
                                    </span>
                                    <div class="complaint-box">
                                        <i class="fas fa-comment-dots"></i>
                                        {{ $history->complaint }}
                                    </div>
                                </div>

                                {{-- BOOKING DATE & TIME --}}
                                <div class="card-section">
                                    <span class="card-section-label">
                                        <i class="fas fa-calendar me-1"></i>Tanggal Booking
                                    </span>
                                    <div class="card-section-value">
                                        {{ \Carbon\Carbon::parse($history->booking_date)->locale('id')->translatedFormat('d F Y') }}
                                    </div>
                                    <div class="card-section-subtext">
                                        Jam {{ \Carbon\Carbon::parse($history->booking_date)->format('H:i') }} WIB
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL UNTUK STATUS CANCELLED --}}
                        @if ($history->status == 'cancelled')
                            <div class="modal fade" id="reasonModal{{ $history->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-ban me-2"></i>Alasan Pembatalan
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="rejection-alert">
                                                <i class="fas fa-info-circle"></i>
                                                Pesan dari Admin
                                            </div>
                                            <div class="rejection-message">
                                                {{ $history->rejection_reason ?? 'Maaf, booking dibatalkan tanpa catatan khusus.' }}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn-modal-close" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>Tutup
                                            </button>
                                            <a href="{{ route('pelanggan.service') }}" class="btn-rebook">
                                                <i class="fas fa-redo me-1"></i>Booking Ulang
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
