<link rel="stylesheet" href="<?php echo e(asset('public/css/custom-style.css')); ?>">

<?php
    use Carbon\Carbon;
?>
<!-- Page Content -->
<div class="content container-fluid">
    <!-- <div class="row">
        <div class="col-md-12">
            <div class="welcome-box">
                <div class="welcome-img">
                    <img alt="" src="<?php echo e(auth()->user()->avatar); ?>" style="height: 60px; width: 60px; border-radius: 8px; float: left; margin: 2px 8px 0px 8px;">
                </div>
                <div class="welcome-det">
                    <h3>Welcome, <?php echo e(auth()->user()->first_name); ?> <?php echo e(auth()->user()->last_name); ?></h3>
                    <p><?php echo e(Carbon::now()->format('l, d F Y')); ?></p>
                </div>
            </div>
        </div>
    </div> -->



    <div class="page-wrapper">

            <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <!-- <h3 class="page-title">Employee</h3> -->
                        <!-- <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                        </ul> -->
                    </div>
                    <div class="col-auto float-end ms-auto">

                        
                    </div>
                </div>
            </div>
            <!-- /Page Header -->


            <div class="">
                <div class="content-container text-light">
                    <div class="row">

                    <div class="col-md-4" style="text-align: center;">
                            <div class="card bg-white text-dark" style="width:325px!important; height: 21pc;">
                                <h3 class="mt-3 text-dark">Hello, <?php echo e(auth()->user()->first_name); ?> <?php echo e(auth()->user()->last_name); ?></h3>

                                <div class="text-danger">
                                   <b> <?php echo e(now()->format('l, F j, Y')); ?> </b>
                                </div>

                                <div class="row" style="place-content: center;">
                                <img src="<?php echo e(auth()->user()->avatar); ?>" class="rounded-circle bg-secondary" width="124px" style="margin-top:10px">
                                </div>

                                <h6 style="margin-top: 2.90rem !important;font-size: 16px;font-weight: 600;color:#575757;">Welcome back, <br> here is your personal overview</h6>
                            </div>
                        </div>

                        <div class="col-md-4" style="text-align: center;">
                            <div class="card bg-white text-dark " style="width:325px!important; height: 21pc;">
                                <h4 class="mt-3">Vacation days remaining </h4>
                                <div class="progress-circle mt-2">
                                <svg class="progress-circle-svg" viewBox="0 0 100 100">
                                        <circle class="progress-circle-background" cx="50" cy="50" r="45"></circle>
                                        <circle class="progress-circle-bar" cx="50" cy="50" r="45" stroke-dasharray="283" stroke-dashoffset="12" style="transition: stroke-dashoffset 0.35s;"></circle>
                                        <text x="50" y="52" text-anchor="middle" alignment-baseline="middle" class="progress-text"><?php echo e($payload['remainingLeave'] ?? 'N/A'); ?></text>
                                    </svg>


                                    <div class="progress-text"></div>
                                </div>
                                <div style="padding: 0px 24px;">
                                <p class="mt-5">You still have <?php echo e($payload['remainingLeave'] ?? 'N/A'); ?> vacation days left from this year.</p>
                                <p class="fw-bold">Last year holidays will lapse if not utilized before 31 March 2025.</p>

                                <div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="text-align: center;">
                            <div class="card bg-white text-dark " style="width:325px!important; height: 21pc;">
                                <div class="wrapper">

                                <h4 class="mt-3">Current Month </h4>
                                    <div id="right">

                                        <div class="button-container-calendar" style="display: flex;    width: 100%;    justify-content: space-between;">
                                            <button id="previous" onclick="previous()">
                                                ‹
                                            </button>
                                            <h3 id="monthAndYear"></h3>
                                            <button id="next" onclick="next()">
                                                ›
                                            </button>
                                        </div>
                                        <table class="table-calendar" id="calendar" data-lang="en">
                                            <thead id="thead-month"></thead>
                                            <!-- Table body for displaying the calendar -->
                                            <tbody id="calendar-body"></tbody>
                                        </table>
                                        <div class="footer-container-calendar">

                                            <!-- Dropdowns to select a specific month and year -->
                                            <select id="month">
                                                <option value=0>Jan</option>
                                                <option value=1>Feb</option>
                                                <option value=2>Mar</option>
                                                <option value=3>Apr</option>
                                                <option value=4>May</option>
                                                <option value=5>Jun</option>
                                                <option value=6>Jul</option>
                                                <option value=7>Aug</option>
                                                <option value=8>Sep</option>
                                                <option value=9>Oct</option>
                                                <option value=10>Nov</option>
                                                <option value=11>Dec</option>
                                            </select>
                                            <!-- Dropdown to select a specific year -->
                                            <select id="year" onchange="jump()"></select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="text-align: center;">
                            <div class="card bg-white text-dark " style="width:325px!important; height: 21pc;">
                                <p class="mt-3 fw-bold">Absence of Your Colleagues</p>

                                <ul class="list-unstyled" style="margin-top: 2rem !important;">
                                    <?php $__empty_1 = true; $__currentLoopData = $payload['absent_colleagues']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li><?php echo e(optional($leave->employee)->first_name); ?> <?php echo e(optional($leave->employee)->last_name); ?>(<?php echo e($leave->leave_type); ?>)</li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <p style="margin-top: 9.50rem !important;color:black" class="fw-bold">No colleagues are absent today.</p>
                                    <?php endif; ?>
                                </ul>
                             </div>
                        </div>
                        <div class="col-md-4" style="">

                        <div class="row">

                                <div class="card" style="width: 20.3pc; height: 102px;">

                                    <div class="row">
                                        <div class="col-md-4" style="text-align: -webkit-right;">
                                            <p class="bg-info stv ms-4 mt-4" style="    text-align: center;"><span
                                                    class="mt-5 text-white dtxt fw-bold"><?php echo e($payload['noofpresentemployeestoday']); ?> / <?php echo e($payload['total_employee']); ?></span></p>
                                        </div>


                                        <div class="col-md-8" style="text-align: center;">
                                            <p class="fw-bold text-dark txt">Today Presents</p>
                                        </div>
                                    </div>

                                </div>

                                <div class="card" style="width: 20.3pc; height: 102px;">

                                    <div class="row">
                                        <div class="col-md-4" style="text-align: -webkit-right;">
                                            <p class="bg-warning stv ms-4 mt-4" style="    text-align: center;"><span
                                                    class="mt-5 text-white dtxt fw-bold"><?php echo e($payload['total_leaves'] ?? 'N/A'); ?></span></p>
                                        </div>


                                        <div class="col-md-8" style="text-align: center;">
                                            <p class="fw-bold text-dark txt">
                                    Total Leaves</p>
                                        </div>
                                    </div>

                                    </div>


                                    <div class="card" style="width: 20.3pc; height: 102px;">

                                    <div class="row">
                                        <div class="col-md-4" style="text-align: -webkit-right;">
                                            <p class="bg-primary stv ms-4 mt-4" style="    text-align: center;"><span
                                                    class="mt-5 text-white dtxt fw-bold"><?php echo e($payload['total_pending_leaves'] ?? 'N/A'); ?></span></p>
                                        </div>


                                        <div class="col-md-8" style="text-align: center;">
                                            <p class="fw-bold text-dark txt">
                                            Pending Requests</p>
                                        </div>
                                    </div>

                                    </div>







                            </div>



                            </div>


                            <div class="col-md-4">
                        <div class="card bg-white text-dark" style="width: 318px!important; height: auto;">
                            <div class="container mt-2">
                                <form method="post" action="<?php echo e(route('leaves.store')); ?>" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="employee_id" value="">
                                    <h6 class="card-title" style="text-align: center;">Enter Quick Absence</h6>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="absence-type" class="form-label">Absence Type</label>
                                            <select class="form-control" name="leave_type" id="leave_type">

                                            <option>Select Leave Type</option>
                                            <option>Casual Leave</option>
                                            <option>Medical Leave</option>
                                            <option>Loss of Pay</option>
                                            </select>
                                        </div>
                                        <div class="row ">
                                            <div class="col-md-6">
                                        <div class="form-group">
                                        <label>From <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control " type="date" name="from" onchange="calculateDays()">
                                        </div>
                                    </div>
                                    </div>
                                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label>To <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control" type="date" name="to" onchange="calculateDays()">
                                        </div>
                                    </div>
                                         </div>
                                        </div>
                                        <input class="form-control" readonly type="hidden" name="no_of_days">

                                      <div class="form-group">
                                        <label>Leave Reason <span class="text-danger">*</span></label>
                                        <textarea rows="2" name="reason" class="form-control"></textarea>
                                    </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- /Page Wrapper -->
