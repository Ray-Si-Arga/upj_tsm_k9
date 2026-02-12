<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
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
    public function create()
    {
        return view('inventory.create');
    }

    // Menyimpan Data
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required',
            'jumlah_barang' => 'required|integer|min:0',
            'harga_beli'    => 'required|numeric|min:0', // Update ini
            'harga_jual'    => 'required|numeric|min:0', // Tambah ini
        ]);

        Inventory::create($request->all());
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
            'harga_beli'    => 'required|numeric|min:0', // Update ini
            'harga_jual'    => 'required|numeric|min:0', // Tambah ini
        ]);

        $inventory->update($request->all());
        return redirect()->route('inventory.index')->with('success', 'Data Berhasil Di Edit');
    }

    // Menghapus Data
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Data Berhasil Di Hapus');
    }
}
