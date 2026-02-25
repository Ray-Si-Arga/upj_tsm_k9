@extends('layouts.app')

@section('content')

<style>
    :root {
        --honda-red:      #B10000;
        --honda-red-dark: #8B0000;
        --honda-red-soft: rgba(177,0,0,.08);
        --navy:           #0f172a;
        --navy-mid:       #1e293b;
        --bg:             #f0f2f5;
        --border:         #e2e8f0;
        --text:           #1e293b;
    }

    * { box-sizing: border-box; }

    /* ============================================================
       PAGE WRAPPER
    ============================================================ */
    .lv-wrap { padding: 28px 0 56px; }

    /* ============================================================
       PAGE HEADER  (dark gradient — sama seperti dashboard)
    ============================================================ */
    .page-header {
        background: linear-gradient(135deg, var(--navy) 0%, #16213e 50%, #0f172a 100%);
        border-radius: 20px;
        padding: 28px 34px;
        color: white;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .page-header::before {
        content: '';
        position: absolute; top: -80px; right: -80px;
        width: 280px; height: 280px; border-radius: 50%;
        background: radial-gradient(circle, rgba(177,0,0,.25) 0%, transparent 70%);
    }
    .page-header::after {
        content: '';
        position: absolute; bottom: -50px; left: 25%;
        width: 180px; height: 180px; border-radius: 50%;
        background: rgba(255,255,255,.03);
    }
    .header-eyebrow {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(177,0,0,.35);
        border: 1px solid rgba(177,0,0,.5);
        color: #fca5a5;
        font-size: .7rem; font-weight: 800; letter-spacing: 1.1px;
        text-transform: uppercase;
        padding: 4px 12px; border-radius: 20px;
        margin-bottom: 10px;
    }
    .header-title {
        font-size: 1.65rem; font-weight: 900;
        color: #fff; letter-spacing: -.5px;
        margin: 0 0 4px;
        position: relative; z-index: 1;
    }
    .header-sub {
        font-size: .82rem; color: rgba(255,255,255,.5);
        font-weight: 500;
        position: relative; z-index: 1;
    }
    .header-actions { position: relative; z-index: 1; }

    /* ============================================================
       STAT CARDS
    ============================================================ */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }
    @media(max-width:768px) { .stat-grid { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px) { .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        border-radius: 16px; padding: 20px;
        color: #fff; position: relative; overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-4px); }
    .stat-card::before {
        content:''; position:absolute; top:-40px; right:-40px;
        width:130px; height:130px; border-radius:50%;
        background: rgba(255,255,255,.07);
    }
    .stat-navy  { background: linear-gradient(140deg,#0f172a,#1e293b); box-shadow: 0 6px 22px rgba(15,23,42,.28); }
    .stat-red   { background: linear-gradient(140deg,#7f1d1d,#B10000); box-shadow: 0 6px 22px rgba(177,0,0,.3); }
    .stat-green { background: linear-gradient(140deg,#064e3b,#047857); box-shadow: 0 6px 22px rgba(6,78,59,.28); }

    .stat-icon  { width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size:.9rem; margin-bottom:12px; position:relative; z-index:1; }
    .stat-label { font-size:.63rem; font-weight:800; letter-spacing:1.1px; text-transform:uppercase; color:rgba(255,255,255,.5); margin-bottom:4px; position:relative; z-index:1; }
    .stat-val   { font-size:1.9rem; font-weight:900; color:#fff; letter-spacing:-1.5px; line-height:1; position:relative; z-index:1; }

    /* ============================================================
       SEARCH / FILTER BAR
    ============================================================ */
    .filter-bar {
        background: #fff;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 18px;
        border: 1px solid var(--border);
        box-shadow: 0 2px 10px rgba(0,0,0,.04);
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .filter-bar .search-wrap {
        flex: 1;
        min-width: 200px;
        position: relative;
    }
    .filter-bar .search-wrap i {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: .85rem;
    }
    .filter-bar input {
        width: 100%;
        padding: 9px 12px 9px 36px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: .84rem;
        color: var(--text);
        outline: none;
        transition: border .2s, box-shadow .2s;
        background: #f8fafc;
    }
    .filter-bar input:focus {
        border-color: var(--honda-red);
        box-shadow: 0 0 0 3px rgba(177,0,0,.08);
        background: #fff;
    }
    .filter-tab {
        display: flex; gap: 6px;
    }
    .filter-tab button {
        padding: 8px 16px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 9px;
        font-size: .78rem; font-weight: 700;
        color: #64748b; cursor: pointer;
        transition: all .18s;
    }
    .filter-tab button.active,
    .filter-tab button:hover {
        background: var(--honda-red);
        border-color: var(--honda-red);
        color: #fff;
    }

    /* ============================================================
       PANEL (table container)
    ============================================================ */
    .panel {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 2px 14px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .panel-hdr {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 22px;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap; gap: 10px;
    }
    .panel-title {
        font-size: .88rem; font-weight: 800; color: var(--text);
        display: flex; align-items: center; gap: 8px;
    }
    .panel-badge {
        font-size: .66rem; background: #f1f5f9; color: #64748b;
        padding: 2px 9px; border-radius: 20px; font-weight: 700;
    }

    /* ============================================================
       TABLE
    ============================================================ */
    .lv-table { width: 100%; border-collapse: collapse; }
    .lv-table thead tr {
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
    }
    .lv-table thead th {
        padding: 12px 18px;
        font-size: .72rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: .8px;
        color: #64748b; white-space: nowrap;
    }
    .lv-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background .15s;
    }
    .lv-table tbody tr:last-child { border-bottom: none; }
    .lv-table tbody tr:hover { background: #fafafa; }
    .lv-table td { padding: 14px 18px; vertical-align: middle; font-size: .84rem; color: var(--text); }

    .svc-name { font-weight: 700; color: var(--navy); font-size: .87rem; }
    .svc-desc { font-size: .77rem; color: #94a3b8; }

    .price-badge {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        padding: 4px 12px;
        border-radius: 8px;
        font-weight: 800;
        font-size: .8rem;
        white-space: nowrap;
    }

    /* type badges */
    .badge-paket  { background: rgba(177,0,0,.1); color: var(--honda-red); border: 1px solid rgba(177,0,0,.2); padding: 4px 11px; border-radius: 20px; font-size: .72rem; font-weight: 800; }
    .badge-satuan { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 4px 11px; border-radius: 20px; font-size: .72rem; font-weight: 800; }

    /* action buttons */
    .btn-edit, .btn-del {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 13px; border-radius: 8px; font-size: .76rem; font-weight: 700;
        border: none; cursor: pointer; text-decoration: none; transition: all .18s;
    }
    .btn-edit { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .btn-edit:hover { background: #fef3c7; color: #92400e; }
    .btn-del  { background: #fff1f2; color: var(--honda-red); border: 1px solid #fecdd3; }
    .btn-del:hover  { background: #ffe4e6; }

    /* ============================================================
       MOBILE CARDS
    ============================================================ */
    .mobile-list { display: none; }
    @media(max-width:767px) {
        .desktop-table { display: none; }
        .mobile-list   { display: block; }
    }

    .mob-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid var(--border);
        box-shadow: 0 2px 10px rgba(0,0,0,.04);
        padding: 18px;
        margin-bottom: 12px;
        transition: box-shadow .2s;
    }
    .mob-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,.08); }
    .mob-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; }
    .mob-name { font-size: .95rem; font-weight: 800; color: var(--navy); }
    .mob-price { font-size: 1.15rem; font-weight: 900; color: #16a34a; margin-bottom: 8px; }
    .mob-desc-box { background: #f8fafc; border-radius: 9px; padding: 10px 12px; margin-bottom: 12px; }
    .mob-desc-label { font-size: .65rem; font-weight: 800; text-transform: uppercase; letter-spacing: .8px; color: #94a3b8; margin-bottom: 3px; }
    .mob-desc-text  { font-size: .8rem; color: #64748b; font-style: italic; }
    .mob-actions { display: flex; gap: 8px; }
    .mob-btn { flex: 1; text-align: center; }

    /* ============================================================
       EMPTY STATE
    ============================================================ */
    .empty-state {
        text-align: center; padding: 56px 20px;
    }
    .empty-state .empty-icon {
        width: 70px; height: 70px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: #94a3b8;
        margin: 0 auto 16px;
    }
    .empty-state p { color: #94a3b8; font-size: .9rem; margin: 0; }

    /* ============================================================
       ALERT SUCCESS
    ============================================================ */
    .alert-custom {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 14px 20px;
        font-size: .84rem; font-weight: 600; color: #16a34a;
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 20px;
    }

    /* ============================================================
       ADD BUTTON
    ============================================================ */
    .btn-add {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--honda-red);
        color: #fff;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: .83rem; font-weight: 800;
        border: none; cursor: pointer; text-decoration: none;
        transition: background .18s, transform .18s, box-shadow .18s;
        box-shadow: 0 4px 14px rgba(177,0,0,.3);
        position: relative; z-index: 1;
    }
    .btn-add:hover {
        background: var(--honda-red-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(177,0,0,.4);
        color: #fff;
    }

</style>

<div class="lv-wrap">
    <div class="container-fluid px-3 px-md-4">

        {{-- =========================================================
             PAGE HEADER
        ========================================================= --}}
        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <div class="header-eyebrow">
                    <i class="fas fa-boxes-stacked"></i> Manajemen
                </div>
                <h1 class="header-title">Paket &amp; Layanan</h1>
                <p class="header-sub">Kelola seluruh paket servis dan layanan satuan yang tersedia</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('layanan.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Layanan
                </a>
            </div>
        </div>

        {{-- =========================================================
             STAT CARDS
        ========================================================= --}}
        @php
            $totalLayanan = $services->count();
            $totalPaket   = $services->where('type', 'paket')->count();
            $totalSatuan  = $services->where('type', 'satuan')->count();
        @endphp
        <div class="stat-grid">
            <div class="stat-card stat-navy">
                <div class="stat-icon"><i class="fas fa-list-ul"></i></div>
                <div class="stat-label">Total Layanan</div>
                <div class="stat-val">{{ $totalLayanan }}</div>
            </div>
            <div class="stat-card stat-red">
                <div class="stat-icon"><i class="fas fa-box-open"></i></div>
                <div class="stat-label">Paket Spesial</div>
                <div class="stat-val">{{ $totalPaket }}</div>
            </div>
            <div class="stat-card stat-green">
                <div class="stat-icon"><i class="fas fa-wrench"></i></div>
                <div class="stat-label">Layanan Satuan</div>
                <div class="stat-val">{{ $totalSatuan }}</div>
            </div>
        </div>

        {{-- =========================================================
             ALERT
        ========================================================= --}}
        @if (session('success'))
            <div class="alert-custom">
                <i class="fas fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- =========================================================
             FILTER BAR
        ========================================================= --}}
        <div class="filter-bar">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama layanan…">
            </div>
            <div class="filter-tab">
                <button class="active" data-filter="all">Semua</button>
                <button data-filter="paket">Paket</button>
                <button data-filter="satuan">Satuan</button>
            </div>
        </div>

        {{-- =========================================================
             DESKTOP TABLE
        ========================================================= --}}
        <div class="panel desktop-table">
            <div class="panel-hdr">
                <div class="panel-title">
                    <i class="fas fa-table-list" style="color:var(--honda-red)"></i>
                    Daftar Layanan
                    <span class="panel-badge">{{ $totalLayanan }} item</span>
                </div>
            </div>
            <table class="lv-table" id="layananTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Layanan</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $i => $service)
                        <tr data-type="{{ $service->type }}" data-name="{{ strtolower($service->name) }}">
                            <td style="color:#94a3b8;font-weight:700;">{{ $i + 1 }}</td>
                            <td>
                                <div class="svc-name">{{ $service->name }}</div>
                            </td>
                            <td>
                                @if ($service->type == 'paket')
                                    <span class="badge-paket"><i class="fas fa-star me-1"></i>Paket Spesial</span>
                                @else
                                    <span class="badge-satuan"><i class="fas fa-wrench me-1"></i>Satuan</span>
                                @endif
                            </td>
                            <td>
                                <span class="price-badge">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="svc-desc">{{ Str::limit($service->description ?? '—', 55) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('layanan.edit', $service->id) }}" class="btn-edit">
                                        <i class="fas fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="{{ route('layanan.destroy', $service->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-del"
                                            onclick="return confirm('Hapus layanan \'{{ $service->name }}\'?')">
                                            <i class="fas fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                                    <p>Belum ada data layanan.<br>Klik <strong>Tambah Layanan</strong> untuk mulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- =========================================================
             MOBILE CARD LIST
        ========================================================= --}}
        <div class="mobile-list" id="mobileList">
            @forelse ($services as $service)
                <div class="mob-card" data-type="{{ $service->type }}" data-name="{{ strtolower($service->name) }}">
                    <div class="mob-card-header">
                        <div class="mob-name">{{ $service->name }}</div>
                        @if ($service->type == 'paket')
                            <span class="badge-paket">Paket</span>
                        @else
                            <span class="badge-satuan">Satuan</span>
                        @endif
                    </div>
                    <div class="mob-price">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                    <div class="mob-desc-box">
                        <div class="mob-desc-label">Deskripsi</div>
                        <div class="mob-desc-text">{{ $service->description ?? 'Tidak ada deskripsi' }}</div>
                    </div>
                    <div class="mob-actions">
                        <a href="{{ route('layanan.edit', $service->id) }}" class="btn-edit mob-btn">
                            <i class="fas fa-pen-to-square"></i> Edit
                        </a>
                        <form action="{{ route('layanan.destroy', $service->id) }}" method="POST" class="mob-btn">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-del w-100"
                                onclick="return confirm('Hapus layanan \'{{ $service->name }}\'?')">
                                <i class="fas fa-trash-can"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                    <p>Belum ada data layanan.</p>
                </div>
            @endforelse
        </div>

    </div>{{-- /container --}}
</div>{{-- /lv-wrap --}}

{{-- ============================================================
     JAVASCRIPT: Live search & filter tabs
============================================================ --}}
<script>
(function () {
    const searchInput = document.getElementById('searchInput');
    const filterBtns  = document.querySelectorAll('.filter-tab button');
    let activeFilter  = 'all';

    function applyFilters() {
        const keyword = searchInput.value.toLowerCase().trim();

        // Desktop rows
        document.querySelectorAll('#layananTable tbody tr[data-name]').forEach(row => {
            const nameMatch   = row.dataset.name.includes(keyword);
            const typeMatch   = activeFilter === 'all' || row.dataset.type === activeFilter;
            row.style.display = (nameMatch && typeMatch) ? '' : 'none';
        });

        // Mobile cards
        document.querySelectorAll('#mobileList .mob-card').forEach(card => {
            const nameMatch    = card.dataset.name.includes(keyword);
            const typeMatch    = activeFilter === 'all' || card.dataset.type === activeFilter;
            card.style.display = (nameMatch && typeMatch) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', applyFilters);

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeFilter = btn.dataset.filter;
            applyFilters();
        });
    });
})();
</script>

@endsection