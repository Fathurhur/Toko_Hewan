<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Expect middleware usage like: middleware('role:admin')
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();

        if (! $user || $user->role !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
