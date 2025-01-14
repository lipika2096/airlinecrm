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
                                <div class="month-list container">
                                    <i class="fas fa-arrow-left mt-3 text-white btn rounded me-2 "
                                        style="background:#ff9b44" onclick="changeYear(-1)"></i>
                                    <button class="active" onclick="activateMonth(this, 0)">Jan, <span
                                            id="year-0"></span></button>
                                    <button onclick="activateMonth(this, 1)">Feb, <span id="year-1"></span></button>
                                    <button onclick="activateMonth(this, 2)">Mar, <span id="year-2"></span></button>
                                    <button onclick="activateMonth(this, 3)">Apr, <span id="year-3"></span></button>
                                    <button onclick="activateMonth(this, 4)">May, <span id="year-4"></span></button>
                                    <button onclick="activateMonth(this, 5)">Jun, <span id="year-5"></span></button>
                                    <button onclick="activateMonth(this, 6)">Jul, <span id="year-6"></span></button>
                                    <button onclick="activateMonth(this, 7)">Aug, <span id="year-7"></span></button>
                                    <button onclick="activateMonth(this, 8)">Sep, <span id="year-8"></span></button>
                                    <button onclick="activateMonth(this, 9)">Oct, <span id="year-9"></span></button>
                                    <button onclick="activateMonth(this, 10)">Nov, <span id="year-10"></span></button>
                                    <button onclick="activateMonth(this, 11)">Dec, <span id="year-11"></span></button>
                                    <i class="fas fa-arrow-right mt-3 text-white btn rounded ms-2"
                                        onclick="changeYear(1)"></i>
                                </div>
                                <div class="section">
                                    <div class="section-header">
                                        <h2>My Todo's</h2>
                                    </div>
                                    <div class="table-responsive">
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
                                                    </tr>
                                                </thead>
                                                <tbody id="events-table-body">
                                                    @foreach ($combinedData as $data)
                                                    <tr data-month="{{ date('n', strtotime($data->event_date ?? $data->created_at)) - 1 }}"
                                                        data-year="{{ date('Y', strtotime($data->event_date ?? $data->created_at)) }}">
                                                        <td>{{ $data->event_name ?? $data->company_name}}</td>
                                                        <td>{{ $data->event_date??$data->created_at }}</td>
                                                        <td>{{ $data->website }}</td>
                                                        <td>{{ $data->email_id }}</td>
                                                        <td>{{ $data->phone_no??$data->phone }}</td>
                                                        <td>{{ $data->contact_person }}</td>
                                                        <td>{{ $data->category }}</td>
                                                        <td>{{ $data->remarks }}</td>
                                                        <td>{{ $data->created_at }}</td>
                                                        <td>{{ $data->createdBy->first_name ?? 'N/A' }} {{
                                                            $data->createdBy->last_name ?? '' }}</td>
                                                        <td>{{ $data->updated_at }}</td>
                                                        <td>{{ $data->updatedBy->first_name ?? 'N/A' }} {{
                                                            $data->updatedBy->last_name ?? '' }}</td>
                                                        <td>
                                                            <div class="dropdown action-label dropdown-item">
                                                                <a class="btn btn-white btn-sm btn-rounded"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit_employee{{ $data->unique_id ?? $data->id }}"
                                                                    style="text-transform:capitalize;">
                                                                    <i class="fa fa-dot-circle-o text-purple"></i>
                                                                    {{ $data->statusId->status_type ?? 'No status
                                                                    Assigned'
                                                                    }}
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <div id="edit_employee{{  $data->unique_id ?? $data->id  }}"
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
                                                                        action="{{ route('admin.events.update', ['id' =>  $data->unique_id ?? $data->id ]) }}"
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
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
<!-- Bootstrap Modal -->
<div id="eventModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Event details will be dynamically injected here -->
            </div>
        </div>
    </div>
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

        var defaultEvents = [
            @foreach ($combinedData as $event)
                {
                    title: '{{ $event->event_name ?? $event->company_name }}',
                    start: '{{ $event->event_date ?? $event->created_at }}',
                    className: '{{ $event->category }}',
                    description: '{{ $event->remarks ?? "No description available" }}', // Add any additional data you need
                    location: '{{ $event->location ?? "N/A" }}',
                    contactPerson: '{{ $event->contact_person }}',
                    email: '{{ $event->event_date ?? $event->created_at }}',
                    phone: '{{ $event->phone?? $event->phone_no }}',
                    website: '{{ $event->website }}',
                }
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        ];

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
                        end: end,
                        className: className,
                        description: description,
                        contactPerson: contactPerson,
                        email:  email,
                        phone: phone,
                        website: website,
                    };
                    $this.$calendarObj.fullCalendar('renderEvent', eventData, true);
                }
                $this.$calendarObj.fullCalendar('unselect');
            },
            eventClick: function(calEvent, jsEvent, view) {
                // Set modal title and content with event data
                $('#eventModal .modal-title').text(calEvent.title);
                $('#eventModal .modal-body').html(`
                    <p><strong>Date:</strong> ${calEvent.start.format('MMMM Do YYYY, h:mm a')}</p>
                    <p><strong>Category:</strong> ${calEvent.className}</p>
                    <p><strong>Remarks:</strong> ${calEvent.description}</p>
                    <p><strong>Contact Person:</strong> ${calEvent.contactPerson}</p>
                    <p><strong>Email:</strong> ${calEvent.email}</p>
                    <p><strong>Phone No:</strong> ${calEvent.phone}</p>
                    <p><strong>Website:</strong> ${calEvent.website}</p>
                `);

                // Show the modal
                $('#eventModal').modal('show');
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

    let displayedYear = new Date().getFullYear();
    let selectedMonth = null;

    function updateYearDisplay() {
        for (let i = 0; i < 12; i++) {
            document.getElementById(`year-${i}`).textContent = displayedYear;
        }
    }
    updateYearDisplay();

    function changeYear(direction) {
        displayedYear += direction;
        updateYearDisplay();
        filterEvents();
    }
    function activateMonth(button, index) {
        const buttons = document.querySelectorAll('.month-list button');
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        selectedMonth = index;
        filterEvents();
    }

    function filterEvents() {
        const rows = document.querySelectorAll('#events-table-body tr');
        rows.forEach(row => {
            const eventMonth = parseInt(row.getAttribute('data-month'));
            const eventYear = parseInt(row.getAttribute('data-year'));

            if ((selectedMonth === null || eventMonth === selectedMonth) && eventYear === displayedYear) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
<style>
    i.fas.fa-arrow-right.mt-3.text-white.btn.rounded,
    i.fas.fa-arrow-left.mt-3.text-white.btn.rounded {
        background: #ff9b44;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: -3px;
        height: fit-content;
        padding: 7px;
        margin-left: -6px;
        border-radius: 92px !important;
        margin-top: 0px !important;
    }
</style>
@endsection