</div>
<!-- /Page Content -->

<style>
.progress-text {
    font-size: 20px; /* Adjust the font size */
    fill: black;     /* Set the text color */
    font-weight: bold; /* Optional: make the text bold */
    dominant-baseline: middle; /* Ensures vertical alignment */
    text-align: center; /* Center-align the text */
    font-family: Arial, sans-serif; /* Use a standard font family */
}
</style>

<style>
.stv {
    width: 69px;
    height: 51px;
    border-radius: 15px;
}
.mini-sidebar .page-wrapper {
    margin-left: 50px!important;
    padding-top: 35px!important;
}
.txt {
    margin-top: 2.25rem !important;
}

.fromm {
    margin-left: -82px;
}

.absent {
    margin-left: -172px;
}

.dtxt {
    position: relative;
    top: 15px;
}

.progress-circle {
    position: relative;
    width: 288px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.progress-circle-svg {

    width: 100%;
    height: 100%;
}

.progress-circle-background {
    fill: none;
    stroke: #e6e6e6;
    stroke-width: 10;
}

.progress-circle-bar {
    fill: none;
    stroke: green;
    stroke-width: 10;
    stroke-linecap: round;
    transition: stroke-dashoffset 0.3s;
}

.progress-text {
    position: absolute;
    font-size: 1.2em;
    color: #000;
    font-weight: bold;
}


/* General styling for the entire page */
body {
    font-family: Arial, sans-serif;
    background-color: white;
    margin: 0;
}

.wrapper {
    max-width: 1100px;
    margin: 15px auto;
}

/* Calendar container */
.container-calendar {
    background: #ffffff;
    padding: 15px;
    max-width: 900px;
    margin: 0 auto;
    overflow: auto;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: space-between;
}

/* Event section styling */
#event-section {
    padding: 10px;
    background: #f5f5f5;
    margin: 20px 0;
    border: 1px solid #ccc;
}

