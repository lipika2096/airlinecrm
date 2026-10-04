<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\TicketStatus;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SupportTicketsExport;

class ReportController extends Controller
{
    public function expenseReport()
    {
        // Add your logic for expense report view
        return view('admin.expense-reports'); // Example view path, adjust as per your structure
    }

    public function invoiceReport()
    {
        // Add your logic for invoice report view
        return view('admin.invoice-reports'); // Example view path, adjust as per your structure
    }

    public function paymentsReport()
    {
        // Add your logic for payments report view
        return view('admin.payments-reports'); // Example view path, adjust as per your structure
    }

    public function projectReport()
    {
        // Add your logic for project report view
        return view('admin.project-reports'); // Example view path, adjust as per your structure
    }

    public function taskReport()
    {
        // Add your logic for task report view
        return view('admin.task-reports'); // Example view path, adjust as per your structure
    }

    public function userReport()
    {
        // Add your logic for user report view
        return view('admin.user-reports'); // Example view path, adjust as per your structure
    }

    public function employeeReport()
    {
        // Add your logic for employee report view
        return view('admin.employee-reports'); // Example view path, adjust as per your structure
    }

    public function payslipReport()
    {
        // Add your logic for payslip report view
        return view('admin.payslip-reports'); // Example view path, adjust as per your structure
    }

    public function attendanceReport()
    {
        // Add your logic for attendance report view
        return view('admin.attendance-reports'); // Example view path, adjust as per your structure
    }

    public function leaveReport()
    {
        // Add your logic for leave report view
        return view('admin.leave-reports'); // Example view path, adjust as per your structure
    }

    public function dailyReport()
    {
        // Add your logic for daily report view
        return view('admin.daily-reports'); // Example view path, adjust as per your structure
    }

    /**
     * Support Tickets Report
     */
    public function supportTicketsReport(Request $request)
    {
        $query = SupportTicket::with(['creator', 'assignedTo', 'ticketStatus']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        $tickets = $query->latest()->get();
        $ticketStatuses = TicketStatus::all();

        return view('admin.reports.support-tickets', compact('tickets', 'ticketStatuses'));
    }

    /**
     * Download Support Tickets Report
     */
    public function downloadSupportTicketsReport(Request $request)
    {
        $query = SupportTicket::with(['creator', 'assignedTo', 'ticketStatus']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        $tickets = $query->latest()->get();

        return Excel::download(new SupportTicketsExport($tickets), 'support-tickets-report.xlsx');
    }

    // Add other methods as per your defined routes
}
