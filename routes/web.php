<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ServiceAdvisorController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\CetakController;

// ---------------------------------------------------------------- //
// ---------------- Halaman Publik --------------------------------- //
// ---------------------------------------------------------------- //
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('pelanggan.dashboard');
    }
    return view('welcome');
});

// ---------------------------------------------------------------- //
// ---------------- Autentikasi & Registrasi ---------------------- //
// ---------------------------------------------------------------- //

// [PERBAIKAN #3] Rate limiting: login max 5x/menit, register max 3x/menit
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])
    ->name('login.post')
    ->middleware('throttle:5,1');

Route::get('/register', [AuthController::class, 'publicRegister'])->name('public.register');
Route::post('/register', [AuthController::class, 'publicRegisterPost'])
    ->name('public.register.post')
    ->middleware('throttle:3,1');

// [PERBAIKAN #2] Logout sekarang menggunakan POST (bukan GET)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ---------------------------------------------------------------- //
// ---------------- Route Pelanggan (Wajib Login) ----------------- //
// ---------------------------------------------------------------- //

// [PERBAIKAN #1] Semua route pelanggan sekarang dilindungi middleware auth
Route::middleware(['auth'])->group(function () {

    Route::get('/pelanggan/dashboard', [BookingController::class, 'pelangganDashboard'])->name('pelanggan.dashboard');
    Route::get('/pelanggan/service', [BookingController::class, 'create'])->name('pelanggan.service');
    Route::post('/pelanggan/service', [BookingController::class, 'store'])
        ->name('customer.booking.store')
        ->middleware('no_duplicate'); // Anti double submit
    Route::get('/pelanggan/history', [BookingController::class, 'pelangganHistory'])->name('pelanggan.history');
    Route::get('/cek-jadwal', [BookingController::class, 'checkDate'])->name('check.date');

    // ----------------------------------------- //
    // ---------------- Profile ---------------- //
    // ----------------------------------------- //
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'profileUpdate'])->name('profile.update');
});

// ---------------------------------------------------------------- //
// -------- Route Advisor (tanpa auth — akses internal) ----------- //
// ---------------------------------------------------------------- //
Route::prefix('advisor')->name('advisor.')->group(function () {
    Route::get('/index', [ServiceAdvisorController::class, 'index'])->name('index');
    Route::get('/create', [ServiceAdvisorController::class, 'create'])->name('create');
    Route::post('/store', [ServiceAdvisorController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ServiceAdvisorController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ServiceAdvisorController::class, 'update'])->name('update');
    Route::get('/print/{id}', [CetakController::class, 'print'])->name('print');
});

// ---------------------------------------------------------------- //
// ---------------- Route Admin (Wajib Login + Admin Role) -------- //
// ---------------------------------------------------------------- //

// [PERBAIKAN #1] Hapus user sekarang hanya bisa diakses admin yang sudah login
// [PERBAIKAN #1] Route hapus dipindahkan ke dalam middleware auth + admin
Route::middleware(['auth', 'admin'])->group(function () {

    // Hapus pengguna — sekarang aman (hanya admin, POST bukan GET)
    Route::delete('/hapus/{id}', [AuthController::class, 'hapus'])->name('hapus');

    // ----------------------------------------- //
    // ---------------- Layanan --------------- //
    // ----------------------------------------- //
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/update/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/delete/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');

    // ----------------------------------------- //
    // --- Booking Walk-in (Admin Input) ------- //
    // ----------------------------------------- //
    Route::get('admin/booking/create', [BookingController::class, 'createWalkIn'])->name('booking.walkin');
    Route::post('admin/booking/store', [BookingController::class, 'storeWalkIn'])
        ->name('booking.storeWalkIn')
        ->middleware('no_duplicate'); // Anti double submit

    // ----------------------------------------- //
    // ---- Dashboard & Jadwal Admin ----------- //
    // ----------------------------------------- //
    Route::get('/dashboard', [BookingController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/jadwal', [BookingController::class, 'jadwal'])->name('admin.jadwal');
    Route::post('/jadwal/store', [BookingController::class, 'storeJadwal'])->name('jadwal.store');
    Route::delete('/jadwal/{date}', [BookingController::class, 'deleteJadwal'])->name('jadwal.delete');

    // ----------------------------------------- //
    // ---------------- Inventory -------------- //
    // ----------------------------------------- //
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
    });

    // ----------------------------------------- //
    // ---------------- Booking ---------------- //
    // ----------------------------------------- //
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/queue', [BookingController::class, 'queueList'])->name('queue');
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::get('/success/{id}', [BookingController::class, 'success'])->name('success');
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::post('/store', [BookingController::class, 'store'])->name('store');
        Route::get('/{id}', [BookingController::class, 'show'])->name('show');
        Route::post('/{id}/update-status', [BookingController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}/history', [BookingController::class, 'historyDetail'])->name('history.detail');
        Route::delete('/destroy/{id}', [BookingController::class, 'destroy'])->name('destroy');
    });

    // ----------------------------------------- //
    // ---------------- Keuangan --------------- //
    // ----------------------------------------- //
    Route::prefix('keuangan')->name('keuangan.')->group(function () {
        Route::get('/', [KeuanganController::class, 'index'])->name('index');
        Route::post('/store', [KeuanganController::class, 'store'])->name('store');
        Route::delete('/{id}', [KeuanganController::class, 'destroy'])->name('destroy');
        Route::get('/cetak', [KeuanganController::class, 'cetak'])->name('cetak');
    });

    // ----------------------------------------- //
    // ---------------- Customers -------------- //
    // ----------------------------------------- //
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [BookingController::class, 'customers'])->name('index');
        Route::get('/{id}/bookings', [BookingController::class, 'customerBookings'])->name('bookings');
        Route::get('/new-count', [BookingController::class, 'getNewCustomersCount'])->name('new-count');
        Route::post('/mark-checked', [BookingController::class, 'markCustomersChecked'])->name('mark-checked');
    });
});