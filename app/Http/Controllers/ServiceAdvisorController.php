<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ServiceAdvisor;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use PDF; // from barryvdh/laravel-dompdf

class ServiceAdvisorController extends Controller
{
    public function create()
    {
        $bookings = \App\Models\Booking::with('service')->get();
        return view('advisor.create', compact('bookings'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'spareparts' => 'nullable|string',
            'customer_complaint' => 'nullable|string',
            'advisor_notes' => 'nullable|string',
        ]);

        $booking = \App\Models\Booking::with('service')->findOrFail($request->booking_id);

        $servicePrice = $booking->service->price;
        $spareparts = [];
        $totalParts = 0;

        if ($request->spareparts) {
            $items = explode(',', $request->spareparts);

            foreach ($items as $item) {
                $item = trim($item);
                if ($item === '') continue;

                // Pecah lagi berdasarkan "|"
                $parts = explode('|', $item);

                if (count($parts) === 2) {
                    [$name, $price] = array_map('trim', $parts);

                    $price = (int) $price;
                    $spareparts[] = [
                        'name' => $name,
                        'price' => $price
                    ];

                    $totalParts += $price;
                }
            }
        }

        $advisor = \App\Models\ServiceAdvisor::create([
            'booking_id'        => $booking->id,
            'jobs'              => $booking->service->name,
            'estimation_cost'   => $servicePrice,
            'spareparts' => $spareparts,
            'estimation_parts'  => $totalParts,
            'total_estimation'  => $servicePrice + $totalParts,
            'customer_complaint' => $request->customer_complaint,
            'advisor_notes'     => $request->advisor_notes,
        ]);

        return redirect()->route('advisor.print', $advisor->id);
    }

    public function print($id)
    {
        $advisor = ServiceAdvisor::with('booking.service')->findOrFail($id);

        if (is_string($advisor->spareparts)) {
            $advisor->spareparts = json_decode($advisor->spareparts, true);
        }

        $pdf = FacadePdf::loadView('advisor.print', compact('advisor'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('service_advisor_' . $advisor->id . '.pdf');
    }
}
