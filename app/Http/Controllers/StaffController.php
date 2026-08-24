<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Show staff login form (users table)
     */
    public function showLoginForm()
    {
        return view('staff.login');
    }

    /**
     * Handle staff login (users table)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to log the staff user in
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
            // Check if user is active
            if (isset($user->is_active) && $user->is_active == 0) {
                Auth::logout();
                return redirect()
                    ->back()
                    ->with('error', 'Your account is deactivated. Please contact administrator.');
            }
            
            $request->session()->put('staff_name', $user->name ?? ($user->first_name . ' ' . $user->last_name));
            $request->session()->put('email', $user->email);
            $request->session()->put('role', 'Staff');

            return redirect()->intended('staff/dashboard');
        }

        // If unsuccessful, then redirect back to the login with the form data
        return redirect()
            ->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    /**
     * Handle staff logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }
}