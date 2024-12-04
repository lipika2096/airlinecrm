@extends('admin/layouts/head-main')

@section('content')
    <title>Staff Reports</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Staff Reports</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Staff Reports</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Filter Form -->
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="report_type">Select Report Type</label>
                                <select name="report_type" class="form-control" onchange="document.getElementById('report-form').submit()">
                                    <option value="">Select Report Type</option>
                                    @foreach($ReportTypes as $type)
                                        <option value="{{ $type->name }}" {{ request('report_type') === $type->name ? 'selected' : '' }}>
                                            {{ ucfirst($type->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="from_date">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="to_date">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                            </div>

                        </div>


                            <div class="card" style="padding:10px;">
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="month">Month</label>
                                        <input type="number" name="month" id="month" class="form-control" min="1" max="12" value="{{ request('month') }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="year">Year</label>
                                        <input type="number" name="year" id="year" class="form-control" min="2000" value="{{ request('year') }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="staff_id">Staff ID</label>
                                        <input type="text" name="staff_id" id="staff_id" class="form-control" value="{{ request('staff_id') }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="staff_id">Date Range</label>
                                        <input type="text" name="date_range" id="date_range" class="form-control" value="{{ request('date_range') }}">
                                    </div>
                                    <div class="col-md-2 form-group" style="align-self: center; text-align: center;">
                                <label for="search"></label>
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Search</button>
                            </div>
                                </div>
                            </div>

                    </form>
                </div>
            </div>
            <!-- /Filter Form -->

            <!-- Results Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        @if($reportType === 'Holidays')
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Holiday Name</th>
                                        <th>Holiday Date</th>
                                        <th>Holiday Day</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staffReports as $index => $report)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $report->title }}</td>
                                            <td>{{ $report->holiday_date }}</td>
                                            <td>{{ \Carbon\Carbon::parse($report->holiday_date)->format('l') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                        <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        @if($reportType === 'On Leave')
                                        <th>Leave Type</th>
                                            @endif
                                       <th>Name</th>
                                        <th>Picture</th>
                                        <th>Airlines</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Staff No</th>
                                        <th>DOJ</th>
                                        <th>Min Hrs</th>
                                        <th>Max Hrs</th>
                                        @if($reportType === 'Overtime')
                                        <th>Overtime</th>
                                        @endif
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staffReports as $index => $report)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            @if($reportType === 'On Leave')
                                            <td>{{ $report->leave_type ?? 0 }}</td>
                                            @endif
                                            <td>{{ $report['user']->first_name }} {{ $report['user']->last_name }}</td>
                                            <td>
                                                @if(!empty($report->avatar_filename) && !empty($report->avatar_directory))
                                                    <img src="{{ asset('staff/storage/avatars/' . $report->avatar_directory . '/' . $report->avatar_filename) }}" alt="User Avatar">
                                                @else
                                                    <img src="{{ asset('public/assets/img/user.jpg') }}" alt="Default Avatar">
                                                @endif
                                            </td>
                                            <td>{{ $report->client_company_name ?? 'Null' }}</td>
                                            <td>{{ $report['user']->department }}</td>
                                            <td>{{ $report['user']->position }}</td>
                                            <td>{{ $report['user']->unique_id }}</td>
                                            <td>{{ $report['user']->joining_date }}</td>
                                            <td>{{ $report['user']->min_hrs }}</td>
                                            <td>{{ $report['user']->max_hrs }}</td>
                                            @if($reportType === 'Overtime')
                                            <td>{{ $report->overtime ?? 0 }}</td>
                                            @endif
                                            <td class="text-end">
                                                <div class="action-icons">
                                                    <a href="#" class="action-icon"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="action-icon"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn btn-white" id="print-account" onclick="window.print()">
                                                        <i class="fa fa-print fa-lg"></i> Print
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /Results Table -->
        </div>
    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>

$('input[name="date_range"]').daterangepicker();

</script>


@endsection
