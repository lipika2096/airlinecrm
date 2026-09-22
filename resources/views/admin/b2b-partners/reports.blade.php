@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <title>B2B Partner Reports</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .report-card {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }
            .report-card h3 {
                font-size: 2rem;
                font-weight: bold;
            }
            .report-card p {
                margin: 0;
                opacity: 0.9;
            }
            .report-icon {
                font-size: 2.5rem;
                opacity: 0.8;
            }
            .report-type-card {
                background: white;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                padding: 20px;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s;
            }
            .report-type-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            }
            .report-type-card .icon {
                font-size: 2rem;
                color: #ff9b44;
                margin-bottom: 10px;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">B2B Partner Reports</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.dashboard') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : route('staff.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners') : route('staff.b2b-partners')) }}">B2B Partners</a></li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <!-- Filters -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.reports') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners.reports') : route('staff.b2b-partners.reports')) }}" method="GET" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Date Range</label>
                                    <select name="date_range" class="form-select">
                                        <option value="">All Time</option>
                                        <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                        <option value="last_3_months" {{ request('date_range') == 'last_3_months' ? 'selected' : '' }}>Last 3 Months</option>
                                        <option value="last_6_months" {{ request('date_range') == 'last_6_months' ? 'selected' : '' }}>Last 6 Months</option>
                                        <option value="last_year" {{ request('date_range') == 'last_year' ? 'selected' : '' }}>Last Year</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Partner Type</label>
                                    <select name="partner_type" class="form-select">
                                        <option value="">All Types</option>
                                        <option value="Travel Agent" {{ request('partner_type') == 'Travel Agent' ? 'selected' : '' }}>Travel Agent</option>
                                        <option value="Tour Operator" {{ request('partner_type') == 'Tour Operator' ? 'selected' : '' }}>Tour Operator</option>
                                        <option value="Corporate" {{ request('partner_type') == 'Corporate' ? 'selected' : '' }}>Corporate</option>
                                        <option value="TMC" {{ request('partner_type') == 'TMC' ? 'selected' : '' }}>TMC</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.reports') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners.reports') : route('staff.b2b-partners.reports')) }}" class="btn btn-secondary w-100">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="col-md-3">
                    <div class="report-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3>{{ $reportData['total_partners'] }}</h3>
                                <p>Total Partners</p>
                            </div>
                            <div class="report-icon">
                                <i class="fa fa-building"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="report-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3>{{ $reportData['active_partners'] }}</h3>
                                <p>Active Partners</p>
                            </div>
                            <div class="report-icon">
                                <i class="fa fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="report-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3>{{ $reportData['total_bookings'] }}</h3>
                                <p>Total Bookings</p>
                            </div>
                            <div class="report-icon">
                                <i class="fa fa-ticket"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="report-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3>₹{{ number_format($reportData['total_revenue'], 2) }}</h3>
                                <p>Total Revenue</p>
                            </div>
                            <div class="report-icon">
                                <i class="fa fa-rupee"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Types -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Generate Reports</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="report-type-card" onclick="generateReport('booking')">
                                        <div class="icon">
                                            <i class="fa fa-file-alt"></i>
                                        </div>
                                        <h6>Booking Report</h6>
                                        <p class="text-muted small">Partner booking statistics</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="report-type-card" onclick="generateReport('revenue')">
                                        <div class="icon">
                                            <i class="fa fa-chart-line"></i>
                                        </div>
                                        <h6>Revenue Report</h6>
                                        <p class="text-muted small">Partner revenue analysis</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="report-type-card" onclick="generateReport('performance')">
                                        <div class="icon">
                                            <i class="fa fa-chart-bar"></i>
                                        </div>
                                        <h6>Partner Performance</h6>
                                        <p class="text-muted small">Performance metrics</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="report-type-card" onclick="generateReport('tsa')">
                                        <div class="icon">
                                            <i class="fa fa-shield-alt"></i>
                                        </div>
                                        <h6>TSA Status Report</h6>
                                        <p class="text-muted small">TSA compliance status</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Partners -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Top Performing Partners</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Partner Name</th>
                                            <th>Partner Code</th>
                                            <th>Type</th>
                                            <th>Total Bookings</th>
                                            <th>Total Passengers</th>
                                            <th>Revenue (INR)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($reportData['top_partners'] as $partner)
                                            <tr>
                                                <td>{{ $partner->partner_name }}</td>
                                                <td>{{ $partner->partner_code }}</td>
                                                <td>{{ $partner->partner_type }}</td>
                                                <td>{{ $partner->total_bookings }}</td>
                                                <td>{{ $partner->total_passengers }}</td>
                                                <td>₹{{ number_format($partner->revenue, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $partner->status == 'Active' ? 'success' : ($partner->status == 'Pending' ? 'warning' : 'danger') }}">
                                                        {{ $partner->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No partners found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Partners by Type -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Partners by Type</h5>
                            <div class="row">
                                @foreach ($reportData['partners_by_type'] as $type => $count)
                                    <div class="col-md-3">
                                        <div class="alert alert-info">
                                            <strong>{{ $type }}:</strong> {{ $count }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function generateReport(reportType) {
            const dateRange = document.querySelector('select[name="date_range"]').value;
            const partnerType = document.querySelector('select[name="partner_type"]').value;

            $.ajax({
                url: '{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route("admin.b2b-partners.generate-report") : (\App\Helpers\RouteHelper::isCustomer() ? route("customer.b2b-partners.generate-report") : route("staff.b2b-partners.generate-report")) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    report_type: reportType,
                    date_range: dateRange,
                    partner_type: partnerType
                },
                success: function(response) {
                    if (response.success) {
                        displayReport(response.data, response.report_type);
                    } else {
                        alert('Error generating report');
                    }
                },
                error: function() {
                    alert('Error generating report');
                }
            });
        }

        function displayReport(data, reportType) {
            let html = '<div class="table-responsive"><table class="table table-striped"><thead><tr>';
            
            // Get headers from first row
            if (data.length > 0) {
                Object.keys(data[0]).forEach(key => {
                    html += '<th>' + key + '</th>';
                });
            }
            html += '</tr></thead><tbody>';

            // Add data rows
            data.forEach(row => {
                html += '<tr>';
                Object.values(row).forEach(value => {
                    html += '<td>' + value + '</td>';
                });
                html += '</tr>';
            });

            html += '</tbody></table></div>';

            // Show in modal
            const modalHtml = `
                <div class="modal fade" id="reportModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${reportType}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ${html}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            $('#reportModal').remove();
            
            // Add new modal
            $('body').append(modalHtml);
            
            // Show modal
            new bootstrap.Modal(document.getElementById('reportModal')).show();
        }
    </script>
@endsection
