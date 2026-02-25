@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">

    @php
        $today             = date('Y-m-d');
        $totalHariIni      = $todayBookings->count();
        $pending           = $todayBookings->where('status', 'pending')->count();
        $onProgress        = $todayBookings->where('status', 'on_progress')->count();
        $done              = $todayBookings->where('status', 'done')->count();
        $totalMendatang    = $upcomingBookings->total();
    @endphp

    <style>
        /* ==============================
           ROOT
        ============================== */
        :root {
            --honda-red:      #B10000;
            --honda-red-dark: #8B0000;
            --honda-red-soft: rgba(177, 0, 0, 0.08);
            --navy:           #0f172a;
            --navy-mid:       #1e293b;
            --emerald:        #064e3b;
            --emerald-mid:    #047857;
            --amber:          #78350f;
            --amber-mid:      #b45309;
            --bg:             #f4f6f9;
            --border:         #e2e8f0;
            --text:           #1e293b;
        }

        body { background: var(--bg); font-family: 'Inter', system-ui, sans-serif; color: var(--text); }

        .bk-wrap { padding: 28px 0; }

        /* ==============================
           PAGE HEADER
        ============================== */
        .page-header {
            display: flex; flex-wrap: wrap;
            align-items: center; justify-content: space-between;
            gap: 16px; margin-bottom: 28px;
        }
        .page-title {
            font-size: 1.6rem; font-weight: 800; color: var(--text);
            margin: 0 0 4px; letter-spacing: -0.5px;
        }
        .page-subtitle { font-size: 0.83rem; color: #64748b; margin: 0; font-weight: 500; }

        .btn-walkin {
            background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
            color: #fff; border: none; border-radius: 10px;
            padding: 9px 20px; font-size: 0.88rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 8px;
            text-decoration: none; transition: all .2s;
            box-shadow: 0 4px 12px rgba(177,0,0,.25);
        }
        .btn-walkin:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(177,0,0,.3); color: #fff; }

        /* ==============================
           SUMMARY CARDS
        ============================== */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px; margin-bottom: 28px;
        }

        .summary-card {
            border-radius: 16px; padding: 20px 22px;
            color: #fff; position: relative; overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }
        .summary-card:hover { transform: translateY(-3px); box-shadow: 0 14px 36px rgba(0,0,0,.14); }
        .summary-card::before {
            content:''; position:absolute; top:-40px; right:-40px;
            width:140px; height:140px; border-radius:50%;
            background:rgba(255,255,255,.06);
        }
        .summary-card::after {
            content:''; position:absolute; bottom:-30px; left:-20px;
            width:110px; height:110px; border-radius:50%;
            background:rgba(255,255,255,.04);
        }

        .card-total    { background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%); box-shadow: 0 6px 24px rgba(15,23,42,.28); }
        .card-pending  { background: linear-gradient(135deg, #78350f 0%, var(--amber-mid) 100%); box-shadow: 0 6px 24px rgba(120,53,15,.28); }
        .card-progress { background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%); box-shadow: 0 6px 24px rgba(30,58,138,.28); }
        .card-done     { background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-mid) 100%); box-shadow: 0 6px 24px rgba(6,78,59,.28); }
        .card-upcoming { background: linear-gradient(135deg, #4c0519 0%, var(--honda-red) 100%); box-shadow: 0 6px 24px rgba(177,0,0,.28); }

        .card-icon-wrap {
            width: 40px; height: 40px; border-radius: 10px;
            background: rgba(255,255,255,.14);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: #fff;
            margin-bottom: 12px; position: relative; z-index: 1;
        }
        .card-label {
            font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: rgba(255,255,255,.58);
            margin-bottom: 4px; position: relative; z-index: 1;
        }
        .card-amount {
            font-size: 1.75rem; font-weight: 800; color: #fff;
            line-height: 1; letter-spacing: -1px;
            position: relative; z-index: 1;
        }
        .card-meta {
            font-size: 0.7rem; color: rgba(255,255,255,.5);
            margin-top: 6px; position: relative; z-index: 1; font-weight: 500;
        }

        /* ==============================
           SECTION DIVIDER
        ============================== */
        .section-label {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 14px;
        }
        .section-label-text {
            font-size: 0.95rem; font-weight: 800; color: var(--text);
        }
        .section-label-badge {
            font-size: 0.7rem; background: var(--honda-red-soft);
            color: var(--honda-red); font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
            border: 1px solid rgba(177,0,0,.15);
        }
        .section-label::after {
            content:''; flex:1; height:1px;
            background: linear-gradient(to right, var(--border), transparent);
        }

        /* ==============================
           TABLE CARD
        ============================== */
        .table-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,.05);
            margin-bottom: 32px;
        }

        .table-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 22px; border-bottom: 1px solid var(--border);
            flex-wrap: wrap; gap: 10px;
        }
        .table-card-title {
            font-size: 0.9rem; font-weight: 700; color: var(--text);
            display: flex; align-items: center; gap: 10px;
        }
        .table-dot-today  { width:10px; height:10px; border-radius:50%; background:var(--honda-red); flex-shrink:0; box-shadow:0 0 0 3px rgba(177,0,0,.15); }
        .table-dot-future { width:10px; height:10px; border-radius:50%; background:#94a3b8; flex-shrink:0; }

        /* Table */
        .bk-table { width:100%; border-collapse:collapse; }
        .bk-table thead th {
            padding: 11px 18px;
            font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .7px;
            color: #94a3b8; background: #f8fafc;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .bk-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
        .bk-table tbody tr:last-child { border-bottom:none; }
        .bk-table tbody tr:hover { background:#fafafa; }
        .bk-table tbody td { padding: 14px 18px; font-size: .875rem; vertical-align: middle; }

        /* Date group row */
        .date-group-row td {
            background: #f8fafc;
            font-size: 0.75rem; font-weight: 700;
            color: #64748b; text-transform: uppercase;
            letter-spacing: .7px; padding: 8px 18px;
            border-top: 1px solid var(--border);
        }

        /* Queue badge */
        .queue-badge {
            width: 38px; height: 38px;
            background: var(--honda-red-soft);
            color: var(--honda-red);
            border: 2px solid rgba(177,0,0,.25);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 1rem;
            margin: 0 auto;
        }
        .queue-num-plain {
            font-weight: 700; color: #94a3b8; font-size: .9rem;
        }

        /* Customer info */
        .cust-name { font-weight: 700; color: var(--text); margin-bottom: 2px; }
        .cust-plate {
            display: inline-block; font-family: 'Consolas', monospace;
            font-weight: 800; font-size: .8rem;
            background: var(--navy); color: #fff;
            padding: 2px 8px; border-radius: 5px; margin-right: 4px;
        }
        .cust-type { font-size: .75rem; color: #64748b; font-weight: 600; }

        /* Service badges */
        .svc-badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 6px;
            font-size: .72rem; font-weight: 700;
            background: #eff6ff; color: #1d4ed8;
            margin: 1px 2px 1px 0;
            white-space: nowrap;
        }
        .svc-more {
            display: inline-flex; align-items: center;
            padding: 3px 8px; border-radius: 6px;
            font-size: .72rem; font-weight: 700;
            background: #f1f5f9; color: #64748b;
            margin: 1px 0;
        }

        /* Time cell */
        .time-primary {
            font-weight: 700; font-size: .88rem; color: var(--text);
        }
        .time-range {
            display: inline-flex; align-items: center; gap: 5px;
            background: #fef3c7; color: #92400e;
            padding: 3px 10px; border-radius: 6px;
            font-size: .78rem; font-weight: 700;
        }
        .time-over {
            background: #fee2e2; color: #991b1b;
        }

        /* Status dropdown */
        .status-wrap select {
            border-radius: 8px; font-size: .78rem; font-weight: 700;
            padding: 5px 10px; border: 2px solid; cursor: pointer;
            outline: none; transition: box-shadow .2s; min-width: 136px;
            appearance: auto;
        }
        .status-wrap select:focus { box-shadow: 0 0 0 3px rgba(177,0,0,.12); }
        .s-pending    { border-color: #f59e0b !important; color: #92400e !important; background: #fffbeb !important; }
        .s-approved   { border-color: #3b82f6 !important; color: #1d4ed8 !important; background: #eff6ff !important; }
        .s-on_progress{ border-color: #8b5cf6 !important; color: #5b21b6 !important; background: #f5f3ff !important; }
        .s-done       { border-color: #10b981 !important; color: #065f46 !important; background: #ecfdf5 !important; }
        .s-cancelled  { border-color: #ef4444 !important; color: #991b1b !important; background: #fef2f2 !important; }

        /* Action buttons */
        .btn-act {
            width: 32px; height: 32px; border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .82rem; transition: all .18s;
            text-decoration: none; border: 1px solid transparent;
        }
        .btn-act:hover { transform: translateY(-2px); }
        .btn-detail { background:#eff6ff; color:#2563eb; border-color:#bfdbfe; }
        .btn-detail:hover { background:#2563eb; color:#fff; }
        .btn-del    { background:#fef2f2; color:#dc2626; border-color:#fecaca; }
        .btn-del:hover { background:#dc2626; color:#fff; }

        /* WA link */
        .wa-link { font-size:.72rem; color:#16a34a; font-weight:600; text-decoration:none; }
        .wa-link:hover { text-decoration:underline; }

        /* Complaint pill */
        .complaint-pill {
            display:inline-block; max-width:200px;
            overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
            font-size:.72rem; color:#64748b; font-style:italic;
            background:#f8fafc; padding:2px 8px; border-radius:5px;
            border: 1px solid var(--border); vertical-align:middle;
        }

        /* Empty state */
        .empty-state { text-align:center; padding:50px 20px; }
        .empty-state i { font-size:2.5rem; color:#e2e8f0; margin-bottom:12px; display:block; }
        .empty-state p { color:#94a3b8; font-size:.88rem; margin:0; }

        /* Scroll */
        .table-scroll { overflow-x:auto; }

        /* Animations */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(14px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .au  { animation: fadeUp .4s ease both; }
        .d1  { animation-delay:.05s; }
        .d2  { animation-delay:.10s; }
        .d3  { animation-delay:.15s; }
        .d4  { animation-delay:.20s; }
        .d5  { animation-delay:.25s; }
        .d6  { animation-delay:.30s; }

        @media(max-width:576px) {
            .cards-grid { grid-template-columns:1fr 1fr; }
            .card-amount { font-size:1.4rem; }
        }
    </style>

    <main class="bk-wrap">
    <div class="container-xl">

        {{-- ==================== PAGE HEADER ==================== --}}
        <div class="page-header au">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-calendar-check me-2" style="color:var(--honda-red);"></i>Antrian Booking
                </h1>
                <p class="page-subtitle">Kelola jadwal servis — hari ini & mendatang.</p>
            </div>
            <a href="{{ route('booking.walkin') }}" class="btn-walkin">
                <i class="fas fa-user-plus"></i> Booking Walk-In
            </a>
        </div>

        {{-- ==================== SUMMARY CARDS ==================== --}}
        <div class="cards-grid">
            <div class="summary-card card-total au d1">
                <div class="card-icon-wrap"><i class="fas fa-calendar-day"></i></div>
                <div class="card-label">Total Hari Ini</div>
                <div class="card-amount">{{ $totalHariIni }}</div>
                <div class="card-meta">Semua status</div>
            </div>
            <div class="summary-card card-pending au d2">
                <div class="card-icon-wrap"><i class="fas fa-hourglass-half"></i></div>
                <div class="card-label">Menunggu</div>
                <div class="card-amount">{{ $pending }}</div>
                <div class="card-meta">Perlu konfirmasi</div>
            </div>
            <div class="summary-card card-progress au d3">
                <div class="card-icon-wrap"><i class="fas fa-wrench"></i></div>
                <div class="card-label">Dikerjakan</div>
                <div class="card-amount">{{ $onProgress }}</div>
                <div class="card-meta">Sedang di bengkel</div>
            </div>
            <div class="summary-card card-done au d4">
                <div class="card-icon-wrap"><i class="fas fa-flag-checkered"></i></div>
                <div class="card-label">Selesai</div>
                <div class="card-amount">{{ $done }}</div>
                <div class="card-meta">Hari ini</div>
            </div>
            <div class="summary-card card-upcoming au d5">
                <div class="card-icon-wrap"><i class="fas fa-calendar-plus"></i></div>
                <div class="card-label">Mendatang</div>
                <div class="card-amount">{{ $totalMendatang }}</div>
                <div class="card-meta">Besok & seterusnya</div>
            </div>
        </div>

        {{-- ==================== TABEL HARI INI ==================== --}}
        <div class="section-label au d5">
            <div class="table-dot-today"></div>
            <span class="section-label-text">Antrian Hari Ini</span>
            <span class="section-label-badge">{{ date('d M Y') }}</span>
        </div>

        <div class="table-card au d6">
            <div class="table-card-header">
                <div class="table-card-title">
                    <i class="fas fa-list-ol" style="color:var(--honda-red);"></i>
                    Daftar Antrian
                    <span style="font-size:.72rem;background:#f1f5f9;color:#64748b;padding:3px 10px;border-radius:20px;font-weight:700;">
                        {{ $totalHariIni }} booking
                    </span>
                </div>
                <span style="font-size:.75rem;color:#94a3b8;font-weight:500;">
                    <i class="far fa-clock me-1"></i>Update realtime
                </span>
            </div>

            <div class="table-scroll">
                <table class="bk-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:60px;">Antrian</th>
                            <th>Pelanggan & Kendaraan</th>
                            
                            <th>Jadwal</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width:90px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todayBookings as $booking)
                            @include('booking.partials.row_content', ['booking' => $booking, 'isToday' => true])
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-check-circle" style="color:#10b981;"></i>
                                        <p class="fw-bold text-success">Tidak ada antrian hari ini.</p>
                                        <p>Semua pekerjaan selesai atau belum ada booking masuk.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ==================== TABEL MENDATANG ==================== --}}
        <div class="section-label au">
            <div class="table-dot-future"></div>
            <span class="section-label-text">Booking Mendatang</span>
            <span class="section-label-badge" style="background:#f1f5f9;color:#64748b;border-color:#e2e8f0;">
                Besok & seterusnya
            </span>
        </div>

        <div class="table-card au">
            <div class="table-card-header">
                <div class="table-card-title">
                    <i class="fas fa-calendar-week" style="color:#64748b;"></i>
                    Jadwal Mendatang
                    <span style="font-size:.72rem;background:#f1f5f9;color:#64748b;padding:3px 10px;border-radius:20px;font-weight:700;">
                        {{ $upcomingBookings->total() }} booking
                    </span>
                </div>
            </div>

            <div class="table-scroll">
                <table class="bk-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:60px;">#</th>
                            <th>Pelanggan & Kendaraan</th>
                            <th>Layanan</th>
                            <th>Jadwal</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width:90px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $lastDate = null; @endphp
                        @forelse ($upcomingBookings as $booking)
                            @php
                                $currentDate = \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d');
                            @endphp
                            @if ($currentDate !== $lastDate)
                                <tr class="date-group-row">
                                    <td colspan="6">
                                        <i class="far fa-calendar me-2"></i>
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->translatedFormat('l, d F Y') }}
                                    </td>
                                </tr>
                                @php $lastDate = $currentDate; @endphp
                            @endif
                            @include('booking.partials.row_content', ['booking' => $booking, 'isToday' => false])
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-calendar-xmark"></i>
                                        <p>Belum ada booking untuk hari-hari berikutnya.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($upcomingBookings->hasPages())
                <div style="padding:16px 22px; border-top:1px solid var(--border); background:#fff;">
                    <div class="d-flex justify-content-end">
                        {{ $upcomingBookings->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>

    </div>
    </main>

    {{-- ==================== MODAL PEMBATALAN ==================== --}}
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
                <div class="modal-header text-white" style="background:linear-gradient(135deg,var(--honda-red),var(--honda-red-dark));">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-ban me-2"></i>Batalkan Booking
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="cancelForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="cancelled">
                    <div class="modal-body p-4">
                        <div class="mb-3 p-3 rounded-3" style="background:#fff5f5;border:1px solid #fecaca;">
                            <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                            <span class="text-danger fw-semibold small">Tindakan ini akan membatalkan booking pelanggan.</span>
                        </div>
                        <label class="fw-bold small text-uppercase mb-2" style="letter-spacing:.5px;">
                            Alasan Pembatalan <span class="text-danger">*</span>
                        </label>
                        <textarea name="rejection_reason" class="form-control" rows="3" required
                            placeholder="Contoh: Slot penuh, Mekanik tidak tersedia, Sparepart habis..."
                            style="border-radius:10px;font-size:.9rem;"></textarea>
                        <div class="form-text">Alasan ini akan ditampilkan kepada pelanggan.</div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light border fw-semibold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white fw-bold"
                            style="background:linear-gradient(135deg,var(--honda-red),var(--honda-red-dark));border-radius:8px;">
                            <i class="fas fa-check me-1"></i>Konfirmasi Batalkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ==================== SCRIPTS ==================== --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>
    <script>
        function handleStatusChange(selectEl, bookingId, updateUrl) {
            if (selectEl.value === 'cancelled') {
                const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
                document.getElementById('cancelForm').action = updateUrl;
                modal.show();
            } else {
                selectEl.form.submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if (Session::has('success'))
                new Notify({ status:'success', title:'Berhasil', text:'{{ Session::get('success') }}',
                    effect:'slide', speed:300, autoclose:true, autotimeout:3000, position:'right top' });
            @endif
            @if (Session::has('error'))
                new Notify({ status:'error', title:'Gagal', text:'{{ Session::get('error') }}',
                    effect:'slide', speed:300, autoclose:true, autotimeout:5000, position:'right top' });
            @endif
        });
    </script>
@endsection