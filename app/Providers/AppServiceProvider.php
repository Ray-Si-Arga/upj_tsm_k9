<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // [PERBAIKAN #10] Force HTTPS di production
        // Semua URL yang di-generate Laravel akan menggunakan https://
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // [PERBAIKAN #11] Log query yang lambat (> 1 detik) untuk monitoring
        // Berguna untuk deteksi anomali / serangan injection yang menyebabkan query berat
        if (app()->environment('production')) {
            DB::whenQueryingForLongerThan(1000, function () {
                Log::warning('Query lambat terdeteksi', [
                    'url'  => request()->fullUrl(),
                    'user' => auth()->id(),
                    'time' => now()->toDateTimeString(),
                ]);
            });
        }
    }
}