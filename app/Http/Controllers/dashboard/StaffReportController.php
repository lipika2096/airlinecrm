<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeLeave;
use App\Models\Holiday;
use App\Models\LeaveType;
use App\Models\ReportType;
use Carbon\Carbon;

class StaffReportController extends Controller
{
    public function index(Request $request)
{
    $leaveTypes = LeaveType::all();
    $ReportTypes = ReportType::all();
    $reportType = $request->input('report_type');
    $name = $request->input('name');
    $month = $request->input('month');
    $year = $request->input('year');

    $staffId = $request->input('staff_id');

    $dateRange = $request->input('date_range');
    if ($dateRange) {
        // Split the date range into from_date and to_date
        [$from_date, $to_date] = explode(' - ', $dateRange);

        // Assign the separated dates back to the request or use them as needed
        $request->merge([
            'from_date' => $from_date,
            'to_date' => $to_date,
        ]);
    }
    
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');

    $query = null;

    if ($reportType === 'Holidays') {
        $query = Holiday::query()
            ->select('*');

        if ($name) {
            $query->where('title', 'LIKE', "%$name%");
        }
        if ($month) {
            $query->whereMonth('holiday_date', $month);
        }
        if ($year) {
            $query->whereYear('holiday_date', $year);
        }
        if ($fromDate) {
            $query->whereDate('holiday_date', '>=', Carbon::parse($fromDate));
        }
        if ($toDate) {
            $query->whereDate('holiday_date', '<=', Carbon::parse($toDate));
        }
    } else {
        $query = EmployeeLeave::query()
            ->join('users', 'employee_leaves.employee_id', '=', 'users.id')
            ->join('clients', 'users.clientid', '=', 'clients.client_id')
            ->select('employee_leaves.*', 'users.*', 'clients.*');
    
        // Filter by report type
        if ($reportType === 'Pending Leaves Approval') {
            $query->where('employee_leaves.status', 2);
        } elseif ($reportType === 'On Leave') {
            $query->whereNotNull('employee_leaves.leave_type');
        } elseif ($reportType === 'Reported Sick') {
            $query->whereRaw('LOWER(employee_leaves.leave_type) = ?', ['sick']);
            // Filter by name within the context of the selected report type
            if ($name) {
                $query->where(function ($q) use ($name) {
                    $q->where('users.first_name', 'LIKE', '%' . $name . '%')
                      ->orWhere('users.last_name', 'LIKE', '%' . $name . '%');
                });
            }
        
            // Additional filters
            if ($month) {
                $query->whereMonth('employee_leaves.from', $month);
            }
            if ($year) {
                $query->whereYear('employee_leaves.from', $year);
            }
            if ($fromDate) {
                $query->whereDate('employee_leaves.from', '>=', Carbon::parse($fromDate));
            }
            if ($toDate) {
                $query->whereDate('employee_leaves.to', '<=', Carbon::parse($toDate));
            }
            if ($staffId) {
                $query->where('users.unique_id', $staffId);
            }
        } elseif ($reportType === 'On Business Trip') {
            $query->whereRaw('LOWER(employee_leaves.leave_type) = ?', ['business trip']);
        } elseif ($reportType === 'Overtime') {
            $query->addSelect([
                \DB::raw('GREATEST(0, (users.max_hrs - users.min_hrs)) as overtime')
            ]);
        }
    
        
    }

    $reports = $query ? $query->get() : collect(); // Get the results or return an empty collection

    return view('admin.staff-report', [
        'staffReports' => $reports,
        'reportType' => $reportType,
        'leaveTypes' => $leaveTypes, // Pass leave types to the view
        'ReportTypes' => $ReportTypes,
        'dateRange' => $dateRange 
    ]);
}

}
