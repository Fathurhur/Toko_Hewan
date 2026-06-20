<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login DAN role-nya sesuai dengan yang diminta
        if (!auth()->check() || auth()->user()->role !== $role) {
            abort(403, 'Akses Ditolak. Halaman ini bukan untuk Anda.');
        }

        return $next($request);
    }
}
