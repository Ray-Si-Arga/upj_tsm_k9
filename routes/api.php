<?php

// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AuthController;

// --- PUBLIC ROUTES (No Auth Required) ---
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


// --- PROTECTED ROUTES (Requires auth:sanctum) ---
Route::middleware('auth:sanctum')->group(function () {

    // --- 1. ADMIN-SPECIFIC ROUTES (Requires 'admin-access' ability) ---
    // Endpoint yang hanya boleh diakses oleh Admin
    Route::middleware('role:admin-access')->group(function () {

        // CRUD Service (Hanya Admin yang mengatur layanan yang tersedia)
        Route::apiResource('services', ServiceController::class)->except(['index', 'show']);

        // Booking Management (Update status, melihat daftar antrian semua pengguna)
        Route::put('/bookings/{id}/status', [BookingController::class, 'updateStatus']);
        Route::get('/bookings/today/queue', [BookingController::class, 'queueList']);

        // Admin bisa melihat detail booking siapapun
        Route::get('/bookings/{id}/admin', [BookingController::class, 'show']);
    });


    // --- 2. CUSTOMER-SPECIFIC ROUTES (Requires 'customer-access' ability) ---
    // Endpoint yang dapat diakses oleh Admin DAN Customer
    Route::middleware('role:customer-access')->group(function () {

        // Service Read (Customer perlu melihat daftar layanan yang tersedia)
        Route::apiResource('services', ServiceController::class)->only(['index', 'show']);

        // Booking Customer (Melihat riwayat sendiri & membuat booking baru)
        Route::get('/bookings', [BookingController::class, 'index']); // (Harus difilter di controller)
        Route::post('/bookings', [BookingController::class, 'store']);

        // Customer melihat detail booking miliknya
        Route::get('/bookings/{id}', [BookingController::class, 'show']);
    });


    // --- 3. GENERAL AUTH ROUTES ---
    // Akses profil dan logout (diberikan kepada semua role yang terautentikasi)
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
