<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User; // <<< PENTING: Import model User Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class BookingController extends Controller
{
    // ==========================================================
    // INDEX (PAGINATION & ROLE-BASED SCOPE)
    // ==========================================================
    public function index(Request $request)
    {
        /** @var User $user */ // <<< KOREKSI: Tambahkan Type Hinting
        $user = $request->user();
        $query = Booking::with('service');
        $perPage = 3;

        if ($user->tokenCan('admin-access')) {
            // Admin: Melihat SEMUA booking
            $query->orderByRaw("FIELD(status, 'pending', 'approved', 'on_progress', 'done', 'cancelled')");
            $query->orderBy('booking_date', 'desc');
        } else {
            // Customer: Hanya melihat booking mereka sendiri
            $query->where('user_id', $user->id);
            $query->latest('created_at', 'asc');
        }

        $bookings = $query->paginate($perPage);

        return response()->json($bookings);
    }

    // ==========================================================
    // STORE (VALIDASI & KUOTA)
    // ==========================================================
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'service_id' => 'required|exists:services,id',
                'booking_date' => 'required|date_format:Y-m-d H:i:s|after:now',
                'vehicle_type' => 'required|string|max:50',
                'plate_number' => 'required|string|max:15',
                'customer_name' => 'required|string|max:100',
                'customer_whatsapp' => 'required|string|max:20',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Cek lagi data anda', 'errors' => $e->errors()], 422);
        }

        $maxQuota = 5;
        $requestedDate = Carbon::parse($validated['booking_date'])->toDateString();

        if (Booking::whereDate('booking_date', $requestedDate)
            ->where('plate_number', $validated['plate_number'])
            ->whereNotIn('status', ['done', 'cancelled'])
            ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Plat Nomor ' . $validated['plate_number'] . ' sudah memiliki antrian aktif pada tanggal ' . $requestedDate . '.'
            ], 409);
        }

        $todayActive = Booking::whereDate('booking_date', $requestedDate)
            ->whereNotIn('status', ['done', 'cancelled'])
            ->count();

        if ($todayActive >= $maxQuota) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota antrian untuk tanggal ' . $requestedDate . ' sudah penuh (maksimal ' . $maxQuota . '). Silahkan pilih hari lain.'
            ], 409);
        }

        $lastNumber = Booking::whereDate('booking_date', $requestedDate)->max('queue_number');
        $queueNumber = $lastNumber ? $lastNumber + 1 : 1;

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'vehicle_type' => $validated['vehicle_type'],
            'plate_number' => $validated['plate_number'],
            'booking_date' => $validated['booking_date'],
            'service_id' => $validated['service_id'],
            'customer_name' => $validated['customer_name'],
            'customer_whatsapp' => $validated['customer_whatsapp'],
            'status' => 'pending',
            'queue_number' => $queueNumber,
        ]);

        $booking->load('service');

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat.',
            'data' => $booking
        ], 201);
    }

    // ==========================================================
    // SHOW (OTORISASI)
    // ==========================================================
    public function show($id)
    {
        /** @var User $user */ // <<< KOREKSI: Tambahkan Type Hinting
        $user = Auth::user();

        $booking = Booking::with('service')->findOrFail($id);

        if (!$user->tokenCan('admin-access') && $booking->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        return response()->json($booking);
    }

    // ==========================================================
    // UPDATE STATUS (ADMIN ONLY)
    // ==========================================================
    public function updateStatus(Request $request, $id)
    {
        /** @var User $user */ // <<< KOREKSI: Tambahkan Type Hinting
        $user = $request->user();

        // Otorisasi tambahan untuk memastikan hanya Admin yang bisa
        if (!$user->tokenCan('admin-access')) {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,approved,on_progress,done,cancelled',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        $booking->load('service');

        return response()->json([
            'success' => true,
            'message' => 'Status booking berhasil diperbarui.',
            'data' => $booking
        ]);
    }

    // ==========================================================
    // QUEUE LIST (ADMIN ONLY)
    // ==========================================================
    public function queueList(Request $request)
    {
        /** @var User $user */ // <<< KOREKSI: Tambahkan Type Hinting
        $user = $request->user();

        // Otorisasi tambahan
        if (!$user->tokenCan('admin-access')) {
             return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        $queue = Booking::with('service')
            ->whereDate('booking_date', Carbon::today())
            ->orderBy('queue_number', 'asc')
            ->get();

        return response()->json($queue);
    }
}
