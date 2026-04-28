<?php
namespace App\Http\Controllers;
use Spatie\Browsershot\Browsershot;
use App\Models\ServiceAdvisor;
use App\Http\Controllers\Controller;
class CetakController extends Controller
{
    public function print($id)
    {
        $advisor = ServiceAdvisor::with(['booking.services', 'booking.user'])->findOrFail($id);

        if (is_string($advisor->spareparts) && !empty($advisor->spareparts)) {
            $advisor->spareparts = json_decode((string) $advisor->spareparts, true);
        } elseif (!is_array($advisor->spareparts)) {
            $advisor->spareparts = [];
        }


        $html = view('cetak.cetak_booking', compact('advisor'))->render();

        // Export ke JPEG
        // $imageContent = Browsershot::html($html)
        //     ->windowSize(794, 1123)
        //     ->setScreenshotType('jpeg', 100)
        //     ->emulateMedia('print')
        //     ->screenshot();

        $PDFContent = Browsershot::html($html)
            ->setChromePath('C:\Program Files\Google\Chrome\Application\chrome.exe')
            ->addChromiumArguments(['no-sandbox', 'disable-setuid-sandbox'])
            ->format('A4')
            ->showBackground()
            ->timeout(120)
            ->pdf();

        return response($PDFContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="invoice-ahass-' . $advisor->booking->queue_number . '.pdf"');
    }
}