#month,
#year {
    display: none;
    /* or remove this block */
}

.container-calendar #left h1 {
    color: green;
    text-align: center;
    background-color: #f2f2f2;
    margin: 0;
    padding: 10px 0;
}

#event-section h3 {
    color: green;
    font-size: 18px;
    margin: 0;
}

#event-section input[type="date"],
#event-section input[type="text"] {
    margin: 10px 0;
    padding: 5px;
    width: 80%;
}

#event-section button {
    background: green;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

.event-marker {
    position: relative;
}

.event-marker::after {
    content: '';
    display: block;
    width: 6px;
    height: 6px;
    background-color: red;
    border-radius: 50%;
    position: absolute;
    bottom: 0;
    left: 0;
}

/* event tooltip styling */
.event-tooltip {
    position: absolute;
    background-color: rgba(234, 232, 232, 0.763);
    color: black;
    padding: 10px;
    border-radius: 4px;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: none;
    transition: all 0.3s;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.event-marker:hover .event-tooltip {
    display: block;
}

/* Reminder section styling */
#reminder-section {
    padding: 10px;
    background: #f5f5f5;
    margin: 20px 0;
    border: 1px solid #ccc;
}

#reminder-section h3 {
    color: green;
    font-size: 18px;
    margin: 0;
}

#reminderList {
    list-style: none;
    padding: 0;
}

#reminderList li {
    margin: 5px 0;
    font-size: 16px;
}

/* Style for the delete buttons */
.delete-event {
    background: rgb(237, 19, 19);
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    margin-left: 10px;
    align-items: right;
}

/* Buttons in the calendar */
.button-container-calendar button {
    cursor: pointer;
    background: green;
    color: #fff;
    border: 1px solid green;
    border-radius: 4px;
    padding: 5px 10px;
}

/* Calendar table */
.table-calendar {
    border-collapse: collapse;
    width: 100%;
}

.table-calendar td,
.table-calendar th {
    padding: 4px;
    border: 1px solid #e2e2e2;
    text-align: center;
    vertical-align: top;
}

