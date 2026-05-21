
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">

    <?php
        $today = date('Y-m-d');
        $totalHariIni = $todayBookings->count();
        $pending = $todayBookings->where('status', 'pending')->count();
        $onProgress = $todayBookings->where('status', 'on_progress')->count();
        $done = $todayBookings->where('status', 'done')->count();
        $totalMendatang = $upcomingBookings->total();
    ?>

    <style>
        /* ==============================
               ROOT & BASE (Updated to match Dashboard)
            ============================== */
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
            --bg:              #f0f2f5;
            --border:          #e2e8f0;
            --text:            #1e293b;
        }

        body {
            background: var(--bg);
            font-family: 'DM Sans', 'Inter', system-ui, sans-serif;
            color: var(--text);
        }

        .bk-wrap { padding: 28px 0 48px; }

        /* ============================================================
           PAGE HEADER (Consistent with Dashboard)
        ============================================================ */
        .page-header {
            background: linear-gradient(135deg, var(--navy) 0%, #16213e 50%, #0f172a 100%);
            border-radius: 20px;
            padding: 30px 36px;
            color: white;
            margin-bottom: 28px;
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
            color: #fff;
        }
        .header-sub {
            font-size: .85rem; color: rgba(255,255,255,.5);
            margin: 0; font-weight: 500; position: relative; z-index: 1;
        }
        .header-actions {
            display: flex; gap: 10px; flex-wrap: wrap;
            position: relative; z-index: 1;
        }
        .btn-hdr-red {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: 10px; font-size: .83rem; font-weight: 700;
            text-decoration: none; transition: all .2s; border: none; cursor: pointer;
            background: var(--honda-red); color: #fff; box-shadow: 0 4px 16px rgba(177,0,0,.35);
        }
        .btn-hdr-red:hover { background: var(--honda-red-dark); color: #fff; transform: translateY(-2px); }

        /* Sisanya (Summary Cards, Table, dll) tetap seperti kode lama Anda */
        /* ==============================
               SUMMARY CARDS
            ============================== */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .summary-card {
            border-radius: 16px;
            padding: 20px 22px;
            color: #fff;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(0, 0, 0, .14);
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
        }

        .summary-card::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -20px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
        }

        .card-total {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
            box-shadow: 0 6px 24px rgba(15, 23, 42, .28);
        }

        .card-pending {
            background: linear-gradient(135deg, #78350f 0%, var(--amber-mid) 100%);
            box-shadow: 0 6px 24px rgba(120, 53, 15, .28);
        }

        .card-progress {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
            box-shadow: 0 6px 24px rgba(30, 58, 138, .28);
        }

        .card-done {
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-mid) 100%);
            box-shadow: 0 6px 24px rgba(6, 78, 59, .28);
        }

        .card-upcoming {
            background: linear-gradient(135deg, #4c0519 0%, var(--honda-red) 100%);
            box-shadow: 0 6px 24px rgba(177, 0, 0, .28);
        }

        .card-icon-wrap {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .14);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #fff;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .card-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, .58);
            margin-bottom: 4px;
            position: relative;
            z-index: 1;
        }

        .card-amount {
            font-size: 1.75rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            letter-spacing: -1px;
            position: relative;
            z-index: 1;
        }

        .card-meta {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, .5);
            margin-top: 6px;
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        /* ==============================
               SECTION DIVIDER
            ============================== */
        .section-label {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .section-label-text {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text);
        }

        .section-label-badge {
            font-size: 0.7rem;
            background: var(--honda-red-soft);
            color: var(--honda-red);
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            border: 1px solid rgba(177, 0, 0, .15);
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
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
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
            margin-bottom: 32px;
        }

        .table-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 10px;
        }

        .table-card-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-dot-today {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--honda-red);
            flex-shrink: 0;
            box-shadow: 0 0 0 3px rgba(177, 0, 0, .15);
        }

        .table-dot-future {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #94a3b8;
            flex-shrink: 0;
        }

        /* Table */
        .bk-table {
            width: 100%;
            border-collapse: collapse;
        }

        .bk-table thead th {
            padding: 11px 18px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: #94a3b8;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .bk-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background .15s;
        }

        .bk-table tbody tr:last-child {
            border-bottom: none;
        }

        .bk-table tbody tr:hover {
            background: #fafafa;
        }

        .bk-table tbody td {
            padding: 14px 18px;
            font-size: .875rem;
            vertical-align: middle;
        }

        /* Date group row */
        .date-group-row td {
            background: #f8fafc;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .7px;
            padding: 8px 18px;
            border-top: 1px solid var(--border);
        }

        /* Queue badge */
        .queue-badge {
            width: 38px;
            height: 38px;
            background: var(--honda-red-soft);
            color: var(--honda-red);
            border: 2px solid rgba(177, 0, 0, .25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1rem;
            margin: 0 auto;
        }

        .queue-num-plain {
            font-weight: 700;
            color: #94a3b8;
            font-size: .9rem;
        }

        /* Customer info */
        .cust-name {
            font-weight: 700;
            color: var(--text);
            margin-bottom: 2px;
        }

        .cust-plate {
            display: inline-block;
            font-family: 'Consolas', monospace;
            font-weight: 800;
            font-size: .8rem;
            background: var(--navy);
            color: #fff;
            padding: 2px 8px;
            border-radius: 5px;
            margin-right: 4px;
        }

        .cust-type {
            font-size: .75rem;
            color: #64748b;
            font-weight: 600;
        }

        /* Service badges */
        .svc-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: .72rem;
            font-weight: 700;
            background: #eff6ff;
            color: #1d4ed8;
            margin: 1px 2px 1px 0;
            white-space: nowrap;
        }

        .svc-more {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: .72rem;
            font-weight: 700;
            background: #f1f5f9;
            color: #64748b;
            margin: 1px 0;
        }

        /* Time cell */
        .time-primary {
            font-weight: 700;
            font-size: .88rem;
            color: var(--text);
        }

        .time-range {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #fef3c7;
            color: #92400e;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: .78rem;
            font-weight: 700;
        }

        .time-over {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Status dropdown */
        .status-wrap select {
            border-radius: 8px;
            font-size: .78rem;
            font-weight: 700;
            padding: 5px 10px;
            border: 2px solid;
            cursor: pointer;
            outline: none;
            transition: box-shadow .2s;
            min-width: 136px;
            appearance: auto;
        }

        .status-wrap select:focus {
            box-shadow: 0 0 0 3px rgba(177, 0, 0, .12);
        }

        .s-pending {
            border-color: #f59e0b !important;
            color: #92400e !important;
            background: #fffbeb !important;
        }

        .s-approved {
            border-color: #3b82f6 !important;
            color: #1d4ed8 !important;
            background: #eff6ff !important;
        }

        .s-on_progress {
            border-color: #8b5cf6 !important;
            color: #5b21b6 !important;
            background: #f5f3ff !important;
        }

        .s-done {
            border-color: #10b981 !important;
            color: #065f46 !important;
            background: #ecfdf5 !important;
        }

        .s-cancelled {
            border-color: #ef4444 !important;
            color: #991b1b !important;
            background: #fef2f2 !important;
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

        .btn-detail {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .btn-detail:hover {
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

        /* WA link */
        .wa-link {
            font-size: .72rem;
            color: #16a34a;
            font-weight: 600;
            text-decoration: none;
        }

        .wa-link:hover {
            text-decoration: underline;
        }

        /* Complaint pill */
        .complaint-pill {
            display: inline-block;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: .72rem;
            color: #64748b;
            font-style: italic;
            background: #f8fafc;
            padding: 2px 8px;
            border-radius: 5px;
            border: 1px solid var(--border);
            vertical-align: middle;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
        }

        .empty-state i {
            font-size: 2.5rem;
            color: #e2e8f0;
            margin-bottom: 12px;
            display: block;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: .88rem;
            margin: 0;
        }

        /* Scroll */
        .table-scroll {
            overflow-x: auto;
        }

        /* Animations */
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

        @media(max-width:576px) {
            .cards-grid {
                grid-template-columns: 1fr 1fr;
            }

            .card-amount {
                font-size: 1.4rem;
            }
        }
    </style>

    <main class="bk-wrap">
        <div class="container-xl">

            
            <div class="page-header au">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-4">
                    <div>
                        <div class="header-eyebrow">
                            Operational
                        </div>
                        <h1 class="header-title">Antrian Booking</h1>
                        <p class="header-sub">Kelola jadwal servis — hari ini & mendatang secara real-time.</p>
                    </div>
                    <div class="header-actions align-self-center">
                        <a href="<?php echo e(route('booking.walkin')); ?>" class="btn-hdr-red">
                            <i class="fas fa-user-plus"></i> Booking Walk-In
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="cards-grid">
                <div class="summary-card card-total au d1">
                    <div class="card-icon-wrap"><i class="fas fa-calendar-day"></i></div>
                    <div class="card-label">Total Hari Ini</div>
                    <div class="card-amount"><?php echo e($totalHariIni); ?></div>
                    <div class="card-meta">Semua status</div>
                </div>
                <div class="summary-card card-pending au d2">
                    <div class="card-icon-wrap"><i class="fas fa-hourglass-half"></i></div>
                    <div class="card-label">Menunggu</div>
                    <div class="card-amount"><?php echo e($pending); ?></div>
                    <div class="card-meta">Perlu konfirmasi</div>
                </div>
                <div class="summary-card card-progress au d3">
                    <div class="card-icon-wrap"><i class="fas fa-wrench"></i></div>
                    <div class="card-label">Dikerjakan</div>
                    <div class="card-amount"><?php echo e($onProgress); ?></div>
                    <div class="card-meta">Sedang di bengkel</div>
                </div>
                <div class="summary-card card-done au d4">
                    <div class="card-icon-wrap"><i class="fas fa-flag-checkered"></i></div>
                    <div class="card-label">Selesai</div>
                    <div class="card-amount"><?php echo e($done); ?></div>
                    <div class="card-meta">Hari ini</div>
                </div>
                <div class="summary-card card-upcoming au d5">
                    <div class="card-icon-wrap"><i class="fas fa-calendar-plus"></i></div>
                    <div class="card-label">Mendatang</div>
                    <div class="card-amount"><?php echo e($totalMendatang); ?></div>
                    <div class="card-meta">Besok & seterusnya</div>
                </div>
            </div>

            
            <div class="section-label au d5">
                <div class="table-dot-today"></div>
                <span class="section-label-text">Antrian Hari Ini</span>
            </div>

            <div class="table-card au d6">
                <div class="table-card-header">
                    <div class="table-card-title">
                        <i class="fas fa-list-ol" style="color:var(--honda-red);"></i>
                        Daftar Antrian
                        <span
                            style="font-size:.72rem;background:#f1f5f9;color:#64748b;padding:3px 10px;border-radius:20px;font-weight:700;">
                            <?php echo e($totalHariIni); ?> booking
                        </span>
                    </div>
                    <span style="font-size:.75rem;color:#94a3b8;font-weight:500;"><?php echo e(date('d M Y')); ?></span>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $todayBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php echo $__env->make('booking.partials.row_content', ['booking' => $booking, 'isToday' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-check-circle" style="color:#10b981;"></i>
                                            <p class="fw-bold text-success">Tidak ada antrian hari ini.</p>
                                            <p>Semua pekerjaan selesai atau belum ada booking masuk.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="section-label au">
                <div class="table-dot-future"></div>
                <span class="section-label-text">Booking Mendatang</span>
            </div>

            <div class="table-card au">
                <div class="table-card-header">
                    <div class="table-card-title">
                        <i class="fas fa-calendar-week" style="color:#64748b;"></i>
                        Jadwal Mendatang
                        <span
                            style="font-size:.72rem;background:#f1f5f9;color:#64748b;padding:3px 10px;border-radius:20px;font-weight:700;">
                            <?php echo e($upcomingBookings->total()); ?> booking
                        </span>
                    </div>
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
                            <?php $lastDate = null; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $upcomingBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php
                                    $currentDate = \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d');
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentDate !== $lastDate): ?>
                                    <tr class="date-group-row">
                                        <td colspan="6">
                                            <i class="far fa-calendar me-2"></i>
                                            <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->locale('id')->translatedFormat('l, d F Y')); ?>

                                        </td>
                                    </tr>
                                    <?php $lastDate = $currentDate; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php echo $__env->make('booking.partials.row_content', ['booking' => $booking, 'isToday' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-xmark"></i>
                                            <p>Belum ada booking untuk hari-hari berikutnya.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcomingBookings->hasPages()): ?>
                    <div style="padding:16px 22px; border-top:1px solid var(--border); background:#fff;">
                        <div class="d-flex justify-content-end">
                            <?php echo e($upcomingBookings->links('pagination::bootstrap-5')); ?>

                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

        </div>
    </main>

    
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
                <div class="modal-header text-white"
                    style="background:linear-gradient(135deg,var(--honda-red),var(--honda-red-dark));">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-ban me-2"></i>Batalkan Booking
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="cancelForm" action="" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="status" value="cancelled">
                    <div class="modal-body p-4">
                        <div class="mb-3 p-3 rounded-3" style="background:#fff5f5;border:1px solid #fecaca;">
                            <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                            <span class="text-danger fw-semibold small">Tindakan ini akan membatalkan booking
                                pelanggan.</span>
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
                        <button type="button" class="btn btn-light border fw-semibold"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white fw-bold"
                            style="background:linear-gradient(135deg,var(--honda-red),var(--honda-red-dark));border-radius:8px;">
                            <i class="fas fa-check me-1"></i>Konfirmasi Batalkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius:16px; overflow:hidden;">
                <div class="modal-header bg-white border-bottom-0 pt-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                        <h5 class="fw-bold mb-0" style="color: #334155;">Detail Layanan Booking</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; background: #f8fafc;">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-list-ul text-danger me-2"></i>
                                <span class="fw-bold text-secondary" style="font-size: 0.8rem;">RINCIAN PAKET / LAYANAN</span>
                            </div>
                        </div>
                        <div class="card-body p-0 bg-white">
                            <div class="table-responsive">
                                <table class="table mb-0" id="detailTable">
                                    <thead style="background-color: #f8fafc;">
                                        <tr>
                                            <th class="px-4 py-3 text-secondary fw-semibold" style="font-size: 0.75rem;">NAMA LAYANAN</th>
                                            <th class="px-4 py-3 text-end text-secondary fw-semibold" style="font-size: 0.75rem;">HARGA</th>
                                        </tr>
                                    </thead>
                                    <tbody id="serviceList">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #f8fafc;">
                                            <td class="px-4 py-3 text-end fw-bold text-secondary">TOTAL ESTIMASI</td>
                                            <td class="px-4 py-3 text-end fw-bold text-primary" id="totalPrice" style="font-size: 1.1rem;">
                                                Rp 0
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    
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
            <?php if(Session::has('success')): ?>
                new Notify({
                    status: 'success', title: 'Berhasil', text: '<?php echo e(Session::get('success')); ?>',
                    effect: 'slide', speed: 300, autoclose: true, autotimeout: 3000, position: 'right top'
                });
            <?php endif; ?>
            <?php if(Session::has('error')): ?>
                new Notify({
                    status: 'error', title: 'Gagal', text: '<?php echo e(Session::get('error')); ?>',
                    effect: 'slide', speed: 300, autoclose: true, autotimeout: 5000, position: 'right top'
                });
            <?php endif; ?>
            });

            function showDetail(services) {
                const serviceList = document.getElementById('serviceList');
                const totalPriceEl = document.getElementById('totalPrice');
                let total = 0;
                
                serviceList.innerHTML = '';

                services.forEach(service => {
                    total += parseFloat(service.price);
                    const row = `
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold text-dark">${service.name}</div>
                                ${service.description ? `<div class="text-muted small mt-1">${service.description}</div>` : ''}
                            </td>
                            <td class="px-4 py-3 text-end align-middle fw-bold">
                                Rp ${new Intl.NumberFormat('id-ID').format(service.price)}
                            </td>
                        </tr>
                    `;
                    serviceList.innerHTML += row;
                });

                totalPriceEl.innerText = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;

                // Pemicu Modal Bootstrap
                var myModal = new bootstrap.Modal(document.getElementById('detailModal'));
                myModal.show();
            }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dokumen Sekolah 12\PKL\TSM\upj_tsm_k9\resources\views\booking\index.blade.php ENDPATH**/ ?>