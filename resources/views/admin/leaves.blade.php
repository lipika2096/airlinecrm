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
                                            <th  class="text-danger">Total Annual Leaves</th>
                                            <th  class="text-danger">Available Leaves</th>
                                            <th>Reason</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employee_leaves as $data)
                                        <tr>
                                             <td>
                                                <h2 class="table-avatar">
                                                    <a href="#">{{$data->user->first_name}} {{$data->user->last_name}} </a>
                                                </h2>
                                            </td>
                                            <td>{{$data->leave_type}}</td>
                                            <td>{{$data->from}}</td>
                                            <td>{{$data->to}}</td>
                                            <td>{{$data->no_of_days}} days</td>
                                            <td class="text-danger">{{$data->user->leave_count}} leaves</td>
                                            @php
                                            $annualLeave = $data->user->leave_count;
                                                $usedAnnualLeave = App\Models\EmployeeLeave::where('employee_id', $data->employee_id)->where('status',3)->where('leave_type','Annual Leave')
                                        ->sum('no_of_days');
                                                $remainingLeave = $annualLeave - $usedAnnualLeave;
                                            @endphp
                                            <td  class="text-danger">{{$remainingLeave}} leaves left</td>
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
                                            @foreach ($leavetypes as $leavetype)
                                                <option value="{{ $leavetype->name }}">
                                                {{ $leavetype->name }}</option>
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
            <!-- /Page Wrapper -->



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

@endsection
