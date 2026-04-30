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
     * Simpan Data ke Database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:64',
            'type' => 'required|in:paket,non_paket',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
        ],
        [
            'name.required' => 'Nama layanan harus diisi.',
            'name.min' => 'Nama layanan minimal 3 karakter.',
            'name.max' => 'Nama layanan maksimal 64 karakter.',
            'type.required' => 'Tipe layanan harus diisi.',
            'type.in' => 'Tipe layanan harus paket atau non_paket.',
            'price.required' => 'Harga layanan harus diisi.',
            'price.numeric' => 'Harga layanan harus berupa angka.',
            'price.min' => 'Harga layanan minimal Rp 0.',
            'description.max' => 'Deskripsi layanan maksimal 500 karakter.',
        ]
    );

        Service::create($request->all());

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan!');
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
