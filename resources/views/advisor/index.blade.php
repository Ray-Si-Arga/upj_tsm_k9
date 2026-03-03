@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primary-dark: #1e293b;
            --primary-blue: #3b82f6;
            --success-green: #10b981;
            --danger-red: #ef4444;
            --bg-body: #f8fafc;
            --card-border: #e2e8f0;

            --navy: #0f172a;

        }

        body {
            background-color: var(--bg-body);
            color: var(--primary-dark);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* Hero Section - Clean Modern */
        .hero-section {
            background: linear-gradient(135deg, var(--navy) 0%, #16213e 50%, #0f172a 100%);
            border-radius: 20px;
            padding: 28px 34px;
            color: white;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(177, 0, 0, .25) 0%, transparent 70%);
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 25%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .03);
        }

        /* Stats Cards - Minimalist */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--card-border);
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-color: var(--primary-blue);
        }

        .stats-icon {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        /* Action & Info Cards */
        .action-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--card-border);
            margin-bottom: 1.5rem;
        }

        .info-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-left: 4px solid var(--primary-blue);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 2rem;
        }

        /* Buttons - Professional Flat */
        .btn-custom {
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
            border: none;
        }

        .btn-primary-custom {
            background-color: var(--primary-blue);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #2563eb;
            color: white;
        }

        .btn-success-custom {
            background-color: var(--success-green);
            color: white;
        }

        .btn-success-custom:hover {
            background-color: #059669;
            color: white;
        }

        /* Table Modernization */
        .table-container {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--card-border);
            overflow: hidden;
        }

        .table thead th {
            background-color: #f1f5f9;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            padding: 1rem;
            border: none;
        }

        .table tbody td {
            padding: 1.1rem 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge-status {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-service {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #d1fae5;
        }

        .btn-print {
            background-color: #f8fafc;
            border: 1px solid var(--card-border);
            color: var(--primary-dark);
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }

        .btn-print:hover {
            background-color: var(--primary-dark);
            color: white;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 1.5rem;
            }

            .stats-card {
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <div class="container py-5">
        {{-- Hero Section --}}
        <div class="hero-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="badge mb-3" style="
                                display: inline-flex;
                                align-items: center;
                                gap: 6px;
                                background: rgba(177, 0, 0, .35);
                                border: 1px solid rgba(177, 0, 0, .5);
                                color: #fca5a5;
                                font-size: .7rem;
                                font-weight: 800;
                                letter-spacing: 1.1px;
                                text-transform: uppercase;
                                padding: 4px 12px;
                                border-radius: 20px;
                                margin-bottom: 10px;">Admin Panel</span>

                    <h2 class="fw-bold mb-1">Service Advisor Dashboard</h2>
                    <p class="mb-0 text-white-50">Monitoring dan manajemen operasional bengkel secara real-time.</p>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <div class="text-white-50 small">Hari ini</div>
                    <div class="fw-bold fs-4">{{ date('d M Y') }}</div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon bg-primary text-white">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Total Akumulasi Service</div>
                        <div class="fs-4 fw-bold">{{ $histories->total() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon bg-success text-white">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Service Bulan Ini</div>
                        <div class="fs-4 fw-bold">{{ $histories->count() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon bg-danger text-white">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Service Hari Ini</div>
                        <div class="fs-4 fw-bold">-</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Section --}}
        <div class="action-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold mb-1">Manajemen Operasional</h5>
                    <p class="text-muted small mb-0">Klik tombol di samping untuk memproses pendaftaran servis.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('booking.walkin') }}" class="btn btn-custom border text-dark">
                        <i class="fas fa-user-plus me-2 text-muted"></i>Booking Walk-In
                    </a>
                    <a href="{{ route('advisor.create') }}" class="btn btn-custom btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>Service dari Booking
                    </a>
                </div>
            </div>
        </div>

        {{-- Info Box --}}
        <div class="info-box d-flex align-items-start gap-3">
            <i class="fas fa-circle-info mt-1 text-primary"></i>
            <p class="mb-0 small text-dark opacity-75">
                <strong>Informasi:</strong> Untuk pelanggan yang datang langsung (walk-in), pastikan untuk membuat entri
                booking terlebih dahulu melalui menu <strong>Booking Walk-In</strong> agar data tercatat dalam sistem
                antrean.
            </p>
        </div>

        {{-- Table Section --}}
        <div class="table-container shadow-sm">
            <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center bg-white">
                <h6 class="fw-bold mb-0">Riwayat Transaksi Terbaru</h6>
                <div class="dropdown">
                    <form action="{{ route('advisor.index') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Cari plat, nama, atau mekanik..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary-custom">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Jadwal & Waktu</th>
                            <th>Pelanggan & Kendaraan</th>
                            <th>Mekanik Bertugas</th>
                            <th>Pekerjaan</th>
                            <th class="text-end">Total Biaya</th>
                            <th class="text-center">Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $index => $data)
                                        <tr>
                                            <td class="text-center text-muted small">{{ $index + $histories->firstItem() }}</td>
                                            <td>
                                                <div class="fw-semibold text-dark">{{ $data->created_at->format('d M Y') }}</div>
                                                <div class="text-muted x-small" style="font-size: 0.75rem;">
                                                    <i class="far fa-clock me-1"></i>{{ $data->created_at->format('H:i') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-primary">{{ strtoupper($data->booking->plate_number ?? '-') }}
                                                </div>
                                                <div class="small text-muted">{{ $data->booking->customer_name ?? '-' }} • {{
                            $data->booking->vehicle_type ?? '-' }}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="small fw-medium">{{ $data->nama_mekanik ?? 'N/A' }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $jobs = $data->jobs;

                                                    if (is_array($jobs) && count($jobs) > 0) {
                                                        // Format BARU: JSON array [['name'=>'...','price'=>...], ...]
                                                        $jobLabel = implode(', ', array_column($jobs, 'name'));
                                                    } elseif (is_string($jobs) && $jobs !== '') {
                                                        // Format LAMA: string biasa (backward compatible)
                                                        $jobLabel = $jobs;
                                                    } else {
                                                        $jobLabel = 'General Service';
                                                    }
                                                @endphp
                                                <span class="badge-status badge-service">
                                                    {{ $jobLabel }}
                                                </span>
                                            </td>
                                            <td class="text-end fw-bold text-dark">
                                                Rp{{ number_format($data->total_estimation, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('advisor.print', $data->id) }}" class="btn btn-print btn-sm">
                                                    <i class="fas fa-file-pdf me-1 text-danger"></i> PDF
                                                </a>
                                            </td>
                                        </tr>
                                        @php
                                            if (is_array($jobs) && count($jobs) > 0) {
                                                // Format BARU: JSON array [['name'=>'...','price'=>...], ...]
                                                $jobLabel = implode(', ', array_column($jobs, 'name'));
                                            } elseif (is_string($jobs) && $jobs !== '') {
                                                // Format LAMA: string biasa (backward compatible)
                                                $jobLabel = $jobs;
                                            } else {
                                                $jobLabel = 'General Service';
                                            }
                                        @endphp
                                        <span class="badge-status badge-service">
                                            {{ $jobLabel }}
                                        </span>
                                        </td>
                                        <td class="text-end fw-bold text-dark">
                                            Rp{{ number_format($data->total_estimation, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('advisor.edit', $data->id) }}" class="btn btn-outline-primary btn-sm"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('advisor.print', $data->id) }}" class="btn btn-print btn-sm"
                                                    title="Cetak PDF">
                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                </a>
                                            </div>
                                        </td>
                                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center">
                                    <img src="https://illustrations.popsy.co/slate/empty-folder.svg" alt="empty"
                                        style="width: 120px;" class="mb-3">
                                    <h6 class="text-muted">Data transaksi tidak ditemukan</h6>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Modern --}}
            @if($histories->hasPages())
                <div class="px-4 py-3 bg-light border-top">
                    {{ $histories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection