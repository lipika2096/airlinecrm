<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicketSetting;
use App\Models\TicketStatus;

class SettingController extends Controller
{
    public function index()
    {
        // Add your logic for settix view
        return view('admin.settings'); // Example view path, adjust as per your structure
    }

    /**
     * Show support ticket settings
     */
    public function supportTicketSettings()
    {
        // Check if user is superadmin
        if (!auth('admin')->check() || !auth('admin')->user()->hasRole('SuperAdmin')) {
            return redirect()->back()->with('error', 'You are not authorized to access this page.');
        }

        $settings = SupportTicketSetting::getSettings();
        $ticketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.support-ticket-settings', compact('settings', 'ticketStatuses'));
    }

    /**
     * Update support ticket settings
     */
    public function updateSupportTicketSettings(Request $request)
    {
        // Check if user is superadmin
        if (!auth('admin')->check() || !auth('admin')->user()->hasRole('SuperAdmin')) {
            return redirect()->back()->with('error', 'You are not authorized to perform this action.');
        }

        $request->validate([
            'auto_close_hours' => 'required|integer|min:1|max:8760', // Max 1 year (8760 hours)
            'auto_close_enabled' => 'required|boolean',
            'auto_close_statuses' => 'nullable|array',
            'auto_close_statuses.*' => 'exists:ticket_statuses,slug',
        ]);

        $settings = SupportTicketSetting::getSettings();
        $settings->auto_close_hours = $request->auto_close_hours;
        $settings->auto_close_enabled = $request->auto_close_enabled;
        $settings->auto_close_statuses = $request->auto_close_statuses ? implode(',', $request->auto_close_statuses) : null;
        $settings->save();

        return redirect()->back()->with('success', 'Support ticket settings updated successfully.');
    }

    // Add other methods as per your defined routes
}
