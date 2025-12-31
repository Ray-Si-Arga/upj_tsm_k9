<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ServiceAdvisor;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf; // Pastikan import ini benar

class ServiceAdvisorController extends Controller
{
    /**
     * Halaman Utama Riwayat Service Advisor
     */
    public function index()
    {
        // PERBAIKAN: Ubah 'booking.service' menjadi 'booking.services'
        $histories = ServiceAdvisor::with(['booking.services'])
            ->latest()
            ->paginate(10);

        return view('advisor.index', compact('histories'));
    }

    /**
     * Halaman Form Pengecekan (Create)
     */
    public function create()
    {
        // Ambil booking yang statusnya 'approved' (Diterima)
        $bookings = Booking::with('services')
            ->where('status', 'approved')
            ->get();

        // Ambil sparepart yang stoknya tersedia
        $spareparts = Inventory::where('jumlah_barang', '>', 0)->get();

        return view('advisor.create', compact('bookings', 'spareparts'));
    }

    /**
     * Simpan Data Pengecekan & Sparepart
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'nama_mekanik' => 'required|string|max:255',
            'customer_complaint' => 'nullable|string',
            'advisor_notes' => 'nullable|string',

            // Validasi Data Pembawa & Pemilik (FITUR BARU)
            'carrier_name' => 'required|string|max:255',
            'carrier_phone' => 'required|string|max:20',
            'owner_name' => 'required|string|max:255',

            // Validasi Data Kendaraan (FITUR BARU)
            'odometer' => 'required', // Bisa string/numeric krn nanti di-clean

            'parts_id' => 'nullable|array',
            'parts_qty' => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            // Ambil data Booking beserta layanan-layanannya
            $booking = Booking::with('services')->findOrFail($request->booking_id);

            // PERBAIKAN: Hitung total harga dari BANYAK layanan
            $servicePrice = $booking->services->sum('price');
            // Gabungkan nama layanan (Contoh: "Ganti Oli, Tambal Ban")
            $jobNames = $booking->services->pluck('name')->implode(', ');

            // --- LOGIKA SPAREPART ---
            $processedParts = [];
            $totalPartsCost = 0;

            if ($request->parts_id) {
                foreach ($request->parts_id as $index => $inventoryId) {
                    $qty = $request->parts_qty[$index];

                    // Lock for update untuk mencegah race condition stok
                    $inventoryItem = Inventory::lockForUpdate()->find($inventoryId);

                    if (!$inventoryItem || $inventoryItem->jumlah_barang < $qty) {
                        DB::rollBack();
                        return back()->with('error', "Stok {$inventoryItem->nama_barang} kurang! Sisa: {$inventoryItem->jumlah_barang}");
                    }

                    // Kurangi Stok
                    $inventoryItem->decrement('jumlah_barang', $qty);

                    $price = $inventoryItem->harga_barang;
                    $subtotal = $price * $qty;

                    $processedParts[] = [
                        'id' => $inventoryItem->id,
                        'name' => $inventoryItem->nama_barang,
                        'qty' => $qty,
                        'price' => $price,
                        'subtotal' => $subtotal
                    ];
                    $totalPartsCost += $subtotal;
                }
            }

            // --- SIMPAN DATA LENGKAP KE SERVICE ADVISOR ---
            $advisor = ServiceAdvisor::create([
                'booking_id'        => $booking->id,
                'nama_mekanik'      => $request->nama_mekanik,
                'jobs'              => $jobNames, // Simpan string gabungan nama service
                'estimation_cost'   => $servicePrice,
                'spareparts'        => $processedParts, // Akan otomatis jadi JSON jika di-cast di Model
                'estimation_parts'  => $totalPartsCost,
                'total_estimation'  => $servicePrice + $totalPartsCost,
                'customer_complaint' => $request->customer_complaint,
                'advisor_notes'     => $request->advisor_notes,

                // DATA BARU (Pastikan field ini ada di $fillable Model ServiceAdvisor)
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

                // Hapus titik dari format ribuan (misal "15.000" jadi "15000")
                'odometer'          => str_replace('.', '', $request->odometer),

                'vehicle_year'      => $request->vehicle_year,
                'engine_number'     => $request->engine_number,
                'chassis_number'    => $request->chassis_number,
                'customer_email'    => $request->customer_email,
                'customer_social'   => $request->customer_social,
            ]);

            // Update status booking jadi done
            $booking->status = 'done';
            $booking->save();

            DB::commit();

            return redirect()->route('advisor.create')
                ->with('success', 'Servis Selesai! Data Tersimpan.')
                ->with('print_invoice_id', $advisor->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Cetak Invoice PDF
     */
    public function print($id)
    {
        // PERBAIKAN: Ubah 'booking.service' menjadi 'booking.services'
        $advisor = ServiceAdvisor::with('booking.services')->findOrFail($id);

        // Decode JSON jika tersimpan sebagai string (untuk jaga-jaga)
        if (is_string($advisor->spareparts)) {
            $advisor->spareparts = json_decode($advisor->spareparts, true);
        }

        $pdf = FacadePdf::loadView('advisor.print', compact('advisor'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('invoice_service_' . $advisor->id . '.pdf');
    }
}
