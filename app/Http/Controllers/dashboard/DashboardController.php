<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calender; // Import Event model
use App\Models\EventStatus;
use App\Models\Admin;
use App\Models\Holiday;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {

        // Get counts from the database
        $employeeCount = DB::table('employees')->where('created_by', auth('admin')->user()->id)->count();
        $agentCount =  DB::table('agents')->count();
        $customerCount = Admin::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'superAdmin');})->count();
        $ticketCount = DB::table('air_tickets')->count();
        $groupCount = DB::table('groups')->count();
        $leadCount = DB::table('detail_leads')->count();
        $total_todo = Calender::count();
        $eventStatus = EventStatus::where('status_type', 'pending')->first();
        $pending_todo = Calender::where('status', $eventStatus->id)->count();
        // Get current month's start and end dates
        $currentMonthStart = now();
        $currentMonthEnd = now()->endOfMonth();
        $today_leave = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
        ->whereDate('to', '>=', now()->toDateString())->where('status',3)->where('created_by', auth('admin')->user()->id)
        ->get()->unique('employee_id');
        $tomorrow_leave = EmployeeLeave::whereDate('from', '<=', now()->addDay()->toDateString())
        ->whereDate('to', '>=', now()->addDay()->toDateString())->where('status',3)->where('created_by', auth('admin')->user()->id)
        ->get()->unique('employee_id');
        $next_seven_days = EmployeeLeave::whereDate('from', '<', now()->addDays(7)->toDateString())->where('created_by', auth('admin')->user()->id)
        ->whereDate('to', '>', now()->toDateString())->whereYear('from', now()->year)
        ->whereYear('to', now()->year)->where('status',3)->orderBy('from','asc')
        ->get();



        // Get upcoming holidays for the current month
        $upcomingHolidays = Holiday::whereBetween('holiday_date', [$currentMonthStart, $currentMonthEnd])
            ->orderBy('holiday_date', 'asc')
            ->get();
        // Pass counts to the view
        return view('admin.admin-dashboard', compact('employeeCount', 'customerCount', 'agentCount', 'ticketCount', 'groupCount', 'leadCount','total_todo','today_leave','tomorrow_leave','next_seven_days', 'pending_todo','upcomingHolidays'));
    }

    public function employeeDashboard()
    {
        return view('admin.employee-dashboard'); // Replace with your employee dashboard view
    }

    public function comingSoon(){
         return view('admin.coming-soon');
    }
}
