<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ServiceAdvisorController;
use Illuminate\Support\Facades\Route;


// --- Rute Dashboard ---
Route::get('/', function () {
    return view('dashboard');
});

Route::get('pelanggan/dashboard', function () {
    return view('pelanggan/dashboard');
});


// ------------------------------------------------------------- //
// ---------------- Otentikasi & Registrasi -------------------- //
// ------------------------------------------------------------- //
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
Route::get('/hapus/{id}', [AuthController::class, 'hapus'])->name('hapus');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// ----------------------------------------------- //
// ---------------- Advisor -------------------- //
// ----------------------------------------------- //
Route::prefix('advisor')->name('advisor.')->group(function () {
    Route::get('/history', [ServiceAdvisorController::class, 'index'])->name('index');
    Route::get('/create', [ServiceAdvisorController::class, 'create'])->name('create');
    Route::post('/store', [ServiceAdvisorController::class, 'store'])->name('store');
    Route::get('/{advisor}/print', [ServiceAdvisorController::class, 'print'])->name('print');
});


// ---------------------------------------------------------------------- //
// ---------------- Rute Yang Diharuskan Autentikasi -------------------- //
// ---------------------------------------------------------------------- //
Route::middleware(['auth'])->group(function () {
    // ------------------------------------------------------------------------ //
    // ---------------- Booking Admin jika customer gaptek -------------------- //
    // ------------------------------------------------------------------------ //
    Route::get('admin/booking/create', [BookingController::class, 'createWalkIn'])->name('booking.walkin');
    Route::post('admin/booking/store', [BookingController::class, 'storeWalkIn'])->name('booking.store');


    // ----------------------------------------------------------- //
    // ---------------- Dashboard Autentikasi -------------------- //
    // ----------------------------------------------------------- //
    Route::get('/dashboard', [BookingController::class, 'adminDashboard'])->name('admin.dashboard');

    // ----------------------------------------------- //
    // ---------------- Inventory -------------------- //
    // ----------------------------------------------- //
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/create', [InventoryController::class, 'create'])->name('create');
        Route::post('/store', [InventoryController::class, 'store'])->name('store');
        Route::get('/edit/{inventory}', [InventoryController::class, 'edit'])->name('edit');
        Route::put('/update/{inventory}', [InventoryController::class, 'update'])->name('update');
        Route::delete('/destroy/{inventory}', [InventoryController::class, 'destroy'])->name('destroy');
    });

    // --------------------------------------------- //
    // ---------------- Profile -------------------- //
    // --------------------------------------------- //
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'profileUpdate'])->name('profile.update');

    // --------------------------------------------- //
    // ---------------- Booking -------------------- //
    // --------------------------------------------- //
    Route::prefix('booking')->name('booking.')->group(function () {

        // 1. Rute dengan Fixed Segment (Diutamakan)
        Route::get('/queue', [BookingController::class, 'queueList'])->name('queue');
        Route::get('/create', [BookingController::class, 'create'])->name('create');

        // 2. Rute untuk Konfirmasi Sukses (Harus di atas {id})
        Route::get('/success/{id}', [BookingController::class, 'success'])->name('success');

        // 3. Rute Index & Store
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::post('/store', [BookingController::class, 'store'])->name('store');

        // 4. Rute dengan Wildcard Parameter {id} (Di paling bawah)
        Route::get('/{id}', [BookingController::class, 'show'])->name('show');
        Route::post('/{id}/update-status', [BookingController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}/history', [BookingController::class, 'historyDetail'])->name('history.detail');
    });

    // ----------------------------------------------- //
    // ---------------- Customers -------------------- //
    // ----------------------------------------------- //
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [BookingController::class, 'customers'])->name('index');
        Route::get('/{whatsapp}/bookings', [BookingController::class, 'customerBookings'])->name('bookings');
        Route::get('/new-count', [BookingController::class, 'getNewCustomersCount'])->name('new-count');
        Route::post('/mark-checked', [BookingController::class, 'markCustomersChecked'])->name('mark-checked');
    });
});
