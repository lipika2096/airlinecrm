@extends('admin/layouts/head-main')
@section('content')
    <title>Leaves</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Leaves</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Leaves</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_leave"><i
                                class="fa fa-plus"></i> Add Leave</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Leave Statistics -->
            <div class="row">
                <div class="col-md-4">
                    <div class="stats-info">
                        <h6>Today Presents</h6>
                        <h4>{{ $noofpresentemployeestoday }} / {{ $total_employee }}</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-info">
                        <h6>Total Leaves</h6>
                        <h4>{{ $total_leaves }} <span>Today</span></h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-info">
                        <h6>Pending Requests</h6>
                        <h4>{{ $total_pending_leaves }}</h4>
                    </div>
                </div>
            </div>
            <!-- /Leave Statistics -->
            <div class="card tab-box">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item">
                                <a href="#new-leaves" data-bs-toggle="tab" class="nav-link active">New Leaves</a>
                            </li>
                            <li class="nav-item">
                                <a href="#approved-leaves" data-bs-toggle="tab" class="nav-link">Approved Leaves</a>
                            </li>
                            <li class="nav-item">
                                <a href="#pending-leaves" data-bs-toggle="tab" class="nav-link">Pending Leaves</a>
                            </li>
                            <li class="nav-item">
                                <a href="#rejected-leaves" data-bs-toggle="tab" class="nav-link">Rejected Leaves</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <!-- Profile Info Tab -->
                <div id="new-leaves" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>No of Days</th>
                                            <th class="text-danger">Total Annual Leaves</th>
                                            <th class="text-danger">Available Leaves</th>
                                            <th>Reason</th>
                                            <th>Date Of Application</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employee_leaves as $data)
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="#">{{ $data->user->first_name }}
                                                            {{ $data->user->last_name }} </a>
                                                    </h2>
                                                </td>
                                                <td>{{ $data->leave_type }}</td>
                                                <td>{{ $data->from }}</td>
                                                <td>{{ $data->to }}</td>
                                                <td>{{ $data->no_of_days }} days</td>

                                                @php
                                                    $annualLeave = $data->user->leave_count;
                                                    $currentYear = now()->year;
                                                    $fromYear = \Carbon\Carbon::parse($data->from)->year;
                                                    $toYear = \Carbon\Carbon::parse($data->to)->year;
                                                    $usedAnnualLeave = 0;

                                                    if ($fromYear == $toYear && $fromYear == $currentYear) {
                                                        // Both from and to years are the current year
                                                        $usedAnnualLeave = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->sum('no_of_days');
                                                    } else {
                                                        // Handle when either fromYear or toYear is not equal to the current year
                                                        $usedAnnualLeave = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->orWhereYear('to', $toYear)
                                                            ->sum('no_of_days');

                                                        $leave_bal_lastyear = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->sum('no_of_days');

                                                        $annualLeave -= $leave_bal_lastyear;

                                                    }

                                                    $remainingLeave = $annualLeave - $usedAnnualLeave;
                                                @endphp
                                                <td class="text-danger">{{ $annualLeave }} leaves</td>
                                                <td class="text-danger">{{ $remainingLeave }} leaves left for {{$fromYear}}</td>
                                                <td>
                                                    @php
                                                        $wordCount = str_word_count($data->reason);
                                                    @endphp
                                                    @if ($wordCount > 5)
                                                        {{ implode(' ', array_slice(explode(' ', $data->reason), 0, 2)) }}...
                                                        <a href="#readmore1{{ $data->id }}" data-bs-toggle="modal" data-bs-target="#readmore{{ $data->id }}" class="text-danger">Read More</a>
                                                    @else
                                                        {{ $data->reason }}
                                                    @endif
                                                </td>
                                                <td>{{$data->created_at}}</td>
                                                <td class="text-center">
                                                    <div class="dropdown action-label">
                                                        @if ($data->status == 1)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approve_leave{{ $data->id }}"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-purple"></i> New
                                                            </a>
                                                        @elseif($data->status == 2)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approve_leave{{ $data->id }}"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-info"></i> Pending
                                                            </a>
                                                        @elseif($data->status == 3)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i> Approved
                                                            </a>
                                                        @else
                                                            <a class="btn btn-white btn-sm btn-rounded " href="#"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Read more Modal -->
                                            <div id="readmore{{ $data->id }}" class="modal custom-modal fade" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header pb-0">
                                                            <h5 class="modal-title">Reason</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body pt-0">
                                                        <p>{{$data->reason}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Read more Modal -->
                                            <!-- Approve Leave Modal -->
                                            <div class="modal custom-modal fade" id="approve_leave{{ $data->id }}"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action ="{{ route('admin.leaves.update', ['id' => $data->id]) }}#new-leaves">
                                                                @method('PATCH') @csrf
                                                                <div class="form-group">
                                                                    <label>Update Leave Status <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="select form-control" name="status">
                                                                        <option value="3">Approve</option>
                                                                        <option value="2">Pending</option>
                                                                        <option value="4">Decline</option>
                                                                        <option value="1">New</option>
                                                                    </select>
                                                                </div>
                                                                <div class="submit-section">
                                                                    <button
                                                                        class="btn btn-primary submit-btn">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Approve Leave Modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="pending-leaves" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>No of Days</th>
                                            <th class="text-danger">Total Annual Leaves</th>
                                            <th class="text-danger">Available Leaves</th>
                                            <th>Reason</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pending_employee_leaves as $data)
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="#">{{ $data->user->first_name }}
                                                            {{ $data->user->last_name }} </a>
                                                    </h2>
                                                </td>
                                                <td>{{ $data->leave_type }}</td>
                                                <td>{{ $data->from }}</td>
                                                <td>{{ $data->to }}</td>
                                                <td>{{ $data->no_of_days }} days</td>

                                                @php
                                                    $annualLeave = $data->user->leave_count;
                                                    $currentYear = now()->year;
                                                    $fromYear = \Carbon\Carbon::parse($data->from)->year;
                                                    $toYear = \Carbon\Carbon::parse($data->to)->year;
                                                    $usedAnnualLeave = 0;

                                                    if ($fromYear == $toYear && $fromYear == $currentYear) {
                                                        // Both from and to years are the current year
                                                        $usedAnnualLeave = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->sum('no_of_days');
                                                    } else {
                                                        // Handle when either fromYear or toYear is not equal to the current year
                                                        $usedAnnualLeave = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->orWhereYear('to', $toYear)
                                                            ->sum('no_of_days');

                                                        $leave_bal_lastyear = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->sum('no_of_days');

                                                        $annualLeave -= $leave_bal_lastyear;

                                                    }

                                                    $remainingLeave = $annualLeave - $usedAnnualLeave;
                                                @endphp
                                                <td class="text-danger">{{ $annualLeave }} leaves</td>
                                                <td class="text-danger">{{ $remainingLeave }} leaves left for {{$fromYear}}</td>
                                                <td>
                                                    @php
                                                        $wordCount = str_word_count($data->reason);
                                                    @endphp
                                                    @if ($wordCount > 5)
                                                        {{ implode(' ', array_slice(explode(' ', $data->reason), 0, 2)) }}...
                                                        <a href="#readmore1{{ $data->id }}" data-bs-toggle="modal" data-bs-target="#readmore{{ $data->id }}" class="text-danger">Read More</a>
                                                    @else
                                                        {{ $data->reason }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown action-label">
                                                        @if ($data->status == 1)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approve_leave{{ $data->id }}"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-purple"></i> New
                                                            </a>
                                                        @elseif($data->status == 2)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approve_leave{{ $data->id }}"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-info"></i> Pending
                                                            </a>
                                                        @elseif($data->status == 3)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i> Approved
                                                            </a>
                                                        @else
                                                            <a class="btn btn-white btn-sm btn-rounded " href="#"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Read more Modal -->
                                            <div id="readmore{{ $data->id }}" class="modal custom-modal fade" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header pb-0">
                                                            <h5 class="modal-title">Reason</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body pt-0">
                                                        <p>{{$data->reason}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Read more Modal -->
                                            <!-- Approve Leave Modal -->
                                            <div class="modal custom-modal fade" id="approve_leave{{ $data->id }}"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action ="{{ route('admin.leaves.update', ['id' => $data->id]) }} #pending-leaves">
                                                                @method('PATCH') @csrf
                                                                <div class="form-group">
                                                                    <label>Update Leave Status <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="select form-control" name="status">
                                                                        <option value="3">Approve</option>
                                                                        <option value="2">Pending</option>
                                                                        <option value="4">Decline</option>
                                                                        <option value="1">New</option>
                                                                    </select>
                                                                </div>
                                                                <div class="submit-section">
                                                                    <button
                                                                        class="btn btn-primary submit-btn">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Approve Leave Modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="approved-leaves" class="pro-overview tab-pane fade show">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>No of Days</th>
                                            <th class="text-danger">Total Annual Leaves</th>
                                            <th class="text-danger">Available Leaves</th>
                                            <th>Reason</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($approved_employee_leaves as $data)
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="#">{{ $data->user->first_name }}
                                                            {{ $data->user->last_name }} </a>
                                                    </h2>
                                                </td>
                                                <td>{{ $data->leave_type }}</td>
                                                <td>{{ $data->from }}</td>
                                                <td>{{ $data->to }}</td>
                                                <td>{{ $data->no_of_days }} days</td>
                                                @php
                                                    $annualLeave = $data->user->leave_count;
                                                    $currentYear = now()->year;
                                                    $fromYear = \Carbon\Carbon::parse($data->from)->year;
                                                    $toYear = \Carbon\Carbon::parse($data->to)->year;
                                                    $usedAnnualLeave = 0;

                                                    if ($fromYear == $toYear && $fromYear == $currentYear) {
                                                        // Both from and to years are the current year
                                                        $usedAnnualLeave = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->sum('no_of_days');
                                                    } else {
                                                        // Handle when either fromYear or toYear is not equal to the current year
                                                        $usedAnnualLeave = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->orWhereYear('to', $toYear)
                                                            ->sum('no_of_days');

                                                        $leave_bal_lastyear = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->sum('no_of_days');

                                                        $annualLeave -= $leave_bal_lastyear;

                                                    }

                                                    $remainingLeave = $annualLeave - $usedAnnualLeave;
                                                @endphp
                                                <td class="text-danger">{{ $annualLeave }} leaves</td>
                                                <td class="text-danger">{{ $remainingLeave }} leaves left for {{$fromYear}}</td>
                                                <td>
                                                    @php
                                                        $wordCount = str_word_count($data->reason);
                                                    @endphp
                                                    @if ($wordCount > 5)
                                                        {{ implode(' ', array_slice(explode(' ', $data->reason), 0, 2)) }}...
                                                        <a href="#readmore1{{ $data->id }}" data-bs-toggle="modal" data-bs-target="#readmore{{ $data->id }}" class="text-danger">Read More</a>
                                                    @else
                                                        {{ $data->reason }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown action-label">
                                                        @if ($data->status == 1)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approve_leave{{ $data->id }}"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-purple"></i> New
                                                            </a>
                                                        @elseif($data->status == 2)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approve_leave{{ $data->id }}"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-info"></i> Pending
                                                            </a>
                                                        @elseif($data->status == 3)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i> Approved
                                                            </a>
                                                        @else
                                                            <a class="btn btn-white btn-sm btn-rounded " href="#"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Read more Modal -->
                                            <div id="readmore{{ $data->id }}" class="modal custom-modal fade" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header pb-0">
                                                            <h5 class="modal-title">Reason</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body pt-0">
                                                        <p>{{$data->reason}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Read more Modal -->
                                            <!-- Approve Leave Modal -->
                                            <div class="modal custom-modal fade" id="approve_leave{{ $data->id }}"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action ="{{ route('admin.leaves.update', ['id' => $data->id]) }}#approved-leaves">
                                                                @method('PATCH') @csrf
                                                                <div class="form-group">
                                                                    <label>Update Leave Status <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="select form-control" name="status">
                                                                        <option value="3">Approve</option>
                                                                        <option value="2">Pending</option>
                                                                        <option value="4">Decline</option>
                                                                        <option value="1">New</option>
                                                                    </select>
                                                                </div>
                                                                <div class="submit-section">
                                                                    <button
                                                                        class="btn btn-primary submit-btn">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Approve Leave Modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="rejected-leaves" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>No of Days</th>
                                            <th class="text-danger">Total Annual Leaves</th>
                                            <th class="text-danger">Available Leaves</th>
                                            <th>Reason</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rejected_employee_leaves as $data)
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="#">{{ $data->user->first_name }}
                                                            {{ $data->user->last_name }} </a>
                                                    </h2>
                                                </td>
                                                <td>{{ $data->leave_type }}</td>
                                                <td>{{ $data->from }}</td>
                                                <td>{{ $data->to }}</td>
                                                <td>{{ $data->no_of_days }} days</td>

                                                @php
                                                    $annualLeave = $data->user->leave_count;
                                                    $currentYear = now()->year;
                                                    $fromYear = \Carbon\Carbon::parse($data->from)->year;
                                                    $toYear = \Carbon\Carbon::parse($data->to)->year;
                                                    $usedAnnualLeave = 0;

                                                    if ($fromYear == $toYear && $fromYear == $currentYear) {
                                                        // Both from and to years are the current year
                                                        $usedAnnualLeave = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->sum('no_of_days');
                                                    } else {
                                                        // Handle when either fromYear or toYear is not equal to the current year
                                                        $usedAnnualLeave = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->orWhereYear('to', $toYear)
                                                            ->sum('no_of_days');

                                                        $leave_bal_lastyear = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)
                                                            ->where('status', 3)
                                                            ->where('leave_type', 'Annual Leave')
                                                            ->whereYear('from', $fromYear)
                                                            ->sum('no_of_days');

                                                        $annualLeave -= $leave_bal_lastyear;

                                                    }

                                                    $remainingLeave = $annualLeave - $usedAnnualLeave;
                                                @endphp
                                                <td class="text-danger">{{ $annualLeave }} leaves</td>
                                                <td class="text-danger">{{ $remainingLeave }} leaves left for {{$fromYear}}</td>
                                                <td>
                                                    @php
                                                        $wordCount = str_word_count($data->reason);
                                                    @endphp
                                                    @if ($wordCount > 5)
                                                        {{ implode(' ', array_slice(explode(' ', $data->reason), 0, 2)) }}...
                                                        <a href="#readmore1{{ $data->id }}" data-bs-toggle="modal" data-bs-target="#readmore{{ $data->id }}" class="text-danger">Read More</a>
                                                    @else
                                                        {{ $data->reason }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown action-label">
                                                        @if ($data->status == 1)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approve_leave{{ $data->id }}"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-purple"></i> New
                                                            </a>
                                                        @elseif($data->status == 2)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approve_leave{{ $data->id }}"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-info"></i> Pending
                                                            </a>
                                                        @elseif($data->status == 3)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i> Approved
                                                            </a>
                                                        @else
                                                            <a class="btn btn-white btn-sm btn-rounded " href="#"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Read more Modal -->
                                            <div id="readmore{{ $data->id }}" class="modal custom-modal fade" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header pb-0">
                                                            <h5 class="modal-title">Reason</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body pt-0">
                                                        <p>{{$data->reason}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Read more Modal -->
                                            <!-- Approve Leave Modal -->
                                            <div class="modal custom-modal fade" id="approve_leave{{ $data->id }}"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action ="{{ route('admin.leaves.update', ['id' => $data->id]) }}#rejected-leaves">
                                                                @method('PATCH') @csrf
                                                                <div class="form-group">
                                                                    <label>Update Leave Status <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="select form-control" name="status">
                                                                        <option value="3">Approve</option>
                                                                        <option value="2">Pending</option>
                                                                        <option value="4">Decline</option>
                                                                        <option value="1">New</option>
                                                                    </select>
                                                                </div>
                                                                <div class="submit-section">
                                                                    <button
                                                                        class="btn btn-primary submit-btn">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Approve Leave Modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Leave Modal -->
        <div id="add_leave" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leave</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action ="{{ route('admin.leaves.store') }}">@csrf
                            <div class="form-group">
                                <label>Select Employee <span class="text-danger">*</span></label>
                                <select class="select form-control" name="employee_id">
                                    <option>Select Employee</option>
                                    @foreach ($employees as $data)
                                        <option value="{{ $data->id }}">{{ $data->first_name }}
                                            {{ $data->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <select class="select form-control" name="leave_type">
                                    <option>Select Leave Type</option>
                                    @foreach ($leavetypes as $leavetype)
                                        <option value="{{ $leavetype->name }}">
                                            {{ $leavetype->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="">
                                    <input class="form-control " id="from" type="date" name="from"
                                        onchange="calculateDays()">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="">
                                    <input class="form-control" id="to" type="date" name="to"
                                        onchange="calculateDays()">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Number of days <span class="text-danger">*</span></label>
                                <input class="form-control" readonly type="text" name="no_of_days">
                            </div>
                            <!--<div class="form-group">-->
                            <!--    <label>Remaining Leaves <span class="text-danger">*</span></label>-->
                            <!--    <input class="form-control" readonly value="12" type="text">-->
                            <!--</div>-->
                            <div class="form-group">
                                <label>Leave Reason</label>
                                <textarea rows="4" name="reason" class="form-control"></textarea>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Leave Modal -->

        <!-- Delete Leave Modal -->
        <div class="modal custom-modal fade" id="delete_approve" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Leave</h3>
                            <p>Are you sure want to delete this leave?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal"
                                        class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Leave Modal -->

    </div>
    <!-- /Page Wrapper -->

    <script>
        function calculateDays() {
            const fromDate = document.querySelector('input[name="from"]').value;
            const toDate = document.querySelector('input[name="to"]').value;
            const noOfDaysInput = document.querySelector('input[name="no_of_days"]');

            if (fromDate && toDate) {

                var startDate = new Date(fromDate);
                var endDate = new Date(toDate);

                const baseUrl = "{{ url('/admin') }}";
                fetch(baseUrl + '/get-holidays')
                    .then(response => response.json())

                    .then(holidays => {

                        var holidayDates = holidays.map(holiday => new Date(holiday.holiday_date).toDateString());
                        var diffDays = 0;
                        for (var date = new Date(startDate); date <= endDate; date.setDate(date.getDate() + 1)) {

                            if (date.getDay() !== 0 && date.getDay() !== 6 && !holidayDates.includes(date
                                    .toDateString())) {
                                diffDays++;
                            }
                        }

                        noOfDaysInput.value = diffDays;
                    })
                    .catch(error => console.error('Error fetching holidays:', error));
            }
        }

        // Function to ensure the date input meets the requirements
        document.getElementById('from').addEventListener('input', function() {
            const dateInput = this;
            const today = new Date();
            const currentYear = today.getFullYear();
            const currentDate = today.toISOString().split('T')[0]; // Gets current date in YYYY-MM-DD format

            // Set the minimum date to today's date
            dateInput.setAttribute('min', currentDate);

            // Check if the entered date has a valid year
            const enteredDate = new Date(dateInput.value);
            if (enteredDate.getFullYear() > currentYear || enteredDate.getFullYear() < 1000) {
                alert("Please enter a valid year between 1000 and the current year.");
                dateInput.value = ''; // Clear the invalid input
            }
        });

        // Function to ensure the date input meets the requirements
        document.getElementById('to').addEventListener('input', function() {
            const dateInput = this;
            const today = new Date();
            const currentYear = today.getFullYear();
            const currentDate = today.toISOString().split('T')[0]; // Gets current date in YYYY-MM-DD format

            // Set the minimum date to today's date
            dateInput.setAttribute('min', currentDate);

            // Check if the entered date has a valid year
            const enteredDate = new Date(dateInput.value);
            if (enteredDate.getFullYear() < currentYear) {
                alert("Please enter a valid year either with current year or with future year.");
                dateInput.value = ''; // Clear the invalid input
            }
        });
    </script>
@endsection
