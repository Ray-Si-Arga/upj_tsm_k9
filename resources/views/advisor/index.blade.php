@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
@endpush

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
        /* Tambahkan variabel Honda agar konsisten */
        --honda-red:       #B10000;
        --honda-red-dark:  #8B0000;
        --navy:            #0f172a;
        --navy-mid:        #1e293b;
        --bg-body:         #f0f2f5;
        --card-border:     #e2e8f0;
        --text:            #1e293b;
    }

    body {
        background-color: var(--bg-body);
        color: var(--text);
        font-family: 'DM Sans', 'Inter', system-ui, sans-serif;
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

        /* Stats Cards - Mengikuti konsep Dashboard */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }
    @media(max-width:768px) { .stats-grid { grid-template-columns: 1fr; } }

    .stats-card {
        border-radius: 16px; 
        padding: 22px;
        color: #fff; 
        position: relative; 
        overflow: hidden;
        transition: transform .22s, box-shadow .22s;
        border: none;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .stats-card:hover { transform: translateY(-4px); }
    
    /* Dekorasi Lingkaran */
    .stats-card::before {
        content:''; position:absolute; top:-40px; right:-40px;
        width:140px; height:140px; border-radius:50%;
        background:rgba(255,255,255,.07);
    }

    /* Warna Gradasi */
    .bg-navy-grad  { background: linear-gradient(140deg, #0f172a 0%, #1e293b 100%); box-shadow: 0 6px 20px rgba(15,23,42,.2); }
    .bg-green-grad { background: linear-gradient(140deg, #064e3b 0%, #047857 100%); box-shadow: 0 6px 20px rgba(6,78,59,.2); }
    .bg-red-grad   { background: linear-gradient(140deg, #4c0519 0%, #B10000 100%); box-shadow: 0 6px 20px rgba(177,0,0,.25); }

    .stats-icon-new { 
        width: 40px; height: 40px; border-radius: 10px; 
        background: rgba(255,255,255,.15); 
        display: flex; align-items: center; justify-content: center; 
        font-size: 1.1rem; margin-bottom: 12px;
    }
    .stats-label { font-size: .7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.1px; color: rgba(255,255,255,.6); margin-bottom: 4px; }
    .stats-value { font-size: 1.75rem; font-weight: 800; color: #fff; letter-spacing: -1px; line-height: 1; }

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
        .action-card {
    background: #fff;
    padding: 24px;
    border-radius: 16px;
    border: 1px solid var(--card-border);
    margin-bottom: 20px;
}
.btn-action-honda {
    background: var(--honda-red);
    color: white !important;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 700;
    transition: all 0.2s;
    border: none;
    box-shadow: 0 4px 12px rgba(177, 0, 0, 0.2);
}
.btn-action-honda:hover {
    background: var(--honda-red-dark);
    transform: translateY(-2px);
}
.btn-action-outline {
    background: white;
    color: var(--navy) !important;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 700;
    border: 1.5px solid var(--card-border);
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
                                margin-bottom: 10px;">Advisor</span>

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
<div class="stats-grid">
    <div class="stats-card bg-navy-grad">
        <div class="stats-icon-new">
            <i class="fas fa-layer-group"></i>
        </div>
        <div>
            <div class="stats-label">Total Akumulasi Service</div>
            <div class="stats-value">{{ $histories->total() }}</div>
        </div>
    </div>

    <div class="stats-card bg-green-grad">
        <div class="stats-icon-new">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div>
            <div class="stats-label">Service Bulan Ini</div>
            <div class="stats-value">{{ $histories->count() }}</div>
        </div>
    </div>

    <div class="stats-card bg-red-grad">
        <div class="stats-icon-new">
            <i class="fas fa-wrench"></i>
        </div>
        <div>
            <div class="stats-label">Service Hari Ini</div>
            <div class="stats-value">-</div>
        </div>
    </div>
</div>
        {{-- Action Section --}}
        <div class="action-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h5 class="fw-bold mb-1" style="color: var(--navy);">Manajemen Operasional</h5>
            <p class="text-muted small mb-0">Proses pendaftaran servis atau kelola antrean pelanggan.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('booking.walkin') }}" class="btn-action-outline text-decoration-none">
                <i class="fas fa-user-plus me-2"></i> Booking Walk-In
            </a>
            <a href="{{ route('advisor.create') }}" class="btn-action-honda text-decoration-none">
                <i class="fas fa-wrench me-2"></i> Service dari Booking
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

        @livewire('advisor-table')

            {{-- Pagination Modern --}}
            @if($histories->hasPages())
                <div class="px-4 py-3 bg-light border-top">
                    {{ $histories->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
<script>
    (function () {
        const input = document.getElementById('realtimeSearch');
        if (!input) return;

        let debounceTimer;

        input.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                const keyword = input.value.trim();
                const url = new URL(window.location.href);

                if (keyword !== '') {
                    url.searchParams.set('search', keyword);
                } else {
                    url.searchParams.delete('search');
                }
                url.searchParams.delete('page'); // reset ke halaman 1

                window.location.href = url.toString();
            }, 450); // delay 450ms setelah berhenti mengetik
        });

        // Auto-focus ke akhir text jika sudah ada value
        if (input.value) {
            const len = input.value.length;
            input.setSelectionRange(len, len);
            input.focus();
        }
    })();
</script>
@endpush

<script>
    (function () {
        const input = document.getElementById('realtimeSearch');
        if (!input) return;

        let debounceTimer;

        input.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                const keyword = input.value.trim();
                const url = new URL(window.location.href);

                if (keyword !== '') {
                    url.searchParams.set('search', keyword);
                } else {
                    url.searchParams.delete('search');
                }
                url.searchParams.delete('page');
                window.location.href = url.toString();
            }, 450);
        });

        if (input.value) {
            const len = input.value.length;
            input.setSelectionRange(len, len);
            input.focus();
        }
    })();
</script>
@endsection