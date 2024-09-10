<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Calender; // Import Event model
use App\Models\EventStatus;
use App\Models\Holiday;
use App\Models\Employee;
use App\Models\EmployeeLeave;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Get counts from the database
        $employeeCount = DB::table('employees')->count();
        $agentCount = DB::table('agents')->count();
        $ticketCount = DB::table('air_tickets')->count();
        $groupCount = DB::table('groups')->count();
        $leadCount = DB::table('detail_leads')->count();
        $total_todo = Calender::count();
        $eventStatus = EventStatus::where('status_type', 'pending')->first();
        $pending_todo = Calender::where('status', $eventStatus->id)->count();
        // Get current month's start and end dates
        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();
        $today_leave = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
        ->whereDate('to', '>=', now()->toDateString())
        ->get();
        $tomorrow_leave = EmployeeLeave::whereDate('from', '<=', now()->addDay()->toDateString())
        ->whereDate('to', '>=', now()->addDay()->toDateString())
        ->get();
        $next_seven_days = EmployeeLeave::whereDate('from', '<=', now()->addDays(7)->toDateString())
        ->whereDate('to', '>=', now()->toDateString())
        ->get();


        // Get upcoming holidays for the current month
        $upcomingHolidays = Holiday::whereBetween('holiday_date', [$currentMonthStart, $currentMonthEnd])
            ->orderBy('holiday_date', 'asc')
            ->get();
        // Pass counts to the view
        return view('admin.admin-dashboard', compact('employeeCount', 'agentCount', 'ticketCount', 'groupCount', 'leadCount','total_todo','today_leave','tomorrow_leave','next_seven_days', 'pending_todo','upcomingHolidays'));
    }

    public function employeeDashboard()
    {
        return view('admin.employee-dashboard'); // Replace with your employee dashboard view
    }
    
    public function comingSoon(){
         return view('admin.coming-soon'); 
    }
}
