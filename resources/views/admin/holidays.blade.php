@extends('admin/layouts/head-main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        .submit-section {
            margin-top: 10px !important;
        }

        .toggle-dropdown,
        .toggle-close {
            cursor: pointer;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
        }

        .toggle-dropdown i,
        .toggle-close i {
            font-size: 16px;
            color: white;
        }
    </style>
    <!-- Page Wrapper -->
    <div class="page-wrapper">


        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header" style="margin-bottom: 10px;">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title"></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Holidays & Leaves</li>
                        </ul>
                    </div>

                    <div class="card tab-box" style="margin-top: 20px;">
                        <div class="row user-tabs">
                            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="nav-item"><a href="#overview" data-bs-toggle="tab"
                                            class="nav-link active">Overview</a>
                                    </li>
                                    <li class="nav-item"><a href="#holidays" data-bs-toggle="tab"
                                            class="nav-link ">Holidays</a>
                                    </li>
                                    <li class="nav-item"><a href="#teams" data-bs-toggle="tab" class="nav-link">Teams</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->

            <div class="tab-content">

                <div id="holidays" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-auto float-end ms-auto" style="margin-bottom: 10px;">

                            <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_event"><i
                                    class="fa fa-plus"></i> Add Holiday</a>

                        </div>
                        <div class="view-toggle" style="margin-bottom: 10px;">

                            <button onclick="toggleView('list')" class="btn calendar-btn list-view"><i
                                    class="fa fa-list"></i></button>
                            <button onclick="toggleView('calendar')" class="btn calendar-btn calendar-view"><i
                                    class="fa fa-calendar" aria-hidden="true"></i></button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-0">
                                <div class="card-body" id="calendar-view" style="display: none">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <!-- Calendar -->
                                            <div id="calendar"></div>
                                            <!-- /Calendar -->

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="list-view">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <!-- Calendar -->
                                            <div class="month-list">
                                                <button class="active" onclick="activateMonth(this, 0)">Jan</button>
                                                <button onclick="activateMonth(this, 1)">Feb</button>
                                                <button onclick="activateMonth(this, 2)">Mar</button>
                                                <button onclick="activateMonth(this, 3)">Apr</button>
                                                <button onclick="activateMonth(this, 4)">May</button>
                                                <button onclick="activateMonth(this, 5)">Jun</button>
                                                <button onclick="activateMonth(this, 6)">Jul</button>
                                                <button onclick="activateMonth(this, 7)">Aug</button>
                                                <button onclick="activateMonth(this, 8)">Sep</button>
                                                <button onclick="activateMonth(this, 9)">Oct</button>
                                                <button onclick="activateMonth(this, 10)">Nov</button>
                                                <button onclick="activateMonth(this, 11)">Dec</button>
                                            </div>
                                            <div class="section">
                                                <div class="section-header">
                                                    <h2>Holiday List</h2>

                                                </div>
                                                <table class="table table-striped custom-table mb-0 datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Country</th>
                                                            <th>State</th>
                                                            <th>Holiday Name</th>
                                                            <th>Holiday Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="events-table-body">
                                                        @foreach ($holidays as $data)
                                                            <tr
                                                                data-month="{{ date('n', strtotime($data->holiday_date)) - 1 }}">

                                                                <td>{{ $data->id }}</td>
                                                                <td>{{ $data->country }}</td>
                                                                <td>{{ $data->state }}</td>
                                                                <td>{{ $data->title }}</td>
                                                                <td>{{ $data->holiday_date }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /Calendar -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /Page Content -->

                    <!-- Add Holiday Modal -->
                    <div id="add_event" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Holiday</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.holidays.store') }}" method="POST">
                                        @csrf <!-- Include CSRF token -->

                                        <div class="form-group">
                                            <label>Country <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control" name="country" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>State <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control" name="state" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Holiday Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="title" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Holiday Date <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control" name="holiday_date" type="datetime-local">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Category</label>
                                            <select class="select form-control" name="category">
                                                <option value='bg-danger'>Danger</option>
                                                <option value='bg-success'>Success</option>
                                                <option value='bg-purple'>Purple</option>
                                                <option value='bg-primary'>Primary</option>
                                                <option value='bg-pink'>Pink</option>
                                                <option value='bg-info'>Info</option>
                                                <option value='bg-inverse'>Inverse</option>
                                                <option value='bg-orange'>Orange</option>
                                                <option value='bg-brown'>Brown</option>
                                                <option value='bg-teal'>Teal</option>
                                                <option value='bg-warning'>Warning</option>
                                            </select>
                                        </div>
                                        <div class="submit-section">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Add Event Modal -->

                    <!-- Event Modal -->
                    <div class="modal custom-modal fade" id="event-modal">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Event</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer text-center">
                                    <button type="button" class="btn btn-success submit-btn save-event">Create
                                        event</button>
                                    <button type="button" class="btn btn-danger submit-btn delete-event"
                                        data-bs-dismiss="modal">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Event Modal -->

                    <!-- Add Category Modal-->
                    <div class="modal custom-modal fade" id="add-category">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add a category</h4>
                                </div>
                                <div class="modal-body p-20">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label">Category Name</label>
                                                <input class="form-control" placeholder="Enter name" type="text"
                                                    name="category-name">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label">Choose Category Color</label>
                                                <select class="form-control form-select"
                                                    data-placeholder="Choose a color..." name="category-color">
                                                    <option value="success">Success</option>
                                                    <option value="danger">Danger</option>
                                                    <option value="info">Info</option>
                                                    <option value="pink">Pink</option>
                                                    <option value="primary">Primary</option>
                                                    <option value="warning">Warning</option>
                                                    <option value="orange">Orange</option>
                                                    <option value="brown">Brown</option>
                                                    <option value="teal">Teal</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger save-category"
                                        data-bs-dismiss="modal">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Add Category Modal-->
                </div>

                <div id="overview" class="pro-overview tab-pane fade show active">

                    <div class="content container-fluid">

                        <div class="page-header">
                            <h3 class="page-title">Staff Leave Overview</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Designation</th>
                                                <th>Department</th>
                                                <th>Contact</th>
                                                <th>Leave Account</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $data)
                                                <tr>
                                                    <td>{{ $data->user->first_name }}</td>
                                                    <td>{{ $data->user->last_name }}</td>
                                                    <td>{{ $data->user->position }}</td>
                                                    <td>{{ $data->user->department }}</td>
                                                    <td><b>Phone No.:</b> {{ $data->user->phone }} <br /> <b>Email:</b>
                                                        {{ $data->user->email }}</td>
                                                    @php
                                                        $annualLeave = $data->user->leave_count;
                                                        $usedAnnualLeave = App\Models\EmployeeLeave::where(
                                                            'employee_id',
                                                            $data->user->id,
                                                        )
                                                            ->where('status', 3)
                                                            ->sum('no_of_days');
                                                        $remainingLeave = $annualLeave - $usedAnnualLeave;
                                                    @endphp
                                                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                                    <script>
                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            var ctx = document.getElementById('leaveProgress_' + {{ $data->user->id }}).getContext('2d');

                                                            // Get dynamic values
                                                            var usedLeave = {{ $usedAnnualLeave }};
                                                            var totalLeave = {{ $data->user->leave_count ?? 0 }};
                                                            var remainingLeave = totalLeave - usedLeave;

                                                            // Create the chart
                                                            new Chart(ctx, {
                                                                type: 'doughnut',
                                                                data: {
                                                                    labels: ['Used Leave', 'Remaining Leave'],
                                                                    datasets: [{
                                                                        data: [usedLeave, remainingLeave > 0 ? remainingLeave : 0],
                                                                        backgroundColor: ['#4CAF50', '#E0E0E0'], // Colors for used and remaining
                                                                        borderWidth: 0
                                                                    }]
                                                                },
                                                                options: {
                                                                    responsive: true,
                                                                    cutout: '70%', // Creates the inner gap for text
                                                                    plugins: {
                                                                        tooltip: {
                                                                            enabled: false
                                                                        },
                                                                        legend: {
                                                                            display: false
                                                                        }
                                                                    }
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                    <td class="text-danger">
                                                        <div style="position: relative; width: 100px; height: 100px;">
                                                            <canvas id="leaveProgress_{{ $data->user->id }}"></canvas>
                                                            <div
                                                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 14px;">
                                                                {{ $usedAnnualLeave }}/{{ $data->user->leave_count ?? 0 }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div id="teams" class="pro-overview tab-pane fade show ">
                    <!-- Page Content -->
                    <div class="content container-fluid">

                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">My Teams </h3>
                                </div>
                                <div class="col-auto float-end ms-auto">

                                    <a class="btn add-btn ms-2" data-bs-toggle="modal" data-bs-target="#new_absence"><i
                                            class="fa fa-plus"></i> New Absence</a>
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#report_sick"><i
                                            class="fa fa-plus"></i> Report Sick</a>

                                    <!-- Request Absence Modal -->
                                    <div id="new_absence" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Request Absence</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post"
                                                        action ="{{ route('admin.newabsence.store') }}#leaves">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Select Employee <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="select form-control"
                                                                        name="employee_id">
                                                                        <option>Select Employee</option>
                                                                        @foreach ($employees as $data)
                                                                            <option value="{{ $data->id }}">
                                                                                {{ $data->first_name }}
                                                                                {{ $data->last_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Absence type</label>
                                                                    <select class="form-control select" name="leave_type">
                                                                        @foreach ($leavetypes as $leavetype)
                                                                            <option value="{{ $leavetype->name }}">
                                                                                {{ $leavetype->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">From</label>
                                                                    <input class="form-control" type="date"
                                                                        name="from" onchange="calculateDays()">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Until</label>
                                                                    <input class="form-control" type="date"
                                                                        name="to" onchange="calculateDays()">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Number of days <span
                                                                            class="text-danger">*</span></label>
                                                                    <input class="form-control" readonly type="text"
                                                                        name="no_of_days">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group d-flex">
                                                                    <input type="checkbox" name="half" id="half-day">
                                                                    <label class="col-form-label ms-3">Half Day </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group d-flex">
                                                                    <input type="radio" name="formerly" id="formerly">
                                                                    <label class="col-form-label ms-3">Formerly </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group d-flex">
                                                                    <input type="radio" name="afternoon"
                                                                        id="afternoon">
                                                                    <label class="col-form-label ms-3">Afternoon </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Absence Series </label>
                                                                    <input type="text" class="form-control"
                                                                        name="absence_series">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">note </label>
                                                                    <textarea class="form-control" name="note" cols="3" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Representation </label>
                                                                    <input type="text" class="form-control"
                                                                        name="representation">
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-sm-12">
                                                    <div class="form-group d-flex">
                                                        <input type="checkbox" name="half">
                                                        <label class="col-form-label ms-3">Reserved | will not be sent to
                                                            approved </label>
                                                    </div>
                                                </div> --}}
                                                        </div>
                                                        <div class="submit-section">
                                                            <button class="btn btn-primary " type="submit">Apply
                                                                For</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Request Absence Modal -->

                                    <!-- Report Sick Modal -->
                                    <div id="report_sick" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Report Sick</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post"
                                                        action ="{{ route('admin.reportsick.store') }}#leaves"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="no_of_days" value="0">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Select Employee <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="select form-control"
                                                                        name="employee_id">
                                                                        @foreach ($employees as $data)
                                                                            <option value="{{ $data->id }}">
                                                                                {{ $data->first_name }}
                                                                                {{ $data->last_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Absence type</label>
                                                                    <select class="form-control select" name="leave_type">
                                                                        @foreach ($leavetypes as $leavetype)
                                                                            <option value="{{ $leavetype->name }}">
                                                                                {{ $leavetype->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">From</label>
                                                                    <input class="form-control" type="date"
                                                                        name="from">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Until</label>
                                                                    <input class="form-control" type="date"
                                                                        name="to">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group d-flex">
                                                                    <input type="checkbox" name="half" id="half-day">
                                                                    <label class="col-form-label ms-3">Half Day </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group d-flex">
                                                                    <input type="radio" name="formerly" id="formerly">
                                                                    <label class="col-form-label ms-3">Formerly </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group d-flex">
                                                                    <input type="radio" name="afternoon"
                                                                        id="afternoon">
                                                                    <label class="col-form-label ms-3">Afternoon </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">note </label>
                                                                    <textarea class="form-control" name="note" cols="3" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Add Attachment</label>

                                                                    <!-- Custom file input container -->
                                                                    <div class="custom-file-upload">
                                                                        <input type="file" class="file-input"
                                                                            name="attachment" id="fileUpload" />
                                                                        <i class="fa fa-file-o file-icon"></i>
                                                                        <span class="file-text">Click to upload</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="submit-section">
                                                            <button class="btn btn-primary " type="submit">Report
                                                                Sick</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Report Sick Modal -->
                                </div>
                            </div>
                        </div>

                        <h3 class="text-center mt-3" id="currentMonth">{{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                        <div class="row mt-5 mb-5">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <select class="form-control" id="coworkerSelect" aria-label="Add Coworker">
                                        <option value="" selected>Add Colleagues</option>

                                        <!-- Add more coworker options as needed -->
                                    </select>
                                    <span class="input-group-text">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <select class="form-control"id="teamSelect" aria-label="Add Team">
                                        <option value="" selected>Add Team</option>

                                    </select>
                                    <span class="input-group-text">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <select class="form-control" id="browseListSelect" aria-label="Browse List">
                                        <option value="" disabled selected>Browse List</option>
                                        @foreach ($users as $data => $user)
                                            @foreach ($user as $dataUser)
                                                <option value="{{ $dataUser->id }}">{{ $dataUser->first_name }}
                                                    {{ $dataUser->first_name }} - {{ $dataUser->department }}</option>
                                            @endforeach
                                        @endforeach
                                        <!-- Add more coworker options as needed -->
                                    </select>
                                    <span class="input-group-text">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Day numbers header -->
                        <div class="row mb-3">
                            <div class="row" id="departmentContainer"></div>

                        </div>



                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                        <script>
                            $(document).ready(function() {
                                const baseUrl = "{{ url('/') }}";

                                $.ajax({
                                    url: baseUrl + '/admin/get-departments',
                                    method: 'GET',
                                    success: function(response) {
                                        let html = '';
                                        response.departments.forEach((dept, index) => {
                                            html += `
                                            <div class="department mb-3" id="department-${index}">
                                                <div class="department-header bg-secondary text-white p- rounded d-flex justify-content-between align-items-center" style="cursor: pointer;" data-department="${dept}" data-index="${index}">
                                                    <h5 class="fw-bold">${dept} <i class="fa fa-caret-down"></i></h5>
                                                    <button class="btn  btn-sm close-department text-white" data-department="${dept}" data-index="${index}">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="employees d-none mt-2" id="employees-${index}"></div>
                                            </div>
                                        `;
                                        });

                                        $('#departmentContainer').html(html);
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });

                                // Handle the close toggle (hide the department)
                                $(document).on('click', '.close-department', function() {
                                    const department = $(this).data('department');
                                    const index = $(this).data('index');

                                    $(`#department-${index}`).hide();

                                    addDepartmentToDropdown(department);
                                    fetchEmployeesForCoworkerDropdown(department);
                                });
                                function fetchEmployeesForCoworkerDropdown(department) {
                                    const coworkerDropdown = $('#coworkerSelect');

                                    $.ajax({
                                        url: baseUrl + `/admin/get-employees/${department}`,
                                        method: 'GET',
                                        success: function(response) {
                                            response.users.forEach(user => {
                                                const optionHTML = `<option value="${user.id}">${user.first_name} ${user.last_name} - ${department}</option>`;
                                                coworkerDropdown.append(optionHTML);
                                            });
                                        },
                                        error: function(error) {
                                            console.error(`Failed to fetch employees for department ${department}:`, error);
                                        }
                                    });
                                }

                                // Function to add the department back to the dropdown
                                function addDepartmentToDropdown(department) {
                                    const departmentDropdown = $('#teamSelect');
                                    const optionHTML = `<option value="${department}">${department}</option>`;
                                    departmentDropdown.append(optionHTML);
                                }

                                $('#teamSelect').on('change', function() {
                                    const selectedDepartment = $(this).val();

                                    if (selectedDepartment) {

                                        const departmentElement = $(`.department-header[data-department="${selectedDepartment}"]`).closest('.department');
                                        departmentElement.show();
                                        const departmentIndex = departmentElement.data('index');
                                        // fetchEmployeesForDepartment(departmentIndex);
                                        $(this).find(`option[value="${selectedDepartment}"]`).remove();
                                    }
                                });
                                // Handle employee selection from Coworker dropdown
                                $('#coworkerSelect').on('change', function () {
                                    const selectedOption = $(this).find(':selected');
                                    const employeeId = selectedOption.val();
                                    const department = selectedOption.data('department');

                                    if (employeeId && department) {
                                        // Show the department tab
                                        const departmentElement = $(`.department-header[data-department="${department}"]`).closest('.department');
                                        departmentElement.show();

                                        // Fetch and display employee details in the department tab
                                        fetchAndShowEmployeeDetails(employeeId, department);

                                        // Remove the employee from the Coworker dropdown
                                        $(this).find(`option[value="${employeeId}"]`).remove();
                                    }
                                });
                                // Function to fetch and show employee details
                                function fetchAndShowEmployeeDetails(employeeId, department) {
                                    const employeesContainer = $(`.department-header[data-department="${department}"]`)
                                        .closest('.department')
                                        .find('.employees');

                                    if (employeesContainer.length > 0) {
                                        const baseurl = "{{ url('/') }}";

                                        $.ajax({
                                            url: baseurl + `/admin/get-employee/${employeeId}`,
                                            method: 'GET',
                                            success: function (response) {
                                                const employee = response.user;
                                                const html = generateCalendar(employee, department);

                                                // Add employee data and make sure the container is visible
                                                employeesContainer.append(html).removeClass('d-none');
                                            },
                                            error: function (error) {
                                                console.error(`Failed to fetch details for employee ID ${employeeId}:`, error);
                                            }
                                        });
                                    }
                                }
                            });

                            $(document).on('click', '.department-header', function() {
                                const department = $(this).data('department');
                                const index = $(this).data('index');
                                const employeesContainer = $(`#employees-${index}`);


                                if (employeesContainer.hasClass('d-none')) {
                                    const baseurl = "{{ url('/') }}";

                                    $.ajax({
                                        url: baseurl + `/admin/get-employees/${department}`,
                                        method: 'GET',
                                        success: function(response) {
                                            let html = '<div class="row">';
                                            response.users.forEach((user, userIndex) => {
                                                html += generateCalendar(user, `${index}-${userIndex}`);
                                            });
                                            html += '</div>';
                                            employeesContainer.html(html);
                                            employeesContainer.removeClass('d-none');
                                        },
                                        error: function(error) {
                                            console.error(error);
                                        }
                                    });
                                } else {

                                    employeesContainer.addClass('d-none');
                                }

                                const icon = $(this).find('i');
                                icon.toggleClass('fa-caret-down fa-caret-up');
                            });


                            function generateCalendar(user, index) {
                                const currentMonth = new Date().getMonth() + 1;
                                const daysInMonth = new Date(new Date().getFullYear(), currentMonth, 0).getDate();
                                const firstDayOfMonth = new Date(new Date().getFullYear(), currentMonth - 1, 1).getDay();
                                const leaveDays = user.leaveDays || [];

                                let calendarHtml = `
                                    <div class="employee-card card mb-3 col-6">
                                        <div class="card-body">
                                            <h5 class="card-title">${user.first_name} ${user.last_name}</h5>
                                            <div class="calendar">
                                                <div class="week-days my-2 d-flex justify-content-between">
                                                    ${['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].map(day => `
                                                                                <div class="day-header" style="width: 14%; font-weight: bold; text-align: center;">
                                                                                    ${day}
                                                                                </div>
                                                                            `).join('')}
                                                </div>

                                                <div class="month-weeks">
                                `;

                                let dayCounter = 1;
                                for (let week = 0; week < Math.ceil((daysInMonth + firstDayOfMonth) / 7); week++) {
                                    calendarHtml += '<div class="week d-flex">';

                                    for (let day = 0; day < 7; day++) {
                                        const currentDay = (week * 7 + day) - firstDayOfMonth + 1;
                                        const isLeaveDay = leaveDays.includes(currentDay);

                                        if (currentDay > 0 && currentDay <= daysInMonth) {
                                            calendarHtml += `
                                                <div class="day mb-2 ms-2"
                                                    style="width: 14%; height: 40px; text-align: center; line-height: 50px; ${isLeaveDay ? 'background-color: black; font-weight: bold; color: white;' : ''}">
                                                    ${currentDay}
                                                </div>
                                            `;
                                        } else {
                                            calendarHtml += '<div class="day empty-day mb-2 ms-2" style="width: 14%; height: 40px;"></div>';
                                        }
                                    }

                                    calendarHtml += '</div>';
                                }

                                calendarHtml += `
                                                </div> <!-- Close month-weeks -->
                                            </div> <!-- Close calendar -->
                                        </div> <!-- Close card-body -->
                                    </div> <!-- Close employee-card -->
                                `;

                                return calendarHtml;
                            }
                        </script>


                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                // Event listener for Coworker dropdown
                                $('select[aria-label="Add Coworker"]').on('change', function() {
                                    const selectedValue = $(this).val();
                                    filterData('coworker', selectedValue);
                                });

                                // Event listener for Team dropdown
                                $('select[aria-label="Add Team"]').on('change', function() {
                                    const selectedValue = $(this).val();
                                    filterData('team', selectedValue);
                                });

                                // Event listener for Browse List dropdown
                                $('select[aria-label="Browse List"]').on('change', function() {
                                    const selectedValue = $(this).val();
                                    filterData('browse_list', selectedValue);
                                });

                                // AJAX function for filtering
                                function filterData(type, value) {
                                    $.ajax({
                                        url: "{{ route('admin.holidays') }}", // Same route as the holidays view
                                        method: "GET",
                                        data: {
                                            type: type,
                                            value: value,
                                            _token: "{{ csrf_token() }}" // CSRF Token for security
                                        },
                                        success: function(response) {
                                            // Process and display the filtered data
                                            if (response.calendarData) {
                                                updateCalendarUI(response.calendarData);
                                            }
                                        },
                                        error: function(xhr) {
                                            console.error(xhr.responseText);
                                        }
                                    });
                                }

                                // Function to update the UI with filtered data
                                function updateCalendarUI(calendarData) {
                                    let container = $('#calendarContainer');
                                    container.empty();

                                    calendarData.forEach(item => {
                                        let leaveDays = item.leaveDays;
                                        let employee = item.employee;

                                        let employeeInitials = employee.first_name.charAt(0).toUpperCase() + employee.last_name
                                            .charAt(0).toUpperCase();
                                        let employeeName = `${employee.first_name} ${employee.last_name}`;

                                        let calendarHtml = `

                                            <div class="col-sm-6">
                                                <div class="card pe-3 ps-2">
                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-sm-2 ms-4 employee-profile rounded-pill leave-card text-white fw-bold">
                                                        ${employeeInitials}
                                                    </div>
                                                    <div class="col-sm-5 mt-2 employee-name text-capitalize" style="font-weight:600;">
                                                        ${employeeName}
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <div class="calendar">
                                                        <div class="week-days d-flex justify-content-between">
                                                            ${['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].map(day => `
                                                                                                                                                                <div class="day-header" style="width: 14.28%; text-align: center;">
                                                                                                                                                                    ${day}
                                                                                                                                                                </div>
                                                                                                                                                            `).join('')}
                                                        </div>

                                                        <div class="month-weeks">
                                                            ${renderWeeks(leaveDays)}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>

                                        `;

                                        container.append(calendarHtml);
                                        // Now we handle hiding the content properly
                                        const targetSelectors = document.getElementsByClassName('mainCalendarDiv');
                                        const departmentSelectors = document.getElementsByClassName('mainCalendarContentDiv');

                                        // Loop through and hide each element individually
                                        Array.from(targetSelectors).forEach(element => {
                                            element.style.display = 'none';
                                        });

                                        Array.from(departmentSelectors).forEach(element => {
                                            element.style.display = 'none';
                                        });
                                    });
                                }

                                // Function to render the weeks and days in the calendar
                                function renderWeeks(leaveDays) {
                                    let now = moment();
                                    let daysInMonth = now.daysInMonth();
                                    let firstDayOfMonth = now.startOf('month').day(); // 0 (Sunday) to 6 (Saturday)

                                    let weeksHtml = '';
                                    let dayCounter = 1;

                                    for (let week = 0; week < Math.ceil((daysInMonth + firstDayOfMonth) / 7); week++) {
                                        weeksHtml += '<div class="week d-flex">';

                                        for (let day = 0; day < 7; day++) {
                                            let currentDay = dayCounter - firstDayOfMonth + 1;
                                            let isLeaveDay = leaveDays.includes(currentDay);

                                            if (currentDay > 0 && currentDay <= daysInMonth) {
                                                weeksHtml += `
                                                    <div class="day mb-2 ms-2" style="width: 14.28%; height: 50px; text-align: center; line-height: 50px; ${isLeaveDay ? 'background-color: black; color: white;' : ''}">
                                                        ${currentDay}
                                                    </div>
                                                `;
                                                dayCounter++;
                                            } else {
                                                weeksHtml +=
                                                    '<div class="day empty-day ms-2" style="width: 14.28%; height: 50px;"></div>';
                                            }
                                        }

                                        weeksHtml += '</div>';
                                    }

                                    return weeksHtml;
                                }
                            });
                        </script>

                        <script>
                            // JavaScript to toggle calendar visibility for each department
                            document.querySelectorAll('.toggle-dropdown').forEach(function(toggleElement) {
                                toggleElement.addEventListener('click', function() {
                                    const targetSelector = toggleElement.getAttribute('data-target');
                                    const calendarContent = document.querySelector(targetSelector);
                                    const departmentId = targetSelector.replace('#calendarContent', '');
                                    const toggleIcon = document.querySelector(`.toggleIcon${departmentId}`);

                                    // Toggle the visibility of the calendar content
                                    calendarContent.classList.toggle('d-none');

                                    // Change the icon direction
                                    if (calendarContent.classList.contains('d-none')) {
                                        toggleIcon.classList.remove('fa-caret-up');
                                        toggleIcon.classList.add('fa-caret-down');
                                    } else {
                                        toggleIcon.classList.remove('fa-caret-down');
                                        toggleIcon.classList.add('fa-caret-up');
                                    }
                                });
                            });

                            // JavaScript to handle the close button functionality
                            document.querySelectorAll('.toggle-close').forEach(function(closeBtn) {
                                closeBtn.addEventListener('click', function() {
                                    const targetSelector = closeBtn.getAttribute('data-target');
                                    const departmentSelector = closeBtn.getAttribute('data-departtaget');
                                    const calendarContent = document.querySelector(targetSelector);
                                    const toggleCalendar = document.querySelector(departmentSelector);
                                    const dataDismissData = closeBtn.getAttribute('data-department-dismiss');
                                    console.log(dataDismissData);
                                    // Hide the calendar content
                                    if (calendarContent) {
                                        calendarContent.classList.add('d-none');
                                    }

                                    // Hide the toggleCalendar row
                                    if (toggleCalendar) {
                                        toggleCalendar.classList.add('d-none');
                                    }
                                });
                            });
                        </script>



                        <style>
                            /* Custom styles for the file input field */
                            .custom-file-upload {
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                flex-direction: column;
                                border: 2px dashed #ccc;
                                border-radius: 5px;
                                padding: 30px;
                                text-align: center;
                                cursor: pointer;
                                position: relative;
                                transition: border-color 0.3s ease;
                            }

                            .custom-file-upload:hover {
                                border-color: #007bff;
                            }

                            .file-input {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                opacity: 0;
                                cursor: pointer;
                            }

                            .file-icon {
                                font-size: 40px;
                                color: #007bff;
                            }

                            .file-text {
                                margin-top: 10px;
                                font-size: 14px;
                                color: #666;
                            }

                            /* File upload text and icon on hover */
                            .custom-file-upload:hover .file-text {
                                color: #007bff;
                            }

                            .rounded-circle {
                                border-radius: 50% !important;
                                width: 100%;
                                height: 100%;
                            }

                            .leave-card {

                                width: 40px;
                                height: 40px;
                                padding: 9px;
                                top: 11px;
                            }

                            .employee-profile {
                                background: #ff9b44;
                            }

                            .day {
                                width: 25px;
                                height: 25px;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                border-radius: 5px;
                                border: 1px outset;
                                /* background-color: #e3e3e3; */
                            }

                            .day.present {
                                background-color: hsl(223.33deg 28.12% 87.45%);
                                color: black;
                            }

                            .day.absent {
                                background-color: #f39c12;
                                color: white;
                            }

                            .day.sick {
                                border: 2px solid red;
                                color: red;
                            }

                            .calendar-header {
                                display: grid;
                                grid-template-columns: repeat(30, 30px);
                                gap: 5px;
                                margin-bottom: 10px;
                            }

                            .day-header {
                                font-weight: bold;
                                text-align: center;
                            }

                            /* .calendar {
                                                display: flex;
                                            } */

                            .input-group-text {

                                border: none;
                                cursor: pointer;
                            }

                            .input-group-text i {
                                color: #000;
                                /* Set the icon color */
                            }

                            .form-control {
                                border-right: none;
                            }

                            .input-group .form-control:focus {
                                box-shadow: none;
                            }
                        </style>

                    </div>
                    <!-- Page Content -->
                </div>

            </div>
            <!-- /Page Wrapper -->

            <!-- /Page Wrapper -->

            <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.0/main.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.0/main.min.css" rel="stylesheet">

            <script>
                $(document).ready(function() {
                    var CalendarApp = function() {
                        this.$calendar = $('#calendar'),
                            this.$calendarObj = null
                    };

                    /* Initializing */
                    CalendarApp.prototype.init = function() {
                        var $this = this;

                        var currentYear = new Date().getFullYear();

                        var defaultEvents = [
                            @foreach ($holidays as $holiday)
                                {
                                    title: '{{ $holiday->title }}',
                                    start: (function() {
                                        var date = new Date('{{ $holiday->holiday_date }}');
                                        var year = currentYear; // Use current year
                                        var month = date.getMonth(); // Get month
                                        var day = date.getDate(); // Get day
                                        return new Date(year, month,
                                            day); // Construct new date with current year
                                    })(),
                                    className: '{{ $holiday->category }}'
                                }
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        ];

                        //console.log(defaultEvents);

                        $this.$calendarObj = $this.$calendar.fullCalendar({
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'month,agendaWeek,agendaDay'
                            },
                            events: defaultEvents,
                            selectable: true,
                            select: function(start, end) {
                                var title = prompt('Event Title:');
                                var eventData;
                                if (title) {
                                    eventData = {
                                        title: title,
                                        start: start,
                                        end: end
                                    };
                                    $this.$calendarObj.fullCalendar('renderEvent', eventData, true);
                                }
                                $this.$calendarObj.fullCalendar('unselect');
                            }
                        });
                    };

                    // Init CalendarApp
                    $.CalendarApp = new CalendarApp;
                    $.CalendarApp.Constructor = CalendarApp;
                    $.CalendarApp.init();

                    // Activate current month by default
                    const currentMonth = new Date().getMonth();
                    const currentMonthButton = document.querySelectorAll('.month-list button')[currentMonth];
                    activateMonth(currentMonthButton, currentMonth);
                    currentMonthButton.classList.add('active');
                });
            </script>

            <script>
                function toggleView(view) {
                    const listView = document.getElementById('list-view');
                    const calendarView = document.getElementById('calendar-view');
                    if (view === 'list') {
                        listView.style.display = 'block';
                        calendarView.style.display = 'none';
                    } else {
                        listView.style.display = 'none';
                        calendarView.style.display = 'block';
                    }
                }

                function activateMonth(button, monthIndex) {
                    const buttons = document.querySelectorAll('.month-list button');
                    buttons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    const rows = document.querySelectorAll('#events-table-body tr');
                    rows.forEach(row => {
                        const eventMonth = row.getAttribute('data-month');
                        if (parseInt(eventMonth) === monthIndex) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
            </script>
            <script>
                function calculateDays() {
                    const fromDate = document.querySelector('input[name="from"]').value;
                    const toDate = document.querySelector('input[name="to"]').value;
                    const noOfDaysInput = document.querySelector('input[name="no_of_days"]');

                    if (fromDate && toDate) {
                        const from = new Date(fromDate);
                        const to = new Date(toDate);
                        const timeDifference = to - from;
                        const daysDifference = timeDifference / (1000 * 3600 * 24);

                        noOfDaysInput.value = daysDifference >= 0 ? daysDifference : 0;
                    } else {
                        noOfDaysInput.value = '';
                    }
                }
            </script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let currentDate = new Date(); // Initialize with the current date
                    let today = new Date();

                    // Example leave days array
                    let leaveDays = [2, 5, 12, 18]; // Modify this array or pass it dynamically from your backend

                    // Function to render the calendar
                    function renderCalendar(date) {
                        const monthYearDisplay = document.getElementById('currentMonth');
                        const calendarContainer = document.getElementById('calendarContainer');
                        const prevButton = document.getElementById('prevMonth');

                        const month = date.getMonth(); // Current month (0-11)
                        const year = date.getFullYear(); // Current year
                        const daysInMonth = new Date(year, month + 1, 0).getDate(); // Get days in month
                        const startOfMonth = new Date(year, month, 1).getDay(); // Get first day of the month (0-6)

                        // Update the month and year display
                        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                            "September", "October", "November", "December"
                        ];
                        monthYearDisplay.textContent = `${monthNames[month]} ${year}`;

                        // Disable the "Previous" button if viewing the current month
                        // if (date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear()) {
                        //     prevButton.disabled = true;
                        // } else {
                        //     prevButton.disabled = false;
                        // }

                        // Create the calendar HTML
                        let calendarHTML = '<div class="row">';
                        const weekdays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                        weekdays.forEach(day => calendarHTML += `<div class="day mb-2">${day}</div>`);
                        calendarHTML += '</div><div class="row">';

                        // Add empty cells for days before the first day of the month
                        let emptyCells = (startOfMonth === 0 ? 6 : startOfMonth - 1); // Adjust for Sunday (0 index in JS)
                        for (let i = 0; i < emptyCells; i++) {
                            calendarHTML += '<div class="day mb-2"></div>';
                        }

                        // Add the days of the month with leave day highlighting
                        for (let i = 1; i <= daysInMonth; i++) {
                            // Check if it's a leave day
                            let isLeaveDay = leaveDays.includes(i);

                            // Apply styles for leave days
                            let dayStyle = isLeaveDay ? 'style="background-color: black; color: white;"' : '';
                            calendarHTML += `<div class="day mb-2" ${dayStyle}>${i}</div>`;

                            // Break row after every 7 days
                            if ((i + emptyCells) % 7 === 0) {
                                calendarHTML += '</div><div class="row">';
                            }
                        }
                        calendarHTML += '</div>';

                        // Update the calendar container with the new HTML
                        calendarContainer.innerHTML = calendarHTML;
                    }

                    // Event listeners for prev/next buttons
                    document.getElementById('prevMonth').addEventListener('click', function() {
                        currentDate.setMonth(currentDate.getMonth() - 1); // Move to the previous month
                        renderCalendar(currentDate);
                    });

                    document.getElementById('nextMonth').addEventListener('click', function() {
                        currentDate.setMonth(currentDate.getMonth() + 1); // Move to the next month
                        renderCalendar(currentDate);
                    });

                    // Initial render
                    renderCalendar(currentDate);
                });
            </script>
        @endsection