/* Date picker */
.date-picker.selected {
    background-color: #f2f2f2;
    font-weight: bold;
    outline: 1px dashed #00BCD4;
}

.date-picker.selected span {
    border-bottom: 2px solid currentColor;
}

/* Day-specific styling */
.date-picker:nth-child(1) {
    color: red;
    /* Sunday */
}

.date-picker:nth-child(6) {
    color: green;
    /* Friday */
}

/* Hover effect for date cells */
.date-picker:hover {
    background-color: green;
    color: white;
    cursor: pointer;
}

/* Header for month and year */
#monthAndYear {
    text-align: center;
    margin-top: 0;
}

/* Navigation buttons */
.button-container-calendar {
    position: relative;
    margin-bottom: 1em;
    overflow: hidden;
    clear: both;
}

#previous {
    float: left;
}

#next {
    float: right;
}


@media (min-width: 1024px){
.page-wrapper {
    margin-left: 100px!important;
}

.fix-header .page-wrapper {
    padding-top: 38px!important;
}
}
</style>

<script>
// script.js

// Define an array to store events
let events = [];

// letiables to store event input fields and reminder list
let eventDateInput =
    document.getElementById("eventDate");
let eventTitleInput =
    document.getElementById("eventTitle");
let eventDescriptionInput =
    document.getElementById("eventDescription");
let reminderList =
    document.getElementById("reminderList");

// Counter to generate unique event IDs
let eventIdCounter = 1;

// Function to add events
function addEvent() {
    let date = eventDateInput.value;
    let title = eventTitleInput.value;
    let description = eventDescriptionInput.value;

    if (date && title) {
        // Create a unique event ID
        let eventId = eventIdCounter++;

        events.push({
            id: eventId,
            date: date,
            title: title,
            description: description
        });
        showCalendar(currentMonth, currentYear);
        eventDateInput.value = "";
        eventTitleInput.value = "";
        eventDescriptionInput.value = "";
        displayReminders();
    }
}

// Function to delete an event by ID
function deleteEvent(eventId) {
    // Find the index of the event with the given ID
    let eventIndex =
        events.findIndex((event) =>
            event.id === eventId);

    if (eventIndex !== -1) {
        // Remove the event from the events array
        events.splice(eventIndex, 1);
        showCalendar(currentMonth, currentYear);
        displayReminders();
    }
}

// Function to display reminders
function displayReminders() {
    reminderList.innerHTML = "";
    for (let i = 0; i < events.length; i++) {
        let event = events[i];
        let eventDate = new Date(event.date);
        if (eventDate.getMonth() ===
            currentMonth &&
            eventDate.getFullYear() ===
            currentYear) {
            let listItem = document.createElement("li");
            listItem.innerHTML =
                `<strong>${event.title}</strong> -
          ${event.description} on
          ${eventDate.toLocaleDateString()}`;

            // Add a delete button for each reminder item
            let deleteButton =
                document.createElement("button");
            deleteButton.className = "delete-event";
            deleteButton.textContent = "Delete";
            deleteButton.onclick = function() {
                deleteEvent(event.id);
            };

            listItem.appendChild(deleteButton);
            reminderList.appendChild(listItem);
        }
    }
}

// Function to generate a range of
// years for the year select input
function generate_year_range(start, end) {
    let years = "";
    for (let year = start; year <= end; year++) {
        years += "<option value='" +
            year + "'>" + year + "</option>";
    }
    return years;
}

// Initialize date-related letiables
today = new Date();
currentMonth = today.getMonth();
currentYear = today.getFullYear();
selectYear = document.getElementById("year");
selectMonth = document.getElementById("month");

createYear = generate_year_range(1970, 2050);

document.getElementById("year").innerHTML = createYear;

let calendar = document.getElementById("calendar");

let months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
];
let days = [
    "Sun", "Mon", "Tue", "Wed",
    "Thu", "Fri", "Sat"
];

$dataHead = "<tr>";
for (dhead in days) {
    $dataHead += "<th data-days='" +
        days[dhead] + "'>" +
        days[dhead] + "</th>";
}
$dataHead += "</tr>";

document.getElementById("thead-month").innerHTML = $dataHead;

