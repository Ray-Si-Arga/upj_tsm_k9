<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;

class KeuanganController extends Controller
{
    // ──────────────────────────────────────────────────────────
    // INDEX — Halaman utama keuangan
    // ──────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('pelanggan.dashboard')
                ->with('error', 'Akses dibatasi untuk Admin.');
        }

        // 1. Tentukan periode & rentang tanggal
        $periode = $request->get('periode', 'bulanan');
        $now     = Carbon::now();

        [$startDate, $endDate, $labelPeriode] = $this->getPeriode($periode, $now, $request);

        // 2. Query dasar dalam periode
        $baseQuery = Keuangan::periode($startDate, $endDate);

        // 3. Hitung ringkasan
        $totalPemasukan   = (clone $baseQuery)->pemasukan()->sum('nominal');
        $totalPengeluaran = (clone $baseQuery)->pengeluaran()->sum('nominal');
        $saldo            = $totalPemasukan - $totalPengeluaran;

        // Badge summary cards
        $jumlahTransaksiService = (clone $baseQuery)->pemasukan()->dariService()->count();
        $jumlahTransaksiManual  = (clone $baseQuery)->count();

        // Alias untuk kompatibilitas view lama
        $jumlahItemInventory = (clone $baseQuery)->pengeluaran()->count();

        // 4. History transaksi — semua key yang dibutuhkan view disertakan
        $historyTransaksi = (clone $baseQuery)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id'        => $item->id,
                    'tanggal'   => $item->created_at,
                    'tipe'      => $item->tipe,
                    'deskripsi' => $item->judul,
                    'sub_info'  => $item->keterangan ?? '-',
                    'mekanik'   => '-',   // Tidak ada di tabel keuangan; view perlu key ini
                    'sumber'    => $item->sumber,
                    'kategori'  => $item->kategori ?? '-',
                    'nominal'   => $item->nominal,
                    'icon'      => $item->tipe === 'pemasukan'
                                    ? 'fa-arrow-trend-up'
                                    : 'fa-arrow-trend-down',
                ];
            });

        // 5. Chart data
        $chartData = $this->getChartData($periode, $now);
        
        return view('keuangan.index', compact(
            'periode',
            'labelPeriode',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'jumlahTransaksiService',
            'jumlahTransaksiManual',
            'jumlahItemInventory',
            'historyTransaksi',
            'chartData'
        ));
    }

    // ──────────────────────────────────────────────────────────
    // STORE — Simpan transaksi manual dari modal
    // ──────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('pelanggan.dashboard')
                ->with('error', 'Akses dibatasi untuk Admin.');
        }

        $request->validate([
            'tipe'       => 'required|in:pemasukan,pengeluaran',
            'judul'      => 'required|string|max:255',
            'nominal'    => 'required|numeric|min:1',
            'kategori'   => 'nullable|string|max:100',
            'keterangan' => 'nullable|string|max:500',
        ]);

        Keuangan::create([
            'tipe'       => $request->tipe,
            'judul'      => $request->judul,
            'nominal'    => $request->nominal,
            'sumber'     => 'manual',
            'kategori'   => $request->kategori
                            ?? ($request->tipe === 'pemasukan' ? 'pemasukan-manual' : 'pengeluaran-manual'),
            'keterangan' => $request->keterangan,
        ]);

        $periode = $request->get('periode', 'bulanan');
        return redirect()->route('keuangan.index', ['periode' => $periode])
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // ──────────────────────────────────────────────────────────
    // DESTROY — Hapus transaksi manual saja
    // ──────────────────────────────────────────────────────────
    public function destroy(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('pelanggan.dashboard')
                ->with('error', 'Akses dibatasi untuk Admin.');
        }

        $transaksi = Keuangan::findOrFail($id);

        if ($transaksi->sumber !== 'manual') {
            return back()->with('error', 'Transaksi otomatis (service/inventory) tidak dapat dihapus dari sini.');
        }

        $transaksi->delete();

        $periode = $request->get('periode', 'bulanan');
        return redirect()->route('keuangan.index', ['periode' => $periode])
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────────────
    // PRIVATE — Tentukan rentang tanggal dari string periode
    // ──────────────────────────────────────────────────────────
