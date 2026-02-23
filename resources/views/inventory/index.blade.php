@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @php
        $totalItem      = $Inventory->count();
        $totalStok      = $Inventory->sum('jumlah_barang');
        $nilaiModal     = $Inventory->sum(fn($i) => $i->harga_beli * $i->jumlah_barang);
        $nilaiJual      = $Inventory->sum(fn($i) => $i->harga_jual * $i->jumlah_barang);
        $potensiLaba    = $nilaiJual - $nilaiModal;
        $stokMenipis    = $Inventory->where('jumlah_barang', '<=', 6)->count();
    @endphp

    <style>
        /* ==============================
           ROOT & BASE
        ============================== */
        :root {
            --honda-red:      #B10000;
            --honda-red-dark: #8B0000;
            --honda-red-soft: rgba(177, 0, 0, 0.08);
            --emerald:        #064e3b;
            --emerald-mid:    #047857;
            --navy:           #0f172a;
            --navy-mid:       #1e293b;
            --amber:          #78350f;
            --amber-mid:      #92400e;
            --bg:             #f4f6f9;
            --border:         #e2e8f0;
            --text:           #1e293b;
        }

        body { background: var(--bg); font-family: 'Inter', system-ui, sans-serif; color: var(--text); }

        .inv-wrap { padding: 28px 0; }

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
        .page-subtitle { font-size: 0.83rem; color: #64748b; margin: 0; font-weight: 500; }

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
        .summary-card:hover { transform: translateY(-3px); box-shadow: 0 14px 36px rgba(0,0,0,0.13); }

        /* Card colours */
        .card-item   { background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%); box-shadow: 0 6px 24px rgba(15,23,42,.28); }
        .card-stok   { background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-mid) 100%); box-shadow: 0 6px 24px rgba(6,78,59,.28); }
        .card-modal  { background: linear-gradient(135deg, #881337 0%, var(--honda-red) 100%); box-shadow: 0 6px 24px rgba(136,19,55,.28); }
        .card-laba   { background: linear-gradient(135deg, var(--amber) 0%, var(--amber-mid) 100%); box-shadow: 0 6px 24px rgba(120,53,15,.28); }
        .card-tipis  { background: linear-gradient(135deg, #4c0519 0%, #881337 100%); box-shadow: 0 6px 24px rgba(76,5,25,.28); }

        /* Decorative circle */
        .summary-card::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 140px; height: 140px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .summary-card::after {
            content: '';
            position: absolute;
            bottom: -30px; left: -20px;
            width: 110px; height: 110px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .card-icon-wrap {
            width: 42px; height: 42px;
            border-radius: 11px;
            background: rgba(255,255,255,0.14);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.05rem; color: #fff;
            margin-bottom: 14px;
            position: relative; z-index: 1;
            backdrop-filter: blur(4px);
        }
        .card-label {
            font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: rgba(255,255,255,.58);
            margin-bottom: 5px; position: relative; z-index: 1;
        }
        .card-amount {
            font-size: 1.5rem; font-weight: 800; color: #fff;
            line-height: 1.2; letter-spacing: -0.5px;
            position: relative; z-index: 1;
        }
        .card-amount.sm { font-size: 1.25rem; }
        .card-meta {
            font-size: 0.72rem; color: rgba(255,255,255,.5);
            margin-top: 7px; position: relative; z-index: 1; font-weight: 500;
        }
        .card-badge {
            display: inline-flex; align-items: center; gap: 4px;
            background: rgba(255,255,255,.14); color: rgba(255,255,255,.85);
            font-size: 0.7rem; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
            margin-top: 10px; position: relative; z-index: 1;
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
            box-shadow: 0 1px 6px rgba(0,0,0,.04);
        }
        .search-wrap { position: relative; flex: 1; min-width: 200px; max-width: 360px; }
        .search-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem; }
        .search-wrap input {
            width: 100%; padding: 9px 14px 9px 38px;
            border: 1px solid var(--border); border-radius: 10px;
            font-size: 0.88rem; color: var(--text);
            outline: none; transition: border-color .2s, box-shadow .2s;
        }
        .search-wrap input:focus { border-color: var(--honda-red); box-shadow: 0 0 0 3px rgba(177,0,0,.1); }

        .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
        .filter-tab {
            padding: 7px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 600;
            border: 1px solid var(--border); background: #fff; color: #64748b;
            cursor: pointer; transition: all .2s; text-decoration: none;
        }
        .filter-tab:hover, .filter-tab.active {
            background: var(--honda-red); color: #fff; border-color: var(--honda-red);
        }
        .filter-tab.active-warn { background: #fef3c7; color: #92400e; border-color: #fcd34d; }

        /* ==============================
           TABLE CARD
        ============================== */
        .table-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,.05);
        }
        .table-header-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 24px; border-bottom: 1px solid var(--border);
            flex-wrap: wrap; gap: 10px;
        }
        .table-title {
            font-size: 0.95rem; font-weight: 700; color: var(--text);
            display: flex; align-items: center; gap: 10px;
        }
        .item-count {
            font-size: 0.72rem; background: #f1f5f9; color: #64748b;
            font-weight: 600; padding: 3px 10px; border-radius: 20px;
        }

        /* Scrollable table */
        .table-scroll { overflow-x: auto; }

        /* Table itself */
        .inv-table { width: 100%; border-collapse: collapse; }

        .inv-table thead th {
            padding: 12px 20px;
            font-size: 0.72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.7px;
            color: #94a3b8; background: #f8fafc;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .inv-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background .15s;
        }
        .inv-table tbody tr:last-child { border-bottom: none; }
        .inv-table tbody tr:hover { background: #fafafa; }
        .inv-table tbody td { padding: 15px 20px; font-size: 0.875rem; vertical-align: middle; }

        /* Row number */
        .row-num { color: #94a3b8; font-weight: 600; font-size: 0.8rem; text-align: center; }

        /* Item name */
        .item-name { font-weight: 700; color: var(--text); }

        /* Stock badge */
        .stok-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 8px;
            font-size: 0.78rem; font-weight: 700; white-space: nowrap;
        }
        .stok-ok    { background: #d1fae5; color: #065f46; }
        .stok-tipis { background: #ffe4e6; color: #9f1239; }
        .stok-warn  { background: #fef3c7; color: #92400e; }

        /* Price */
        .price-cell { white-space: nowrap; }
        .price-row { display: flex; align-items: center; gap: 6px; margin-bottom: 3px; }
        .price-label {
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .5px; color: #94a3b8; min-width: 28px;
        }
        .price-val {
            font-family: 'Consolas', monospace; font-weight: 700;
            font-size: 0.85rem; padding: 3px 8px; border-radius: 6px;
        }
        .price-beli { background: #fef2f2; color: #b91c1c; }
        .price-jual { background: #f0fdf4; color: #15803d; }

        /* Laba cell */
        .laba-per { font-family: 'Consolas', monospace; font-weight: 700; color: #1d4ed8; font-size: 0.85rem; }
        .laba-total { font-size: 0.72rem; color: #64748b; font-weight: 600; margin-top: 2px; }

        /* Action buttons */
        .btn-act {
            width: 34px; height: 34px; border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.85rem; transition: all .18s; text-decoration: none;
            border: 1px solid transparent;
        }
        .btn-act:hover { transform: translateY(-2px); }
        .btn-edit  { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
        .btn-edit:hover  { background: #2563eb; color: #fff; }
        .btn-hapus { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
        .btn-hapus:hover { background: #dc2626; color: #fff; }

        /* Empty state */
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state i { font-size: 3rem; color: #e2e8f0; margin-bottom: 14px; display: block; }
        .empty-state p { color: #94a3b8; font-size: 0.9rem; }

        /* ==============================
           MOBILE CARDS
        ============================== */
        .mobile-card {
            background: #fff; border-radius: 14px;
            border: 1px solid var(--border); padding: 18px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }
        .mobile-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }

        /* ==============================
           ANIMATIONS
        ============================== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .au  { animation: fadeUp .4s ease both; }
        .d1  { animation-delay: .05s; }
        .d2  { animation-delay: .10s; }
        .d3  { animation-delay: .15s; }
        .d4  { animation-delay: .20s; }
        .d5  { animation-delay: .25s; }
        .d6  { animation-delay: .30s; }

        /* ==============================
           ADD BUTTON
        ============================== */
        .btn-add {
            background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
            color: #fff; border: none; border-radius: 10px;
            padding: 9px 20px; font-size: 0.88rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 8px;
            text-decoration: none; transition: all .2s;
            box-shadow: 0 4px 12px rgba(177,0,0,.25);
        }
        .btn-add:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(177,0,0,.3); color: #fff; }

        @media (max-width: 576px) {
            .card-amount { font-size: 1.2rem; }
            .cards-grid  { grid-template-columns: 1fr 1fr; }
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
                <h1 class="page-title"><i class="fa-solid fa-boxes-stacked me-2" style="color:var(--honda-red);"></i>Inventori Spare-Part</h1>
                <p class="page-subtitle">Kelola stok, harga beli, dan potensi keuntungan bengkel.</p>
            </div>
            <a href="{{ route('inventory.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Barang
            </a>
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
                <div class="card-meta">Total harga beli × stok</div>
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
                <div class="card-meta">Item ≤ 6 unit tersisa</div>
                <div class="card-badge"><i class="fas fa-bell" style="font-size:.6rem;"></i> Perlu restock</div>
            </div>

        </div>

        {{-- ==================== TOOLBAR ==================== --}}
        <div class="toolbar au d5">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama barang..." oninput="filterTable()">
            </div>
            <div class="filter-tabs">
                <button class="filter-tab active" onclick="filterStok('all', this)">Semua</button>
                <button class="filter-tab" onclick="filterStok('tipis', this)">
                    <i class="fas fa-triangle-exclamation me-1 text-danger"></i>Stok Menipis
                </button>
                <button class="filter-tab" onclick="filterStok('aman', this)">Stok Aman</button>
            </div>
        </div>

        {{-- ==================== TABLE (DESKTOP) ==================== --}}
        <div class="table-card au d6 d-none d-md-block">
            <div class="table-header-bar">
                <div class="table-title">
                    <i class="fas fa-list" style="color:#64748b;"></i>
                    Daftar Inventori
                    <span class="item-count" id="visibleCount">{{ $totalItem }} item</span>
                </div>
                <span style="font-size:.78rem; color:#94a3b8; font-weight:500;">
                    <i class="far fa-calendar me-1"></i>{{ date('d M Y') }}
                </span>
            </div>

            <div class="table-scroll">
                <table class="inv-table" id="invTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:52px;">#</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th class="text-center">Laba / Unit</th>
                            <th class="text-center">Potensi Total</th>
                            <th class="text-center" style="width:100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($Inventory as $index => $data)
                            @php
                                $laba       = $data->harga_jual - $data->harga_beli;
                                $totalLaba  = $laba * $data->jumlah_barang;
                                $stokClass  = $data->jumlah_barang <= 6 ? 'tipis' : 'aman';
                            @endphp
                            <tr data-name="{{ strtolower($data->nama_barang) }}" data-stok="{{ $stokClass }}">
                                <td class="row-num">{{ $index + 1 }}</td>

                                {{-- Nama --}}
                                <td>
                                    <div class="item-name">{{ $data->nama_barang }}</div>
                                    @if($data->jumlah_barang <= 6)
                                        <small class="text-danger"><i class="fas fa-circle-exclamation me-1"></i>Perlu restock</small>
                                    @endif
                                </td>

                                {{-- Stok --}}
                                <td class="text-center">
                                    @if($data->jumlah_barang == 0)
                                        <span class="stok-badge stok-tipis"><i class="fas fa-times-circle"></i>Habis</span>
                                    @elseif($data->jumlah_barang <= 6)
                                        <span class="stok-badge stok-tipis"><i class="fas fa-triangle-exclamation"></i>{{ $data->jumlah_barang }} unit</span>
                                    @elseif($data->jumlah_barang <= 15)
                                        <span class="stok-badge stok-warn"><i class="fas fa-minus-circle"></i>{{ $data->jumlah_barang }} unit</span>
                                    @else
                                        <span class="stok-badge stok-ok"><i class="fas fa-check-circle"></i>{{ $data->jumlah_barang }} unit</span>
                                    @endif
                                </td>

                                {{-- Harga Beli --}}
                                <td class="price-cell">
                                    <span class="price-val price-beli">Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</span>
                                </td>

                                {{-- Harga Jual --}}
                                <td class="price-cell">
                                    <span class="price-val price-jual">Rp {{ number_format($data->harga_jual, 0, ',', '.') }}</span>
                                </td>

                                {{-- Laba per unit --}}
                                <td class="text-center">
                                    <div class="laba-per">Rp {{ number_format($laba, 0, ',', '.') }}</div>
                                    <div class="laba-total">
                                        {{ round(($laba / max($data->harga_beli, 1)) * 100, 1) }}% margin
                                    </div>
                                </td>

                                {{-- Potensi Total --}}
                                <td class="text-center">
                                    <div class="laba-per" style="color:#059669;">Rp {{ number_format($totalLaba, 0, ',', '.') }}</div>
                                    <div class="laba-total">{{ $data->jumlah_barang }} × Rp {{ number_format($laba, 0, ',', '.') }}</div>
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('inventory.edit', $data->id) }}" class="btn-act btn-edit" title="Edit">
                                            <i class="fas fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('inventory.destroy', $data->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Hapus barang \'{{ $data->nama_barang }}\'?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-act btn-hapus" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="fas fa-box-open"></i>
                                        <p>Belum ada data inventori.<br>Tambahkan barang pertama Anda.</p>
                                        <a href="{{ route('inventory.create') }}" class="btn-add mt-2">
                                            <i class="fas fa-plus"></i> Tambah Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ==================== MOBILE CARDS ==================== --}}
        <div class="d-md-none au d6">
            @forelse ($Inventory as $index => $data)
                @php
                    $laba      = $data->harga_jual - $data->harga_beli;
                    $totalLaba = $laba * $data->jumlah_barang;
                @endphp
                <div class="mobile-card">
                    <div class="mobile-card-header">
                        <div>
                            <div class="fw-bold text-dark">{{ $data->nama_barang }}</div>
                            <small class="text-muted">#{{ $index + 1 }}</small>
                        </div>
                        @if($data->jumlah_barang <= 6)
                            <span class="stok-badge stok-tipis"><i class="fas fa-triangle-exclamation"></i>{{ $data->jumlah_barang }} unit</span>
                        @elseif($data->jumlah_barang <= 15)
                            <span class="stok-badge stok-warn">{{ $data->jumlah_barang }} unit</span>
                        @else
                            <span class="stok-badge stok-ok"><i class="fas fa-check-circle"></i>{{ $data->jumlah_barang }} unit</span>
                        @endif
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="p-2 rounded-3" style="background:#fef2f2;">
                                <div style="font-size:.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Harga Beli</div>
                                <div style="font-weight:800; color:#b91c1c; font-size:.88rem;">Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded-3" style="background:#f0fdf4;">
                                <div style="font-size:.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Harga Jual</div>
                                <div style="font-weight:800; color:#15803d; font-size:.88rem;">Rp {{ number_format($data->harga_jual, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded-3" style="background:#eff6ff;">
                                <div style="font-size:.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Laba / Unit</div>
                                <div style="font-weight:800; color:#1d4ed8; font-size:.88rem;">Rp {{ number_format($laba, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded-3" style="background:#f0fdf4;">
                                <div style="font-size:.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Potensi Total</div>
                                <div style="font-weight:800; color:#059669; font-size:.88rem;">Rp {{ number_format($totalLaba, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('inventory.edit', $data->id) }}" class="btn-act btn-edit flex-fill justify-content-center" style="width:auto; height:auto; padding:8px;">
                            <i class="fas fa-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('inventory.destroy', $data->id) }}" method="POST" class="flex-fill"
                              onsubmit="return confirm('Hapus barang ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-act btn-hapus w-100" style="height:auto; padding:8px; width:100%!important; border-radius:8px;">
                                <i class="fas fa-trash-alt me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <p>Belum ada data inventori.</p>
                </div>
            @endforelse
        </div>

    </div>

    <script>
        // ===================== SEARCH =====================
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            updateVisible(q, currentFilter);
        }

        // ===================== STOK FILTER =====================
        let currentFilter = 'all';

        function filterStok(type, btn) {
            currentFilter = type;
            document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const q = document.getElementById('searchInput').value.toLowerCase();
            updateVisible(q, type);
        }

        function updateVisible(q, stokFilter) {
            const rows = document.querySelectorAll('#invTable tbody tr[data-name]');
            let count = 0;
            rows.forEach(row => {
                const name  = row.getAttribute('data-name') || '';
                const stok  = row.getAttribute('data-stok') || '';
                const matchQ    = name.includes(q);
                const matchStok = stokFilter === 'all' || stok === stokFilter;
                const show = matchQ && matchStok;
                row.style.display = show ? '' : 'none';
                if (show) count++;
            });
            const el = document.getElementById('visibleCount');
            if (el) el.textContent = count + ' item';
        }
    </script>

@endsection