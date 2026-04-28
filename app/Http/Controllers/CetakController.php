<?php
namespace App\Http\Controllers;
use App\Models\ServiceAdvisor;
use App\Http\Controllers\Controller;
class CetakController extends Controller
{
    public function preview($id)
    {
        $advisor = ServiceAdvisor::with(['booking.services', 'booking.user'])->findOrFail($id);

        if (is_string($advisor->spareparts) && !empty($advisor->spareparts)) {
            $advisor->spareparts = json_decode((string) $advisor->spareparts, true);
        } elseif (!is_array($advisor->spareparts)) {
            $advisor->spareparts = [];
        }

        return view('cetak.cetak_booking', compact('advisor'));
    }
}