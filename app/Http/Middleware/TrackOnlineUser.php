<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackOnlineUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Update last_seen_at every request (throttle to prevent excessive DB writes)
            // Only update if last_seen_at is null or older than 1 minute
            if (!$user->last_seen_at || $user->last_seen_at->diffInMinutes(now()) >= 1) {
                $user->update(['last_seen_at' => now()]);
            }
        }

        return $next($request);
    }
}
