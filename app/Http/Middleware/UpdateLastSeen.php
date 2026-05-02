<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userId  = Auth::id();
            $cacheKey = "user_ping_{$userId}";

            // Throttle DB update: max sekali per 60 detik per user
            if (!Cache::has($cacheKey)) {
                Auth::user()->updateQuietly(['last_seen_at' => now()]);
                Cache::put($cacheKey, true, 60);
            }
        }

        return $next($request);
    }
}
