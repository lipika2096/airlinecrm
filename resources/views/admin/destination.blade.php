@extends('admin.layouts.head-main')
@section('content')
    <title>Destinations</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .profile-widget .user-name {
                color: #333333;
                margin-top: 30px !important;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Destinations</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Destinations</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal"
                            data-bs-target="#add_destination"><i class="fa fa-plus"></i> Add Destination</a>
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
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($destinations as $destination)
                                    <tr>
                                        <td>{{ $destination->id }}</td>
                                        <td>{{ $destination->name }}</td>
                                        <td>
                                            <div class="action-icons">
                                                <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#edit_destination_{{ $destination->id }}" style="margin-right: 10px;">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.destinations.destroy', $destination->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-icon" style="border:none;background:none;padding:0;color:inherit;">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Destination Modal -->
                                    <div id="edit_destination_{{ $destination->id }}" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Destination</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.destinations.update', $destination->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label>Name<span class="text-danger">*</span></label>
                                                            <input class="form-control" name="name" type="text" value="{{ $destination->name }}" required>
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
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Destination Modal -->
    <div id="add_destination" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Destination</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.destinations.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Name<span class="text-danger">*</span></label>
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
@endsection
