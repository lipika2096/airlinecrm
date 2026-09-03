<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use Carbon\Carbon;
use App\Models\User;

class PasswordResetController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForgotPassword()
    {
        return view('admin.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            $user = User::where('email', $request->email)->first();
            if(!$user){
                return back()->with('error', 'We cannot find a user with that email address.');

            }
        }

        // Generate a password reset token
        $token = Str::random(60);

        // Store the token in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Send the password reset link via email
        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        try {
            if($admin){
                \Mail::raw("Hello {$admin->name },\n\nYou requested a password reset for your account.\n\nClick the link below to reset your password:\n{$resetLink}\n\nThis link will expire in 60 minutes.\n\nIf you did not request this, please ignore this email.\n\nThank you.", function($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Password Reset Request');
                });
            }
            else{
                    \Mail::raw("Hello {$user->first_name },\n\nYou requested a password reset for your account.\n\nClick the link below to reset your password:\n{$resetLink}\n\nThis link will expire in 60 minutes.\n\nIf you did not request this, please ignore this email.\n\nThank you.", function($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Password Reset Request');
                });
            }

            return back()->with('success', 'We have emailed your password reset link!');
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
            return back()->with('error', 'Failed to send password reset email. Please try again.');
        }
    }

    /**
     * Show the password reset form
     */
    public function showResetPassword(Request $request, $token)
    {
        return view('admin.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Find the token record
        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenRecord) {
            return back()->with('error', 'Invalid or expired password reset token.');
        }

        // Verify the token
        if (!Hash::check($request->token, $tokenRecord->token)) {
            return back()->with('error', 'Invalid or expired password reset token.');
        }

        // Check if token is expired (60 minutes)
        if (Carbon::parse($tokenRecord->created_at)->addMinutes(60)->isPast()) {
            return back()->with('error', 'This password reset link has expired.');
        }

        // Find the user and update password
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            $user = User::where('email', $request->email)->first();
            if(!$user){
                return back()->with('error', 'We cannot find a user with that email address.');
            }
        }
        if($admin){
            $admin->password = Hash::make($request->password);
            $admin->plain_password = $request->password; // Update plain password as well
            $admin->save();
        }   
        else{            
            $user->password = Hash::make($request->password);
            $user->plain_password = $request->password; // Update plain password as well
            $user->save();
        }

        // Delete the used token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Send password reset confirmation email
        try {
            if($admin){
                \Mail::raw("Hello {$admin->name},\n\nYour password has been successfully reset.\n\nIf you did not make this change, please contact support immediately.\n\nThank you.", function($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Password Reset Confirmation');
                });
            }
            else{
                \Mail::raw("Hello {$user->first_name },\n\nYou requested a password reset for your account.\n\nClick the link below to reset your password:\n{$resetLink}\n\nThis link will expire in 60 minutes.\n\nIf you did not request this, please ignore this email.\n\nThank you.", function($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Password Reset Request');
                });
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset confirmation email: ' . $e->getMessage());
        }

        return redirect('/')->with('success', 'Your password has been reset successfully! You can now login with your new password.');
    }
}