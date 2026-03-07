<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Cegah clickjacking — halaman tidak bisa dibuka dalam iframe oleh site lain
        $response->headers->set('X-Frame-Options', 'DENY');

        // Cegah browser menebak tipe file (MIME sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Kontrol informasi URL yang dikirim saat klik link keluar
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Paksa HTTPS selama 1 tahun (hanya aktif di production)
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Nonaktifkan fitur browser yang tidak dipakai (kamera, mikrofon, GPS, payment)
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // CSP (Content-Security-Policy) SENGAJA DIHAPUS:

        // Hapus header yang mengungkap teknologi server
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}