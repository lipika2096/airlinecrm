@extends('admin/layouts/head-main')
@section('content')
    <title>Unassigned Tickets</title>

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
                        <h3 class="page-title">Unassigned Tickets</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('staff.support-tickets.dashboard') }}">Support Ticket Dashboard</a></li>
                            <li class="breadcrumb-item active">Unassigned Tickets</li>
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
                            <form method="GET" action="{{ route('staff.support-tickets.unassigned') }}">
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
                                        <a href="{{ route('staff.support-tickets.unassigned') }}" class="btn btn-secondary btn-sm">
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
                            <div class="table-responsive-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <!-- <th>Sr. no. </th> -->
                                            <th>Ticket #</th>
                                            <th>Subject</th>
                                            <th>Category</th>
                                            @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
                                            <th>Priority</th>
                                            @endif
                                            @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
                                            <th>Status</th>
                                            @endif
                                            <th>Created By</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($tickets->count() > 0)
                                            @foreach($tickets as $ticket)
                                                <tr>
                                                    <!-- <td> {{$ticket->id}} </td> -->
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
                                                    <td>{{ $ticket->creator ? $ticket->creator->first_name . ' ' . $ticket->creator->last_name : 'Unknown' }}</td>
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

    <style>
        /* Responsive Design */
        @media (max-width: 768px) {
            .filter-row .row {
                flex-direction: column;
            }

            .filter-row .col-md-3,
            .filter-row .col-md-2 {
                width: 100%;
                margin-bottom: 10px;
            }

            .filter-row button {
                width: 100%;
                margin: 5px 0;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table thead th {
                padding: 8px 6px;
                font-size: 11px;
            }

            table tbody td {
                padding: 8px 6px;
                font-size: 12px;
            }

            .badge {
                font-size: 10px;
                padding: 4px 6px;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 11px;
            }
        }

        @media (max-width: 576px) {
            .filter-row button {
                font-size: 12px;
            }

            table {
                font-size: 11px;
            }

            .btn-outline-primary {
                width: 100%;
            }
        }

        /* Table Responsive Container for Zoom */
        .table-responsive-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            position: relative;
        }

        .table-responsive-responsive table {
            min-width: 800px;
            width: 100%;
        }

        /* Zoom level specific table fixes */
        @media screen and (max-width: 1200px) {
            .table-responsive-responsive table {
                min-width: 700px;
            }
        }

        @media screen and (max-width: 992px) {
            .table-responsive-responsive table {
                min-width: 600px;
            }

            table thead th,
            table tbody td {
                padding: 6px 4px;
                font-size: 12px;
            }
        }

        @media screen and (max-width: 768px) {
            .table-responsive-responsive table {
                min-width: 500px;
            }

            table thead th,
            table tbody td {
                padding: 5px 3px;
                font-size: 11px;
            }
        }

        @media screen and (max-width: 576px) {
            .table-responsive-responsive table {
                min-width: 400px;
            }

            table thead th,
            table tbody td {
                padding: 4px 2px;
                font-size: 10px;
            }
        }

        /* Custom scrollbar for table */
        .table-responsive-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-responsive-responsive::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .table-responsive-responsive::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endsection
