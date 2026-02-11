<?php

namespace App\Http\Controllers;

use App\Models\ServiceAdvisor;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Hanya admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Akses dibatasi untuk Admin.');
        }

        // -------------------------------------------------------
        // 1. TENTUKAN RENTANG TANGGAL BERDASARKAN FILTER PERIODE
        // -------------------------------------------------------
        $periode = $request->get('periode', 'bulanan');
        $now     = Carbon::now();

        switch ($periode) {
            case 'harian':
                $startDate = $now->copy()->startOfDay();
                $endDate   = $now->copy()->endOfDay();
                $labelPeriode = 'Hari Ini, ' . $now->translatedFormat('d F Y');
                break;

            case 'mingguan':
                $startDate = $now->copy()->startOfWeek(Carbon::MONDAY);
                $endDate   = $now->copy()->endOfWeek(Carbon::SUNDAY);
                $labelPeriode = $startDate->translatedFormat('d M') . ' – ' . $endDate->translatedFormat('d M Y');
                break;

            case 'tahunan':
                $startDate = $now->copy()->startOfYear();
                $endDate   = $now->copy()->endOfYear();
                $labelPeriode = 'Tahun ' . $now->year;
                break;

            case 'bulanan':
            default:
                $periode   = 'bulanan';
                $startDate = $now->copy()->startOfMonth();
                $endDate   = $now->copy()->endOfMonth();
                $labelPeriode = $now->translatedFormat('F Y');
                break;
        }

        // -------------------------------------------------------
        // 2. HITUNG PEMASUKAN (dari service_advisors)
        //    Ambil berdasarkan created_at di rentang periode
        // -------------------------------------------------------
        $pemasukanQuery = ServiceAdvisor::with(['booking'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        $totalPemasukan = (clone $pemasukanQuery)->sum('total_estimation');
        $jumlahTransaksiService = (clone $pemasukanQuery)->count();

        // -------------------------------------------------------
        // 3. HITUNG PENGELUARAN (dari inventory: harga × jumlah)
        //    Karena tidak ada tanggal pembelian, kita gunakan
        //    updated_at sebagai proxy waktu perubahan stok
        // -------------------------------------------------------
        $pengeluaranQuery = Inventory::whereBetween('updated_at', [$startDate, $endDate]);

        $totalPengeluaran = Inventory::selectRaw('SUM(harga_barang * jumlah_barang) as total')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->value('total') ?? 0;

        $jumlahItemInventory = (clone $pengeluaranQuery)->count();

        // -------------------------------------------------------
        // 4. SALDO
        // -------------------------------------------------------
        $saldo = $totalPemasukan - $totalPengeluaran;

        // -------------------------------------------------------
        // 5. HISTORY TRANSAKSI (Gabungan Pemasukan + Pengeluaran)
        //    Diformat sebagai koleksi seragam lalu diurutkan
        // -------------------------------------------------------

        // Pemasukan: dari service_advisors
        $transaksiPemasukan = ServiceAdvisor::with(['booking'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal'     => $item->created_at,
                    'tipe'        => 'pemasukan',
                    'deskripsi'   => 'Service: ' . ($item->jobs ?? '-'),
                    'sub_info'    => ($item->booking->customer_name ?? '-') . ' • ' . ($item->booking->plate_number ?? '-'),
                    'mekanik'     => $item->nama_mekanik ?? '-',
                    'nominal'     => $item->total_estimation,
                    'id'          => $item->id,
                    'badge_color' => 'emerald',
                    'icon'        => 'fa-arrow-trend-up',
                ];
            });

        // Pengeluaran: dari inventory (updated_at sebagai tanggal)
        $transaksiPengeluaran = Inventory::whereBetween('updated_at', [$startDate, $endDate])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal'     => $item->updated_at,
                    'tipe'        => 'pengeluaran',
                    'deskripsi'   => 'Stok: ' . $item->nama_barang,
                    'sub_info'    => 'Jumlah: ' . $item->jumlah_barang . ' unit @ Rp ' . number_format($item->harga_barang, 0, ',', '.'),
                    'mekanik'     => '-',
                    'nominal'     => $item->harga_barang * $item->jumlah_barang,
                    'id'          => $item->id,
                    'badge_color' => 'rose',
                    'icon'        => 'fa-arrow-trend-down',
                ];
            });

        // Gabungkan dan urutkan by tanggal terbaru
        $historyTransaksi = $transaksiPemasukan
            ->concat($transaksiPengeluaran)
            ->sortByDesc('tanggal')
            ->values();

        // -------------------------------------------------------
        // 6. DATA CHART (7 hari/minggu/bulan terakhir untuk grafik mini)
        // -------------------------------------------------------
        $chartData = $this->getChartData($periode, $now);

        return view('keuangan.index', compact(
            'periode',
            'labelPeriode',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'jumlahTransaksiService',
            'jumlahItemInventory',
            'historyTransaksi',
            'chartData'
        ));
    }

    /**
     * Bangun data untuk chart sparkline ringkasan
     */
    private function getChartData(string $periode, Carbon $now): array
    {
        $labels    = [];
        $pemasukan = [];

        switch ($periode) {
            case 'harian':
                // Per jam (6 jam terakhir)
                for ($i = 5; $i >= 0; $i--) {
                    $jam = $now->copy()->subHours($i);
                    $labels[]    = $jam->format('H:00');
                    $pemasukan[] = ServiceAdvisor::whereBetween('created_at', [
                        $jam->copy()->startOfHour(),
                        $jam->copy()->endOfHour()
                    ])->sum('total_estimation');
                }
                break;

            case 'mingguan':
                // Per hari (7 hari)
                $startWeek = $now->copy()->startOfWeek(Carbon::MONDAY);
                for ($i = 0; $i < 7; $i++) {
                    $hari = $startWeek->copy()->addDays($i);
                    $labels[]    = $hari->translatedFormat('D');
                    $pemasukan[] = ServiceAdvisor::whereDate('created_at', $hari->toDateString())
                        ->sum('total_estimation');
                }
                break;

            case 'tahunan':
                // Per bulan (12 bulan)
                for ($i = 1; $i <= 12; $i++) {
                    $bulan = Carbon::create($now->year, $i, 1);
                    $labels[]    = $bulan->translatedFormat('M');
                    $pemasukan[] = ServiceAdvisor::whereYear('created_at', $now->year)
                        ->whereMonth('created_at', $i)
                        ->sum('total_estimation');
                }
                break;

            case 'bulanan':
            default:
                // Per minggu dalam bulan ini (4-5 minggu)
                $startMonth = $now->copy()->startOfMonth();
                $endMonth   = $now->copy()->endOfMonth();
                $current    = $startMonth->copy();
                $week       = 1;
                while ($current->lte($endMonth)) {
                    $weekEnd     = $current->copy()->endOfWeek(Carbon::SUNDAY);
                    if ($weekEnd->gt($endMonth)) $weekEnd = $endMonth->copy();
                    $labels[]    = 'W' . $week;
                    $pemasukan[] = ServiceAdvisor::whereBetween('created_at', [
                        $current->copy()->startOfDay(),
                        $weekEnd->copy()->endOfDay()
                    ])->sum('total_estimation');
                    $current     = $weekEnd->copy()->addDay();
                    $week++;
                }
                break;
        }

        return compact('labels', 'pemasukan');
    }
}