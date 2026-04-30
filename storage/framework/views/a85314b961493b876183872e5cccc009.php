<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasPages()): ?>
    <div class="custom-mobile-pagination d-flex justify-content-between align-items-center mt-3 pt-3 border-top w-100">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->onFirstPage()): ?>
            <button class="btn-mobile-nav disabled" disabled>
                <i class="fas fa-chevron-left me-2"></i> Sebelumnya
            </button>
        <?php else: ?>
            <button class="btn-mobile-nav" wire:click="previousPage" wire:loading.attr="disabled" rel="prev">
                <i class="fas fa-chevron-left me-2"></i> Sebelumnya
            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasMorePages()): ?>
            <button class="btn-mobile-nav" wire:click="nextPage" wire:loading.attr="disabled" rel="next">
                Selanjutnya <i class="fas fa-chevron-right ms-2"></i>
            </button>
        <?php else: ?>
            <button class="btn-mobile-nav disabled" disabled>
                Selanjutnya <i class="fas fa-chevron-right ms-2"></i>
            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <style>
        .custom-mobile-pagination .btn-mobile-nav {
            background: #fff;
            border: 1px solid #e2e8f0;
            color: var(--text, #1e293b);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
            text-decoration: none;
        }

        .custom-mobile-pagination .btn-mobile-nav:not(.disabled):hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .custom-mobile-pagination .btn-mobile-nav.disabled {
            background: #f8fafc;
            color: #94a3b8;
            border-color: #f1f5f9;
            cursor: not-allowed;
            box-shadow: none;
        }
    </style>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH C:\Users\HP\Downloads\upj_tsm_k9\resources\views/livewire/mobile-pagination.blade.php ENDPATH**/ ?>