@extends('admin/layouts/head-main')
@section('content')


    <title>Termination</title>


   <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Termination</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Termination</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_termination"><i class="fa fa-plus"></i> Add Termination</a>
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
                                    <th>Terminated Employee </th>
                                    <th>Termination Type </th>
                                    <th>Termination Date </th>
                                    <th>Reason</th>
                                    <th>Notice Date </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($termination as $data)
                                <tr>
                                    <td>
                                        <h2 class="table-avatar blue-link">
                                            <a href="javascript:void(0)">{{$data->user->first_name}} {{$data->user->last_name}}</a>
                                        </h2>
                                    </td>
                                    <td>{{$data->termination_type}}</td>
                                    <td>{{$data->termination_date}}</td>
                                    <td>{{$data->reason}}</td>
                                    <td>{{$data->notice_date}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Termination Modal -->
        <div id="add_termination" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Termination</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('admin.termination.store')}}">@csrf
                            <div class="form-group">
                                <label>Terminated Employee <span class="text-danger">*</span></label>
                                <select class="select" name="employee_id">
                                            <option>Select Staff</option>
                                            @foreach($staff as $staffData)
                                                <option value="{{$staffData->client_id}}">{{$staffData->user->first_name}} {{$staffData->user->last_name}}</option>
                                            @endforeach
                                        </select>
                            </div>
                            <div class="form-group">
                                <label>Termination Type <span class="text-danger">*</span></label>
                                <div class="add-group-btn">
                                    <select class="select" name="termination_type">
                                        <option>Misconduct</option>
                                        <option>Others</option>
                                    </select>
                                    <a class="btn btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i> Add</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Termination Date <span class="text-danger">*</span></label>
                                <div class="">
                                    <input type="date" class="form-control" name="termination_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Reason <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="4" name="reason"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Notice Date <span class="text-danger">*</span></label>
                                <div class="">
                                    <input type="date" class="form-control" name="notice_date">
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Termination Modal -->

        <!-- Edit Termination Modal -->
        <div id="edit_termination" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Termination</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Terminated Employee <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value="John Doe">
                            </div>
                            <div class="form-group">
                                <label>Termination Type <span class="text-danger">*</span></label>
                                <div class="add-group-btn">
                                    <select class="select">
                                        <option>Misconduct</option>
                                        <option>Others</option>
                                    </select>
                                    <a class="btn btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i> Add</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Termination Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" value="28/02/2019">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Reason <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Notice Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" value="28/02/2019">
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Termination Modal -->

        <!-- Delete Termination Modal -->
        <div class="modal custom-modal fade" id="delete_termination" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Termination</h3>
                            <p>Are you sure want to delete?</p>
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
        <!-- /Delete Termination Modal -->

    </div>
    <!-- /Page Wrapper -->






@endsection
