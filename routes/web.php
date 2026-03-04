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


//Rute Dashboard
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('pelanggan.dashboard');
    }
    return view('welcome');
});

// Otentikasi & Registrasi
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/register', [AuthController::class, 'publicRegister'])->name('public.register');
Route::post('/register', [AuthController::class, 'publicRegisterPost'])->name('public.register.post');
Route::get('/hapus/{id}', [AuthController::class, 'hapus'])->name('hapus');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Yang Diharuskan Autentikasi
Route::middleware(['auth'])->group(function () {
    //Pelanggan / Customer
    Route::get('/pelanggan/dashboard', [BookingController::class, 'pelangganDashboard'])->name('pelanggan.dashboard');
    Route::get('/pelanggan/service', [BookingController::class, 'create'])->name('pelanggan.service');
    Route::post('/pelanggan/service', [BookingController::class, 'store'])->name('customer.booking.store');
    Route::get('/pelanggan/history', [BookingController::class, 'pelangganHistory'])->name('pelanggan.history');
    Route::get('/cek-jadwal', [BookingController::class, 'checkDate'])->name('check.date');

    //Advisor
    Route::prefix('advisor')->name('advisor.')->group(function () {
        Route::get('/index', [ServiceAdvisorController::class, 'index'])->name('index');
        Route::get('/create', [ServiceAdvisorController::class, 'create'])->name('create');
        Route::post('/store', [ServiceAdvisorController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ServiceAdvisorController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ServiceAdvisorController::class, 'update'])->name('update');
        Route::get('/print/{id}', [CetakController::class, 'print'])->name('print');
    });

    //Service Layanan
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/update/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/delete/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');

    //Booking Walk In
    Route::get('admin/booking/create', [BookingController::class, 'createWalkIn'])->name('booking.walkin');
    Route::post('admin/booking/store', [BookingController::class, 'storeWalkIn'])->name('booking.storeWalkIn');

    //Dashboard Autentikasi
    Route::get('/dashboard', [BookingController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/jadwal', [BookingController::class, 'jadwal'])->name('admin.jadwal');

    //Inventory
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
    });

    //Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'profileUpdate'])->name('profile.update');

    //Booking
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

        Route::delete('/destroy/{id}', [BookingController::class, 'destroy'])->name('destroy');
    });

    //Keuangan
    Route::prefix('keuangan')->name('keuangan.')->group(function () {
        Route::get('/', [KeuanganController::class, 'index'])->name('index');
        Route::post('/store', [KeuanganController::class, 'store'])->name('store');
        Route::delete('/{id}', [KeuanganController::class, 'destroy'])->name('destroy');
        Route::get('/cetak', [KeuanganController::class, 'cetak'])->name('cetak');
    });

    //Customers
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [BookingController::class, 'customers'])->name('index');
        Route::get('/{id}/bookings', [BookingController::class, 'customerBookings'])->name('bookings');
        Route::get('/new-count', [BookingController::class, 'getNewCustomersCount'])->name('new-count');
        Route::post('/mark-checked', [BookingController::class, 'markCustomersChecked'])->name('mark-checked');
    });
});
