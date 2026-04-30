
<div wire:poll.10000ms="refresh">

    
    <div class="hero-banner">
        <div class="hero-bg-pattern"></div>
        <div class="hero-content">
            <div class="hero-left">
                <div class="greeting-chip">
                    <span class="pulse-dot"></span>
                    Live Status
                </div>
                <h1 class="hero-title">
                    Halo, <span class="hero-name"><?php echo e(Auth::user()->name); ?></span> 👋
                </h1>
                <p class="hero-subtitle">Pantau kendaraanmu secara real-time di sini.</p>
            </div>
            <div class="hero-right">
                <a href="<?php echo e(route('pelanggan.service')); ?>" class="btn-booking-hero">
                    <i class="fas fa-plus-circle me-2"></i>Booking Sekarang
                </a>
            </div>
        </div>

        
        <div class="stats-row">
            <div class="stat-chip">
                <div class="stat-icon stat-icon-blue">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <div class="stat-number"><?php echo e($totalService); ?></div>
                    <div class="stat-label">Total Service</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="stat-icon stat-icon-orange">
                    <i class="fas fa-wrench"></i>
                </div>
                <div>
                    <div class="stat-number"><?php echo e($totalAktif); ?></div>
                    <div class="stat-label">Sedang Aktif</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="stat-icon stat-icon-green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="stat-number"><?php echo e($totalSelesai); ?></div>
                    <div class="stat-label">Selesai</div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="live-indicator">
        <div wire:loading wire:target="refresh">
            <span class="spinner-border spinner-border-sm text-primary me-2" role="status"></span>
            <span class="text-muted small">Memperbarui...</span>
        </div>
        <div wire:loading.remove wire:target="refresh">
            <span class="live-dot"></span>
            <span class="text-muted small">Terakhir diperbarui pukul <strong><?php echo e($lastUpdated); ?></strong> · Auto-refresh setiap 10 detik</span>
        </div>
    </div>

    
    <div class="section-header-row">
        <h5 class="section-title"><i class="fas fa-motorcycle me-2 text-primary"></i>Servis Aktif</h5>
        <a href="<?php echo e(route('pelanggan.history')); ?>" class="btn-history">
            <i class="fas fa-history me-1"></i> Riwayat
        </a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeBookings->isEmpty()): ?>
        
        <div class="empty-state-card">
            <div class="empty-illustration">
                <i class="fas fa-motorcycle"></i>
                <div class="empty-spark">✨</div>
            </div>
            <h5 class="empty-title">Tidak Ada Servis Aktif</h5>
            <p class="empty-desc">Kendaraanmu sedang tidak dalam antrian. Yuk jadwalkan servis sekarang!</p>
            <a href="<?php echo e(route('pelanggan.service')); ?>" class="btn-empty-cta">
                <i class="fas fa-calendar-plus me-2"></i>Booking Servis
            </a>
        </div>
    <?php else: ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $status = $booking->status;
                $steps = [
                    ['key' => 'pending',     'icon' => 'fa-clock',           'label' => 'Menunggu'],
                    ['key' => 'approved',    'icon' => 'fa-clipboard-check',  'label' => 'Diterima'],
                    ['key' => 'on_progress', 'icon' => 'fa-tools',            'label' => 'Dikerjakan'],
                    ['key' => 'done',        'icon' => 'fa-check-double',     'label' => 'Selesai'],
                ];
                $stepIndex = match($status) {
                    'pending'     => 0,
                    'approved'    => 1,
                    'on_progress' => 2,
                    'done'        => 3,
                    default       => 0,
                };
                $statusConfig = match($status) {
                    'pending'     => ['label' => 'Menunggu Konfirmasi', 'color' => '#f59e0b', 'bg' => '#fef3c7'],
                    'approved'    => ['label' => 'Sudah Dikonfirmasi',  'color' => '#3b82f6', 'bg' => '#dbeafe'],
                    'on_progress' => ['label' => 'Sedang Dikerjakan',   'color' => '#8b5cf6', 'bg' => '#ede9fe'],
                    default       => ['label' => $status,               'color' => '#6b7280', 'bg' => '#f3f4f6'],
                };
            ?>

            <div class="booking-card">
                
                <div class="booking-card-header">
                    <div class="booking-meta">
                        <span class="queue-badge">#<?php echo e($booking->queue_number); ?></span>
                        <div>
                            <div class="booking-date">
                                <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->locale('id')->translatedFormat('l, d F Y')); ?>

                            </div>
                            <div class="booking-time">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('H:i')); ?> WIB
                            </div>
                        </div>
                    </div>
                    <div class="status-badge-pill" style="color: <?php echo e($statusConfig['color']); ?>; background: <?php echo e($statusConfig['bg']); ?>;">
                        <?php echo e($statusConfig['label']); ?>

                    </div>
                </div>

                
                <div class="vehicle-row">
                    <div class="vehicle-icon-wrap">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="vehicle-details">
                        <div class="vehicle-type"><?php echo e(ucfirst($booking->vehicle_type)); ?></div>
                        <div class="vehicle-plate"><?php echo e(strtoupper($booking->plate_number)); ?></div>
                    </div>
                    <div class="vehicle-service ms-auto text-end">
                        <div class="text-muted small">Layanan</div>
                        <div class="fw-bold text-dark">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->services->count() > 1): ?>
                                <?php echo e($booking->services->count()); ?> Layanan
                            <?php else: ?>
                                <?php echo e($booking->services->first()?->name ?? 'Service Umum'); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->services->count() > 0): ?>
                        <div class="service-total fw-bold">
                            Rp <?php echo e(number_format($booking->services->sum('price'), 0, ',', '.')); ?>

                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="tracker-wrap">
                    <div class="tracker-line">
                        <div class="tracker-line-fill" style="width: <?php echo e(($stepIndex / (count($steps) - 1)) * 100); ?>%"></div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $isDone    = $i < $stepIndex;
                            $isActive  = $i === $stepIndex;
                        ?>
                        <div class="tracker-step <?php echo e($isDone ? 'done' : ($isActive ? 'active' : '')); ?>">
                            <div class="tracker-circle">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isDone): ?>
                                    <i class="fas fa-check"></i>
                                <?php elseif($isActive): ?>
                                    <i class="fas <?php echo e($step['icon']); ?>"></i>
                                <?php else: ?>
                                    <span><?php echo e($i + 1); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="tracker-label"><?php echo e($step['label']); ?></div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->complaint): ?>
                <div class="complaint-row">
                    <i class="fas fa-comment-alt-dots me-2 text-muted"></i>
                    <span class="text-muted small fst-italic">"<?php echo e($booking->complaint); ?>"</span>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div><?php /**PATH /home/hakuuu/Desktop/project/upj_tsm_k9/resources/views/livewire/pelanggan-dashboard.blade.php ENDPATH**/ ?>