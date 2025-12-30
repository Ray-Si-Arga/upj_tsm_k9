<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    /**
     * Tampilkan Daftar Layanan
     */
    public function index()
    {
        // Ambil semua data service
        $services = Service::all();
        return view('layanan.index', compact('services'));
    }

    /**
     * Tampilkan Form Tambah Layanan
     */
    public function create()
    {
        return view('layanan.create');
    }

    /**
     * Simpan Data ke Database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:paket,non_paket',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string', // Wajib diisi jika type = paket (bisa diatur logic di view)
        ]);

        Service::create($request->all());

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Tampilkan Form Edit
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('layanan.edit', compact('service'));
    }

    /**
     * Update Data
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:paket,non_paket',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $service = Service::findOrFail($id);
        $service->update($request->all());

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Hapus Data
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
