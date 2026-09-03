@extends('admin/layouts/head-main')
@section('title', 'Admin Dashboard')
@section('content')

    @php
        use Carbon\Carbon;
    @endphp

    <!-- Page Wrapper -->
    <div class="page-wrapper" style="background-color: #f8f9fa;">

        <!-- Main Content -->
        <div class="main-content" style="padding: 30px;">
            
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 style="margin: 0; color: #333; font-weight: 600; text-transform: capitalize;">Welcome, {{$user->name}}</h2>
                    <p style="margin: 5px 0 0 0; color: #666;">{{ $user->company_name ?? 'CRM SAAS' }}</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.create'): route('staff.support-tickets.create') }}" class="btn btn-primary" style="background-color: #0066cc; border-color: #0066cc;">
                        <i class="fa fa-plus me-2"></i> New Ticket
                    </a>
                    <div class="user-avatar">
                        <img src="{{ asset('assets/img/profiles/avatar-02.jpg') }}" alt="User Avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #0066cc;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px; font-weight: 500;">My Bookings</p>
                                <h3 style="margin: 8px 0 0 0; color: #333; font-weight: 700; font-size: 32px;">{{ $myBookings ?? 0 }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(0, 102, 204, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-plane" style="color: #0066cc; font-size: 24px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #ff9800;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px; font-weight: 500;">Pending Invoices</p>
                                <h3 style="margin: 8px 0 0 0; color: #333; font-weight: 700; font-size: 32px;">{{ $pendingInvoices ?? 0 }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(255, 152, 0, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-file-invoice" style="color: #ff9800; font-size: 24px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #f44336;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px; font-weight: 500;">Outstanding</p>
                                <h3 style="margin: 8px 0 0 0; color: #333; font-weight: 700; font-size: 32px;">€{{ number_format($outstandingAmount ?? 0, 2) }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(244, 67, 54, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-euro-sign" style="color: #f44336; font-size: 24px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Overview -->
            <div class="row mb-4">
                <div class="col-12">
                    <h4 style="margin: 0 0 20px 0; color: #333; font-weight: 600;">Support Overview</h4>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 2px solid #ffc107;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px; font-weight: 500;">Open Tickets</p>
                                <h3 style="margin: 8px 0 0 0; color: #333; font-weight: 700; font-size: 32px;">{{ $openTickets ?? 0 }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(255, 193, 7, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-folder-open" style="color: #ffc107; font-size: 24px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 2px solid #ff9800;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px; font-weight: 500;">Pending Tickets</p>
                                <h3 style="margin: 8px 0 0 0; color: #333; font-weight: 700; font-size: 32px;">{{ $pendingTickets ?? 0 }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(255, 152, 0, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-clock" style="color: #ff9800; font-size: 24px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 2px solid #4caf50;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px; font-weight: 500;">Closed Tickets</p>
                                <h3 style="margin: 8px 0 0 0; color: #333; font-weight: 700; font-size: 32px;">{{ $closedTickets ?? 0 }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(76, 175, 80, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-check-circle" style="color: #4caf50; font-size: 24px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Tickets -->
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: none;">
                        <div class="card-body" style="padding: 25px;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 style="margin: 0; color: #333; font-weight: 600;">Recent Tickets</h4>
                                @if($isSuperAdmin)
                                <a href="{{ route('admin.support-tickets.index') }}" style="color: #0066cc; text-decoration: none; font-weight: 500;">View All Tickets</a>
                                @elseif($isStaff)
                                <a href="{{ route('staff.support-tickets.dashboard') }}" style="color: #0066cc; text-decoration: none; font-weight: 500;">View All Tickets</a>
                                @else
                                <a href="{{ route('customer.support-tickets.dashboard') }}" style="color: #0066cc; text-decoration: none; font-weight: 500;">View All Tickets</a>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover" style="margin: 0;">
                                    <thead>
                                        <tr style="background-color: #f8f9fa;">
                                            <th style="padding: 15px; font-weight: 600; color: #333; border: none;">TICKET ID</th>
                                            <th style="padding: 15px; font-weight: 600; color: #333; border: none;">SUBJECT</th>
                                            <th style="padding: 15px; font-weight: 600; color: #333; border: none;">DEPARTMENT</th>
                                            <th style="padding: 15px; font-weight: 600; color: #333; border: none;">STATUS</th>
                                            <th style="padding: 15px; font-weight: 600; color: #333; border: none;">UPDATED</th>
                                            <th style="padding: 15px; font-weight: 600; color: #333; border: none;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($recentTickets && $recentTickets->count() > 0)
                                            @foreach($recentTickets as $ticket)
                                                <tr style="border-bottom: 1px solid #eee;">
                                                    <td style="padding: 15px; color: #333; font-weight: 500;">#{{ $ticket->ticket_number ?? $ticket->id }}</td>
                                                    <td style="padding: 15px; color: #666;">{{ $ticket->subject }}</td>
                                                    <td style="padding: 15px; color: #666;">{{ ucfirst(str_replace('_', ' ', $ticket->department ?? 'General')) }}</td>
                                                    <td style="padding: 15px;">
                                                        @php
                                                            $statusClass = match($ticket->status ?? 'open') {
                                                                'open' => 'bg-warning',
                                                                'in_progress' => 'bg-info',
                                                                'resolved' => 'bg-success',
                                                                'closed' => 'bg-secondary',
                                                                default => 'bg-primary'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $statusClass }}" style="padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">{{ ucfirst($ticket->status ?? 'Open') }}</span>
                                                    </td>
                                                    <td style="padding: 15px; color: #666;">{{ $ticket->updated_at ? Carbon::parse($ticket->updated_at)->diffForHumans() : 'N/A' }}</td>
                                                    <td>
                                                        @if($isSuperAdmin)
                                                        <a href="{{ route('admin.support-tickets.show', $ticket->id) }}" class="btn btn-sm btn-view-ticket">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    @elseif($isStaff)
                                                        <a href="{{ route('staff.support-tickets.show', $ticket->id) }}" class="btn btn-sm btn-view-ticket">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    @else
                                                        <a href="{{ route('customer.support-tickets.show', $ticket->id) }}" class="btn btn-sm btn-view-ticket">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" style="padding: 30px; text-align: center; color: #999;">
                                                    <i class="fa fa-ticket" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                                    <p style="margin: 0;">No recent tickets found</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection