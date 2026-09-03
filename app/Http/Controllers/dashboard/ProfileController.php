<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function employeeProfile()
    {
        // Add your logic for employee profile view
        $user = User::find(auth()->user()->id);
        
        $employee = User::where('email', $user->email)->first();
        $profile = User::where('id', $user->id)->first();
        return view('admin.client-profile', compact('profile')); // Example view path, adjust as per your structure
    }

    public function clientProfile()
    {
        // Add your logic for client profile view
        $profile = Admin::with(['adminDetail'])->find(auth('admin')->user()->id);
        return view('admin.client-profile', compact('profile')); // Example view path, adjust as per your structure
    }

    public function adminProfile()
    {
        // Add your logic for client profile view

        $customer = Admin::with(['adminDetail', 'kycDocuments'])->find(auth('admin')->user()->id);
        return view('admin.profile', compact('customer')); // Example view path, adjust as per your structure
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->guard('admin')->check() ? auth()->guard('admin')->user() : auth()->guard('employee')->user();
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('password_error', 'Current password is incorrect!');
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->plain_password = $request->new_password; // If you store plain password
        $user->save();

        return redirect()->back()->with('password_success', 'Password updated successfully!');
    }


    // Add other methods as per your defined routes
}
