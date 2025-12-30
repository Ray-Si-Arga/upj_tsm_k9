<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Index
    // Tambahkan method ini
    public function index()
    {
        $user = Auth::user();

        // Ambil booking TERAKHIR milik user ini
        // Kita ambil yang statusnya BUKAN cancelled agar fokus ke yang aktif/selesai
        $lastBooking = Booking::with('service')
            ->where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->first();

        // Hitung statistik sederhana (Opsional)
        $totalService = Booking::where('user_id', $user->id)->where('status', 'done')->count();

        return view('pelanggan.dashboard', compact('lastBooking', 'totalService'));
    }

    public function ServisCustomer()
    {
        return view('pelanggan.service');
    }
}
