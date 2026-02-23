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
        $queueBookings = Booking::with(['user', 'services'])
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
            'user_id'            => 'required|exists:users,id',
            'vehicle_type'       => 'required|in:bebek,sport,matic',
            'plate_number'       => 'required|string|max:25',
            'service_ids'        => 'required|array|min:1',
            'service_ids.*'      => 'exists:services,id',
            'customer_whatsapp'  => 'nullable|string|max:15',
            'booking_date'       => 'required|date',
            'complaint'          => 'nullable|string',
            'estimation_hours'   => 'nullable|integer|min:0',
            'estimation_minutes' => 'nullable|integer|min:0|max:59',
        ]);

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
            $dateOnly     = $bookingTime->format('Y-m-d');
            $lastQueue    = Booking::whereDate('booking_date', $dateOnly)->max('queue_number') ?? 0;
            $newQueueNumber = $lastQueue + 1;

            // Estimasi durasi
            $hours        = $request->estimation_hours ?? 0;
            $minutes      = $request->estimation_minutes ?? 0;
            $totalMinutes = ($hours * 60) + $minutes;

            // Simpan booking
            $booking = Booking::create([
                'user_id'             => $selectedUser->id,
                'customer_name'       => $selectedUser->name,
                'customer_whatsapp'   => $request->customer_whatsapp ?? $selectedUser->phone ?? '000000000000',
                'vehicle_type'        => $request->vehicle_type,
                'plate_number'        => strtoupper($request->plate_number),
                'complaint'           => $request->complaint,
                'booking_date'        => $bookingTime,
                'estimation_duration' => $totalMinutes > 0 ? $totalMinutes : null,
                'queue_number'        => $newQueueNumber,
                'status'              => 'approved',
            ]);

            // Simpan ke tabel pivot booking_service (multi-service)
            $booking->services()->attach($request->service_ids);

            $pesanSukses = 'Booking Walk-in Berhasil! Antrian No: ' . $newQueueNumber
                         . ' atas nama ' . $selectedUser->name . '.';

            if ($totalMinutes > 0) {
                $jamSelesai   = $booking->booking_date->copy()->addMinutes($totalMinutes)->format('H:i');
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
        // 1. Validasi Input
        $request->validate([
            'service_ids'       => 'required|array|min:1', // Wajib array
            'service_ids.*'     => 'exists:services,id',
            'booking_date'      => 'required|date',
            'plate_number'      => 'required|string',
            'vehicle_type'      => 'required|string',
            'customer_whatsapp' => 'required|string',
            'customer_name'     => 'required|string',
            'complaint'         => 'nullable|string',
        ]);

        $user = Auth::user();

        // 2. Logic Nomor Antrian (Dijalankan SEKALI saja)
        $date = \Carbon\Carbon::parse($request->booking_date)->format('Y-m-d');
        $lastQueue = Booking::whereDate('booking_date', $date)->max('queue_number') ?? 0;
        $newQueueNumber = $lastQueue + 1;

        // 3. Simpan Data Booking UTAMA (Hapus 'service_id' dari sini)
        $booking = Booking::create([
            'user_id'           => $user->id,
            'booking_date'      => $request->booking_date,
            'customer_name'     => $request->customer_name,
            'customer_whatsapp' => $request->customer_whatsapp,
            'vehicle_type'      => $request->vehicle_type,
            'plate_number'      => strtoupper($request->plate_number),
            'status'            => 'pending',
            'queue_number'      => $newQueueNumber, // Satu nomor antrian
            'complaint'         => $request->complaint,
            // Jangan isi 'service_id' karena kolom ini sudah tidak dipakai/dihapus
        ]);

        // 4. Simpan Layanan ke Tabel Pivot (booking_service)
        // Inilah yang menghubungkan 1 Booking dengan Banyak Service
        $booking->services()->attach($request->service_ids);

        return redirect()->route('pelanggan.dashboard')->with('success', 'Booking berhasil! Nomor antrian Anda: ' . $newQueueNumber);
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
        $bookings = Booking::with(['user', 'services'])
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
