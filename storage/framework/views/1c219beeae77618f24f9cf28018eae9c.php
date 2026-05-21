
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
               ROOT TOKENS  (selaras dengan halaman admin)
            ============================================================ */
        :root {
            --red: #B10000;
            --red-dark: #8B0000;
            --red-soft: rgba(177, 0, 0, .08);
            --red-border: rgba(177, 0, 0, .18);
            --navy: #0f172a;
            --navy-mid: #1e293b;
            --green: #047857;
            --green-soft: rgba(4, 120, 87, .10);
            --amber: #b45309;
            --amber-soft: rgba(180, 83, 9, .10);
            --bg: #f0f2f5;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #1e293b;
            --muted: #64748b;
            --subtle: #94a3b8;
            --radius: 16px;
            --radius-pill: 999px;
            --shadow-sm: 0 2px 10px rgba(0, 0, 0, .06);
            --shadow-md: 0 6px 24px rgba(0, 0, 0, .10);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            font-family: 'DM Sans', system-ui, sans-serif;
            color: var(--text);
        }

        /* ============================================================
               PAGE WRAPPER
            ============================================================ */
        .pg-wrap {
            padding: 28px 0 60px;
        }

        /* ============================================================
               HERO BANNER  (identik gaya admin)
            ============================================================ */
        .page-header {
            background: linear-gradient(135deg, var(--navy) 0%, #16213e 55%, #0f172a 100%);
            border-radius: 20px;
            padding: 28px 32px 30px;
            color: #fff;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(177, 0, 0, .28) 0%, transparent 70%);
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 20%;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .03);
        }

        .header-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(177, 0, 0, .30);
            border: 1px solid rgba(177, 0, 0, .45);
            color: #fca5a5;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: var(--radius-pill);
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .header-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.4px;
            margin: 0 0 4px;
            position: relative;
            z-index: 1;
        }

        .header-sub {
            font-size: .83rem;
            color: rgba(255, 255, 255, .5);
            font-weight: 500;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .header-btn-row {
            display: flex;
            gap: 10px;
            margin-top: 22px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .btn-red {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--red);
            color: #fff;
            font-weight: 700;
            font-size: .83rem;
            padding: 10px 22px;
            border-radius: var(--radius-pill);
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background .18s, transform .15s, box-shadow .18s;
            box-shadow: 0 4px 14px rgba(177, 0, 0, .40);
        }

        .btn-red:hover {
            background: var(--red-dark);
            transform: translateY(-2px);
            color: #fff;
            box-shadow: 0 6px 20px rgba(177, 0, 0, .50);
        }

        .btn-ghost-white {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .10);
            border: 1.5px solid rgba(255, 255, 255, .20);
            color: rgba(255, 255, 255, .85);
            font-weight: 600;
            font-size: .83rem;
            padding: 10px 20px;
            border-radius: var(--radius-pill);
            text-decoration: none;
            transition: background .18s, transform .15s;
        }

        .btn-ghost-white:hover {
            background: rgba(255, 255, 255, .20);
            color: #fff;
            transform: translateY(-2px);
        }

        /* ============================================================
               SECTION WRAPPER
            ============================================================ */
        .section-wrapper {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-wrapper>.panel:last-child,
        .section-wrapper>.empty-panel:last-child {
            margin-bottom: 0;
        }

        .btn-lainnya {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--red-soft);
            border: 1.5px solid var(--red-border);
            color: var(--red);
            font-size: .82rem;
            font-weight: 700;
            padding: 9px 22px;
            border-radius: var(--radius-pill);
            cursor: pointer;
            transition: background .18s, transform .15s;
        }

        .btn-lainnya:hover {
            background: var(--red-border);
            transform: translateY(-2px);
        }

        .btn-lainnya:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
        }

        /* ============================================================
               SECTION LABEL
            ============================================================ */
        .sec-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 14px;
        }

        .sec-label::before {
            content: '';
            display: block;
            width: 4px;
            height: 14px;
            border-radius: 4px;
            background: var(--red);
        }

        .sec-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ============================================================
               PANEL (white card identik admin)
            ============================================================ */
        .panel {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 16px;
            transition: box-shadow .2s;
        }

        .panel:hover {
            box-shadow: var(--shadow-md);
        }

        .panel-hdr {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
            gap: 8px;
        }

        .panel-title {
            font-size: .88rem;
            font-weight: 800;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-badge {
            font-size: .66rem;
            background: var(--red-soft);
            color: var(--red);
            border: 1px solid var(--red-border);
            padding: 3px 10px;
            border-radius: var(--radius-pill);
            font-weight: 700;
        }

        /*============================================================
                                MODAL
        ============================================================*/
        .modal-content{
            height: 75vh;
        }

        /* ============================================================
               BOOKING ITEM
            ============================================================ */
        .booking-item {
            padding: 18px 20px;
            border-bottom: 1px solid #f8fafc;
            transition: background .15s;
        }

        .booking-item:last-child {
            border-bottom: none;
        }

        .booking-item:hover {
            background: #fafbfe;
        }

        .booking-meta-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .booking-date {
            font-size: .82rem;
            font-weight: 700;
            color: var(--text);
        }

        .booking-time {
            font-size: .76rem;
            color: var(--muted);
            font-weight: 500;
            margin-top: 2px;
        }

        .queue-badge {
            background: linear-gradient(135deg, var(--red), var(--red-dark));
            color: #fff;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .5px;
            padding: 5px 14px;
            border-radius: var(--radius-pill);
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(177, 0, 0, .30);
        }

        .vehicle-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .vehicle-name {
            font-size: 1.08rem;
            font-weight: 800;
            color: var(--text);
        }

        .plate-badge {
            background: var(--amber-soft);
            border: 1.5px solid rgba(180, 83, 9, .25);
            color: #7a4500;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: 1px;
            padding: 4px 12px;
            border-radius: 8px;
            text-transform: uppercase;
        }

        .service-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 6px;
        }

        .service-key {
            font-size: .72rem;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .service-val {
            font-size: .85rem;
            font-weight: 700;
            color: var(--text);
        }

        /* ============================================================
               STEPPER
            ============================================================ */
        .stepper-wrap {
            display: flex;
            justify-content: space-between;
            position: relative;
            padding-top: 6px;
            margin: 18px 0 4px;
        }

        .stepper-wrap::before {
            content: '';
            position: absolute;
            top: 22px;
            left: 8%;
            width: 84%;
            height: 3px;
            background: var(--border);
            border-radius: 4px;
        }

        .step-progress {
            position: absolute;
            top: 22px;
            left: 8%;
            height: 3px;
            background: linear-gradient(90deg, var(--green), #34d399);
            border-radius: 4px;
            transition: width .6s cubic-bezier(.4, 0, .2, 1);
        }

        .step-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            z-index: 2;
        }

        .step-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--surface);
            border: 2.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 7px;
            color: var(--subtle);
            font-size: .85rem;
            box-shadow: var(--shadow-sm);
            transition: all .3s;
        }

        .step-lbl {
            font-size: .62rem;
            color: var(--muted);
            font-weight: 600;
            text-align: center;
        }

        .step-item.done .step-icon {
            border-color: var(--green);
            background: var(--green);
            color: #fff;
            box-shadow: 0 0 0 4px var(--green-soft);
        }

        .step-item.done .step-lbl {
            color: var(--green);
            font-weight: 700;
        }

        /* ============================================================
               ON-PROGRESS ALERT
            ============================================================ */
        .progress-alert {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--red-soft);
            border: 1.5px solid var(--red-border);
            border-radius: 12px;
            padding: 14px 16px;
            margin-top: 16px;
        }

        .progress-alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--red);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .progress-alert-title {
            font-size: .85rem;
            font-weight: 700;
            color: var(--red-dark);
            margin-bottom: 2px;
        }

        .progress-alert-sub {
            font-size: .76rem;
            color: var(--muted);
            font-weight: 500;
        }

        /* ============================================================
               EMPTY STATE
            ============================================================ */
        .empty-panel {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            text-align: center;
            padding: 48px 24px;
            margin-bottom: 16px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--red-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--red);
        }

        .empty-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: .84rem;
            color: var(--muted);
            font-weight: 500;
            margin-bottom: 24px;
        }

        /* ============================================================
               NOTIFICATION CARDS
            ============================================================ */
        .notif-card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 14px 18px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .notif-stripe {
            width: 4px;
            align-self: stretch;
            border-radius: 4px;
            flex-shrink: 0;
            min-height: 48px;
        }

        .notif-body {
            flex: 1;
        }

        .notif-title {
            font-size: .88rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 3px;
        }

        .notif-desc {
            font-size: .78rem;
            color: var(--muted);
            font-weight: 500;
            margin-bottom: 5px;
        }

        .notif-date {
            font-size: .73rem;
            font-weight: 700;
            color: var(--red);
        }

        .badge-tutup {
            background: var(--red-soft);
            border: 1px solid var(--red-border);
            color: var(--red);
            font-size: .65rem;
            font-weight: 800;
            letter-spacing: .6px;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: var(--radius-pill);
            white-space: nowrap;
            flex-shrink: 0;
            align-self: flex-start;
        }

        /* ============================================================
               MOBILE RESPONSIVE
            ============================================================ */
        @media (max-width: 575px) {
            .pg-wrap {
                padding: 16px 0 80px;
            }

            .page-header {
                border-radius: 14px;
                padding: 20px 18px 22px;
            }

            .header-title {
                font-size: 1.25rem;
            }

            .header-btn-row {
                gap: 8px;
                margin-top: 16px;
            }

            .btn-red,
            .btn-ghost-white {
                font-size: .8rem;
                padding: 9px 14px;
                flex: 1;
                justify-content: center;
            }

            .booking-item {
                padding: 14px 16px;
            }

            .step-icon {
                width: 30px;
                height: 30px;
                font-size: .75rem;
            }

            .step-lbl {
                font-size: .56rem;
            }

            .stepper-wrap::before {
                top: 19px;
            }

            .step-progress {
                top: 19px;
            }

            .vehicle-name {
                font-size: .95rem;
            }

            .empty-panel {
                padding: 36px 16px;
            }

            .empty-icon {
                width: 68px;
                height: 68px;
                font-size: 1.7rem;
            }
        }
    </style>

    <main>
        <div class="container pg-wrap">

            
            <div class="page-header">
                <div class="header-eyebrow">
                    Dashboard Pelanggan
                </div>
                <h1 class="header-title">Halo, <?php echo e(Auth::user()->name); ?> 👋</h1>
                <p class="header-sub">Pantau status servis kendaraan Anda secara real-time.</p>
                <div class="header-btn-row">
                    <a href="<?php echo e(route('pelanggan.service')); ?>" class="btn-red">
                        <i class="fas fa-plus"></i> Booking
                    </a>
                    <a href="<?php echo e(route('pelanggan.history')); ?>" class="btn-ghost-white">
                        <i class="fas fa-history"></i> Riwayat
                    </a>
                </div>
            </div>



            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notifications->isNotEmpty()): ?>
                <div class="section-wrapper">
                    <div class="sec-label">
                        Pengumuman
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $notifications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="notif-card">
                            <div class="notif-stripe" style="background:<?php echo e($note->color ?? 'var(--red)'); ?>;"></div>
                            <div class="notif-body">
                                <div class="notif-title"><?php echo e($note->title); ?></div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($note->description): ?>
                                    <div class="notif-desc"><?php echo e($note->description); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="notif-date">
                                    <i class="far fa-calendar me-1"></i>
                                    <?php echo e(\Carbon\Carbon::parse($note->date)->locale('id')->translatedFormat('d F Y')); ?>

                                </div>
                            </div>
                            <div class="badge-tutup">Tutup</div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notifications->count() > 5): ?>
                        <div class="text-center mt-2">
                            <button class="btn-lainnya" data-bs-toggle="modal" data-bs-target="#modalNotif">
                                <i class="fas fa-ellipsis-h"></i>
                                Lainnya (<?php echo e($notifications->count() - 5); ?> pengumuman)
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="modal fade" id="modalNotif" tabindex="-1" data-bs-backdrop="true" data-bs-keyboard="true"
                aria-labelledby="modalNotifLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content " style="border-radius: var(--radius); border: 1px solid var(--border);">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="modalNotifLabel"
                                style="font-size: .92rem; font-weight: 800; color: var(--text);">
                                Semua Pengumuman
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body pt-3">
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('notifikasi-modal', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-827874521-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="sec-label mt-1">
    <i class="fas fa-wrench" style="color:var(--red);"></i>
    Servis Aktif
</div>
<?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('booking-status-tracker');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-827874521-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
                </div>

            

            </div>

        </div>
    </main>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dokumen Sekolah 12\PKL\TSM\upj_tsm_k9\resources\views\pelanggan\dashboard.blade.php ENDPATH**/ ?>