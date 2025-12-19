@extends('Layouts.app')

@section('content')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .stat-card {
            border-radius: 16px;
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1);
            opacity: 1;
        }

        .queue-item {
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .queue-item:hover {
            background: rgba(177, 0, 0, 0.03);
            transform: translateX(5px);
        }

        .queue-item:last-child {
            border-bottom: none;
        }

        .queue-number {
            background: linear-gradient(135deg, #B10000 0%, #8B0000 100%);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(177, 0, 0, 0.3);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: capitalize;
        }

        .btn-modern {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .card-modern {
            border-radius: 16px;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .dashboard-header h1 {
            background: linear-gradient(135deg, #B10000 0%, #8B0000 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
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

    {{-- Notifikasi menggunakan library --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('success'))
                new Notify({
                    status: 'success',
                    title: 'Berhasil',
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

    <body>
        <!-- Main Content -->
        <main class="dashboard-container">
            {{-- <div class="max-w-7xl mx-auto"> --}}
            <!-- Header -->
            <div class="dashboard-header mb-8 animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-bold mb-2">Dashboard Admin</h1>
                <p class="text-lg text-gray-600">Overview sistem dan monitoring booking</p>
            </div>
            
            {{-- booking guest --}}
            <a href="{{ route('booking.walkin') }}" class="btn btn-success">
                <i class="bi bi-person-plus"></i> Tambah Booking Manual
            </a>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Booking Hari Ini -->
                <div class="stat-card bg-gradient-to-r from-green-500 to-emerald-600 text-white animate-fade-in-up">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-semibold opacity-90 mb-2 uppercase tracking-wide">Total Booking
                                    Hari
                                    Ini</p>
                                <h2 class="text-3xl font-bold mb-1">{{ $totalBookingsToday ?? 0 }}</h2>
                                <p class="text-sm opacity-75">Booking hari ini</p>
                            </div>
                            <i class="fas fa-calendar-check stat-icon"></i>
                        </div>
                    </div>
                </div>

                <!-- Booking Menunggu -->
                <div
                    class="stat-card bg-gradient-to-r from-amber-400 to-orange-500 text-white animate-fade-in-up delay-100">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-semibold opacity-90 mb-2 uppercase tracking-wide">Booking
                                    Menunggu
                                </p>
                                <h2 class="text-3xl font-bold mb-1">{{ $pendingBookings ?? 0 }}</h2>
                                <p class="text-sm opacity-75">Perlu konfirmasi</p>
                            </div>
                            <i class="fas fa-hourglass-half stat-icon"></i>
                        </div>
                    </div>
                </div>

                <!-- Customer Terdaftar -->
                <div class="stat-card bg-gradient-to-r from-blue-500 to-cyan-600 text-white animate-fade-in-up delay-200">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-semibold opacity-90 mb-2 uppercase tracking-wide">Customer
                                    Terdaftar
                                </p>
                                <h2 class="text-3xl font-bold mb-1">{{ $registeredCustomers ?? 0 }}</h2>
                                <p class="text-sm opacity-75">Total customer</p>
                            </div>
                            <i class="fas fa-users stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Queue Section -->
            <div class="card-modern animate-fade-in-up delay-300">
                <div class="bg-gradient-to-r from-blue-600 to-rose-700 text-white rounded-t-2xl p-6">
                    <div class="flex justify-between items-center">
                        <h5 class="text-xl font-bold mb-0">
                            <i class="fas fa-list-ol mr-3"></i>Antrian Booking Hari Ini
                        </h5>
                        <a href="{{ route('booking.index') }}" class="btn-modern bg-white text-blue-600 hover:bg-gray-100">
                            Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <div class="p-0">
                    @if ($queueBookings->isEmpty())
                        <div class="text-center py-12">
                            <i class="fas fa-check-circle text-5xl text-green-500 mb-4"></i>
                            <p class="text-gray-500 text-lg mb-0">Tidak ada antrian booking hari ini</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-100">
                            @foreach ($queueBookings as $booking)
                                <div class="queue-item p-6">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                                        <div class="flex items-center mb-4 md:mb-0">
                                            <div class="queue-number mr-4">
                                                #{{ $booking->queue_number }}
                                            </div>
                                            <div>
                                                <h6 class="font-bold text-gray-800 text-lg mb-1">
                                                    {{ $booking->customer_name }}</h6>
                                                <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                                                    <span class="flex items-center">
                                                        <i class="fas fa-motorcycle mr-2"></i>
                                                        {{ $booking->license_plate }}
                                                    </span>
                                                    <span class="flex items-center">
                                                        <i class="fas fa-wrench mr-2"></i>
                                                        {{ $booking->service->name ?? 'Layanan Tidak Dikenal' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            @php
                                                $statusConfig = [
                                                    'pending' => [
                                                        'class' => 'bg-amber-100 text-amber-800',
                                                        'icon' => 'fa-clock',
                                                    ],
                                                    'approved' => [
                                                        'class' => 'bg-blue-100 text-blue-800',
                                                        'icon' => 'fa-check',
                                                    ],
                                                    'on_progress' => [
                                                        'class' => 'bg-purple-100 text-purple-800',
                                                        'icon' => 'fa-spinner',
                                                    ],
                                                    'done' => [
                                                        'class' => 'bg-green-100 text-green-800',
                                                        'icon' => 'fa-check-double',
                                                    ],
                                                    'cancelled' => [
                                                        'class' => 'bg-red-100 text-red-800',
                                                        'icon' => 'fa-times',
                                                    ],
                                                ];
                                                $statusInfo = $statusConfig[strtolower($booking->status)] ?? [
                                                    'class' => 'bg-gray-100 text-gray-800',
                                                    'icon' => 'fa-question',
                                                ];
                                            @endphp
                                            <span class="status-badge {{ $statusInfo['class'] }} flex items-center gap-2">
                                                <i class="fas {{ $statusInfo['icon'] }}"></i>
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                            <a href="{{ route('booking.show', $booking->id) }}"
                                                class="btn-modern bg-gradient-to-r from-blue-500 to-cyan-600 text-white hover:from-blue-600 hover:to-cyan-700">
                                                Detail <i class="fas fa-chevron-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="card-modern p-6 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-plus text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Tambah Booking</h4>
                    <p class="text-gray-600 text-sm mb-4">Buat booking baru untuk customer</p>
                    <a href="{{ route('booking.create') }}"
                        class="btn-modern bg-blue-600 text-white hover:bg-blue-700 w-full">
                        Buat Booking
                    </a>
                </div>

                <div class="card-modern p-6 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-green-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Tambah Customer</h4>
                    <p class="text-gray-600 text-sm mb-4">Registrasi customer baru</p>
                    <a href="{{ route('customers.create') }}"
                        class="btn-modern bg-green-600 text-white hover:bg-green-700 w-full">
                        Tambah Customer
                    </a>
                </div>

                <div class="card-modern p-6 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-bar text-purple-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Laporan</h4>
                    <p class="text-gray-600 text-sm mb-4">Lihat laporan dan statistik</p>
                    <a href="#" class="btn-modern bg-purple-600 text-white hover:bg-purple-700 w-full">
                        Lihat Laporan
                    </a>
                </div>
            </div>
        </div> --}}
        </main>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>

    <script>
        // Tambahan JavaScript untuk interaksi
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi scroll reveal
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe semua elemen dengan animasi
            document.querySelectorAll('.stat-card, .card-modern').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'all 0.6s ease-out';
                observer.observe(el);
            });
        });
    </script>
@endsection
