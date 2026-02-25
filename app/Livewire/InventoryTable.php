<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Inventory;

class InventoryTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStok = 'all';

    protected $paginationTheme = 'bootstrap';

    #[On('searchUpdated')]
    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    #[On('filterUpdated')]
    public function updateFilter($filter)
    {
        $this->filterStok = $filter;
        $this->resetPage();
    }

    public function render()
    {
        $query = Inventory::latest();

        if ($this->search) {
            $query->where('nama_barang', 'like', '%' . $this->search . '%');
        }

        if ($this->filterStok === 'tipis') {
            $query->where('jumlah_barang', '<=', 6);
        } elseif ($this->filterStok === 'aman') {
            $query->where('jumlah_barang', '>', 6);
        }

        $inventories = $query->paginate(10);

        return view('livewire.inventory-table', [
            'Inventory' => $inventories
        ]);
    }
}
