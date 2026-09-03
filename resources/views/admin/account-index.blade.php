@extends('admin/layouts/head-main')
@section('title', 'Account Dashboard')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">
    <style>
        .metric-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .metric-card h5 {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
        }
        .metric-card h3 {
            color: #333;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        .metric-card.profit h3 {
            color: #28a745;
        }
        .metric-card.outstanding h3 {
            color: #dc3545;
        }
        .chart-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            min-height: 300px;
        }
        .chart-card h5 {
            color: #333;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .chart-card .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
        .table-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .table-card h5 {
            color: #333;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .table-card table {
            margin-bottom: 0;
        }
        .table-card table th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
    </style>

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Account Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Accounts</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Key Metrics -->
        <div class="row">
            <div class="col-md-4">
                <div class="metric-card">
                    <h5>TODAY'S SALES</h5>
                    <h3>€ {{ number_format($todaySales ?? 0, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric-card profit">
                    <h5>TODAY'S PROFIT</h5>
                    <h3>€ {{ number_format($todayProfit ?? 0, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric-card outstanding">
                    <h5>OUTSTANDING</h5>
                    <h3>€ {{ number_format($outstanding ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>

        <!-- Financial Overview -->
        <div class="row">
            <div class="col-md-4">
                <div class="metric-card">
                    <h5>CASH IN HAND</h5>
                    <h3>€ {{ number_format($cashInHand ?? 0, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric-card">
                    <h5>BANK BALANCE</h5>
                    <h3>€ {{ number_format($bankBalance ?? 0, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric-card">
                    <h5>UPCOMING TRIPS</h5>
                    <h3>{{ $upcomingTrips ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-card">
                    <h5>Sales This Month</h5>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-card">
                    <h5>Profit This Month</h5>
                    <div class="chart-container">
                        <canvas id="profitChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables -->
        <div class="row">
            <div class="col-md-6">
                <div class="table-card">
                    <h5>Recent Bookings</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recentBookings) && $recentBookings->count() > 0)
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>{{ $booking->booking_id ?? 'N/A' }}</td>
                                            <td>{{ $booking->customer_name ?? 'N/A' }}</td>
                                            <td>€ {{ number_format($booking->amount ?? 0, 2) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">No recent bookings</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="table-card">
                    <h5>Recent Payments</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Payment ID</th>
                                    <th>Payer</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recentPayments) && $recentPayments->count() > 0)
                                    @foreach($recentPayments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_id ?? 'N/A' }}</td>
                                            <td>{{ $payment->payer_name ?? 'N/A' }}</td>
                                            <td>€ {{ number_format($payment->amount ?? 0, 2) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">No recent payments</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($salesLabels ?? []),
            datasets: [{
                label: 'Sales',
                data: @json($salesData ?? []),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                fill: true,
                //tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Profit Chart
    const profitCtx = document.getElementById('profitChart').getContext('2d');
    new Chart(profitCtx, {
        type: 'line',
        data: {
            labels: @json($profitLabels ?? []),
            datasets: [{
                label: 'Profit',
                data: @json($profitData ?? []),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                fill: true,
                //tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
