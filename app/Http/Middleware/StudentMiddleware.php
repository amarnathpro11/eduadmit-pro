<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StudentMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle($request, Closure $next)
  {
    if (!auth('student')->check()) {
      return redirect()->route('student.login');
    }

    if (auth('student')->user()->role->name !== 'student') {
      abort(403);
    }

    if (!auth('student')->user()->is_active) {
      Auth::guard('student')->logout();
      return redirect()->route('student.login')->with('error', 'Your account has been deactivated. Please contact admin.');
    }

    return $next($request);
  }
}
