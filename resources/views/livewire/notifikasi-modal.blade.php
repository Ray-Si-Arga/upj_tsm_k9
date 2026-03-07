<div>
    @forelse($items as $note)
        <div class="notif-card" style="margin-bottom: 10px;">
            <div class="notif-stripe" style="background:{{ $note->color ?? 'var(--red)' }};"></div>
            <div class="notif-body">
                <div class="notif-title">{{ $note->title }}</div>
                @if($note->description)
                    <div class="notif-desc">{{ $note->description }}</div>
                @endif
                <div class="notif-date">
                    <i class="far fa-calendar me-1"></i>
                    {{ \Carbon\Carbon::parse($note->date)->locale('id')->translatedFormat('d F Y') }}
                </div>
            </div>
            <div class="badge-tutup">Tutup</div>
        </div>
    @empty
        <div class="text-center py-4" style="color: var(--muted); font-size: .85rem;">
            <i class="fas fa-bell-slash mb-2 d-block" style="font-size: 1.8rem; color: var(--subtle);"></i>
            Tidak ada pengumuman.
        </div>
    @endforelse

    @if($hasMore)
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
    @endif
</div>