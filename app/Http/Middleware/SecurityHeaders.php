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

        // Cegah clickjacking - halaman tidak boleh dimuat dalam iframe
        $response->headers->set('X-Frame-Options', 'DENY');

        // Cegah browser menebak-nebak tipe konten (MIME sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Kontrol informasi referrer yang dikirim
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Paksa HTTPS di browser selama 1 tahun (hanya aktif di production)
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Nonaktifkan fitur browser yang tidak perlu
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // Content Security Policy — sesuaikan dengan CDN yang dipakai project ini
        $response->headers->set('Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' " .
                "https://cdn.jsdelivr.net " .
                "https://cdnjs.cloudflare.com " .
                "https://fonts.googleapis.com; " .
            "style-src 'self' 'unsafe-inline' " .
                "https://cdn.jsdelivr.net " .
                "https://cdnjs.cloudflare.com " .
                "https://fonts.googleapis.com; " .
            "font-src 'self' " .
                "https://fonts.gstatic.com " .
                "https://cdnjs.cloudflare.com; " .
            "img-src 'self' data: https:; " .
            "connect-src 'self'; " .
            "frame-ancestors 'none';"
        );

        // Hapus header yang mengungkap teknologi server
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}