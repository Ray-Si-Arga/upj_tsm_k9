@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        .card-history {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-header {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .vehicle-badge {
            background-color: #e9ecef;
            color: #495057;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-icon:hover {
            transform: translateY(-2px);
        }
    </style>

    <main class="py-4">
        <div class="container">
            {{-- Header Section --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Riwayat Service</h2>
                    <p class="text-muted mb-0">
                        Pelanggan: <span class="fw-bold text-primary">{{ $customerName ?? 'Nama Tidak Ditemukan' }}</span>
                    </p>
                </div>
                <a href="{{ route('customers.index') }}"
                    class="btn btn-light border text-secondary shadow-sm rounded-pill px-4 hover-shadow">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="card card-history">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-header">
                                <tr>
                                    <th class="py-3 px-4">Tanggal Booking</th>
                                    <th class="py-3 px-4">Kendaraan</th>
                                    <th class="py-3 px-4">Layanan</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        {{-- Tanggal --}}
                                        <td class="px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light p-2 rounded me-3 text-secondary">
                                                    <i class="far fa-calendar-alt"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">
                                                        {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('H:i') }}
                                                        WIB
                                                    </small>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Kendaraan --}}
                                        <td class="px-4">
                                            <div class="fw-semibold text-dark">{{ $booking->vehicle_type }}</div>
                                            <span class="vehicle-badge mt-1 d-inline-block">
                                                {{ strtoupper($booking->plate_number) }}
                                            </span>
                                        </td>

                                        {{-- Layanan --}}
                                        <td class="px-4">
                                            <span class="fw-medium text-secondary">{{ $booking->service->name }}</span>
                                        </td>

                                        {{-- Status --}}
                                        <td class="px-4 text-center">
                                            @php
                                                $statusClass = match ($booking->status) {
                                                    'pending' => 'bg-warning text-dark',
                                                    'approved' => 'bg-primary text-white',
                                                    'on_progress' => 'bg-info text-white',
                                                    'done' => 'bg-success text-white',
                                                    'cancelled' => 'bg-danger text-white',
                                                    default => 'bg-secondary text-white',
                                                };

                                                $statusLabel = match ($booking->status) {
                                                    'pending' => 'Menunggu',
                                                    'approved' => 'Diterima',
                                                    'on_progress' => 'Dikerjakan',
                                                    'done' => 'Selesai',
                                                    'cancelled' => 'Batal',
                                                    default => ucfirst($booking->status),
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 fw-normal">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-4 text-center">
                                            <a href="{{ route('booking.history.detail', [$booking->customer_whatsapp, $booking->id]) }}"
                                                class="btn btn-outline-primary btn-icon" title="Lihat Detail Transaksi">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-history fa-3x mb-3 text-secondary opacity-25"></i>
                                                <p class="mb-0 fs-5">Belum Ada Riwayat</p>
                                                <p class="small">Customer ini belum pernah melakukan service.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