// Tambahkan parameter $request (default null agar tidak error di index)
    private function getPeriode($periode, $now, $request = null)
    {
        // Ambil input dari form, jika tidak ada gunakan default sekarang
        $tahun = $request ? $request->get('tahun', $now->year) : $now->year;
        $bulan = $request ? $request->get('bulan', $now->month) : $now->month;

        switch ($periode) {
            case 'harian':
                $startDate = $now->copy()->startOfDay();
                $endDate = $now->copy()->endOfDay();
                $label = "Hari Ini (" . $now->translatedFormat('d F Y') . ")";
                break;

            case 'mingguan':
                if ($request && $request->has('minggu')) {
                    $mingguKe = $request->get('minggu');
                    $bulanPilihan = $request->get('bulan', $now->month);
                    $tahunPilihan = $request->get('tahun', $now->year);

                    $startOfMonth = Carbon::create($tahunPilihan, $bulanPilihan, 1)->startOfMonth();
                    $startDate = $startOfMonth->copy()->addWeeks($mingguKe - 1)->startOfWeek(Carbon::MONDAY);
                    $endDate = $startDate->copy()->endOfWeek(Carbon::SUNDAY);
                    $label = "Minggu ke-$mingguKe, " . $startOfMonth->translatedFormat('F Y');
                } else {
                    $startDate = $now->copy()->startOfWeek(Carbon::MONDAY);
                    $endDate = $now->copy()->endOfWeek(Carbon::SUNDAY);
                    $label = "Minggu Ini (" . $startDate->translatedFormat('d M') . " - " . $endDate->translatedFormat('d M Y') . ")";
                }
                break;

            case 'tahunan':
                $startDate = Carbon::create($tahun, 1, 1)->startOfYear();
                $endDate = $startDate->copy()->endOfYear();
                $label = "Tahun " . $tahun;
                break;

            case 'custom':
                $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
                $endDate = Carbon::parse($request->get('end_date'))->endOfDay();
                $label = $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y');
                break;

            case 'bulanan':
            default:
                $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
                $endDate = $startDate->copy()->endOfMonth();
                $label = $startDate->translatedFormat('F Y');
                break;
        }

        return [$startDate, $endDate, $label];
    }
    // ──────────────────────────────────────────────────────────
    // PRIVATE — Data untuk grafik chart
    // ──────────────────────────────────────────────────────────
    private function getChartData(string $periode, Carbon $now): array
{
    $labels    = [];
    $pemasukan = [];
    $pengeluaran = [];
    $saldo     = [];
 
    switch ($periode) {
        case 'harian':
            for ($i = 5; $i >= 0; $i--) {
                $jam         = $now->copy()->subHours($i);
                $labels[]    = $jam->format('H:00');
 
                $p = Keuangan::pemasukan()
                    ->whereBetween('created_at', [
                        $jam->copy()->startOfHour(),
                        $jam->copy()->endOfHour(),
                    ])->sum('nominal');
 
                $k = Keuangan::pengeluaran()
                    ->whereBetween('created_at', [
                        $jam->copy()->startOfHour(),
                        $jam->copy()->endOfHour(),
                    ])->sum('nominal');
 
                $pemasukan[]   = $p;
                $pengeluaran[] = $k;
                $saldo[]       = $p - $k;
            }
            break;
 
        case 'mingguan':
            $startWeek = $now->copy()->startOfWeek(Carbon::MONDAY);
            for ($i = 0; $i < 7; $i++) {
                $hari        = $startWeek->copy()->addDays($i);
                $labels[]    = $hari->translatedFormat('D');
 
                $p = Keuangan::pemasukan()
                    ->whereDate('created_at', $hari->toDateString())
                    ->sum('nominal');
 
                $k = Keuangan::pengeluaran()
                    ->whereDate('created_at', $hari->toDateString())
                    ->sum('nominal');
 
                $pemasukan[]   = $p;
                $pengeluaran[] = $k;
                $saldo[]       = $p - $k;
            }
            break;
 
        case 'tahunan':
            for ($i = 1; $i <= 12; $i++) {
                $bulan       = Carbon::create($now->year, $i, 1);
                $labels[]    = $bulan->translatedFormat('M');
 
                $p = Keuangan::pemasukan()
                    ->whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $i)
                    ->sum('nominal');
 
                $k = Keuangan::pengeluaran()
                    ->whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $i)
                    ->sum('nominal');
 
                $pemasukan[]   = $p;
                $pengeluaran[] = $k;
                $saldo[]       = $p - $k;
            }
            break;
 
        case 'bulanan':
        default:
            $startMonth = $now->copy()->startOfMonth();
            $endMonth   = $now->copy()->endOfMonth();
            $current    = $startMonth->copy();
            $week       = 1;
            while ($current->lte($endMonth)) {
                $weekEnd  = $current->copy()->endOfWeek(Carbon::SUNDAY);
                if ($weekEnd->gt($endMonth)) $weekEnd = $endMonth->copy();
 
                $labels[] = 'W' . $week;
 
                $p = Keuangan::pemasukan()
                    ->whereBetween('created_at', [
                        $current->copy()->startOfDay(),
                        $weekEnd->copy()->endOfDay(),
                    ])->sum('nominal');
 
                $k = Keuangan::pengeluaran()
                    ->whereBetween('created_at', [
                        $current->copy()->startOfDay(),
                        $weekEnd->copy()->endOfDay(),
                    ])->sum('nominal');
 
                $pemasukan[]   = $p;
                $pengeluaran[] = $k;
                $saldo[]       = $p - $k;
 
                $current = $weekEnd->copy()->addDay();
                $week++;
            }
            break;
    }
 
    return compact('labels', 'pemasukan', 'pengeluaran', 'saldo');
}

    public function cetak(Request $request) 
    {
        $periode = $request->get('periode', 'bulanan');
        $now = Carbon::now();
        
        // Gunakan request untuk mendapatkan filter spesifik
        [$startDate, $endDate, $labelPeriode] = $this->getPeriode($periode, $now, $request);

        $baseQuery = Keuangan::whereBetween('created_at', [$startDate, $endDate]);
        
        $totalPemasukan = (clone $baseQuery)->where('tipe', 'pemasukan')->sum('nominal');
        $totalPengeluaran = (clone $baseQuery)->where('tipe', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;
        $historyTransaksi = $baseQuery->orderBy('created_at', 'asc')->get();

        $html = view('keuangan.pdf', compact('labelPeriode', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'historyTransaksi'))->render();

        // 1. Generate data PDF mentah
        $pdfContent = Browsershot::html($html)
            ->setChromePath('C:\Program Files\Google\Chrome\Application\chrome.exe') // Sesuaikan path Windows Anda
            ->addChromiumArguments(['no-sandbox', 'disable-setuid-sandbox'])
            ->emulateMedia('screen')
            ->margins(10, 10, 10, 10)
            ->format('A4')
            ->pdf(); // Ini mengembalikan string biner PDF

        return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="laporan-keuangan-' . $labelPeriode . '.pdf"');
    }
}