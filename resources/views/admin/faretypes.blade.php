@extends('admin/layouts/head-main')
@section('title', 'Fare Types')
@section('content')



   <!-- Page Wrapper -->
            <div class="page-wrapper">

                <!-- Page Content -->
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Fare Types</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Admin</li>
                                </ul>
                            </div>
                            <div class="col-auto float-end ms-auto">
                                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_fare"><i class="fa fa-plus"></i> Add Fare Types</a>
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
                                            <th>#</th>
                                            <th>Fare Type</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($fare_type as $index => $fares)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $fares->fare_type }}</td>
                                            <!-- <td>Hardware Expenses</td> -->
                                            <td class="text-end">
                                                <div class="dropdown-action">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit_fare{{$fares->id}}"><i class="fa fa-pencil m-r-5"></i></a>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#delete_fare{{$fares->id}}"><i class="fa fa-trash m-r-5"></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                    <!-- Edit Duty Modal -->
                                    <div class="modal custom-modal fade" id="edit_fare{{$fares->id}}" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Fare Type</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('admin.faretypes.update', $fares->id)}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                        <div class="form-group">
                                                            <label>Fare Type<span class="text-danger">*</span></label>
                                                            <input class="form-control" name="name" type="text" value="{{$fares->fare_type}}">
                                                        </div>

                                                        <div class="submit-section">
                                                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Edit Duty Modal -->

                                    <div class="modal fade" id="delete_fare{{$fares->id}}" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteCategoryModalLabel">Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.faretypes.delete', ['id'=> $fares->id]) }}" method="POST" enctype="multipart/form-data">
                                                @method('delete')
                                                @csrf
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this Fare Type?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
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

                <!-- Add Holiday Modal -->
                <div class="modal custom-modal fade" id="add_fare" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Fare Types</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.faretypes.store')}}" method="post">
                                @csrf
                                    <div class="form-group">
                                        <label>Fare Type <span class="text-danger">*</span></label>
                                        <input class="form-control" name="name" type="text">
                                    </div>

                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Add Holiday Modal -->

            </div>
            <!-- /Page Wrapper -->



@endsection
