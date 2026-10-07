@extends('admin/layouts/head-main')
@section('title', 'Support Tickets Report')
@section('content')

    @php
        use Illuminate\Support\Str;
    @endphp

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Support Tickets Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.reports.support-tickets') }}">Reports</a></li>
                            <li class="breadcrumb-item active">Support Tickets</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Filter Tickets</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.support-tickets.generate') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control select">
                                        <option value="">All Statuses</option>
                                        @foreach($ticketStatuses as $status)
                                            <option value="{{ $status->slug }}" {{ $statusFilter == $status->slug ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i> Generate Report
                                        </button>
                                        @if(isset($tickets) && $tickets->count() > 0)
                                        <a href="{{ route('admin.reports.support-tickets.download', [
                                            'status' => $statusFilter ?? '',
                                            'start_date' => $startDate ?? '',
                                            'end_date' => $endDate ?? ''
                                        ]) }}" class="btn btn-success">
                                            <i class="fa fa-download"></i> Download CSV
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Table -->
            @if(isset($tickets))
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Report Results
                        @if($tickets->count() > 0)
                        <span class="badge badge-info">{{ $tickets->count() }} tickets found</span>
                        @else
                        <span class="badge badge-warning">No tickets found</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if($tickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Ticket Number</th>
                                    <th>Subject</th>
                                    <th>Department</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Assigned To</th>
                                    <th>Company</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                <tr>
                                    <td><a href="{{\App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.show', $ticket->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.show', $ticket->id) : route('customer.support-tickets.show', $ticket->id))}}">{{ $ticket->ticket_number }}</a></td>
                                    <td>{{ Str::limit($ticket->subject, 50) }}</td>
                                    <td>{{ $ticket->department }}</td>
                                    <td>
                                        <span class="badge badge-{{ $ticket->priority == 'high' ? 'danger' : ($ticket->priority == 'medium' ? 'warning' : 'info') }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($ticket->ticketStatus)
                                        <span class="badge" style="background-color: {{ $ticket->ticketStatus->color ?? '#6c757d' }};">
                                            {{ $ticket->ticketStatus->name }}
                                        </span>
                                        @else
                                        <span class="badge badge-secondary">{{ ucfirst($ticket->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->creator_name }}</td>
                                    <td>
                                        @if($ticket->assignedTo)
                                            {{ $ticket->assignedTo->name ?? $ticket->assignedTo->first_name . ' ' . $ticket->assignedTo->last_name }}
                                        @else
                                            <span class="text-muted">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->company_name ?? 'N/A' }}</td>
                                    <td>{{ $ticket->created_at ? $ticket->created_at->format('d M Y H:i') : 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No tickets found matching your criteria.</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

    </div>

@endsection
