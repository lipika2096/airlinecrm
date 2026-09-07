@extends('admin/layouts/head-main')
@section('title', 'Support Ticket Dashboard')
@section('content')

    @php
        use Carbon\Carbon;
        use Illuminate\Support\Str;
    @endphp

    <!-- Page Wrapper -->
    <div class="page-wrapper" style="background-color: #f8f9fa;">

        <!-- Main Content -->
        <div class="main-content" style="padding: 30px;">
            
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 style="margin: 0; color: #333; font-weight: 600;">Support Ticket Dashboard</h2>
                    <p style="margin: 5px 0 0 0; color: #666;">{{ Carbon::now()->format('l, d F Y') }}</p>
                </div>
                <!-- <div class="date-range-picker" style="background: white; padding: 10px 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <i class="fa fa-calendar" style="margin-right: 10px; color: #6a1b9a;"></i>
                    <span style="color: #333; font-weight: 500;">{{ now()->subDays(6)->format('d M') }} - {{ now()->format('d M Y') }}</span>
                </div> -->
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #6a1b9a;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">All Tickets</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $newTickets }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(106, 27, 154, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-ticket" style="color: #6a1b9a; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #2196f3;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Open Tickets</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $openTickets }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(33, 150, 243, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-folder-open" style="color: #2196f3; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #ff9800;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Pending Tickets</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $pendingTickets }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(255, 152, 0, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-clock" style="color: #ff9800; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #f44336;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Overdue</p>
                                <h3 style="margin: 5px 0 0 0; color: #f44336; font-weight: 700; font-size: 28px;">{{ $overdueTickets }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(244, 67, 54, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-exclamation-triangle" style="color: #f44336; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4caf50;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Resolved</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $resolvedTickets }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(76, 175, 80, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-check-circle" style="color: #4caf50; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #9e9e9e;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Closed</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $closedTickets }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(158, 158, 158, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-archive" style="color: #9e9e9e; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @if($isSuperAdmin)
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #00bcd4;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Avg. First Response</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $avgFirstResponse }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(0, 188, 212, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-bolt" style="color: #00bcd4; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #3f51b5;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Avg. Resolution Time</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $avgResolutionTime }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(63, 81, 181, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-hourglass-half" style="color: #3f51b5; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Recent Tickets Table -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="table-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 style="margin: 0; color: #333; font-weight: 600;">Latest 5 Tickets</h4>
                            <a href="{{ \App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') :(\App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.dashboard') : route('admin.support-tickets.index')) }}" class="btn btn-primary" style="background: #6a1b9a; border: none; border-radius: 6px; padding: 8px 16px;">
                                <i class="fa fa-list"></i> View All Tickets
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" style="margin: 0;">
                                <thead>
                                    <tr style="background: #f8f9fa;">
                                        <th style="border: none; padding: 12px; font-weight: 600; color: #333;">Ticket #</th>
                                        <th style="border: none; padding: 12px; font-weight: 600; color: #333;">Company</th>
                                        <th style="border: none; padding: 12px; font-weight: 600; color: #333;">Subject</th>
                                        <th style="border: none; padding: 12px; font-weight: 600; color: #333;">Category</th>
                                        <th style="border: none; padding: 12px; font-weight: 600; color: #333;">Priority</th>
                                        <th style="border: none; padding: 12px; font-weight: 600; color: #333;">Status</th>
                                        <th style="border: none; padding: 12px; font-weight: 600; color: #333;">Assigned To</th>
                                        <th style="border: none; padding: 12px; font-weight: 600; color: #333;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($recentTickets->count() > 0)
                                        @foreach($recentTickets as $ticket)
                                            <tr style="border-bottom: 1px solid #e9ecef;">
                                                <td style="padding: 12px; vertical-align: middle;">
                                                    <a href="{{ route('admin.support-tickets.show', $ticket->id) }}" style="color: #6a1b9a; text-decoration: none; font-weight: 500;">
                                                        {{ $ticket->ticket_number }}
                                                    </a>
                                                </td>
                                                <td style="padding: 12px; vertical-align: middle;">
                                                    {{ $ticket->company_name ?? ($ticket->creator && $ticket->creator->adminDetail ? $ticket->creator->adminDetail->company_name : ($ticket->creator ? $ticket->creator->name : 'Unknown')) }}
                                                </td>
                                                <td style="padding: 12px; vertical-align: middle;">
                                                    {{ Str::limit($ticket->subject, 50) }}
                                                </td>
                                                <td style="padding: 12px; vertical-align: middle;">
                                                    {{ $ticket->department ? ucfirst(str_replace('_', ' ', $ticket->department)) : 'N/A' }}
                                                </td>
                                                <td style="padding: 12px; vertical-align: middle;">
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
                                                <td style="padding: 12px; vertical-align: middle;">
                                                    @php
                                                        $dashboardStatus = $ticketStatuses->where('slug', $ticket->status)->first();
                                                    @endphp
                                                    @if($dashboardStatus)
                                                        <span class="badge" style="background-color: {{ $dashboardStatus->color }}; color: white; padding: 6px 12px; border-radius: 12px; font-size: 12px;">{{ $dashboardStatus->name }}</span>
                                                    @else
                                                        <span class="badge" style="background: #f5f5f5; color: #616161; padding: 6px 12px; border-radius: 12px; font-size: 12px;">{{ ucfirst($ticket->status) }}</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 12px; vertical-align: middle;">
                                                    {{ $ticket->assignedTo ? $ticket->assignedTo->first_name . ' ' . $ticket->assignedTo->last_name : 'Unassigned' }}
                                                </td>
                                                <td style="padding: 12px; vertical-align: middle;">
                                                    <a href="{{ \App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.show', $ticket->id) :(\App\Helpers\RouteHelper::isCustomer() ? route('customer.support-tickets.show', $ticket->id) : route('admin.support-tickets.show', $ticket->id)) }}" class="btn btn-sm btn-outline-primary" style="border-color: #6a1b9a; color: #6a1b9a; border-radius: 4px;">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" style="text-align: center; padding: 30px; color: #666;">
                                                <i class="fa fa-inbox" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                                                <p style="margin: 0;">No recent tickets found.</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
            const topDepartmentsLabels = @json($topDepartmentsData['labels'] ?? []);
            const topDepartmentsData = @json($topDepartmentsData['data'] ?? []);

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

            // Top Departments Chart
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
