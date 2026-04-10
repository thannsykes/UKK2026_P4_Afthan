<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'petugas'])) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk petugas.');
        }

        return $next($request);
    }
}