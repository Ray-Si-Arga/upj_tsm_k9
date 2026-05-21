

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --red:        #B10000;
            --red-dark:   #7f0000;
            --red-glow:   rgba(177, 0, 0, 0.15);
            --surface:    #ffffff;
            --bg:         #f5f5f7;
            --border:     #e8e8ed;
            --ink:        #1a1a2e;
            --muted:      #6e6e80;
            --subtle:     #aeaebb;
            --green:      #00875a;
            --green-soft: rgba(0, 135, 90, 0.10);
            --amber:      #c47d0e;
            --amber-soft: rgba(196, 125, 14, 0.10);
            --blue:       #0057b8;
            --blue-soft:  rgba(0, 87, 184, 0.10);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Sora', system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        /* ── PAGE WRAPPER ── */
        .hist-page {
            max-width: 680px;
            margin: 0 auto;
            padding: 20px 16px 80px;
        }

        /* ── TOP HERO BAR ── */
        .hero-bar {
            background: linear-gradient(145deg, #1a0d0d 0%, #1a0000 50%, #200000 100%);
            border-radius: 20px;
            padding: 24px 22px 22px;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
        }

        .hero-bar::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(177,0,0,.35) 0%, transparent 70%);
        }

        .hero-bar::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -20px;
            width: 150px; height: 150px;
            border-radius: 50%;
            background: rgba(255,255,255,.02);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,.45);
            margin-bottom: 6px;
        }

        .hero-eyebrow span {
            width: 18px; height: 1px;
            background: rgba(255,255,255,.3);
        }

        .hero-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.5px;
            line-height: 1.15;
            margin: 0 0 4px;
        }

        .hero-sub {
            font-size: .75rem;
            color: rgba(255,255,255,.4);
            font-weight: 400;
            margin: 0;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px; height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            color: rgba(255,255,255,.75);
            text-decoration: none;
            flex-shrink: 0;
            transition: background .18s;
        }

        .btn-back:hover {
            background: rgba(255,255,255,.15);
            color: #fff;
        }

        /* Hero Stats Row */
        .hero-stats {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 10px;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .hstat {
            flex: 1;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 12px;
            padding: 10px 12px;
            text-align: center;
        }

        .hstat-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }

        .hstat-lbl {
            font-size: .6rem;
            font-weight: 600;
            color: rgba(255,255,255,.38);
            letter-spacing: .8px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* ── FILTER CHIP BAR ── */
        .filter-bar {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
            margin-bottom: 18px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .filter-bar::-webkit-scrollbar { display: none; }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 600;
            border: 1.5px solid var(--border);
            background: var(--surface);
            color: var(--muted);
            cursor: pointer;
            white-space: nowrap;
            transition: all .18s;
            flex-shrink: 0;
        }

        .chip.active,
        .chip:hover {
            background: var(--ink);
            border-color: var(--ink);
            color: #fff;
        }

        .chip-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ── CARD LIST ── */
        .hist-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .hist-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
            animation: slideUp .35s ease both;
        }

        .hist-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(0,0,0,.07);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hist-card:nth-child(1) { animation-delay: .04s; }
        .hist-card:nth-child(2) { animation-delay: .08s; }
        .hist-card:nth-child(3) { animation-delay: .12s; }
        .hist-card:nth-child(4) { animation-delay: .16s; }
        .hist-card:nth-child(5) { animation-delay: .20s; }

        /* Card top stripe */
        .card-stripe {
            height: 3px;
            width: 100%;
        }

        .stripe-done     { background: linear-gradient(90deg, #00875a, #00c87c); }
        .stripe-cancelled { background: linear-gradient(90deg, #B10000, #e53935); }

        /* Card body */
        .card-body-area {
            padding: 16px 18px;
        }

        /* Row 1: Date + badge */
        .card-row1 {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 12px;
        }

        .card-date-main {
            font-size: .82rem;
            font-weight: 700;
            color: var(--ink);
        }

        .card-date-day {
            font-size: .68rem;
            color: var(--subtle);
            font-weight: 400;
            margin-top: 1px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .2px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .status-pill .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .pill-done {
            background: var(--green-soft);
            color: var(--green);
            border: 1px solid rgba(0,135,90,.2);
        }
        .pill-done .dot { background: var(--green); }

        .pill-cancelled {
            background: var(--red-glow);
            color: var(--red);
            border: 1px solid rgba(177,0,0,.2);
        }
        .pill-cancelled .dot { background: var(--red); }

        /* Row 2: Vehicle info */
        .vehicle-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            padding: 10px 12px;
            background: var(--bg);
            border-radius: 10px;
        }

        .vehicle-icon-box {
            width: 36px; height: 36px;
            border-radius: 9px;
            background: rgba(177,0,0,.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            color: var(--red);
            flex-shrink: 0;
        }

        .vehicle-name {
            font-size: .85rem;
            font-weight: 700;
            color: var(--ink);
            text-transform: capitalize;
        }

        .vehicle-plate {
            font-family: 'JetBrains Mono', monospace;
            font-size: .72rem;
            font-weight: 600;
            color: var(--muted);
            margin-top: 1px;
            text-transform: uppercase;
        }

        /* Row 3: Services */
        .service-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 12px;
        }

        .svc-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 7px;
            font-size: .68rem;
            font-weight: 600;
            background: rgba(0,87,184,.07);
            color: var(--blue);
            border: 1px solid rgba(0,87,184,.12);
        }

        /* Row 4: Complaint */
        .complaint-box {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(196,125,14,.06);
            border: 1px solid rgba(196,125,14,.15);
            margin-bottom: 14px;
        }

        .complaint-icon {
            font-size: .75rem;
            color: var(--amber);
            margin-top: 1px;
            flex-shrink: 0;
        }

        .complaint-text {
            font-size: .76rem;
            color: var(--amber);
            font-style: italic;
            line-height: 1.45;
            font-weight: 500;
        }

        /* Cancelled reason button */
        .btn-reason {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            width: 100%;
            padding: 10px 14px;
            border-radius: 11px;
            background: rgba(177,0,0,.06);
            border: 1.5px solid rgba(177,0,0,.15);
            color: var(--red);
            font-size: .76rem;
            font-weight: 700;
            cursor: pointer;
            text-align: left;
            transition: background .18s;
            margin-bottom: 4px;
        }

        .btn-reason:hover { background: rgba(177,0,0,.1); }
        .btn-reason .chevron { font-size: .7rem; opacity: .7; }

        /* Done check strip */
        .done-strip {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .74rem;
            font-weight: 600;
            color: var(--green);
            padding: 8px 12px;
            border-radius: 10px;
            background: var(--green-soft);
            border: 1px solid rgba(0,135,90,.15);
        }

        /* ── EMPTY STATE ── */
        .empty-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px 40px;
            text-align: center;
            animation: slideUp .4s ease both;
        }

        .empty-icon-ring {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: linear-gradient(145deg, #f5f5f7, #e8e8ed);
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--subtle);
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: .82rem;
            color: var(--subtle);
            font-weight: 400;
            margin-bottom: 24px;
            max-width: 260px;
        }

        .btn-book-now {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px;
            background: var(--ink);
            color: #fff;
            font-size: .82rem;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-book-now:hover {
            background: var(--red);
            color: #fff;
            transform: translateY(-2px);
        }

        /* ── MODAL CANCELLATION REASON ── */
        .modal-content {
            border: none;
            border-radius: 22px;
            overflow: hidden;
        }

        .modal-backdrop.show { opacity: .4; }

        .reason-header {
            background: linear-gradient(135deg, var(--red-dark), var(--red));
            padding: 20px 22px;
        }

        .reason-body { padding: 22px; }

        .reason-quote {
            font-size: .88rem;
            color: var(--ink);
            line-height: 1.6;
            font-style: italic;
            border-left: 3px solid var(--red);
            padding-left: 14px;
            margin-bottom: 20px;
        }

        .reason-footer-btns {
            display: flex;
            gap: 10px;
        }

        .btn-close-modal {
            flex: 1;
            padding: 12px;
            border-radius: 11px;
            border: 1.5px solid var(--border);
            background: transparent;
            font-size: .83rem;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
        }

        .btn-rebook {
            flex: 2;
            padding: 12px;
            border-radius: 11px;
            border: none;
            background: var(--red);
            font-size: .83rem;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background .18s;
        }

        .btn-rebook:hover { background: var(--red-dark); color: #fff; }

        /* ── RESPONSIVE ── */
        @media (min-width: 600px) {
            .hist-page { padding: 28px 24px 80px; }
            .hero-title { font-size: 1.75rem; }
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <main class="hist-page">

        
        <div class="hero-bar">
            <div class="hero-content">
                <div>
                    <div class="hero-eyebrow">
                        <span></span>
                        Riwayat Servis
                    </div>
                    <h1 class="hero-title">Histori Kendaraan</h1>
                    <p class="hero-sub">Semua catatan servis yang telah selesai</p>
                </div>
                <a href="<?php echo e(route('pelanggan.dashboard')); ?>" class="btn-back">
                    <i class="fas fa-arrow-left" style="font-size:.8rem;"></i>
                </a>
            </div>

            <div class="hero-stats">
                <?php
                    $totalAll   = $historyBookings->count();
                    $totalDone  = $historyBookings->where('status','done')->count();
                    $totalBatal = $historyBookings->where('status','cancelled')->count();
                ?>
                <div class="hstat">
                    <div class="hstat-num"><?php echo e($totalAll); ?></div>
                    <div class="hstat-lbl">Total</div>
                </div>
                <div class="hstat">
                    <div class="hstat-num" style="color:#4ade80;"><?php echo e($totalDone); ?></div>
                    <div class="hstat-lbl">Selesai</div>
                </div>
                <div class="hstat">
                    <div class="hstat-num" style="color:#f87171;"><?php echo e($totalBatal); ?></div>
                    <div class="hstat-lbl">Dibatalkan</div>
                </div>
            </div>
        </div>

        
        <div class="filter-bar">
            <div class="chip active" onclick="filterCards('all', this)">
                <i class="fas fa-layer-group" style="font-size:.65rem;"></i> Semua
            </div>
            <div class="chip" onclick="filterCards('done', this)">
                <span class="chip-dot" style="background:#00875a;"></span> Selesai
            </div>
            <div class="chip" onclick="filterCards('cancelled', this)">
                <span class="chip-dot" style="background:#B10000;"></span> Dibatalkan
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($historyBookings->isEmpty()): ?>
            <div class="empty-wrap">
                <div class="empty-icon-ring">
                    <i class="fas fa-scroll"></i>
                </div>
                <div class="empty-title">Belum Ada Riwayat</div>
                <p class="empty-sub">Kamu belum memiliki catatan servis yang selesai. Yuk buat booking pertama!</p>
                <a href="<?php echo e(route('pelanggan.service')); ?>" class="btn-book-now">
                    <i class="fas fa-wrench" style="font-size:.75rem;"></i>
                    Booking Sekarang
                </a>
            </div>
        <?php else: ?>
            <div class="hist-list" id="histList">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $historyBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="hist-card" data-status="<?php echo e($history->status); ?>">
                        
                        <div class="card-stripe <?php echo e($history->status == 'done' ? 'stripe-done' : 'stripe-cancelled'); ?>"></div>

                        <div class="card-body-area">

                            
                            <div class="card-row1">
                                <div>
                                    <div class="card-date-main">
                                        <?php echo e(\Carbon\Carbon::parse($history->booking_date)->locale('id')->translatedFormat('d F Y')); ?>

                                    </div>
                                    <div class="card-date-day">
                                        <i class="far fa-clock" style="font-size:.62rem; margin-right:3px;"></i>
                                        <?php echo e(\Carbon\Carbon::parse($history->booking_date)->format('H:i')); ?> WIB
                                    </div>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->status == 'done'): ?>
                                    <div class="status-pill pill-done">
                                        <span class="dot"></span> Selesai
                                    </div>
                                <?php elseif($history->status == 'cancelled'): ?>
                                    <div class="status-pill pill-cancelled">
                                        <span class="dot"></span> Dibatalkan
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            
                            <div class="vehicle-row">
                                <div class="vehicle-icon-box">
                                    <i class="fas fa-motorcycle"></i>
                                </div>
                                <div>
                                    <div class="vehicle-name"><?php echo e($history->vehicle_type); ?></div>
                                    <div class="vehicle-plate"><?php echo e(strtoupper($history->plate_number)); ?></div>
                                </div>
                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->services->count()): ?>
                                <div class="service-chips">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $history->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <span class="svc-chip">
                                            <i class="fas fa-check" style="font-size:.58rem;"></i>
                                            <?php echo e($svc->name); ?>

                                        </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->complaint): ?>
                                <div class="complaint-box">
                                    <i class="fas fa-comment-dots complaint-icon"></i>
                                    <div class="complaint-text">"<?php echo e($history->complaint); ?>"</div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->status == 'done'): ?>
                                <div class="done-strip">
                                    <i class="fas fa-shield-check" style="font-size:.8rem;"></i>
                                    Servis berhasil diselesaikan
                                </div>
                            <?php elseif($history->status == 'cancelled'): ?>
                                <button class="btn-reason" type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#reasonModal<?php echo e($history->id); ?>">
                                    <span>
                                        <i class="fas fa-circle-info" style="margin-right:6px; font-size:.75rem;"></i>
                                        Lihat alasan pembatalan
                                    </span>
                                    <i class="fas fa-chevron-right chevron"></i>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->status == 'cancelled'): ?>
                        <div class="modal fade" id="reasonModal<?php echo e($history->id); ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="reason-header">
                                        <div style="font-size:.62rem; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; color:rgba(255,255,255,.5); margin-bottom:5px;">
                                            Booking Dibatalkan
                                        </div>
                                        <div style="font-size:.95rem; font-weight:800; color:#fff; margin-bottom:2px;">
                                            <?php echo e(\Carbon\Carbon::parse($history->booking_date)->locale('id')->translatedFormat('d F Y')); ?>

                                        </div>
                                        <div style="font-size:.72rem; color:rgba(255,255,255,.5);">
                                            <?php echo e(strtoupper($history->plate_number)); ?> • <?php echo e($history->vehicle_type); ?>

                                        </div>
                                    </div>
                                    <div class="reason-body">
                                        <div style="font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.8px; color:var(--subtle); margin-bottom:10px;">
                                            Pesan dari Admin
                                        </div>
                                        <div class="reason-quote">
                                            "<?php echo e($history->rejection_reason ?? 'Maaf, booking dibatalkan tanpa catatan khusus.'); ?>"
                                        </div>
                                        <div class="reason-footer-btns">
                                            <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                            <a href="<?php echo e(route('pelanggan.service')); ?>" class="btn-rebook">
                                                <i class="fas fa-redo" style="font-size:.72rem;"></i>
                                                Booking Ulang
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </main>

    <script>
        function filterCards(status, el) {
            // update active chip
            document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
            el.classList.add('active');

            // filter cards
            document.querySelectorAll('.hist-card').forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dokumen Sekolah 12\PKL\TSM\upj_tsm_k9\resources\views/pelanggan/history.blade.php ENDPATH**/ ?>