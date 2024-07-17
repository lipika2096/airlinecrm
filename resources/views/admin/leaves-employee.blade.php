@extends('admin/layouts/head-main')
@section('content')


    <title>Leaves Employees</title>


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
                            @if($remaining_leave != 0)
                                <div class="col-auto float-end ms-auto">
                                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <!-- Leave Statistics -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stats-info">
                                <h6>Annual Leave</h6>
                                <h4>{{$total_leaves}}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-info">
                                <h6>Medical Leave</h6>
                                <h4>{{$medical_leave}}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-info">
                                <h6>Other Leave</h6>
                                <h4>{{$other_leave}}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-info">
                                <h6>Remaining Leave</h6>
                                <h4>{{$remaining_leave}}</h4>
                            </div>
                        </div>
                    </div>
                    <!-- /Leave Statistics -->

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
                                        @foreach($leaves as $data)
                                        <tr>
                                            <td>{{$data->leave_type}}</td>
                                            <td>{{$data->from}}</td>
                                            <td>{{$data->to}}</td>
                                            <td>{{$data->no_of_days}} days</td>
                                            <td>{{$data->reason}}</td>
                                            <td class="text-center">
                                                <div class="dropdown action-label">
                                                    @if($data->status == 1)
                                                        <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                            <i class="fa fa-dot-circle-o text-purple"></i> New
                                                        </a>
                                                        @elseif($data->status == 2)
                                                        <a class="btn btn-white btn-sm btn-rounded" href="#" >
                                                            <i class="fa fa-dot-circle-o text-info"></i> Pending
                                                        </a>
                                                        @elseif($data->status == 3)
                                                        <a class="btn btn-white btn-sm btn-rounded" href="#" >
                                                            <i class="fa fa-dot-circle-o text-success"></i> Approved
                                                        </a>
                                                        @else
                                                        <a class="btn btn-white btn-sm btn-rounded " href="#" >
                                                            <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                                        </a>
                                                    @endif
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
                                <form>
                                    <div class="form-group">
                                        <label>Leave Type <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select Leave Type</option>
                                            <option>Casual Leave 12 Days</option>
                                            <option>Medical Leave</option>
                                            <option>Loss of Pay</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>From <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>To <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Number of days <span class="text-danger">*</span></label>
                                        <input class="form-control" readonly type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Remaining Leaves <span class="text-danger">*</span></label>
                                        <input class="form-control" readonly value="12" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Leave Reason <span class="text-danger">*</span></label>
                                        <textarea rows="4" class="form-control"></textarea>
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

                <!-- Edit Leave Modal -->
                <div id="edit_leave" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Leave</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label>Leave Type <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select Leave Type</option>
                                            <option>Casual Leave 12 Days</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>From <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" value="01-01-2019" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>To <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" value="01-01-2019" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Number of days <span class="text-danger">*</span></label>
                                        <input class="form-control" readonly type="text" value="2">
                                    </div>
                                    <div class="form-group">
                                        <label>Remaining Leaves <span class="text-danger">*</span></label>
                                        <input class="form-control" readonly value="12" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Leave Reason <span class="text-danger">*</span></label>
                                        <textarea rows="4" class="form-control">Going to hospital</textarea>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Edit Leave Modal -->

                <!-- Delete Leave Modal -->
                <div class="modal custom-modal fade" id="delete_approve" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>Delete Leave</h3>
                                    <p>Are you sure want to Cancel this leave?</p>
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





@endsection
