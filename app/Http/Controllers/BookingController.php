<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User; // Digunakan untuk statistik
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

// BookingController ini fokus melayani Web View (Blade)
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


    /**
     * Menampilkan daftar semua booking (Index utama untuk admin)
     */
    public function index()
    {
        // Pengecekan role manual
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('booking.create')->with('error', 'Akses dibatasi untuk Admin.');
        }

        // Ambil semua booking dengan eager loading (user dan service)
        $bookings = Booking::with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.index', compact('bookings'));
    }

    /**
     * Menampilkan form untuk membuat booking baru (Untuk customer/user)
     */
    public function create()
    {
        $todayActive = Booking::whereDate('booking_date', date('Y-m-d'))
            ->whereIn('status', ['pending', 'approved', 'on_progress'])
            ->count();

        $services = Service::all();
        $user = Auth::user();

        return view('booking.create', compact('services', 'user', 'todayActive'));
    }


    public function store(Request $request)
    {

        $validasi = $request->validate([
            'vehicle_type' => ['required', 'string', 'max:50'],
            'plate_number' => ['required', 'string', 'max:20'],
            'booking_date' => ['required', 'date'],
            'service_id' => ['required', 'exists:services,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_whatsapp' => ['required', 'string', 'max:15'],
        ]);

        $datetime = strtotime($request->booking_date);
        $date = date('Y-m-d', $datetime);
        $time = date('H:i', $datetime);

        // Hitung nomor antrian per hari
        $lastQueue = Booking::whereDate('booking_date', $date)->max('queue_number');
        $newQueueNumber = $lastQueue ? $lastQueue + 1 : 1;


        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->vehicle_type = $request->vehicle_type;
        $booking->plate_number = $request->plate_number;
        $booking->booking_date = $request->booking_date;
        $booking->service_id = $request->service_id;
        $booking->customer_name = $request->customer_name;
        $booking->customer_whatsapp = $request->customer_whatsapp;
        $booking->queue_number = $newQueueNumber;
        $booking->status = 'pending';
        $booking->save();

        return redirect()->route('booking.success', $booking->id)
            ->with('success', 'Booking berhasil dibuat!');
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
}
