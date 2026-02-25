@extends('layouts.app')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* =========================================
                               TOKENS
                            ========================================= */
        :root {
            --red: #B10000;
            --red-dk: #8B0000;
            --red-soft: rgba(177, 0, 0, .09);
            --red-border: rgba(177, 0, 0, .18);

            --navy: #0b1120;
            --navy-mid: #14213d;
            --navy-soft: #1d2e4a;

            --bg: #f1f5fb;
            --surface: #ffffff;
            --border: #e4eaf3;
            --ink: #0f172a;
            --muted: #64748b;
            --subtle: #94a3b8;

            --blue-soft: rgba(29, 78, 216, .07);
            --blue: #1d4ed8;
        }

        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
        }

        .page-wrap {
            padding: 2rem 2rem 4rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* =========================================
                               PAGE HEADER BANNER
                            ========================================= */
        .page-banner {
            background: linear-gradient(125deg, var(--navy) 0%, var(--navy-mid) 50%, var(--navy-soft) 100%);
            border-radius: 22px;
            padding: 30px 36px;
            margin-bottom: 26px;
            position: relative;
            overflow: hidden;
        }

        /* fine grid texture */
        .page-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .025) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        /* red glow blob */
        .page-banner::after {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(177, 0, 0, .25) 0%, transparent 68%);
            pointer-events: none;
        }

        .banner-inner {
            position: relative;
            z-index: 1;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .banner-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(177, 0, 0, .2);
            border: 1px solid rgba(177, 0, 0, .32);
            color: #fca5a5;
            border-radius: 30px;
            padding: 3px 13px;
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-family: 'Syne', sans-serif;
        }

        .banner-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.7rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 4px;
            letter-spacing: -.4px;
        }

        .banner-sub {
            font-size: .83rem;
            color: rgba(255, 255, 255, .45);
            margin: 0;
        }

        /* stat pills inside banner */
        .banner-pills {
            display: flex;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .b-pill {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 14px;
            padding: 12px 22px;
            min-width: 96px;
        }

        .b-pill-num {
            font-family: 'Syne', sans-serif;
            font-size: 1.55rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .b-pill-lbl {
            font-size: .62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .9px;
            color: rgba(255, 255, 255, .4);
            margin-top: 4px;
        }

        .b-pill.accent .b-pill-num {
            color: #fca5a5;
        }

        /* =========================================
                               STAT CARDS ROW
                            ========================================= */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .s-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 8px rgba(0, 0, 0, .04);
            transition: transform .2s, box-shadow .2s;
        }

        .s-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .07);
        }

        .s-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .s-icon.red {
            background: linear-gradient(135deg, var(--red) 0%, var(--red-dk) 100%);
            color: #fff;
        }

        .s-icon.blue {
            background: var(--blue-soft);
            color: var(--blue);
        }

        .s-label {
            font-size: .69rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: var(--subtle);
            margin-bottom: 2px;
            font-family: 'Syne', sans-serif;
        }

        .s-value {
            font-family: 'Syne', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--ink);
            line-height: 1;
            letter-spacing: -.5px;
        }

        .s-note {
            font-size: .72rem;
            color: var(--subtle);
            margin-top: 3px;
        }

        /* =========================================
                               TOOLBAR
                            ========================================= */
        .toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 320px;
        }

        .search-wrap i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--subtle);
            font-size: .85rem;
            pointer-events: none;
        }

        .search-wrap input {
            width: 100%;
            padding: 9px 14px 9px 36px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: .87rem;
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }

        .search-wrap input:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px var(--red-soft);
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .count-tag {
            background: var(--red-soft);
            border: 1px solid var(--red-border);
            color: var(--red);
            border-radius: 8px;
            padding: 6px 14px;
            font-size: .78rem;
            font-weight: 700;
            white-space: nowrap;
        }

        /* =========================================
                               TABLE CARD
                            ========================================= */
        .t-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 1px 12px rgba(0, 0, 0, .04);
            overflow: hidden;
        }

        .t-card-head {
            padding: 18px 26px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: #fafbfd;
        }

        .t-head-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .t-head-title i {
            color: var(--red);
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, var(--red) 0%, var(--red-dk) 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 8px 18px;
            font-size: .83rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .18s, transform .18s;
        }

        .btn-add:hover {
            opacity: .88;
            transform: translateY(-1px);
            color: #fff;
        }

        /* table */
        .cust-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cust-table thead tr {
            background: #f8fafc;
            border-bottom: 1.5px solid var(--border);
        }

        .cust-table thead th {
            padding: 12px 22px;
            font-size: .67rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--subtle);
            white-space: nowrap;
            font-family: 'Syne', sans-serif;
        }

        .cust-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background .14s;
        }

        .cust-table tbody tr:last-child {
            border-bottom: none;
        }

        .cust-table tbody tr:hover {
            background: #fafbfd;
        }

        .cust-table tbody td {
            padding: 15px 22px;
            font-size: .875rem;
            vertical-align: middle;
        }

        /* avatar */
        .cust-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: .82rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .cust-name {
            font-weight: 600;
            font-size: .9rem;
            color: var(--ink);
        }

        .cust-id {
            font-size: .72rem;
            color: var(--subtle);
            margin-top: 1px;
        }

        /* contact lines */
        .c-line {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: .82rem;
            color: var(--muted);
            margin-bottom: 3px;
        }

        .c-line:last-child {
            margin-bottom: 0;
        }

        .c-line i {
            width: 13px;
            text-align: center;
            flex-shrink: 0;
        }

        /* history badge */
        .hist-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: .76rem;
            font-weight: 700;
            background: var(--blue-soft);
            color: var(--blue);
            border: 1px solid rgba(29, 78, 216, .14);
        }

        /* action buttons */
        .act-wrap {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }

        .btn-act {
            width: 35px;
            height: 35px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .82rem;
            border: 1.5px solid transparent;
            text-decoration: none;
            cursor: pointer;
            background: transparent;
            transition: all .17s;
        }

        .btn-act:hover {
            transform: translateY(-2px);
        }

        .btn-view {
            background: var(--blue-soft);
            color: var(--blue);
            border-color: rgba(29, 78, 216, .15);
        }

        .btn-view:hover {
            background: var(--blue);
            color: #fff;
        }

        .btn-del {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .btn-del:hover {
            background: #dc2626;
            color: #fff;
        }

        /* =========================================
                               TABLE FOOTER
                            ========================================= */
        .t-foot {
            padding: 13px 26px;
            border-top: 1px solid var(--border);
            background: #fafbfd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .t-foot-info {
            font-size: .77rem;
            color: var(--subtle);
            font-weight: 500;
        }

        /* =========================================
                               EMPTY STATE
                            ========================================= */
        .empty-box {
            text-align: center;
            padding: 72px 24px;
        }

        .empty-ico {
            width: 68px;
            height: 68px;
            border-radius: 18px;
            background: var(--red-soft);
            border: 1.5px solid var(--red-border);
            color: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 16px;
        }

        .empty-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: .84rem;
            color: var(--subtle);
        }

        /* =========================================
                               ANIMATIONS
                            ========================================= */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
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

        /* =========================================
                               RESPONSIVE
                            ========================================= */
        @media (max-width: 768px) {
            .page-wrap {
                padding: 1.25rem 1rem 3rem;
            }

            .banner-pills {
                display: none;
            }

            .banner-title {
                font-size: 1.3rem;
            }

            .col-alamat {
                display: none;
            }
        }
    </style>

    <main class="page-wrap">

        {{-- =============================================
        BANNER
        ============================================= --}}
        <div class="page-banner au">
            <div class="banner-inner">
                <div>
                    <div class="banner-label">
                        <i class="fas fa-user-shield" style="font-size:.6rem;"></i>
                        Admin Panel
                    </div>
                    <h1 class="banner-title">Database Customer</h1>
                    <p class="banner-sub">Kelola semua data pelanggan yang terdaftar di sistem.</p>
                </div>

                <div class="banner-pills">
                    <div class="b-pill">
                        <span class="b-pill-num">{{ $customers->count() }}</span>
                        <span class="b-pill-lbl">Total</span>
                    </div>
                    <div class="b-pill accent">
                        <span
                            class="b-pill-num">{{ $customers->where('created_at', '>=', now()->subDays(7))->count() }}</span>
                        <span class="b-pill-lbl">Baru</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- =============================================
        STAT CARDS
        ============================================= --}}
        <div class="stats-row au d1">
            <div class="s-card">
                <div class="s-icon red">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="s-label">Total Customer</div>
                    <div class="s-value">{{ $customers->count() }}</div>
                    <div class="s-note"><i class="fas fa-check-circle me-1 text-success"></i>Database terverifikasi</div>
                </div>
            </div>

            <div class="s-card">
                <div class="s-icon blue">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <div class="s-label">Customer Baru</div>
                    <div class="s-value">{{ $customers->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                    <div class="s-note"><i class="fas fa-calendar-alt me-1"></i>7 hari terakhir</div>
                </div>
            </div>
        </div>

        {{-- =============================================
        TOOLBAR
        ============================================= --}}
        <div class="toolbar au d2">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="custSearch" placeholder="Cari nama atau ID customer..." oninput="doSearch()">
            </div>
            <div class="toolbar-right">
                <span class="count-tag" id="countTag">
                    <i class="fas fa-users me-1"></i>{{ $customers->count() }} customer
                </span>
            </div>
        </div>

        {{-- =============================================
        TABLE CARD
        ============================================= --}}
        <div class="t-card au d3">
            <div class="t-card-head">
                <div class="t-head-title">
                    <i class="fas fa-address-book"></i>
                    Daftar Database Customer
                </div>

            </div>

            @if($customers->isEmpty())
                <div class="empty-box">
                    <div class="empty-ico"><i class="fas fa-users-slash"></i></div>
                    <div class="empty-title">Belum ada customer terdaftar</div>
                    <p class="empty-sub">Data akan muncul setelah customer melakukan registrasi.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="cust-table" id="custTable">
                        <thead>
                            <tr>
                                <th style="width:48px; text-align:center;">#</th>
                                <th>Customer</th>
                                <th class="col-alamat">Kontak &amp; Alamat</th>
                                <th>Riwayat</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $index => $customer)
                                <tr>
                                    {{-- No --}}
                                    <td
                                        style="text-align:center; font-family:'Syne',sans-serif; font-size:.78rem; font-weight:700; color:#cbd5e1;">
                                        {{ $index + 1 }}
                                    </td>

                                    {{-- Customer --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="cust-avatar">
                                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="cust-name">{{ $customer->name }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kontak & Gmail --}}
                                    <td class="col-alamat">
                                        <div class="c-line">
                                            <i class="fas fa-phone-alt" style="color:var(--subtle);"></i>
                                            <span>{{ $customer->phone }}</span>
                                        </div>
                                        <div class="c-line">
                                            <i class="fas fa-envelope" style="color:var(--subtle);"></i>
                                            <span>{{ Str::limit($customer->email, 40) }}</span>
                                        </div>
                                    </td>

                                    {{-- Riwayat --}}
                                    <td>
                                        <span class="hist-badge">
                                            <i class="fas fa-history" style="font-size:.65rem;"></i>
                                            {{ $customer->bookings->count() }} Transaksi
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="pe-4">
                                        <div class="act-wrap">
                                            @if ($customer->bookings->isNotEmpty())
                                                <a href="{{ route('customers.bookings', ['whatsapp' => $customer->phone, 'email' => $customer->email]) }}"
                                                    class="btn-act btn-view" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @else
                                                <button class="btn btn-outline-secondary btn-icon" disabled title="Belum ada riwayat">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route('hapus', $customer->id) }}" class="btn-act btn-del"
                                                onclick="return confirm('Hapus data ini?')" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Footer --}}
                <div class="t-foot">
                    <span class="t-foot-info" id="tableInfo">
                        Menampilkan {{ $customers->count() }} dari {{ $customers->count() }} customer
                    </span>
                    <span style="font-size:.74rem; color:var(--subtle);">
                        <i class="far fa-clock me-1"></i>{{ now()->format('d M Y, H:i') }}
                    </span>
                </div>
            @endif
        </div>

    </main>

    {{-- =============================================
    SEARCH SCRIPT
    ============================================= --}}
    <script>
        function doSearch() {
            const q = document.getElementById('custSearch').value.toLowerCase();
            const rows = document.querySelectorAll('#custTable tbody tr');
            const tag = document.getElementById('countTag');
            const info = document.getElementById('tableInfo');
            let vis = 0;

            rows.forEach(r => {
                const match = r.textContent.toLowerCase().includes(q);
                r.style.display = match ? '' : 'none';
                if (match) vis++;
            });

            const total = rows.length;
            tag.innerHTML = `<i class="fas fa-users me-1"></i>${vis} customer`;
            info.textContent = `Menampilkan ${vis} dari ${total} customer`;
        }
    </script>

@endsection