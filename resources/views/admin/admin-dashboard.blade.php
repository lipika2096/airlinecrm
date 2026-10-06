@extends('admin/layouts/head-main')
@section('title', 'Dashboard')
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
                    <h2 style="margin: 0; color: #333; font-weight: 600;">Welcome, {{ auth('admin')->check() ? auth('admin')->user()->name : auth()->user()->first_name ." ".auth()->user()->last_name}}</h2>
                    <p style="margin: 5px 0 0 0; color: #666;">{{ Carbon::now()->format('l, d F Y') }}</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <!-- <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.create'): route('staff.support-tickets.create') }}" class="btn btn-primary" style="background-color: #6a1b9a; border-color: #6a1b9a;">
                        <i class="fa fa-plus me-2"></i> New Ticket
                    </a> -->
                    <div class="user-avatar">
                        <img src="{{ asset('assets/img/profiles/avatar-02.jpg') }}" alt="User Avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    </div>
                </div>
            </div>

            <!-- Statistics Cards
            <div class="row mb-4">
                <h4>My Bookings</h4>
                <div class="col-lg-2 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #6a1b9a;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Total Bookings</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $myBookings ?? 0 }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(106, 27, 154, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-plane" style="color: #6a1b9a; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #ff9800;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Pending Invoices</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $pendingInvoices ?? 0 }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(255, 152, 0, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-file-text-o" style="color: #ff9800; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #f44336;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Outstanding</p>
                                <h3 style="margin: 5px 0 0 0; color: #f44336; font-weight: 700; font-size: 28px;">€{{ number_format($outstandingAmount ?? 0, 2) }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(244, 67, 54, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-euro-sign" style="color: #f44336; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Support Tickets Statistics -->
            <div class="row mb-4">
                <h4>Support Tickets</h4>
                <div class="col-lg-2 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #2196f3;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Open Tickets</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $openTickets ?? 0 }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(33, 150, 243, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-folder-open" style="color: #2196f3; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @if(\App\Helpers\RouteHelper::isStaff())
                <div class="col-lg-2 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #ff9800;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Pending</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $pendingTickets ?? 0 }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(255, 152, 0, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-clock" style="color: #ff9800; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-lg-2 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4caf50;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Resolved</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $closedTickets ?? 0 }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(76, 175, 80, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-check-circle" style="color: #4caf50; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="chart-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <h4 style="margin: 0 0 20px 0; color: #333; font-weight: 600;">Tickets Overview</h4>
                        <div style="height: 300px;">
                            <canvas id="ticketsOverviewChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="chart-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <h4 style="margin: 0 0 20px 0; color: #333; font-weight: 600;">Ticket Categories</h4>
                        <div style="height: 300px;">
                            <canvas id="topDepartmentsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Tickets Table -->
            <!-- <div class="row">
                <div class="col-12">
                    <div class="card" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: none;">
                        <div class="card-body" style="padding: 25px;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 style="margin: 0; color: #333; font-weight: 600;">Recent Tickets</h4>
                                @if($isStaff)
                                <a href="{{ route('staff.support-tickets.dashboard') }}" style="color: #6a1b9a; text-decoration: none; font-weight: 500;">View All Tickets</a>
                                @else
                                <a href="{{ route('customer.support-tickets.dashboard') }}" style="color: #6a1b9a; text-decoration: none; font-weight: 500;">View All Tickets</a>
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
                                                    <td style="padding: 15px; color: #333; font-weight: 500;">{{ $ticket->ticket_number ?? $ticket->id }}</td>
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
                                                        @if($isStaff)
                                                        <a href="{{ route('staff.support-tickets.show', $ticket->id) }}" class="btn btn-sm" style="background-color: #6a1b9a; color: white; border: none;">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                        @else
                                                        <a href="{{ route('customer.support-tickets.show', $ticket->id) }}" class="btn btn-sm" style="background-color: #6a1b9a; color: white; border: none;">
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
            </div> -->

        </div>

    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Safe JSON data from PHP
            const ticketsOverviewLabels = @json($ticketsOverviewData['labels'] ?? []);
            const ticketsOverviewNew = @json($ticketsOverviewData['new_tickets'] ?? []);
            const ticketsOverviewResolved = @json($ticketsOverviewData['resolved_tickets'] ?? []);
            const ticketsOverviewClosed = @json($ticketsOverviewData['closed_tickets'] ?? []);
            const topDepartmentsLabels = @json($ticketCategoriesData['labels'] ?? []);
            const topDepartmentsData = @json($ticketCategoriesData['data'] ?? []);

            // Tickets Overview Chart
            const ticketsCtx = document.getElementById('ticketsOverviewChart');
            if (ticketsCtx) {
                new Chart(ticketsCtx, {
                    type: 'line',
                    data: {
                        labels: ticketsOverviewLabels,
                        datasets: [{
                            label: 'Open',
                            data: ticketsOverviewNew,
                            borderColor: '#6a1b9a',
                            backgroundColor: 'rgba(106, 27, 154, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Closed',
                            data: ticketsOverviewClosed,
                            borderColor: '#f44336',
                            backgroundColor: 'rgba(244, 67, 54, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Ticket Categories Chart
            const deptCtx = document.getElementById('topDepartmentsChart');
            if (deptCtx) {
                new Chart(deptCtx, {
                    type: 'doughnut',
                    data: {
                        labels: topDepartmentsLabels,
                        datasets: [{
                            data: topDepartmentsData,
                            backgroundColor: [
                                '#6a1b9a',
                                '#2196f3',
                                '#ff9800',
                                '#4caf50',
                                '#9e9e9e',
                                '#f44336',
                                '#00bcd4',
                                '#3f51b5'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
                });
            }
        });
    </script>

@endsection