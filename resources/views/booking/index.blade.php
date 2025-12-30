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
            margin-bottom: 2rem;
        }

        .table-header-today {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .table-header-future {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .queue-badge {
            width: 40px;
            height: 40px;
            background-color: #e3f2fd;
            color: #0d6efd;
            border: 2px solid #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.1rem;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
        }

        .status-select {
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
            border: 1px solid #dee2e6;
            padding-left: 1rem;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .badge-time {
            background-color: #fff3cd;
            color: #856404;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
        }
    </style>

    <main class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Dashboard Antrian</h2>
                    <p class="text-muted mb-0">Kelola operasional servis kendaraan hari ini dan mendatang.</p>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- TABEL 1: BOOKING HARI INI (PRIORITAS)      --}}
            {{-- ========================================== --}}
            <h5 class="fw-bold text-primary mb-3"><i class="fas fa-clock me-2"></i>Antrian Hari Ini ({{ date('d M Y') }})
            </h5>

            <div class="card card-booking border-primary">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-header-today">
                                <tr>
                                    <th class="py-3 px-4 text-center" width="10%">No. Antrian</th>
                                    <th class="py-3 px-4">Pelanggan & Kendaraan</th>
                                    <th class="py-3 px-4">Jadwal & Estimasi</th>
                                    <th class="py-3 px-4 text-center">Status Pengerjaan</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($todayBookings as $booking)
                                    @include('booking.partials.row_content', [
                                        'booking' => $booking,
                                        'isToday' => true,
                                    ])
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 bg-light">
                                            <div class="text-muted">
                                                <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-50"></i>
                                                <p class="mb-0 fs-5">Tidak ada antrian hari ini.</p>
                                                <p class="small">Semua pekerjaan telah selesai atau belum ada booking
                                                    masuk.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- TABEL 2: BOOKING MENDATANG (BESOK DST)     --}}
            {{-- ========================================== --}}
            <h5 class="fw-bold text-secondary mb-3 mt-5"><i class="fas fa-calendar-alt me-2"></i>Jadwal Mendatang</h5>

            <div class="card card-booking">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-header-future">
                                <tr>
                                    <th class="py-3 px-4 text-center" width="10%">No</th>
                                    <th class="py-3 px-4">Pelanggan & Kendaraan</th>
                                    <th class="py-3 px-4">Waktu</th> {{-- Judul kolom saya ubah sedikit --}}
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Variabel untuk melacak tanggal terakhir --}}
                                @php $lastDate = null; @endphp

                                @forelse ($upcomingBookings as $booking)
                                    @php
                                        // Ambil tanggal saja (Y-m-d) untuk pengecekan
                                        $currentDate = \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d');
                                    @endphp

                                    {{-- LOGIKA PEMISAH: Jika tanggal baris ini beda dengan sebelumnya, buat Header --}}
                                    @if ($lastDate !== $currentDate)
                                        <tr class="table-light">
                                            <td colspan="5" class="px-4 py-2 fw-bold text-primary border-bottom">
                                                <i class="far fa-calendar-check me-2"></i>
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->translatedFormat('l, d F Y') }}
                                            </td>
                                        </tr>
                                        {{-- Update lastDate agar baris berikutnya dengan tanggal sama tidak memunculkan header lagi --}}
                                        @php $lastDate = $currentDate; @endphp
                                    @endif

                                    {{-- Include baris data (Partial yang sudah kita buat sebelumnya) --}}
                                    @include('booking.partials.row_content', [
                                        'booking' => $booking,
                                        'isToday' => false,
                                    ])

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <span class="text-muted fst-italic">Belum ada booking untuk hari-hari
                                                berikutnya.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                @if ($upcomingBookings->hasPages())
                    <div class="card-footer bg-white border-0 py-3">
                        <div class="d-flex justify-content-end">
                            {{ $upcomingBookings->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>
    <script>
        // ... (Script Notifikasi sama seperti sebelumnya) ...
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('success'))
                new Notify({
                    status: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                    effect: 'slide',
                    speed: 300,
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
                    autoclose: true,
                    autotimeout: 5000,
                    position: 'right top'
                });
            @endif
        });
    </script>
@endsection
