@extends('admin/layouts/head-main')
@section('content')
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
                                        <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Holidays & Leaves</li>
                                    </ul>
                                </div>
                               
                                <div class="card tab-box" style="margin-top: 20px;">
                                    <div class="row user-tabs">
                                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                            <ul class="nav nav-tabs nav-tabs-bottom">
                                                <li class="nav-item"><a href="#holidays" data-bs-toggle="tab" class="nav-link active">Holidays</a>
                                                </li>
                                                <li class="nav-item"><a href="#leaves" data-bs-toggle="tab" class="nav-link">Leaves</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> 
                                
                            </div>
                        </div>
                        <!-- /Page Header -->

            <div class="tab-content">
                
                    <div id="holidays" class="pro-overview tab-pane fade show active">
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
                                                        <h2>Todo List</h2>

                                                    </div>
                                                    <table class="table table-striped custom-table mb-0 datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Holiday Name</th>
                                                                <th>Holiday Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="events-table-body">
                                                            @foreach ($holidays as $data)
                                                                <tr data-month="{{ date('n', strtotime($data->holiday_date)) - 1 }}">
                                                                    <td>{{ $data->id }}</td>
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
                                        <button type="button" class="btn btn-success submit-btn save-event">Create event</button>
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
                                                    <select class="form-control form-select" data-placeholder="Choose a color..."
                                                        name="category-color">
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
                                        <button type="button" class="btn btn-danger save-category" data-bs-dismiss="modal">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Add Category Modal-->
                   </div>
                    <div id="leaves" class="pro-overview tab-pane fade show "> 
                        <!-- Page Content -->
                        <div class="content container-fluid">

                            <!-- Page Header -->
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                       
                                    </div>
                                    <div class="col-auto float-end ms-auto">
                                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Page Header -->

                            <!-- Leave Statistics -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-info">
                                        <h6>Today Presents</h6>
                                        <h4>{{$noofpresentemployeestoday}} / {{$total_employee}}</h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stats-info">
                                        <h6>Total Leaves</h6>
                                        <h4>{{$total_leaves}} <span>Today</span></h4>
                                    </div>
                                </div>
                                <!--<div class="col-md-3">-->
                                <!--    <div class="stats-info">-->
                                <!--        <h6>Unplanned Leaves</h6>-->
                                <!--        <h4>0 <span>Today</span></h4>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="col-md-4">
                                    <div class="stats-info">
                                        <h6>Pending Requests</h6>
                                        <h4>{{$total_pending_leaves}}</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- /Leave Statistics -->

                            <!-- Search Filter -->
                            <!--<div class="row filter-row">-->
                            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
                            <!--        <div class="form-group form-focus">-->
                            <!--            <input type="text" class="form-control floating">-->
                            <!--            <label class="focus-label">Employee Name</label>-->
                            <!--        </div>-->
                            <!--   </div>-->
                            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
                            <!--        <div class="form-group form-focus select-focus">-->
                            <!--            <select class="form-control select floating">-->
                            <!--                <option> -- Select -- </option>-->
                            <!--                <option>Casual Leave</option>-->
                            <!--                <option>Medical Leave</option>-->
                            <!--                <option>Loss of Pay</option>-->
                            <!--            </select>-->
                            <!--            <label class="focus-label">Leave Type</label>-->
                            <!--        </div>-->
                            <!--   </div>-->
                            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
                            <!--        <div class="form-group form-focus select-focus">-->
                            <!--            <select class="form-control select floating">-->
                            <!--                <option> -- Select -- </option>-->
                            <!--                <option> Pending </option>-->
                            <!--                <option> Approved </option>-->
                            <!--                <option> Rejected </option>-->
                            <!--            </select>-->
                            <!--            <label class="focus-label">Leave Status</label>-->
                            <!--        </div>-->
                            <!--   </div>-->
                            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
                            <!--        <div class="form-group form-focus">-->
                            <!--            <div class="cal-icon">-->
                            <!--                <input class="form-control floating datetimepicker" type="text">-->
                            <!--            </div>-->
                            <!--            <label class="focus-label">From</label>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
                            <!--        <div class="form-group form-focus">-->
                            <!--            <div class="cal-icon">-->
                            <!--                <input class="form-control floating datetimepicker" type="text">-->
                            <!--            </div>-->
                            <!--            <label class="focus-label">To</label>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
                            <!--        <a href="#" class="btn btn-success w-100"> Search </a>-->
                            <!--   </div>-->
                            <!--</div>-->
                            <!-- /Search Filter -->

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
                                                    <th>Reason</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($employee_leaves as $data)
                                                <tr>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="#">{{$data->user->first_name ?? 'N\A'}} {{$data->user->last_name  ?? 'N\A'}} </a>
                                                        </h2>
                                                    </td>
                                                    <td>{{$data->leave_type}}</td>
                                                    <td>{{$data->from}}</td>
                                                    <td>{{$data->to}}</td>
                                                    <td>{{$data->no_of_days}}</td>
                                                    <td>{{$data->reason}}</td>
                                                    <td class="text-center">
                                                        <div class="dropdown action-label">
                                                            @if($data->status == 1)
                                                                <a class="btn btn-white btn-sm btn-rounded" href="#"   data-bs-toggle="modal" data-bs-target="#approve_leave{{$data->id}}" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-purple"></i> New
                                                                </a>
                                                                @elseif($data->status == 2)
                                                                <a class="btn btn-white btn-sm btn-rounded" href="#"   data-bs-toggle="modal" data-bs-target="#approve_leave{{$data->id}}" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-info"></i> Pending
                                                                </a>
                                                                @elseif($data->status == 3)
                                                                <a class="btn btn-white btn-sm btn-rounded" href="#" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-success"></i> Approved
                                                                </a>
                                                                @else
                                                                <a class="btn btn-white btn-sm btn-rounded " href="#" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Approve Leave Modal -->
                                                <div class="modal custom-modal fade" id="approve_leave{{$data->id}}" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <form method="POST" action ="{{route('admin.leaves.update', ['id' => $data->id])}}"> @method('PATCH') @csrf
                                                                    <div class="form-group">
                                                                        <label>Update Leave Status <span class="text-danger">*</span></label>
                                                                        <select class="select form-control" name="status">
                                                                            <option value="3">Approve</option>
                                                                            <option value="2">Pending</option>
                                                                            <option value="4">Decline</option>
                                                                            <option  value="1">New</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="submit-section">
                                                                        <button class="btn btn-primary submit-btn">Submit</button>
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
                                        <form method="POST" action ="{{route('admin.leaves.store')}}">@csrf
                                            <div class="form-group">
                                                <label>Select Employee <span class="text-danger">*</span></label>
                                                <select class="select form-control" name="employee_id">
                                                    <option>Select Employee</option>
                                                    @foreach($employees as $data)
                                                        <option value="{{$data->id}}">{{$data->first_name}} {{$data->last_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Leave Type <span class="text-danger">*</span></label>
                                                <select class="select form-control" name="leave_type">
                                                    <option>Select Leave Type</option>
                                                    @foreach($leavetypes as $leavetype)
                                                        <option value="{{$leavetype->name}}">{{$leavetype->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>From <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input class="form-control " type="date" name="from" onchange="calculateDays()">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>To <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input class="form-control" type="date" name="to" onchange="calculateDays()">
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
                                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
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
    <!-- /Page Wrapper -->

    <!-- /Page Wrapper -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.0/main.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.0/main.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
@endsection
