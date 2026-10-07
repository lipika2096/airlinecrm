<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordUpdatedMail;
use Illuminate\Support\Facades\Mail;


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
        try {
            \Log::info('Password update attempt started', [
                'user_id' => auth()->check() ? auth()->id() : null,
                'guard' => auth()->guard('admin')->check() ? 'admin' : (auth()->check() ? 'web' : 'none')
            ]);

            // Get the authenticated user based on the guard
            if (auth()->guard('admin')->check()) {
                $user = auth()->guard('admin')->user();
                \Log::info('User authenticated via admin guard', ['user_id' => $user->id]);
            } elseif (auth()->check()) {
                $user = auth()->user();
                \Log::info('User authenticated via web guard', ['user_id' => $user->id]);
            } else {
                \Log::error('User not authenticated');
                return redirect()->back()->with('error', 'User not authenticated!');
            }

            \Log::info('Request data', [
                'has_current_password' => isset($request->current_password),
                'has_new_password' => isset($request->new_password),
                'has_confirm_password' => isset($request->confirm_password)
            ]);

            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8',
            ]);

            \Log::info('Validation passed');

            // Check if current password matches
            if (!Hash::check($request->current_password, $user->password)) {
                \Log::error('Current password does not match', ['user_id' => $user->id]);
                return redirect()->back()->with('error', 'Current password is incorrect!');
            }

            \Log::info('Current password verified, updating password', ['user_id' => $user->id]);

            // Update password
            $user->password = Hash::make($request->new_password);
            if (isset($user->plain_password)) {
                $user->plain_password = $request->new_password;
            }
            $user->save();

            \Log::info('Password updated successfully', ['user_id' => $user->id]);

            // Send password update email
            try {
                Mail::to($user->email)->send(new PasswordUpdatedMail($user));
                \Log::info('Password update email sent successfully', ['user_id' => $user->id, 'email' => $user->email]);
            } catch (\Exception $e) {
                \Log::error('Failed to send password update email: ' . $e->getMessage(), [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
                // Continue even if email fails - password was still updated
            }

            return redirect()->back()->with('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to update password: ' . $e->getMessage(), [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to update password: ' . $e->getMessage());
        }
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
