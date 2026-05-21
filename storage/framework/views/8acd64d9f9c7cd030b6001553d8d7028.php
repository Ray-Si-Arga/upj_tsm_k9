<div>
    <div class="table-container shadow-sm">
        <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center bg-white">
            <h6 class="fw-bold mb-0">Riwayat Transaksi Terbaru</h6>
            <div class="position-relative">
                <i class="fas fa-search position-absolute"
                    style="left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:0.85rem; pointer-events:none;"></i>
                <input
                    wire:model.live.debounce.400ms="search"
                    type="text"
                    class="form-control form-control-sm ps-4"
                    placeholder="Cari plat, nama, atau mekanik..."
                    style="min-width:280px; padding-left:34px !important;">

                
                <div wire:loading wire:target="search"
                    class="position-absolute"
                    style="right:10px; top:50%; transform:translateY(-50%);">
                    <div class="spinner-border text-secondary" role="status"
                        style="width:0.9rem; height:0.9rem; border-width:2px;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Jadwal &amp; Waktu</th>
                        <th>Pelanggan &amp; Kendaraan</th>
                        <th>Mekanik Bertugas</th>
                        <th>Pekerjaan</th>
                        <th class="text-end">Total Biaya</th>
                        <th class="text-center">Dokumen</th>
                    </tr>
                </thead>
                <tbody wire:loading.class="opacity-50" wire:target="search, gotoPage, nextPage, previousPage">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <tr>
                            <td class="text-center text-muted small"><?php echo e($index + $histories->firstItem()); ?></td>
                            <td>
                                <div class="fw-semibold text-dark"><?php echo e($data->created_at->format('d M Y')); ?></div>
                                <div class="text-muted x-small" style="font-size: 0.75rem;">
                                    <i class="far fa-clock me-1"></i><?php echo e($data->created_at->format('H:i')); ?>

                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-primary"><?php echo e(strtoupper($data->booking->plate_number ?? '-')); ?></div>
                                <div class="small text-muted"><?php echo e($data->booking->customer_name ?? '-'); ?> • <?php echo e($data->booking->vehicle_type ?? '-'); ?></div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="small fw-medium"><?php echo e($data->nama_mekanik ?? 'N/A'); ?></div>
                                </div>
                            </td>
                            <td>
                                <?php
                                    $jobs = $data->jobs;
                                    if (is_array($jobs) && count($jobs) > 0) {
                                        $jobLabel = implode(', ', array_column($jobs, 'name'));
                                    } elseif (is_string($jobs) && $jobs !== '') {
                                        $jobLabel = $jobs;
                                    } else {
                                        $jobLabel = 'General Service';
                                    }
                                ?>
                                <span class="badge-status badge-service"><?php echo e($jobLabel); ?></span>
                            </td>
                            <td class="text-end fw-bold text-dark">
                                Rp<?php echo e(number_format($data->total_estimation, 0, ',', '.')); ?>

                            </td>
                            <td class="text-center">
                                <a href="<?php echo e(route('advisor.preview', $data->id)); ?>" target="_blank" class="btn btn-print btn-sm" title="Cetak / Print">
                                    <i class="fas fa-file-pdf text-danger"></i>
                                </a>
                                <a href="<?php echo e(route('advisor.edit', $data->id)); ?>" class="btn btn-outline-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="7" class="py-5 text-center">
                                <img src="https://illustrations.popsy.co/slate/empty-folder.svg" alt="empty"
                                    style="width: 120px;" class="mb-3">
                                <h6 class="text-muted">Data transaksi tidak ditemukan</h6>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($histories->hasPages()): ?>
            <div class="px-4 py-3 bg-light border-top">
                <?php echo e($histories->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div><?php /**PATH D:\Dokumen Sekolah 12\PKL\TSM\upj_tsm_k9\resources\views\livewire\advisor-table.blade.php ENDPATH**/ ?>