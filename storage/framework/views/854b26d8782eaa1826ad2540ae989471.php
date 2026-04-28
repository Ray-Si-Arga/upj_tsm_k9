
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        .card-history {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .status-badge-done {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .status-badge-cancelled {
            background-color: #f8d7da;
            color: #842029;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }
    </style>

    <main class="py-4">
        <div class="container">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1">Riwayat Servis</h3>
                    <p class="text-muted mb-0">Daftar kendaraan yang telah selesai diservis.</p>
                </div>
                <a href="<?php echo e(route('pelanggan.dashboard')); ?>" class="btn btn-outline-secondary rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($historyBookings->isEmpty()): ?>
                <div class="alert alert-light text-center p-5 border-0 shadow-sm rounded-4">
                    <i class="fas fa-history fa-3x mb-3 text-secondary opacity-25"></i>
                    <h5>Belum ada riwayat</h5>
                    <p class="text-muted">Anda belum memiliki transaksi servis yang selesai.</p>
                </div>
            <?php else: ?>
                <div class="card card-history">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4">Tanggal</th>
                                        <th class="py-3 px-4">Kendaraan</th>
                                        <th class="py-3 px-4">Layanan</th>
                                        <th class="py-3 px-4">Keluhan</th>
                                        <th class="py-3 px-4 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $historyBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <tr>
                                            
                                            <td class="px-4">
                                                <div class="fw-bold text-dark">
                                                    <?php echo e(\Carbon\Carbon::parse($history->booking_date)->locale('id')->translatedFormat('d F Y')); ?>

                                                </div>
                                                <small class="text-muted">
                                                    Jam <?php echo e(\Carbon\Carbon::parse($history->booking_date)->format('H:i')); ?>

                                                    WIB
                                                </small>
                                            </td>

                                            
                                            <td class="px-4">
                                                <div class="fw-semibold"><?php echo e($history->vehicle_type); ?></div>
                                                <small class="text-muted"><?php echo e(strtoupper($history->plate_number)); ?></small>
                                            </td>

                                            
                                            <td class="px-4">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $history->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                    <span class="badge bg-secondary mb-1"><?php echo e($svc->name); ?></span><br>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            </td>

                                            
                                            <td class="px-4">
                                                <div class="text-danger fw-semibold"><?php echo e($history->complaint); ?></div>
                                            </td>

                                            
                                            <td class="px-4 text-center">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->status == 'done'): ?>
                                                    <span class="status-badge-done"><i class="fas fa-check-circle me-1"></i>
                                                        Selesai</span>
                                                <?php elseif($history->status == 'cancelled'): ?>
                                                    
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger rounded-pill px-3 fw-bold"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#reasonModal<?php echo e($history->id); ?>">
                                                        <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                                    </button>

                                                    
                                                    <div class="modal fade" id="reasonModal<?php echo e($history->id); ?>"
                                                        tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content text-start">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h6 class="modal-title fw-bold">Alasan Pembatalan</h6>
                                                                    <button type="button" class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div
                                                                        class="alert alert-light border-danger text-danger">
                                                                        <i class="fas fa-info-circle me-2"></i>
                                                                        <strong>Pesan dari Admin:</strong>
                                                                    </div>
                                                                    <p class="mb-0 fs-5 text-dark">
                                                                        "<?php echo e($history->rejection_reason ?? 'Maaf, booking dibatalkan tanpa catatan khusus.'); ?>"
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                    <a href="<?php echo e(route('pelanggan.service')); ?>"
                                                                        class="btn btn-primary btn-sm">Booking Ulang</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dokumen Sekolah 12\PKL\upj_tsm_k9\resources\views/pelanggan/history.blade.php ENDPATH**/ ?>