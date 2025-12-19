<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ServiceAdvisor;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use PDF; // from barryvdh/laravel-dompdf

class ServiceAdvisorController extends Controller
{

    public function index()
    {
        $histories = ServiceAdvisor::with(['booking.service'])
            ->latest()
            ->paginate(10);
        return view('advisor.index', compact('histories'));
    }

    public function create()
    {
        $bookings = \App\Models\Booking::with('service')->get();
        // Ambil data inventory yang stoknya > 0 untuk ditampilkan di dropdown
        $spareparts = Inventory::where('jumlah_barang', '>', 0)->get();

        return view('advisor.create', compact('bookings', 'spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'nama_mekanik' => 'required|string|max:255',
            'customer_complaint' => 'nullable|string',
            'advisor_notes' => 'nullable|string',
            'parts_id' => 'nullable|array',
            'parts_id.*' => 'exists:inventory,id',
            'parts_qty' => 'nullable|array',
            'parts_qty.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // 1. Ambil data Booking
            $booking = \App\Models\Booking::with('service')->findOrFail($request->booking_id);
            $servicePrice = $booking->service->price;

            // 2. Logika Inventory (Sama seperti sebelumnya)
            $processedParts = [];
            $totalPartsCost = 0;

            if ($request->parts_id) {
                foreach ($request->parts_id as $index => $inventoryId) {
                    $qty = $request->parts_qty[$index];
                    $price = $request->parts_price[$index]; // Ambil dari input hidden

                    $inventoryItem = Inventory::lockForUpdate()->find($inventoryId);

                    if (!$inventoryItem || $inventoryItem->jumlah_barang < $qty) {
                        DB::rollBack();
                        return back()->with('error', "Stok {$inventoryItem->nama_barang} kurang! Sisa: {$inventoryItem->jumlah_barang}");
                    }

                    $inventoryItem->decrement('jumlah_barang', $qty);

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

            // 3. Simpan Data Service Advisor
            $advisor = \App\Models\ServiceAdvisor::create([
                'booking_id'        => $booking->id,
                'nama_mekanik'     => $request->nama_mekanik, // Sesuaikan dengan nama kolom di DB
                'jobs'              => $booking->service->name,
                'estimation_cost'   => $servicePrice,
                'spareparts'        => $processedParts,
                'estimation_parts'  => $totalPartsCost,
                'total_estimation'  => $servicePrice + $totalPartsCost,
                'customer_complaint' => $request->customer_complaint,
                'advisor_notes'     => $request->advisor_notes,
            ]);

            // === [FITUR BARU] UPDATE STATUS BOOKING ===
            // Mengubah status antrian menjadi 'done' (Selesai)
            $booking->status = 'done';
            $booking->save();
            // ==========================================

            DB::commit();

            // Redirect kembali ke form dengan membawa ID Invoice untuk didownload otomatis
            return redirect()->route('advisor.create')
                ->with('success', 'Servis Selesai! Status antrian diperbarui & Invoice didownload.')
                ->with('print_invoice_id', $advisor->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function print($id)
    {
        $advisor = ServiceAdvisor::with('booking.service')->findOrFail($id);

        if (is_string($advisor->spareparts)) {
            $advisor->spareparts = json_decode($advisor->spareparts, true);
        }

        $pdf = FacadePdf::loadView('advisor.print', compact('advisor'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('service_advisor_' . $advisor->id . '.pdf');
    }
}
