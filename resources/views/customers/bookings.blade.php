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
                   TOKENS  (sama dengan customers/index)
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

            --green: #059669;
            --green-soft: rgba(5, 150, 105, .08);
            --amber: #d97706;
            --amber-soft: rgba(217, 119, 6, .08);
            --blue: #1d4ed8;
            --blue-soft: rgba(29, 78, 216, .07);
            --slate-soft: rgba(100, 116, 139, .08);
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
        }

        .page-wrap {
            padding: 2rem 2rem 4rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        /* =========================================
                   BANNER
                ========================================= */
        .page-banner {
            background: linear-gradient(125deg, var(--navy) 0%, var(--navy-mid) 50%, var(--navy-soft) 100%);
            border-radius: 22px;
            padding: 28px 36px;
            margin-bottom: 26px;
            position: relative;
            overflow: hidden;
        }

        .page-banner::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(177, 0, 0, .25) 0%, transparent 68%);
            pointer-events: none;
        }

        .page-banner::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 25%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .03);
        }

        .banner-inner {
            position: relative;
            z-index: 1;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
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
        }

        .banner-title {
            font-size: 1.65rem;
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

        /* back button inside banner */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .15);
            color: rgba(255, 255, 255, .85);
            border-radius: 10px;
            padding: 9px 18px;
            font-size: .83rem;
            font-weight: 600;
            text-decoration: none;
            transition: background .18s, transform .18s;
            position: relative;
            z-index: 1;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, .18);
            transform: translateX(-2px);
            color: #fff;
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
            max-width: 300px;
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
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }

        .search-wrap input:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px var(--red-soft);
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
            background: #fafbfd;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .t-head-title {
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

        /* table */
        .hist-table {
            width: 100%;
            border-collapse: collapse;
        }

        .hist-table thead tr {
            background: #f8fafc;
            border-bottom: 1.5px solid var(--border);
        }

        .hist-table thead th {
            padding: 12px 22px;
            font-size: .67rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--subtle);
            white-space: nowrap;
        }

        .hist-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background .14s;
        }

        .hist-table tbody tr:last-child {
            border-bottom: none;
        }

        .hist-table tbody tr:hover {
            background: #fafbfd;
        }

        .hist-table tbody td {
            padding: 15px 22px;
            font-size: .875rem;
            vertical-align: middle;
        }

        /* plate number pill */
        .plate-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border: 2px solid var(--navy);
            border-radius: 8px;
            padding: 5px 14px;
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .plate-pill i {
            font-size: .65rem;
            color: rgba(255, 255, 255, .5);
        }

        /* date */
        .date-main {
            font-weight: 600;
            font-size: .87rem;
            color: var(--ink);
        }

        .date-day {
            font-size: .72rem;
            color: var(--subtle);
            margin-top: 1px;
        }

        /* service name */
        .svc-name {
            font-weight: 500;
            font-size: .87rem;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .svc-name i {
            color: var(--subtle);
            font-size: .75rem;
        }

        /* ---- STATUS BADGE ---- */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 13px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 700;
            text-transform: capitalize;
            white-space: nowrap;
        }

        .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* selesai / completed */
        .st-selesai,
        .st-completed,
        .st-done {
            background: var(--green-soft);
            color: var(--green);
            border: 1px solid rgba(5, 150, 105, .2);
        }

        .st-selesai .dot,
        .st-completed .dot,
        .st-done .dot {
            background: var(--green);
        }

        /* pending / menunggu */
        .st-pending,
        .st-menunggu,
        .st-waiting {
            background: var(--amber-soft);
            color: var(--amber);
            border: 1px solid rgba(217, 119, 6, .2);
        }

        .st-pending .dot,
        .st-menunggu .dot,
        .st-waiting .dot {
            background: var(--amber);
        }

        /* proses / in-progress */
        .st-proses,
        .st-process,
        .st-in-progress {
            background: var(--blue-soft);
            color: var(--blue);
            border: 1px solid rgba(29, 78, 216, .18);
        }

        .st-proses .dot,
        .st-process .dot,
        .st-in-progress .dot {
            background: var(--blue);
        }

        /* batal / cancelled */
        .st-batal,
        .st-cancelled,
        .st-cancel {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .st-batal .dot,
        .st-cancelled .dot,
        .st-cancel .dot {
            background: #dc2626;
        }

        /* default fallback */
        .st-default {
            background: var(--slate-soft);
            color: var(--muted);
            border: 1px solid rgba(100, 116, 139, .18);
        }

        .st-default .dot {
            background: var(--subtle);
        }

        /* ---- ACTION ---- */
        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--blue-soft);
            color: var(--blue);
            border: 1.5px solid rgba(29, 78, 216, .15);
            border-radius: 9px;
            padding: 7px 15px;
            font-size: .8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .17s;
        }

        .btn-detail:hover {
            background: var(--blue);
            color: #fff;
            transform: translateY(-2px);
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

        /* =========================================
                   RESPONSIVE
                ========================================= */
        @media (max-width: 640px) {
            .page-wrap {
                padding: 1.25rem 1rem 3rem;
            }

            .banner-title {
                font-size: 1.3rem;
            }

            .col-svc {
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
                        Riwayat Servis
                    </div>
                    <h1 class="banner-title">Riwayat Booking</h1>
                    <p class="banner-sub">Semua histori booking kendaraan customer.</p>
                </div>
                <a href="{{ route('customers.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Pelanggan
                </a>
            </div>
        </div>

        {{-- =============================================
        TOOLBAR
        ============================================= --}}
        <div class="toolbar au d1">
            <div>
                <span class="count-tag" id="countTag">
                    <i class="fas fa-calendar-alt me-1"></i>{{ count($bookings) }} booking
                </span>
            </div>
        </div>

        {{-- =============================================
        TABLE CARD
        ============================================= --}}
        <div class="t-card au d2">
            <div class="t-card-head">
                <div class="t-head-title">
                    <i class="fas fa-clipboard-list"></i>
                    Data Riwayat Booking
                </div>
            </div>

            @if($bookings->isEmpty())
                <div class="empty-box">
                    <div class="empty-ico"><i class="fas fa-calendar-times"></i></div>
                    <div class="empty-title">Belum ada riwayat booking</div>
                    <p class="empty-sub">Customer ini belum pernah melakukan booking service.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="hist-table" id="histTable">
                        <thead>
                            <tr>
                                <th style="width:48px; text-align:center;">#</th>
                                <th>No. Polisi</th>
                                <th>Tgl Booking</th>
                                <th class="col-svc">Service</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $index => $booking)
                                <tr>
                                    {{-- No --}}
                                    <td
                                        style="text-align:center; font-family:'Syne',sans-serif; font-size:.78rem; font-weight:700;">
                                        {{ $index + 1 }}
                                    </td>

                                    {{-- No. Polisi --}}
                                    <td>
                                        <div class="plate-pill">
                                            {{ $booking->plate_number }}
                                        </div>
                                    </td>

                                    {{-- Tgl Booking --}}
                                    <td>
                                        <div class="date-main">
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                        </div>
                                        <div class="date-day">
                                            {{ \Carbon\Carbon::setLocale('id') }}
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l') }}
                                        </div>
                                    </td>

                                    {{-- Service --}}
                                    <td class="col-svc">
                                        <div class="svc-name">
                                            <i class="fas fa-wrench"></i>
                                            {{ $booking->service->name ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @php
                                            $st = strtolower($booking->status);
                                            $cls = match (true) {
                                                in_array($st, ['selesai', 'completed', 'done']) => 'st-selesai',
                                                in_array($st, ['pending', 'menunggu', 'waiting']) => 'st-pending',
                                                in_array($st, ['proses', 'process', 'in-progress']) => 'st-proses',
                                                in_array($st, ['batal', 'cancelled', 'cancel']) => 'st-batal',
                                                default => 'st-default',
                                            };
                                        @endphp
                                        <span class="status-badge {{ $cls }}">
                                            <span class="dot"></span>
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('booking.history.detail', $booking->id) }}" class="btn-detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Footer --}}
                <div class="t-foot">
                    <span class="t-foot-info" id="tableInfo">
                        Menampilkan {{ count($bookings) }} dari {{ count($bookings) }} booking
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
            const q = document.getElementById('histSearch').value.toLowerCase();
            const rows = document.querySelectorAll('#histTable tbody tr');
            const tag = document.getElementById('countTag');
            const info = document.getElementById('tableInfo');
            let vis = 0;

            rows.forEach(r => {
                const match = r.textContent.toLowerCase().includes(q);
                r.style.display = match ? '' : 'none';
                if (match) vis++;
            });

            const total = rows.length;
            tag.innerHTML = `<i class="fas fa-calendar-alt me-1"></i>${vis} booking`;
            info.textContent = `Menampilkan ${vis} dari ${total} booking`;
        }
    </script>

@endsection