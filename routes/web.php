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

// Rute Dashboard Jika User Sudah Masuk Ke Aplikasi Dan Belum Logout
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('pelanggan.dashboard');
    }
    return view('welcome');
});

// Autentikasi
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])
    ->name('login.post');

Route::get('/register', [AuthController::class, 'publicRegister'])->name('public.register');
Route::post('/register', [AuthController::class, 'publicRegisterPost'])
    ->name('public.register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // Pelanggan
    Route::get('/pelanggan/dashboard', [BookingController::class, 'pelangganDashboard'])->name('pelanggan.dashboard');
    Route::get('/pelanggan/service', [BookingController::class, 'create'])->name('pelanggan.service');
    Route::post('/pelanggan/service', [BookingController::class, 'store'])
        ->name('customer.booking.store')
        ->middleware('no_duplicate');
    Route::get('/pelanggan/history', [BookingController::class, 'pelangganHistory'])->name('pelanggan.history');
    Route::get('/cek-jadwal', [BookingController::class, 'checkDate'])->name('check.date');

    // Advisor
    Route::prefix('advisor')->name('advisor.')->group(function () {
        Route::get('/index', [ServiceAdvisorController::class, 'index'])->name('index');
        Route::get('/create', [ServiceAdvisorController::class, 'create'])->name('create');
        Route::post('/store', [ServiceAdvisorController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ServiceAdvisorController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ServiceAdvisorController::class, 'update'])->name('update');
        Route::get('/preview/{id}', [CetakController::class, 'preview'])->name('preview');
    });

    // Service Layanan
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index')->middleware('admin');
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store')->middleware('admin');
    Route::put('/layanan/update/{id}', [LayananController::class, 'update'])->name('layanan.update')->middleware('admin');
    Route::delete('/layanan/delete/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy')->middleware('admin');

    // Booking Walk In
    Route::get('admin/booking/create', [BookingController::class, 'createWalkIn'])->name('booking.walkin')->middleware('admin');
    Route::post('admin/booking/store', [BookingController::class, 'storeWalkIn'])
        ->name('booking.storeWalkIn')
        ->middleware(['admin', 'no_duplicate']);

    // Dashboard & Jadwal
    Route::get('/dashboard', [BookingController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('admin');
    Route::get('/jadwal', [BookingController::class, 'jadwal'])->name('admin.jadwal')->middleware('admin');
    Route::post('/jadwal/store', [BookingController::class, 'storeJadwal'])->name('jadwal.store')->middleware('admin');
    Route::delete('/jadwal/{date}', [BookingController::class, 'deleteJadwal'])->name('jadwal.delete')->middleware('admin');

    // Inventory
    Route::prefix('inventory')->name('inventory.')->middleware('admin')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
    });

    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'profileUpdate'])->name('profile.update');

    // Booking
    Route::prefix('booking')->name('booking.')->group(function () {

        // Fixed segment (harus di atas {id})
        Route::get('/queue', [BookingController::class, 'queueList'])->name('queue')->middleware('admin');
        Route::get('/create', [BookingController::class, 'create'])->name('create');

        // Halaman sukses — diakses customer setelah submit, TANPA middleware admin
        Route::get('/success/{id}', [BookingController::class, 'success'])->name('success');

        // Index & Store
        Route::get('/', [BookingController::class, 'index'])->name('index')->middleware('admin');
        Route::post('/store', [BookingController::class, 'store'])->name('store')->middleware('admin');

        // Wildcard {id} — di paling bawah
        Route::get('/{id}', [BookingController::class, 'show'])->name('show');
        Route::post('/{id}/update-status', [BookingController::class, 'updateStatus'])->name('updateStatus')->middleware('admin');
        Route::get('/{id}/history', [BookingController::class, 'historyDetail'])->name('history.detail');
        Route::delete('/destroy/{id}', [BookingController::class, 'destroy'])->name('destroy')->middleware('admin');
    });

    // Keuangan
    Route::prefix('keuangan')->name('keuangan.')->middleware('admin')->group(function () {
        Route::get('/', [KeuanganController::class, 'index'])->name('index');
        Route::post('/store', [KeuanganController::class, 'store'])->name('store');
        Route::delete('/{id}', [KeuanganController::class, 'destroy'])->name('destroy');
        Route::get('/cetak', [KeuanganController::class, 'cetak'])->name('cetak');
    });

    // Customers
    Route::prefix('customers')->name('customers.')->middleware('admin')->group(function () {
        Route::get('/', [BookingController::class, 'customers'])->name('index');
        Route::get('/{id}/bookings', [BookingController::class, 'customerBookings'])->name('bookings');
        Route::get('/new-count', [BookingController::class, 'getNewCustomersCount'])->name('new-count');
        Route::post('/mark-checked', [BookingController::class, 'markCustomersChecked'])->name('mark-checked');
    });

    // Hapus User
    Route::delete('/hapus/{id}', [AuthController::class, 'hapus'])->name('hapus')->middleware('admin');
});