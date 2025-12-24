@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">

    <style>
        .card-booking {
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

        .table-hover tbody tr:hover {
            background-color: #f1f4f9;
            transition: background-color 0.2s ease;
        }

        .status-select {
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
            border: 1px solid #dee2e6;
            padding-left: 1rem;
        }

        .btn-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-icon:hover {
            transform: scale(1.1);
        }

        .badge-time {
            background-color: #e3f2fd;
            color: #0d6efd;
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
        }
    </style>

    <main class="py-4">
        <div class="container">
            {{-- Header Section --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Daftar Booking</h2>
                    <p class="text-muted mb-0">Kelola antrian dan status pengerjaan kendaraan.</p>
                </div>
                {{-- Jika ingin tombol tambah booking di sini --}}
                {{-- <a href="{{ route('booking.create') }}" class="btn btn-primary rounded-pill px-4"><i class="fas fa-plus me-2"></i>Booking Baru</a> --}}
            </div>

            {{-- Card Table --}}
            <div class="card card-booking">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-header">
                                <tr>
                                    <th class="py-3 px-4">No Antrian</th>
                                    <th class="py-3 px-4">Pelanggan</th>
                                    <th class="py-3 px-4">Kendaraan</th>
                                    <th class="py-3 px-4">Jadwal & Estimasi</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $booking)
                                    @php
                                        $bookingTime = \Carbon\Carbon::parse($booking->booking_date);

                                        // 1. Waktu Mulai (Sudah diperbaiki, tanpa tambah 15 menit hardcode)
                                        // $startTime = $bookingTime;
                                        $startTime = $bookingTime->copy()->addMinutes(15);


                                        // 2. Ambil durasi (Default 60 menit jika kosong)
                                        $duration = $booking->estimation_duration ?? 60;

                                        // 3. Hitung Waktu Selesai
                                        $endTime = $bookingTime->copy()->addMinutes($duration);

                                        $isOver = now()->greaterThan($endTime) && $booking->status == 'on_progress';
                                    @endphp
                                    <tr>
                                        <td class="px-4">
                                            <div class="fw-bold text-dark">{{ $booking->customer_name }}</div>
                                            <small class="text-muted">
                                                <i class="fab fa-whatsapp text-success me-1"></i>
                                                {{ $booking->customer_whatsapp }}
                                            </small>
                                        </td>
                                        <td class="px-4">
                                            <div class="text-dark fw-semibold">{{ $booking->vehicle_type }}</div>
                                            <span class="badge bg-light text-secondary border border-secondary mt-1">
                                                {{ strtoupper($booking->plate_number) }}
                                            </span>
                                        </td>
                                        <td class="px-4">
                                            <div class="d-flex flex-column gap-1">
                                                <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i>
                                                    {{ $bookingTime->format('d M Y') }}</span>
                                                <span class="badge-time">
                                                    <i class="far fa-clock me-1"></i> {{ $startTime->format('H:i') }} -
                                                    {{ $endTime->format('H:i') }} WIB
                                                </span>
                                                @if ($isOver)
                                                    <span class="badge bg-danger text-white mt-1">
                                                        <i class="fas fa-exclamation-circle me-1"></i> Lewat Estimasi
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 text-center">
                                            <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST">
                                                @csrf
                                                @php
                                                    $statusColor = match ($booking->status) {
                                                        'pending' => 'border-warning text-warning',
                                                        'approved' => 'border-primary text-primary',
                                                        'on_progress' => 'border-info text-info',
                                                        'done' => 'border-success text-success',
                                                        'cancelled' => 'border-danger text-danger',
                                                        default => 'border-secondary text-secondary',
                                                    };
                                                @endphp
                                                <select name="status"
                                                    class="form-select form-select-sm status-select {{ $statusColor }}"
                                                    onchange="this.form.submit()" style="min-width: 140px;">
                                                    <option value="pending"
                                                        {{ $booking->status == 'pending' ? 'selected' : '' }}>⏳ Menunggu
                                                    </option>
                                                    <option value="approved"
                                                        {{ $booking->status == 'approved' ? 'selected' : '' }}>✅ Diterima
                                                    </option>
                                                    <option value="on_progress"
                                                        {{ $booking->status == 'on_progress' ? 'selected' : '' }}>🔧
                                                        Dikerjakan</option>
                                                    <option value="done"
                                                        {{ $booking->status == 'done' ? 'selected' : '' }}>🏁 Selesai
                                                    </option>
                                                    <option value="cancelled"
                                                        {{ $booking->status == 'cancelled' ? 'selected' : '' }}>❌
                                                        Dibatalkan</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-4 text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- Tombol Detail --}}
                                                <a href="{{ route('booking.show', $booking->id) }}"
                                                    class="btn btn-outline-primary btn-icon btn-sm" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('booking.destroy', $booking->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-icon btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus data booking ini?')"
                                                        title="Hapus Data">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-clipboard-list fa-3x mb-3 text-secondary opacity-50"></i>
                                                <p class="mb-0 fs-5">Belum ada data booking.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination Footer --}}
                @if ($bookings->hasPages())
                    <div class="card-footer bg-white border-0 py-3">
                        <div class="d-flex justify-content-end">
                            {{ $bookings->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>

    {{-- Script Notifikasi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('success'))
                new Notify({
                    status: 'info',
                    title: 'Info',
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
