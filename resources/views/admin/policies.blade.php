@extends('admin/layouts/head-main')
@section('content')


    <title>Policies</title>


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Policies</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Policies</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_policy"><i class="fa fa-plus"></i> Add Policy</a>
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
                                    <th>Policy Name </th>
                                    <th>Department </th>
                                    <th>Description </th>
                                    <th>Created </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($policy as $data)
                                <tr>
                                    <td>{{$data->policy_name}}</td>
                                    <td>{{$data->department->department_name}}</td>
                                    <td>{{$data->description}}</td>
                                    <td>{{$data->created_at}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Policy Modal -->
        <div id="add_policy" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Policy</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action ="{{route('admin.policies.store')}}">@csrf
                            <div class="form-group">
                                <label>Policy Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="policy_name">
                            </div>
                            <div class="form-group">
                                <label>Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="4" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Department</label>
                                <select class="select" name="department">
                                    @foreach($department as $departmentData)
                                    <option value="{{$departmentData->id}}">{{$departmentData->department_name}}</option>
                                    @endforeach
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
        <!-- /Add Policy Modal -->

        <!-- Edit Policy Modal -->
        <div id="edit_policy" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Policy</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Policy Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value="Leave Policy">
                            </div>
                            <div class="form-group">
                                <label>Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Department</label>
                                <select class="select">
                                    <option>All Departments</option>
                                    <option>Web Development</option>
                                    <option>Marketing</option>
                                    <option>IT Management</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Upload Policy <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="edit_policy_upload">
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Policy Modal -->

        <!-- Delete Policy Modal -->
        <div class="modal custom-modal fade" id="delete_policy" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Policy</h3>
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
        <!-- /Delete Policy Modal -->

    </div>
    <!-- /Page Wrapper -->





@endsection
