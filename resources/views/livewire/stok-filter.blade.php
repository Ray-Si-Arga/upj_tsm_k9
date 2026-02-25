<div class="filter-tabs">
    <button class="filter-tab {{ $activeFilter === 'all' ? 'active' : '' }}"
        wire:click="setFilter('all')">Semua</button>
    <button class="filter-tab {{ $activeFilter === 'tipis' ? 'active' : '' }}" wire:click="setFilter('tipis')">
        <i class="fas fa-triangle-exclamation me-1 text-danger"></i>Stok Menipis
    </button>
    <button class="filter-tab {{ $activeFilter === 'aman' ? 'active' : '' }}" wire:click="setFilter('aman')">Stok
        Aman</button>
</div>