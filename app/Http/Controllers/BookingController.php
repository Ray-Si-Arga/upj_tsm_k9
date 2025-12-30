<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User; // Digunakan untuk statistik
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Menampilkan dashboard admin (Ringkasan dan Antrian Hari Ini)
     */
    public function adminDashboard()
    {
        // Pengecekan role manual untuk akses dashboard
        if (Auth::user()->role !== 'admin') {
            // Jika bukan admin, arahkan ke halaman booking/create (atau halaman customer lainnya)
            return redirect()->route('booking.create')->with('error', 'Akses dibatasi untuk Admin.');
        }

        // 1. Ambil data statistik untuk Card
        $today = date('Y-m-d');

        $totalBookingsToday = Booking::whereDate('booking_date', $today)->count();
        $pendingBookings = Booking::whereIn('status', ['pending', 'approved', 'on_progress'])->count();
        $registeredCustomers = User::where('role', 'customer')->count();

        // 2. Ambil data antrian hari ini (untuk ditampilkan di bagian bawah dashboard)
        $queueBookings = Booking::with(['user', 'service'])
            ->whereDate('booking_date', $today)
            ->whereIn('status', ['pending', 'approved', 'on_progress'])
            // Sorting di client (JS/Blade) atau jika diperlukan gunakan orderBy di sini,
            // namun dihindari karena berpotensi memerlukan index tambahan.
            ->get();

        return view('admin.dashboard', compact(
            'totalBookingsToday',
            'pendingBookings',
            'registeredCustomers',
            'queueBookings',
        ));
    }

    public function createWalkIn()
    {
        // hanya admin yang boleh akses
        if (auth::user()->role !== 'admin') {
            return redirect()->route('booking.create')->with('error', 'Hanya admin yang boleh akses');
        }

        $services = Service::all();

        // dd($request->all());

        $todayactive = Booking::whereDate('booking_date', date('Y-m-d'))
            ->whereIn('status', ['pending', 'approved', 'on_progress'])
            ->count();

        return view('booking.admin_create', compact('services', 'todayactive'));
    }

    public function storeWalkIn(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:225',
            'vehicle_type' => 'required|string|max:50',
            'plate_number' => 'required|string|max:25',
            'service_id' => 'required|exists:services,id',
            'customer_whatsapp' => 'nullable|string|max:15',
            'booking_date' => 'required|date', // Pastikan required

            'estimation_hours' => 'nullable|integer|min:0',
            'estimation_minutes' => 'nullable|integer|min:0|max:59',
        ]);

        try {
            // 1. Ambil waktu yang diinginkan dari Input Form
            $bookingTime = \Carbon\Carbon::parse($request->booking_date);

            // 2. Cek Slot (PERBAIKAN FORMAT DATE DISINI)
            // Menggunakan format('Y-m-d H:i:s') -> Huruf 'd' kecil
            $existBooking = Booking::whereBetween('booking_date', [
                $bookingTime->format('Y-m-d H:i:s'),
                $bookingTime->copy()->addMinutes(59)->format('Y-m-d H:i:s'),
            ])->count();

            $maxCapacity = 2; // Batas 2 motor per jam

            if ($existBooking >= $maxCapacity) {
                return back()
                    ->with('error', 'Mohon maaf, slot waktu jam ' . $bookingTime->format('H:i') . ' sudah penuh! Silakan pilih jam lain.')
                    ->withInput();
            }

            // 3. Persiapkan Data
            // Hapus variabel $now = now() karena kita pakai inputan admin

            // Hitung nomor antrian untuk TANGGAL BOOKING TERSEBUT
            $dateOnly = $bookingTime->format('Y-m-d');
            $lastqueue = Booking::whereDate('booking_date', $dateOnly)->max('queue_number');
            $newQueueNumber = $lastqueue ? $lastqueue + 1 : 1;

            $booking = new Booking();
            $booking->user_id = null;
            $booking->customer_name = $request->customer_name;
            $booking->customer_whatsapp = $request->customer_whatsapp ?? '000000000000';
            $booking->vehicle_type = $request->vehicle_type;
            $booking->plate_number = $request->plate_number;
            $booking->service_id = $request->service_id;

            // PERBAIKAN: Simpan waktu sesuai inputan, BUKAN waktu sekarang
            $booking->booking_date = $bookingTime;

            // Logic Durasi
            $hours = $request->estimation_hours ?? 0;
            $minutes = $request->estimation_minutes ?? 0;
            $totalMinutes = ($hours * 60) + $minutes;
            $booking->estimation_duration = $totalMinutes > 0 ? $totalMinutes : null;

            $booking->queue_number = $newQueueNumber;
            $booking->status = 'approved'; // Walk-in biasanya langsung approved
            $booking->save();

            // Pesan Sukses
            $pesanSukses = 'Booking Walk-in Berhasil! Antrian No: ' . $newQueueNumber;

            if ($totalMinutes > 0) {
                $jamSelesai = $booking->booking_date->copy()->addMinutes($totalMinutes)->format('H:i');
                $pesanSukses .= ". Estimasi selesai pukul: " . $jamSelesai . " WIB";
            }

            return redirect()->route('admin.dashboard')
                ->with('success', $pesanSukses);
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
        $todayBookings = Booking::with(['user', 'service'])
            ->whereDate('booking_date', $today)
            ->orderBy('queue_number', 'asc') // Urutkan 1, 2, 3...
            ->get();

        // 2. DATA MENDATANG (Booking Besok dst)
        $upcomingBookings = Booking::with(['user', 'service'])
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
        // 1. Validasi Input
        $request->validate([
            'service_ids'       => 'required|array|min:1', // Wajib array & minimal pilih 1
            'service_ids.*'     => 'exists:services,id',   // Pastikan ID service ada di database
            'booking_date'      => 'required|date',        // Tanggal wajib diisi
            'plate_number'      => 'required|string',
            'vehicle_type'      => 'required|string',
            'customer_whatsapp' => 'required|string',
            'customer_name'     => 'required|string', // Pastikan nama terkirim
            'complaint'         => 'nullable|string',
        ]);

        $user = Auth::user();

        // 2. Looping (Perulangan) untuk menyimpan setiap service yang dicentang
        foreach ($request->service_ids as $serviceId) {

            // Logic Nomor Antrian: Reset per hari
            // Kita cari nomor antrian tertinggi di tanggal yang dipilih
            $date = \Carbon\Carbon::parse($request->booking_date)->format('Y-m-d');

            // Ambil nomor antrian terakhir hari itu, kalau belum ada mulai dari 0
            $lastQueue = Booking::whereDate('booking_date', $date)->max('queue_number') ?? 0;

            // Simpan ke Database
            Booking::create([
                'user_id'           => $user->id,
                'service_id'        => $serviceId, // Simpan ID service satu per satu
                'booking_date'      => $request->booking_date,
                'customer_name'     => $request->customer_name,
                'customer_whatsapp' => $request->customer_whatsapp,
                'vehicle_type'      => $request->vehicle_type,
                'plate_number'      => strtoupper($request->plate_number),
                'status'            => 'pending', // Default status menunggu
                'queue_number'      => $lastQueue + 1, // Nomor antrian bertambah
                'complaint'         => $request->complaint,
            ]);
        }

        // Redirect ke dashboard setelah semua tersimpan
        return redirect()->route('pelanggan.dashboard')->with('success', 'Booking berhasil! Layanan telah ditambahkan ke antrian.');
    }

    /**
     * Dashboard: Hanya menampilkan booking yang SEDANG AKTIF
     */
    public function pelangganDashboard()
    {
        $user = Auth::user();

        // Ambil Booking Aktif (Pending, Approved, On Progress)
        $activeBookings = Booking::with('service')
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
        $historyBookings = Booking::with('service')
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

        $queueBookings = Booking::with(['user', 'service'])
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
        $booking = Booking::with(['user', 'service'])->findOrFail($id);

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
        // Otorisasi Manual: Hanya Admin yang boleh memperbarui status
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang diizinkan memperbarui status.');
        }

        // 1. Validasi Status Baru
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'on_progress', 'done', 'cancelled'])],
        ]);

        // 2. Update Data
        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * Menampilkan halaman sukses setelah booking dibuat
     */
    public function success($id)
    {
        $booking = Booking::with(['service'])->findOrFail($id);

        return view('booking.success', compact('booking'));
    }

    /**
     * Menampilkan detail riwayat booking (Jika ada halaman history)
     */
    public function historyDetail($id)
    {
        $booking = Booking::with(['user', 'service'])->findOrFail($id);

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

        // Asumsi: Kita hanya mengambil user dengan role 'customer'
        $customers = User::where('role', 'customer')
            ->with('bookings')
            ->orderBy('created_at', 'desc')
            ->get();


        return view('customers.index', compact('customers'));
    }

    /**
     * Menampilkan daftar booking berdasarkan nomor WhatsApp (Hanya Admin)
     */
    public function customerBookings($whatsapp)
    {
        // Pengecekan role manual
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('booking.create')->with('error', 'Akses dibatasi untuk Admin.');
        }

        // Ambil semua booking untuk nomor WhatsApp tertentu
        $bookings = Booking::with(['user', 'service'])
            // ->where('whatsapp_number', $whatsapp)
            ->where('customer_whatsapp', $whatsapp)
            // ->orderBy('booking_date', 'desc')
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
