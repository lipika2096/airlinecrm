<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportTicketComment;
use App\Models\Admin;
use App\Models\InternalNote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\TicketStatus;
use App\Models\AdminDetail;
use App\Models\Department;
use App\Helpers\RouteHelper;

class SupportTicketController extends Controller
{
    public function ticketDashboard(Request $request)
    {
        // Check if user is staff (users table) or admin (admins table)
        $user = auth()->check() ? auth()->user() : (auth('admin')->check() ? Auth::guard('admin')->user() : null);
        $isSuperAdmin = RouteHelper::isSuperAdmin();
        $isStaff = RouteHelper::isStaff();

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $superAdminId = $superAdmin ? $superAdmin->id : null;
        $isSuperAdminCreatedStaff = $superAdmin && $user && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
            $isStaff = false;
        }

        if (!$user) {
            return redirect()->route('admin.login');
        }

            $staffdepartments = \App\Models\UserDepartment::distinct()
                ->pluck('department_name')
                ->map(function($dept) {
                    return trim($dept);
                })
                ->filter()
                ->sort()
                ->values();

            // Get staff members based on user type
            if ($isSuperAdmin) {
                // Superadmin-created staff should see all active staff members
                $staffMembers = User::where('role_id', 2)->where('status', 'active')->whereNull('deleted_at')->get();
            } else {
                $staffMembers = User::where('role_id', 2)->where('status', 'active')->where('created_by', $user->id)->whereNull('deleted_at')->get();
            }


            $query = SupportTicket::with(['creator', 'assignedTo', 'relatedUser'])
                ->when($isStaff, function ($query) use ($user) {
                    // For staff users, show tickets assigned to them or created by them
                    // Do NOT show tickets created by the admin (customer) who created this staff member
                    return $query->where(function($q) use ($user) {
                        $q->where('assigned_to', $user->id)
                          ->orWhere('created_by', $user->id)
                          ->whereNotIn('created_by', function($query) use ($user) {
                              // Exclude tickets created by the admin (customer) who created this staff member
                              $query->select('admins.id')
                                  ->from('admins')
                                  ->where('admins.id', $user->created_by);
                          });
                    });
                })
                ->when(!$isSuperAdmin && !$isStaff, function ($query) use ($user, $superAdminId) {
                    // For non-SuperAdmin admin users (customers), show:
                    // 1. Tickets created by them
                    // 2. Tickets created by their staff members
                    // 3. Exclude tickets created by SuperAdmin or staff created by SuperAdmin
                    return $query->where(function($q) use ($user) {
                        $q->where('created_by', $user->id)
                          ->orWhereIn('created_by', function($query) use ($user) {
                              // Include tickets created by staff members created by this customer
                              $query->select('users.id')
                                  ->from('users')
                                  ->where('users.created_by', $user->id);
                          });
                    })->where(function($q) use ($superAdminId) {
                        // Exclude tickets created by SuperAdmin directly
                        $q->where('created_by', '!=', $superAdminId)
                          ->whereNotIn('created_by', function($query) use ($superAdminId) {
                              // Exclude tickets created by staff members who were created by SuperAdmin
                              $query->select('users.id')
                                  ->from('users')
                                  ->where('users.created_by', $superAdminId);
                          });
                    });
                });

            // SuperAdmin filters
            if ($isSuperAdmin) {
                // Tab filter for superadmin
                if ($request->has('tab') && !empty($request->tab)) {
                    $tab = $request->tab;
                    
                    switch($tab) {
                        case 'new':
                            $openStatusSlug = TicketStatus::where('name', 'Open')->first()?->slug ?? 'open';
                            $query->where('status', $openStatusSlug);
                            break;
                        case 'in_progress':
                            $inProgressStatusSlug = TicketStatus::where('name', 'In Progress')->first()?->slug ?? 'in_progress';
                            $query->where('status', $inProgressStatusSlug);
                            break;
                        case 'resolved':
                            $resolvedStatusSlug = TicketStatus::where('name', 'Resolved')->first()?->slug ?? 'resolved';
                            $query->where('status', $resolvedStatusSlug);
                            break;
                        case 'reopened':
                            $reopenedStatusSlug = TicketStatus::where('name', 'Reopened')->first()?->slug ?? 'reopened';
                            $query->where('status', $reopenedStatusSlug);
                            break;
                        case 'waiting_feedback':
                            $waitingFeedbackStatusSlug = TicketStatus::where('name', 'Waiting Feedback')->first()?->slug ?? 'waiting_feedback';
                            $query->where('status', $waitingFeedbackStatusSlug);
                            break;
                        case 'critical':
                            $query->where('priority', 'critical');
                            break;
                        case 'closed':
                            $closedStatusSlug = TicketStatus::where('name', 'Closed')->first()?->slug ?? 'closed';
                            $query->where('status', $closedStatusSlug);
                            break;
                        case 'unassigned':
                        $superAdminId = Admin::role('SuperAdmin')->first();

                            $query->where(function($q) use ($superAdminId) {
                                $q->whereNull('assigned_to');
                            });
                            break;
                        case 'all':
                        default:
                            // Show all tickets
                            break;
                    }
                }
                
                // Company filter - search by company_name in adminDetails
                if ($request->has('company') && !empty($request->company)) {
                    $query->whereHas('creator', function ($q) use ($request) {
                        $q->whereHas('adminDetail', function ($subQ) use ($request) {
                            $subQ->where('company_name', 'like', "%{$request->company}%");
                        });
                    });
                }
                
                // Department filter
                if ($request->has('department') && !empty($request->department)) {
                    $query->where('department', $request->department);
                }
                
                // Status filter
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('status', $request->status);
                }
                
                // Priority filter
                if ($request->has('priority') && !empty($request->priority)) {
                    $query->where('priority', $request->priority);
                }
                
                // Date range filter
                if ($request->has('date_from') && !empty($request->date_from)) {
                    $query->whereDate('created_at', '>=', $request->date_from);
                }
                if ($request->has('date_to') && !empty($request->date_to)) {
                    $query->whereDate('created_at', '<=', $request->date_to);
                }
                
