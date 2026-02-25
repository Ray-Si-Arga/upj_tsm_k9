<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        [$startDate, $endDate, $labelPeriode] = $this->getPeriode($periode, $now);

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
    private function getPeriode(string $periode, Carbon $now): array
    {
        switch ($periode) {
            case 'harian':
                return [
                    $now->copy()->startOfDay(),
                    $now->copy()->endOfDay(),
                    'Hari Ini, ' . $now->translatedFormat('d F Y'),
                ];
            case 'mingguan':
                $start = $now->copy()->startOfWeek(Carbon::MONDAY);
                $end   = $now->copy()->endOfWeek(Carbon::SUNDAY);
                return [
                    $start, $end,
                    $start->translatedFormat('d M') . ' – ' . $end->translatedFormat('d M Y'),
                ];
            case 'tahunan':
                return [
                    $now->copy()->startOfYear(),
                    $now->copy()->endOfYear(),
                    'Tahun ' . $now->year,
                ];
            case 'bulanan':
            default:
                return [
                    $now->copy()->startOfMonth(),
                    $now->copy()->endOfMonth(),
                    $now->translatedFormat('F Y'),
                ];
        }
    }

    // ──────────────────────────────────────────────────────────
    // PRIVATE — Data untuk grafik chart
    // ──────────────────────────────────────────────────────────
    private function getChartData(string $periode, Carbon $now): array
    {
        $labels    = [];
        $pemasukan = [];

        switch ($periode) {
            case 'harian':
                for ($i = 5; $i >= 0; $i--) {
                    $jam         = $now->copy()->subHours($i);
                    $labels[]    = $jam->format('H:00');
                    $pemasukan[] = Keuangan::pemasukan()
                        ->whereBetween('created_at', [
                            $jam->copy()->startOfHour(),
                            $jam->copy()->endOfHour(),
                        ])->sum('nominal');
                }
                break;

            case 'mingguan':
                $startWeek = $now->copy()->startOfWeek(Carbon::MONDAY);
                for ($i = 0; $i < 7; $i++) {
                    $hari        = $startWeek->copy()->addDays($i);
                    $labels[]    = $hari->translatedFormat('D');
                    $pemasukan[] = Keuangan::pemasukan()
                        ->whereDate('created_at', $hari->toDateString())
                        ->sum('nominal');
                }
                break;

            case 'tahunan':
                for ($i = 1; $i <= 12; $i++) {
                    $bulan       = Carbon::create($now->year, $i, 1);
                    $labels[]    = $bulan->translatedFormat('M');
                    $pemasukan[] = Keuangan::pemasukan()
                        ->whereYear('created_at', $now->year)
                        ->whereMonth('created_at', $i)
                        ->sum('nominal');
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

                    $labels[]    = 'W' . $week;
                    $pemasukan[] = Keuangan::pemasukan()
                        ->whereBetween('created_at', [
                            $current->copy()->startOfDay(),
                            $weekEnd->copy()->endOfDay(),
                        ])->sum('nominal');

                    $current = $weekEnd->copy()->addDay();
                    $week++;
                }
                break;
        }

        return compact('labels', 'pemasukan');
    }
}