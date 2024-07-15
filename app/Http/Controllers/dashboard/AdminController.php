<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
          ]);
          $credentials = $request->only('email', 'password');
          // Attempt to log the user in
          if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $admin = Auth::guard('admin')->user();
            $request->session()->put('admin_name', $admin->name);
            $request->session()->put('email', $admin->email);
            $request->session()->put('role', 'Superadmin');

            return redirect()->route('admin.dashboard');
          }

          // If unsuccessful, then redirect back to the login with the form data
          // If unsuccessful, then redirect back to the login with the form data
          return redirect()
            ->back()
            ->with('error', 'These credentials do not match our records.');
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Log the admin out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return view('admin.index'); // Redirect to the login page
    }
}
