@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        .card-customer {
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

        .avatar-initial {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
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
                    <h2 class="fw-bold text-dark mb-1">Daftar Customer</h2>
                    <p class="text-muted mb-0">Kelola data pelanggan dan riwayat servis mereka.</p>
                </div>
            </div>

            @if ($customers->isEmpty())
                <div class="card card-customer text-center py-5">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-users-slash fa-4x text-muted opacity-25"></i>
                        </div>
                        <h5 class="text-muted">Belum ada customer terdaftar</h5>
                        <p class="text-secondary">Data customer akan muncul setelah mereka melakukan registrasi.</p>
                    </div>
                </div>
            @else
                <div class="card card-customer">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-header">
                                    <tr>
                                        <th class="py-3 px-4 text-center" width="5%">#</th>
                                        <th class="py-3 px-4">Nama Customer</th>
                                        <th class="py-3 px-4">Kontak</th>
                                        <th class="py-3 px-4 text-center">Total Booking</th>
                                        <th class="py-3 px-4 text-center" width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $index => $customer)
                                        <tr>
                                            <td class="text-center text-muted">{{ $index + 1 }}</td>

                                            {{-- Kolom Nama --}}
                                            <td class="px-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar-initial">
                                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $customer->name }}</div>
                                                        <small class="text-muted" style="font-size: 0.75rem;">Joined:
                                                            {{ $customer->created_at->format('d M Y') }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Kolom Kontak --}}
                                            <td class="px-4">
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="text-dark small">
                                                        <i
                                                            class="far fa-envelope text-secondary me-2"></i>{{ $customer->email }}
                                                    </div>

                                                    @if ($customer->bookings->isNotEmpty())
                                                        @php
                                                            $whatsappNumber = $customer->bookings->first()
                                                                ->customer_whatsapp;
                                                        @endphp
                                                        <div class="text-dark small">
                                                            <i
                                                                class="fab fa-whatsapp text-success me-2 fs-6"></i>{{ $whatsappNumber }}
                                                        </div>
                                                    @else
                                                        <div class="text-muted small fst-italic ps-4">
                                                            Belum ada WA
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- Kolom Total Booking --}}
                                            <td class="text-center">
                                                <span
                                                    class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                                    {{ $customer->bookings->count() }} Transaksi
                                                </span>
                                            </td>

                                            {{-- Kolom Aksi --}}
                                            <td class="text-center px-4">
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if ($customer->bookings->isNotEmpty())
                                                        {{-- Tombol Riwayat --}}
                                                        <a href="{{ route('customers.bookings', ['email' => $customer->email, 'whatsapp' => $whatsappNumber ?? 'N/A']) }}"
                                                            class="btn btn-outline-info btn-icon"
                                                            title="Lihat Riwayat Servis">
                                                            <i class="fas fa-history"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn btn-outline-secondary btn-icon" disabled
                                                            title="Belum ada riwayat">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    @endif

                                                    {{-- Tombol Hapus --}}
                                                    {{-- Perbaikan: Menggunakan Link (GET) sesuai route di web.php --}}
                                                    <a href="{{ route('hapus', $customer->id) }}"
                                                        class="btn btn-outline-danger btn-icon"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data customer ini? Data yang dihapus tidak dapat dikembalikan.')"
                                                        title="Hapus Customer">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
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
