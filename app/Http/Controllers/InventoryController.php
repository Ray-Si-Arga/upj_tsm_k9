<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // ── Index ──────────────────────────────────────────
    public function index()
    {
        $Inventory   = Inventory::latest()->get();
        $totalItem   = $Inventory->count();
        $nilaiModal  = $Inventory->sum(fn($i) => $i->harga_beli * $i->jumlah_barang);
        $potensiLaba = $Inventory->sum(fn($i) => ($i->harga_jual - $i->harga_beli) * $i->jumlah_barang);
        $stokMenipis = $Inventory->where('jumlah_barang', '<=', 6)->count();

        return view('inventory.index', compact(
            'Inventory', 'totalItem', 'nilaiModal', 'potensiLaba', 'stokMenipis'
        ));
    }

    // ── Create ─────────────────────────────────────────
    public function create()
    {
        return view('inventory.create');
    }

    // ── Store ──────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required',
            'jumlah_barang' => 'required|integer|min:0',
            'harga_beli'    => 'required|numeric|min:0',
            'harga_jual'    => 'required|numeric|min:0',
        ]);

        $inventory = Inventory::create($request->all());

        // Catat ke tabel keuangan (pengeluaran pembelian stok)
        Keuangan::create([
            'tipe'         => 'pengeluaran',
            'judul'        => 'Pembelian: ' . $inventory->nama_barang,
            'nominal'      => $inventory->harga_beli * $inventory->jumlah_barang,
            'sumber'       => 'inventory',
            'kategori'     => 'inventory',
            'keterangan'   => 'Stok awal ' . $inventory->jumlah_barang . ' unit @ Rp ' . number_format($inventory->harga_beli, 0, ',', '.'),
            'referensi_id' => $inventory->id,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Data Berhasil Di Tambah');
    }

    // ── Edit ───────────────────────────────────────────
    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', compact('inventory'));
    }

    // ── Update ─────────────────────────────────────────
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'nama_barang'   => 'required',
            'jumlah_barang' => 'required|integer|min:0',
            'harga_beli'    => 'required|numeric|min:0',
            'harga_jual'    => 'required|numeric|min:0',
        ]);

        $inventory->update($request->all());

        // Update catatan keuangan yang terkait
        $keuangan = Keuangan::where('sumber', 'inventory')
                            ->where('referensi_id', $inventory->id)
                            ->latest()
                            ->first();

        if ($keuangan) {
            $keuangan->update([
                'judul'      => 'Pembelian: ' . $inventory->nama_barang,
                'nominal'    => $inventory->harga_beli * $inventory->jumlah_barang,
                'keterangan' => 'Stok ' . $inventory->jumlah_barang . ' unit @ Rp ' . number_format($inventory->harga_beli, 0, ',', '.'),
            ]);
        }

        return redirect()->route('inventory.index')->with('success', 'Data Berhasil Di Edit');
    }

    // ── Destroy ────────────────────────────────────────
    public function destroy(Inventory $inventory)
    {
        // Hapus juga catatan keuangan terkait
        Keuangan::where('sumber', 'inventory')
                ->where('referensi_id', $inventory->id)
                ->delete();

        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Data Berhasil Di Hapus');
    }
}