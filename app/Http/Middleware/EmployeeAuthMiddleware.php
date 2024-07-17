<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EmployeeAuthMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Check if the user is authenticated as admin
    if (!Auth::guard('employee')->check()) {
      // If not authenticated as admin, check if login form is submitted
      if ($request->isMethod('post')) {
        // Attempt to authenticate the admin user
        if (Auth::guard('employee')->attempt($request->only('email', 'password'))) {
          // If authentication successful, redirect to intended URL
          $admin = Auth::guard('employee')->admin();
          $name = $admin->first_name ." ". $admin->last_name;
          $request->session()->put('employee_name', $name );
          $request->session()->put('role', 'Employee');
          return redirect()->intended('/employee/dashboard');
        } else {
          // If authentication failed, return the login form with errors
          return redirect()
            ->back()
            ->withErrors(['email' => 'Invalid credentials']);
        }
      } else {
        // If not a POST request, display the admin login form
        $response = response()->view('admin.employee-login');
        $response->withCookie(cookie('employee_not_authenticated', 'true', 60)); // Set cookie for 60 minutes
        return $response;
      }
    }

    // If already authenticated as admin, proceed with the request
    return $next($request);
  }
}
