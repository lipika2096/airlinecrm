<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Get counts from the database
        $employeeCount = DB::table('employees')->count();
        $agentCount = DB::table('users')->where('role_id', 2)->count();
        $ticketCount = DB::table('air_tickets')->count();
        $groupCount = DB::table('groups')->count();
        $leadCount = DB::table('detail_leads')->count();

        // Pass counts to the view
        return view('admin.admin-dashboard', compact('employeeCount', 'agentCount', 'ticketCount', 'groupCount', 'leadCount'));
    }

    public function employeeDashboard()
    {
        return view('admin.employee-dashboard'); // Replace with your employee dashboard view
    }
}