                // Search filter
                if ($request->has('search') && !empty($request->search)) {
                    $searchTerm = $request->search;
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('ticket_number', 'like', "%{$searchTerm}%")
                        ->orWhere('subject', 'like', "%{$searchTerm}%")
                        ->orWhere('description', 'like', "%{$searchTerm}%");
                    });
                }
                
                // Pagination for superadmin
                $tickets = $query->latest()->paginate(10);
            } else {
                // Non-superadmin filters (includes staff and customers)
                // Apply status filter
                if ($request->has('status') && $request->status != 'all') {
                    // Get the resolved status slug
                    $resolvedStatusSlug = TicketStatus::where('name', 'Resolved')->first()?->slug ?? 'resolved';
                    
                    if ($request->status == 'closed') {
                        // For closed filter, include both closed and resolved statuses
                        $query->whereIn('status', ['closed', 'resolved']);
                    } else {
                        // For other statuses (like open, in_progress), filter normally
                        $query->where('status', $request->status);
                    }
                }

                // Apply search filter
                if ($request->has('search') && !empty($request->search)) {
                    $searchTerm = $request->search;
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('ticket_number', 'like', "%{$searchTerm}%")
                        ->orWhere('subject', 'like', "%{$searchTerm}%")
                        ->orWhere('description', 'like', "%{$searchTerm}%");
                    });
                }

                // Staff users get pagination, customers get all
                // if ($isStaff) {
                    $tickets = $query->latest()->paginate(10);
                // } else {
                //     $tickets = $query->latest()->get();
                // }
            }

            // Get filter options for superadmin
            $departments = \App\Models\UserDepartment::distinct()
                ->pluck('department_name')
                ->filter()
                ->sort()
                ->values()
                ->toArray();
            $priorities = ['low', 'medium', 'high', 'critical', 'urgent'];
            $statuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->pluck('slug')->toArray();
            
            // Get all ticket statuses for display (needed for both SuperAdmin and non-SuperAdmin)
            $allTicketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

            // For non-superadmin users, filter to show relevant statuses
            if (!$isSuperAdmin) {
                $ticketStatuses = $allTicketStatuses->filter(function($status) {
                    return in_array($status->slug, ['open', 'in_progress', 'closed']);
                });
            } else {
                $ticketStatuses = $allTicketStatuses;
            }

            // Get counts for non-superadmin users
            $counts = [];
            if (!$isSuperAdmin) {
                if ($isStaff) {
                    // For staff users, count tickets assigned to them or created by them
                    // Do NOT count tickets created by the admin (customer) who created this staff member
                    $userTickets = SupportTicket::where(function($q) use ($user) {
                        $q->where('assigned_to', $user->id)
                          ->orWhere('created_by', $user->id)
                          ->whereNotIn('created_by', function($query) use ($user) {
                              // Exclude tickets created by the admin (customer) who created this staff member
                              $query->select('admins.id')
                                  ->from('admins')
                                  ->where('admins.id', $user->created_by);
                          });
                    });
                } else {
                    // For customers, count tickets created by them or by their staff members
                    // Exclude tickets created by SuperAdmin or staff created by SuperAdmin
                    $userTickets = SupportTicket::where(function($q) use ($user) {
                        $q->where('created_by', $user->id)
                          ->orWhereIn('created_by', function($query) use ($user) {
                              // Include tickets created by staff members created by this customer
                              $query->select('users.id')
                                  ->from('users')
                                  ->where('users.created_by', $user->id);
                          });
                    })->where(function($q) use ($superAdmin) {
                        // Exclude tickets created by SuperAdmin directly
                        $q->where('created_by', '!=', $superAdmin->id)
                          ->whereNotIn('created_by', function($query) use ($superAdmin) {
                              // Exclude tickets created by staff members who were created by SuperAdmin
                              $query->select('users.id')
                                  ->from('users')
                                  ->where('users.created_by', $superAdmin->id);
                          });
                    });
                }

                $counts = [
                    'all' => $userTickets->count(),
                ];

                // Add counts for each status from database
                foreach($ticketStatuses as $status) {
                    // Count tickets by exact status
                    $counts[$status->slug] = (clone $userTickets)->where('status', $status->slug)->count();
                }
            } else {                            
                // For superadmin, count all tickets - use the same base query structure
                $allTickets = SupportTicket::with(['creator', 'assignedTo', 'relatedUser']);
                $counts = [
                    'all' => $allTickets->count(),
                ];
                
                // Get status slugs for counting
                $openStatusSlug = TicketStatus::where('name', 'Open')->first()?->slug ?? 'open';
                $inProgressStatusSlug = TicketStatus::where('name', 'In Progress')->first()?->slug ?? 'in_progress';
                $resolvedStatusSlug = TicketStatus::where('name', 'Resolved')->first()?->slug ?? 'resolved';
                $reopenedStatusSlug = TicketStatus::where('name', 'Reopened')->first()?->slug ?? 'reopened';
                $waitingFeedbackStatusSlug = TicketStatus::where('name', 'Waiting Feedback')->first()?->slug ?? 'waiting_feedback';
                $closedStatusSlug = TicketStatus::where('name', 'Closed')->first()?->slug ?? 'closed';
                
                // Add counts for each tab
                $counts['new'] = (clone $allTickets)->where('status', $openStatusSlug)->count();
                $counts['in_progress'] = (clone $allTickets)->where('status', $inProgressStatusSlug)->count();
                $counts['resolved'] = (clone $allTickets)->where('status', $resolvedStatusSlug)->count();
                $counts['reopened'] = (clone $allTickets)->where('status', $reopenedStatusSlug)->count();
                $counts['waiting_feedback'] = (clone $allTickets)->where('status', $waitingFeedbackStatusSlug)->count();
                $counts['critical'] = (clone $allTickets)->where('priority', 'critical')->count();
                $counts['closed'] = (clone $allTickets)->where('status', $closedStatusSlug)->count();
                $counts['unassigned'] = (clone $allTickets)->where(function($query) {
                    $query->whereNull('assigned_to');
                })->count();
                
                // Add counts for each status from database
                foreach($ticketStatuses as $status) {
                    $counts[$status->slug] = (clone $allTickets)->where('status', $status->slug)->count();
                }
            }
            
            // Get unique company names for filter dropdown
            $companies = AdminDetail::whereNotNull('company_name')
                ->where('company_name', '!=', '')
                ->get();
            return view('admin.support-tickets.index', compact('staffdepartments','staffMembers','tickets', 'isSuperAdmin', 'counts', 'departments', 'priorities', 'statuses', 'companies', 'ticketStatuses', 'isStaff', 'superAdminId'));
    }

    public function dashboardStatistics()
    {
        $user = auth()->check() ? auth()->user() : (auth('admin')->check() ? Auth::guard('admin')->user() : null);
        $isSuperAdmin = RouteHelper::isSuperAdmin();
        $isStaff = RouteHelper::isStaff();
        $isCustomer = RouteHelper::isCustomer();

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $superAdminId = $superAdmin ? $superAdmin->id : null;
        $isSuperAdminCreatedStaff = $superAdmin && $user && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
            $isStaff = false;
        }
            // Get status slugs from database
            $openStatusSlug = TicketStatus::where('name', 'Open')->first()?->slug ?? 'open';
            $inProgressStatusSlug = TicketStatus::where('name', 'In Progress')->first()?->slug ?? 'in_progress';
            $resolvedStatusSlug = TicketStatus::where('name', 'Resolved')->first()?->slug ?? 'resolved';
            $closedStatusSlug = TicketStatus::where('name', 'Closed')->first()?->slug ?? 'closed';

            // Get ticket statistics - show all tickets for SuperAdmin (including superadmin-created staff)
            if ($isSuperAdmin) {
                // SuperAdmin sees all tickets
                $newTickets = SupportTicket::count();
                $openTickets = SupportTicket::where('status', $openStatusSlug)->count();
                $pendingTickets = SupportTicket::where('status', $inProgressStatusSlug)->count();
                $overdueTickets = SupportTicket::whereNotIn('status', [$resolvedStatusSlug, $closedStatusSlug])
                    ->where('created_at', '<', now()->subHours(24))
                    ->count();
                $resolvedTickets = SupportTicket::where('status', $resolvedStatusSlug)->count();
                $closedTickets = SupportTicket::where('status', $closedStatusSlug)->count();
            } else {
                // Regular staff and customers see only their tickets based on user type
                if ($isStaff) {
                    // Staff: show tickets assigned to them or created by them
                    // Do NOT show tickets created by the admin (customer) who created this staff member
                    $baseQuery = SupportTicket::where(function($query) use ($user) {
                        $query->where('assigned_to', $user->id)
                          ->orWhere('created_by', $user->id)
                          ->whereNotIn('created_by', function($query) use ($user) {
                              // Exclude tickets created by the admin (customer) who created this staff member
                              $query->select('admins.id')
                                  ->from('admins')
                                  ->where('admins.id', $user->created_by);
                          });
                    });
                } else {
                    // Customer: show tickets created by them or by their staff members
                    // Exclude tickets created by SuperAdmin or staff created by SuperAdmin
                    $baseQuery = SupportTicket::where(function($q) use ($user) {
                        $q->where('created_by', $user->id)
                          ->orWhereIn('created_by', function($query) use ($user) {
                              // Include tickets created by staff members created by this customer
                              $query->select('users.id')
                                  ->from('users')
                                  ->where('users.created_by', $user->id);
                          });
                    })->where(function($q) use ($superAdmin) {
                        // Exclude tickets created by SuperAdmin directly
                        $q->where('created_by', '!=', $superAdmin->id)
                          ->whereNotIn('created_by', function($query) use ($superAdmin) {
                              // Exclude tickets created by staff members who were created by SuperAdmin
                              $query->select('users.id')
                                  ->from('users')
                                  ->where('users.created_by', $superAdmin->id);
                          });
                    });
                }

                $newTickets = (clone $baseQuery)->count();
                $openTickets = (clone $baseQuery)->where('status', $openStatusSlug)->count();
                $pendingTickets = (clone $baseQuery)->where('status', $inProgressStatusSlug)->count();
                $overdueTickets = (clone $baseQuery)->whereNotIn('status', [$resolvedStatusSlug, $closedStatusSlug])
                    ->where('created_at', '<', now()->subHours(24))
                    ->count();
                $resolvedTickets = (clone $baseQuery)->where('status', $resolvedStatusSlug)->count();
                $closedTickets = (clone $baseQuery)->where('status', $closedStatusSlug)->count();
            }
            // Calculate average response time (in minutes)
            $avgFirstResponse = $this->calculateAverageFirstResponse();
            
            // Calculate average resolution time
            $avgResolutionTime = $this->calculateAverageResolutionTime();

            // Get data for Tickets Overview chart (last 7 days)
            $ticketsOverviewData = $this->getTicketsOverviewData();
            
            // Get data for Top Departments chart
            $topDepartmentsData = $this->getTopDepartmentsData();

            // Get recent tickets for table view (latest 5)
            if ($isSuperAdmin) {
                // SuperAdmin sees all recent tickets
                $recentTickets = SupportTicket::with(['creator', 'assignedTo'])
                    ->latest()
                    ->limit(5)
                    ->get();
            } else {
                // Regular staff and customers see only their recent tickets based on user type
                if ($isStaff) {
                    // Staff: show tickets assigned to them or created by them
                    // Do NOT show tickets created by the admin (customer) who created this staff member
                    $recentTickets = SupportTicket::where(function($query) use ($user) {
                        $query->where('assigned_to', $user->id)
                          ->orWhere('created_by', $user->id)
                          ->whereNotIn('created_by', function($query) use ($user) {
                              // Exclude tickets created by the admin (customer) who created this staff member
                              $query->select('admins.id')
                                  ->from('admins')
                                  ->where('admins.id', $user->created_by);
                          });
                    })->with(['creator', 'assignedTo'])
                        ->latest()
                        ->limit(5)
                        ->get();
                } else {
                    // Customer: show tickets created by them or by their staff members
                    // Exclude tickets created by SuperAdmin or staff created by SuperAdmin
                    $recentTickets = SupportTicket::where(function($q) use ($user) {
                        $q->where('created_by', $user->id)
                          ->orWhereIn('created_by', function($query) use ($user) {
                              // Include tickets created by staff members created by this customer
                              $query->select('users.id')
                                  ->from('users')
                                  ->where('users.created_by', $user->id);
                          });
                    })->where(function($q) use ($superAdmin) {
                        // Exclude tickets created by SuperAdmin directly
                        $q->where('created_by', '!=', $superAdmin->id)
                          ->whereNotIn('created_by', function($query) use ($superAdmin) {
                              // Exclude tickets created by staff members who were created by SuperAdmin
                              $query->select('users.id')
                                  ->from('users')
                                  ->where('users.created_by', $superAdmin->id);
                          });
                    })->with(['creator', 'assignedTo'])
                        ->latest()
                        ->limit(5)
                        ->get();
                }
            }
            
            // Get all ticket statuses for display
            $ticketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

            return view('admin.support-tickets.dashboard', compact(
                'isSuperAdmin',
                'isStaff',
                'isCustomer',
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
                'recentTickets',
                'ticketStatuses'
            ));
    }

    public function index(Request $request)
    {
        // Check if user is staff (users table) or admin (admins table)
        $user = auth()->check() ? auth()->user() : (auth('admin')->check() ? Auth::guard('admin')->user() : null);
        $isSuperAdmin = RouteHelper::isSuperAdmin();
        $isStaff = RouteHelper::isStaff();

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $superAdminId = $superAdmin ? $superAdmin->id : null;
        $isSuperAdminCreatedStaff = $superAdmin && $user && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
            $isStaff = false;
        }

        if (!$user) {
            return redirect()->route('admin.login');
        }

        $query = SupportTicket::with(['creator', 'assignedTo', 'relatedUser'])
            ->when($isStaff, function ($query) use ($user) {
                // For staff users, show tickets assigned to them or created by them
                // Do NOT show tickets created by the admin (customer) who created this staff member
                return $query->where(function($q) use ($user) {
                    $q->where('assigned_to', $user->id)
                      ->orWhere('created_by', $user->id)
                      ->whereNotIn('created_by', function($query) use ($user) {
                          // Exclude tickets created by the admin (customer) who created this staff member
                          $query->select('admins.id')
                              ->from('admins')
                              ->where('admins.id', $user->created_by);
                      });
                });
            })
            ->when(!$isSuperAdmin && !$isStaff, function ($query) use ($user, $superAdminId) {
                // For non-SuperAdmin admin users (customers), show:
                // 1. Tickets created by them
                // 2. Tickets created by their staff members
                // 3. Exclude tickets created by SuperAdmin or staff created by SuperAdmin
                return $query->where(function($q) use ($user) {
                    $q->where('created_by', $user->id)
                      ->orWhereIn('created_by', function($query) use ($user) {
                          // Include tickets created by staff members created by this customer
                          $query->select('users.id')
                              ->from('users')
                              ->where('users.created_by', $user->id);
                      });
                })->where(function($q) use ($superAdminId) {
                    // Exclude tickets created by SuperAdmin directly
                    $q->where('created_by', '!=', $superAdminId)
                      ->whereNotIn('created_by', function($query) use ($superAdminId) {
                          // Exclude tickets created by staff members who were created by SuperAdmin
                          $query->select('users.id')
                              ->from('users')
                              ->where('users.created_by', $superAdminId);
                      });
                });
            });

        // SuperAdmin filters
        if ($isSuperAdmin) {
            // Tab filter for superadmin
            if ($request->has('tab') && !empty($request->tab)) {
                $tab = $request->tab;
                
                switch($tab) {
                    case 'new':
                        $openStatusSlug = TicketStatus::where('name', 'Open')->first()?->slug ?? 'open';
                        $query->where('status', $openStatusSlug);
                        break;
                    case 'in_progress':
                        $inProgressStatusSlug = TicketStatus::where('name', 'In Progress')->first()?->slug ?? 'in_progress';
                        $query->where('status', $inProgressStatusSlug);
                        break;
                    case 'resolved':
                        $resolvedStatusSlug = TicketStatus::where('name', 'Resolved')->first()?->slug ?? 'resolved';
                        $query->where('status', $resolvedStatusSlug);
                        break;
                    case 'reopened':
                        $reopenedStatusSlug = TicketStatus::where('name', 'Reopened')->first()?->slug ?? 'reopened';
                        $query->where('status', $reopenedStatusSlug);
                        break;
                    case 'waiting_feedback':
                        $waitingFeedbackStatusSlug = TicketStatus::where('name', 'Waiting Feedback')->first()?->slug ?? 'waiting_feedback';
                        $query->where('status', $waitingFeedbackStatusSlug);
                        break;
                    case 'critical':
                        $query->where('priority', 'critical');
                        break;
                    case 'closed':
                        $closedStatusSlug = TicketStatus::where('name', 'Closed')->first()?->slug ?? 'closed';
                        $query->where('status', $closedStatusSlug);
                        break;
                    case 'unassigned':
                        $query->where(function($q) use ($superAdminId) {
                            $q->whereNull('assigned_to');
                        });
                        break;
                    case 'all':
                    default:
                        // Show all tickets
                        break;
                }
            }
            
            // Company filter - search by company_name in adminDetails
            if ($request->has('company') && !empty($request->company)) {
                $query->whereHas('creator', function ($q) use ($request) {
                    $q->whereHas('adminDetail', function ($subQ) use ($request) {
                        $subQ->where('company_name', 'like', "%{$request->company}%");
                    });
                });
            }
            
            // Department filter
            if ($request->has('department') && !empty($request->department)) {
                $query->where('department', $request->department);
            }
            
            // Status filter
            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }
            
            // Priority filter
            if ($request->has('priority') && !empty($request->priority)) {
                $query->where('priority', $request->priority);
            }
            
            // Date range filter
            if ($request->has('date_from') && !empty($request->date_from)) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->has('date_to') && !empty($request->date_to)) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            // Search filter
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('ticket_number', 'like', "%{$searchTerm}%")
                      ->orWhere('subject', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%");
                });
            }
            
            // Pagination for superadmin
            $tickets = $query->latest()->paginate(10);
        } else {
            // Non-superadmin filters
            // Apply status filter
            if ($request->has('status') && $request->status != 'all') {
                // Get the resolved status slug
                $resolvedStatusSlug = TicketStatus::where('name', 'Resolved')->first()?->slug ?? 'resolved';
                
                if ($request->status == 'closed') {
                    // For closed filter, include both closed and resolved statuses
                    $query->whereIn('status', ['closed', $resolvedStatusSlug]);
                } elseif ($request->status == 'in_progress') {
                    // For in_progress filter, include both in_progress and resolved statuses
                    $query->whereIn('status', ['in_progress', $resolvedStatusSlug]);
                } else {
                    // For other statuses (like open), filter normally
                    $query->where('status', $request->status);
                }
            }

            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('ticket_number', 'like', "%{$searchTerm}%")
                      ->orWhere('subject', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%");
                });
            }

            $tickets = $query->latest()->paginate(10);
        }

        // Get counts for non-superadmin users
        $counts = [];
        if (!$isSuperAdmin) {
            $userTickets = SupportTicket::forUser($user->id);
            $counts = [
                'all' => $userTickets->count(),
                'open' => (clone $userTickets)->where('status', 'open')->count(),
                'pending' => (clone $userTickets)->where('status', 'in_progress')->count(),
                'closed' => (clone $userTickets)->whereIn('status', ['resolved', 'closed'])->count(),
            ];
        }

        // Get filter options for superadmin
        $departments = \App\Models\UserDepartment::distinct()
            ->pluck('department_name')
            ->map(function($dept) {
                return trim($dept);
            })
            ->filter()
            ->sort()
            ->values()
            ->toArray();
        $priorities = ['low', 'medium', 'high', 'critical', 'urgent']; // Common priorities, but text field allows custom values
        $statuses = ['open', 'in_progress', 'resolved', 'closed'];
        
        // Get unique company names for filter dropdown
        $companies = AdminDetail::whereNotNull('company_name')
            ->where('company_name', '!=', '')
            ->get();
        
        // Get all ticket statuses for display (needed for both SuperAdmin and non-SuperAdmin)
        $allTicketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

        // For non-superadmin users, filter to show only open, in_progress, and closed statuses
        if (!$isSuperAdmin) {
            $ticketStatuses = $allTicketStatuses->filter(function($status) {
                return in_array($status->slug, ['open', 'in_progress', 'closed']);
            });
        } else {
            $ticketStatuses = $allTicketStatuses;
        }

        // Get counts for non-superadmin users
        $counts = [];
        if (!$isSuperAdmin) {
            if ($isStaff) {
                // For staff users, count tickets assigned to them or created by them
                $userTickets = SupportTicket::where(function($q) use ($user) {
                    $q->where('assigned_to', $user->id)
                      ->orWhere('created_by', $user->id);
                });
            } else {
                // For customers, show tickets created by them or by their staff members
                // Exclude tickets created by SuperAdmin or staff created by SuperAdmin
                $superAdmin = Admin::role('SuperAdmin')->first();
                $userTickets = SupportTicket::where(function($q) use ($user) {
                    $q->where('created_by', $user->id)
                      ->orWhereIn('created_by', function($query) use ($user) {
                          // Include tickets created by staff members created by this customer
                          $query->select('users.id')
                              ->from('users')
                              ->where('users.created_by', $user->id);
                      });
                })->where(function($q) use ($superAdmin) {
                    // Exclude tickets created by SuperAdmin directly
                    $q->where('created_by', '!=', $superAdmin->id)
                      ->whereNotIn('created_by', function($query) use ($superAdmin) {
                          // Exclude tickets created by staff members who were created by SuperAdmin
                          $query->select('users.id')
                              ->from('users')
                              ->where('users.created_by', $superAdmin->id);
                      });
                });
            }
            
            $counts = [
                'all' => $userTickets->count(),
            ];
            
            // Get the resolved status slug
            $resolvedStatusSlug = TicketStatus::where('name', 'Resolved')->first()?->slug ?? 'resolved';
            
            // Add counts for each status from database
            foreach($ticketStatuses as $status) {
                if ($status->slug == 'in_progress') {
                    // For in_progress, include both in_progress and resolved statuses
                    $counts[$status->slug] = (clone $userTickets)
                        ->whereIn('status', ['in_progress', $resolvedStatusSlug])
                        ->count();
                } elseif ($status->slug == 'closed') {
                    // For closed, include both closed and resolved statuses
                    $counts[$status->slug] = (clone $userTickets)
                        ->whereIn('status', ['closed', $resolvedStatusSlug])
                        ->count();
                } else {
                    // For other statuses (like open), count normally
                    $counts[$status->slug] = (clone $userTickets)->where('status', $status->slug)->count();
                }
            }
        } else {
            // For superadmin, count all tickets - use the same base query structure
            $allTickets = SupportTicket::with(['creator', 'assignedTo', 'relatedUser']);
            $counts = [
                'all' => $allTickets->count(),
            ];
            
            // Get status slugs for counting
            $openStatusSlug = TicketStatus::where('name', 'Open')->first()?->slug ?? 'open';
            $inProgressStatusSlug = TicketStatus::where('name', 'In Progress')->first()?->slug ?? 'in_progress';
            $resolvedStatusSlug = TicketStatus::where('name', 'Resolved')->first()?->slug ?? 'resolved';
            $reopenedStatusSlug = TicketStatus::where('name', 'Reopened')->first()?->slug ?? 'reopened';
            $waitingFeedbackStatusSlug = TicketStatus::where('name', 'Waiting Feedback')->first()?->slug ?? 'waiting_feedback';
            $closedStatusSlug = TicketStatus::where('name', 'Closed')->first()?->slug ?? 'closed';
            
            // Add counts for each tab
            $counts['new'] = (clone $allTickets)->where('status', $openStatusSlug)->count();
            $counts['in_progress'] = (clone $allTickets)->where('status', $inProgressStatusSlug)->count();
            $counts['resolved'] = (clone $allTickets)->where('status', $resolvedStatusSlug)->count();
            $counts['reopened'] = (clone $allTickets)->where('status', $reopenedStatusSlug)->count();
            $counts['waiting_feedback'] = (clone $allTickets)->where('status', $waitingFeedbackStatusSlug)->count();
            $counts['critical'] = (clone $allTickets)->where('priority', 'critical')->count();
            $counts['closed'] = (clone $allTickets)->where('status', $closedStatusSlug)->count();
            $counts['unassigned'] = (clone $allTickets)->where(function($query) {
                $query->whereNull('assigned_to');
            })->count();
            
            // Add counts for each status from database
            foreach($ticketStatuses as $status) {
                $counts[$status->slug] = (clone $allTickets)->where('status', $status->slug)->count();
            }
        }

            $staffdepartments = \App\Models\UserDepartment::distinct()
                ->pluck('department_name')
                ->map(function($dept) {
                    return trim($dept);
                })
                ->filter()
                ->sort()
                ->values();

            // Get staff members based on user type
            if ($isSuperAdmin) {
                // Superadmin-created staff should see all active staff members
                $staffMembers = User::where('role_id', 2)->where('status', 'active')->whereNull('deleted_at')->get();
            } else {
                // Check if this staff user was created by superadmin
                $superAdmin = Admin::role('SuperAdmin')->first();
                $isSuperAdminCreatedStaff = $superAdmin && $user->created_by == $superAdmin->id;

                if ($isSuperAdminCreatedStaff) {
                    // Show both superadmin's staff and own created staff
                    $staffMembers = User::where('role_id', 2)
                        ->where('status', 'active')
                        ->whereNull('deleted_at')
                        ->where(function($query) use ($user, $superAdmin) {
                            $query->where('created_by', $superAdmin->id)
                                  ->orWhere('created_by', $user->id);
                        })
                        ->get();
                } else {
                    // Regular staff sees only their created staff
                    $staffMembers = User::where('role_id', 2)->where('status', 'active')->where('created_by', $user->id)->whereNull('deleted_at')->get();
                }
            }


        return view('admin.support-tickets.index', compact('staffdepartments','staffMembers','tickets', 'isSuperAdmin', 'isStaff', 'counts', 'departments', 'priorities', 'statuses', 'companies', 'ticketStatuses', 'superAdminId'));
    }

    public function create()
    {
        // Check if user is staff (users table) or admin (admins table)
        $user = auth()->check() ? auth()->user() : (auth('admin')->check() ? Auth::guard('admin')->user() : null);
        $isSuperAdmin = RouteHelper::isSuperAdmin();
        $isStaff = RouteHelper::isStaff();

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $superAdminId = $superAdmin ? $superAdmin->id : null;
        $isSuperAdminCreatedStaff = $superAdmin && $user && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
            $isStaff = false;
        }

        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Fetch staff members (role_id=2) for assignment
        $clients = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->latest()->get();
        
        // For SuperAdmin, get all staff users for assignment
        if (\App\Helpers\RouteHelper::isSuperAdmin()) {
            $company = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->latest()->get();
            // Superadmin-created staff should see all active staff members
            $staffMembers = User::where('role_id', 2)->where('status', 'active')->whereNull('deleted_at')->get();
        } elseif (\App\Helpers\RouteHelper::isStaff()) {
            $superAdminDetail = Admin::role('SuperAdmin')->first();
            if($user->created_by == $superAdminDetail->id){
                // For staff users, get all staff members for assignment
                $company = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'superAdmin');})->latest()->get();
                $staffMembers = User::where('role_id', 2)->where('status', 'active')->whereNull('deleted_at')
                ->where(function($query) use ($user, $superAdminDetail) {
                    $query->where('created_by', $user->id)
                          ->orWhere('created_by', $superAdminDetail->id);
                })->get();
            }
            else{
                $company = "";
                // For staff users, get all staff members for assignment
                $staffMembers = User::where('role_id', 2)->where('status', 'active')->where('created_by', $user->id)->whereNull('deleted_at')->get();
            }
        } else {
            $company = "";
            // For non-SuperAdmin, get staff created by current user
            $staffMembers = User::where('role_id', 2)->where('status', 'active')->where('created_by', $user->id)->whereNull('deleted_at')->get();
        }
        
        return view('admin.support-tickets.create', compact('company','staffMembers', 'clients', 'isStaff', 'isSuperAdmin'));
    }

    public function store(Request $request)
    {
        // Check if user is staff (users table) or admin (admins table)
        $currentUser = auth()->check() ? auth()->user() : (auth('admin')->check() ? Auth::guard('admin')->user() : null);
        $isSuperAdmin = RouteHelper::isSuperAdmin();
        $isStaff = RouteHelper::isStaff();

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $isSuperAdminCreatedStaff = $superAdmin && $currentUser && $currentUser->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
            $isStaff = false;
        }

        if (!$currentUser) {
            return redirect()->route('admin.login');
        }

        // Build validation rules dynamically based on user type
        $validationRules = [
            'department' => 'required|string|in:technical_support,billing,booking,account,other',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'nullable|string|max:255',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip', // Max 5MB per file
            'attachment_names' => 'nullable|array',
            'booking_reference' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|integer',
            'related_user_id' => 'nullable|integer',
        ];

        // Add company name validation for super admin
        if ($isSuperAdmin) {
            $validationRules['company_name'] = 'required|string|max:255';
        }

        $request->validate($validationRules);

        // Convert empty string to null for assigned_to
        if ($request->assigned_to === '' || $request->assigned_to === null) {
            $request->merge(['assigned_to' => null]);
        }

        // Generate temporary ticket number (will be updated after creation)
        $ticketNumber = 'TEMP-' . strtoupper(Str::random(6));

        // Assign the ticket to the specified user or default to SuperAdmin for staff
        // if ($isStaff) {
        //     // For regular staff users, default to SuperAdmin
        //     $superAdmin = Admin::role('SuperAdmin')->first();
        //     $assignedTo = $superAdmin ? $superAdmin->id : null;
        // } else {
            // For admin users (including superadmin-created staff), use the specified assignment or leave unassigned
            $assignedTo = $request->assigned_to;
        //}

        // Handle file attachments - handle both single and multiple files
        $attachmentPaths = [];
        
        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            $customNames = $request->input('attachment_names', []);
            // Convert to array if it's a single file
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $index => $file) {
                if ($file && $file->isValid()) {
                    try {
                        $originalName = $file->getClientOriginalName();
                        $customName = isset($customNames[$index]) && !empty($customNames[$index]) 
                            ? $customNames[$index] . '.' . $file->getClientOriginalExtension()
                            : $originalName;
                        
                        $path = $file->storeAs('support-ticket-attachments', $customName, 'public');
                        $attachmentPaths[] = [
                            'path' => $path,
                            'original_name' => $customName
                        ];
                    } catch (\Exception $e) {
                        \Log::error('File storage failed', ['error' => $e->getMessage()]);
                    }
                }
            }
        }

        // Get company name based on user type
        $companyName = null;
        if ($isSuperAdmin) {
            // For super admin, use the provided company name from the form
            $companyName = $request->company_name;
        } elseif (!$isStaff && $currentUser instanceof \App\Models\Admin && $currentUser->adminDetail) {
            // For non-super admin users, use their admin detail company name
            $companyName = $currentUser->adminDetail->company_name;
        }

        // Determine created_by_type
        $createdByType = null;
        if ($isSuperAdmin) {
            $createdByType = 'superadmin';
        } elseif ($isStaff) {
            $createdByType = 'staff';
        } else {
            $createdByType = 'customer';
        }

        // Get assigned_to_name if assigned
        $assignedToName = null;
        if ($assignedTo) {
            $assignedAdmin = Admin::find($assignedTo);
            if ($assignedAdmin && $assignedAdmin->hasRole('SuperAdmin')) {
                $assignedToName = 'Super Admin';
            } else {
                $assignedUser = User::find($assignedTo);
                if ($assignedUser) {
                    $assignedToName = $assignedUser->first_name . ' ' . $assignedUser->last_name;
                }
            }
        }

        $ticket = SupportTicket::create([
            'ticket_number' => $ticketNumber,
            'department' => $request->department,
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority ?? 'medium',
            'status' => 'open',
            'created_by' => $currentUser->id,
            'created_by_type' => $createdByType,
            'assigned_to' => $assignedTo,
            'assigned_to_name' => $assignedToName,
            'related_user_id' => $request->related_user_id,
            'booking_reference' => $request->booking_reference,
            'attachments' => json_encode($attachmentPaths),
            'company_name' => $companyName,
        ]);

        // Generate ticket number using ticket ID
        $ticketNumber = $ticket->id . '-' . strtoupper(Str::random(6));
        $ticket->ticket_number = $ticketNumber;
        $ticket->save();

        // Notify assigned staff if ticket is assigned
        if ($assignedTo) {
            $this->createNotification(
                $assignedTo,
                'staff',
                'ticket_created',
                'New Ticket Assigned',
                "You have been assigned to new ticket #{$ticketNumber}",
                $ticket->id,
                ['subject' => $request->subject, 'priority' => $request->priority ?? 'medium']
            );
        }

        // Notify SuperAdmin if ticket is created by staff or customer
        if ($isStaff || (!$isSuperAdmin && !$isStaff)) {
            $superAdmin = Admin::role('SuperAdmin')->first();
            if ($superAdmin) {
                $this->createNotification(
                    $superAdmin->id,
                    'admin',
                    'ticket_created',
                    'New Support Ticket Created',
                    "New ticket #{$ticketNumber} has been created",
                    $ticket->id,
                    ['subject' => $request->subject, 'priority' => $request->priority ?? 'medium']
                );
            }
        }

        if(\App\Helpers\RouteHelper::isSuperAdmin()) {
            return redirect()->route('admin.support-tickets.index')
                ->with('success', 'Support ticket created successfully.');
        } elseif(\App\Helpers\RouteHelper::isStaff()) {
            return redirect()->route('staff.support-tickets.dashboard')
                ->with('success', 'Support ticket created successfully.');
        }
        else {
            return redirect()->route('customer.support-tickets.dashboard')
                ->with('success', 'Support ticket created successfully.');
        }
    }

    public function show($id)
    {
        $user = auth()->check() ? auth()->user() : (auth('admin')->check() ? Auth::guard('admin')->user() : null);
        $isSuperAdmin = RouteHelper::isSuperAdmin();
        $isStaff = RouteHelper::isStaff();

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $superAdminId = $superAdmin ? $superAdmin->id : null;
        $isSuperAdminCreatedStaff = $superAdmin && $user && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
            $isStaff = false;
        }

        if (!$user) {
            return redirect()->route('admin.login');
        }

        $ticket = SupportTicket::with(['creator', 'assignedTo', 'relatedUser', 'comments.user', 'internalNotes.user'])
            ->when($isStaff, function ($query) use ($user) {
                // For staff users, show tickets assigned to them or created by them
                // Do NOT show tickets created by the admin (customer) who created this staff member
                return $query->where(function($q) use ($user) {
                    $q->where('assigned_to', $user->id)
                      ->orWhere('created_by', $user->id)
                      ->whereNotIn('created_by', function($query) use ($user) {
                          // Exclude tickets created by the admin (customer) who created this staff member
                          $query->select('admins.id')
                              ->from('admins')
                              ->where('admins.id', $user->created_by);
                      });
                });
            })
            ->when(!$isSuperAdmin && !$isStaff, function ($query) use ($user, $superAdminId) {
                // For non-SuperAdmin admin users (customers), show:
                // 1. Tickets created by them
                // 2. Tickets created by their staff members
                // 3. Exclude tickets created by SuperAdmin or staff created by SuperAdmin
                return $query->where(function($q) use ($user) {
                    $q->where('created_by', $user->id)
                      ->orWhereIn('created_by', function($query) use ($user) {
                          // Include tickets created by staff members created by this customer
                          $query->select('users.id')
                              ->from('users')
                              ->where('users.created_by', $user->id);
                      });
                })->where(function($q) use ($superAdminId) {
                    // Exclude tickets created by SuperAdmin directly
                    $q->where('created_by', '!=', $superAdminId)
                      ->whereNotIn('created_by', function($query) use ($superAdminId) {
                          // Exclude tickets created by staff members who were created by SuperAdmin
                          $query->select('users.id')
                              ->from('users')
                              ->where('users.created_by', $superAdminId);
                      });
                });
            })
            ->findOrFail($id);

        $comments = $ticket->comments()->get();
        $internalNotes = $ticket->internalNotes()->latest()->get();

        // Merge final comment with regular comments for chronological display
        $allComments = collect();
        
        // Add regular comments
        foreach ($comments as $comment) {
            $allComments->push([
                'type' => 'regular',
                'data' => $comment,
                'created_at' => $comment->created_at,
            ]);
        }
        
        // Add final comment if it exists and has a closed_at timestamp
        if ($ticket->final_comment && $ticket->closed_at) {
            $allComments->push([
                'type' => 'final',
                'data' => $ticket,
                'created_at' => $ticket->closed_at,
            ]);
        }
        
        // Sort all comments by created_at
        $allComments = $allComments->sortBy('created_at')->values();

        // Get staff members for assignment dropdown
        if ($isSuperAdmin) {
            $staffMembers = User::where('role_id', 2)->where('status', 'active')->whereNull('deleted_at')->get();
        } else {
            // Check if this staff user was created by superadmin
            $superAdmin = Admin::role('SuperAdmin')->first();
            $isSuperAdminCreatedStaff = $superAdmin && $user->created_by == $superAdmin->id;

            if ($isSuperAdminCreatedStaff) {
                // Show both superadmin's staff and own created staff
                $staffMembers = User::where('role_id', 2)
                    ->where('status', 'active')
                    ->whereNull('deleted_at')
                    ->where(function($query) use ($user, $superAdmin) {
                        $query->where('created_by', $superAdmin->id)
                              ->orWhere('created_by', $user->id);
                    })
                    ->get();
            } else {
                // Regular staff sees only their created staff
                $staffMembers = User::where('role_id', 2)->where('status', 'active')->where('created_by', $user->id)->whereNull('deleted_at')->get();
            }
        }

        // Calculate SLA due time (based on priority)
        $slaHours = 6; // default
        switch($ticket->priority) {
            case 'critical':
                $slaHours = 2;
                break;
            case 'high':
                $slaHours = 4;
                break;
            case 'medium':
                $slaHours = 8;
                break;
            case 'low':
                $slaHours = 24;
                break;
        }
        $slaDue = $ticket->created_at->copy()->addHours($slaHours);
        $isOverdue = $slaDue->isPast() && !in_array($ticket->status, ['resolved', 'closed']);
        $departments = \App\Models\UserDepartment::distinct()
            ->pluck('department_name')
            ->map(function($dept) {
                return trim($dept);
            })
            ->filter()
            ->sort()
            ->values();

        // Check if user can rate (ticket creator and ticket is closed)
        $canRate = !$isSuperAdmin && $ticket->status === 'closed' && $ticket->created_by === $user->id && !$ticket->rating;

        // Check if currently assigned staff is deleted
        $isAssignedStaffDeleted = false;
        if ($ticket->assigned_to && $ticket->assignedTo) {
            $assignedStaff = User::find($ticket->assigned_to);
            $isAssignedStaffDeleted = !$assignedStaff || $assignedStaff->deleted_at !== null;
        }

        // Get active tab from session or default to details
        $activeTab = session('active_tab', 'details');

        // Get available ticket statuses
        $ticketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

        // Get unique company names for SuperAdmin dropdown
        $companies = AdminDetail::whereNotNull('company_name')
            ->where('company_name', '!=', '')
            ->get();

        return view('admin.support-tickets.show', compact('ticket', 'comments', 'allComments', 'internalNotes', 'isSuperAdmin', 'isStaff', 'staffMembers', 'slaDue', 'isOverdue', 'canRate', 'activeTab', 'ticketStatuses', 'departments', 'companies', 'isAssignedStaffDeleted'));
    }

    public function myCreatedTickets(Request $request)
    {
        $user = auth()->user();
        $isStaff = true;
        $isSuperAdmin = false;

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $isSuperAdminCreatedStaff = $superAdmin && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
            $isStaff = false;
        }

        $query = SupportTicket::with(['creator', 'assignedTo', 'relatedUser'])
            ->where('created_by', $user->id);

        // Apply filters
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('ticket_number', 'like', "%{$searchTerm}%")
                  ->orWhere('subject', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $tickets = $query->latest()->paginate(10);

        // Get ticket statuses
        $ticketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.support-tickets.my-created', compact('tickets', 'isSuperAdmin', 'isStaff', 'ticketStatuses'));
    }

    public function assignedTickets(Request $request)
    {
        $user = auth()->user();
        $isStaff = true;
        $isSuperAdmin = false;

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $isSuperAdminCreatedStaff = $superAdmin && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
            $isStaff = false;
        }

        $query = SupportTicket::with(['creator', 'assignedTo', 'relatedUser'])
            ->where('assigned_to', $user->id);

        // Apply filters
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('ticket_number', 'like', "%{$searchTerm}%")
                  ->orWhere('subject', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $tickets = $query->latest()->paginate(10);

        // Get ticket statuses
        $ticketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.support-tickets.assigned', compact('tickets', 'isSuperAdmin', 'isStaff', 'ticketStatuses'));
    }

    public function unassignedTickets(Request $request)
    {
        $user = auth()->user();
        $isStaff = true;
        $isSuperAdmin = false;

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $isSuperAdminCreatedStaff = $superAdmin && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
            $isStaff = false;
        }

        $query = SupportTicket::with(['creator', 'assignedTo', 'relatedUser'])
            ->where(function($q) use ($superAdmin) {
                $q->whereNull('assigned_to')
                  ->orWhere('assigned_to', $superAdmin->id);
            });

        // Apply filters
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('ticket_number', 'like', "%{$searchTerm}%")
                  ->orWhere('subject', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $tickets = $query->latest()->paginate(10);

        // Get ticket statuses
        $ticketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.support-tickets.unassigned', compact('tickets', 'isSuperAdmin', 'isStaff', 'ticketStatuses'));
    }

    public function getStaffByDepartment(Request $request)
    {
        $departmentName = $request->input('department_id');

        // Debug logging
        \Log::info('getStaffByDepartment called with department: ' . $departmentName);

        // Check if department name is provided
        if (empty($departmentName)) {
            return response()->json([
                'staff' => []
            ]);
        }

        // Check if current user is a customer
        $isCustomer = RouteHelper::isCustomer();
        $currentUserId = auth('admin')->user()?->id;

        // Build query for staff members (role_id=2) who have this department in their user_departments
        // Also filter out deleted staff and only show active staff
        $query = User::where('role_id', 2)
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->whereHas('userDepartments', function($query) use ($departmentName) {
                $query->where('department_name', $departmentName);
            });

        // If customer, filter to only show staff created by this customer
        if ($isCustomer && $currentUserId) {
            $query->where('created_by', $currentUserId);
            \Log::info('Filtering staff for customer ID: ' . $currentUserId);
        }

        $staff = $query->get();

        \Log::info('Found staff count: ' . $staff->count());

        return response()->json([
            'staff' => $staff
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        //dd($request->category);
        // Determine user type and permissions
        $isStaff = RouteHelper::isStaff();
        $isSuperAdmin = RouteHelper::isSuperAdmin();
        $isCustomer = RouteHelper::isCustomer();

        // Check if staff user was created by superadmin
        $isSuperAdminCreatedStaff = false;
        if (\App\Helpers\RouteHelper::isStaff()) {
            $superAdmin = Admin::role('SuperAdmin')->first();
            $isSuperAdminCreatedStaff = $superAdmin && auth()->user()->created_by == $superAdmin->id;

            // If staff was created by superadmin, give them superadmin privileges
            if ($isSuperAdminCreatedStaff) {
                $isSuperAdmin = true;
                // Keep $isStaff as true to ensure correct user ID retrieval
            }
        }

        // Get user ID - always use auth() for staff (including superadmin-created staff)
        // and auth('admin') for actual admins
        if (auth()->check()) {
            $userId = auth()->user()->id;
        } elseif (auth('admin')->check()) {
            $userId = auth('admin')->user()->id;
        } else {
            $userId = null;
        }
        
        // Get available statuses from database
        $availableStatuses = TicketStatus::where('is_active', true)->pluck('slug')->toArray();
        
        // Build validation rules dynamically
        $validationRules = [
            'status' => 'nullable|in:' . implode(',', $availableStatuses),
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'category' => 'nullable|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'rating_comment' => 'nullable|string|max:1000',
        ];

        // Only require final_comment if it's not an AJAX request (i.e., form submission)
        if (!$request->ajax() && !$request->wantsJson()) {
            $validationRules['final_comment'] = 'required_if:status,closed|string|max:1000';
        } else {
            $validationRules['final_comment'] = 'nullable|string|max:1000';
        }

        $request->validate($validationRules);

        $ticket = SupportTicket::findOrFail($id);
        
        // Check if staff user has permission to update this ticket
        if ($isStaff && !$isSuperAdminCreatedStaff) {
            // Regular staff can only update tickets assigned to them or created by them
            if ($ticket->assigned_to != $userId && $ticket->created_by != $userId) {
                return redirect()->back()
                    ->with('error', 'You do not have permission to update this ticket.');
            }
        }
        // Superadmin-created staff (now treated as superadmin) can update any ticket
        
        // Customers can transfer tickets (assign staff) but cannot change status directly
        if (\App\Helpers\RouteHelper::isCustomer()) {
            // Allow customers to assign/transfer tickets but not change status
            if ($request->has('status') && $request->status !== $ticket->status) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You do not have permission to update ticket status.'
                    ], 403);
                }
                return redirect()->back()
                    ->with('error', 'You do not have permission to update ticket status.');
            }
            // Allow assignment/transfer for customers
            // Additional check: customer can only transfer to their own staff
            if ($request->has('assigned_to') && $request->assigned_to) {
                $staffUser = User::find($request->assigned_to);
                if (!$staffUser || $staffUser->created_by != $userId) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You can only transfer tickets to your own staff members.'
                        ], 403);
                    }
                    return redirect()->back()
                        ->with('error', 'You can only transfer tickets to your own staff members.');
                }
            }
        }

        // Prevent closing unassigned tickets
        if ($request->status === 'closed' && !$ticket->assigned_to) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot close unassigned tickets. Please assign the ticket to a staff member first.'
                ], 422);
            }
            return redirect()->back()
                ->with('error', 'Cannot close unassigned tickets. Please assign the ticket to a staff member first.');
        }

        // Prevent resolving unassigned tickets
        if ($request->status === 'resolved' && !$ticket->assigned_to) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot resolve unassigned tickets. Please assign the ticket to a staff member first.'
                ], 422);
            }
            return redirect()->back()
                ->with('error', 'Cannot resolve unassigned tickets. Please assign the ticket to a staff member first.');
        }

        $oldStatus = $ticket->status;
        $ticket->status = $request->status ?? $ticket->status;

        if ($request->has('assigned_to')) {
            $ticket->assigned_to = $request->assigned_to;

            // Only automatically set department based on assigned staff if:
            // 1. Department is not explicitly provided AND
            // 2. Category is not being set (to avoid conflicts during transfer operations)
            if ($request->assigned_to && !$request->has('department') && !$request->has('category')) {
                $assignedStaff = \App\Models\User::whereNull('deleted_at')->where('id',$request->assigned_to);
                if ($assignedStaff && !empty($assignedStaff->department)) {
                    $ticket->department = $assignedStaff->department[0];
                }
            }
        }

        // Update priority if provided
        if ($request->has('priority') && $request->priority !== '') {
            $ticket->priority = $request->priority;
        }

        // Update category if provided (this is the support ticket category)
        if ($request->has('category') && $request->category !== '') {
            $ticket->department = $request->category;
        }
        else{
            $ticket->department = $ticket->department;
        }
        // Update department if provided (this is the staff department)
        if ($request->has('department') && $request->department !== '') {
            // Note: department and category both use the same field in database
            // Category takes precedence for support ticket classification
            if (!$request->has('category') || $request->category === '') {
                
                $ticket->department = $ticket->department;
            }
                        //dd($ticket->department);

        }

        // Handle status changes and timestamps
        // Automatically change status from on_hold to reopened when any status change occurs (except to on_hold)
        if (in_array(strtolower($oldStatus), ['on_hold', 'onhold']) && 
            $request->status && 
            !in_array(strtolower($request->status), ['on_hold', 'onhold'])) {
            $reopenedStatus = TicketStatus::where('name', 'Reopened')->first();
            $reopenedStatusSlug = $reopenedStatus ? $reopenedStatus->slug : 'reopened';
            $ticket->status = $reopenedStatusSlug;
            
            // Log the status change for audit purposes
            \Log::info('Ticket status automatically changed from on_hold to reopened', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'previous_status' => $oldStatus,
                'requested_status' => $request->status,
                'new_status' => $reopenedStatusSlug,
                'triggered_by' => 'manual_status_update',
                'user_id' => $userId
            ]);
        }
        
        if ($request->status === 'resolved') {
            $ticket->resolved_at = now();
            // Save who resolved the ticket
            $ticket->resolved_by = $userId;
        } elseif ($request->status === 'closed') {
            $ticket->closed_at = now();
            if (!$ticket->resolved_at) {
                $ticket->resolved_at = now();
            }
            // Save who resolved the ticket if not already set
            if (!$ticket->resolved_by) {
                $ticket->resolved_by = $userId;
            }
            // Save final comment when closing ticket
            if ($request->has('final_comment')) {
                $ticket->final_comment = $request->final_comment;
            }
            // Save rating and feedback when closing ticket
            if ($request->has('rating')) {
                $ticket->rating = $request->rating;
            }
            if ($request->has('rating_comment')) {
                $ticket->rating_comment = $request->rating_comment;
            }
            // Save who closed the ticket
            $ticket->closed_by = $userId;
        } elseif ($oldStatus === 'closed' && $request->status === 'open') {
            // Reopening ticket - clear timestamps and rating only
            // Keep final_comment, closed_by, and resolved_by for historical records
            $ticket->resolved_at = null;
            $ticket->closed_at = null;
            $ticket->rating = null;
            $ticket->rating_comment = null;
            // Don't clear final_comment, closed_by, resolved_by - preserve them for history
        } elseif ($oldStatus === 'resolved' && $request->status === 'open') {
            // Reopening from resolved - clear timestamp but keep resolved_by for history
            $ticket->resolved_at = null;
            // Don't clear resolved_by - preserve it for historical records
        }

        $ticket->save();

        // Notify ticket creator about status change
        if ($oldStatus != $ticket->status && $ticket->created_by != $userId) {
            $creatorType = \App\Models\Admin::find($ticket->created_by) ? 'admin' : 'staff';
            $this->createNotification(
                $ticket->created_by,
                $creatorType,
                'status_update',
                'Ticket Status Updated',
                "Ticket #{$ticket->ticket_number} status changed from {$oldStatus} to {$ticket->status}",
                $ticket->id,
                ['old_status' => $oldStatus, 'new_status' => $ticket->status]
            );
        }

        // Notify assigned staff about status change
        if ($oldStatus != $ticket->status && $ticket->assigned_to && $ticket->assigned_to != $userId) {
            $this->createNotification(
                $ticket->assigned_to,
                'staff',
                'status_update',
                'Ticket Status Updated',
                "Ticket #{$ticket->ticket_number} status changed from {$oldStatus} to {$ticket->status}",
                $ticket->id,
                ['old_status' => $oldStatus, 'new_status' => $ticket->status]
            );
        }

        // Return JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ticket updated successfully.',
                'ticket' => $ticket
            ]);
        }

        return redirect()->back()
            ->with('success', 'Ticket updated successfully.')
            ->with('active_tab', $request->get('active_tab', 'details'));
    }

    private function createNotification($userId, $userType, $type, $title, $message, $supportTicketId, $data = null)
    {
        \App\Models\Notification::create([
            'user_id' => $userId,
            'user_type' => $userType,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'support_ticket_id' => $supportTicketId,
            'is_read' => false,
        ]);
    }

    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip',
            'attachment_names' => 'nullable|array',
        ]);

        $ticket = SupportTicket::findOrFail($id);

        // Get current user ID based on authentication guard
        if (auth()->check()) {
            // Staff user from users table
            $userId = auth()->id();
        } elseif (auth('admin')->check()) {
            // Admin user from admins table
            $userId = Auth::guard('admin')->id();
        } else {
            return redirect()->back()->with('error', 'Authentication required.');
        }

        // Handle file attachments for comments
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            $customNames = $request->input('attachment_names', []);
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $index => $file) {
                if ($file && $file->isValid()) {
                    try {
                        $originalName = $file->getClientOriginalName();
                        $customName = isset($customNames[$index]) && !empty($customNames[$index]) 
                            ? $customNames[$index] . '.' . $file->getClientOriginalExtension()
                            : $originalName;
                        
                        $path = $file->storeAs('support-ticket-attachments', $customName, 'public');
                        $attachmentPaths[] = [
                            'path' => $path,
                            'original_name' => $customName
                        ];
                    } catch (\Exception $e) {
                        \Log::error('File storage failed', ['error' => $e->getMessage()]);
                    }
                }
            }
        }

        SupportTicketComment::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $userId,
            'comment' => $request->comment,
            'attachments' => json_encode($attachmentPaths),
            'commented_by' => $request->commented_by
        ]);

        // Get current user type
        $currentUserType = RouteHelper::isStaff() ? 'staff' : (RouteHelper::isSuperAdmin() ? 'superadmin' : 'customer');

        // Get SuperAdmin
        $superAdmin = Admin::role('SuperAdmin')->first();

        // Determine who to notify based on who commented
        if ($currentUserType === 'staff') {
            // If staff commented, notify ticket creator and superadmin
            if ($ticket->created_by != $userId) {
                $creatorType = \App\Models\Admin::find($ticket->created_by) ? 'admin' : 'staff';
                $this->createNotification(
                    $ticket->created_by,
                    $creatorType,
                    'comment',
                    'New Comment on Ticket',
                    "A new comment has been added to ticket #{$ticket->ticket_number}",
                    $ticket->id,
                    ['comment' => substr($request->comment, 0, 100)]
                );
            }

            // Notify superadmin if exists and not the commenter
            if ($superAdmin && $superAdmin->id != $userId) {
                $this->createNotification(
                    $superAdmin->id,
                    'admin',
                    'comment',
                    'New Comment on Ticket',
                    "A new comment has been added to ticket #{$ticket->ticket_number}",
                    $ticket->id,
                    ['comment' => substr($request->comment, 0, 100)]
                );
            }
        } elseif ($currentUserType === 'superadmin' || $currentUserType === 'customer') {
            // If superadmin or customer commented, notify assigned staff
            if ($ticket->assigned_to && $ticket->assigned_to != $userId) {
                $this->createNotification(
                    $ticket->assigned_to,
                    'staff',
                    'comment',
                    'New Comment on Assigned Ticket',
                    "A new comment has been added to ticket #{$ticket->ticket_number}",
                    $ticket->id,
                    ['comment' => substr($request->comment, 0, 100)]
                );
            }

            // If customer commented, also notify superadmin
            if ($currentUserType === 'customer' && $superAdmin && $superAdmin->id != $userId) {
                $this->createNotification(
                    $superAdmin->id,
                    'admin',
                    'comment',
                    'New Comment on Ticket',
                    "A new comment has been added to ticket #{$ticket->ticket_number}",
                    $ticket->id,
                    ['comment' => substr($request->comment, 0, 100)]
                );
            }

            // If superadmin commented, also notify ticket creator (if not the creator)
            if ($currentUserType === 'superadmin' && $ticket->created_by != $userId) {
                $creatorType = \App\Models\Admin::find($ticket->created_by) ? 'admin' : 'staff';
                $this->createNotification(
                    $ticket->created_by,
                    $creatorType,
                    'comment',
                    'New Comment on Ticket',
                    "A new comment has been added to ticket #{$ticket->ticket_number}",
                    $ticket->id,
                    ['comment' => substr($request->comment, 0, 100)]
                );
            }
        }

        // Automatically change status from on_hold to reopened when a comment is added
        // Check for both 'on_hold' and 'onhold' to handle different formats
        if (in_array(strtolower($ticket->status), ['on_hold', 'onhold'])) {
            $reopenedStatus = TicketStatus::where('name', 'Reopened')->first();
            $reopenedStatusSlug = $reopenedStatus ? $reopenedStatus->slug : 'reopened';
            $ticket->status = $reopenedStatusSlug;
            $ticket->save();
            
            // Log the status change for audit purposes
            \Log::info('Ticket status automatically changed from on_hold to reopened', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'previous_status' => $ticket->status,
                'new_status' => $reopenedStatusSlug,
                'triggered_by' => 'comment_addition',
                'user_id' => $userId
            ]);
        }

        return redirect()->back()
            ->with('success', 'Comment added successfully.')
            ->with('active_tab', $request->get('active_tab', 'conversation'));
    }

    public function assign(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $previousAssignedTo = $ticket->assigned_to;
        $ticket->assigned_to = $request->assigned_to;
        
        // Automatically change status from on_hold to reopened when ticket is reassigned
        // Check for both 'on_hold' and 'onhold' to handle different formats
        if (in_array(strtolower($ticket->status), ['on_hold', 'onhold'])) {
            $reopenedStatus = TicketStatus::where('name', 'Reopened')->first();
            $reopenedStatusSlug = $reopenedStatus ? $reopenedStatus->slug : 'reopened';
            $ticket->status = $reopenedStatusSlug;
            
            // Log the status change for audit purposes
            \Log::info('Ticket status automatically changed from on_hold to reopened', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'previous_status' => $ticket->status,
                'new_status' => $reopenedStatusSlug,
                'triggered_by' => 'reassignment',
                'assigned_to' => $request->assigned_to,
                'previous_assigned_to' => $previousAssignedTo
            ]);
        }
        
        $ticket->save();

        // Notify newly assigned staff
        $this->createNotification(
            $request->assigned_to,
            'staff',
            'assignment',
            'New Ticket Assignment',
            "You have been assigned to ticket #{$ticket->ticket_number}",
            $ticket->id,
            ['subject' => $ticket->subject]
        );

        // Notify previous assigned staff if reassignment
        if ($previousAssignedTo && $previousAssignedTo != $request->assigned_to) {
            $this->createNotification(
                $previousAssignedTo,
                'staff',
                'assignment',
                'Ticket Reassigned',
                "Ticket #{$ticket->ticket_number} has been reassigned to another staff member",
                $ticket->id,
                ['subject' => $ticket->subject]
            );
        }

        return redirect()->back()
            ->with('success', 'Ticket assigned successfully.');
    }

    public function destroy($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('admin.support-tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
    
    public function submitRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'rating_comment' => 'nullable|string|max:500',
        ]);

        $ticket = SupportTicket::findOrFail($id);

        // Get current user based on authentication guard
        $user = auth()->check() ? auth()->user() : (auth('admin')->check() ? Auth::guard('admin')->user() : null);
        $isSuperAdmin = RouteHelper::isSuperAdmin();

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $superAdminId = $superAdmin ? $superAdmin->id : null;
        $isSuperAdminCreatedStaff = $superAdmin && $user && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
        }

        if (!$user) {
            return redirect()->back()->with('error', 'Authentication required.');
        }

        // Only allow rating if ticket is closed and user is the creator
        if ($ticket->status !== 'closed') {
            return redirect()->back()
                ->with('error', 'You can only rate closed tickets.');
        }
        
        if ($ticket->created_by !== $user->id) {
            return redirect()->back()
                ->with('error', 'You can only rate your own tickets.');
        }
        
        if ($isSuperAdmin) {
            return redirect()->back()
                ->with('error', 'SuperAdmins cannot rate tickets.');
        }

        $ticket->rating = $request->rating;
        $ticket->rating_comment = $request->rating_comment;
        $ticket->save();

        return redirect()->back()
            ->with('success', 'Thank you for your feedback!')
            ->with('active_tab', $request->get('active_tab', 'details'));
    }
    
    public function addInternalNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip',
            'attachment_names' => 'nullable|array',
        ]);

        // Check if user is admin or staff
        $user = auth('admin')->check() ? Auth::guard('admin')->user() : (auth()->check() ? auth()->user() : null);
        $isSuperAdmin = RouteHelper::isSuperAdmin();

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $superAdminId = $superAdmin ? $superAdmin->id : null;
        $isSuperAdminCreatedStaff = $superAdmin && $user && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
        }

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Authentication required.');
        }

        // Only superAdmin and superadmin-created staff can add internal notes
        if (!$isSuperAdmin) {
            return redirect()->back()
                ->with('error', 'You are not authorized to add internal notes.');
        }

        $ticket = SupportTicket::findOrFail($id);

        // Get the creator's name for display
        $creatorName = '';
        if (auth('admin')->check()) {
            $creatorName = Auth::guard('admin')->user()->name;
        } elseif (auth()->check()) {
            $creatorName = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        }

        // Handle file attachments for internal notes
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            $customNames = $request->input('attachment_names', []);
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $index => $file) {
                if ($file && $file->isValid()) {
                    try {
                        $originalName = $file->getClientOriginalName();
                        $customName = isset($customNames[$index]) && !empty($customNames[$index]) 
                            ? $customNames[$index] . '.' . $file->getClientOriginalExtension()
                            : $originalName;
                        
                        $path = $file->storeAs('internal-note-attachments', $customName, 'public');
                        $attachmentPaths[] = [
                            'path' => $path,
                            'original_name' => $customName
                        ];
                    } catch (\Exception $e) {
                        \Log::error('File storage failed', ['error' => $e->getMessage()]);
                    }
                }
            }
        }

        InternalNote::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => auth('admin')->check() ? Auth::guard('admin')->user()->id : $superAdminId,
            'creator_name' => $creatorName,
            'note' => $request->note,
            'attachments' => json_encode($attachmentPaths),
        ]);

        // Automatically change status from on_hold to reopened when an internal note is added
        // Check for both 'on_hold' and 'onhold' to handle different formats
        if (in_array(strtolower($ticket->status), ['on_hold', 'onhold'])) {
            $reopenedStatus = TicketStatus::where('name', 'Reopened')->first();
            $reopenedStatusSlug = $reopenedStatus ? $reopenedStatus->slug : 'reopened';
            $ticket->status = $reopenedStatusSlug;
            $ticket->save();
            
            // Log the status change for audit purposes
            \Log::info('Ticket status automatically changed from on_hold to reopened', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'previous_status' => $ticket->status,
                'new_status' => $reopenedStatusSlug,
                'triggered_by' => 'internal_note_addition',
                'user_id' => $user->id
            ]);
        }

        return redirect()->back()
            ->with('success', 'Internal note added successfully.')
            ->with('active_tab', $request->get('active_tab', 'internal-notes'));
    }
    
    public function updateInternalNote(Request $request, $id)
    {
        $request->validate([
            'note_id' => 'required|exists:internal_notes,id',
            'note' => 'required|string|max:1000',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip',
            'attachment_names' => 'nullable|array',
        ]);

        // Check if user is admin or staff
        $user = auth('admin')->check() ? Auth::guard('admin')->user() : (auth()->check() ? auth()->user() : null);
        $isSuperAdmin = RouteHelper::isSuperAdmin();

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $superAdminId = $superAdmin ? $superAdmin->id : null;
        $isSuperAdminCreatedStaff = $superAdmin && $user && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
        }

        // Only superAdmin and superadmin-created staff can update internal notes
        if (!$isSuperAdmin) {
            return redirect()->back()
                ->with('error', 'You are not authorized to update internal notes.');
        }

        $ticket = SupportTicket::findOrFail($id);
        $note = InternalNote::findOrFail($request->note_id);

        // Get current user ID for comparison
        $currentUserId = auth('admin')->check() ? Auth::guard('admin')->user()->id : $superAdminId;

        // Check if the note belongs to the current user
        if ($note->user_id !== $currentUserId) {
            return redirect()->back()
                ->with('error', 'You can only edit your own notes.');
        }

        // Handle file attachments for internal notes
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            $customNames = $request->input('attachment_names', []);
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $index => $file) {
                if ($file && $file->isValid()) {
                    try {
                        $originalName = $file->getClientOriginalName();
                        $customName = isset($customNames[$index]) && !empty($customNames[$index]) 
                            ? $customNames[$index] . '.' . $file->getClientOriginalExtension()
                            : $originalName;
                        
                        $path = $file->storeAs('internal-note-attachments', $customName, 'public');
                        $attachmentPaths[] = [
                            'path' => $path,
                            'original_name' => $customName
                        ];
                    } catch (\Exception $e) {
                        \Log::error('File storage failed', ['error' => $e->getMessage()]);
                    }
                }
            }
        }
        
        // Merge with existing attachments
        $existingAttachments = json_decode($note->attachments, true) ?? [];
        // Handle backward compatibility for existing string-based attachments
        $normalizedExisting = [];
        foreach($existingAttachments as $attachment) {
            if(is_array($attachment)) {
                $normalizedExisting[] = $attachment;
            } else {
                $normalizedExisting[] = [
                    'path' => $attachment,
                    'original_name' => basename($attachment)
                ];
            }
        }
        $allAttachments = array_merge($normalizedExisting, $attachmentPaths);

        $note->update([
            'note' => $request->note,
            'attachments' => json_encode($allAttachments),
        ]);

        return redirect()->back()
            ->with('success', 'Internal note updated successfully.')
            ->with('active_tab', $request->get('active_tab', 'internal-notes'));
    }
    
    private function calculateAverageFirstResponse()
    {
        $ticketsWithComments = SupportTicket::has('comments')->get();

        $responseTimesInSeconds = $ticketsWithComments->map(function ($ticket) {
            $firstComment = $ticket->comments()
                ->orderBy('created_at', 'asc')
                ->first();

            if ($firstComment && $ticket->created_at) {
                return $ticket->created_at->diffInSeconds($firstComment->created_at);
            }

            return null;
        })->filter();

        if ($responseTimesInSeconds->isEmpty()) {
            return '00:00:00';
        }

        $averageSeconds = (int) round($responseTimesInSeconds->avg());

        $hours = intdiv($averageSeconds, 3600);
        $minutes = intdiv($averageSeconds % 3600, 60);
        $seconds = $averageSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

    }
    
    private function calculateAverageResolutionTime()
    {
        // Calculate average resolution time in hours, minutes and seconds
        $resolvedTickets = SupportTicket::whereIn('status', ['resolved', 'closed'])
            ->whereNotNull('resolved_at')
            ->get();

        $resolutionTimesInSeconds = $resolvedTickets->map(function ($ticket) {
            if ($ticket->created_at && $ticket->resolved_at) {
                return $ticket->created_at->diffInSeconds($ticket->resolved_at);
            }

            return null;
        })->filter();

        if ($resolutionTimesInSeconds->isEmpty()) {
            return '00:00:00';
        }

        // Average time in seconds
        $averageSeconds = (int) round($resolutionTimesInSeconds->avg());

        // Convert seconds to hours, minutes and seconds
        $hours = intdiv($averageSeconds, 3600);
        $minutes = intdiv($averageSeconds % 3600, 60);
        $seconds = $averageSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
    
    private function getTicketsOverviewData()
    {
        // Get ticket counts for the last 7 days by status
        $labels = [];
        $newTickets = [];
        $resolvedTickets = [];
        $closedTickets = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('M d');
            $dateFull = now()->subDays($i)->format('Y-m-d');
            
            $labels[] = $date;
            $newTickets[] = SupportTicket::whereDate('created_at', $dateFull)->count();
            $resolvedTickets[] = SupportTicket::whereDate('resolved_at', $dateFull)->count();
            $closedTickets[] = SupportTicket::whereDate('closed_at', $dateFull)->count();
        }
        
        return [
            'labels' => $labels,
            'new_tickets' => $newTickets,
            'resolved_tickets' => $resolvedTickets,
            'closed_tickets' => $closedTickets
        ];
    }
    
    private function getTopDepartmentsData()
    {
        // Get ticket counts by department
        $data = SupportTicket::select('department', \DB::raw('count(*) as total'))
            ->groupBy('department')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        
        $labels = $data->pluck('department')->toArray();
        $counts = $data->pluck('total')->toArray();
        
        return [
            'labels' => $labels,
            'data' => $counts
        ];
    }

    public function updateCompanyName(Request $request, $id)
    {
        // Check if user is SuperAdmin or superadmin-created staff
        $isSuperAdmin = RouteHelper::isSuperAdmin();

        // Check if this staff user was created by superadmin
        $superAdmin = Admin::role('SuperAdmin')->first();
        $user = auth()->check() ? auth()->user() : (auth('admin')->check() ? Auth::guard('admin')->user() : null);
        $isSuperAdminCreatedStaff = $superAdmin && $user && $user->created_by == $superAdmin->id;

        // If staff was created by superadmin, give them superadmin privileges
        if ($isSuperAdminCreatedStaff) {
            $isSuperAdmin = true;
        }

        if (!$isSuperAdmin) {
            return redirect()->back()->with('error', 'You are not authorized to update company name.');
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $ticket->company_name = $request->company_name;
        $ticket->save();

        return redirect()->back()
            ->with('success', 'Company name updated successfully.')
            ->with('active_tab', $request->get('active_tab', 'details'));
    }
}
