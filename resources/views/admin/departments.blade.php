@extends('admin/layouts/head-main')
@section('content')
    <title>Departments</title>


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Department</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Department</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_department"><i
                                class="fa fa-plus"></i> Add Department</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div>
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Department Name</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($department as $data)
                                    <tr>
                                        <td>{{ $data->department_name }}</td>
                                        <td class="text-end">
                                            <div class="dropdown-action">
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit_department{{ $data->id }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Edit Department Modal -->
                                    <div id="edit_department{{ $data->id }}" class="modal custom-modal fade"
                                        role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Department</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ route('admin.departments.edit', ['id' => $data->id]) }}"
                                                        method="POST">

                                                        @method('patch')
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Department Name <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" name="department_name"
                                                                value="{{ $data->department_name }}" type="text">
                                                        </div>
                                                        <div class="submit-section">
                                                            <button class="btn btn-primary" type="submit">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Edit Department Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Department Modal -->
        <div id="add_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Department</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action ="{{ route('admin.departments.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>Department Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="department_name">
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Department Modal -->



        <!-- Delete Department Modal -->
        <div class="modal custom-modal fade" id="delete_department" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Department</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal"
                                        class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Department Modal -->

    </div>
    <!-- /Page Wrapper -->
@endsection
