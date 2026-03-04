<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Jadwal;

class NotifikasiModal extends Component
{
    public int $perPage = 10;

    public function loadMore(): void
    {
        $this->perPage += 10;
    }

    public function render()
    {
        // Ambil perPage + 1 untuk mendeteksi apakah masih ada data berikutnya
        $all = Jadwal::where('date', '>=', now()->toDateString())
            ->where('is_closed', true)
            ->orderBy('date', 'asc')
            ->limit($this->perPage + 1)
            ->get();

        $hasMore = $all->count() > $this->perPage;
        $items = $all->take($this->perPage);

        return view('livewire.notifikasi-modal', compact('items', 'hasMore'));
    }
}
