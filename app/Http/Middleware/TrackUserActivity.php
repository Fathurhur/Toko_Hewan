<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if ($user = Auth::user()) {
            $user->last_seen = \Illuminate\Support\Carbon::now();
            $user->save();
        }
        return $next($request);
    }
}
