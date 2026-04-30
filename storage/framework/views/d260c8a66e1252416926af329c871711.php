
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        /* ============================================================
           ROOT & BASE
        ============================================================ */
        :root {
            --honda-red:       #B10000;
            --honda-red-dark:  #8B0000;
            --honda-red-soft:  rgba(177,0,0,.08);
            --navy:            #0f172a;
            --navy-mid:        #1e293b;
            --emerald:         #064e3b;
            --emerald-mid:     #047857;
            --amber:           #78350f;
            --amber-mid:       #b45309;
            --blue-dark:       #1e3a8a;
            --blue-mid:        #1d4ed8;
            --bg:              #f0f2f5;
            --border:          #e2e8f0;
            --text:            #1e293b;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--bg);
            font-family: 'DM Sans', 'Inter', system-ui, sans-serif;
            color: var(--text);
        }

        .db-wrap { padding: 28px 0 48px; }

        /* ============================================================
           PAGE HEADER  (Honda-red gradient hero)
        ============================================================ */
        .page-header {
            background: linear-gradient(135deg, var(--navy) 0%, #16213e 50%, #0f172a 100%);
            border-radius: 20px;
            padding: 30px 36px;
            color: white;
            margin-bottom: 26px;
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute; top: -80px; right: -80px;
            width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(177,0,0,.25) 0%, transparent 70%);
        }
        .page-header::after {
            content: '';
            position: absolute; bottom: -50px; left: 20%;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,.03);
        }

        .header-eyebrow {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(177,0,0,.25); border: 1px solid rgba(177,0,0,.35);
            color: #fca5a5; border-radius: 20px;
            padding: 4px 14px; font-size: .72rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 1.2px;
            margin-bottom: 10px; position: relative; z-index: 1;
        }
        .header-title {
            font-size: 1.75rem; font-weight: 800; margin: 0 0 5px;
            letter-spacing: -.6px; position: relative; z-index: 1;
        }
        .header-sub {
            font-size: .85rem; color: rgba(255,255,255,.5);
            margin: 0; font-weight: 500; position: relative; z-index: 1;
        }
        .header-date {
            font-size: .88rem; font-weight: 700;
            color: rgba(255,255,255,.75); margin-top: 6px;
            position: relative; z-index: 1;
        }
        .header-actions {
            display: flex; gap: 10px; flex-wrap: wrap;
            position: relative; z-index: 1;
        }
        .btn-hdr {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: 10px; font-size: .83rem; font-weight: 700;
            text-decoration: none; transition: all .2s; border: none; cursor: pointer;
        }
        .btn-hdr-red  { background: var(--honda-red); color: #fff; box-shadow: 0 4px 16px rgba(177,0,0,.35); }
        .btn-hdr-red:hover  { background: var(--honda-red-dark); color: #fff; transform: translateY(-2px); }
        .btn-hdr-ghost { background: rgba(255,255,255,.1); color: rgba(255,255,255,.85); border: 1px solid rgba(255,255,255,.18); }
        .btn-hdr-ghost:hover { background: rgba(255,255,255,.18); color: #fff; transform: translateY(-2px); }

        /* live dot */
        .live-dot {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: .72rem; font-weight: 700; color: rgba(255,255,255,.55);
            position: relative; z-index: 1;
        }
        .live-dot::before {
            content: '';
            width: 7px; height: 7px; border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 0 0 rgba(74,222,128,.5);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%   { box-shadow: 0 0 0 0 rgba(74,222,128,.5); }
            70%  { box-shadow: 0 0 0 7px rgba(74,222,128,0); }
            100% { box-shadow: 0 0 0 0 rgba(74,222,128,0); }
        }

        /* ============================================================
           SUMMARY CARDS  (row of 6)
        ============================================================ */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }
        @media(max-width:1200px) { .cards-grid { grid-template-columns: repeat(3, 1fr); } }
        @media(max-width:640px)  { .cards-grid { grid-template-columns: repeat(2, 1fr); } }

        .sc {
            border-radius: 16px; padding: 20px 20px 16px;
            color: #fff; position: relative; overflow: hidden;
            transition: transform .22s, box-shadow .22s;
            cursor: default;
        }
        .sc:hover { transform: translateY(-4px); }
        .sc::before {
            content:''; position:absolute; top:-50px; right:-50px;
            width:160px; height:160px; border-radius:50%;
            background:rgba(255,255,255,.07);
        }
        .sc::after {
            content:''; position:absolute; bottom:-35px; left:-25px;
            width:120px; height:120px; border-radius:50%;
            background:rgba(255,255,255,.04);
        }

        .sc-navy   { background: linear-gradient(140deg, #0f172a 0%, #1e293b 100%); box-shadow: 0 6px 24px rgba(15,23,42,.3); }
        .sc-amber  { background: linear-gradient(140deg, #78350f 0%, #b45309 100%); box-shadow: 0 6px 24px rgba(120,53,15,.3); }
        .sc-blue   { background: linear-gradient(140deg, #1e3a8a 0%, #1d4ed8 100%); box-shadow: 0 6px 24px rgba(30,58,138,.3); }
        .sc-green  { background: linear-gradient(140deg, #064e3b 0%, #047857 100%); box-shadow: 0 6px 24px rgba(6,78,59,.3); }
        .sc-teal   { background: linear-gradient(140deg, #134e4a 0%, #0f766e 100%); box-shadow: 0 6px 24px rgba(19,78,74,.3); }
        .sc-red    { background: linear-gradient(140deg, #4c0519 0%, #B10000 100%); box-shadow: 0 6px 24px rgba(177,0,0,.32); }

        .sc-icon { width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size:.95rem; margin-bottom:12px; position:relative; z-index:1; }
        .sc-label { font-size:.65rem; font-weight:800; text-transform:uppercase; letter-spacing:1.1px; color:rgba(255,255,255,.55); margin-bottom:3px; position:relative; z-index:1; }
        .sc-val   { font-size:1.65rem; font-weight:800; color:#fff; line-height:1; letter-spacing:-1px; position:relative; z-index:1; }
        .sc-val.sm { font-size:1.05rem; letter-spacing:-.2px; }
        .sc-sub   { font-size:.65rem; color:rgba(255,255,255,.45); margin-top:5px; position:relative; z-index:1; font-weight:500; }
        .sc-link  { display:inline-block; font-size:.65rem; font-weight:800; color:rgba(255,255,255,.65); text-decoration:none; margin-top:5px; position:relative; z-index:1; }
        .sc-link:hover { color:#fff; }

        /* ============================================================
           TWO-COLUMN LAYOUT
        ============================================================ */
        .db-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 18px;
            margin-bottom: 20px;
        }
        @media(max-width:1100px) { .db-grid { grid-template-columns: 1fr; } }

        .side-col { display: flex; flex-direction: column; gap: 18px; }

        /* ============================================================
           PANEL (white card)
        ============================================================ */
        .panel {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 14px rgba(0,0,0,.05);
            overflow: hidden;
        }
        .panel-hdr {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 22px; border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap; gap: 8px;
        }
        .panel-title {
            font-size: .88rem; font-weight: 800; color: var(--text);
            display: flex; align-items: center; gap: 8px;
        }
        .panel-badge {
            font-size: .66rem; background: #f1f5f9; color: #64748b;
            padding: 2px 9px; border-radius: 20px; font-weight: 700;
        }
        .panel-badge-red {
            font-size: .66rem; background: var(--honda-red-soft); color: var(--honda-red);
            border: 1px solid rgba(177,0,0,.18);
            padding: 2px 9px; border-radius: 20px; font-weight: 700;
        }
        .panel-link {
            font-size: .76rem; color: var(--honda-red); font-weight: 700; text-decoration: none;
        }
        .panel-link:hover { text-decoration: underline; }

        /* ============================================================
           CHART
        ============================================================ */
        .chart-body { padding: 18px 22px 22px; }

        /* ============================================================
           QUEUE TABLE (antrian mini)
        ============================================================ */
        .q-table { width: 100%; border-collapse: collapse; }
        .q-table thead th {
            padding: 9px 14px; font-size: .66rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: .7px;
            color: #94a3b8; background: #f8fafc;
            border-bottom: 1px solid var(--border); white-space: nowrap;
        }
        .q-table tbody tr { border-bottom: 1px solid #f8fafc; transition: background .15s; }
        .q-table tbody tr:last-child { border-bottom: none; }
        .q-table tbody tr:hover { background: #fafafa; }
        .q-table tbody td { padding: 11px 14px; font-size: .82rem; vertical-align: middle; }

        .q-badge {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--honda-red-soft);
            color: var(--honda-red); border: 2px solid rgba(177,0,0,.22);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: .85rem; margin: 0 auto;
        }
        .q-plate {
            font-family: 'Courier New', monospace; font-weight: 800; font-size: .72rem;
            background: var(--navy); color: #fff;
            padding: 2px 6px; border-radius: 4px; letter-spacing: .5px;
        }
        .q-name { font-weight: 700; font-size: .83rem; color: var(--text); }
        .q-type { font-size: .7rem; color: #64748b; font-weight: 500; }

        /* status pills */
        .sp { display:inline-flex; align-items:center; gap:4px; padding:4px 9px; border-radius:7px; font-size:.68rem; font-weight:800; white-space:nowrap; }
        .sp-pending    { background:#fffbeb; color:#92400e; border:1.5px solid #f59e0b; }
        .sp-approved   { background:#eff6ff; color:#1d4ed8; border:1.5px solid #3b82f6; }
        .sp-on_progress{ background:#f5f3ff; color:#5b21b6; border:1.5px solid #8b5cf6; }
        .sp-done       { background:#ecfdf5; color:#065f46; border:1.5px solid #10b981; }
        .sp-cancelled  { background:#fef2f2; color:#991b1b; border:1.5px solid #ef4444; }

        /* ============================================================
           QUICK ACTIONS
        ============================================================ */
        .qa-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 16px; }
        .qa-btn {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 8px; padding: 16px 10px; border-radius: 12px;
            font-weight: 800; font-size: .75rem; text-decoration: none;
            transition: all .2s; text-align: center;
            border: 1.5px solid var(--border); color: var(--text); background: #fff;
        }
        .qa-btn i { font-size: 1.25rem; }
        .qa-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
        .qa-red   { border-color: rgba(177,0,0,.2); background: var(--honda-red-soft); color: var(--honda-red); }
        .qa-red:hover   { background: var(--honda-red); color: #fff; }
        .qa-blue  { border-color: #bfdbfe; background: #eff6ff; color: #1d4ed8; }
        .qa-blue:hover  { background: #1d4ed8; color: #fff; }
        .qa-green { border-color: #a7f3d0; background: #ecfdf5; color: #065f46; }
        .qa-green:hover { background: #065f46; color: #fff; }
        .qa-amber { border-color: #fcd34d; background: #fffbeb; color: #92400e; }
        .qa-amber:hover { background: #92400e; color: #fff; }

        /* ============================================================
           BOTTOM ROW: 3 panels
        ============================================================ */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 18px;
            margin-top: 0;
        }
        @media(max-width:900px) { .bottom-grid { grid-template-columns: 1fr; } }

        /* ============================================================
           TOP CUSTOMERS
        ============================================================ */
        .tc-list { padding: 4px 20px 8px; }
        .tc-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 0; border-bottom: 1px solid #f8fafc;
        }
        .tc-item:last-child { border-bottom: none; }
        .tc-rank {
            width: 24px; height: 24px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .68rem; font-weight: 800; flex-shrink: 0;
        }
        .tr-1 { background: #fef3c7; color: #92400e; }
        .tr-2 { background: #f1f5f9; color: #475569; }
        .tr-3 { background: #fff7ed; color: #c2410c; }
        .tr-n { background: #f8fafc; color: #94a3b8; }
        .tc-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, var(--honda-red), var(--honda-red-dark));
            display: flex; align-items: center; justify-content: center;
            font-size: .82rem; color: white; font-weight: 800; flex-shrink: 0;
        }
        .tc-info { flex: 1; min-width: 0; }
        .tc-name { font-weight: 700; font-size: .83rem; color: var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .tc-wa   { font-size: .68rem; color: #64748b; font-weight: 500; margin-top:1px; }
        .tc-count {
            font-weight: 800; font-size: .9rem; color: var(--honda-red);
            flex-shrink: 0; white-space: nowrap;
            font-family: 'Courier New', monospace;
        }

        /* ============================================================
           LOW STOCK
        ============================================================ */
        .ls-list { padding: 4px 20px 8px; }
        .ls-item {
            display: flex; align-items: center; justify-content: space-between;
            gap: 10px; padding: 10px 0; border-bottom: 1px solid #f8fafc;
        }
        .ls-item:last-child { border-bottom: none; }
        .ls-left { flex: 1; min-width: 0; }
        .ls-name { font-weight: 700; font-size: .82rem; color: var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .ls-price { font-size: .68rem; color: #94a3b8; font-weight: 500; margin-top: 1px; }
        .ls-badge-red  { background:#fee2e2; color:#991b1b; padding:4px 9px; border-radius:7px; font-size:.7rem; font-weight:800; white-space:nowrap; flex-shrink:0; }
        .ls-badge-warn { background:#fef3c7; color:#92400e; padding:4px 9px; border-radius:7px; font-size:.7rem; font-weight:800; white-space:nowrap; flex-shrink:0; }

        /* ============================================================
           POPULAR SERVICES
        ============================================================ */
        .svc-list { padding: 6px 22px 12px; }
        .svc-item { padding: 9px 0; border-bottom: 1px solid #f8fafc; }
        .svc-item:last-child { border-bottom: none; }
        .svc-row  { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
        .svc-name { font-weight: 700; font-size: .82rem; color: var(--text); }
        .svc-cnt  { font-weight: 800; font-size: .78rem; color: var(--honda-red); font-family: 'Courier New', monospace; }
        .svc-track { height: 5px; background: #f1f5f9; border-radius: 10px; overflow: hidden; }
        .svc-fill  { height: 100%; border-radius: 10px; background: linear-gradient(to right, var(--honda-red), var(--honda-red-dark)); transition: width .6s ease; }

        /* ============================================================
           EMPTY STATE
        ============================================================ */
        .empty-box { text-align: center; padding: 40px 20px; }
        .empty-box i { font-size: 2rem; color: #e2e8f0; margin-bottom: 10px; display: block; }
        .empty-box p { color: #94a3b8; font-size: .85rem; margin: 0; }

        /* ============================================================
           ANIMATIONS
        ============================================================ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .au  { animation: fadeUp .45s ease both; }
        .d1  { animation-delay: .04s; } .d2  { animation-delay: .08s; }
        .d3  { animation-delay: .12s; } .d4  { animation-delay: .16s; }
        .d5  { animation-delay: .20s; } .d6  { animation-delay: .24s; }
        .d7  { animation-delay: .28s; } .d8  { animation-delay: .32s; }
    </style>

    <main class="db-wrap">
    <div class="container-xl">

        
        <div class="page-header au">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-4">
                <div>
                    <div class="header-eyebrow">
                        Admin Panel
                    </div>
                    <h1 class="header-title">Dashboard Operasional</h1>
                    <p class="header-sub">Pantau seluruh aktivitas bengkel secara real-time.</p>
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div class="header-date">
                            <i class="far fa-calendar me-1"></i>
                            <?php echo e(\Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y')); ?>

                        </div>
                        <div class="live-dot">Live</div>
                    </div>
                </div>
                <div class="header-actions align-self-center">
                    <a href="<?php echo e(route('booking.walkin')); ?>" class="btn-hdr btn-hdr-red">
                        <i class="fas fa-user-plus"></i> Walk-In
                    </a>
                    <a href="<?php echo e(route('advisor.create')); ?>" class="btn-hdr btn-hdr-ghost">
                        <i class="fas fa-wrench"></i> Proses Service
                    </a>
                    <a href="<?php echo e(route('booking.index')); ?>" class="btn-hdr btn-hdr-ghost">
                        <i class="fas fa-list"></i> Semua Booking
                    </a>
                </div>
            </div>
        </div>

        
        <div class="cards-grid">
            <div class="sc sc-navy au d1">
                <div class="sc-icon"><i class="fas fa-calendar-day"></i></div>
                <div class="sc-label">Booking Hari Ini</div>
                <div class="sc-val"><?php echo e($totalBookingsToday); ?></div>
                <div class="sc-sub">Semua status</div>
                <a href="<?php echo e(route('booking.index')); ?>" class="sc-link">Lihat detail</a>
            </div>

            <div class="sc sc-amber au d2">
                <div class="sc-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="sc-label">Antrian Aktif</div>
                <div class="sc-val"><?php echo e($pendingBookings); ?></div>
                <div class="sc-sub">Pending + proses</div>
                <a href="<?php echo e(route('booking.index')); ?>" class="sc-link">Kelola</a>
            </div>

            <div class="sc sc-blue au d3">
                <div class="sc-icon"><i class="fas fa-users"></i></div>
                <div class="sc-label">Customer</div>
                <div class="sc-val"><?php echo e($registeredCustomers); ?></div>
                <div class="sc-sub">Terdaftar</div>
                <a href="<?php echo e(route('customers.index')); ?>" class="sc-link">Lihat</a>
            </div>

            <div class="sc sc-green au d4">
                <div class="sc-icon"><i class="fas fa-flag-checkered"></i></div>
                <div class="sc-label">Selesai Bulan Ini</div>
                <div class="sc-val"><?php echo e($doneThisMonth); ?></div>
                <div class="sc-sub">Service tuntas</div>
                <a href="<?php echo e(route('advisor.index')); ?>" class="sc-link">Riwayat</a>
            </div>

            <div class="sc sc-teal au d5">
                <div class="sc-icon"><i class="fas fa-arrow-trend-up"></i></div>
                <div class="sc-label">Pemasukan Bulan Ini</div>
                <div class="sc-val sm">Rp&nbsp;<?php echo e(number_format($revenueThisMonth, 0, ',', '.')); ?></div>
                <div class="sc-sub">Service selesai</div>
                <a href="<?php echo e(route('keuangan.index')); ?>" class="sc-link">Keuangan</a>
            </div>

            <div class="sc sc-red au d6">
                <div class="sc-icon"><i class="fas fa-triangle-exclamation"></i></div>
                <div class="sc-label">Stok Menipis</div>
                <div class="sc-val"><?php echo e($lowStockCount); ?></div>
                <div class="sc-sub">Item 6 unit</div>
                <a href="<?php echo e(route('inventory.index')); ?>" class="sc-link">Cek inventory</a>
            </div>
        </div>

        
        <div class="db-grid au d4">

            
            <div class="panel">
                <div class="panel-hdr">
                    <div class="panel-title">
                        <i class="fas fa-chart-area" style="color:var(--honda-red);"></i>
                        Tren Booking & Service Selesai
                        <span class="panel-badge">7 Hari Terakhir</span>
                    </div>
                    <span style="font-size:.72rem;color:#94a3b8;font-weight:600;">
                        <i class="far fa-clock me-1"></i>Update otomatis
                    </span>
                </div>
                <div class="chart-body">
                    <canvas id="trendChart" height="130"></canvas>
                </div>
            </div>

            
            <div class="side-col">

                
                <div class="panel">
                    <div class="panel-hdr">
                        <div class="panel-title"><i class="fas fa-bolt" style="color:var(--honda-red);"></i> Aksi Cepat</div>
                    </div>
                    <div class="qa-grid">
                        <a href="<?php echo e(route('booking.walkin')); ?>" class="qa-btn qa-red">
                            <i class="fas fa-user-plus"></i> Walk-In
                        </a>
                        <a href="<?php echo e(route('advisor.create')); ?>" class="qa-btn qa-blue">
                            <i class="fas fa-wrench"></i> Proses Service
                        </a>
                        <a href="<?php echo e(route('inventory.index')); ?>" class="qa-btn qa-green">
                            <i class="fas fa-box-open"></i> Tambah Stok
                        </a>
                        <a href="<?php echo e(route('keuangan.index')); ?>" class="qa-btn qa-amber">
                            <i class="fas fa-wallet"></i> Keuangan
                        </a>
                    </div>
                </div>

                
                <div class="panel">
                    <div class="panel-hdr">
                        <div class="panel-title">
                            <i class="fas fa-star" style="color:#f59e0b;"></i>
                            Layanan Terpopuler
                        </div>
                        <span class="panel-badge">All time</span>
                    </div>
                    <div class="svc-list">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php $maxVal = $topServices->first()?->total ?? 1; ?>
                            <?php $pct = $maxVal > 0 ? round(($svc->total / $maxVal) * 100) : 0; ?>
                            <div class="svc-item">
                                <div class="svc-row">
                                    <span class="svc-name"><?php echo e($svc->name); ?></span>
                                    <span class="svc-cnt"><?php echo e($svc->total); ?></span>
                                </div>
                                <div class="svc-track">
                                    <div class="svc-fill" style="width:<?php echo e($pct); ?>%;"></div>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <div class="empty-box"><i class="fas fa-star"></i><p>Belum ada data.</p></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        
        <div class="bottom-grid au d6">

            
            <div class="panel">
                <div class="panel-hdr">
                    <div class="panel-title">
                        <i class="fas fa-trophy" style="color:#f59e0b;"></i>
                        Pelanggan Setia
                        <span class="panel-badge">Paling sering service</span>
                    </div>
                    <a href="<?php echo e(route('customers.index')); ?>" class="panel-link">Lihat semua</a>
                </div>
                <div class="tc-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="tc-item">
                            <div class="tc-rank <?php echo e($i === 0 ? 'tr-1' : ($i === 1 ? 'tr-2' : ($i === 2 ? 'tr-3' : 'tr-n'))); ?>">
                                <?php echo e($i + 1); ?>

                            </div>
                            <div class="tc-avatar"><?php echo e(strtoupper(substr($cust->customer_name ?? 'X', 0, 1))); ?></div>
                            <div class="tc-info">
                                <div class="tc-name"><?php echo e($cust->customer_name); ?></div>
                                <div class="tc-wa">
                                    <i class="fab fa-whatsapp text-success me-1"></i>
                                    <?php echo e($cust->customer_whatsapp ?? '-'); ?>

                                </div>
                            </div>
                            <div class="tc-count"><?php echo e($cust->total); ?></div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="empty-box"><i class="fas fa-users"></i><p>Belum ada data.</p></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="panel">
                <div class="panel-hdr">
                    <div class="panel-title">
                        <i class="fas fa-triangle-exclamation" style="color:#ef4444;"></i>
                        Stok Perlu Restock
                    </div>
                    <a href="<?php echo e(route('inventory.index')); ?>" class="panel-link">Kelola</a>
                </div>
                <div class="ls-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $lowStockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="ls-item">
                            <div class="ls-left">
                                <div class="ls-name"><?php echo e($item->nama_barang); ?></div>
                                <div class="ls-price">Jual: Rp <?php echo e(number_format($item->harga_jual, 0, ',', '.')); ?></div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->jumlah_barang == 0): ?>
                                <span class="ls-badge-red"><i class="fas fa-times me-1"></i>HABIS</span>
                            <?php elseif($item->jumlah_barang <= 3): ?>
                                <span class="ls-badge-red"><?php echo e($item->jumlah_barang); ?> unit</span>
                            <?php else: ?>
                                <span class="ls-badge-warn"><?php echo e($item->jumlah_barang); ?> unit</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="empty-box">
                            <i class="fas fa-check-circle" style="color:#10b981;"></i>
                            <p class="fw-bold" style="color:#10b981;">Semua stok aman!</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="panel">
                <div class="panel-hdr">
                    <div class="panel-title">
                        <i class="fas fa-list-ol" style="color:var(--honda-red);"></i>
                        Antrian Hari Ini
                        <span class="panel-badge-red"><?php echo e($queueBookings->count()); ?> aktif</span>
                    </div>
                    <a href="<?php echo e(route('booking.index')); ?>" class="panel-link">Kelola semua</a>
                </div>
                <div style="overflow-x:auto;">
                    <table class="q-table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Pelanggan</th>
                                <th>Jam</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $queueBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php
                                    $pillClass = match($booking->status) {
                                        'pending'     => 'sp-pending',
                                        'approved'    => 'sp-approved',
                                        'on_progress' => 'sp-on_progress',
                                        'done'        => 'sp-done',
                                        default       => 'sp-cancelled',
                                    };
                                    $pillLabel = match($booking->status) {
                                        'pending'     => 'Menunggu',
                                        'approved'    => 'Diterima',
                                        'on_progress' => 'Dikerjakan',
                                        'done'        => 'Selesai',
                                        default       => 'Batal',
                                    };
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="q-badge"><?php echo e($booking->queue_number); ?></div>
                                    </td>
                                    <td>
                                        <div class="q-name"><?php echo e(Str::limit($booking->customer_name, 15)); ?></div>
                                        <div class="mt-1">
                                            <span class="q-plate"><?php echo e(strtoupper($booking->plate_number)); ?></span>
                                            <span class="q-type ms-1"><?php echo e(ucfirst($booking->vehicle_type)); ?></span>
                                        </div>
                                    </td>
                                    <td style="font-size:.76rem;font-weight:700;color:#64748b;white-space:nowrap;">
                                        <i class="far fa-clock me-1"></i><?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('H:i')); ?>

                                    </td>
                                    <td class="text-center">
                                        <span class="sp <?php echo e($pillClass); ?>"><?php echo e($pillLabel); ?></span>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-box">
                                            <i class="fas fa-check-circle" style="color:#10b981;"></i>
                                            <p style="color:#10b981;font-weight:700;">Tidak ada antrian aktif.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
    </main>

    
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>
    <script>
    // ---- TREND CHART ----
    (function () {
        const labels  = <?php echo json_encode($chartLabels, 15, 512) ?>;
        const booking = <?php echo json_encode($chartBooking, 15, 512) ?>;
        const selesai = <?php echo json_encode($chartDone, 15, 512) ?>;

        const ctx = document.getElementById('trendChart').getContext('2d');

        // Gradients
        const gRed = ctx.createLinearGradient(0, 0, 0, 280);
        gRed.addColorStop(0, 'rgba(177,0,0,.18)');
        gRed.addColorStop(1, 'rgba(177,0,0,0)');

        const gGreen = ctx.createLinearGradient(0, 0, 0, 280);
        gGreen.addColorStop(0, 'rgba(16,185,129,.15)');
        gGreen.addColorStop(1, 'rgba(16,185,129,0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Booking Masuk',
                        data: booking,
                        borderColor: '#B10000',
                        backgroundColor: gRed,
                        borderWidth: 2.5,
                        fill: true,
                        tension: .4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#B10000',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Service Selesai',
                        data: selesai,
                        borderColor: '#10b981',
                        backgroundColor: gGreen,
                        borderWidth: 2.5,
                        fill: true,
                        tension: .4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            font: { size: 11, weight: '700' },
                            usePointStyle: true,
                            pointStyleWidth: 8,
                            padding: 16,
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 12, weight: '700' },
                        bodyFont: { size: 12 },
                        padding: 14,
                        cornerRadius: 10,
                        displayColors: true,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: '600' }, color: '#94a3b8' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, font: { size: 10 }, color: '#94a3b8' },
                        grid: { color: '#f1f5f9', lineWidth: 1 }
                    }
                }
            }
        });
    })();

    // ---- NOTIFICATIONS ----
    document.addEventListener('DOMContentLoaded', function () {
        <?php if(Session::has('success')): ?>
            new Notify({ status:'success', title:'Berhasil', text:'<?php echo e(Session::get('success')); ?>',
                effect:'slide', speed:300, autoclose:true, autotimeout:3500, position:'right top' });
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
            new Notify({ status:'error', title:'Gagal', text:'<?php echo e(Session::get('error')); ?>',
                effect:'slide', speed:300, autoclose:true, autotimeout:5000, position:'right top' });
        <?php endif; ?>
    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Downloads\upj_tsm_k9\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>