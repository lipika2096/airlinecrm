@extends('admin/layouts/head-main')
@section('title', 'Super Admin Dashboard')
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
                    <h2 style="margin: 0; color: #333; font-weight: 600;">Super Admin Dashboard</h2>
                    <p style="margin: 5px 0 0 0; color: #666;">{{ Carbon::now()->format('l, d F Y') }}</p>
                </div>
                <!-- <div class="date-range-picker" style="background: white; padding: 10px 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <i class="fa fa-calendar" style="margin-right: 10px; color: #6a1b9a;"></i>
                    <span style="color: #333; font-weight: 500;">{{ now()->subDays(6)->format('d M') }} - {{ now()->format('d M Y') }}</span>
                </div> -->
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <h4>Support Tickets</h4>
                <div class="col-lg-2 col-md-6 mb-3">
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
                <div class="col-lg-2 col-md-6 mb-3">
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
                <div class="col-lg-2 col-md-6 mb-3">
                    <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #ff9800;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p style="margin: 0; color: #666; font-size: 14px;">Pending</p>
                                <h3 style="margin: 5px 0 0 0; color: #333; font-weight: 700; font-size: 28px;">{{ $pendingTickets }}</h3>
                            </div>
                            <div class="icon" style="background: rgba(255, 152, 0, 0.1); padding: 15px; border-radius: 50%;">
                                <i class="fa fa-clock" style="color: #ff9800; font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-3">
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
                <div class="col-lg-2 col-md-6 mb-3">
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
                <div class="col-lg-2 col-md-6 mb-3">
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
