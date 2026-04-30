
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
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
            max-width: 800px;
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
               DETAIL CARD
            ========================================= */
        .detail-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 1px 12px rgba(0, 0, 0, .04);
            overflow: hidden;
        }

        /* ---- section header ---- */
        .sec-head {
            padding: 16px 26px;
            border-bottom: 1px solid var(--border);
            background: #fafbfd;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .sec-head-title {
            font-size: .95rem;
            font-weight: 700;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .sec-head-title i {
            color: var(--red);
        }

        /* ---- rows ---- */
        .detail-row {
            display: flex;
            align-items: flex-start;
            padding: 17px 26px;
            border-bottom: 1px solid #f1f5f9;
            gap: 16px;
            transition: background .13s;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row:hover {
            background: #fafbfd;
        }

        .row-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--red-soft);
            border: 1px solid var(--red-border);
            color: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .82rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .row-label {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: var(--subtle);
            margin-bottom: 3px;
        }

        .row-value {
            font-size: .92rem;
            font-weight: 500;
            color: var(--ink);
            line-height: 1.4;
        }

        /* ---- special value styles ---- */

        /* plate number */
        .plate-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--ink);
            border-radius: 8px;
            border: 2px solid var(--ink);
            padding: 4px 14px;
            font-size: .85rem;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .plate-pill i {
            font-size: .65rem;
            color: rgba(255, 255, 255, .5);
        }

        /* whatsapp */
        .wa-val {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #059669;
            font-weight: 600;
        }

        .wa-val i {
            font-size: .9rem;
        }

        /* status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: .78rem;
            font-weight: 700;
            text-transform: capitalize;
        }

        .status-badge .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

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

        .st-default {
            background: var(--slate-soft);
            color: var(--muted);
            border: 1px solid rgba(100, 116, 139, .18);
        }

        .st-default .dot {
            background: var(--subtle);
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

        /* =========================================
               RESPONSIVE
            ========================================= */
        @media (max-width: 600px) {
            .page-wrap {
                padding: 1.25rem 1rem 3rem;
            }

            .banner-title {
                font-size: 1.3rem;
            }

            .detail-row {
                padding: 14px 18px;
            }
        }
    </style>

    <main class="page-wrap">

        
        <div class="page-banner au">
            <div class="banner-inner">
                <div>
                    <div class="banner-label">
                        Detail Booking
                    </div>
                    <h1 class="banner-title">Informasi Booking</h1>
                    <p class="banner-sub">Rincian lengkap data booking kendaraan.</p>
                </div>
                <a href="<?php echo e(route('customers.index')); ?>" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pelanggan
                </a>
            </div>
        </div>

        
        <div class="detail-card au d1">

            <div class="sec-head">
                <div class="sec-head-title">
                    <i class="fas fa-clipboard-list"></i>
                    Data Lengkap Booking
                </div>
            </div>

            
            <div class="detail-row">
                <div class="row-icon"><i class="fas fa-user"></i></div>
                <div>
                    <div class="row-label">Nama Customer</div>
                    <div class="row-value"><?php echo e($booking->customer_name); ?></div>
                </div>
            </div>

            
            <div class="detail-row">
                <div class="row-icon"><i class="fab fa-whatsapp"></i></div>
                <div>
                    <div class="row-label">No. WhatsApp</div>
                    <div class="row-value">
                        <span class="wa-val">
                            <?php echo e($booking->customer_whatsapp); ?>

                        </span>
                    </div>
                </div>
            </div>

            
            <div class="detail-row">
                <div class="row-icon"><i class="fas fa-motorcycle"></i></div>
                <div>
                    <div class="row-label">Jenis Kendaraan</div>
                    <div class="row-value"><?php echo e($booking->vehicle_type); ?></div>
                </div>
            </div>

            
            <div class="detail-row">
                <div class="row-icon"><i class="fas fa-car"></i></div>
                <div>
                    <div class="row-label">No. Polisi</div>
                    <div class="row-value">
                        <span class="plate-pill">
                            <?php echo e($booking->plate_number); ?>

                        </span>
                    </div>
                </div>
            </div>

            
            <div class="detail-row">
                <div class="row-icon"><i class="fas fa-calendar-alt"></i></div>
                <div>
                    <div class="row-label">Tanggal Booking</div>
                    <div class="row-value">
                        <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->isoFormat('dddd, D MMMM Y')); ?>

                    </div>
                </div>
            </div>

            
            <div class="detail-row">
                <div class="row-icon"><i class="fas fa-wrench"></i></div>
                <div>
                    <div class="row-label">Service</div>
                    <div class="row-value"><?php echo e($booking->service->name ?? '-'); ?></div>
                </div>
            </div>

            
            <div class="detail-row">
                <div class="row-icon"><i class="fas fa-info-circle"></i></div>
                <div>
                    <div class="row-label">Status</div>
                    <div class="row-value">
                        <?php
                            $st = strtolower($booking->status);
                            $cls = match (true) {
                                in_array($st, ['selesai', 'completed', 'done']) => 'st-selesai',
                                in_array($st, ['pending', 'menunggu', 'waiting']) => 'st-pending',
                                in_array($st, ['proses', 'process', 'in-progress']) => 'st-proses',
                                in_array($st, ['batal', 'cancelled', 'cancel']) => 'st-batal',
                                default => 'st-default',
                            };
                        ?>
                        <span class="status-badge <?php echo e($cls); ?>">
                            <span class="dot"></span>
                            <?php echo e(ucfirst($booking->status)); ?>

                        </span>
                    </div>
                </div>
            </div>

        </div>

    </main>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hakuuu/Desktop/project/upj_tsm_k9/resources/views/booking/history_detail.blade.php ENDPATH**/ ?>