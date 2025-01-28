<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function registerAdmin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'full_name' => 'required'
        ]);
        $admin = Admin::create([
            'email' =>  $request->input('email'),
            'password' =>  Hash::make($request->input('password')),
            'name' =>  $request->input('full_name'),
            'plain_password' => $request->password
        ]);

        $role = Role::findById($request->input('role'),'web');
        $admin->assignRole($role);

        return redirect()->back()->with('success', 'New Admin created successfully');
    }

    public function showAllAdmin(Request $request){
        $admin = Admin::latest()->get();
        $roles = Role::with('permissions')->where('name', '!=', 'superAdmin')->get();
        return view('admin.admin-view', compact('admin', 'roles'));
    }

    public function editAdmin(Request $request, $id){
        $admin = Admin::find($id);
        $admin->update([
            'name' => $request->full_name,
            'email' => $request->email,
        ]);
        return redirect()->back()->with('success', 'Admin updated successfully');
    }


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
