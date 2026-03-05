<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\AdminOnly;                   // [PERBAIKAN #6] Middleware role admin
use App\Http\Middleware\SecurityHeaders;             // [PERBAIKAN #9] Security headers
use App\Http\Middleware\PreventDuplicateSubmission;  // Anti double submit

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // [PERBAIKAN #9] Tambahkan SecurityHeaders ke semua request web
        $middleware->web(append: [
            SecurityHeaders::class,
        ]);

        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'role'         => CheckUserRole::class,
            'admin'        => AdminOnly::class,
            'no_duplicate' => PreventDuplicateSubmission::class, // Anti double submit
        ]);

        // [PERBAIKAN #3] Rate limiting sudah dikonfigurasi di routes/web.php
        // Laravel sudah punya throttle middleware bawaan
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();