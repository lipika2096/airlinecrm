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
use App\Models\SupportTicket;
use App\Models\SupportTicketComment;
use App\Models\InternalNote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        if (auth()->check()) {
            // Staff user from users table
            $user = auth()->user();
            $isStaff = true;
            $isSuperAdmin = false;
        } elseif (auth('admin')->check()) {
            // Admin user from admins table
            $user = Auth::guard('admin')->user();
            $isSuperAdmin = $user->hasRole('SuperAdmin');
            $isStaff = false;
        } else {
            $user = Auth::user();
            $isSuperAdmin = false;
            $isStaff = false;
        }

        // If SuperAdmin, show the new SuperAdmin dashboard
        if ($isSuperAdmin) {
            return $this->superAdminDashboard();
        }

        // Get booking statistics for the current user
        $myBookings = DB::table('air_tickets')->where('created_by', $user->id)->count();
        
        // Get pending invoices count
        $pendingInvoices = 0;
        
        // Get outstanding amount
        $outstandingAmount =  0;

        // Get support ticket statistics for the current user
        $openTickets = SupportTicket::where('status', 'open')
            ->where(function($query) use ($user) {
                $query->where('created_by', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->count();
        
        $pendingTickets = SupportTicket::where('status', 'in_progress')
            ->where(function($query) use ($user) {
                $query->where('created_by', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->count();
        
        $closedTickets = SupportTicket::where('status', 'closed')
            ->where(function($query) use ($user) {
                $query->where('created_by', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->count();

        // Get recent tickets for the current user
        $recentTickets = SupportTicket::where(function($query) use ($user) {
                $query->where('created_by', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Pass data to the view
        return view('admin.admin-dashboard', compact(
            'myBookings',
            'pendingInvoices', 
            'outstandingAmount',
            'openTickets',
            'pendingTickets',
            'closedTickets',
            'recentTickets',
            'user'  ,
            'isSuperAdmin',
            'isStaff'
        ));
    }

    public function superAdminDashboard()
    {
        $user = auth('admin')->user();
        $isSuperAdmin = true;
        $isStaff = false;
        
        // Get ticket statistics for SuperAdmin dashboard
        $newTickets = SupportTicket::count();
        $openTickets = SupportTicket::where('status', 'open')->count();
        $pendingTickets = SupportTicket::where('status', 'in_progress')->count();
        
        // Calculate overdue tickets (tickets past SLA)
        $overdueTickets = SupportTicket::whereNotIn('status', ['resolved', 'closed'])
            ->where('created_at', '<', now()->subHours(24))
            ->count();
        
        $resolvedTickets = SupportTicket::where('status', 'resolved')->count();
        $closedTickets = SupportTicket::where('status', 'closed')->count();
        // Calculate average response time (in minutes)
        $avgFirstResponse = $this->calculateAverageFirstResponse();
        
        // Calculate average resolution time
        $avgResolutionTime = $this->calculateAverageResolutionTime();

        // Get data for Tickets Overview chart (last 7 days)
        $ticketsOverviewData = $this->getTicketsOverviewData();
        
        // Get data for Top Departments chart
        $topDepartmentsData = $this->getTopDepartmentsData();

        return view('admin.superadmin-dashboard', compact(
            'newTickets',
            'openTickets',
            'pendingTickets',
            'overdueTickets',
            'resolvedTickets',
            'closedTickets',
            'avgFirstResponse',
            'avgResolutionTime',
            'ticketsOverviewData',
            'topDepartmentsData',
            'user',
            'isSuperAdmin',
            'isStaff'
        ));
    }

    private function calculateAverageFirstResponse()
    {
        // Calculate average time between ticket creation and first comment
        $firstComments = SupportTicketComment::select('support_ticket_id', DB::raw('MIN(created_at) as first_comment_time'))
            ->groupBy('support_ticket_id')
            ->get();
        
        if ($firstComments->isEmpty()) {
            return '0m';
        }

        $totalResponseTime = 0;
        $count = 0;

        foreach ($firstComments as $comment) {
            $ticket = SupportTicket::find($comment->support_ticket_id);
            if ($ticket && $comment->first_comment_time) {
                $responseTime = $ticket->created_at->diffInMinutes($comment->first_comment_time);
                $totalResponseTime += $responseTime;
                $count++;
            }
        }

        if ($count === 0) {
            return '0m';
        }

        $avgMinutes = round($totalResponseTime / $count);
        return $avgMinutes . 'm';
    }

    private function calculateAverageResolutionTime()
    {
        // Calculate average time between ticket creation and resolution
        $resolvedTickets = SupportTicket::whereNotNull('resolved_at')
            ->where('status', 'resolved')
            ->get();
        
        if ($resolvedTickets->isEmpty()) {
            return '0h 0m';
        }

        $totalResolutionTime = 0;
        foreach ($resolvedTickets as $ticket) {
            $resolutionTime = $ticket->created_at->diffInMinutes($ticket->resolved_at);
            $totalResolutionTime += $resolutionTime;
        }

        $avgMinutes = round($totalResolutionTime / $resolvedTickets->count());
        $hours = floor($avgMinutes / 60);
        $minutes = $avgMinutes % 60;
        
        return $hours . 'h ' . $minutes . 'm';
    }

    private function getTicketsOverviewData()
    {
        // Get data for last 7 days
        $days = [];
        $newTicketsData = [];
        $resolvedTicketsData = [];
        $closedTicketsData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->format('d M');
            
            // Count new tickets created on this day
            $newTicketsData[] = SupportTicket::whereDate('created_at', $date->toDateString())->count();
            
            // Count resolved tickets on this day
            $resolvedTicketsData[] = SupportTicket::whereDate('resolved_at', $date->toDateString())
                ->where('status', 'resolved')
                ->count();
            
            // Count closed tickets on this day
            $closedTicketsData[] = SupportTicket::whereDate('closed_at', $date->toDateString())
                ->where('status', 'closed')
                ->count();
        }

        return [
            'labels' => $days,
            'new_tickets' => $newTicketsData,
            //'resolved_tickets' => $resolvedTicketsData,
            'closed_tickets' => $closedTicketsData
        ];
    }

    private function getTopDepartmentsData()
    {
        // Get ticket distribution by department
        $departments = SupportTicket::select('department', DB::raw('count(*) as total'))
            ->groupBy('department')
            ->orderByDesc('total')
            ->get();
        
        $labels = [];
        $data = [];
        
        foreach ($departments as $dept) {
            $labels[] = ucfirst(str_replace('_', ' ', $dept->department));
            $data[] = $dept->total;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    public function employeeDashboard()
    {
        return view('admin.employee-dashboard'); // Replace with your employee dashboard view
    }

    public function staffDashboard()
    {
        if (auth()->check()) {
            // Staff user from users table
            $user = auth()->user();
            $isStaff = true;
            $isSuperAdmin = false;
        } elseif (auth('admin')->check()) {
            // Admin user from admins table
            $user = Auth::guard('admin')->user();
            $isSuperAdmin = $user->hasRole('SuperAdmin');
            $isStaff = false;
        } else {
            $user = Auth::user();
            $isSuperAdmin = false;
            $isStaff = false;
        }

        // If SuperAdmin, show the new SuperAdmin dashboard
        if ($isSuperAdmin) {
            return $this->superAdminDashboard();
        }

        //dd($user);
        // Ensure user has a name field
        if (empty($user->name) && !empty($user->first_name) && !empty($user->last_name)) {
            $user->name = $user->first_name . ' ' . $user->last_name;
        }
        
        // Get basic statistics for staff dashboard
        $myBookings = DB::table('air_tickets')->where('created_by', $user->id)->count();
        
        // Get support ticket statistics for the current user
        $openTickets = SupportTicket::where('status', 'open')
            ->where(function($query) use ($user) {
                $query->where('created_by', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->count();
        
        $pendingTickets = SupportTicket::where('status', 'in_progress')
            ->where(function($query) use ($user) {
                $query->where('created_by', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->count();
        
        $closedTickets = SupportTicket::where('status', 'closed')
            ->where(function($query) use ($user) {
                $query->where('created_by', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->count();

        // Get recent tickets for the current user
        $recentTickets = SupportTicket::where(function($query) use ($user) {
                $query->where('created_by', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Pass data to the view
        return view('admin.admin-dashboard', compact(
            'myBookings',
            'openTickets',
            'pendingTickets',
            'closedTickets',
            'recentTickets',
            'user',
            'isSuperAdmin',
            'isStaff'

        ));
    }

    public function comingSoon(){
         return view('admin.coming-soon');
    }
}
