<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Inventory;
use App\Models\Keuangan;

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

        $isEdit = (bool) $this->inventory_id;

        if ($isEdit) {
            // ── MODE EDIT ──────────────────────────────────────
            $inventory = Inventory::findOrFail($this->inventory_id);
            $inventory->update([
                'nama_barang' => $this->nama_barang,
                'jumlah_barang' => $this->jumlah_barang,
                'harga_beli' => $this->harga_beli,
                'harga_jual' => $this->harga_jual,
            ]);

            // Update catatan keuangan yang terkait
            $keuangan = Keuangan::where('sumber', 'inventory')
                ->where('referensi_id', $inventory->id)
                ->latest()
                ->first();
            if ($keuangan) {
                $keuangan->update([
                    'judul' => 'Pembelian: ' . $inventory->nama_barang,
                    'nominal' => $inventory->harga_beli * $inventory->jumlah_barang,
                    'keterangan' => 'Stok ' . $inventory->jumlah_barang . ' unit @ Rp ' . number_format($inventory->harga_beli, 0, ',', '.'),
                ]);
            }

        } else {
            // ── MODE TAMBAH BARU ────────────────────────────────
            $inventory = Inventory::create([
                'nama_barang' => $this->nama_barang,
                'jumlah_barang' => $this->jumlah_barang,
                'harga_beli' => $this->harga_beli,
                'harga_jual' => $this->harga_jual,
            ]);

            // Catat pengeluaran ke tabel keuangan
            Keuangan::create([
                'tipe' => 'pengeluaran',
                'judul' => 'Pembelian: ' . $inventory->nama_barang,
                'nominal' => $inventory->harga_beli * $inventory->jumlah_barang,
                'sumber' => 'inventory',
                'kategori' => 'inventory',
                'keterangan' => 'Stok awal ' . $inventory->jumlah_barang . ' unit @ Rp ' . number_format($inventory->harga_beli, 0, ',', '.'),
                'referensi_id' => $inventory->id,
            ]);
        }

        session()->flash('success', $isEdit ? 'Barang berhasil diperbarui!' : 'Barang berhasil ditambahkan!');

        $this->dispatch('close-modal');
        $this->create();
    }

    public function delete($id)
    {
        $inventory = Inventory::findOrFail($id);

        // Hapus catatan keuangan terkait
        Keuangan::where('sumber', 'inventory')
            ->where('referensi_id', $inventory->id)
            ->delete();

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