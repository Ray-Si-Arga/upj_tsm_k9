<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, string $ability): Response
    {
        if (!$request->user() || !$request->user()->tokenCan($ability)) {
            return response()->json([
                'message' => 'Forbidden. Requires ability: ' . $ability
            ], 403);
        }

        return $next($request);
    }
}

