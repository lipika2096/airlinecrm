@extends('admin/layouts/head-main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <title>Staff Profile</title>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                    <div class="card tab-box" style="margin-top: 20px;">
                        <div class="row user-tabs">
                            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="nav-item"><a href="#general" data-bs-toggle="tab" class="nav-link active">General</a>
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
            <div class="tab-content" style="margin-top:-30px;">
                <div id="general" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-3" style="padding: 3pc;margin-right: 33px;">
                                <div class="row">
                                    <div class="col-9">
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Employee ID</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->unique_id}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold ">
                                        <p>First Name</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->first_name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Last Name</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->last_name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p> Email</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->email}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>DOB</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->dob}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>DOJ</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->joining_date}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Branch</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->branch}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Department </p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->department}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Position</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->position}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Work Type</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->work_type}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Phone</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->phone}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p> Mobile(personal)</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->personal_phone}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Mobile( Company)</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->company_mobile}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Company</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->client->client_company_name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Min Hrs</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->min_hrs}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 fw-bold">
                                        <p>Max Hrs</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$employees->max_hrs}}</p>
                                    </div>
                                </div>

                                    </div>

                                <div class="col-3">
                                    @if (!empty($employees->avatar_filename))
                                        <img src="{{ asset('staff/storage/avatars/' . $employees->avatar_directory . '/' . $employees->avatar_filename) }}"
                                            alt=""  width="60%" style="width: 150px;border-radius: 85px;margin-top:20px;height: 150px!important;" class="ms-5">
                                    @else
                                        <img src="{{ asset('public/assets/img/user.jpg/') }}" alt=""  width="60%" style="width: 150px;border-radius: 85px;margin-top:20px;height: 150px!important;" class="ms-5">
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

                                    </div>
                                    <div class="col-auto float-end ms-auto">
                                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
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
                                                @foreach($employee_leaves_view as $data)
                                                <tr>
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
                                                                <form method="POST" action ="{{route('admin.view-staff.leaves.update', ['id' => $data->id])}}#leaves"> @method('PATCH') @csrf
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
                                        <form method="POST" action ="{{route('admin.view-staff.leaves.store')}}#leaves">@csrf
                                            <div class="form-group">
                                                <!-- <label>Select Employee <span class="text-danger">*</span></label> -->
                                                <input type="hidden" value="{{$employees->id}}" name="employee_id">
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
</script>
        @endsection
