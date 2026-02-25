<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // index
    public function index()
    {
        $Inventory = Inventory::latest()->get();
        return view('inventory.index', compact('Inventory'));
    }

    // Membuat Data
    // public function create()
    // {
    //     return view('inventory.create');
    // }

    // Menyimpan Data
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required',
            'jumlah_barang' => 'required|integer|min:0',
            'harga_beli'    => 'required|numeric|min:0',
            'harga_jual'    => 'required|numeric|min:0',
        ]);

        $inventory = Inventory::create($request->all());

        // Otomatis catat ke pengeluaran
        Pengeluaran::create([
            'judul'      => 'Pembelian : ' . $inventory->nama_barang,
            'nominal'    => $inventory->harga_beli * $inventory->jumlah_barang,
            'kategori'   => 'inventory',
            'keterangan' => 'Stok awal ' . $inventory->jumlah_barang . ' unit @ Rp ' . number_format($inventory->harga_beli, 0, ',', '.'),
        ]);

        return redirect()->route('inventory.index')->with('success', 'Data Berhasil Di Tambah');
    }

    // Mengedit Data
    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', compact('inventory'));
    }

    // Mengupdate Data
    public function update(Request $request, Inventory $inventory)
{
    $request->validate([
        'nama_barang'   => 'required',
        'jumlah_barang' => 'required|integer|min:0',
        'harga_beli'    => 'required|numeric|min:0',
        'harga_jual'    => 'required|numeric|min:0',
    ]);

    $inventory->update($request->all());

    // Update data pengeluaran yang terkait di tabel keuangan
    $pengeluaran = Pengeluaran::where('kategori', 'inventory')
        ->where('judul', 'like', 'Pembelian : ' . $inventory->nama_barang . '%')
        ->orWhere('judul', 'like', 'Pembelian : ' . $request->nama_barang . '%')
        ->first();

    if ($pengeluaran) {
        $pengeluaran->update([
            'judul'      => 'Pembelian : ' . $inventory->nama_barang,
            'nominal'    => $inventory->harga_beli * $inventory->jumlah_barang,
            'keterangan' => 'Stok ' . $inventory->jumlah_barang . ' unit @ Rp ' . number_format($inventory->harga_beli, 0, ',', '.'),
        ]);
    }

    return redirect()->route('inventory.index')->with('success', 'Data Berhasil Di Edit');
}

    // Menghapus Data
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Data Berhasil Di Hapus');
    }
}
