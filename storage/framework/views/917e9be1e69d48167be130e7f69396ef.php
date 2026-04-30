<div class="filter-tabs">
    <button class="filter-tab <?php echo e($activeFilter === 'all' ? 'active' : ''); ?>"
        wire:click="setFilter('all')">Semua</button>
    <button class="filter-tab <?php echo e($activeFilter === 'tipis' ? 'active' : ''); ?>" wire:click="setFilter('tipis')">
        <i class="fas fa-triangle-exclamation me-1 text-danger"></i>Stok Menipis
    </button>
    <button class="filter-tab <?php echo e($activeFilter === 'aman' ? 'active' : ''); ?>" wire:click="setFilter('aman')">Stok
        Aman</button>
</div><?php /**PATH D:\Dokumen Sekolah 12\PKL\upj_tsm_k9\resources\views/livewire/stok-filter.blade.php ENDPATH**/ ?>