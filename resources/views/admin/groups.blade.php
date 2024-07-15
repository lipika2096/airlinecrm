@extends('admin/layouts/head-main')
@section('content')


    <title>Designations</title>


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Groups</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Groups</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_airline"><i class="fa fa-plus"></i> Add Groups</a>
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

                                    <th>Group Name</th>
                                    <th>Airline Code</th>
                                    <th>Agent Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group as $data)
                            <tr>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->airline->airline_code }}</td>
                                <td>{{ $data->agent->first_name }} {{ $data->agent->last_name }}</td>

                            </tr>
                                 <!-- Edit Designation Modal -->
                                 <div id="edit_airline{{$data->id}}" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Airline</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.airlines.update', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
                                                    @method('patch')
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Airline Code <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="airline_code" value="{{$data->airline_code}}" type="text" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Airline Ticketing Code <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="airline_ticketing_code" value="{{$data->airline_ticketing_code}}" type="text" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Airline Contact Details <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="airline_contact_details" value="{{$data->airline_contact_details}}" type="text" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Rules Do <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="rules_do" value="{{$data->rules_do}}" type="text" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Rules Don't <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="rules_dont" value="{{$data->rules_dont}}" type="text" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Standard Cancellation Charges <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="standard_cancellation_charges" value="{{$data->standard_cancellation_charges}}" type="text" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Date Change Charges <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="date_change_charges" value="{{$data->date_change_charges}}" type="text" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Routes Flown From <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="routes_flown_from" value="{{$data->routes_flown_from}}" type="text" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Routes Flown To <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="routes_flown_to" value="{{$data->routes_flown_to}}" type="text" required>
                                                    </div>
                                                    <div class="submit-section">
                                                        <button class="btn btn-primary" type="submit">Update</button>
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
        </div>
        <!-- /Page Content -->

       <!-- Add Airline Modal -->
<div id="add_airline" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Airline</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.groups.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Select Agent <span class="text-danger">*</span></label>
                        <select class="select" name="agent_id">
                            <option>Select Department</option>
                            @foreach($agent as $agent_data)
                                <option value="{{$agent_data->id}}" >{{$agent_data->first_name}} {{$agent_data->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Airline <span class="text-danger">*</span></label>
                        <select class="select" name="airline_id">
                            <option>Select Airline</option>
                            @foreach($airline as $airline_data)
                                <option value="{{$airline_data->id}}">{{$airline_data->airline_code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Group Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="name" type="text" required>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Airline Modal -->




        <!-- Delete Designation Modal -->
        <div class="modal custom-modal fade" id="delete_designation" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Designation</h3>
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
        <!-- /Delete Designation Modal -->

    </div>
    <!-- /Page Wrapper -->





@endsection
