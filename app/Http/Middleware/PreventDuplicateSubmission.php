<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * PreventDuplicateSubmission
 *
 * Middleware backend yang memblokir request POST duplikat
 * dalam jeda 5 detik dari user yang sama ke endpoint yang sama.
 *
 * Cara kerja:
 * - Setiap POST request diberi kunci unik berdasarkan: user_id + URL + fingerprint isi form
 * - Jika kunci yang sama sudah ada di cache, request diblokir
 * - Kunci otomatis expired setelah 5 detik
 */
class PreventDuplicateSubmission
{
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya cek method POST, PUT, PATCH (bukan GET)
        if (!$request->isMethod('POST') && !$request->isMethod('PUT') && !$request->isMethod('PATCH')) {
            return $next($request);
        }

        // Buat fingerprint unik dari kombinasi:
        // user id + URL + isi form yang penting (tanpa token CSRF)
        $formData = $request->except(['_token', '_method']);
        $fingerprint = md5(
            ($request->user()?->id ?? $request->ip()) .
            '|' . $request->fullUrl() .
            '|' . serialize($formData)
        );

        $cacheKey = 'form_submit_' . $fingerprint;

        // Jika kunci sudah ada → request duplikat
        if (Cache::has($cacheKey)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Permintaan duplikat. Harap tunggu sebelum mengirim ulang.'
                ], 429);
            }

            return redirect()->back()
                ->withInput()
                ->with('warning', 'Permintaan Anda sedang diproses. Mohon jangan klik tombol berulang kali.');
        }

        // Simpan kunci ke cache selama 5 detik
        Cache::put($cacheKey, true, now()->addSeconds(5));

        return $next($request);
    }
}