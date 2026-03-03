<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Keuangan;
use App\Models\User; // Digunakan untuk statistik
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\ServiceAdvisor;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
    /**
     * Menampilkan dashboard admin (Ringkasan dan Antrian Hari Ini)
     */
    public function jadwal()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('booking.create')
                ->with('error', 'Akses dibatasi untuk Admin.');
        }

        return view('admin.jadwal');
    }

    public function storeJadwal($data)
    {
        return \App\Models\Jadwal::updateOrCreate(
            ['event_id' => $data['id'] ?? $data['event_id']],
            [
                'date' => $data['date'],
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'color' => $data['color'] ?? '#B10000',
                'start_time' => $data['startTime'] ?? null,
                'end_time' => $data['endTime'] ?? null,
                'is_closed' => $data['isClosed'] ?? false,
            ]
        );
    }

    public function deleteJadwal($eventId)
    {
        return \App\Models\Jadwal::where('event_id', $eventId)->delete();
    }

    public function adminDashboard()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('booking.create')
                ->with('error', 'Akses dibatasi untuk Admin.');
        }

        $today = date('Y-m-d');
        $now = Carbon::now();

        // ── 1. KARTU RINGKASAN ──────────────────────────
        $totalBookingsToday = Booking::whereDate('booking_date', $today)->count();

        $pendingBookings = Booking::whereIn('status', ['pending', 'approved', 'on_progress'])->count();

        $registeredCustomers = User::where('role', 'customer')->count();

        // Service selesai bulan ini
        $doneThisMonth = Booking::where('status', 'done')
            ->whereYear('booking_date', $now->year)
            ->whereMonth('booking_date', $now->month)
            ->count();

        // ── DIUPDATE: Pemasukan bulan ini dari tabel keuangan ──
        $revenueThisMonth = Keuangan::pemasukan()
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('nominal');

        // Jumlah item stok menipis
        $lowStockCount = Inventory::where('jumlah_barang', '<=', 6)->count();

        // ── 2. ANTRIAN AKTIF HARI INI ───────────────────
        $queueBookings = Booking::with(['user', 'services'])
            ->whereDate('booking_date', $today)
            ->whereIn('status', ['pending', 'approved', 'on_progress'])
            ->orderBy('queue_number', 'asc')
            ->get();

        // ── 3. TOP 7 PELANGGAN SETIA ────────────────────
        $topCustomers = Booking::select(
            'customer_name',
            'customer_whatsapp',
            DB::raw('COUNT(*) as total')
        )
            ->where('status', 'done')
            ->whereNotNull('customer_name')
            ->groupBy('customer_name', 'customer_whatsapp')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        // ── 4. STOK MENIPIS (panel bawah) ───────────────
        $lowStockItems = Inventory::where('jumlah_barang', '<=', 6)
            ->orderBy('jumlah_barang', 'asc')
            ->limit(8)
            ->get();

        // ── 5. LAYANAN TERPOPULER ────────────────────────
        $topServices = Service::select('services.id', 'services.name')
            ->join('booking_service', 'services.id', '=', 'booking_service.service_id')
            ->join('bookings', 'bookings.id', '=', 'booking_service.booking_id')
            ->where('bookings.status', 'done')
            ->groupBy('services.id', 'services.name')
            ->selectRaw('COUNT(*) as total')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // ── 6. CHART DATA — 7 HARI TERAKHIR ─────────────
        $chartLabels = [];
        $chartBooking = [];
        $chartDone = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $d = $date->format('Y-m-d');

            $chartLabels[] = $date->locale('id')->translatedFormat('D d/m');
            $chartBooking[] = Booking::whereDate('booking_date', $d)->count();
            $chartDone[] = Booking::whereDate('booking_date', $d)
                ->where('status', 'done')->count();
        }

        return view('admin.dashboard', compact(
            'totalBookingsToday',
            'pendingBookings',
            'registeredCustomers',
            'doneThisMonth',
            'revenueThisMonth',
            'lowStockCount',
            'queueBookings',
            'topCustomers',
            'lowStockItems',
            'topServices',
            'chartLabels',
            'chartBooking',
            'chartDone',
        ));
    }




    public function createWalkIn()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('booking.create')->with('error', 'Hanya admin yang boleh akses.');
        }

        $services = Service::all();

        // Ambil semua user dengan role customer (untuk dropdown)
        $customers = User::where('role', 'customer')
            ->orderBy('name', 'asc')
            ->get();

        $todayactive = Booking::whereDate('booking_date', date('Y-m-d'))
            ->whereIn('status', ['pending', 'approved', 'on_progress'])
            ->count();

        return view('booking.admin_create', compact('services', 'customers', 'todayactive'));
    }

    public function storeWalkIn(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_type' => 'required|in:bebek,sport,matic',
            'plate_number' => 'required|string|max:25',
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
            'customer_whatsapp' => 'nullable|string|max:15',
            'booking_date' => 'required|date',
            'complaint' => 'nullable|string',
            'estimation_hours' => 'nullable|integer|min:0',
            'estimation_minutes' => 'nullable|integer|min:0|max:59',
        ]);

        // Validasi Hari Minggu
        $bookingDateCheck = Carbon::parse($request->booking_date);
        if ($bookingDateCheck->isSunday()) {
            return back()
                ->withInput()
                ->with('error', 'Mohon maaf, bengkel kami libur pada hari Minggu. Silakan pilih hari lain.');
        }

        try {
            $bookingTime = \Carbon\Carbon::parse($request->booking_date);

            // Cek slot (maks 2 motor per jam)
            $existBooking = Booking::whereBetween('booking_date', [
                $bookingTime->format('Y-m-d H:i:s'),
                $bookingTime->copy()->addMinutes(59)->format('Y-m-d H:i:s'),
            ])->count();

            if ($existBooking >= 2) {
                return back()
                    ->with('error', 'Slot jam ' . $bookingTime->format('H:i') . ' sudah penuh! Silakan pilih jam lain.')
                    ->withInput();
            }

            // Ambil data user yang dipilih
            $selectedUser = User::findOrFail($request->user_id);

            // Nomor antrian
            $dateOnly = $bookingTime->format('Y-m-d');
            $lastQueue = Booking::whereDate('booking_date', $dateOnly)->max('queue_number') ?? 0;
            $newQueueNumber = $lastQueue + 1;

            // Estimasi durasi
            $hours = $request->estimation_hours ?? 0;
            $minutes = $request->estimation_minutes ?? 0;
            $totalMinutes = ($hours * 60) + $minutes;

            // Simpan booking
            $booking = Booking::create([
                'user_id' => $selectedUser->id,
                'customer_name' => $selectedUser->name,
                'customer_whatsapp' => $request->customer_whatsapp ?? $selectedUser->phone ?? '000000000000',
                'vehicle_type' => $request->vehicle_type,
                'plate_number' => strtoupper($request->plate_number),
                'complaint' => $request->complaint,
                'booking_date' => $bookingTime,
                'estimation_duration' => $totalMinutes > 0 ? $totalMinutes : null,
                'queue_number' => $newQueueNumber,
                'status' => 'approved',
            ]);

            // Simpan ke tabel pivot booking_service (multi-service)
            $booking->services()->attach($request->service_ids);

            $pesanSukses = 'Booking Walk-in Berhasil! Antrian No: ' . $newQueueNumber
                . ' atas nama ' . $selectedUser->name . '.';

            if ($totalMinutes > 0) {
                $jamSelesai = $booking->booking_date->copy()->addMinutes($totalMinutes)->format('H:i');
                $pesanSukses .= " Estimasi selesai pukul {$jamSelesai} WIB.";
            }

            return redirect()->route('admin.dashboard')->with('success', $pesanSukses);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Menampilkan daftar semua booking (Index utama untuk admin)
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('booking.create')->with('error', 'Akses dibatasi untuk Admin.');
        }

        $today = date('Y-m-d');

        // 1. DATA HARI INI (Diurutkan berdasarkan Nomor Antrian)
        $todayBookings = Booking::with(['user', 'services'])
            ->whereDate('booking_date', $today)
            ->orderBy('queue_number', 'asc') // Urutkan 1, 2, 3...
            ->get();

        // 2. DATA MENDATANG (Booking Besok dst)
        $upcomingBookings = Booking::with(['user', 'services'])
            ->whereDate('booking_date', '>', $today)
            ->orderBy('booking_date', 'asc')
            ->orderBy('queue_number', 'asc')
            ->paginate(10); // Tetap pakai pagination agar tidak kepanjangan

        return view('booking.index', compact('todayBookings', 'upcomingBookings'));
    }

    /**
     * Menampilkan form untuk membuat booking baru (Untuk customer/user)
     */

    // ----------------------------------------------------------------------- //
    // ---------------- function Untuk Pelanggan/Customer -------------------- //
    // ----------------------------------------------------------------------- //
    public function create()
    {
        $todayActive = Booking::whereDate('booking_date', date('Y-m-d'))
            ->whereIn('status', ['pending', 'approved', 'on_progress'])
            ->count();

        $services = Service::all();
        $user = Auth::user();

        return view('pelanggan.service', compact('services', 'user', 'todayActive'));
    }


    public function store(Request $request)
    {
        // 1. Validasi Dasar
        $request->validate([
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
            'booking_date' => 'required|date',
            'customer_name' => 'required|string|max:255',
            'customer_whatsapp' => 'required|string|max:20',
            'vehicle_type' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20',
            'complaint' => 'nullable|string', // <-- TAMBAHKAN VALIDASI INI
        ]);

        // 2. LOGIKA VALIDASI HARI MINGGU
        $date = Carbon::parse($request->booking_date);
        if ($date->isSunday()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Mohon maaf, bengkel kami libur pada hari Minggu. Silakan pilih hari lain.');
        }

        // 3. Hitung Nomor Antrian berdasarkan tanggal booking
        $bookingDate = Carbon::parse($request->booking_date)->format('Y-m-d');
        $lastQueue = Booking::whereDate('booking_date', $bookingDate)->max('queue_number') ?? 0;
        $newQueueNumber = $lastQueue + 1;

        // 4. Proses Simpan Data
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'booking_date' => $request->booking_date,
            'customer_name' => $request->customer_name,
            'customer_whatsapp' => $request->customer_whatsapp,
            'vehicle_type'      => $request->vehicle_type,
            'plate_number'      => strtoupper($request->plate_number),
            'queue_number'      => $newQueueNumber,
            'status'            => 'pending',
            'complaint'         => $request->complaint, // <-- TAMBAHKAN BARIS INI UNTUK MENYIMPAN KE DATABASE
        ]);

        $booking->services()->attach($request->service_ids);

        return redirect()->route('booking.success', $booking->id);
    }

    /**
     * Dashboard: Hanya menampilkan booking yang SEDANG AKTIF
     */
    public function pelangganDashboard()
    {
        $user = Auth::user();

        // Ambil Booking Aktif (Pending, Approved, On Progress)
        $activeBookings = Booking::with('services')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved', 'on_progress'])
            ->orderBy('booking_date', 'asc')
            ->get();

        return view('pelanggan.dashboard', compact('activeBookings'));
    }

    /**
     * Halaman Baru: Menampilkan RIWAYAT (Selesai / Batal)
     */
    public function pelangganHistory()
    {
        $user = Auth::user();

        // Ambil Riwayat (Done, Cancelled)
        $historyBookings = Booking::with('services')
            ->where('user_id', $user->id)
            ->whereIn('status', ['done', 'cancelled'])
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('pelanggan.history', compact('historyBookings'));
    }


    /**
     * Menampilkan daftar booking yang sedang dalam antrian (Queue List)
     */
    public function queueList()
    {
        // Pengecekan role manual
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('booking.create')->with('error', 'Akses dibatasi untuk Admin.');
        }

        $today = date('Y-m-d');

        $queueBookings = Booking::with(['user', 'services'])
            ->whereDate('booking_date', $today)
            ->whereIn('status', ['pending', 'approved', 'on_progress'])
            ->orderBy('queue_number', 'asc')
            ->get();

        return view('booking.queue_list', compact('queueBookings'));
    }

    /**
     * Menampilkan detail booking tertentu
     */
    public function show($id)
    {
        // Menggunakan eager loading untuk memuat data user dan service sekaligus
        $booking = Booking::with(['user', 'services'])->findOrFail($id);

        // Otorisasi sederhana: Hanya admin atau pemilik booking yang boleh melihat
        if (Auth::user()->role !== 'admin' && Auth::id() !== $booking->user_id) {
            abort(403, 'Anda tidak memiliki akses ke detail booking ini.');
        }

        return view('booking.show', compact('booking'));
    }

    /**
     * Memperbarui status booking (Hanya Admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = $request->status;

        // Jika statusnya cancelled, simpan alasannya
        if ($request->status == 'cancelled') {
            $booking->rejection_reason = $request->rejection_reason;
        } else {
            // Jika status berubah jadi aktif lagi, hapus alasan lama (opsional)
            $booking->rejection_reason = null;
        }

        $booking->save();

        // Kirim notifikasi WA disini jika perlu (Nanti)

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * Menampilkan halaman sukses setelah booking dibuat
     */
    public function success($id)
    {
        $booking = Booking::with(['services'])->findOrFail($id);

        return view('booking.success', compact('booking'));
    }

    /**
     * Menampilkan detail riwayat booking (Jika ada halaman history)
     */
    public function historyDetail($id)
    {
        $booking = Booking::with(['user', 'services'])->findOrFail($id);

        // Otorisasi: Admin atau pemilik booking
        if (Auth::user()->role !== 'admin' && Auth::id() !== $booking->user_id) {
            abort(403, 'Anda tidak memiliki akses ke riwayat booking ini.');
        }

        return view('booking.history_detail', compact('booking'));
    }

    /**
     * Menampilkan daftar semua customer (Hanya Admin)
     */
    public function customers()
    {
        // Pengecekan role manual
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('booking.create')->with('error', 'Akses dibatasi untuk Admin.');
        }

        $now = \Carbon\Carbon::now();

        $totalCustomers = User::where('role', 'customer')->count();
        $newCustomers = User::where('role', 'customer')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        $totalAdmins = User::where('role', 'admin')->count();
        $newAdmins = User::where('role', 'admin')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        return view('customers.index', compact('totalCustomers', 'newCustomers', 'totalAdmins', 'newAdmins'));
    }

    /**
     * Menampilkan daftar booking berdasarkan nomor WhatsApp (Hanya Admin)
     */
    public function customerBookings($id)
    {
        // Pengecekan role manual
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('booking.create')->with('error', 'Akses dibatasi untuk Admin.');
        }

        // Ambil semua booking untuk user ID tertentu
        $bookings = Booking::with(['user', 'services'])
            ->where('user_id', $id)
            ->orderBy('booking_date', 'desc')
            ->get();

        // Ambil customer name untuk header view
        $customerName = $bookings->first()->customer_name ?? 'Customer Tidak Ditemukan';

        return view('customers.bookings', compact('bookings', 'customerName'));
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        // dd('Hapus berhasil' , $booking->all());

        return redirect()->route('booking.index')->with('success', 'Data booking berhasil dihapus');
    }
}