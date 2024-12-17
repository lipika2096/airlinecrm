@extends('admin/layouts/head-main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <title>Staff Profile</title>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .fw-bold {
                120px;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Staff Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Staff Profile</li>
                        </ul>
                        <p class="d-inline text-dark font-weight-bolder">Welcome to <b
                                class="d-inline text-capitalize">{{ $employees->first_name }} {{ $employees->last_name }}</b>
                            profile</p>
                    </div>
                    <div class="card tab-box" style="margin-top: 20px;">
                        <div class="row user-tabs">
                            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="nav-item"><a href="#general" data-bs-toggle="tab"
                                            class="nav-link active">General</a>
                                    </li>
                                    <li class="nav-item"><a href="#leaves" data-bs-toggle="tab" class="nav-link">My
                                            Overview</a>
                                    </li>
                                    <li class="nav-item"><a href="#training-certficates" data-bs-toggle="tab"
                                            class="nav-link">Training & Certificates</a>
                                    </li>
                                    <li class="nav-item"><a href="#readsign" data-bs-toggle="tab" class="nav-link">Read &
                                            Sign</a>
                                    </li>
                                    <li class="nav-item"><a href="#library" data-bs-toggle="tab"
                                            class="nav-link">Library</a>
                                    </li>
                                    <li class="nav-item"><a href="#applications" data-bs-toggle="tab"
                                            class="nav-link">Applications</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="tab-content" style="margin-top:-30px;">
                <div id="general" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-3" style="padding: 3pc;margin-right: 33px;">
                                <div class="row">
                                    <div class="col-7">
                                        <table class="table table-bordered table-striped">

                                            <tbody>
                                                <tr>
                                                    <td class="fw-bold">Employee ID</td>
                                                    <td>{{ $employees->unique_id }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">First Name</td>
                                                    <td>{{ $employees->first_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Last Name</td>
                                                    <td>{{ $employees->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Email</td>
                                                    <td>{{ $employees->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">DOB </td>
                                                    <td>{{ $employees->dob }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">DOJ</td>
                                                    <td>{{ $employees->joining_date }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Branch</td>
                                                    <td>{{ $employees->branch }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Department</td>
                                                    <td>{{ $employees->department }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Position</td>
                                                    <td>{{ $employees->position }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Work Type</td>
                                                    <td>{{ $employees->work_type }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Phone</td>
                                                    <td>{{ $employees->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Mobile(Personal)</td>
                                                    <td>{{ $employees->personal_phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Mobile(Company)</td>
                                                    <td>{{ $employees->company_mobile }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Company</td>
                                                    <td>{{ $employees->client_company_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Min Hrs</td>
                                                    <td>{{ $employees->min_hrs }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Max Hrs</td>
                                                    <td>{{ $employees->max_hrs }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-5" style= "padding-left:90px;">
                                        @if (!empty($employees->avatar_filename))
                                            <img src="{{ asset('staff/storage/avatars/' . $employees->avatar_directory . '/' . $employees->avatar_filename) }}"
                                                alt="" width="60%"
                                                style="width: 150px;border-radius: 85px;margin-top:20px;height: 150px!important;"
                                                class="ms-5">
                                        @else
                                            <img src="{{ asset('public/assets/img/user.jpg/') }}" alt=""
                                                width="60%"
                                                style="width: 150px;border-radius: 85px;margin-top:20px;height: 150px!important;"
                                                class="ms-5">
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="leaves" class="pro-overview tab-pane fade show ">
                    <!-- Page Content -->
                    <div class="content container-fluid">

                        <!-- Page Header -->
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <a class="btn add-btn ms-2" data-bs-toggle="modal"
                                    data-bs-target="#new_absence"><i class="fa fa-plus"></i> New Absence</a>
                                <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#report_sick"><i
                                        class="fa fa-plus"></i> Report Sick</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Page Header -->

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
                                                        <div class="modal-body pt-0">
                                                            <form method="post"
                                                                action="{{ route('admin.newabsence.store') }}#leaves">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                            <input type="hidden" value="{{ $employees->id }}" class="form-control"
                                                                            name="employee_id">

                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Absence type</label>
                                                                            <select class="form-control select"
                                                                                name="leave_type">
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
                                                                            <input class="form-control" id="from" type="date"
                                                                                name="from" onchange="calculateDays()">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Until</label>
                                                                            <input class="form-control"  id="to" type="date"
                                                                                name="to" onchange="calculateDays()">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>Number of days <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input class="form-control" id="no_of_days" readonly type="text"
                                                                                name="no_of_days">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group d-flex">
                                                                            <input type="checkbox" name="half"
                                                                                id="half-day">&nbsp;Half Day
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group d-flex">
                                                                            <input type="radio" name="formerly"
                                                                                id="formerly">&nbsp;Formerly
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group d-flex">
                                                                            <input type="radio" name="afternoon"
                                                                                id="afternoon">&nbsp;Afternoon
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Absence Series
                                                                            </label>
                                                                            <input type="text" class="form-control"
                                                                                name="absence_series">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Representation
                                                                            </label>
                                                                            <input type="text" class="form-control"
                                                                                name="representation">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">note </label>
                                                                            <textarea class="form-control" name="note"
                                                                                cols="3" rows="3"></textarea>
                                                                        </div>
                                                                    </div>

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
                                                                action="{{ route('admin.reportsick.store') }}#leaves"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                {{-- <input type="hidden" name="no_of_days" value="0"> --}}
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">

                                                                                <input type="hidden" value="{{ $employees->id }}" class="form-control"
                                                                                    name="employee_id">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Absence type</label>
                                                                            <select class="form-control select"
                                                                                name="leave_type">
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
                                                                                name="from" id="from1" onchange="calculateDays1()">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Until</label>
                                                                            <input class="form-control" type="date"
                                                                                name="to"  id="to1" onchange="calculateDays1()">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>Number of days <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input class="form-control" id="no_of_days1" readonly type="text"
                                                                                name="no_of_days">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group d-flex">
                                                                            <input type="checkbox" name="half"
                                                                                id="half-day">&nbsp;Half Day
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group d-flex">
                                                                            <input type="radio" name="formerly"
                                                                                id="formerly">&nbsp;Formerly
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group d-flex">
                                                                            <input type="radio" name="afternoon"
                                                                                id="afternoon">&nbsp;Afternoon
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">note </label>
                                                                            <textarea class="form-control" name="note"
                                                                                cols="3" rows="3"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Add
                                                                                Attachment</label>

                                                                            <!-- Custom file input container -->
                                                                            <div class="custom-file-upload">
                                                                                <input type="file" class="file-input"
                                                                                    name="attachment" id="fileUpload" />
                                                                                <i class="fa fa-file-o file-icon"></i>
                                                                                <span class="file-text">Click to
                                                                                    upload</span>
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
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="month-dates">

                                        <div id="monthDateList"></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Legend for leave types -->
                                                <div class="leave-type-legend">
                                                    <div class="legend-item"><span class="color-box"
                                                            style="background-color: #229f7c"></span><span class="color-box"
                                                            style="background-color: #7ccdb6;"></span> Vacation </div>
                                                    <!--<div class="legend-item"><span class="color-box" style="background-color: #7ccdb6;"></span> Half Vacation Leave</div>-->
                                                    <div class="legend-item"><span class="color-box"
                                                            style="background-color: rgb(242, 188, 68)"></span> Business Trip</div>
                                                    <div class="legend-item"><span class="color-box"
                                                            style="background-color: rgb(255, 120, 98);"></span> Annual Leave </div>
                                                    <div class="legend-item"><span class="color-box"
                                                            style="background-color: #206eb6"></span> Holidays</div>
                                                    <div class="legend-item"><span class="color-box"
                                                                    style="background-color: rgb(200, 149, 227)"></span> Special Leave</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Leave Summary Boxes -->
                                                <div class="leave-summary">
                                                    <div class="total-leave-box">
                                                        <span class="leave-box">{{ $usedAnnualLeave }}</span>
                                                        <h6>Approved vacation days</h6>

                                                    </div>
                                                    <div class="remaining-leave-box">
                                                        <span class="leave-box">{{ $remainingLeave }}</span>
                                                        <h6>Vacation days remaining</h6>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Leave Summary Boxes -->
                                                <div class="leave-summary">
                                                    <div class="total-leave">
                                                        <h6 style="    color: black;">There are a total of
                                                            {{ $total_holidays }} vacation days available this year.</h6>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- /Page Content -->

                <style>
                    .leave-type-legend {
                        display: flex;
                        justify-content: center;
                        /* Horizontally center the legend items */
                        gap: 20px;
                        /* Add spacing between each legend item */
                        margin-bottom: 20px;
                        /* Add some margin at the bottom */
                    }

                    .color-box {
                        padding: 3px 10px;
                        border-radius: 5px;
                        margin-right: 10px;
                    }

                    .leave-summary {
                        display: flex;
                        justify-content: center;
                        /* Center the entire leave summary horizontally */
                        text-align: center;
                        /* Align text to the center */
                        margin-bottom: 20px;
                        /* Add spacing between rows */
                    }

                    .leave-box {
                        color: black;
                        font-size: 18px;
                        border: 3px solid black;
                        border-radius: 100%;
                        width: 30px;
                        /* Increase width for better readability */
                        height: 30px;
                        /* Increase height for better readability */
                        display: flex;
                        justify-content: center;
                        /* Center the text horizontally */
                        align-items: center;
                        /* Center the text vertically */
                    }

                    .total-leave-box,
                    .remaining-leave-box {
                        display: flex;
                        flex-direction: row;
                        justify-content: center;
                        align-items: center;
                        margin: 0 20px;
                        gap: 10px;
                    }

                    .total-leave-box h6,
                    .remaining-leave-box h6 {
                        color: black;
                        font-size: 16px;
                        margin-top: 10px;
                        /* Add space between the number and the text */
                    }

                    .total-leave {
                        text-align: center;
                        margin-top: 20px;
                        font-size: 16px;
                        color: black;
                    }

                    /* Ensure the rows have proper spacing */
                    .month-dates {
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 5px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    }



                    .month-date {
                        display: flex;
                        align-items: center;
                        margin-bottom: 10px;
                    }

                    .month {
                        width: 88px;
                        /* Fixed width for month names */
                        font-weight: bold;
                    }

                    .dates {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 1px;
                    }

                    .date {
                        margin: 0 0px;
                        padding: 2px 6px;
                        background-color: #e0e0e0;
                        border-radius: 3px;
                    }
                    </style>

                    <script>
                    const monthNames = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];

                    const leave_type = @json($leavetypes);

                    // Fetch leave data and holidays data from backend
                    const leaveData = @json($leaveData); // Leave data from the backend
                    const holidays = @json($holidays); // Holidays data from the backend
                    // Function to generate random color
                    // Function to return leave type colors
                    function getLeaveTypeColor(type) {
                        switch (type) {
                            case 'Vacation':
                                return 'rgb(67, 169, 148)'; // Vacation leave color
                            case 'Half Vacation Leave':
                                return 'lightgreen'; // Half vacation leave color
                            case 'Business Trip': // Ensure correct spelling
                                return 'rgb(242, 188, 68)'; // Business trip color
                            case 'Annual Leave': // Ensure correct spelling
                                return 'rgb(255, 120, 98)'; // Sick leave color
                            case 'Holiday':
                                return '#206eb6'; // Holiday color
                            case 'Special Leave':
                                return 'rgb(200, 149, 227)'; //Special Leave
                            default:
                                return 'rgb(255, 120, 98)'; // Returning the leave type name as title
                        }
                    }

                    // Function to render the calendar with colored leaves
                    document.addEventListener("DOMContentLoaded", () => {
                        const monthDateList = document.getElementById("monthDateList");
                        const currentYear = 2024; // Set the year

                        // Loop through each month
                        monthNames.forEach((month, index) => {
                            const monthDateDiv = document.createElement("div");
                            monthDateDiv.classList.add("month-date");

                            const monthDiv = document.createElement("div");
                            monthDiv.classList.add("month");
                            monthDiv.textContent = month;

                            const datesDiv = document.createElement("div");
                            datesDiv.classList.add("dates");

                            // Get the number of days in the month
                            const days = new Date(currentYear, index+1 , 0).getDate();
                            for (let day = 1; day <= days; day++) {
                                const dateDiv = document.createElement("div");
                                dateDiv.classList.add("date");
                                dateDiv.textContent = day;

                                // Check if the date falls within any leave range and apply the leave color
                                leaveData.forEach(leave => {
                                const leaveStart = new Date(leave.from);
                                const leaveEnd = new Date(leave.to);
                                const currentDate = new Date(currentYear, index, day);
                                leaveStart.setDate(leaveStart.getDate() - 1);

                                if (currentDate >= leaveStart && currentDate <= leaveEnd) {
                                    const leaveColor = getLeaveTypeColor(leave.leave_type);
                                    if (leaveColor !== 'transparent') {
                                        dateDiv.style.backgroundColor = leaveColor;
                                        dateDiv.style.color = "#fff"; // Make the text white for better contrast
                                    }
                                }
                                if (currentDate === leaveStart) {
                                        dateDiv.style.backgroundColor =
                                        leaveColor; // Apply blue color for holidays
                                        dateDiv.style.color = "#fff"; // Make the text white
                                    }
                            });

                                // Check if the current date is a holiday
                                holidays.forEach(holiday => {
                                    const holidayDate = new Date(holiday.holiday_date);
                                    if (holidayDate.getFullYear() === currentYear &&
                                        holidayDate.getMonth() === index &&
                                        holidayDate.getDate() === day) {
                                        dateDiv.style.backgroundColor =
                                        '#206eb6'; // Apply blue color for holidays
                                        dateDiv.style.color = "#fff"; // Make the text white
                                    }
                                });

                                datesDiv.appendChild(dateDiv);
                            }

                            monthDateDiv.appendChild(monthDiv);
                            monthDateDiv.appendChild(datesDiv);
                            monthDateList.appendChild(monthDateDiv);
                        });
                    });
                    </script>

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
                                    <form method="POST" action ="{{ route('admin.view-staff.leaves.store') }}#leaves">
                                        @csrf
                                        <div class="form-group">
                                            <!-- <label>Select Employee <span class="text-danger">*</span></label> -->
                                            <input type="hidden" value="{{ $employees->id }}" name="employee_id">
                                        </div>
                                        <div class="form-group">
                                            <label>Leave Type <span class="text-danger">*</span></label>
                                            <select class="select form-control" name="leave_type">
                                                <option>Select Leave Type</option>
                                                @foreach ($leavetypes as $leavetype)
                                                    <option value="{{ $leavetype->name }}">{{ $leavetype->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>From <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control " type="date" name="from" id="from"
                                                    onchange="calculateDays()">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>To <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control" type="date" name="to" id="to"
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
                                            <label>Leave Reason <span class="text-danger">*</span></label>
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
                                                <a href="javascript:void(0);"
                                                    class="btn btn-primary continue-btn">Delete</a>
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
                <div id="training-certficates" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>License Approval</th>
                                            <th>Abbr</th>
                                            <th>DOI</th>
                                            <th>DEX</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="7">No data found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="readsign" class="pro-overview tab-pane fade show ">
                    <!-- Page Content -->
                    <div class="content container-fluid">

                        <!-- Page Header -->
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">

                                </div>
                                <div class="col-auto float-end ms-auto">
                                    <a href="#" class="btn add-btn" data-bs-toggle="modal"
                                        data-bs-target="#add_document"><i class="fa fa-plus"></i> Add Document</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Page Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                {{-- <th>Document</th> --}}
                                                <th>Airline</th>
                                                <th>Created On</th>
                                                <th>Created By</th>
                                                <th>Last Viewed By</th>
                                                <th>Last Viewed On</th>
                                                <th class="text-center">View & Sign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($staffReadSign as $data)
                                                <tr>
                                                    <td>{{ $data->doc_name }}</td>
                                                    {{-- <td><a href="{{asset('public/assets/docs/'.$data->attachment)}}">view {{ $data->attachment }}</a></td> --}}
                                                    <td>{{ $data->airline->airline_name }}</td>
                                                    <td>{{ $data->created_at }}</td>
                                                    <td>{{ $data->created_by }}</td>
                                                    <td>{{ $data->updated_at }}</td>
                                                    <td>{{ $data->updated_by }}</td>
                                                    <td class="text-center">
                                                        @if ($data->sign_doc == NULL)
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#view_sign_document{{ $data->id }}"
                                                                aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-purple"></i> Sign Document
                                                            </a>
                                                        @else
                                                            Document Already Signed
                                                        @endif
                                                    </td>
                                                </tr>
                                                <!-- Approve Leave Modal -->
                                                <div class="modal custom-modal fade"
                                                    id="view_sign_document{{ $data->id }}" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action ="{{ route('admin.view-staff.readsign.update', ['id' => $data->id]) }}#readsign">
                                                                    @method('PATCH') @csrf
                                                                    <div class="form-group">
                                                                        <label>Sign the document <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="checkbox" value="1"
                                                                            name="sign_document">
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
                    <!-- /Page Content -->

                    <!-- Add Leave Modal -->
                    <div id="add_document" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Document</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action ="{{ route('admin.view-staff.readsign.store') }}#readsign" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <!-- <label>Select Employee <span class="text-danger">*</span></label> -->
                                            <input type="hidden" value="{{ $employees->id }}" name="staff_id">
                                            <input type="hidden" value=" " name="updated_at">
                                        </div>
                                        <div class="form-group">
                                            <label>Airline <span class="text-danger">*</span></label>
                                            <select class="select form-control" name="airline_id">
                                                <option>Select Airline</option>
                                                @foreach ($airline as $air)
                                                    <option value="{{ $air->airline_id }}">{{ $air->airline->airline_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Document Name <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control " type="text" name="doc_name">
                                            </div>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label>Attachment <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control" type="file" name="attachment">
                                            </div>
                                        </div> --}}

                                        <div class="submit-section">
                                            <button class="btn btn-primary submit-btn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Add Leave Modal -->

                </div>
                <div id="library" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                            <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_library"><i
                                    class="fa fa-plus"></i> Add Library</a>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Read & Sign</th>
                                            <th>Issue Date</th>
                                            <th>Effective Date</th>
                                            <th>Edition No.</th>
                                            <th class="text-center" colspan="2">Uploaded
                                            </th>
                                            <th class="text-center" colspan="2">Updated</th>
                                            <th>Attachment</th>
                                            <th>Actions</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th> </th>
                                            <th> </th>
                                            <th> </th>
                                            <th>DateTime</th>
                                            <th>User</th>
                                            <th>DateTime</th>
                                            <th>User</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($library as $index => $data)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $data->doc_name }}</td>
                                                <td>
                                                    <i class=" fas {{ $data->read_sign == 1 ? 'fa-check' : '' }}"
                                                        data-field="read_sign"
                                                        data-staff-id="{{ $data->staff_id }}"></i>
                                                </td>
                                                <td>{{ $data->issue_date }}</td>
                                                <td>{{ $data->effective_date }}</td>
                                                <td>{{ $data->edition_no }}</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>{{ $data->admin->name ??  ($data->user->first_name ." ".$data->user->last_name) }}</td>
                                                <td>{{ $data->updated_at }}</td>
                                                <td>
                                                    {{ $data->adminUpdated->name ?? ($data->userUpdated ? $data->userUpdated->first_name . ' ' . $data->userUpdated->last_name : '') }}
                                                </td>

                                                <td>
                                                    @if($data->attachment && $decodedAttachments = json_decode($data->attachment))
                                                        @foreach($decodedAttachments as $index => $docLibrary)

                                                                <a href="{{$docLibrary}}" target="_blank">
                                                                <i
                                                            class="fa fa-eye"></i>
                                                                </a>
                                                        @endforeach
                                                    @else
                                                        <li>No documents available</li>
                                                    @endif
                                                    <!--<a target="_blank"-->
                                                    <!--    href="{{ asset('public/assets/docs/' . $data->attachment) }}"> <i-->
                                                    <!--        class="fa fa-eye"></i></a>-->
                                                    <!--<i class="fa fa-download"></i>-->
                                                    <!--<i class="fa fa-trash"></i>-->
                                                </td>
                                                <td style="display:flex;">
                                                    <a class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#edit_library{{ $data->id }}"><i
                                                            class="fa fa-edit"></i></a>

                                                            <a style="margin-right: 10px;" class="btnedit-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete_library{{ $data->id }}"><i
                                                                class="fa fa-trash"></i></a>

                                                </td>
                                            </tr>

                                        <!-- Delete fleet Modal -->
                                        <div id="delete_library{{$data->id}}" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete Library</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.airline.library.destroy',$data->id)}}#library" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <p>Are you sure you want to delete?
                                                            </p>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <textarea class="form-control" name="remarks" col="1"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete fleet Modal -->
                                            <div id="edit_library{{ $data->id }}" class="modal fade"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Library</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.view-staff.library.update', $data->id) }}#library"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input class="form-control" type="hidden"
                                                                    name="staff_id" value="{{ $employees->id }}">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Airline <span class="text-danger">*</span></label>
                                                                            <select class="select form-control" name="airline_id">
                                                                                <option>Select Airline</option>
                                                                                @foreach ($airline as $air)
                                                                                    <option value="{{ $air->airline_id }}" {{ $air->airline_id == $data->airline_id?'selected':''}}>{{ $air->airline->airline_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="doc_name">Document Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="doc_name" name="doc_name"
                                                                                value="{{ $data->doc_name }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="issue_date">Issue Date</label>
                                                                            <input type="date" class="form-control"
                                                                                id="issue_date" name="issue_date"
                                                                                value="{{ $data->issue_date }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="edition_no">Edition No</label>
                                                                            <input type="text" class="form-control"
                                                                                id="edition_no" name="edition_no"
                                                                                value="{{ $data->edition_no }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="attachment">Attachment</label>
                                                                            <input type="file" class="form-control"
                                                                                id="attachment" name="attachment">
                                                                            @if ($data->attachment)
                                                                                <p>Current Document: <a target="_blank"
                                                                                        href="{{ asset('public/assets/docs/' . $data->attachment) }}">View
                                                                                        Doc</a>
                                                                                </p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="submit-section">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- Repeat for other documents -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="add_library" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Library</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.view-staff.library.store') }}#library" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" name="staff_id"
                                                     value="{{ $employees->id }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Airline <span class="text-danger">*</span></label>
                                                <select class="select form-control" name="airline_id">
                                                    <option>Select Airline</option>
                                                    @foreach ($airline as $air)
                                                        <option value="{{ $air->airline_id }}">{{ $air->airline->airline_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Document Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="doc_name"
                                                    id="doc_name">
                                            </div>
                                            <div class="form-group">
                                                <label>Edition No <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="edition_no"
                                                    id="edition_no">
                                            </div>
                                            <div class="form-group">
                                                <label>Issue Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="issue_date"
                                                    id="issue_date">
                                            </div>
                                            <div class="form-group">
                                                <label>Upload Documents <span class="text-danger">*</span></label>
                                                <input class="form-control" type="file" name="documents" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="applications" class="pro-overview tab-pane fade show ">
                    <!-- Page Content -->
                    <div class="content container-fluid">

                        <!-- Page Header -->
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">

                                </div>
                                <div class="col-auto float-end ms-auto">
                                    <a href="#" class="btn add-btn" data-bs-toggle="modal"
                                        data-bs-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Page Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>Leave Type</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>No of Days</th>
                                                <th>Reason</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employee_leaves_view as $data)
                                                <tr>
                                                    <td>{{ $data->leave_type }}</td>
                                                    <td>{{ $data->from }}</td>
                                                    <td>{{ $data->to }}</td>
                                                    <td>{{ $data->no_of_days }}</td>
                                                    <td>{{ $data->reason }}</td>
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
                                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                                    Approved
                                                                </a>
                                                            @else
                                                                <a class="btn btn-white btn-sm btn-rounded "
                                                                    href="#" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Approve Leave Modal -->
                                                <div class="modal custom-modal fade"
                                                    id="approve_leave{{ $data->id }}" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action ="{{ route('admin.view-staff.leaves.update', ['id' => $data->id]) }}#leaves">
                                                                    @method('PATCH') @csrf
                                                                    <div class="form-group">
                                                                        <label>Update Leave Status <span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="select form-control"
                                                                            name="status">
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
                                    <form method="POST" action ="{{ route('admin.view-staff.leaves.store') }}#leaves">
                                        @csrf
                                        <div class="form-group">
                                            <!-- <label>Select Employee <span class="text-danger">*</span></label> -->
                                            <input type="hidden" value="{{ $employees->id }}" name="employee_id">
                                        </div>
                                        <div class="form-group">
                                            <label>Leave Type <span class="text-danger">*</span></label>
                                            <select class="select form-control" name="leave_type">
                                                <option>Select Leave Type</option>
                                                @foreach ($leavetypes as $leavetype)
                                                    <option value="{{ $leavetype->name }}">{{ $leavetype->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>From <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control " type="date" name="from" id="from"
                                                    onchange="calculateDays()">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>To <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control" type="date" name="to" id="to"
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
                                            <label>Leave Reason <span class="text-danger">*</span></label>
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
                                                <a href="javascript:void(0);"
                                                    class="btn btn-primary continue-btn">Delete</a>
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
                <!-- Page Content -->
            </div>
        </div>
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

                    noOfDaysInput.value = daysDifference >= 0 ? daysDifference + 1 : 0;
                } else {
                    noOfDaysInput.value = '';
                }
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Check if there's a hash in the URL
                if (window.location.hash) {
                    const activeTab = window.location.hash;
                    // Find the corresponding tab and show it
                    const tabElement = document.querySelector(`a[href="${activeTab}"]`);
                    if (tabElement) {
                        tabElement.click();
                    }
                }

                // Optional: update the form action with the current tab on form submit
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    form.addEventListener('submit', function() {
                        const activeTab = document.querySelector('.nav-tabs .active a');
                        if (activeTab) {
                            form.action += activeTab.getAttribute('href');
                        }
                    });
                });
            });

     // Function to ensure the date input meets the requirements
  document.getElementById('from').addEventListener('input', function () {
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
   document.getElementById('to').addEventListener('input', function () {
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
        </script>
    @endsection
