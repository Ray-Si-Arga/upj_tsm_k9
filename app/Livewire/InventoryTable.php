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

    public $inventory_id, $nama_barang, $jumlah_barang, $harga_beli, $harga_jual;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'nama_barang' => 'required|string|max:255',
        'jumlah_barang' => 'required|integer|min:0',
        'harga_beli' => 'required|numeric|min:0',
        'harga_jual' => 'required|numeric|min:0',
    ];

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

    #[On('create-inventory')]
    public function create()
    {
        $this->reset(['inventory_id', 'nama_barang', 'jumlah_barang', 'harga_beli', 'harga_jual']);
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->resetValidation();
        $inventory = Inventory::findOrFail($id);
        $this->inventory_id = $inventory->id;
        $this->nama_barang = $inventory->nama_barang;
        $this->jumlah_barang = $inventory->jumlah_barang;
        $this->harga_beli = $inventory->harga_beli;
        $this->harga_jual = $inventory->harga_jual;
    }

    public function store()
    {
        $this->validate();

        Inventory::updateOrCreate(
            ['id' => $this->inventory_id],
            [
                'nama_barang' => $this->nama_barang,
                'jumlah_barang' => $this->jumlah_barang,
                'harga_beli' => $this->harga_beli,
                'harga_jual' => $this->harga_jual,
            ]
        );

        session()->flash('success', $this->inventory_id ? 'Barang berhasil diperbarui!' : 'Barang berhasil ditambahkan!');

        $this->dispatch('close-modal');
        $this->create();
    }

    public function delete($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
        session()->flash('success', 'Barang berhasil dihapus!');
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
