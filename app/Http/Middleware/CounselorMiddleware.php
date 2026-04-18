<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CounselorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || (!Auth::user()->role || Auth::user()->role->name !== 'counselor')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Must be a Counselor.'], 403);
            }
            return redirect()->route('counselor.login')->with('error', 'Please login as a Counselor to access this portal.');
        }

        return $next($request);
    }
}