monthAndYear =
    document.getElementById("monthAndYear");
showCalendar(currentMonth, currentYear);

// Function to navigate to the next month
function next() {
    currentYear = currentMonth === 11 ?
        currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    showCalendar(currentMonth, currentYear);
}

// Function to navigate to the previous month
function previous() {
    currentYear = currentMonth === 0 ?
        currentYear - 1 : currentYear;
    currentMonth = currentMonth === 0 ?
        11 : currentMonth - 1;
    showCalendar(currentMonth, currentYear);
}

// Function to jump to a specific month and year
function jump() {
    currentYear = parseInt(selectYear.value);
    currentMonth = parseInt(selectMonth.value);
    showCalendar(currentMonth, currentYear);
}

// Function to display the calendar
function showCalendar(month, year) {
    let firstDay = new Date(year, month, 1).getDay();
    tbl = document.getElementById("calendar-body");
    tbl.innerHTML = "";
    monthAndYear.innerHTML = months[month] + " " + year;
    selectYear.value = year;
    selectMonth.value = month;

    let date = 1;
    for (let i = 0; i < 6; i++) {
        let row = document.createElement("tr");
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) {
                cell = document.createElement("td");
                cellText = document.createTextNode("");
                cell.appendChild(cellText);
                row.appendChild(cell);
            } else if (date > daysInMonth(month, year)) {
                break;
            } else {
                cell = document.createElement("td");
                cell.setAttribute("data-date", date);
                cell.setAttribute("data-month", month + 1);
                cell.setAttribute("data-year", year);
                cell.setAttribute("data-month_name", months[month]);
                cell.className = "date-picker";
                cell.innerHTML = "<span>" + date + "</span";

                if (
                    date === today.getDate() &&
                    year === today.getFullYear() &&
                    month === today.getMonth()
                ) {
                    cell.className = "date-picker selected";
                }

                // Check if there are events on this date
                if (hasEventOnDate(date, month, year)) {
                    cell.classList.add("event-marker");
                    cell.appendChild(
                        createEventTooltip(date, month, year)
                    );
                }

                row.appendChild(cell);
                date++;
            }
        }
        tbl.appendChild(row);
    }

    displayReminders();
}

// Function to create an event tooltip
function createEventTooltip(date, month, year) {
    let tooltip = document.createElement("div");
    tooltip.className = "event-tooltip";
    let eventsOnDate = getEventsOnDate(date, month, year);
    for (let i = 0; i < eventsOnDate.length; i++) {
        let event = eventsOnDate[i];
        let eventDate = new Date(event.date);
        let eventText = `<strong>${event.title}</strong> -
          ${event.description} on
          ${eventDate.toLocaleDateString()}`;
        let eventElement = document.createElement("p");
        eventElement.innerHTML = eventText;
        tooltip.appendChild(eventElement);
    }
    return tooltip;
}

// Function to get events on a specific date
function getEventsOnDate(date, month, year) {
    return events.filter(function(event) {
        let eventDate = new Date(event.date);
        return (
            eventDate.getDate() === date &&
            eventDate.getMonth() === month &&
            eventDate.getFullYear() === year
        );
    });
}

// Function to check if there are events on a specific date
function hasEventOnDate(date, month, year) {
    return getEventsOnDate(date, month, year).length > 0;
}

// Function to get the number of days in a month
function daysInMonth(iMonth, iYear) {
    return 32 - new Date(iYear, iMonth, 32).getDate();
}

// Call the showCalendar function initially to display the calendar
showCalendar(currentMonth, currentYear);
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
            const daysDifference = Math.ceil(timeDifference / (1000 * 3600 * 24)); // Use Math.ceil to handle partial days

            noOfDaysInput.value = daysDifference >= 0 ? daysDifference : 0;
        } else {
            noOfDaysInput.value = '';
        }
    }

    // Attach event listeners to date inputs
    document.querySelector('input[name="from"]').addEventListener('change', calculateDays);
    document.querySelector('input[name="to"]').addEventListener('change', calculateDays);

    // Calculate days on initial page load
    calculateDays();
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
<?php /**PATH C:\xampp\htdocs\crmforairlines\staff\application\resources\views/pages/home/client/widgets/first-row/wrapper.blade.php ENDPATH**/ ?>