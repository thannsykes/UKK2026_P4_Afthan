<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnggotaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'anggota') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk anggota.');
        }

        return $next($request);
    }
}