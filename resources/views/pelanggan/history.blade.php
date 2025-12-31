@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1">Riwayat Servis</h3>
                    <p class="text-muted mb-0">Daftar kendaraan yang telah selesai diservis.</p>
                </div>
                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>

            {{-- Tabel Riwayat --}}
            @if ($historyBookings->isEmpty())
                <div class="alert alert-light text-center p-5 border-0 shadow-sm rounded-4">
                    <i class="fas fa-history fa-3x mb-3 text-secondary opacity-25"></i>
                    <h5>Belum ada riwayat</h5>
                    <p class="text-muted">Anda belum memiliki transaksi servis yang selesai.</p>
                </div>
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
                                        <th class="py-3 px-4">Keluhan</th>
                                        <th class="py-3 px-4 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historyBookings as $history)
                                        <tr>
                                            {{-- KOLOM 1: TANGGAL --}}
                                            <td class="px-4">
                                                <div class="fw-bold text-dark">
                                                    {{ \Carbon\Carbon::parse($history->booking_date)->locale('id')->translatedFormat('d F Y') }}
                                                </div>
                                                <small class="text-muted">
                                                    Jam {{ \Carbon\Carbon::parse($history->booking_date)->format('H:i') }}
                                                    WIB
                                                </small>
                                            </td>

                                            {{-- KOLOM 2: KENDARAAN --}}
                                            <td class="px-4">
                                                <div class="fw-semibold">{{ $history->vehicle_type }}</div>
                                                <small class="text-muted">{{ strtoupper($history->plate_number) }}</small>
                                            </td>

                                            {{-- KOLOM 3: LAYANAN --}}
                                            <td class="px-4">
                                                @foreach ($history->services as $svc)
                                                    <span class="badge bg-secondary mb-1">{{ $svc->name }}</span><br>
                                                @endforeach
                                            </td>

                                            {{-- KOLOM 4: KOMPLAIN --}}
                                            <td class="px-4">
                                                <div class="text-danger fw-semibold">{{ $history->complaint }}</div>
                                            </td>

                                            {{-- KOLOM 5: STATUS (Tombol) --}}
                                            <td class="px-4 text-center">
                                                @if ($history->status == 'done')
                                                    <span class="status-badge-done"><i class="fas fa-check-circle me-1"></i>
                                                        Selesai</span>
                                                @elseif($history->status == 'cancelled')
                                                    {{-- Tombol Merah --}}
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger rounded-pill px-3 fw-bold"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#reasonModal{{ $history->id }}">
                                                        <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                                    </button>

                                                    {{-- MODAL ALASAN --}}
                                                    <div class="modal fade" id="reasonModal{{ $history->id }}"
                                                        tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content text-start">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h6 class="modal-title fw-bold">Alasan Pembatalan</h6>
                                                                    <button type="button" class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div
                                                                        class="alert alert-light border-danger text-danger">
                                                                        <i class="fas fa-info-circle me-2"></i>
                                                                        <strong>Pesan dari Admin:</strong>
                                                                    </div>
                                                                    <p class="mb-0 fs-5 text-dark">
                                                                        "{{ $history->rejection_reason ?? 'Maaf, booking dibatalkan tanpa catatan khusus.' }}"
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                    <a href="{{ route('pelanggan.service') }}"
                                                                        class="btn btn-primary btn-sm">Booking Ulang</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
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
