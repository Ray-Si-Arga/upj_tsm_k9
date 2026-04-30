<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div class="notif-card" style="margin-bottom: 10px;">
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
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <div class="text-center py-4" style="color: var(--muted); font-size: .85rem;">
            <i class="fas fa-bell-slash mb-2 d-block" style="font-size: 1.8rem; color: var(--subtle);"></i>
            Tidak ada pengumuman.
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasMore): ?>
        <div class="text-center mt-3">
            <button wire:click="loadMore" class="btn-lainnya" wire:loading.attr="disabled" wire:target="loadMore">
                <span wire:loading.remove wire:target="loadMore">
                    <i class="fas fa-chevron-down"></i> Muat Lebih Banyak
                </span>
                <span wire:loading wire:target="loadMore">
                    <i class="fas fa-spinner fa-spin"></i> Memuat...
                </span>
            </button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH /home/hakuuu/Desktop/project/upj_tsm_k9/resources/views/livewire/notifikasi-modal.blade.php ENDPATH**/ ?>