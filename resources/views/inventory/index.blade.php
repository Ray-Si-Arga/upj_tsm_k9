@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
@endpush

@section('content')
    @php
        $totalItem = $Inventory->count();
        $totalStok = $Inventory->sum('jumlah_barang');
        $nilaiModal = $Inventory->sum(fn($i) => $i->harga_beli * $i->jumlah_barang);
        $nilaiJual = $Inventory->sum(fn($i) => $i->harga_jual * $i->jumlah_barang);
        $potensiLaba = $nilaiJual - $nilaiModal;
        $stokMenipis = $Inventory->where('jumlah_barang', '<=', 6)->count();
    @endphp

    <style>
        /* ==============================
                           ROOT & BASE
                        ============================== */
        :root {
            --honda-red: #B10000;
            --honda-red-dark: #8B0000;
            --honda-red-soft: rgba(177, 0, 0, 0.08);
            --emerald: #064e3b;
            --emerald-mid: #047857;
            --navy: #0f172a;
            --navy-mid: #1e293b;
            --amber: #78350f;
            --amber-mid: #92400e;
            --bg: #f4f6f9;
            --border: #e2e8f0;
            --text: #1e293b;
        }

        body {
            background: var(--bg);
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--text);
        }

        .inv-wrap {
            padding: 28px 0;
        }

        /* ==============================
                           PAGE HEADER
                        ============================== */
        .page-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
        }

        .page-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text);
            margin: 0 0 4px;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            font-size: 0.83rem;
            color: #64748b;
            margin: 0;
            font-weight: 500;
        }

        /* ==============================
                           SUMMARY CARDS
                        ============================== */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        .summary-card {
            border-radius: 18px;
            padding: 22px 24px;
            color: #fff;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(0, 0, 0, 0.13);
        }

        /* Card colours */
        .card-item {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
            box-shadow: 0 6px 24px rgba(15, 23, 42, .28);
        }

        .card-stok {
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-mid) 100%);
            box-shadow: 0 6px 24px rgba(6, 78, 59, .28);
        }

        .card-modal {
            background: linear-gradient(135deg, #881337 0%, var(--honda-red) 100%);
            box-shadow: 0 6px 24px rgba(136, 19, 55, .28);
        }

        .card-laba {
            background: linear-gradient(135deg, var(--amber) 0%, var(--amber-mid) 100%);
            box-shadow: 0 6px 24px rgba(120, 53, 15, .28);
        }

        .card-tipis {
            background: linear-gradient(135deg, #4c0519 0%, #881337 100%);
            box-shadow: 0 6px 24px rgba(76, 5, 25, .28);
        }

        /* Decorative circle */
        .summary-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .summary-card::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -20px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
        }

        .card-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.14);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            color: #fff;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(4px);
        }

        .card-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, .58);
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }

        .card-amount {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
        }

        .card-amount.sm {
            font-size: 1.25rem;
        }

        .card-meta {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, .5);
            margin-top: 7px;
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        .card-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(255, 255, 255, .14);
            color: rgba(255, 255, 255, .85);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            margin-top: 10px;
            position: relative;
            z-index: 1;
        }

        /* ==============================
                           SEARCH + FILTER BAR
                        ============================== */
        .toolbar {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 16px 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, .04);
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 360px;
        }

        .search-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .search-wrap input {
            width: 100%;
            padding: 9px 14px 9px 38px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.88rem;
            color: var(--text);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .search-wrap input:focus {
            border-color: var(--honda-red);
            box-shadow: 0 0 0 3px rgba(177, 0, 0, .1);
        }

        .filter-tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid var(--border);
            background: #fff;
            color: #64748b;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
        }

        .filter-tab:hover,
        .filter-tab.active {
            background: var(--honda-red);
            color: #fff;
            border-color: var(--honda-red);
        }

        .filter-tab.active-warn {
            background: #fef3c7;
            color: #92400e;
            border-color: #fcd34d;
        }

        /* ==============================
                           TABLE CARD
                        ============================== */
        .table-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
        }

        .table-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 10px;
        }

        .table-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .item-count {
            font-size: 0.72rem;
            background: #f1f5f9;
            color: #64748b;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Scrollable table */
        .table-scroll {
            overflow-x: auto;
        }

        /* Table itself */
        .inv-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inv-table thead th {
            padding: 12px 20px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #94a3b8;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .inv-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background .15s;
        }

        .inv-table tbody tr:last-child {
            border-bottom: none;
        }

        .inv-table tbody tr:hover {
            background: #fafafa;
        }

        .inv-table tbody td {
            padding: 15px 20px;
            font-size: 0.875rem;
            vertical-align: middle;
        }

        /* Row number */
        .row-num {
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.8rem;
            text-align: center;
        }

        /* Item name */
        .item-name {
            font-weight: 700;
            color: var(--text);
        }

        /* Stock badge */
        .stok-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .stok-ok {
            background: #d1fae5;
            color: #065f46;
        }

        .stok-tipis {
            background: #ffe4e6;
            color: #9f1239;
        }

        .stok-warn {
            background: #fef3c7;
            color: #92400e;
        }

        /* Price */
        .price-cell {
            white-space: nowrap;
        }

        .price-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 3px;
        }

        .price-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #94a3b8;
            min-width: 28px;
        }

        .price-val {
            font-family: 'Consolas', monospace;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 3px 8px;
            border-radius: 6px;
        }

        .price-beli {
            background: #fef2f2;
            color: #b91c1c;
        }

        .price-jual {
            background: #f0fdf4;
            color: #15803d;
        }

        /* Laba cell */
        .laba-per {
            font-family: 'Consolas', monospace;
            font-weight: 700;
            color: #1d4ed8;
            font-size: 0.85rem;
        }

        .laba-total {
            font-size: 0.72rem;
            color: #64748b;
            font-weight: 600;
            margin-top: 2px;
        }

        /* Action buttons */
        .btn-act {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: all .18s;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .btn-act:hover {
            transform: translateY(-2px);
        }

        .btn-edit {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .btn-edit:hover {
            background: #2563eb;
            color: #fff;
        }

        .btn-hapus {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .btn-hapus:hover {
            background: #dc2626;
            color: #fff;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 3rem;
            color: #e2e8f0;
            margin-bottom: 14px;
            display: block;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* ==============================
                           MOBILE CARDS
                        ============================== */
        .mobile-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 18px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
        }

        .mobile-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        /* ==============================
                           ANIMATIONS
                        ============================== */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .au {
            animation: fadeUp .4s ease both;
        }

        .d1 {
            animation-delay: .05s;
        }

        .d2 {
            animation-delay: .10s;
        }

        .d3 {
            animation-delay: .15s;
        }

        .d4 {
            animation-delay: .20s;
        }

        .d5 {
            animation-delay: .25s;
        }

        .d6 {
            animation-delay: .30s;
        }

        /* ==============================
                           ADD BUTTON
                        ============================== */
        .btn-add {
            background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 9px 20px;
            font-size: 0.88rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all .2s;
            box-shadow: 0 4px 12px rgba(177, 0, 0, .25);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(177, 0, 0, .3);
            color: #fff;
        }

        @media (max-width: 576px) {
            .card-amount {
                font-size: 1.2rem;
            }

            .cards-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>

    <div class="container inv-wrap">

        {{-- ==================== ALERTS ==================== --}}
        @if (session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 au">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4 au">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        {{-- ==================== PAGE HEADER ==================== --}}
        <div class="page-header au">
            <div>
                <h1 class="page-title"></i>Inventori Spare-Part</h1>
                <p class="page-subtitle">Kelola stok, harga beli, dan potensi keuntungan bengkel.</p>
            </div>
            <button onclick="window.dispatchEvent(new CustomEvent('open-create-modal'))" data-bs-toggle="modal"
                data-bs-target="#formModal" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Barang
            </button>
        </div>

        {{-- ==================== SUMMARY CARDS ==================== --}}
        <div class="cards-grid">

            {{-- Total Item --}}
            <div class="summary-card card-item au d1">
                <div class="card-icon-wrap"><i class="fas fa-tags"></i></div>
                <div class="card-label">Total Jenis Item</div>
                <div class="card-amount">{{ $totalItem }}</div>
                <div class="card-meta">Jenis sparepart tercatat</div>
                <div class="card-badge"><i class="fas fa-database" style="font-size:.6rem;"></i> Master data</div>
            </div>


            {{-- Nilai Modal --}}
            <div class="summary-card card-modal au d3">
                <div class="card-icon-wrap"><i class="fas fa-arrow-trend-down"></i></div>
                <div class="card-label">Nilai Modal</div>
                <div class="card-amount sm">Rp {{ number_format($nilaiModal, 0, ',', '.') }}</div>
                <div class="card-meta">Total harga beli Ã— stok</div>
                <div class="card-badge"><i class="fas fa-receipt" style="font-size:.6rem;"></i> Modal tersimpan</div>
            </div>

            {{-- Potensi Laba --}}
            <div class="summary-card card-laba au d4">
                <div class="card-icon-wrap"><i class="fas fa-arrow-trend-up"></i></div>
                <div class="card-label">Potensi Laba</div>
                <div class="card-amount sm">Rp {{ number_format($potensiLaba, 0, ',', '.') }}</div>
                <div class="card-meta">Jika semua stok terjual</div>
                <div class="card-badge"><i class="fas fa-chart-line" style="font-size:.6rem;"></i> Estimasi profit</div>
            </div>

            {{-- Stok Menipis --}}
            <div class="summary-card card-tipis au d5">
                <div class="card-icon-wrap"><i class="fas fa-triangle-exclamation"></i></div>
                <div class="card-label">Stok Menipis</div>
                <div class="card-amount">{{ $stokMenipis }}</div>
                <div class="card-meta">Item â‰¤ 6 unit tersisa</div>
                <div class="card-badge"><i class="fas fa-bell" style="font-size:.6rem;"></i> Perlu restock</div>
            </div>
        </div>

        {{-- ==================== TOOLBAR (LIVEWIRE REUSABLE COMPONENTS) ==================== --}}
        <div class="toolbar au d5">
            @livewire('search-bar', ['placeholder' => 'Cari nama barang...'])

            @livewire('stok-filter')
        </div>

        {{-- ==================== LIVEWIRE COMPONENT ==================== --}}
        @livewire('inventory-table')

    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', (event) => {
                let modalEl = document.getElementById('formModal');
                if (modalEl) {
                    let modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) {
                        modal.hide();

                        // Hapus backdrop jika masih ada
                        let backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.remove();
                        }

                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }
                }
            });
        });
    </script>
@endsection