<div wire:poll.10000ms>

    
    <div class="d-flex align-items-center justify-content-between mb-3 px-1">
        <div class="d-flex align-items-center gap-2">
            <span class="live-dot"></span>
            <span style="font-size:.72rem; font-weight:700; color:#047857; letter-spacing:.5px; text-transform:uppercase;">
                Live Update
            </span>
        </div>
        <span style="font-size:.70rem; color:#94a3b8; font-weight:500;">
            <i class="fas fa-sync-alt me-1" style="font-size:.65rem;"></i>
            Terakhir diperbarui: <strong><?php echo e($lastUpdated); ?></strong>
        </span>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeBookings->isEmpty()): ?>
        
        <div class="empty-panel">
            <div class="empty-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="empty-title">Tidak Ada Booking Aktif</div>
            <div class="empty-sub">Semua pekerjaan selesai atau belum ada booking yang dibuat.</div>
            <a href="<?php echo e(route('pelanggan.service')); ?>" class="btn-red mt-4" style="font-size:.82rem; padding:10px 22px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; background:#B10000; color:#fff; font-weight:700; border-radius:999px; box-shadow:0 4px 14px rgba(177,0,0,.35);">
                <i class="fas fa-plus"></i> Buat Booking Baru
            </a>
        </div>
    <?php else: ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $status  = $booking->status;
                $progW   = '0%';
                if ($status === 'pending')     $progW = '0%';
                if ($status === 'approved')    $progW = '44%';
                if ($status === 'on_progress') $progW = '75%';

                $badgeCfg = match($status) {
                    'pending'     => ['label' => 'Menunggu Konfirmasi', 'icon' => 'fa-clock',           'bg' => '#fef3c7', 'color' => '#92400e', 'border' => '#fcd34d'],
                    'approved'    => ['label' => 'Diterima',            'icon' => 'fa-clipboard-check', 'bg' => '#d1fae5', 'color' => '#065f46', 'border' => '#6ee7b7'],
                    'on_progress' => ['label' => 'Sedang Dikerjakan',   'icon' => 'fa-wrench',          'bg' => '#fee2e2', 'color' => '#991b1b', 'border' => '#fca5a5'],
                    default       => ['label' => $status,               'icon' => 'fa-circle',          'bg' => '#f1f5f9', 'color' => '#475569', 'border' => '#cbd5e1'],
                };
            ?>

            <div class="panel booking-item" style="border-left: 4px solid
                <?php echo e($status === 'on_progress' ? '#B10000' : ($status === 'approved' ? '#047857' : '#b45309')); ?>;">

                
                <div class="booking-meta-row">
                    <div>
                        <div class="booking-date">
                            <i class="fas fa-calendar-alt me-1" style="color:#94a3b8;"></i>
                            <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->locale('id')->translatedFormat('l, d M Y · H:i')); ?> WIB
                        </div>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $booking->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <span class="svc-chip"><?php echo e($svc->name); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>

                    
                    <span class="status-badge" style="
                        background: <?php echo e($badgeCfg['bg']); ?>;
                        color: <?php echo e($badgeCfg['color']); ?>;
                        border: 1.5px solid <?php echo e($badgeCfg['border']); ?>;
                        display:inline-flex; align-items:center; gap:6px;
                        padding:5px 14px; border-radius:999px;
                        font-size:.72rem; font-weight:800;
                        white-space:nowrap;
                        <?php echo e($status === 'on_progress' ? 'animation: pulse-badge 1.8s infinite;' : ''); ?>

                    ">
                        <i class="fas <?php echo e($badgeCfg['icon']); ?>" style="font-size:.7rem;"></i>
                        <?php echo e($badgeCfg['label']); ?>

                    </span>
                </div>

                
                <div class="d-flex flex-wrap gap-3 mb-14" style="margin-bottom:14px;">
                    <div class="vehicle-chip">
                        <i class="fas fa-motorcycle me-1" style="color:#94a3b8;"></i>
                        <span><?php echo e(strtoupper($booking->plate_number)); ?></span>
                    </div>
                    <div class="vehicle-chip">
                        <i class="fas fa-hashtag me-1" style="color:#94a3b8;"></i>
                        <span>Antrian #<?php echo e($booking->queue_number); ?></span>
                    </div>
                </div>

                
                <div class="stepper-wrap">
                    <div class="step-progress" style="width:<?php echo e($progW); ?>;"></div>

                    <div class="step-item <?php echo e(in_array($status, ['pending','approved','on_progress']) ? 'done' : ''); ?>">
                        <div class="step-icon"><i class="fas fa-clock"></i></div>
                        <div class="step-lbl">Menunggu</div>
                    </div>
                    <div class="step-item <?php echo e(in_array($status, ['approved','on_progress']) ? 'done' : ''); ?>">
                        <div class="step-icon"><i class="fas fa-clipboard-check"></i></div>
                        <div class="step-lbl">Diterima</div>
                    </div>
                    <div class="step-item <?php echo e($status === 'on_progress' ? 'done' : ''); ?>">
                        <div class="step-icon">
                            <i class="fas fa-wrench <?php echo e($status === 'on_progress' ? 'fa-spin' : ''); ?>" style="<?php echo e($status === 'on_progress' ? 'animation-duration:2s;' : ''); ?>"></i>
                        </div>
                        <div class="step-lbl">Dikerjakan</div>
                    </div>
                    <div class="step-item">
                        <div class="step-icon"><i class="fas fa-flag-checkered"></i></div>
                        <div class="step-lbl">Selesai</div>
                    </div>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status === 'on_progress' && $booking->estimation_duration): ?>
                    <?php
                        $estTime = \Carbon\Carbon::parse($booking->booking_date)
                            ->addMinutes($booking->estimation_duration);
                    ?>
                    <div class="progress-alert" style="margin-top:16px;">
                        <div class="progress-alert-icon" style="animation: pulse-icon 1.8s infinite;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <div class="progress-alert-title">🔧 Kendaraan Anda Sedang Dikerjakan Mekanik</div>
                            <div class="progress-alert-sub">
                                Estimasi selesai pukul <strong><?php echo e($estTime->format('H:i')); ?> WIB</strong>
                                &nbsp;·&nbsp; Mohon tunggu di area bengkel
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status === 'approved'): ?>
                    <div class="approved-alert" style="margin-top:16px;">
                        <div class="approved-alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <div class="approved-alert-title">✅ Booking Dikonfirmasi</div>
                            <div class="approved-alert-sub">
                                Silakan datang 15 menit sebelum jadwal dan tunjukkan nomor antrian kepada petugas.
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <style>
        /* Live dot */
        .live-dot {
            width: 9px; height: 9px;
            border-radius: 50%;
            background: #047857;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(4,120,87,.5);
            animation: live-pulse 1.6s infinite;
        }
        @keyframes live-pulse {
            0%   { box-shadow: 0 0 0 0 rgba(4,120,87,.5); }
            70%  { box-shadow: 0 0 0 7px rgba(4,120,87,0); }
            100% { box-shadow: 0 0 0 0 rgba(4,120,87,0); }
        }

        /* Service chips */
        .svc-chip {
            display: inline-block;
            background: rgba(177,0,0,.08);
            color: #8B0000;
            border: 1px solid rgba(177,0,0,.15);
            font-size: .68rem;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 999px;
        }

        /* Vehicle chip */
        .vehicle-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: .75rem;
            font-weight: 600;
            color: #475569;
            padding: 3px 12px;
            border-radius: 8px;
        }

        /* Badge pulse */
        @keyframes pulse-badge {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.75; }
        }

        /* Progress alert */
        .progress-alert {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #fff5f5;
            border: 1.5px solid rgba(177,0,0,.20);
            border-radius: 12px;
            padding: 14px 16px;
        }
        .progress-alert-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: #B10000;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .progress-alert-title {
            font-size: .85rem;
            font-weight: 700;
            color: #7f1d1d;
            margin-bottom: 2px;
        }
        .progress-alert-sub {
            font-size: .76rem;
            color: #64748b;
            font-weight: 500;
        }
        @keyframes pulse-icon {
            0%, 100% { transform: scale(1); }
            50%       { transform: scale(1.1); }
        }

        /* Approved alert */
        .approved-alert {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #f0fdf4;
            border: 1.5px solid #6ee7b7;
            border-radius: 12px;
            padding: 14px 16px;
        }
        .approved-alert-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: #047857;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .approved-alert-title {
            font-size: .85rem;
            font-weight: 700;
            color: #065f46;
            margin-bottom: 2px;
        }
        .approved-alert-sub {
            font-size: .76rem;
            color: #64748b;
            font-weight: 500;
        }
    </style>

</div><?php /**PATH D:\Dokumen Sekolah 12\PKL\upj_tsm_k9\resources\views/livewire/booking-status-tracker.blade.php ENDPATH**/ ?>