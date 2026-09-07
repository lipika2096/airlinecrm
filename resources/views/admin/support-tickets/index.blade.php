@extends('admin/layouts/head-main')
@section('content')
    <title>Support Tickets</title>

    @php
        // Define routes for all user types
        $dashboardRoute = $isSuperAdmin ? route('admin.support-tickets.index') : ($isStaff ? route('staff.support-tickets.index') : route('customer.support-tickets.index'));
        $createRoute = $isSuperAdmin ? route('admin.support-tickets.create') : ($isStaff ? route('staff.support-tickets.create') : route('customer.support-tickets.create'));
        $showRouteBase = $isSuperAdmin ? 'admin.support-tickets.show' : ($isStaff ? 'staff.support-tickets.show' : 'customer.support-tickets.show');
        $dashboardIndexRoute = $isSuperAdmin ? route('admin.support-tickets.index') : ($isStaff ? route('staff.support-tickets.dashboard') : route('customer.support-tickets.dashboard'));
        $createRoute = $isSuperAdmin ? route('admin.support-tickets.create') : ($isStaff ? route('staff.support-tickets.create') : route('customer.support-tickets.create'));
    @endphp

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">{{ $isSuperAdmin ? 'All Tickets (Admin View)' : 'My Tickets' }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ $dashboardRoute }}">Support Ticket Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $isSuperAdmin ? 'All Tickets' : 'My Tickets' }}</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ $createRoute }}" class="btn add-btn"><i class="fa fa-plus"></i> {{ $isSuperAdmin ? 'New Ticket' : 'Create Ticket' }}</a>
                    </div>  
                </div>
            </div>
            <!-- /Page Header -->

            @if($isSuperAdmin)
            
                <!-- SuperAdmin Advanced Filters -->
                <div class="row filter-row mb-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.support-tickets.index') }}">
                                    <div class="row align-items-end">
                                        <!-- <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Company</label>
                                                <select class="form-control" name="company">
                                                    <option value="">All Companies</option>
                                                    @foreach($companies as $company)
                                                        <option value="{{ $company }}" {{ request('company') == $company ? 'selected' : '' }}>
                                                            {{ $company }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select class="form-control" name="department">
                                                    <option value="">All Categories</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department }}" {{ request('department') == $department ? 'selected' : '' }}>
                                                            {{ ucfirst(str_replace('_', ' ', $department)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="">All Status</option>
                                                    @foreach($ticketStatuses as $status)
                                                        <option value="{{ $status->slug }}" {{ request('status') == $status->slug ? 'selected' : '' }}>
                                                            {{ $status->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Priority</label>
                                                <select class="form-control" name="priority">
                                                    <option value="">All Priority</option>
                                                    @foreach($priorities as $priority)
                                                        <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>
                                                            {{ ucfirst($priority) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date Range</label>
                                                <div class="input-group">
                                                    <input type="date" name="date_from" class="form-control" placeholder="From" value="{{ request('date_from') }}">
                                                    <input type="date" name="date_to" class="form-control" placeholder="To" value="{{ request('date_to') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Search</label>
                                                <div class="input-group">
                                                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa fa-search"></i> Search Tickets
                                            </button>
                                            <a href="{{ route('admin.support-tickets.index') }}" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-refresh"></i> Reset Filters
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SuperAdmin Tab View -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="superadmin-filter-tabs">
                                    <a href="{{ route('admin.support-tickets.index') }}?tab=all" 
                                    class="superadmin-tab {{ request('tab', 'all') == 'all' ? 'active' : '' }}">
                                        Total Tickets ({{ $counts['all'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('admin.support-tickets.index') }}?tab=new" 
                                    class="superadmin-tab {{ request('tab') == 'new' ? 'active' : '' }}">
                                        New Tickets ({{ $counts['new'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('admin.support-tickets.index') }}?tab=in_progress" 
                                    class="superadmin-tab {{ request('tab') == 'in_progress' ? 'active' : '' }}">
                                        In Progress ({{ $counts['in_progress'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('admin.support-tickets.index') }}?tab=resolved" 
                                    class="superadmin-tab {{ request('tab') == 'resolved' ? 'active' : '' }}">
                                        Resolved ({{ $counts['resolved'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('admin.support-tickets.index') }}?tab=reopened" 
                                    class="superadmin-tab {{ request('tab') == 'reopened' ? 'active' : '' }}">
                                        Reopened ({{ $counts['reopened'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('admin.support-tickets.index') }}?tab=waiting_feedback" 
                                    class="superadmin-tab {{ request('tab') == 'waiting_feedback' ? 'active' : '' }}">
                                        Waiting (Feedback) ({{ $counts['waiting_feedback'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('admin.support-tickets.index') }}?tab=critical" 
                                    class="superadmin-tab {{ request('tab') == 'critical' ? 'active' : '' }}">
                                        Critical ({{ $counts['critical'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('admin.support-tickets.index') }}?tab=closed" 
                                    class="superadmin-tab {{ request('tab') == 'closed' ? 'active' : '' }}">
                                        Closed ({{ $counts['closed'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('admin.support-tickets.index') }}?tab=unassigned" 
                                    class="superadmin-tab {{ request('tab') == 'unassigned' ? 'active' : '' }}">
                                        Unassigned ({{ $counts['unassigned'] ?? 0 }})
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(\App\Helpers\RouteHelper::isStaff() && (auth()->user()->created_by == 2))
            <!-- SuperAdmin Advanced Filters -->
                <div class="row filter-row mb-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ \App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') :(\App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : route('admin.support-tickets.index')) }}">
                                    <div class="row align-items-end">
                                        <!-- <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Company</label>
                                                <select class="form-control" name="company">
                                                    <option value="">All Companies</option>
                                                    @foreach($companies as $company)
                                                        <option value="{{ $company }}" {{ request('company') == $company ? 'selected' : '' }}>
                                                            {{ $company }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select class="form-control" name="department">
                                                    <option value="">All Categories</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department }}" {{ request('department') == $department ? 'selected' : '' }}>
                                                            {{ ucfirst(str_replace('_', ' ', $department)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="">All Status</option>
                                                    @foreach($ticketStatuses as $status)
                                                        <option value="{{ $status->slug }}" {{ request('status') == $status->slug ? 'selected' : '' }}>
                                                            {{ $status->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Priority</label>
                                                <select class="form-control" name="priority">
                                                    <option value="">All Priority</option>
                                                    @foreach($priorities as $priority)
                                                        <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>
                                                            {{ ucfirst($priority) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date Range</label>
                                                <div class="input-group">
                                                    <input type="date" name="date_from" class="form-control" placeholder="From" value="{{ request('date_from') }}">
                                                    <input type="date" name="date_to" class="form-control" placeholder="To" value="{{ request('date_to') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Search</label>
                                                <div class="input-group">
                                                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa fa-search"></i> Search Tickets
                                            </button>
                                            <a href="{{ route('admin.support-tickets.index') }}" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-refresh"></i> Reset Filters
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Non-SuperAdmin User-Friendly Layout -->
                @php
                    $baseRoute = $dashboardIndexRoute;
                @endphp
                <div class="row filter-row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body"> 
                                <!-- Filter Tabs -->
                                <div class="filter-tabs-modern">
                                    <a href="{{ $baseRoute }}?status=all" 
                                    class="filter-tab {{ request('status', 'all') == 'all' ? 'active' : '' }}">
                                        <i class="fa fa-list"></i> All ({{ $counts['all'] ?? 0 }})
                                    </a>
                                    @foreach($ticketStatuses as $status)
                                        <a href="{{ $baseRoute }}?status={{ $status->slug }}" 
                                        class="filter-tab {{ request('status') == $status->slug ? 'active' : '' }}">
                                            <i class="fa fa-circle" style="color: {{ $status->color }}; font-size: 8px;"></i> {{ $status->name }} ({{ $counts[$status->slug] ?? 0 }})
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Non-SuperAdmin User-Friendly Layout -->
                @php
                    $baseRoute = $dashboardRoute;
                @endphp
                <div class="row filter-row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body"> 
                                <!-- Filter Tabs -->
                                <div class="filter-tabs-modern">
                                    <a href="{{ $baseRoute }}?status=all" 
                                    class="filter-tab {{ request('status', 'all') == 'all' ? 'active' : '' }}">
                                        <i class="fa fa-list"></i> All ({{ $counts['all'] ?? 0 }})
                                    </a>
                                    @foreach($ticketStatuses as $status)
                                        <a href="{{ $baseRoute }}?status={{ $status->slug }}" 
                                        class="filter-tab {{ request('status') == $status->slug ? 'active' : '' }}">
                                            <i class="fa fa-circle" style="color: {{ $status->color }}; font-size: 8px;"></i> {{ $status->name }} ({{ $counts[$status->slug] ?? 0 }})
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    @if($isSuperAdmin)
                    <div class="card" style="border: none; box-shadow: none;">
                        <div class="card-body" style="padding: 0;">
                            <table class="table table-modern-tickets">
                                <thead>
                                    <tr>
                                        <th>TICKET ID</th>
                                        <th>COMPANY</th>
                                        <th>SUBJECT</th>
                                        <th>CATEGORY</th>
                                        <th>PRIORITY</th>
                                        <th>STATUS</th>
                                        <th>ASSIGNED TO</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td><span class="ticket-id-badge">#{{ $ticket->id }}</span></td>
                                            <td>{{ $ticket->company_name ?? 'Superadmin' }}</td>
                                            <td><a href="{{ route('admin.support-tickets.show', $ticket->id) }}" class="ticket-subject-link">{{ Str::limit($ticket->subject, 50) }}</a></td>
                                            <td>
                                                @if($ticket->department)
                                                    <span class="department-badge">{{ ucfirst(str_replace('_', ' ', $ticket->department)) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ticket->priority == 'low')
                                                    <span class="badge bg-success">Low</span>
                                                @elseif($ticket->priority == 'medium')
                                                    <span class="badge bg-primary">Medium</span>
                                                @elseif($ticket->priority == 'high')
                                                    <span class="badge bg-danger">High</span>
                                                @elseif($ticket->priority == 'critical')
                                                    <span class="badge bg-danger">Critical</span>
                                                @elseif($ticket->priority == 'urgent')
                                                    <span class="badge bg-danger">Urgent</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $superAdminTicketStatus = $ticketStatuses->where('slug', $ticket->status)->first();
                                                @endphp
                                                @if($superAdminTicketStatus)
                                                    <span class="status-badge" style="background-color: {{ $superAdminTicketStatus->color }}; color: white;">
                                                        {{ $superAdminTicketStatus->name }}
                                                    </span>
                                                @else
                                                    <span class="status-badge status-{{ $ticket->status }}">
                                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $ticket->assignedTo ? $ticket->assignedTo->first_name . ' ' . $ticket->assignedTo->last_name : 'Unassigned' }}</td>
                                            <td class="text-end">
                                                <div class="dropdown-action">
                                                    @if($isSuperAdmin)
                                                        <a href="{{ route('admin.support-tickets.show', $ticket->id) }}" class="btn btn-sm btn-view-ticket">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                        @if($ticket->status !== 'closed' && ( ($ticket->assigned_to === null || $ticket->assigned_to === auth('admin')->user()->id)))
                                                        <button type="button" class="btn btn-sm btn-assign-ticket" data-bs-toggle="modal" data-bs-target="#assignTicketModal" data-ticket-id="{{ $ticket->id }}" data-current-assigned="{{ $ticket->assigned_to ?? '' }}">
                                                            <i class="fa fa-user-plus"></i> Assign
                                                        </button>
                                                        @else
                                                        <button type="button" class="btn btn-sm btn-assign-ticket" disabled>
                                                            <i class="fa fa-user-plus"></i> Assign
                                                        </button>
                                                        @endif
                                                    @elseif($isStaff)
                                                        <a href="{{ route('staff.support-tickets.show', $ticket->id) }}" class="btn btn-sm btn-view-ticket">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                        
                                                    @else
                                                        <a href="{{ route('customer.support-tickets.show', $ticket->id) }}" class="btn btn-sm btn-view-ticket">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($tickets->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">No tickets found.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal fade" id="assignTicketModal" tabindex="-1" role="dialog"aria-labelledby="assignTicketModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST"  id="assignTicketForm" action="">
                                    @csrf
                                    @method('patch')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="assignTicketModalLabel">
                                            Update Ticket Assignment
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            {{-- Department --}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="departmentSelect">
                                                        Department
                                                    </label>
                                                    <select class="form-control" name="department" id="departmentSelect">
                                                        <option value="">
                                                            Select Department
                                                        </option>
                                                        @foreach($staffdepartments as $department)
                                                            <option value="{{ $department }}"
                                                                {{ isset($ticket->department) && $ticket->department == $department ? 'selected' : '' }}>
                                                                {{ $department }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Assign To --}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="staffSelect">
                                                        Assign To
                                                    </label>
                                                    <select class="form-control" name="assigned_to" id="staffSelect">
                                                        <option value="">
                                                            Select Staff Member
                                                        </option>
                                                        @foreach($staffMembers as $staff)
                                                            <option value="{{ $staff->id }}" >
                                                                {{ $staff->first_name }} {{ $staff->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i>
                                            Update Assignment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Non-SuperAdmin Table Layout -->
                    <div class="card user-friendly-table-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-user-friendly">
                                    <thead>
                                        <tr>
                                            <th>Ticket ID</th>
                                            <th>Subject</th>
                                            <th>Category</th>
                                            <!-- <th>Priority</th> -->
                                            @if($isStaff)<th>Status</th>@endif
                                            <th>Last Updated</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tickets as $ticket)
                                        <tr>
                                            <td>
                                                <span class="ticket-id-modern">#{{ $ticket->id }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route($showRouteBase, $ticket->id) }}" class="subject-link">
                                                    {{ Str::limit($ticket->subject, 50) }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="category-badge">
                                                    <i class="fa fa-folder"></i>
                                                    {{ ucfirst(str_replace('_', ' ', $ticket->department ?? 'General')) }}
                                                </span>
                                            </td>
                                            <!-- <td>
                                                <span class="priority-badge priority-{{ $ticket->priority }}">
                                                    {{ ucfirst($ticket->priority) }}
                                                </span>
                                            </td> -->
                                            @if($isStaff)
                                            <td>
                                                @php
                                                    $indexTicketStatus = $ticketStatuses->where('slug', $ticket->status)->first();
                                                @endphp
                                                @if($indexTicketStatus)
                                                    <span class="status-badge" style="background-color: {{ $indexTicketStatus->color }}; color: white;">
                                                        {{ $indexTicketStatus->name }}
                                                    </span>
                                                @else
                                                    <span class="status-badge status-{{ $ticket->status }}">
                                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                                    </span>
                                                @endif
                                            </td>
                                            @endif
                                            <td>
                                                <span class="time-ago">
                                                    <i class="fa fa-clock"></i>
                                                    {{ $ticket->updated_at->diffForHumans() }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route($showRouteBase, $ticket->id) }}" class="btn btn-sm btn-view-ticket">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                @if($isStaff)
                                                    <button type="button" class="btn btn-sm btn-assign-ticket" data-bs-toggle="modal" data-bs-target="#transferTicketModal" data-ticket-id="{{ $ticket->id }}" data-current-assigned="{{ $ticket->assigned_to ?? '' }}">
                                                        <i class="fa fa-user-plus"></i> Transfer
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="empty-state-table">
                                                    <div class="empty-state-icon">
                                                        <i class="fa fa-ticket"></i>
                                                    </div>
                                                    <h4>No Tickets Found</h4>
                                                    <p>You don't have any support tickets yet. Create your first ticket to get started!</p>
                                                    <a href="{{ $createRoute }}" class="btn-create-first">
                                                        <i class="fa fa-plus"></i> Create Your First Ticket
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            
                    <div class="modal fade" id="transferTicketModal" tabindex="-1" role="dialog"aria-labelledby="transferTicketModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST"  id="transferTicketForm" action="">
                                    @csrf
                                    @method('patch')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="transferTicketModalLabel">
                                            Transfer Ticket
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            {{-- Department --}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="departmentSelect">
                                                        Department
                                                    </label>
                                                    <select class="form-control" name="department" id="departmentStaffSelect">
                                                        <option value="">
                                                            Select Department
                                                        </option>
                                                        @foreach($staffdepartments as $department)
                                                            <option value="{{ $department }}"
                                                                {{ isset($ticket->department) && $ticket->department == $department ? 'selected' : '' }}>
                                                                {{ $department }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Assign To --}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="staffSelect">
                                                        Transfer To
                                                    </label>
                                                    <select class="form-control" name="assigned_to" id="staffSelect2">
                                                        <option value="">
                                                            Select Staff Member
                                                        </option>
                                                        @foreach($staffMembers as $staff)
                                                            <option value="{{ $staff->id }}">
                                                                {{ $staff->first_name }} {{ $staff->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i>
                                            Transfer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            
            @if(!$isSuperAdmin)
            <!-- Pagination for Non-SuperAdmin -->
            <div class="row">
                <div class="col-md-12">
                    {{ $tickets->appends(request()->except('page'))->links() }}
                </div>
            </div>
            @endif
            
            @if($isSuperAdmin)
            <!-- Pagination for SuperAdmin -->
            <div class="row">
                <div class="col-md-12">
                    {{ $tickets->appends(request()->except('page'))->links() }}
                </div>
            </div>
            @endif
        </div>
        <!-- /Page Content -->
    </div>
    
    <style>
        /* User-Friendly Header Section */
        /* .user-friendly-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .user-friendly-header .card-body {
            padding: 25px;
        } */
        
        .welcome-section .welcome-title {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 5px 0;
        }
        
        .welcome-section .welcome-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin: 0;
        }
        
        /* Modern Search Input */
        .search-modern {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .search-input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }
        
        .search-button {
            position: absolute;
            right: 5px;
            background: #667eea;
            color: white;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-button:hover {
            background: #764ba2;
            transform: scale(1.1);
        }
        
        /* Quick Stats Cards */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.25);
        }
        
        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }
        
        .stat-all .stat-icon { background: rgba(255, 255, 255, 0.3); }
        .stat-open .stat-icon { background: #4fc3f7; }
        .stat-pending .stat-icon { background: #ffb74d; }
        .stat-closed .stat-icon { background: #81c784; }
        
        .stat-info {
            flex: 1;
        }
        
        .stat-number {
            color: white;
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            margin-top: 3px;
        }
        
        /* Modern Filter Tabs */
        .filter-tabs-modern {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
        }
        
        .filter-tab {
            padding: 10px 20px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .filter-tab:hover {
            background: rgba(255, 255, 255, 0.25);
        }
        
        .filter-tab.active {
            background: white;
            color: #667eea;
            border-color: #667eea;
            border-radius: 12px;
            
        }
        
        /* User-Friendly Table Card */
        .user-friendly-table-card {
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }
        
        .user-friendly-table-card .card-body {
            padding: 0;
        }
        
        .table-user-friendly {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        
        .table-user-friendly thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .table-user-friendly thead th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            color: white;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }
        
        .table-user-friendly tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }
        
        .table-user-friendly tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .table-user-friendly tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #495057;
            font-size: 14px;
        }
        
        /* Modern Ticket ID */
        .ticket-id-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
        }
        
        /* Subject Link */
        .subject-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        
        .subject-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        /* Category Badge */
        .category-badge {
            background: #f8f9fa;
            color: #6c757d;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid #e9ecef;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        /* Priority Badge */
        .priority-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            display: inline-block;
        }
        
        .priority-badge.priority-low {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .priority-badge.priority-medium {
            background: #e3f2fd;
            color: #1565c0;
        }
        
        .priority-badge.priority-high {
            background: #ffebee;
            color: #c62828;
        }
        
        .priority-badge.priority-critical {
            background: #ffcdd2;
            color: #b71c1c;
        }
        
        .priority-badge.priority-urgent {
            background: #ffecb3;
            color: #f57f17;
        }
        
        /* Status Badge */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-block;
        }
        
        .status-badge.status-open {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .status-badge.status-in_progress {
            background: #fff3e0;
            color: #f57c00;
        }
        
        .status-badge.status-resolved {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .status-badge.status-closed {
            background: #f5f5f5;
            color: #757575;
        }
        
        /* Time Ago */
        .time-ago {
            color: #6c757d;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .time-ago i {
            color: #999;
        }
        
        /* Action Button */
        .btn-action-view {
            //background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: black;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-action-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
        }
        
        /* Empty State in Table */
        .empty-state-table {
            padding: 40px 20px;
            text-align: center;
        }
        
        .empty-state-table .empty-state-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
        }
        
        .empty-state-table h4 {
            color: #333;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .empty-state-table p {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .empty-state-table .btn-create-first {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .empty-state-table .btn-create-first:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .quick-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .welcome-section .welcome-title {
                font-size: 20px;
            }
            
            .filter-tabs-modern {
                flex-direction: column;
            }
            
            .filter-tab {
                justify-content: center;
            }
            
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table-user-friendly {
                min-width: 600px;
            }
            
            .table-user-friendly thead th {
                padding: 12px 10px;
                font-size: 11px;
            }
            
            .table-user-friendly tbody td {
                padding: 12px 10px;
                font-size: 13px;
            }
            
            .ticket-id-modern {
                font-size: 11px;
                padding: 4px 8px;
            }
            
            .subject-link {
                font-size: 13px;
            }
            
            .category-badge,
            .priority-badge,
            .status-badge {
                font-size: 10px;
                padding: 4px 8px;
            }
            
            .btn-action-view {
                padding: 6px 12px;
                font-size: 11px;
            }
        }
    </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#departmentSelect').on('change', function() {
                var departmentId = $(this).val();
                var staffSelect = $('#staffSelect');
                var currentAssignedTo = '{{ $ticket->assigned_to ?? '' }}';
                // Show loading state
                staffSelect.html('<option value="">Loading...</option>');
                if (departmentId) {
                // Fetch staff members by department via AJAX
                    $.ajax({
                        url: '{{ route('admin.get-staff-by-department') }}',
                        type: 'GET',
                        data: { department_id: departmentId },
                        success: function(response) {
                            staffSelect.empty();
                            staffSelect.append('<option value="">Select Staff Member</option>');
                            if (response.staff && response.staff.length > 0) {
                                response.staff.forEach(function(staff) {
                                    var selected = staff.id == currentAssignedTo ? 'selected' : '';
                                    staffSelect.append('<option value="' + staff.id + '" ' + selected + '>' + staff.first_name + ' ' + staff.last_name + '</option>');
                                });
                            } else {
                                staffSelect.append('<option value="">No staff members found</option>');
                            }
                        },
                        error: function(xhr) {
                            staffSelect.empty();
                            staffSelect.append('<option value="">Error loading staff</option>');
                        }
                    });
                } else {
                    // Reset to all staff members
                    staffSelect.empty();
                    staffSelect.append('<option value="">Select Staff Member</option>');
                    @foreach($staffMembers as $staff)
                        staffSelect.append('<option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }}</option>');
                    @endforeach
                }
            });

            $('#departmentStaffSelect').on('change', function() {
                var departmentId = $(this).val();
                var staffSelect2 = $('#staffSelect2');
                var currentAssignedTo = '{{ $ticket->assigned_to ?? '' }}';
                // Show loading state
                staffSelect2.html('<option value="">Loading...</option>');
                if (departmentId) {
                // Fetch staff members by department via AJAX
                    $.ajax({
                        url: '{{ route('admin.get-staff-by-department') }}',
                        type: 'GET',
                        data: { department_id: departmentId },
                        success: function(response) {
                            staffSelect2.empty();
                            staffSelect2.append('<option value="">Select Staff Member</option>');
                            if (response.staff && response.staff.length > 0) {
                                response.staff.forEach(function(staff) {
                                    var selected = staff.id == currentAssignedTo ? 'selected' : '';
                                    staffSelect2.append('<option value="' + staff.id + '" ' + selected + '>' + staff.first_name + ' ' + staff.last_name + '</option>');
                                });
                            } else {
                                staffSelect2.append('<option value="">No staff members found</option>');
                            }
                        },
                        error: function(xhr) {
                            staffSelect2.empty();
                            staffSelect2.append('<option value="">Error loading staff</option>');
                        }
                    });
                } else {
                    // Reset to all staff members
                    staffSelect2.empty();
                    staffSelect2.append('<option value="">Select Staff Member</option>');
                    @foreach($staffMembers as $staff)
                        staffSelect2.append('<option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }}</option>');
                    @endforeach
                }
            });
        });
        
        document.addEventListener('DOMContentLoaded', function () {

            const assignTicketModal = document.getElementById('assignTicketModal');

            assignTicketModal.addEventListener('show.bs.modal', function (event) {

                const button = event.relatedTarget;

                // Get clicked ticket ID
                const ticketId = button.getAttribute('data-ticket-id');

                // Laravel route with placeholder
                let actionUrl = "{{ $isSuperAdmin? route('admin.support-tickets.update-status', ':ticketId'): ($isStaff ? route('staff.support-tickets.update-status', ':ticketId'): route('customer.support-tickets.update-status', ':ticketId')) }}";

                // Replace placeholder with actual ticket ID
                actionUrl = actionUrl.replace(':ticketId', ticketId);

                // Set form action
                document.getElementById('assignTicketForm').action = actionUrl;
            });
        });

        document.addEventListener('DOMContentLoaded', function () {

            const transferTicketModal = document.getElementById('transferTicketModal');

            transferTicketModal.addEventListener('show.bs.modal', function (event) {

                const button = event.relatedTarget;

                // Get clicked ticket ID
                const ticketId = button.getAttribute('data-ticket-id');

                // Laravel route with placeholder
                let actionUrl = "{{ $isSuperAdmin? route('admin.support-tickets.update-status', ':ticketId'): ($isStaff ? route('staff.support-tickets.update-status', ':ticketId'): route('customer.support-tickets.update-status', ':ticketId')) }}";

                // Replace placeholder with actual ticket ID
                actionUrl = actionUrl.replace(':ticketId', ticketId);

                // Set form action
                document.getElementById('transferTicketForm').action = actionUrl;
            });
        });
    </script>
@endsection