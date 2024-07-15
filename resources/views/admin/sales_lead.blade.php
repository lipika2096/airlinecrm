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
                        <h3 class="page-title">Sales Lead Entry</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sales Lead Entry</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salelead"><i class="fa fa-plus"></i> Add Sale Lead</a>
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

                                    <th>Name of company</th>
                                    <th>Website</th>
                                    <th>Email Id</th>
                                    <th>Phone</th>
                                    <th>Contact Person</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salesLead as $data)
                <tr>
                    <td>{{ $data->company_name }}</td>
                    <td>{{ $data->website }}</td>
                    <td>{{ $data->email_id}}</td>
                    <td>{{ $data->phone }}</td>
                    <td>{{ $data->contact_person }}</td>
                    <td>{{ $data->category}}</td>
                    <td class="text-end">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_salelead{{$data->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                <!-- Add more actions if needed -->
                            </div>
                        </div>
                    </td>

                </tr>
                                 <!-- Edit Designation Modal -->
                                 <div id="edit_salelead{{$data->id}}" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Sales Lead</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.saleslead.update', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
                                                    @method('patch')
                                                    @csrf

                    <div class="form-group">
                        <label>Name of Company<span class="text-danger">*</span></label>
                        <input class="form-control" name="company_name" value="{{$data->company_name}}" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Website<span class="text-danger">*</span></label>
                        <input class="form-control" name="website" value="{{$data->website}}" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Email Id<span class="text-danger">*</span></label>
                        <input class="form-control" name="email" type="email" value="{{$data->email_id}}" required>
                    </div>
                    <div class="form-group">
                        <label>Phone No.<span class="text-danger">*</span></label>
                        <input class="form-control" name="phone" type="text" value="{{$data->phone}}" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Person<span class="text-danger">*</span></label>
                        <input class="form-control" name="contact_person" value="{{$data->contact_person}}" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Category<span class="text-danger">*</span></label>
                        <input class="form-control" name="category" value="{{$data->category}}"  type="text" required>
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
<div id="add_salelead" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Sales Lead</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.saleslead.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Name of Company<span class="text-danger">*</span></label>
                        <input class="form-control" name="company_name" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Website<span class="text-danger">*</span></label>
                        <input class="form-control" name="website" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Email Id<span class="text-danger">*</span></label>
                        <input class="form-control" name="email" type="email" required>
                    </div>
                    <div class="form-group">
                        <label>Phone No.<span class="text-danger">*</span></label>
                        <input class="form-control" name="phone" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Person<span class="text-danger">*</span></label>
                        <input class="form-control" name="contact_person" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Category<span class="text-danger">*</span></label>
                        <input class="form-control" name="category" type="text" required>
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
