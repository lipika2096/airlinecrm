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
        $user = User::where('id', auth()->user()->id)->whereNull('deleted_at')->first();
        
        $employee = User::where('email', $user->email)->whereNull('deleted_at')->first();
        $profile = User::where('id', $user->id)->whereNull('deleted_at')->first();
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

    /**
     * Update user timezone
     */
    public function updateTimezone(Request $request)
    {
        $user = null;
        
        if (auth()->guard('admin')->check()) {
            $user = auth()->guard('admin')->user();
        } elseif (auth()->guard('employee')->check()) {
            $user = auth()->guard('employee')->user();
        } elseif (auth()->check()) {
            $user = auth()->user();
        }
        
        if (!$user) {
            return redirect()->back()->with('timezone_error', 'User not authenticated!');
        }
        
        $request->validate([
            'timezone' => 'nullable|string',
        ]);

        // Update timezone - if empty, set to null to use system default
        $user->timezone = empty($request->timezone) ? null : $request->timezone;
        
        try {
            $user->save();
            
            // Refresh the user to get the updated timezone
            $user->refresh();
            
            // Set the new timezone for the current session
            \App\Helpers\TimezoneHelper::setAppTimezone();
            
            return redirect()->back()->with('timezone_success', 'Timezone updated successfully! Current timezone: ' . ($user->timezone ?? 'System Default'));
        } catch (\Exception $e) {
            return redirect()->back()->with('timezone_error', 'Failed to update timezone: ' . $e->getMessage());
        }
    }


    // Add other methods as per your defined routes
}
