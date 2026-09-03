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

class SupportTicketController extends Controller
{
    public function ticketDashboard(Request $request)
    {
        // Check if user is staff (users table) or admin (admins table)
        if (auth()->check()) {
            // Staff user from users table
            $user = auth()->user();
            $isSuperAdmin = false;
            $isStaff = true;
        } elseif (auth('admin')->check()) {
            // Admin user from admins table
            $user = Auth::guard('admin')->user();
            $isSuperAdmin = $user->hasRole('SuperAdmin');
            $isStaff = false;
        } else {
            return redirect()->route('admin.login');
        }
            
            $query = SupportTicket::with(['creator', 'assignedTo', 'relatedUser'])
                ->when($isStaff, function ($query) use ($user) {
                    // For staff users, show tickets assigned to them or created by them
                    return $query->where(function($q) use ($user) {
                        $q->where('assigned_to', $user->id)
                          ->orWhere('created_by', $user->id);
                    });
                })
                ->when(!$isSuperAdmin && !$isStaff, function ($query) use ($user) {
                    // For non-SuperAdmin admin users (customers), use existing logic
                    return $query->forUser($user->id);
                });

            // SuperAdmin filters
            if ($isSuperAdmin) {
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
                        $query->whereIn('status', ['closed']);
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
            $departments = ['technical_support', 'billing', 'booking', 'account', 'other'];
            $priorities = ['low', 'medium', 'high', 'critical', 'urgent'];
            $statuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->pluck('slug')->toArray();
            
            // Get all ticket statuses for display (needed for both SuperAdmin and non-SuperAdmin)
            $allTicketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

            // For non-superadmin users, filter to show relevant statuses
            if (!$isSuperAdmin) {
                $ticketStatuses = $allTicketStatuses->filter(function($status) {
                    return in_array($status->slug, ['open', 'in_progress', 'resolved', 'reopened', 'waiting_feedback', 'closed']);
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
                    // For customers, use existing logic
                    $userTickets = SupportTicket::forUser($user->id);
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
                // For superadmin, count all tickets
                $allTickets = SupportTicket::query();
                $counts = [
                    'all' => $allTickets->count(),
                ];
                
                // Add counts for each status from database
                foreach($ticketStatuses as $status) {
                    $counts[$status->slug] = (clone $allTickets)->where('status', $status->slug)->count();
                }
            }
            
            // Get unique company names for filter dropdown
            $companies = AdminDetail::whereNotNull('company_name')
                ->where('company_name', '!=', '')
                ->pluck('company_name')
                ->unique()
                ->sort()
                ->values();

            return view('admin.support-tickets.index', compact('tickets', 'isSuperAdmin', 'counts', 'departments', 'priorities', 'statuses', 'companies', 'ticketStatuses', 'isStaff'));
    }

    public function dashboardStatistics()
    {
        // Get ticket statistics for SuperAdmin dashboard
            $newTickets = SupportTicket::count();
            
            // Get status slugs from database
            $openStatusSlug = TicketStatus::where('name', 'Open')->first()?->slug ?? 'open';
            $inProgressStatusSlug = TicketStatus::where('name', 'In Progress')->first()?->slug ?? 'in_progress';
            $resolvedStatusSlug = TicketStatus::where('name', 'Resolved')->first()?->slug ?? 'resolved';
            $closedStatusSlug = TicketStatus::where('name', 'Closed')->first()?->slug ?? 'closed';
            
            $openTickets = SupportTicket::where('status', $openStatusSlug)->count();
            $pendingTickets = SupportTicket::where('status', $inProgressStatusSlug)->count();
            
            // Calculate overdue tickets (tickets past SLA)
            $overdueTickets = SupportTicket::whereNotIn('status', [$resolvedStatusSlug, $closedStatusSlug])
                ->where('created_at', '<', now()->subHours(24))
                ->count();
            
            $resolvedTickets = SupportTicket::where('status', $resolvedStatusSlug)->count();
            $closedTickets = SupportTicket::where('status', $closedStatusSlug)->count();
            // Calculate average response time (in minutes)
            $avgFirstResponse = $this->calculateAverageFirstResponse();
            
            // Calculate average resolution time
            $avgResolutionTime = $this->calculateAverageResolutionTime();

            // Get data for Tickets Overview chart (last 7 days)
            $ticketsOverviewData = $this->getTicketsOverviewData();
            
            // Get data for Top Departments chart
            $topDepartmentsData = $this->getTopDepartmentsData();

            // Get recent tickets for table view (latest 5)
            $recentTickets = SupportTicket::with(['creator', 'assignedTo'])
                ->latest()
                ->limit(5)
                ->get();
            
            // Get all ticket statuses for display
            $ticketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

            return view('admin.support-tickets.dashboard', compact(
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
        if (auth()->check()) {
            // Staff user from users table
            $user = auth()->user();
            $isSuperAdmin = false;
            $isStaff = true;
        } elseif (auth('admin')->check()) {
            // Admin user from admins table
            $user = Auth::guard('admin')->user();
            $isSuperAdmin = $user->hasRole('SuperAdmin');
            $isStaff = false;
        } else {
            return redirect()->route('admin.login');
        }
        
        $query = SupportTicket::with(['creator', 'assignedTo', 'relatedUser'])
            ->when($isStaff, function ($query) use ($user) {
                // For staff users, show tickets assigned to them or created by them
                return $query->where(function($q) use ($user) {
                    $q->where('assigned_to', $user->id)
                      ->orWhere('created_by', $user->id);
                });
            })
            ->when(!$isSuperAdmin && !$isStaff, function ($query) use ($user) {
                // For non-SuperAdmin admin users (customers), use existing logic
                return $query->forUser($user->id);
            });

        // SuperAdmin filters
        if ($isSuperAdmin) {
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
        $departments = ['technical_support', 'billing', 'booking', 'account', 'other'];
        $priorities = ['low', 'medium', 'high', 'critical', 'urgent']; // Common priorities, but text field allows custom values
        $statuses = ['open', 'in_progress', 'resolved', 'closed'];
        
        // Get unique company names for filter dropdown
        $companies = AdminDetail::whereNotNull('company_name')
            ->where('company_name', '!=', '')
            ->pluck('company_name')
            ->unique()
            ->sort()
            ->values();
        
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
                // For customers, use existing logic
                $userTickets = SupportTicket::forUser($user->id);
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
        }

        return view('admin.support-tickets.index', compact('tickets', 'isSuperAdmin', 'isStaff', 'counts', 'departments', 'priorities', 'statuses', 'companies', 'ticketStatuses'));
    }

    public function create()
    {
        // Check if user is staff (users table) or admin (admins table)
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
            return redirect()->route('admin.login');
        }

        // Fetch staff members (role_id=2) for assignment
        $clients = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->latest()->get();
        
        // For SuperAdmin, get all staff users for assignment
        if ($isSuperAdmin) {
            $staffMembers = User::where('role_id', 2)->where('status', 'active')->get();
        } elseif ($isStaff) {
            // For staff users, get all staff members for assignment
            $staffMembers = User::where('role_id', 2)->where('status', 'active')->get();
        } else {
            // For non-SuperAdmin, get staff created by current user
            $staffMembers = User::where('role_id', 2)->where('status', 'active')->where('created_by', $user->id)->get();
        }
        
        return view('admin.support-tickets.create', compact('staffMembers', 'clients', 'isStaff', 'isSuperAdmin'));
    }

    public function store(Request $request)
    {
        // Check if user is staff (users table) or admin (admins table)
        if (auth()->check()) {
            // Staff user from users table
            $currentUser = auth()->user();
            $isStaff = true;
            $isSuperAdmin = false;
        } elseif (auth('admin')->check()) {
            // Admin user from admins table
            $currentUser = Auth::guard('admin')->user();
            $isSuperAdmin = $currentUser->hasRole('SuperAdmin');
            $isStaff = false;
        } else {
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

        $ticketNumber = 'TKT-' . strtoupper(Str::random(8));

        // Assign the ticket to the specified user or default to SuperAdmin for staff
        if ($isStaff) {
            // For staff users, default to SuperAdmin
            $superAdmin = Admin::role('SuperAdmin')->first();
            $assignedTo = $superAdmin ? $superAdmin->id : null;
        } else {
            // For admin users, use the specified assignment or leave unassigned
            $assignedTo = $request->assigned_to;
        }

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

        SupportTicket::create([
            'ticket_number' => $ticketNumber,
            'department' => $request->department,
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority ?? 'medium',
            'status' => 'open',
            'created_by' => $currentUser->id,
            'assigned_to' => $assignedTo,
            'related_user_id' => $request->related_user_id,
            'booking_reference' => $request->booking_reference,
            'attachments' => json_encode($attachmentPaths),
            'company_name' => $companyName,
        ]);

        if($isSuperAdmin) {
            return redirect()->route('admin.support-tickets.index')
                ->with('success', 'Support ticket created successfully.');
        } else if($isStaff) {
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

        $ticket = SupportTicket::with(['creator', 'assignedTo', 'relatedUser', 'comments.user', 'internalNotes.user'])
            ->findOrFail($id);

        $comments = $ticket->comments()->get();
        $internalNotes = $ticket->internalNotes()->latest()->get();

        // Get staff members for assignment dropdown
        if ($isSuperAdmin) {
            $staffMembers = User::where('role_id', 2)->where('status', 'active')->get();
        } else {
            $staffMembers = User::where('created_by', $user->id)->get();
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
        $departments = Department::latest()->get();

        // Check if user can rate (ticket creator and ticket is closed)
        $canRate = !$isSuperAdmin && $ticket->status === 'closed' && $ticket->created_by === $user->id && !$ticket->rating;

        // Get active tab from session or default to details
        $activeTab = session('active_tab', 'details');

        // Get available ticket statuses
        $ticketStatuses = TicketStatus::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.support-tickets.show', compact('ticket', 'comments', 'internalNotes', 'isSuperAdmin', 'isStaff', 'staffMembers', 'slaDue', 'isOverdue', 'canRate', 'activeTab', 'ticketStatuses', 'departments'));
    }

    public function getStaffByDepartment(Request $request)
    {
        $departmentId = $request->input('department_id');

        // Get staff members (role_id=2) by department
        $staff = User::where('role_id', 2)
            ->where('department', $departmentId)
            ->get();
            //dd($staff);

        return response()->json([
            'staff' => $staff
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        // Determine user type and permissions
        $isStaff = auth()->check();
        $isSuperAdmin = auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin');
        $isCustomer = auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin');
        
        $userId = $isStaff ? auth()->user()->id : auth('admin')->user()->id;
        
        // Get available statuses from database
        $availableStatuses = TicketStatus::where('is_active', true)->pluck('slug')->toArray();
        
        $request->validate([
            'status' => 'required|in:' . implode(',', $availableStatuses),
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'nullable|string|max:255',
            'department' => 'nullable|string|in:technical_support,billing,booking,account,other',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        
        // Check if staff user has permission to update this ticket
        if ($isStaff) {
            // Staff can only update tickets assigned to them or created by them
            if ($ticket->assigned_to != $userId && $ticket->created_by != $userId) {
                return redirect()->back()
                    ->with('error', 'You do not have permission to update this ticket.');
            }
        }
        
        // Customers should not be able to update ticket status (only view)
        if ($isCustomer) {
            return redirect()->back()
                ->with('error', 'You do not have permission to update ticket status.');
        }
        
        $oldStatus = $ticket->status;
        $ticket->status = $request->status;

        if ($request->has('assigned_to')) {
            $ticket->assigned_to = $request->assigned_to;
        }

        // Update priority if provided
        if ($request->has('priority') && $request->priority !== '') {
            $ticket->priority = $request->priority;
        }

        // Update department/category if provided
        if ($request->has('department') && $request->department !== '') {
            $ticket->department = $request->department;
        }

        // Handle status changes and timestamps
        if ($request->status === 'resolved') {
            $ticket->resolved_at = now();
        } elseif ($request->status === 'closed') {
            $ticket->closed_at = now();
            if (!$ticket->resolved_at) {
                $ticket->resolved_at = now();
            }
        } elseif ($oldStatus === 'closed' && $request->status === 'open') {
            // Reopening ticket - clear timestamps and rating
            $ticket->resolved_at = null;
            $ticket->closed_at = null;
            $ticket->rating = null;
            $ticket->rating_comment = null;
        }

        $ticket->save();

        return redirect()->back()
            ->with('success', 'Ticket updated successfully.')
            ->with('active_tab', $request->get('active_tab', 'details'));
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
        ]);

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
        $ticket->assigned_to = $request->assigned_to;
        $ticket->save();

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
        if (auth()->check()) {
            // Staff user from users table
            $user = auth()->user();
            $isSuperAdmin = false;
        } elseif (auth('admin')->check()) {
            // Admin user from admins table
            $user = Auth::guard('admin')->user();
            $isSuperAdmin = $user->hasRole('SuperAdmin');
        } else {
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

        $user = Auth::guard('admin')->user();
        
        // Only superAdmin can add internal notes
        if (!$user->hasRole('SuperAdmin')) {
            return redirect()->back()
                ->with('error', 'You are not authorized to add internal notes.');
        }

        $ticket = SupportTicket::findOrFail($id);

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
            'user_id' => $user->id,
            'note' => $request->note,
            'attachments' => json_encode($attachmentPaths),
        ]);

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

        $user = Auth::guard('admin')->user();
        
        // Only superAdmin can update internal notes
        if (!$user->hasRole('SuperAdmin')) {
            return redirect()->back()
                ->with('error', 'You are not authorized to update internal notes.');
        }

        $ticket = SupportTicket::findOrFail($id);
        $note = InternalNote::findOrFail($request->note_id);
        
        // Check if the note belongs to the current user
        if ($note->user_id !== $user->id) {
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
        // Calculate average time to first response (in minutes)
        // Get the first comment for each ticket and calculate response time
        $ticketsWithComments = SupportTicket::has('comments')->get();
        
        $responseTimes = $ticketsWithComments->map(function ($ticket) {
            $firstComment = $ticket->comments()->orderBy('created_at')->first();
            if ($firstComment && $ticket->created_at) {
                return $ticket->created_at->diffInMinutes($firstComment->created_at);
            }
            return null;
        })->filter();
        
        return $responseTimes->isEmpty() ? 0 : round($responseTimes->avg(), 2);
    }
    
    private function calculateAverageResolutionTime()
    {
        // Calculate average resolution time (in hours)
        $resolvedTickets = SupportTicket::whereIn('status', ['resolved', 'closed'])
            ->whereNotNull('resolved_at')
            ->get();
            
        $resolutionTimes = $resolvedTickets->map(function ($ticket) {
            if ($ticket->created_at && $ticket->resolved_at) {
                return $ticket->created_at->diffInHours($ticket->resolved_at);
            }
            return null;
        })->filter();
        
        return $resolutionTimes->isEmpty() ? 0 : round($resolutionTimes->avg(), 2);
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
        // Check if user is SuperAdmin
        if (!auth('admin')->check() || !Auth::guard('admin')->user()->hasRole('SuperAdmin')) {
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
