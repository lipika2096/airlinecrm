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
                    <p class="d-inline text-dark font-weight-bolder">Welcome to <b class="d-inline text-capitalize">{{
                            $employees->first_name }} {{ $employees->last_name }}</b>
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
                                <li class="nav-item"><a href="#teams" data-bs-toggle="tab" class="nav-link">Teams</a>
                                </li>
                                <li class="nav-item"><a href="#approved-airlines" data-bs-toggle="tab"
                                        class="nav-link">Approved Airline Duties</a>
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

                                <div class="col-5" style="padding-left:90px;">
                                    @if (!empty($employees->avatar_filename))
                                    <img src="{{ asset('staff/storage/avatars/' . $employees->avatar_directory . '/' . $employees->avatar_filename) }}"
                                        alt="" width="60%"
                                        style="width: 150px;border-radius: 85px;margin-top:20px;height: 150px!important;"
                                        class="ms-5">
                                    @else
                                    <img src="{{ asset('public/assets/img/user.jpg/') }}" alt="" width="60%"
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
                                <a class="btn add-btn ms-2" data-bs-toggle="modal" data-bs-target="#new_absence"><i
                                        class="fa fa-plus"></i> New Absence</a>
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
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body pt-0">
                                    <form method="post" action="{{ route('admin.newabsence.store') }}#leaves">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" value="{{ $employees->id }}" class="form-control"
                                                    name="employee_id">

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
                                                    <input class="form-control" id="from" type="date" name="from"
                                                        onchange="calculateDays()">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Until</label>
                                                    <input class="form-control" id="to" type="date" name="to"
                                                        onchange="calculateDays()">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Number of days <span class="text-danger">*</span></label>
                                                    <input class="form-control" id="no_of_days" readonly type="text"
                                                        name="no_of_days">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group d-flex">
                                                    <input type="checkbox" name="half" id="half-day">&nbsp;Half Day
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group d-flex">
                                                    <input type="radio" name="formerly" id="formerly">&nbsp;Formerly
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group d-flex">
                                                    <input type="radio" name="afternoon" id="afternoon">&nbsp;Afternoon
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Absence Series
                                                    </label>
                                                    <input type="text" class="form-control" name="absence_series">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Representation
                                                    </label>
                                                    <input type="text" class="form-control" name="representation">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">note </label>
                                                    <textarea class="form-control" name="note" cols="3"
                                                        rows="3"></textarea>
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
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{ route('admin.reportsick.store') }}#leaves"
                                        enctype="multipart/form-data">
                                        @csrf
                                        {{-- <input type="hidden" name="no_of_days" value="0"> --}}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">

                                                    <input type="hidden" value="{{ $employees->id }}"
                                                        class="form-control" name="employee_id">
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
                                                    <input class="form-control" type="date" name="from" id="from1"
                                                        onchange="calculateDays1()">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Until</label>
                                                    <input class="form-control" type="date" name="to" id="to1"
                                                        onchange="calculateDays1()">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Number of days <span class="text-danger">*</span></label>
                                                    <input class="form-control" id="no_of_days1" readonly type="text"
                                                        name="no_of_days">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group d-flex">
                                                    <input type="checkbox" name="half" id="half-day">&nbsp;Half Day
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group d-flex">
                                                    <input type="radio" name="formerly" id="formerly">&nbsp;Formerly
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group d-flex">
                                                    <input type="radio" name="afternoon" id="afternoon">&nbsp;Afternoon
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">note </label>
                                                    <textarea class="form-control" name="note" cols="3"
                                                        rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">Add
                                                        Attachment</label>

                                                    <!-- Custom file input container -->
                                                    <div class="custom-file-upload">
                                                        <input type="file" class="file-input" name="attachment"
                                                            id="fileUpload" />
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
                                <div class="year-scroller">
                                    <a class="btnn" id="prevYear"> <i class="fa fa-angle-left"></i></a>
                                    <span class="crtyear" id="currentYearDisplay">{{ \Carbon\Carbon::now()->year
                                        }}</span>
                                    <a class="btnn" id="nextYear"> <i class="fa fa-angle-right"></i></a>
                                </div>
                                <div class="month-dates">

                                    <div id="monthDateList"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Legend for leave types -->
                                            <div class="leave-type-legend">
                                                <div class="legend-item"><span class="color-box"
                                                        style="background-color: #229f7c"></span>Annual Leave </div>
                                                <!--<div class="legend-item"><span class="color-box" style="background-color: #7ccdb6;"></span> Half Vacation Leave</div>-->
                                                <div class="legend-item"><span class="color-box"
                                                        style="background-color: rgb(242, 188, 68)"></span> Business
                                                    Trip</div>
                                                <div class="legend-item"><span class="color-box"
                                                        style="background-color: rgb(255, 120, 98);"></span> Sick Leave
                                                </div>
                                                <div class="legend-item"><span class="color-box"
                                                        style="background-color: #206eb6"></span> Holidays</div>
                                                <div class="legend-item"><span class="color-box"
                                                        style="background-color: rgb(200, 149, 227)"></span> Special
                                                    Leave</div>
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
                    .year-scroller {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin: 20px 0;
                    }

                    .year-scroller .btn {
                        margin: 0 10px;
                    }

                    a.btnn {
                        display: inline-block;
                        font-size: 15px !important;
                        background: #ddd;
                        border: 1px solid #ddd !important;
                        border-radius: 5px !important;
                        margin: 0px 5px 14px 5px;
                        padding: 5px 12px 5px 12px;
                        color: #000;
                    }

                    .fa {
                        font-size: 20px;
                    }

                    .crtyear {
                        font-size: 22px;

                        margin: 0px 5px 8px 5px;
                        /* padding: 13px 12px 4px 12px; */
                    }

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
                                    case 'Annual Leave':
                                        return 'rgb(67, 169, 148)'; // Vacation leave color
                                    case 'Half Vacation Leave':
                                        return 'lightgreen'; // Half vacation leave color
                                    case 'Business Trip': // Ensure correct spelling
                                        return 'rgb(242, 188, 68)'; // Business trip color
                                    case 'Sick Leave': // Ensure correct spelling
                                        return 'rgb(255, 120, 98)'; // Sick leave color
                                    case 'Holiday':
                                        return '#206eb6'; // Holiday color
                                    case 'Special Leave':
                                        return 'rgb(200, 149, 227)'; //Special Leave
                                    default:
                                        return 'rgb(255, 120, 98)'; // Returning the leave type name as title
                                }
                            }
                            document.addEventListener("DOMContentLoaded", () => {
                                let currentYear = new Date().getFullYear();

                                const monthDateList = document.getElementById("monthDateList");

                                $('#prevYear').click(function () {
                                    currentYear--;
                                    updateYearDisplay();
                                });

                                $('#nextYear').click(function () {
                                    currentYear++;
                                    updateYearDisplay();
                                });

                                function updateYearDisplay() {
                                    // Clear existing data
                                    monthDateList.innerHTML = '';

                                    $('#currentYearDisplay').text(currentYear);

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
                                }

                                // Call updateYearDisplay to show data for the default current year
                                updateYearDisplay();
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
                                <form method="POST" action="{{ route('admin.view-staff.leaves.store') }}#leaves">
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
                                        <label>Leave Reason </label>
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
                                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_document"><i
                                        class="fa fa-plus"></i> Add Document</a>
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
                                            {{-- <td><a href="{{asset('public/assets/docs/'.$data->attachment)}}">view
                                                    {{ $data->attachment }}</a></td> --}}
                                            <td>{{ $data->airline->airline_name??'' }}</td>
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
                                        <div class="modal custom-modal fade" id="view_sign_document{{ $data->id }}"
                                            role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('admin.view-staff.readsign.update', ['id' => $data->id]) }}#readsign">
                                                            @method('PATCH') @csrf
                                                            <div class="form-group">
                                                                <label>Sign the document <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="checkbox" value="1" name="sign_document">
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
                                <form method="POST" action="{{ route('admin.view-staff.readsign.store') }}#readsign"
                                    enctype="multipart/form-data">
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
                                                data-field="read_sign" data-staff-id="{{ $data->staff_id }}"></i>
                                        </td>
                                        <td>{{ $data->issue_date }}</td>
                                        <td>{{ $data->effective_date }}</td>
                                        <td>{{ $data->edition_no }}</td>
                                        <td>{{ $data->created_at }}</td>
                                        <td>{{ $data->admin->name ?? ($data->user->first_name ."
                                            ".$data->user->last_name) }}</td>
                                        <td>{{ $data->updated_at }}</td>
                                        <td>
                                            {{ $data->adminUpdated->name ?? ($data->userUpdated ?
                                            $data->userUpdated->first_name . ' ' . $data->userUpdated->last_name : '')
                                            }}
                                        </td>

                                        <td>
                                            @if($data->attachment && $decodedAttachments =
                                            json_decode($data->attachment))
                                            @foreach($decodedAttachments as $index => $docLibrary)

                                            <a href="{{$docLibrary}}" target="_blank">
                                                <i class="fa fa-eye"></i>
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

                                            <a style="margin-right: 10px;" class="btnedit-btn" data-bs-toggle="modal"
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
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{route('admin.airline.library.destroy',$data->id)}}#library"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <p>Are you sure you want to delete?
                                                        </p>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <textarea class="form-control" name="remarks"
                                                                        col="1"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Delete fleet Modal -->
                                    <div id="edit_library{{ $data->id }}" class="modal fade" role="dialog">
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
                                                        <input class="form-control" type="hidden" name="staff_id"
                                                            value="{{ $employees->id }}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Airline <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="select form-control"
                                                                        name="airline_id">
                                                                        <option>Select Airline</option>
                                                                        @foreach ($airline as $air)
                                                                        <option value="{{ $air->airline_id }}" {{ $air->
                                                                            airline_id ==
                                                                            $data->airline_id?'selected':''}}>{{
                                                                            $air->airline->airline_name }}
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
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    Changes</button>
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
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                                            <input type="text" class="form-control" name="doc_name" id="doc_name">
                                        </div>
                                        <div class="form-group">
                                            <label>Edition No <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="edition_no" id="edition_no">
                                        </div>
                                        <div class="form-group">
                                            <label>Issue Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="issue_date" id="issue_date">
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
                            {{-- <div class="col-auto float-end ms-auto">
                                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_leave"><i
                                        class="fa fa-plus"></i> Add Leave</a>
                            </div> --}}
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
                                                    <a class="btn btn-white btn-sm btn-rounded " href="#"
                                                        aria-expanded="false">
                                                        <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                                    </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Approve Leave Modal -->
                                        <div class="modal custom-modal fade" id="approve_leave{{ $data->id }}"
                                            role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('admin.view-staff.leaves.update', ['id' => $data->id]) }}#leaves">
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
                                <form method="POST" action="{{ route('admin.view-staff.leaves.store') }}#leaves">
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
                                        <label>Leave Reason </label>
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

            <div id="teams" class="pro-overview tab-pane fade show ">
                <!-- Page Content -->
                <div class="content container-fluid">

                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">My Teams </h3>
                            </div>
                            <div class="col-auto float-end ms-auto">

                                <a class="btn add-btn ms-2" data-bs-toggle="modal" data-bs-target="#new_absence_teams"><i
                                        class="fa fa-plus"></i> New Absence</a>
                                <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#report_sick_teams"><i
                                        class="fa fa-plus"></i> Report Sick</a>

                                <!-- Request Absence Modal -->
                                <div id="new_absence_teams" class="modal custom-modal fade" role="dialog">
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
                                                    action="{{ route('admin.newabsence.store') }}#leaves">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Select Employee <span
                                                                        class="text-danger">*</span></label>
                                                                <select class="select form-control" name="employee_id">
                                                                    <option>Select Employee</option>
                                                                    @foreach ($allEmployee as $data)
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
                                                                <input class="form-control" type="date" name="from"
                                                                    onchange="calculateDays()">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Until</label>
                                                                <input class="form-control" type="date" name="to"
                                                                    onchange="calculateDays()">
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
                                                                <input type="radio" name="afternoon" id="afternoon">
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
                                                                <textarea class="form-control" name="note" cols="3"
                                                                    rows="3"></textarea>
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
                                                                <label class="col-form-label ms-3">Reserved | will not
                                                                    be sent to
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
                                <div id="report_sick_teams" class="modal custom-modal fade" role="dialog">
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
                                                    <input type="hidden" name="no_of_days" value="0">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Select Employee <span
                                                                        class="text-danger">*</span></label>
                                                                <select class="select form-control" name="employee_id">
                                                                    @foreach ($allEmployee as $data)
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
                                                                <input class="form-control" type="date" name="from">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Until</label>
                                                                <input class="form-control" type="date" name="to">
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
                                                                <input type="radio" name="afternoon" id="afternoon">
                                                                <label class="col-form-label ms-3">Afternoon </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">note </label>
                                                                <textarea class="form-control" name="note" cols="3"
                                                                    rows="3"></textarea>
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

                    <div class="text-center mt-3">
                        <button id="prevMonth" class="btn btn-outline-primary">&larr;</button>
                        <h3 class="d-inline mx-3" id="currentMonth">{{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                        <button id="nextMonth" class="btn btn-outline-primary">&rarr;</button>
                    </div><input type="hidden" id="currentMonthValue"
                        value="{{ \Carbon\Carbon::now()->format('Y-m') }}">
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
                                <select class="form-control" id="teamSelect" aria-label="Add Team">
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
                        document.addEventListener('DOMContentLoaded', function () {
                            const currentMonthElement = document.getElementById('currentMonth');
                            const currentMonthValue = document.getElementById('currentMonthValue');

                            // Function to update the displayed month and hidden value
                            const updateMonthDisplay = (date) => {
                                const options = { year: 'numeric', month: 'long' };
                                currentMonthElement.textContent = date.toLocaleDateString('en-US', options);
                                currentMonthValue.value = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
                            };

                            // Parse the initial hidden input value as a Date
                            const parseDate = (value) => {
                                const [year, month] = value.split('-');
                                return new Date(year, month - 1, 1); // Month is zero-based in JavaScript
                            };

                            // Set up event listeners for buttons
                            document.getElementById('prevMonth').addEventListener('click', () => {
                                const currentDate = parseDate(currentMonthValue.value);
                                currentDate.setMonth(currentDate.getMonth() - 1);
                                updateMonthDisplay(currentDate);
                            });

                            document.getElementById('nextMonth').addEventListener('click', () => {
                                const currentDate = parseDate(currentMonthValue.value);
                                currentDate.setMonth(currentDate.getMonth() + 1);
                                updateMonthDisplay(currentDate);
                            });

                            // Initialize the display
                            updateMonthDisplay(parseDate(currentMonthValue.value));
                        });


                            $(document).ready(function() {
                                const baseUrl = "{{ url('/') }}";

                                // Fetch departments on page load
                                $.ajax({
                                    url: baseUrl + '/admin/get-departments',
                                    method: 'GET',
                                    success: function(response) {
                                        let html = '';
                                        response.departments.forEach((dept, index) => {
                                            html += `
                                                <div class="department mb-3" id="department-${index}">
                                                    <div class="department-header bg-secondary text-white p-2 rounded d-flex justify-content-between align-items-center" style="cursor: pointer;" data-department="${dept}" data-index="${index}">
                                                        <h5 class="fw-bold">${dept} <i class="fa fa-caret-down"></i></h5>
                                                        <button class="btn btn-primary btn-sm close-department" data-department="${dept}" data-index="${index}">
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

                                // Close department and add to dropdowns
                                $(document).on('click', '.close-department', function() {
                                    const department = $(this).data('department');
                                    const index = $(this).data('index');

                                    $(`#department-${index}`).hide();
                                    addToDropdowns(department);
                                });

                                // Add department to both dropdowns
                                function addToDropdowns(department) {
                                    const teamOption = `<option value="${department}">${department}</option>`;
                                    const coworkerOption = `<option class="coworker-dept-option" data-department="${department}">${department}</option>`;

                                    if (!$(`#teamSelect option[value="${department}"]`).length) {
                                        $('#teamSelect').append(teamOption);
                                    }

                                    fetchEmployeesForCoworkerDropdown(department);
                                }
                                // Function to fetch employees and populate the Coworker dropdown
                                function fetchEmployeesForCoworkerDropdown(department) {
                                    const coworkerDropdown = $('#coworkerSelect');

                                    $.ajax({
                                        url: `${baseUrl}/admin/get-employees/${department}`,
                                        method: 'GET',
                                        success: function(response) {
                                            response.users.forEach(user => {
                                                const coworkerOption = `
                                                    <option value="${user.id}" data-department="${department}">
                                                        ${user.first_name} ${user.last_name}
                                                    </option>`;
                                                if (!$(`#coworkerSelect option[value="${user.id}"]`).length) {
                                                    coworkerDropdown.append(coworkerOption);
                                                }
                                            });
                                        },
                                        error: function(error) {
                                            console.error(`Failed to fetch employees for department ${department}:`, error);
                                        }
                                    });
                                }
                                // Restore department on selecting from Team dropdown
                                $('#teamSelect').on('change', function() {
                                    const selectedDepartment = $(this).val();
                                    if (selectedDepartment) {
                                        const departmentElement = $(`.department-header[data-department="${selectedDepartment}"]`).closest('.department');
                                        departmentElement.show();

                                        $(this).find(`option[value="${selectedDepartment}"]`).remove();
                                    }
                                });

                                // Show employee data on selecting from Coworker dropdown
                                $('#coworkerSelect').on('change', function() {
                                    const selectedOption = $(this).find(':selected');
                                    const employeeId = selectedOption.val();
                                    const department = selectedOption.data('department');

                                    if (employeeId && department) {
                                        const departmentElement = $(`.department-header[data-department="${department}"]`).closest('.department');
                                        departmentElement.show();

                                        fetchAndShowEmployeeDetails(employeeId, department);

                                        $(this).find(`option[value="${employeeId}"]`).remove();
                                    }
                                });

                                // Fetch and display employee details
                                function fetchAndShowEmployeeDetails(employeeId, department) {
                                    const employeesContainer = $(`.department-header[data-department="${department}"]`)
                                        .closest('.department')
                                        .find('.employees');

                                    if (employeesContainer.length > 0) {
                                        $.ajax({
                                            url: baseUrl + `/admin/get-employee/${employeeId}`,
                                            method: 'GET',
                                            success: function(response) {
                                                const employee = response.user;
                                                const html = generateCalendar(employee, department);

                                                employeesContainer.append(html).removeClass('d-none');
                                            },
                                            error: function(error) {
                                                console.error(`Failed to fetch details for employee ID ${employeeId}:`, error);
                                            }
                                        });
                                    }
                                }

                                // Expand/Collapse department
                                $(document).on('click', '.department-header', function() {
                                    const department = $(this).data('department');
                                    const index = $(this).data('index');
                                    const employeesContainer = $(`#employees-${index}`);

                                    if (employeesContainer.hasClass('d-none')) {
                                        fetchEmployeesForDepartment(department, employeesContainer);
                                    } else {
                                        employeesContainer.addClass('d-none');
                                    }

                                    $(this).find('i').toggleClass('fa-caret-down fa-caret-up');
                                });

                                // Fetch employees for department
                                function fetchEmployeesForDepartment(department, container) {
                                    $.ajax({
                                        url: baseUrl + `/admin/get-employees/${department}`,
                                        method: 'GET',
                                        success: function(response) {
                                            let html = '<div class="row">';
                                            response.users.forEach(user => {
                                                html += generateCalendar(user, department);
                                            });
                                            html += '</div>';

                                            container.html(html).removeClass('d-none');
                                        },
                                        error: function(error) {
                                            console.error(`Failed to fetch employees for department ${department}:`, error);
                                        }
                                    });
                                }
                                function processLeavesData(leavesData) {
                                            const processedData = [];

                                            leavesData.forEach(leave => {
                                                const leaveType = leave.leave_type;
                                                const fromDate = new Date(leave.from);
                                                const toDate = new Date(leave.to);

                                                // Generate dates between 'from' and 'to'
                                                for (let date = new Date(fromDate); date <= toDate; date.setDate(date.getDate() + 1)) {
                                                    processedData.push({
                                                        day: date.getDate(), // Extract day
                                                        month: date.getMonth() + 1, // Extract month (0-based)
                                                        year: date.getFullYear(), // Extract year
                                                        type: leaveType // Leave type
                                                    });
                                                }
                                            });

                                            return processedData;
                                        }

                                        function generateCalendar(user, department) {
                                            // Get the month and year from the DOM
                                            const textContent = document.getElementById('currentMonth').textContent;
                                            const [monthName, dynaYear] = textContent.split(" ");

                                            const monthMap = {
                                                January: 1, February: 2, March: 3, April: 4,
                                                May: 5, June: 6, July: 7, August: 8,
                                                September: 9, October: 10, November: 11, December: 12
                                            };

                                            const currentMonth = monthMap[monthName];
                                            const currentYear = parseInt(dynaYear);

                                            // Preprocess the user's leave data
                                            const leaveDays = processLeavesData(user.leavesData).filter(leave =>
                                                leave.month === currentMonth && leave.year === currentYear
                                            );

                                            // Rest of the generateCalendar function
                                            const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
                                            const firstDayOfMonth = new Date(currentYear, currentMonth - 1, 1).getDay();

                                            let calendarHtml = `
                                                <div class="employee-card card mb-3 col-6">
                                                    <div class="card-body">
                                                        <h5 class="card-title">${user.first_name} ${user.last_name}</h5>
                                                        <div class="calendar" style="float:none!important;">
                                                            <div class="week-days my-2 d-flex justify-content-between">
                                                                ${['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].map(day => `
                                                                    <div class="day-header" style="width: 14%; font-weight: bold; text-align: center;">${day}</div>
                                                                `).join('')}
                                                            </div>
                                                            <div class="month-weeks">
                                            `;

                                            for (let week = 0; week < Math.ceil((daysInMonth + firstDayOfMonth) / 7); week++) {
                                                calendarHtml += '<div class="week d-flex">';
                                                for (let day = 0; day < 7; day++) {
                                                    const currentDay = week * 7 + day - firstDayOfMonth + 1;
                                                    const leaveDayData = leaveDays.find(leave => leave.day === currentDay);
                                                    const leaveColor = leaveDayData ? getLeaveTypeColor(leaveDayData.type) : '';

                                                    if (currentDay > 0 && currentDay <= daysInMonth) {
                                                        calendarHtml += `
                                                            <div class="day mb-2 ms-2" style="width: 30%; height: 40px; text-align: center; line-height: 50px; ${leaveColor ? `background-color: ${leaveColor}; font-weight: bold; color: white;` : ''}">
                                                                ${currentDay}
                                                            </div>
                                                        `;
                                                    } else {
                                                        calendarHtml += '<div class="day empty-day mb-2 ms-2" style="width: 30%; height: 40px;"></div>';
                                                    }
                                                }
                                                calendarHtml += '</div>';
                                            }

                                            calendarHtml += `
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;

                                            return calendarHtml;
                                        }
                            });
                    </script>




                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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
            <div id="approved-airlines" class="pro-overview tab-pane fade show ">
                <!-- Page Content -->
                <div class="content container-fluid">
                    <div class="row">
                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                            <a class="btn add-btn" style="margin-right:10px; border-radius:10px !important;"
                                data-bs-toggle="modal" data-bs-target="#add_approvedStaff"><i class="fa fa-plus"></i>
                                Add/Edit Approved Staff</a>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold">Airline
                                            </th>
                                            @foreach ($duty as $ft)
                                            <th class="fw-bold">
                                                {{ $ft->name }}</th>
                                            @endforeach
                                            <th>Created On</th>
                                            <th>Created By</th>
                                            <th>Updated On</th>
                                            <th>Updated By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($airlineDetails as $air)
                                        <tr>
                                            <div class="form-group">
                                                <input class="form-control" type="hidden" name="staff_id"
                                                    value="{{ $employees->id ?? 0}}">

                                                <input class="form-control" type="hidden" name="updated_at" value="  ">
                                            </div>
                                            <th class="fw-bold">
                                                {{ $air->airline->airline_name }}</th>
                                            @foreach ($duty as $ft)
                                            @php
                                            $approvedStaff = DB::table('approved_staffs')
                                            ->where('staff_id', $employees->id)
                                            ->where('duties', $ft->name)
                                            ->where('airline_id', $air->airline_id)
                                            ->first();
                                            @endphp
                                            <input type="hidden" name="staff[{{ $air->id }}][{{ $ft->name }}]"
                                                value="2">
                                            <th>
                                                <input type="checkbox" name="staff[{{ $air->id }}][{{ $ft->name }}]"
                                                    value="1" {{ $approvedStaff && $approvedStaff->status == 1 ?
                                                'checked' : '' }}>
                                            </th>
                                            @endforeach
                                            <td>{{ $approvedStaff->created_at ?? 'N/A' }}</td>
                                            <td>{{ $approvedStaff->created_by ?? 'N/A' }}</td>
                                            <td>{{ $approvedStaff->updated_at ?? 'N/A' }}</td>
                                            <td>{{ $approvedStaff->updated_by ?? 'N/A' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="add_approvedStaff" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Approved Staff</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.staff.approved-staff-rights.store') }}#approved-airlines"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="fw-bold">Airline
                                                    </th>
                                                    @foreach ($duty as $ft)
                                                    <th class="fw-bold">
                                                        {{ $ft->name }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($airlineDetails as $air)
                                                <tr>
                                                    <div class="form-group">
                                                        <input class="form-control" type="hidden" name="staff_id"
                                                            value="{{ $employees->id ?? 0}}">

                                                        <input class="form-control" type="hidden" name="updated_at"
                                                            value="  ">

                                                        <input class="form-control" type="hidden" name="created_by"
                                                            value="{{auth()->user()->name}}">
                                                    </div>
                                                    <th class="fw-bold">
                                                        {{ $air->airline->airline_name }}</th>
                                                    @foreach ($duty as $ft)
                                                    @php
                                                    $approvedStaff = DB::table('approved_staffs')
                                                    ->where('staff_id', $employees->id)
                                                    ->where('duties', $ft->name)
                                                    ->where('airline_id', $air->airline_id)
                                                    ->first();
                                                    @endphp
                                                    <input type="hidden"
                                                        name="airline[{{ $air->airline_id }}][{{ $ft->name }}]"
                                                        value="2">
                                                    <th>
                                                        <input type="checkbox"
                                                            name="airline[{{ $air->airline_id }}][{{ $ft->name }}]"
                                                            value="1" {{ $approvedStaff && $approvedStaff->status == 1 ?
                                                        'checked' : '' }}>
                                                    </th>
                                                    @endforeach
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>
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
                                <form method="POST" action="{{ route('admin.view-staff.leaves.store') }}#leaves">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.0/main.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.0/main.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>


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



            function calculateDays1() {
                    const fromDate = document.getElementById('from1').value;
                    const toDate = document.getElementById('to1').value;
                    const noOfDaysInput = document.getElementById('no_of_days1');

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
    </script>

    <script>
        // document.addEventListener("DOMContentLoaded", function() {
            //     let currentDate = new Date(); // Initialize with the current date
            //     let today = new Date();

            //     // Example leave days array
            //     let leaveDays = [2, 5, 12, 18]; // Modify this array or pass it dynamically from your backend

            //     // Function to render the calendar
            //     function renderCalendar(date) {

            //         const monthYearDisplay = document.getElementById('currentMonth');
            //         const calendarContainer = document.getElementById('calendarContainer');
            //         const prevButton = document.getElementById('prevMonth');

            //         const month = date.getMonth(); // Current month (0-11)
            //         const year = date.getFullYear(); // Current year
            //         const daysInMonth = new Date(year, month, 0).getDate(); // Get days in month
            //         const startOfMonth = new Date(year, month, 1).getDay(); // Get first day of the month (0-6)

            //         // Update the month and year display
            //         const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
            //             "September", "October", "November", "December"
            //         ];
            //         monthYearDisplay.textContent = `${monthNames[month]} ${year}`;

            //         // Disable the "Previous" button if viewing the current month
            //         // if (date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear()) {
            //         //     prevButton.disabled = true;
            //         // } else {
            //         //     prevButton.disabled = false;
            //         // }

            //         // Create the calendar HTML
            //         let calendarHTML = '<div class="row">';
            //         const weekdays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            //         weekdays.forEach(day => calendarHTML += `<div class="day mb-2">${day}</div>`);
            //         calendarHTML += '</div><div class="row">';

            //         // Add empty cells for days before the first day of the month
            //         let emptyCells = (startOfMonth === 0 ? 6 : startOfMonth - 1); // Adjust for Sunday (0 index in JS)
            //         for (let i = 0; i < emptyCells; i++) {
            //             calendarHTML += '<div class="day mb-2"></div>';
            //         }

            //         // Add the days of the month with leave day highlighting
            //         for (let i = 1; i <= daysInMonth; i++) {
            //             // Check if it's a leave day
            //             let isLeaveDay = leaveDays.includes(i);

            //             // Apply styles for leave days
            //             let dayStyle = isLeaveDay ? 'style="background-color: black; color: white;"' : '';
            //             calendarHTML += `<div class="day mb-2" ${dayStyle}>${i}</div>`;

            //             // Break row after every 7 days
            //             if ((i + emptyCells) % 7 === 0) {
            //                 calendarHTML += '</div><div class="row">';
            //             }
            //         }
            //         calendarHTML += '</div>';

            //         // Update the calendar container with the new HTML
            //         calendarContainer.innerHTML = calendarHTML;
            //     }

            //     // Event listeners for prev/next buttons
            //     document.getElementById('prevMonth').addEventListener('click', function() {
            //         currentDate.setMonth(currentDate.getMonth() - 1); // Move to the previous month
            //         renderCalendar(currentDate);
            //     });

            //     document.getElementById('nextMonth').addEventListener('click', function() {
            //         currentDate.setMonth(currentDate.getMonth() + 1); // Move to the next month
            //         renderCalendar(currentDate);
            //     });

            //     // Initial render
            //     renderCalendar(currentDate);
            // });
    </script>
    <script>
        // function calculateDays() {
            //     const fromDate = document.querySelector('input[name="from"]').value;
            //     const toDate = document.querySelector('input[name="to"]').value;
            //     const noOfDaysInput = document.querySelector('input[name="no_of_days"]');

            //     if (fromDate && toDate) {
            //         const from = new Date(fromDate);
            //         const to = new Date(toDate);
            //         const timeDifference = to - from;
            //         const daysDifference = timeDifference / (1000 * 3600 * 24);

            //         noOfDaysInput.value = daysDifference >= 0 ? daysDifference + 1 : 0;
            //     } else {
            //         noOfDaysInput.value = '';
            //     }
            // }
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
    if (enteredDate.getFullYear() < currentYear ) {
      alert("Please enter a valid year either with current year or with future year.");
      dateInput.value = ''; // Clear the invalid input
    }
  });
    </script>
    @endsection
