<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Check if the user is authenticated as admin
    if (!Auth::guard('admin')->check()) {
      // If not authenticated as admin, check if login form is submitted
      if ($request->isMethod('post')) {
        // Attempt to authenticate the admin user
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
          // If authentication successful, redirect to intended URL
          $admin = Auth::guard('admin')->user();
          $request->session()->put('admin_name', $admin->name);
          
          // Check if user has SuperAdmin role
          if ($admin->hasRole('SuperAdmin')) {
            $request->session()->put('role', 'Superadmin');
            return redirect()->intended('superadmin/dashboard');
          } else {
            // If not SuperAdmin, treat as customer
            $request->session()->put('role', 'Customer');
            return redirect()->intended('customer/dashboard');
          }
        } else {
          // If authentication failed, return the login form with errors
          return redirect()
            ->back()
            ->withErrors(['email' => 'Invalid credentials']);
        }
      } else {
        // If not a POST request, display the admin login form
        $response = response()->view('admin.index');
        $response->withCookie(cookie('admin_not_authenticated', 'true', 60)); // Set cookie for 60 minutes
        return $response;
      }
    }

    // If already authenticated as admin, check role and redirect if needed
    $admin = Auth::guard('admin')->user();
    if (!$admin->hasRole('SuperAdmin')) {
      // Customer should not access superadmin routes
      return redirect()->to('customer/dashboard');
    }

    // If already authenticated as SuperAdmin, proceed with the request
    return $next($request);
  }
}
