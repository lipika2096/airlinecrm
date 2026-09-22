@extends('admin/layouts/head-main')
@section('content')
    <title>Support Tickets</title>

    @php
        // Define routes for all user types
        $dashboardRoute = \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.index') : route('customer.support-tickets.index'));
        $createRoute = \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.create') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.create') : route('customer.support-tickets.create'));
        $showRouteBase = \App\Helpers\RouteHelper::isSuperAdmin() ? 'admin.support-tickets.show' : (\App\Helpers\RouteHelper::isStaff() ? 'staff.support-tickets.show' : 'customer.support-tickets.show');
        $dashboardIndexRoute = \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('customer.support-tickets.dashboard'));
        $createRoute = \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.create') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.create') : route('customer.support-tickets.create'));

        // Get current user ID regardless of authentication guard
        $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);
    @endphp

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">{{ \App\Helpers\RouteHelper::isSuperAdmin() ? 'All Tickets (Admin View)' : 'My Tickets' }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.index') : route('customer.support-tickets.index')) }}">Support Ticket Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ \App\Helpers\RouteHelper::isSuperAdmin() ? 'All Tickets' : 'My Tickets' }}</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ $createRoute }}" class="btn add-btn"><i class="fa fa-plus"></i> {{ \App\Helpers\RouteHelper::isSuperAdmin() ? 'New Ticket' : 'Create Ticket' }}</a>
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
                                <form method="GET" action="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}">
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
                                            <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}" class="btn btn-secondary btn-sm">
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
                                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}?tab=all" 
                                    class="superadmin-tab {{ request('tab', 'all') == 'all' ? 'active' : '' }}">
                                        Total Tickets ({{ $counts['all'] ?? 0 }})
                                    </a>
                                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}?tab=new" 
                                    class="superadmin-tab {{ request('tab') == 'new' ? 'active' : '' }}">
                                        New Tickets ({{ $counts['new'] ?? 0 }})
                                    </a>
                                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}?tab=in_progress" 
                                    class="superadmin-tab {{ request('tab') == 'in_progress' ? 'active' : '' }}">
                                        In Progress ({{ $counts['in_progress'] ?? 0 }})
                                    </a>
                                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}?tab=resolved" 
                                    class="superadmin-tab {{ request('tab') == 'resolved' ? 'active' : '' }}">
                                        Resolved ({{ $counts['resolved'] ?? 0 }})
                                    </a>
                                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}?tab=reopened" 
                                    class="superadmin-tab {{ request('tab') == 'reopened' ? 'active' : '' }}">
                                        Reopened ({{ $counts['reopened'] ?? 0 }})
                                    </a>
                                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}?tab=waiting_feedback" 
                                    class="superadmin-tab {{ request('tab') == 'waiting_feedback' ? 'active' : '' }}">
                                        Waiting (Feedback) ({{ $counts['waiting_feedback'] ?? 0 }})
                                    </a>
                                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}?tab=critical" 
                                    class="superadmin-tab {{ request('tab') == 'critical' ? 'active' : '' }}">
                                        Critical ({{ $counts['critical'] ?? 0 }})
                                    </a>
                                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}?tab=closed" 
                                    class="superadmin-tab {{ request('tab') == 'closed' ? 'active' : '' }}">
                                        Closed ({{ $counts['closed'] ?? 0 }})
                                    </a>
                                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}?tab=unassigned" 
                                    class="superadmin-tab {{ request('tab') == 'unassigned' ? 'active' : '' }}">
                                        Unassigned ({{ $counts['unassigned'] ?? 0 }})
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(\App\Helpers\RouteHelper::isStaff() && $superAdminId && auth()->user()->created_by === $superAdminId)
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
                                            <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('admin.support-tickets.index')) }}" class="btn btn-secondary btn-sm">
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
            @endif

            <div class="row">
                <div class="col-md-12">
                    @if($isSuperAdmin)
                    <div class="card" style="border: none; box-shadow: none;">
                        <div class="card-body" style="padding: 0;">
                            <table class="table table-modern-tickets">
                                <thead>
                                    <tr>
                                        <th>Sr.no.</th>
                                        <th>TICKET ID</th>
                                        <th>COMPANY</th>
                                        <th>SUBJECT</th>
                                        <th>CATEGORY</th>
                                        @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
                                        <th>PRIORITY</th>
                                        @endif
                                        @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
                                        <th>STATUS</th>
                                        @endif
                                        <th>ASSIGNED TO</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{$ticket->id}}</td>
                                            <td><span class="ticket-id-badge">#{{ $ticket->ticket_number }}</span></td>
                                            <td>{{ $ticket->company_name ?? 'Superadmin' }}</td>
                                            <td><a href="{{ route('admin.support-tickets.show', $ticket->id) }}" class="ticket-subject-link">{{ Str::limit($ticket->subject, 50) }}</a></td>
                                            <td>
                                                @if($ticket->department)
                                                    <span class="department-badge">{{ ucfirst(str_replace('_', ' ', $ticket->department)) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
                                            <td>
                                                <div class="priority-dropdown">
                                                    <button type="button" class="btn btn-sm priority-btn" data-bs-toggle="dropdown" data-ticket-id="{{ $ticket->id }}" data-current-priority="{{ $ticket->priority }}">
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
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($ticket->priority) }}</span>
                                                        @endif
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item priority-option" href="#" data-priority="low" data-ticket-id="{{ $ticket->id }}">Low</a></li>
                                                        <li><a class="dropdown-item priority-option" href="#" data-priority="medium" data-ticket-id="{{ $ticket->id }}">Medium</a></li>
                                                        <li><a class="dropdown-item priority-option" href="#" data-priority="high" data-ticket-id="{{ $ticket->id }}">High</a></li>
                                                        <li><a class="dropdown-item priority-option" href="#" data-priority="critical" data-ticket-id="{{ $ticket->id }}">Critical</a></li>
                                                        <li><a class="dropdown-item priority-option" href="#" data-priority="urgent" data-ticket-id="{{ $ticket->id }}">Urgent</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            @endif
                                            @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
                                            <td>
                                                <div class="status-dropdown">
                                                    <button type="button" class="btn btn-sm status-btn" data-bs-toggle="dropdown" data-ticket-id="{{ $ticket->id }}" data-current-status="{{ $ticket->status }}">
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
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @foreach($ticketStatuses as $status)
                                                            <li><a class="dropdown-item status-option" href="#" data-status="{{ $status->slug }}" data-ticket-id="{{ $ticket->id }}">{{ $status->name }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                            @endif
                                            <td>{{ $ticket->assignedTo ? $ticket->assignedTo->first_name . ' ' . $ticket->assignedTo->last_name : 'Unassigned' }}</td>
                                            <td class="text-end">
                                                <div class="dropdown-action">
                                                    @if($isSuperAdmin)
                                                        <a href="{{ \App\Helpers\RouteHelper::isCustomer() ?  route('customer.support-tickets.show', $ticket->id) : (\App\Helpers\RouteHelper::isStaff() ?  route('staff.support-tickets.show', $ticket->id)  :  route('admin.support-tickets.show', $ticket->id) ) }}" class="btn btn-sm btn-view-ticket">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                        @if($ticket->status !== 'closed' && ( ($ticket->assigned_to === null || $ticket->assigned_to === $currentUserId)))
                                                        <button type="button" class="btn btn-sm btn-assign-ticket" data-bs-toggle="modal" data-bs-target="#assignTicketModal" data-ticket-id="{{ $ticket->id }}" data-current-assigned="{{ $ticket->assigned_to ?? '' }}">
                                                            <i class="fa fa-user-plus"></i> Assign
                                                        </button>
                                                        @else
                                                        <button type="button" class="btn btn-sm btn-assign-ticket" disabled>
                                                            <i class="fa fa-user-plus"></i> Assign
                                                        </button>
                                                        @endif
                                                        <button type="button" class="btn btn-sm btn-transfer-ticket" data-bs-toggle="modal" data-bs-target="#superAdminTransferModal" data-ticket-id="{{ $ticket->id }}" data-current-assigned="{{ $ticket->assigned_to ?? '' }}" data-current-department="{{ $ticket->department ?? '' }}" data-current-category="{{ $ticket->department ?? '' }}">
                                                            <i class="fa fa-exchange-alt"></i> Transfer
                                                        </button>
                                                    @elseif($isStaff)
                                                        <a href="{{ route('staff.support-tickets.show', $ticket->id) }}" class="btn btn-sm btn-view-ticket">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-transfer-ticket" data-bs-toggle="modal" data-bs-target="#transferTicketModal" data-ticket-id="{{ $ticket->id }}" data-current-assigned="{{ $ticket->assigned_to ?? '' }}" data-current-department="{{ $ticket->department ?? '' }}">
                                                            <i class="fa fa-exchange-alt"></i> Transfer
                                                        </button>
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
                                
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="assignTicketModalLabel">
                                            Update Ticket Assignment
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
                    <div class="modal fade" id="superAdminTransferModal" tabindex="-1" role="dialog" aria-labelledby="superAdminTransferModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" id="superAdminTransferForm" action="">
                                    @csrf
                                    @method('patch')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="superAdminTransferModalLabel">
                                            Transfer Ticket
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            {{-- Support Ticket Category --}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="transferCategorySelect">
                                                        Ticket Category
                                                    </label>
                                                    <select class="form-control" name="category" id="transferCategorySelect">
                                                        <option value="">
                                                            Select Category
                                                        </option>
                                                        <option value="technical_support">Technical Support</option>
                                                        <option value="billing">Billing</option>
                                                        <option value="booking">Booking</option>
                                                        <option value="account">Account</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Department/Category --}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="transferDepartmentSelect">
                                                        Department
                                                    </label>
                                                    <select class="form-control" name="department" id="transferDepartmentSelect">
                                                        <option value="">
                                                            Select Department
                                                        </option>
                                                        @foreach($staffdepartments as $department)
                                                            <option value="{{ $department }}">
                                                                {{ $department }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Transfer To --}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="transferStaffSelect">
                                                        Transfer To
                                                    </label>
                                                    <select class="form-control" name="assigned_to" id="transferStaffSelect">
                                                        <option value="">
                                                            Select Staff Member
                                                        </option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-exchange-alt"></i>
                                            Transfer Ticket
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
                                            <th>Sr.no.</th>
                                            <th>Ticket ID</th>
                                            <th>Subject</th>
                                            <th>Category</th>
                                            @if($isStaff)<th>Priority</th>@endif
                                            @if($isStaff)<th>Status</th>@endif
                                            <th>Last Updated</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tickets as $ticket)
                                        <tr>                           <td>{{$ticket->id}}</td>
                                            <td>
                                                <span class="ticket-id-modern">#{{ $ticket->ticket_number }}</span>
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
                                            @if($isStaff)
                                            <td>
                                                <div class="priority-dropdown">
                                                    <button type="button" class="btn btn-sm priority-btn" data-bs-toggle="dropdown" data-ticket-id="{{ $ticket->id }}" data-current-priority="{{ $ticket->priority }}">
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
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($ticket->priority) }}</span>
                                                        @endif
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item priority-option" href="#" data-priority="low" data-ticket-id="{{ $ticket->id }}">Low</a></li>
                                                        <li><a class="dropdown-item priority-option" href="#" data-priority="medium" data-ticket-id="{{ $ticket->id }}">Medium</a></li>
                                                        <li><a class="dropdown-item priority-option" href="#" data-priority="high" data-ticket-id="{{ $ticket->id }}">High</a></li>
                                                        <li><a class="dropdown-item priority-option" href="#" data-priority="critical" data-ticket-id="{{ $ticket->id }}">Critical</a></li>
                                                        <li><a class="dropdown-item priority-option" href="#" data-priority="urgent" data-ticket-id="{{ $ticket->id }}">Urgent</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            @endif
                                            @if($isStaff)
                                            <td>
                                                <div class="status-dropdown">
                                                    <button type="button" class="btn btn-sm status-btn" data-bs-toggle="dropdown" data-ticket-id="{{ $ticket->id }}" data-current-status="{{ $ticket->status }}">
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
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @foreach($ticketStatuses as $status)
                                                            <li><a class="dropdown-item status-option" href="#" data-status="{{ $status->slug }}" data-ticket-id="{{ $ticket->id }}">{{ $status->name }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
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
                                                    @if($ticket->status !== 'closed' && ( ($ticket->assigned_to === null || $ticket->assigned_to === $currentUserId)))
                                                    <button type="button" class="btn btn-sm btn-assign-ticket" data-bs-toggle="modal" data-bs-target="#staffAssignModal" data-ticket-id="{{ $ticket->id }}" data-current-assigned="{{ $ticket->assigned_to ?? '' }}">
                                                        <i class="fa fa-user-plus"></i> Assign
                                                    </button>
                                                    @else
                                                    <button type="button" class="btn btn-sm btn-assign-ticket" disabled>
                                                        <i class="fa fa-user-plus"></i> Assign
                                                    </button>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-transfer-ticket" data-bs-toggle="modal" data-bs-target="#transferTicketModal" data-ticket-id="{{ $ticket->id }}" data-current-assigned="{{ $ticket->assigned_to ?? '' }}" data-current-department="{{ $ticket->department ?? '' }}" data-current-category="{{ $ticket->department ?? '' }}">
                                                        <i class="fa fa-exchange-alt"></i> Transfer
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
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
                    <div class="modal fade" id="staffAssignModal" tabindex="-1" role="dialog" aria-labelledby="staffAssignModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" id="staffAssignForm" action="">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staffAssignModalLabel">
                                            Assign Ticket
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            {{-- Assign To --}}
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="staffAssignSelect">
                                                        Assign To
                                                    </label>
                                                    <select class="form-control" name="assigned_to" id="staffAssignSelect">
                                                        <option value="">
                                                            Select Staff Member
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-user-plus"></i>
                                            Assign Ticket
                                        </button>
                                    </div>
                                </form>
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
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            {{-- Support Ticket Category --}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="transferCategoryStaffSelect">
                                                        Ticket Category
                                                    </label>
                                                    <select class="form-control" name="category" id="transferCategoryStaffSelect">
                                                        <option value="">
                                                            Select Category
                                                        </option>
                                                        <option value="technical_support">Technical Support</option>
                                                        <option value="billing">Billing</option>
                                                        <option value="booking">Booking</option>
                                                        <option value="account">Account</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Department --}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="transferDepartmentStaffSelect">
                                                        Department
                                                    </label>
                                                    <select class="form-control" name="department" id="transferDepartmentStaffSelect">
                                                        <option value="">
                                                            Select Department
                                                        </option>
                                                        @foreach($staffdepartments as $department)
                                                            <option value="{{ $department }}">
                                                                {{ $department }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Assign To --}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="transferStaffSelect2">
                                                        Transfer To
                                                    </label>
                                                    <select class="form-control" name="assigned_to" id="transferStaffSelect2">
                                                        <option value="">
                                                            Select Staff Member
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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

        /* Status and Priority Dropdown Styles */
        .status-dropdown,
        .priority-dropdown {
            position: relative;
            display: inline-block;
        }

        .status-btn,
        .priority-btn {
            padding: 4px 8px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .status-btn:hover,
        .priority-btn:hover {
            opacity: 0.8;
        }

        .status-btn:disabled,
        .priority-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .status-dropdown .dropdown-menu,
        .priority-dropdown .dropdown-menu {
            min-width: 150px;
            max-height: 300px;
            overflow-y: auto;
        }

        .status-option,
        .priority-option {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .status-option:hover,
        .priority-option:hover {
            background-color: #f8f9fa;
        }

        /* Transfer Button Styling */
        .btn-transfer-ticket {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            margin-left: 5px;
            transition: all 0.3s ease;
        }

        .btn-transfer-ticket:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
        }

        .btn-transfer-ticket:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
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
            @if(\App\Helpers\RouteHelper::isSuperAdmin())
            var staffByDepartmentRoute = '{{ route('admin.get-staff-by-department') }}';
            var updateStatusRoute = '{{ route('admin.support-tickets.update-status', ':ticketId') }}';
            var updateMethod = 'PATCH';
            @elseif(\App\Helpers\RouteHelper::isStaff())
            var staffByDepartmentRoute = '{{ route('staff.get-staff-by-department') }}';
            var updateStatusRoute = '{{ route('staff.support-tickets.update-status', ':ticketId') }}';
            var updateMethod = 'POST';
            @else
            var staffByDepartmentRoute = null;
            var updateStatusRoute = null;
            var updateMethod = 'PATCH';
            @endif

            @if($isSuperAdmin || $isStaff)
            $('#departmentSelect').on('change', function() {
                var departmentId = $(this).val();
                var staffSelect = $('#staffSelect');
                var currentAssignedTo = '{{ $ticket->assigned_to ?? '' }}';

                console.log('Department changed:', departmentId);
                console.log('Route URL:', staffByDepartmentRoute);

                // Show loading state
                staffSelect.html('<option value="">Loading...</option>');
                if (departmentId && staffByDepartmentRoute) {
                // Fetch staff members by department via AJAX
                    $.ajax({
                        url: staffByDepartmentRoute,
                        type: 'GET',
                        data: { department_id: departmentId.trim() },
                        success: function(response) {
                            console.log('Staff response:', response);
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
                            console.error('Error loading staff:', xhr);
                            console.error('Response status:', xhr.status);
                            console.error('Response text:', xhr.responseText);
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
            @endif

            @if($isSuperAdmin || $isStaff)
            $('#transferDepartmentSelect').on('change', function() {
                var departmentId = $(this).val();
                var transferStaffSelect = $('#transferStaffSelect');
                var currentAssignedTo = '';

                console.log('Transfer Department changed:', departmentId);
                console.log('Route URL:', staffByDepartmentRoute);

                // Show loading state
                transferStaffSelect.html('<option value="">Loading...</option>');
                if (departmentId && staffByDepartmentRoute) {
                // Fetch staff members by department via AJAX
                    $.ajax({
                        url: staffByDepartmentRoute,
                        type: 'GET',
                        data: { department_id: departmentId.trim() },
                        success: function(response) {
                            console.log('Staff response for transfer:', response);
                            transferStaffSelect.empty();
                            transferStaffSelect.append('<option value="">Select Staff Member</option>');
                            if (response.staff && response.staff.length > 0) {
                                response.staff.forEach(function(staff) {
                                    var selected = staff.id == currentAssignedTo ? 'selected' : '';
                                    transferStaffSelect.append('<option value="' + staff.id + '" ' + selected + '>' + staff.first_name + ' ' + staff.last_name + '</option>');
                                });
                            } else {
                                transferStaffSelect.append('<option value="">No staff members found</option>');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error loading staff for transfer:', xhr);
                            console.error('Response status:', xhr.status);
                            console.error('Response text:', xhr.responseText);
                            transferStaffSelect.empty();
                            transferStaffSelect.append('<option value="">Error loading staff</option>');
                        }
                    });
                } else {
                    // Reset to all staff members
                    transferStaffSelect.empty();
                    transferStaffSelect.append('<option value="">Select Staff Member</option>');
                    @foreach($staffMembers as $staff)
                        transferStaffSelect.append('<option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }}</option>');
                    @endforeach
                }
            });
            @endif

            @if($isSuperAdmin || $isStaff)
            $('#transferDepartmentStaffSelect').on('change', function() {
                var departmentId = $(this).val();
                var transferStaffSelect2 = $('#transferStaffSelect2');
                var currentAssignedTo = '';

                console.log('Transfer Department Staff changed:', departmentId);
                console.log('Route URL:', staffByDepartmentRoute);

                // Show loading state
                transferStaffSelect2.html('<option value="">Loading...</option>');
                if (departmentId && staffByDepartmentRoute) {
                // Fetch staff members by department via AJAX
                    $.ajax({
                        url: staffByDepartmentRoute,
                        type: 'GET',
                        data: { department_id: departmentId.trim() },
                        success: function(response) {
                            console.log('Staff response for transfer staff:', response);
                            transferStaffSelect2.empty();
                            transferStaffSelect2.append('<option value="">Select Staff Member</option>');
                            if (response.staff && response.staff.length > 0) {
                                response.staff.forEach(function(staff) {
                                    var selected = staff.id == currentAssignedTo ? 'selected' : '';
                                    transferStaffSelect2.append('<option value="' + staff.id + '" ' + selected + '>' + staff.first_name + ' ' + staff.last_name + '</option>');
                                });
                            } else {
                                transferStaffSelect2.append('<option value="">No staff members found</option>');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error loading staff for transfer staff:', xhr);
                            console.error('Response status:', xhr.status);
                            console.error('Response text:', xhr.responseText);
                            transferStaffSelect2.empty();
                            transferStaffSelect2.append('<option value="">Error loading staff</option>');
                        }
                    });
                } else {
                    // Reset to all staff members
                    transferStaffSelect2.empty();
                    transferStaffSelect2.append('<option value="">Select Staff Member</option>');
                    @foreach($staffMembers as $staff)
                        transferStaffSelect2.append('<option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }}</option>');
                    @endforeach
                }
            });
            @endif

            // Handle status change via dropdown
            $('.status-option').on('click', function(e) {
                e.preventDefault();
                var status = $(this).data('status');
                var ticketId = $(this).data('ticket-id');
                var button = $(this).closest('.status-dropdown').find('.status-btn');
                var currentStatus = button.data('current-status');

                if (status === currentStatus) {
                    return; // No change needed
                }

                if (!updateStatusRoute) {
                    console.error('Update status route not available');
                    return;
                }

                var url = updateStatusRoute.replace(':ticketId', ticketId);

                // Show loading state
                button.prop('disabled', true);
                button.find('.status-badge').text('Updating...');

                $.ajax({
                    url: url,
                    type: updateMethod,
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        // Update button data and UI
                        button.data('current-status', status);
                        var statusName = $(e.target).text();

                        // Find the status object to get the color
                        @php
                            $statusData = [];
                            foreach($ticketStatuses as $st) {
                                $statusData[$st->slug] = ['name' => $st->name, 'color' => $st->color];
                            }
                        @endphp

                        var statusData = @json($statusData);
                        if (statusData[status]) {
                            button.find('.status-badge').text(statusData[status].name);
                            button.find('.status-badge').css('background-color', statusData[status].color);
                        } else {
                            button.find('.status-badge').text(statusName);
                        }

                        // Show success message
                        alert('Status updated successfully!');
                    },
                    error: function(xhr) {
                        console.error('Error updating status:', xhr);
                        var errorMessage = 'Unknown error';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                var errorData = JSON.parse(xhr.responseText);
                                errorMessage = errorData.message || errorData.error || errorMessage;
                            } catch (e) {
                                errorMessage = xhr.responseText.substring(0, 200);
                            }
                        }
                        alert('Error updating status: ' + errorMessage);
                        // Reset button
                        button.prop('disabled', false);
                        button.find('.status-badge').text(currentStatus);
                    },
                    complete: function() {
                        button.prop('disabled', false);
                    }
                });
            });

            // Handle priority change via dropdown
            $('.priority-option').on('click', function(e) {
                e.preventDefault();
                var priority = $(this).data('priority');
                var ticketId = $(this).data('ticket-id');
                var button = $(this).closest('.priority-dropdown').find('.priority-btn');
                var currentPriority = button.data('current-priority');

                if (priority === currentPriority) {
                    return; // No change needed
                }

                if (!updateStatusRoute) {
                    console.error('Update status route not available');
                    return;
                }

                var url = updateStatusRoute.replace(':ticketId', ticketId);

                // Show loading state
                button.prop('disabled', true);
                button.find('.badge').text('Updating...');

                $.ajax({
                    url: url,
                    type: updateMethod,
                    data: {
                        _token: '{{ csrf_token() }}',
                        priority: priority
                    },
                    success: function(response) {
                        // Update button data and UI
                        button.data('current-priority', priority);

                        // Update badge color and text based on priority
                        var badgeClass = 'bg-secondary';
                        var priorityText = priority.charAt(0).toUpperCase() + priority.slice(1);

                        switch(priority) {
                            case 'low':
                                badgeClass = 'bg-success';
                                break;
                            case 'medium':
                                badgeClass = 'bg-primary';
                                break;
                            case 'high':
                            case 'critical':
                            case 'urgent':
                                badgeClass = 'bg-danger';
                                break;
                        }

                        button.find('.badge').removeClass().addClass('badge ' + badgeClass).text(priorityText);

                        // Show success message
                        alert('Priority updated successfully!');
                    },
                    error: function(xhr) {
                        console.error('Error updating priority:', xhr);
                        var errorMessage = 'Unknown error';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                var errorData = JSON.parse(xhr.responseText);
                                errorMessage = errorData.message || errorData.error || errorMessage;
                            } catch (e) {
                                errorMessage = xhr.responseText.substring(0, 200);
                            }
                        }
                        alert('Error updating priority: ' + errorMessage);
                        // Reset button
                        button.prop('disabled', false);
                        button.find('.badge').removeClass().addClass('badge bg-secondary').text(currentPriority);
                    },
                    complete: function() {
                        button.prop('disabled', false);
                    }
                });
            });

            // Handle assign ticket modal (SuperAdmin)
            const assignTicketModal = document.getElementById('assignTicketModal');
            if (assignTicketModal) {
                assignTicketModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const ticketId = button.getAttribute('data-ticket-id');
                    let actionUrl = "{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.update-status', ':ticketId') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.update-status', ':ticketId') : route('admin.support-tickets.update-status', ':ticketId')) }}"
                    actionUrl = actionUrl.replace(':ticketId', ticketId);
                    document.getElementById('assignTicketForm').action = actionUrl;

                    // Reset form
                    document.getElementById('assignTicketForm').reset();
                });
            }

            // Handle SuperAdmin transfer ticket modal
            const superAdminTransferModal = document.getElementById('superAdminTransferModal');
            if (superAdminTransferModal) {
                superAdminTransferModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const ticketId = button.getAttribute('data-ticket-id');
                    const currentCategory = button.getAttribute('data-current-category') || '';
                    const currentDepartment = button.getAttribute('data-current-department') || '';
                    const currentAssigned = button.getAttribute('data-current-assigned') || '';

                    let actionUrl = "{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.update-status', ':ticketId') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.update-status', ':ticketId') : route('customer.support-tickets.update-status', ':ticketId')) }}";
                    actionUrl = actionUrl.replace(':ticketId', ticketId);
                    document.getElementById('superAdminTransferForm').action = actionUrl;

                    // Set current values
                    document.getElementById('transferCategorySelect').value = currentCategory;
                    document.getElementById('transferDepartmentSelect').value = currentDepartment;
                    document.getElementById('transferStaffSelect').value = currentAssigned;
                });
            }

            // Handle staff assign ticket modal
            const staffAssignModal = document.getElementById('staffAssignModal');
            if (staffAssignModal) {
                staffAssignModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const ticketId = button.getAttribute('data-ticket-id');
                    const currentAssigned = button.getAttribute('data-current-assigned') || '';

                    let actionUrl = "{{ \App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.update-status', ':ticketId') : route('admin.support-tickets.update-status', ':ticketId') }}";
                    actionUrl = actionUrl.replace(':ticketId', ticketId);
                    document.getElementById('staffAssignForm').action = actionUrl;

                    // Set current value
                    document.getElementById('staffAssignSelect').value = currentAssigned;
                });
            }

            // Handle staff transfer ticket modal
            const transferTicketModal = document.getElementById('transferTicketModal');
            if (transferTicketModal) {
                transferTicketModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const ticketId = button.getAttribute('data-ticket-id');
                    const currentCategory = button.getAttribute('data-current-category') || '';
                    const currentDepartment = button.getAttribute('data-current-department') || '';
                    const currentAssigned = button.getAttribute('data-current-assigned') || '';

                    let actionUrl = "{{ $isSuperAdmin? route('admin.support-tickets.update-status', ':ticketId'): ($isStaff ? route('staff.support-tickets.update-status', ':ticketId'): route('customer.support-tickets.update-status', ':ticketId')) }}";
                    actionUrl = actionUrl.replace(':ticketId', ticketId);
                    document.getElementById('transferTicketForm').action = actionUrl;

                    // Set current values
                    document.getElementById('transferCategoryStaffSelect').value = currentCategory;
                    document.getElementById('transferDepartmentStaffSelect').value = currentDepartment;
                    document.getElementById('transferStaffSelect2').value = currentAssigned;
                });
            }

            // Handle SuperAdmin transfer form submission via AJAX
            $('#superAdminTransferForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                // Show loading state
                form.find('button[type="submit"]').prop('disabled', true).text('Transferring...');

                $.ajax({
                    url: url,
                    type: updateMethod,
                    data: formData,
                    success: function(response) {
                        alert('Ticket transferred successfully!');
                        $('#superAdminTransferModal').modal('hide');
                        // Reload page to show updated data
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error transferring ticket:', xhr);
                        var errorMessage = 'Unknown error';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                var errorData = JSON.parse(xhr.responseText);
                                errorMessage = errorData.message || errorData.error || errorMessage;
                            } catch (e) {
                                errorMessage = xhr.responseText.substring(0, 200);
                            }
                        }
                        alert('Error transferring ticket: ' + errorMessage);
                    },
                    complete: function() {
                        form.find('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-exchange-alt"></i> Transfer Ticket');
                    }
                });
            });

            // Handle staff assign form submission via AJAX
            $('#staffAssignForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                // Show loading state
                form.find('button[type="submit"]').prop('disabled', true).text('Assigning...');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Ticket assigned successfully!');
                        $('#staffAssignModal').modal('hide');
                        // Reload page to show updated data
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error assigning ticket:', xhr);
                        var errorMessage = 'Unknown error';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                var errorData = JSON.parse(xhr.responseText);
                                errorMessage = errorData.message || errorData.error || errorMessage;
                            } catch (e) {
                                errorMessage = xhr.responseText.substring(0, 200);
                            }
                        }
                        alert('Error assigning ticket: ' + errorMessage);
                    },
                    complete: function() {
                        form.find('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-user-plus"></i> Assign Ticket');
                    }
                });
            });

            // Handle staff transfer form submission via AJAX
            $('#transferTicketForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                // Show loading state
                form.find('button[type="submit"]').prop('disabled', true).text('Transferring...');

                $.ajax({
                    url: url,
                    type: updateMethod,
                    data: formData,
                    success: function(response) {
                        alert('Ticket transferred successfully!');
                        $('#transferTicketModal').modal('hide');
                        // Reload page to show updated data
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error transferring ticket:', xhr);
                        var errorMessage = 'Unknown error';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                var errorData = JSON.parse(xhr.responseText);
                                errorMessage = errorData.message || errorData.error || errorMessage;
                            } catch (e) {
                                errorMessage = xhr.responseText.substring(0, 200);
                            }
                        }
                        alert('Error transferring ticket: ' + errorMessage);
                    },
                    complete: function() {
                        form.find('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save"></i> Transfer');
                    }
                });
            });
        });
    </script>
@endsection