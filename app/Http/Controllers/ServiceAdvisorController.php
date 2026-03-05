<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ServiceAdvisor;
use App\Models\Inventory;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceAdvisorController extends Controller
{
    /**
     * Halaman Utama Riwayat Service Advisor
     */
    public function index(Request $request)
    {
        $query = ServiceAdvisor::with(['booking.services']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mekanik', 'like', "%{$search}%")
                    ->orWhereHas('booking', function ($b) use ($search) {
                        $b->where('plate_number', 'like', "%{$search}%")
                            ->orWhere('customer_name', 'like', "%{$search}%")
                            ->orWhere('vehicle_type', 'like', "%{$search}%");
                    });
            });
        }

        $histories = $query->latest()->paginate(10);
        $histories->appends(['search' => $request->search]);

        return view('advisor.index', compact('histories'));
    }

    /**
     * Halaman Form Pengecekan (Create)
     */
    public function create()
    {
        $bookings = Booking::with('services')
            ->where('status', 'approved')
            ->get();

        $spareparts = Inventory::where('jumlah_barang', '>', 0)->get();
        $services   = \App\Models\Service::all();

        return view('advisor.create', compact('bookings', 'spareparts', 'services'));
    }

    /**
     * Simpan Data Pengecekan & Sparepart
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id'        => 'required|exists:bookings,id',
            'nama_mekanik'      => 'required|string|max:255',
            'customer_complaint'=> 'nullable|string',
            'advisor_notes'     => 'nullable|string',
            'carrier_name'      => 'required|string|max:255',
            'carrier_phone'     => 'required|string|max:20',
            'owner_name'        => 'required|string|max:255',
            'odometer'          => 'required',
            'parts_id'          => 'nullable|array',
            'parts_qty'         => 'nullable|array',
            
            'pkb_approval'      => 'required',
            'part_bekas_dibawa' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $booking = Booking::with('services')->findOrFail($request->booking_id);

            // --- JOBS ---
            $jobsNames  = $request->input('jobs_name', []);
            $jobsPrices = $request->input('jobs_price', []);
            $processedJobs = [];
            $servicePrice  = 0;

            foreach ($jobsNames as $index => $name) {
                $name = trim($name);
                if ($name === '') continue;
                $price = isset($jobsPrices[$index]) ? (int) $jobsPrices[$index] : 0;
                $servicePrice += $price;
                $processedJobs[] = ['name' => $name, 'price' => $price];
            }

            // --- SPAREPART ---
            $processedParts = [];
            $totalPartsCost = 0;

            if ($request->parts_id) {
                foreach ($request->parts_id as $index => $inventoryId) {
                    $qty = $request->parts_qty[$index];
                    $inventoryItem = Inventory::lockForUpdate()->find($inventoryId);

                    if (!$inventoryItem || $inventoryItem->jumlah_barang < $qty) {
                        DB::rollBack();
                        return back()->with('error', "Stok {$inventoryItem->nama_barang} kurang! Sisa: {$inventoryItem->jumlah_barang}");
                    }

                    $inventoryItem->decrement('jumlah_barang', $qty);

                    $price    = $inventoryItem->harga_jual;
                    $subtotal = $price * $qty;

                    $processedParts[] = [
                        'id'       => $inventoryItem->id,
                        'name'     => $inventoryItem->nama_barang,
                        'qty'      => $qty,
                        'price'    => $price,
                        'subtotal' => $subtotal,
                    ];
                    $totalPartsCost += $subtotal;
                }
            }

            // --- SIMPAN ---
            $advisor = ServiceAdvisor::create([
                'booking_id'        => $booking->id,
                'nama_mekanik'      => $request->nama_mekanik,
                'jobs'              => $processedJobs,
                'estimation_cost'   => $servicePrice,
                'spareparts'        => $processedParts,
                'estimation_parts'  => $totalPartsCost,
                'total_estimation'  => $servicePrice + $totalPartsCost,
                'customer_complaint'=> $request->customer_complaint,
                'advisor_notes'     => $request->advisor_notes,
                'carrier_name'      => $request->carrier_name,
                'carrier_address'   => $request->carrier_address,
                'carrier_area'      => $request->carrier_area,
                'carrier_phone'     => $request->carrier_phone,
                'relationship'      => $request->relationship,
                'owner_name'        => $request->owner_name,
                'owner_address'     => $request->owner_address,
                'owner_area'        => $request->owner_area,
                'owner_phone'       => $request->owner_phone,
                'is_own_dealer'     => $request->is_own_dealer ?? 0,
                'visit_reason'      => $request->visit_reason,
                'odometer'          => str_replace('.', '', $request->odometer),
                'vehicle_year'      => $request->vehicle_year,
                'engine_number'     => $request->engine_number,
                'chassis_number'    => $request->chassis_number,
                'customer_email'    => $request->customer_email,
                'customer_social'   => $request->customer_social,
                //'fuel_level'        => $request->fuel_level,
                'pkb_approval'      => $request->pkb_approval,
                'part_bekas_dibawa' => $request->part_bekas_dibawa,
            ]);

            $booking->status = 'done';
            $booking->save();

            $firstJobName = !empty($processedJobs) ? $processedJobs[0]['name'] : 'Servis Kendaraan';

            Keuangan::create([
                'tipe'         => 'pemasukan',
                'judul'        => 'Service: ' . $firstJobName,
                'nominal'      => $advisor->total_estimation,
                'sumber'       => 'service',
                'kategori'     => 'service',
                'keterangan'   => ($booking->customer_name ?? '-') . ' • ' . ($booking->plate_number ?? '-') . ' • Mekanik: ' . ($advisor->nama_mekanik ?? '-'),
                'referensi_id' => $advisor->id,
            ]);

            DB::commit();

            return redirect()->route('advisor.index')
                ->with('success', 'Servis Selesai! Data Tersimpan.')
                ->with('print_invoice_id', $advisor->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Halaman Form Edit
     */
    public function edit($id)
    {
        $advisor    = ServiceAdvisor::with('booking')->findOrFail($id);
        $spareparts = Inventory::where('jumlah_barang', '>', 0)->get();
        $services   = \App\Models\Service::all();

        return view('advisor.edit', compact('advisor', 'spareparts', 'services'));
    }

    /**
     * Update Data Service Advisor
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mekanik'      => 'required|string|max:255',
            'customer_complaint'=> 'nullable|string',
            'advisor_notes'     => 'nullable|string',
            'carrier_name'      => 'required|string|max:255',
            'carrier_phone'     => 'required|string|max:20',
            'owner_name'        => 'required|string|max:255',
            'odometer'          => 'required',
            'parts_id'          => 'nullable|array',
            'parts_qty'         => 'nullable|array',
            //'fuel_level'        => 'required|string',
            'pkb_approval'      => 'required',
            'part_bekas_dibawa' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $advisor = ServiceAdvisor::findOrFail($id);

            // --- KEMBALIKAN STOK SPAREPART LAMA ---
            $oldParts = is_array($advisor->spareparts) ? $advisor->spareparts : [];
            foreach ($oldParts as $oldPart) {
                $invItem = Inventory::find($oldPart['id'] ?? null);
                if ($invItem) {
                    $invItem->increment('jumlah_barang', $oldPart['qty'] ?? 0);
                }
            }

            // --- JOBS ---
            $jobsNames  = $request->input('jobs_name', []);
            $jobsPrices = $request->input('jobs_price', []);
            $processedJobs = [];
            $servicePrice  = 0;

            foreach ($jobsNames as $index => $name) {
                $name = trim($name);
                if ($name === '') continue;
                $price = isset($jobsPrices[$index]) ? (int) $jobsPrices[$index] : 0;
                $servicePrice += $price;
                $processedJobs[] = ['name' => $name, 'price' => $price];
            }

            // --- SPAREPART BARU ---
            $processedParts = [];
            $totalPartsCost = 0;

            if ($request->parts_id) {
                foreach ($request->parts_id as $index => $inventoryId) {
                    $qty = $request->parts_qty[$index];
                    $inventoryItem = Inventory::lockForUpdate()->find($inventoryId);

                    if (!$inventoryItem || $inventoryItem->jumlah_barang < $qty) {
                        DB::rollBack();
                        $name = $inventoryItem ? $inventoryItem->nama_barang : "ID:{$inventoryId}";
                        $sisa = $inventoryItem ? $inventoryItem->jumlah_barang : 0;
                        return back()->with('error', "Stok {$name} kurang! Sisa: {$sisa}")->withInput();
                    }

                    $inventoryItem->decrement('jumlah_barang', $qty);

                    $price    = $inventoryItem->harga_jual;
                    $subtotal = $price * $qty;

                    $processedParts[] = [
                        'id'       => $inventoryItem->id,
                        'name'     => $inventoryItem->nama_barang,
                        'qty'      => $qty,
                        'price'    => $price,
                        'subtotal' => $subtotal,
                    ];
                    $totalPartsCost += $subtotal;
                }
            }

            // --- UPDATE DATA ---
            $advisor->update([
                'nama_mekanik'      => $request->nama_mekanik,
                'jobs'              => $processedJobs,
                'estimation_cost'   => $servicePrice,
                'spareparts'        => $processedParts,
                'estimation_parts'  => $totalPartsCost,
                'total_estimation'  => $servicePrice + $totalPartsCost,
                'customer_complaint'=> $request->customer_complaint,
                'advisor_notes'     => $request->advisor_notes,
                'carrier_name'      => $request->carrier_name,
                'carrier_address'   => $request->carrier_address,
                'carrier_area'      => $request->carrier_area,
                'carrier_phone'     => $request->carrier_phone,
                'relationship'      => $request->relationship,
                'owner_name'        => $request->owner_name,
                'owner_address'     => $request->owner_address,
                'owner_area'        => $request->owner_area,
                'owner_phone'       => $request->owner_phone,
                'is_own_dealer'     => $request->is_own_dealer ?? 0,
                'visit_reason'      => $request->visit_reason,
                'odometer'          => str_replace('.', '', $request->odometer),
                'vehicle_year'      => $request->vehicle_year,
                'engine_number'     => $request->engine_number,
                'chassis_number'    => $request->chassis_number,
                'customer_email'    => $request->customer_email,
                'customer_social'   => $request->customer_social,
                //'fuel_level'        => $request->fuel_level,
                'pkb_approval'      => $request->pkb_approval,
                'part_bekas_dibawa' => $request->part_bekas_dibawa,
            ]);

            // --- UPDATE DATA KEUANGAN ---
            $firstJobName = !empty($processedJobs) ? $processedJobs[0]['name'] : 'Servis Kendaraan';
            $booking = $advisor->booking;

            $keuangan = Keuangan::where('referensi_id', $advisor->id)
                ->where('sumber', 'service')
                ->first();

            if ($keuangan) {
                $keuangan->update([
                    'judul'      => 'Service: ' . $firstJobName,
                    'nominal'    => $advisor->total_estimation,
                    'keterangan' => ($booking->customer_name ?? '-') . ' • ' . ($booking->plate_number ?? '-') . ' • Mekanik: ' . ($advisor->nama_mekanik ?? '-'),
                ]);
            }

            DB::commit();

            return redirect()->route('advisor.index')
                ->with('success', 'Data service berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus Data Service Advisor
     */
    //public function destroy($id)
    //{
    //    DB::beginTransaction();
    //    try {
    //        $advisor = ServiceAdvisor::findOrFail($id);
//
    //        // Kembalikan stok sparepart
    //        $parts = is_array($advisor->spareparts) ? $advisor->spareparts : [];
    //        foreach ($parts as $part) {
    //            $invItem = Inventory::find($part['id'] ?? null);
    //            if ($invItem) {
    //                $invItem->increment('jumlah_barang', $part['qty'] ?? 0);
    //            }
    //        }
//
    //        // Hapus data keuangan terkait
    //        Keuangan::where('referensi_id', $advisor->id)->where('sumber', 'service')->delete();
//
    //        $advisor->delete();
//
    //        DB::commit();
    //        return redirect()->route('advisor.index')->with('success', 'Data service berhasil dihapus.');
    //    } catch (\Exception $e) {
    //        DB::rollBack();
    //        return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
    //    }
    //}
}