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
                        <h3 class="page-title">Designations</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Designations</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_designation"><i
                                class="fa fa-plus"></i> Add Designation</a>
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
                                    <th>Designation </th>
                                    <th>Department </th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($designation as $data)
                                    <tr>
                                        <td>{{ $data->department->department_name }}</td>
                                        <td>{{ $data->designation }}</td>
                                        <td class="text-end">
                                            <div class="dropdown-action"> <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit_designation{{ $data->id }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Edit Designation Modal -->
                                    <div id="edit_designation{{ $data->id }}" class="modal custom-modal fade"
                                        role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Designation</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ route('admin.designations.edit', ['id' => $data->id]) }}"
                                                        method="POST" enctype="multipart/form-data">

                                                        @method('patch') @csrf
                                                        <div class="form-group">
                                                            <label>Designation Name <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" name="designation"
                                                                value="{{ $data->designation }}" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Department <span class="text-danger">*</span></label>
                                                            <select class="select" name="department">
                                                                <option>Select Department</option>
                                                                @foreach ($department as $department_data)
                                                                    <option value="{{ $department_data->id }}"
                                                                        @if ($data->department_id == $department_data->id) selected @endif>
                                                                        {{ $department_data->department_name }}</option>
                                                                @endforeach
                                                            </select>
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

        <!-- Add Designation Modal -->
        <div id="add_designation" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Designation</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.designations.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Designation Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="designation" type="text">
                            </div>
                            <div class="form-group">
                                <label>Department <span class="text-danger">*</span></label>
                                <select class="select" name="department">
                                    <option>Select Department</option>
                                    @foreach ($department as $data)
                                        <option value="{{ $data->id }}">{{ $data->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Designation Modal -->



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
                                    <a href="javascript:void(0);" data-bs-dismiss="modal"
                                        class="btn btn-primary cancel-btn">Cancel</a>
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
