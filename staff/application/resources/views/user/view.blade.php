<!DOCTYPE html>
<html lang="en" class="{{ auth()->user()->type ?? '' }} {{ config('visibility.page_rendering') }}">
@php
    use Carbon\Carbon;
@endphp
<!--CRM - GROWCRM.IO-->
@include('layout.header')
@include('nav.topnav')
@include('nav.leftmenu')

<!--page wrapper-->
<div class="page-wrapper">
    <!--overlay-->
    <div class="page-wrapper-overlay js-close-side-panels hidden" data-target=""></div>
    <!--overlay-->
    @if(config('visibility.page_rendering') == '' || config('visibility.page_rendering') != 'print-page')
        <div class="preloader">
            <div class="loader">
                <div class="loader-loading"></div>
            </div>
        </div>
    @endif
    <!--preloader-->

    <body id="main-body"
        class="loggedin fix-header card-no-border fix-sidebar {{ config('settings.css_kanban') }} {{ runtimePreferenceLeftmenuPosition(auth()->user()->left_menu_position) }} {{ $page['page'] ?? '' }}">
        <!--main wrapper-->
        <div id="main-wrapper">
            <div class="container profile-container">
                <h4>Profile</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="profile-card">
                            <div class="col-md-1">
                                <img src="{{ asset('storage/avatars/'.$agent->avatar_directory.'/'.$agent->avatar_filename) }}" alt="Profile Image">
                            </div>
                            <div class="col-md-5" style="padding: 0 35px;border-right: dotted;">
                                <h5>{{$agent->first_name}} {{$agent->last_name}}</h5>
                                <p>Date of Creation: {{Carbon::parse($agent->created_at)->format('jS M Y')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <span style="font-weight: bold;">Unique ID:</span> <a style="display: inline;position: absolute;">{{$agent->unique_id}}</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span style="font-weight: bold;">Email:</span> <a style="display: inline;position: absolute;">{{$agent->email}}</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span style="font-weight: bold;">Phone:</span> <a style="display: inline;position: absolute;">{{$agent->phone}}</a>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="row nav nav-tabs">
    <button class="tablinks btn btn-default" onclick="openCity(event, 'General')">General</button>
    <button class="tablinks btn btn-default" onclick="openCity(event, 'MyOverview')">My Overview</button>
    <button class="tablinks btn btn-default" onclick="openCity(event, 'MyColleagues')">My Colleagues</button>
    <button class="tablinks btn btn-default" onclick="openCity(event, 'Applications')">Applications</button>
    <button class="tablinks btn btn-default" onclick="openCity(event, 'TrainingCertificates')">Training & Certificates</button>
    <button class="tablinks btn btn-default" onclick="openCity(event, 'ReadandSign')">Read & Sign</button>
    <button class="tablinks btn btn-default" onclick="openCity(event, 'Library')">Library</button>
    <button class="tablinks btn btn-default" onclick="openCity(event, 'LastRequestForm')">Last Request Form</button>
</div>

<!-- General Tab Content -->
<div id="General" class="tabcontent active">
     <div class="card">
                        <div class="card-body">
                                    <div class="row">
                                        <!-- Left column for user image -->
                                        <div class="col-md-4 text-center">
                                            <img src="{{ auth()->user()->avatar }}" class="rounded-circle bg-secondary" width="124px" style="margin-top:10px">
                                            <!-- Button with ID below the image -->
                                            <div class="row" style="justify-content: center;">

                                        </div>
                                        </div>

                                        <!-- Right column for user details -->
                                        <div class="col-md-8">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>First Name</strong></td>
                                                        <td>{{$agent->first_name}} </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Last Name</strong></td>
                                                        <td>{{$agent->last_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email</strong></td>
                                                        <td>{{$agent->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>DOB</strong></td>
                                                        <td>{{$agent->dob}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>DOJ</strong></td>
                                                        <td>{{$agent->joining_date}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Branch</strong></td>
                                                        <td>{{$agent->branch}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Department</strong></td>
                                                        <td>{{$agent->department}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Position</strong></td>
                                                        <td>{{$agent->position}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Work Type</strong></td>
                                                        <td>{{$agent->work_type}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Phone Mobile (Personal)</strong></td>
                                                        <td>{{$agent->personal_phone}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Mobile (Company)</strong></td>
                                                        <td>{{$agent->company_mobile}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Company</strong></td>
                                                        <td>{{$agent->client_company_name}}</td>
                                                    </tr>



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                        </div>
                    </div>
                    </div>

<!-- My Overview Tab Content -->
<div id="MyOverview" class="tabcontent">

    <div class="card">
        <div class="card-body">
        <div class="container">
        <div class="month-dates">

            <div id="monthDateList"></div>
        </div>
    </div>


        </div>
    </div>
</div>

<style>



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
    width: 88px; /* Fixed width for month names */
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

function getDaysInMonth(month) {
    const date = new Date(2024, month + 1, 0); // Get the last date of the month
    return date.getDate();
}

document.addEventListener("DOMContentLoaded", () => {
    const monthDateList = document.getElementById("monthDateList");

    monthNames.forEach((month, index) => {
        const monthDateDiv = document.createElement("div");
        monthDateDiv.classList.add("month-date");

        const monthDiv = document.createElement("div");
        monthDiv.classList.add("month");
        monthDiv.textContent = month;

        const datesDiv = document.createElement("div");
        datesDiv.classList.add("dates");

        const days = getDaysInMonth(index);
        for (let day = 1; day <= days; day++) {
            const dateDiv = document.createElement("div");
            dateDiv.classList.add("date");
            dateDiv.textContent = day;
            datesDiv.appendChild(dateDiv);
        }

        monthDateDiv.appendChild(monthDiv);
        monthDateDiv.appendChild(datesDiv);
        monthDateList.appendChild(monthDateDiv);
    });
});

</script>
<!-- My Colleagues Tab Content -->
<div id="MyColleagues" class="tabcontent">
    <div class="card">
        <div class="card-body">
            <p>My Colleagues content goes here.</p>
        </div>
    </div>
</div>



<!-- Applications Tab Content -->
<div id="Applications" class="tabcontent">
    <div class="card">
        <div class="card-body">
            <p>Applications content goes here.</p>
        </div>
    </div>
</div>

<!-- Training & Certificates Tab Content -->
<div id="TrainingCertificates" class="tabcontent">
    <div class="card">
        <div class="card-body">
            <p>Training & Certificates content goes here.</p>
        </div>
    </div>
</div>

<!-- Read & Sign Tab Content -->
<div id="ReadandSign" class="tabcontent">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Airline</th>
                        <th>Created</th>
                        <th>Last Viewed</th>
                        <th>Viewed & Signed</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">No data found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Library Tab Content -->
<div id="Library" class="tabcontent">
    <div class="card">
        <div class="card-body">
            <p>Library content goes here.</p>
        </div>
    </div>
</div>

<!-- Last Request Form Tab Content -->
<div id="LastRequestForm" class="tabcontent">
    <div class="card">
        <div class="card-body">
            <p>Last Request Form content goes here.</p>
        </div>
    </div>
</div>

<script>
    function openCity(evt, cityName) {
        // Hide all tab content
        var tabcontent = document.getElementsByClassName("tabcontent");
        for (var i = 0; i < tabcontent.length; i++) {
            tabcontent[i].classList.remove("active"); // Use classList to manage classes
        }

        // Remove active class from all buttons
        var tablinks = document.getElementsByClassName("tablinks");
        for (var i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }

        // Show the current tab and add an active class to the button that opened the tab
        document.getElementById(cityName).classList.add("active");
        evt.currentTarget.classList.add("active");
    }

    // Display the default tab (General) on page load
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('General').classList.add("active");
        document.querySelector('.tablinks').classList.add("active");
    });
</script>
<style>
        .tabcontent {
            display: none; /* Hide all tab content by default */
        }
        .tabcontent.active {
            display: block; /* Show active tab content */
        }
    </style>


        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f8f9fa;
                margin: 0;
                padding: 0;
            }
            .breadcrumb {
                background-color: transparent;
                padding: 0;
                margin-bottom: 15px;
            }
            .breadcrumb-item+.breadcrumb-item::before {
                content: "/";
            }
            .profile-container {
                padding: 20px;
            }
            .profile-card {
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
                display: flex;
                align-items: center;
                width: 1098px;
                height: 160px;
                margin-left: -2px;
            }
            .profile-card img {
                border-radius: 50%;
                width: 80px;
                height: 80px;
                margin-right: 20px;
            }
            .wallet-request-card {
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
            }
            .profile-info {
                flex-grow: 1;
            }
            .profile-info h5 {
                margin: 0;
                font-weight: bold;
            }
            .profile-info p {
                margin: 0;
                color: #6c757d;
            }
            .profile-email {
                margin-left: auto;
                text-align: right;
            }
            .profile-email span {
                font-weight: bold;
            }
            .profile-email a {
                color: #007bff;
                text-decoration: none;
            }
            .profile-email a:hover {
                text-decoration: underline;
            }
            .nav-tabs {
                border-bottom: 1px solid #dee2e6;
                position: relative;
                margin-left: 3px !important;
                margin: 5px 0px !important;
                background: #fff;
                border-radius: 5px;
            }
            button.tablinks {
    background: #fff;
    margin-right: 5px;
    border: none;
}
        </style>
        <script src="{{ asset('public/js/core/app.js') }}"></script>
        <script src="{{ asset('public/css/custom.css') }}"></script>
        @include('modals.actions-modal-wrapper')
        @include('modals.common-modal-wrapper')
        @include('modals.plain-modal-wrapper')
        @include('pages.authentication.modal.relogin')
        @include('modals.create')
        @include('layout.footerjs')
        @include('layout.automationjs')
        {!! config('system.settings_theme_body') !!}

    </body>

    <script>
        // Function to calculate number of days between two dates
        function calculateDays() {
            var from_date = document.getElementById('from').value;
            var to_date = document.getElementById('to').value;

            if (from_date && to_date) {
                // Calculate number of days between dates
                var startDate = new Date(from_date);
                var endDate = new Date(to_date);
                var timeDiff = endDate.getTime() - startDate.getTime();
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                // Update number of days field
                document.getElementById('no_of_days').value = diffDays + 1; // Include both start and end dates

                // // Calculate remaining leaves (assuming 12 as default total)
                // var totalLeaves = 12;
                // var usedLeaves = 0; // You need to implement logic to fetch used leaves dynamically

                // var remainingLeaves = totalLeaves - usedLeaves;
                // document.getElementById('remaining_leaves').value = remainingLeaves;
            }
        }

        // Attach event listeners to from and to date inputs
        document.getElementById('from').addEventListener('change', calculateDays);
        document.getElementById('to').addEventListener('change', calculateDays);

        // Calculate days on page load (if you want initial calculation)
        calculateDays();
    </script>
    @if(config('visibility.page_rendering') == 'print-page')
        <script src="{{ asset('/public/js/dynamic/print.js?v=') }}{{ config('system.versioning') }}"></script>
    @endif
</div>
</html>
