@extends('admin/layouts/head-main')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Events</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Events</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_event"><i
                                class="fa fa-plus"></i> Add Event</a>
                    </div>
                    <div class="view-toggle">
                        <button onclick="toggleView('list')" class="btn calendar-btn list-view"><i
                                class="fa fa-list"></i></button>
                        <button onclick="toggleView('calendar')" class="btn calendar-btn calendar-view"><i
                                class="fa fa-calendar" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->



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
                                            <h2>My Todo's</h2>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped custom-table mb-0 datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Schedule Date</th>
                                                        <th>Website</th>
                                                        <th>Email</th>
                                                        <th>Phone No</th>
                                                        <th>Contact Person</th>
                                                        <th>Category</th>
                                                        <th>Remarks</th>
                                                        <th>Created On</th>
                                                        <th>Created By</th>
                                                        <th>Updated On</th>
                                                        <th>Updated By</th>
                                                        <th>Status</th>
                                                        {{-- <th>Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody id="events-table-body">
                                                    @foreach ($events as $data)
                                                        <tr data-month="{{ date('n', strtotime($data->event_date)) - 1 }}">
                                                            <td>{{ $data->event_name }}</td>
                                                            <td>{{ $data->event_date }}</td>
                                                            <td>{{ $data->website }}</td>
                                                            <td>{{ $data->email_id }}</td>
                                                            <td>{{ $data->phone_no }}</td>
                                                            <td>{{ $data->contact_person }}</td>
                                                            <td>{{ $data->category }}</td>
                                                            <td>{{ $data->remarks }}</td>
                                                            <td>{{ $data->created_at }}</td>
                                                            <td>{{ $data->createdBy->first_name ?? 'N/A' }} {{ $data->createdBy->last_name ?? '' }}</td>
                                                            <td>{{ $data->updated_at }}</td>
                                                            <td>{{ $data->updatedBy->first_name ?? 'N/A' }} {{ $data->updatedBy->last_name ?? ''  }}</td>
                                                            <td>
                                                                <div class="dropdown action-label dropdown-item" >
                                                                    <a class="btn btn-white btn-sm btn-rounded" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_employee{{ $data->id }}" style="text-transform:capitalize;">
                                                                        <i class="fa fa-dot-circle-o text-purple"></i>
                                                                        {{ $data->statusId->status_type??'No status Assigned' }}
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            {{-- <td>
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle"
                                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                            class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" data-bs-toggle="modal"
                                                                            data-bs-target="#edit_employee{{ $data->id }}"><i
                                                                                class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                        <!-- Add more actions if needed -->
                                                                    </div>
                                                                </div>
                                                            </td> --}}
                                                        </tr>
                                                        <!-- Edit Designation Modal -->
                                                        <div id="edit_employee{{ $data->id }}"
                                                            class="modal custom-modal fade" role="dialog">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Todo Status</h5>
                                                                        <button type="button" class="close"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('admin.events.update', ['id' => $data->id]) }}"
                                                                            method="POST" enctype="multipart/form-data">
                                                                            @method('patch')
                                                                            @csrf
                                                                            <div class="form-group">
                                                                                <label>Status<span
                                                                                        class="text-danger">*</span></label>
                                                                                <select class="form-control" name="status"
                                                                                    required>
                                                                                    <option>Select Status</option>
                                                                                    @foreach ($eventStatus as $status)
                                                                                        <option value="{{ $status->id }}"  @if($data->status_id == $status->id) selected @endif>
                                                                                            {{ $status->status_type }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="submit-section">
                                                                                <button class="btn btn-primary"
                                                                                    type="submit">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- /Edit Designation Modal -->
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /Calendar -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Event Modal -->
        <div id="add_event" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Event</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.events.store') }}" method="POST">
                            @csrf <!-- Include CSRF token -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input class="form-control" name="updated_at" type="hidden" value=" ">
                                        <input class="form-control" name="event_name" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input class="form-control" name="website" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email Id</label>
                                        <input class="form-control" name="email_id" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Phone No.</label>
                                        <input class="form-control" name="phone_no" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Contact Person</label>
                                        <input class="form-control" name="contact_person" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input class="form-control" name="category" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Event Date <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control" name="event_date" type="datetime-local">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks"></textarea>
                                    </div>
                                </div>
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

                var defaultEvents = [
                    @foreach ($events as $event)
                        {
                            title: '{{ $event->event_name }}',
                            start: '{{ $event->event_date }}',
                            className: '{{ $event->category }}'
                        }
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                ];

                // console.log(defaultEvents);

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
@endsection
