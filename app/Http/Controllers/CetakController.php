<?php
namespace App\Http\Controllers;
use Spatie\Browsershot\Browsershot;
use App\Models\ServiceAdvisor;
use App\Models\User;
use App\Models\Inventory;
use App\Http\Controllers\Controller;
class CetakController extends Controller
{
    public function print($id)
    {
        $advisor = ServiceAdvisor::with(['booking.services', 'booking.user'])->findOrFail($id);

        if (is_string($advisor->spareparts)) {
            $advisor->spareparts = json_decode($advisor->spareparts, true);
        }


        $html = view('cetak.cetak_booking', compact('advisor'))->render();

        // Export ke JPEG
        // $imageContent = Browsershot::html($html)
        //     ->windowSize(794, 1123)
        //     ->setScreenshotType('jpeg', 100)
        //     ->emulateMedia('print')
        //     ->screenshot();

            $PDFContent = Browsershot::html($html)
        ->setChromePath('/usr/bin/google-chrome-stable') // Path yang kamu temukan tadi
        ->addArgs(['--no-sandbox', '--disable-setuid-sandbox']) // Wajib untuk Linux
        ->format('A4')
        ->showBackground()
        ->pdf();
    
        return response($PDFContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="invoice-ahass-' . $advisor->booking->queue_number . '.pdf"');
    }
}