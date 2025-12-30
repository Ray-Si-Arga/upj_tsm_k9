@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Card Styles */
        .stat-card {
            border-radius: 1rem;
            border: none;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 1;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            bottom: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 60%);
            z-index: -1;
            transform: scale(0);
            transition: transform 0.6s ease-out;
        }

        .stat-card:hover::before {
            transform: scale(2);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            font-size: 3rem;
            opacity: 0.2;
            position: absolute;
            right: 1.5rem;
            bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.2) rotate(-10deg);
            opacity: 0.3;
        }

        /* Modern Button */
        .btn-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Table Styles */
        .modern-table-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .modern-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 1rem;
        }

        .modern-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .modern-table tr:last-child td {
            border-bottom: none;
        }

        .modern-table tr:hover {
            background-color: #f8fafc;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-enter {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }
    </style>

    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 animate-enter">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Dashboard Admin</h1>
                <p class="text-gray-500 mt-1">Overview sistem dan monitoring antrian booking</p>
            </div>

            <a href="{{ route('booking.walkin') }}" class="btn-modern bg-green-600 text-white hover:bg-green-700">
                <i class="fa-solid fa-user-plus"></i>
                <span>Booking Manual</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 animate-enter delay-100">
                <div class="relative z-10">
                    <p class="text-blue-100 text-sm font-medium uppercase tracking-wider mb-1">Total Booking Hari Ini</p>
                    <h2 class="text-4xl font-bold">{{ $totalBookingsToday ?? 0 }}</h2>
                    <p class="text-blue-100 text-sm mt-2 flex items-center gap-1">
                        <i class="fa-solid fa-calendar-day"></i> Data per hari ini
                    </p>
                </div>
                <i class="fa-solid fa-clipboard-list stat-icon"></i>
            </div>

            <div class="stat-card bg-gradient-to-br from-amber-500 to-orange-500 text-white p-6 animate-enter delay-200">
                <div class="relative z-10">
                    <p class="text-amber-100 text-sm font-medium uppercase tracking-wider mb-1">Booking Menunggu</p>
                    <h2 class="text-4xl font-bold">{{ $pendingBookings ?? 0 }}</h2>
                    <p class="text-amber-100 text-sm mt-2 flex items-center gap-1">
                        <i class="fa-solid fa-clock"></i> Perlu konfirmasi
                    </p>
                </div>
                <i class="fa-solid fa-hourglass-half stat-icon"></i>
            </div>

            <div class="stat-card bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-6 animate-enter delay-300">
                <div class="relative z-10">
                    <p class="text-emerald-100 text-sm font-medium uppercase tracking-wider mb-1">Customer Terdaftar</p>
                    <h2 class="text-4xl font-bold">{{ $registeredCustomers ?? 0 }}</h2>
                    <p class="text-emerald-100 text-sm mt-2 flex items-center gap-1">
                        <i class="fa-solid fa-users"></i> Total basis data
                    </p>
                </div>
                <i class="fa-solid fa-users-line stat-icon"></i>
            </div>
        </div>

        <div class="modern-table-container animate-enter delay-300">
            <div class="p-6 border-b border-gray-100 bg-white flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                        <i class="fa-solid fa-list-ol text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Antrian Booking Hari Ini</h3>
                </div>
                <a href="{{ route('booking.index') }}"
                    class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1 transition-colors">
                    Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left modern-table">
                    @if ($queueBookings->isEmpty())
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fa-regular fa-calendar-check text-5xl mb-3"></i>
                                        <p class="text-lg font-medium">Tidak ada antrian booking hari ini.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <thead>
                            <tr>
                                <th class="text-center w-24">No. Antrian</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Layanan</th>
                                <th class="text-center">Estimasi Selesai</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($queueBookings as $booking)
                                <tr>
                                    <td class="text-center">
                                        <span
                                            class="inline-block bg-gray-100 text-gray-800 font-bold px-3 py-1 rounded-lg text-lg border border-gray-200">
                                            {{ $booking->queue_number }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="font-bold text-gray-800">{{ $booking->customer_name }}</div>
                                        <div class="text-sm text-gray-500">
                                            <i class="fa-brands fa-whatsapp text-green-500 mr-1"></i>
                                            {{ $booking->customer_whatsapp }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-gray-800">{{ $booking->vehicle_type }}</div>
                                        <span
                                            class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded border border-gray-200 mt-1 uppercase">
                                            {{ $booking->plate_number }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-medium text-gray-700">{{ $booking->service->name }}</span>
                                    </td>

                                    {{-- Estimasi Selesai --}}
                                    {{-- Estimasi Selesai --}}
                                    <td class="text-center">
                                        @php
                                            // 1. Parse waktu booking dari database
                                            $waktuBooking = \Carbon\Carbon::parse($booking->booking_date);

                                            // 2. Ambil durasi. Jika kosong/null, pakai default 60 menit
                                            $durasi = $booking->estimation_duration ?? 60;

                                            // 3. Hitung waktu selesai (gunakan copy() agar variabel asli tidak berubah)
                                            $waktuSelesai = $waktuBooking->copy()->addMinutes($durasi);
                                        @endphp

                                        <div class="flex flex-col items-center">
                                            {{-- Tampilkan Jam Selesai --}}
                                            <span
                                                class="bg-blue-50 text-blue-700 text-sm font-semibold px-3 py-1 rounded-full border border-blue-100">
                                                <i class="fa-regular fa-clock mr-1"></i>
                                                {{ $waktuSelesai->format('H:i') }} WIB
                                            </span>

                                            {{-- Tampilkan Durasi di bawahnya (Opsional, agar admin tahu ini estimasi berapa lama) --}}
                                            <span class="text-xs text-gray-400 mt-1">
                                                (+{{ $durasi }} Menit)
                                            </span>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        @if ($booking->status == 'pending')
                                            <span
                                                class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full border border-amber-200">Menunggu</span>
                                        @elseif($booking->status == 'approved')
                                            <span
                                                class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full border border-blue-200">Diterima</span>
                                        @elseif($booking->status == 'on_progress')
                                            <span
                                                class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full border border-indigo-200">Dikerjakan</span>
                                        @elseif($booking->status == 'done')
                                            <span
                                                class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full border border-green-200">Selesai</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('booking.show', $booking->id) }}"
                                            class="text-gray-400 hover:text-blue-600 transition-colors p-2"
                                            title="Lihat Detail">
                                            <i class="fa-solid fa-eye text-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Notifikasi (Helper Function)
            function showNotify(status, title, text) {
                new Notify({
                    status: status,
                    title: title,
                    text: text,
                    effect: 'fade',
                    speed: 300,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 3000,
                    gap: 20,
                    distance: 20,
                    type: 1,
                    position: 'right top'
                });
            }

            @if (Session::has('success'))
                showNotify('success', 'Berhasil', '{{ Session::get('success') }}');
            @endif

            @if (Session::has('error'))
                showNotify('error', 'Gagal', '{{ Session::get('error') }}');
            @endif
        });
    </script>
@endsection
