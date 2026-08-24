<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StaffAuthMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Check if the user is authenticated
    if (!Auth::check()) {
      // If not authenticated, redirect to main login page with staff tab
      return redirect()->route('admin.login');
    }

    // If already authenticated, proceed with the request
    return $next($request);
  }
}