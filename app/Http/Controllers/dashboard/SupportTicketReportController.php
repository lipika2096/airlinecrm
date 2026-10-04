<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\TicketStatus;
use App\Models\Admin;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SupportTicketReportController extends Controller
{
    public function index()
    {
        $ticketStatuses = TicketStatus::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.reports.support-tickets', compact('ticketStatuses'))->with([
            'statusFilter' => null,
            'startDate' => null,
            'endDate' => null,
        ]);
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'status' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $ticketStatuses = TicketStatus::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $query = SupportTicket::with(['creator', 'assignedTo', 'ticketStatus']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $tickets = $query->orderBy('created_at', 'desc')->get();

        $statusFilter = $request->status;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return view('admin.reports.support-tickets', compact(
            'tickets',
            'ticketStatuses',
            'statusFilter',
            'startDate',
            'endDate'
        ));
    }

    public function downloadReport(Request $request)
    {
        $query = SupportTicket::with(['creator', 'assignedTo', 'ticketStatus']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $tickets = $query->orderBy('created_at', 'desc')->get();

        $fileName = 'support_tickets_report_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($tickets) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Ticket Number',
                'Subject',
                'Department',
                'Priority',
                'Status',
                'Created By',
                'Assigned To',
                'Company Name',
                'Booking Reference',
                'Created At',
                'Resolved At',
                'Closed At',
            ]);

            // Add data rows
            foreach ($tickets as $ticket) {
                fputcsv($file, [
                    $ticket->ticket_number,
                    $ticket->subject,
                    $ticket->department,
                    $ticket->priority,
                    $ticket->ticketStatus ? $ticket->ticketStatus->name : $ticket->status,
                    $ticket->creator_name,
                    $ticket->assignedTo ? ($ticket->assignedTo->name ?? $ticket->assignedTo->first_name . ' ' . $ticket->assignedTo->last_name) : 'Unassigned',
                    $ticket->company_name,
                    $ticket->booking_reference ?? 'N/A',
                    $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i:s') : 'N/A',
                    $ticket->resolved_at ? $ticket->resolved_at->format('Y-m-d H:i:s') : 'N/A',
                    $ticket->closed_at ? $ticket->closed_at->format('Y-m-d H:i:s') : 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
