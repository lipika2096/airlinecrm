@extends('admin/layouts/head-main')
@section('content')
    <title>My Created Tickets</title>

    @php
        $createRoute = route('staff.support-tickets.create');
        $showRouteBase = 'staff.support-tickets.show';
    @endphp

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">My Created Tickets</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('staff.support-tickets.dashboard') }}">Support Ticket Dashboard</a></li>
                            <li class="breadcrumb-item active">My Created Tickets</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ $createRoute }}" class="btn add-btn"><i class="fa fa-plus"></i> Create Ticket</a>
                    </div>  
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Filters -->
            <div class="row filter-row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('staff.support-tickets.my-created') }}">
                                <div class="row align-items-end">
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Search</label>
                                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search tickets...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('staff.support-tickets.my-created') }}" class="btn btn-secondary btn-sm">
                                            <i class="fa fa-refresh"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sr. no.</th>
                                            <th>Ticket #</th>
                                            <th>Subject</th>
                                            <th>Category</th>
                                            @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
                                            <th>Priority</th>
                                            @endif
                                            @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
                                            <th>Status</th>
                                            @endif
                                            <th>Assigned To</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($tickets->count() > 0)
                                            @foreach($tickets as $ticket)
                                                <tr>
                                                    <td> {{$ticket->id}} </td>
                                                    <td>
                                                        <a href="{{ route($showRouteBase, $ticket->id) }}">
                                                            {{ $ticket->ticket_number }}
                                                        </a>
                                                    </td>
                                                    <td>{{ Str::limit($ticket->subject, 50) }}</td>
                                                    <td>{{ $ticket->department ? ucfirst(str_replace('_', ' ', $ticket->department)) : 'N/A' }}</td>
                                                    @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
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
                                                    @endif
                                                    @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
                                                    <td>
                                                        @php
                                                            $status = $ticketStatuses->where('slug', $ticket->status)->first();
                                                        @endphp
                                                        @if($status)
                                                            <span class="badge" style="background-color: {{ $status->color }}; color: white;">{{ $status->name }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($ticket->status) }}</span>
                                                        @endif
                                                    </td>
                                                    @endif
                                                    <td>{{ $ticket->assignedTo ? $ticket->assignedTo->first_name . ' ' . $ticket->assignedTo->last_name : 'Unassigned' }}</td>
                                                    <td>{{ \App\Helpers\TimezoneHelper::format($ticket->created_at, 'M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route($showRouteBase, $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">No tickets found.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            {{ $tickets->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
