@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 4px solid #667eea;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .action-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-success-custom {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(17, 153, 142, 0.4);
        }

        .table-modern {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .table-modern thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table-modern thead th {
            border: none;
            padding: 1.2rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .table-modern tbody tr:hover {
            background-color: #f8f9ff;
            transform: scale(1.01);
        }

        .table-modern tbody td {
            padding: 1.2rem 1rem;
            vertical-align: middle;
        }

        .badge-custom {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-success-custom {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .btn-print {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(240, 147, 251, 0.4);
            color: white;
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 5rem;
            color: #e0e0e0;
            margin-bottom: 1rem;
        }

        .info-box {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 5px solid #f5576c;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 1.5rem;
            }

            .stats-card {
                margin-bottom: 1rem;
            }

            .action-card {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="container py-4">
        {{-- Hero Section --}}
        <div class="hero-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold mb-2"><i class="fas fa-clipboard-list me-2"></i>Service Advisor Dashboard</h2>
                    <p class="mb-0 opacity-90">Kelola service kendaraan dan riwayat transaksi</p>
                </div>
                <div class="text-end">
                    <div class="fw-bold fs-5"><i class="far fa-calendar-alt me-2"></i>{{ date('d M Y') }}</div>
                    <small class="opacity-90">{{ date('l') }}</small>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $histories->total() }}</h3>
                    <p class="text-muted mb-0">Total Service</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card" style="border-left-color: #38ef7d;">
                    <div class="stats-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $histories->count() }}</h3>
                    <p class="text-muted mb-0">Service Bulan Ini</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card" style="border-left-color: #f5576c;">
                    <div class="stats-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="fw-bold mb-1">-</h3>
                    <p class="text-muted mb-0">Service Hari Ini</p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="action-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="fw-bold mb-2"><i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Service Baru</h5>
                    <p class="text-muted mb-md-0">Proses service untuk customer dengan atau tanpa booking</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('advisor.create') }}" class="btn btn-primary-custom w-100 w-md-auto mb-2">
                        <i class="fas fa-clipboard-check me-2"></i>Service dari Booking
                    </a>
                </div>
            </div>
        </div>

        {{-- Info Box untuk Walk-In Customer --}}
        <div class="info-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-2"></i>Customer Walk-In (Tanpa Booking)</h6>
                    <p class="mb-0 small">Jika customer datang tanpa booking, admin harus membuat booking walk-in terlebih dahulu di dashboard admin, kemudian proses service dapat dilakukan melalui tombol "Service dari Booking" di atas.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('booking.walkin') }}" class="btn btn-success-custom w-100 w-md-auto">
                        <i class="fas fa-user-plus me-2"></i>Buat Booking Walk-In
                    </a>
                </div>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Table Section --}}
        <div class="table-modern">
            <div class="p-4 border-bottom">
                <h5 class="fw-bold mb-0"><i class="fas fa-history me-2 text-primary"></i>Riwayat Service & Transaksi</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="12%">Tanggal</th>
                            <th width="20%">Info Kendaraan</th>
                            <th width="15%">Mekanik</th>
                            <th width="20%">Pekerjaan</th>
                            <th class="text-end" width="15%">Total Biaya</th>
                            <th class="text-center" width="13%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $index => $data)
                            <tr>
                                <td class="text-center fw-bold text-muted">
                                    {{ $index + $histories->firstItem() }}
                                </td>

                                <td>
                                    <div class="fw-bold">{{ $data->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>{{ $data->created_at->format('H:i') }} WIB
                                    </small>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark">{{ strtoupper($data->booking->plate_number ?? '-') }}</div>
                                    <small class="text-muted">
                                        <i class="fas fa-motorcycle me-1"></i>{{ $data->booking->vehicle_type ?? '-' }}
                                    </small><br>
                                    <small class="text-primary">
                                        <i class="fas fa-user me-1"></i>{{ $data->booking->customer_name ?? '-' }}
                                    </small>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="fas fa-user-tie text-primary"></i>
                                        </div>
                                        <span class="fw-bold">{{ $data->nama_mekanik ?? '-' }}</span>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge badge-custom badge-success-custom">
                                        {{ $data->jobs ?? '-' }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <div class="fw-bold text-success fs-6">
                                        Rp {{ number_format($data->total_estimation, 0, ',', '.') }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('advisor.print', $data->id) }}" 
                                       class="btn btn-print btn-sm"
                                       title="Cetak Invoice">
                                        <i class="fas fa-print me-1"></i>Cetak
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5 class="text-muted mt-3 mb-2">Belum Ada Riwayat Service</h5>
                                        <p class="text-muted small">Mulai tambahkan service baru untuk melihat riwayat di sini</p>
                                        <a href="{{ route('advisor.create') }}" class="btn btn-primary-custom mt-3">
                                            <i class="fas fa-plus me-2"></i>Tambah Service
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($histories->hasPages())
                <div class="p-4 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan {{ $histories->firstItem() }} - {{ $histories->lastItem() }} dari {{ $histories->total() }} data
                        </div>
                        <div>
                            {{ $histories->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection