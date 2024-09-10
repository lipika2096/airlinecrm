@extends('admin/layouts/head-main')
@section('content')


    <title>Event Status</title>


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Event Status</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Event Status</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_airline"><i class="fa fa-plus"></i> Add New Event Status</a>
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
                                    <th>Id</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventStatus as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->status_type }}</td>
                    <td>
                        <div class="dropdown-action">
                            <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#edit_airline{{$data->id}}">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#delete_status{{$data->id}}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        
                    </td>
                </tr>
                
            <div class="modal fade" id="delete_status{{$data->id}}" tabindex="-1" aria-labelledby="deleteStatusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteStatusModalLabel">Delete Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.events.status.delete', ['id'=> $data->id]) }}" method="POST" enctype="multipart/form-data">
                        @method('delete')
                        @csrf
                            <div class="modal-body">
                                <p>Are you sure you want to delete this Status?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                                 <!-- Edit Designation Modal -->
                                 <div id="edit_airline{{$data->id}}" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Status</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.events.status.update', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
                                                    @method('patch')
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Status<span class="text-danger">*</span></label>
                                                        <input class="form-control" name="status" value="{{$data->status_type}}" type="text" required>
                                                    </div>
                                                    <div class="submit-section">
                                                        <button class="btn btn-primary" type="submit">Update</button>
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
            </div>
        </div>
        <!-- /Page Content -->

       <!-- Add Airline Modal -->
<div id="add_airline" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Status</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.events.status.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Status<span class="text-danger">*</span></label>
                        <input class="form-control" name="status" type="text" required>
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
