<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
  /**
   * Handle an incoming request.
   */
  public function handle($request, Closure $next, ...$guards)
  {
    if (Auth::check()) {
      $user = Auth::user();
      if ($user->hasAnyRole(['Admin', 'Blogger'])) {
        return redirect()->route('admin.dashboard');
      }
      return redirect()->route('public.home');
    }

    return $next($request);
  }
}
