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
                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal"
                            data-bs-target="#add_salelead"><i class="fa fa-plus"></i> Add Sale Lead</a>

                    </div>
                </div>
            </div>
            <div class="card tab-box">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item">
                                <a href="#allocated-leads" data-bs-toggle="tab" class="nav-link active">Allocated Leads</a>
                            </li>
                            <li class="nav-item">
                                <a href="#unallocated-leads" data-bs-toggle="tab" class="nav-link">Un-allocated Leads</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <!-- Profile Info Tab -->
                <div id="allocated-leads" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">

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
                                                    <th>Remarks</th>
                                                    <th>Staff Assigned</th>
                                                    <th>Created On</th>
                                                    <th>Created By</th>
                                                    <th>Updated On</th>
                                                    <th>Updated By</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($allocatedsalesLead as $data)
                                                    <tr>
                                                        <td>{{ $data->company_name }}</td>
                                                        <td>{{ $data->website }}</td>
                                                        <td>{{ $data->email_id }}</td>
                                                        <td>{{ $data->phone }}</td>
                                                        <td>{{ $data->contact_person }}</td>
                                                        <td>{{ $data->category }}</td>
                                                        <td>{{ $data->remarks }}</td>
                                                        <td>{{ $data->staff_names ?? 'No staff assigned' }}
                                                        <td>{{ $data->created_at }}</td>
                                                        <td>{{ $data->created_by }}</td>
                                                        <td>{{ $data->updated_at }}</td>
                                                        <td>{{ $data->updated_by }}</td>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#edit_salelead{{ $data->id }}"><i
                                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                    <!-- Add more actions if needed -->
                                                                </div>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    <!-- Edit Sales Lead Modal -->
                                                    <div id="edit_salelead{{ $data->id }}" class="modal custom-modal fade" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                                                                        <div class="row">
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Name of Company</label>
                                                                                <input class="form-control" name="company_name" value="{{ $data->company_name }}" type="text">
                                                                            </div>
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Website</label>
                                                                                <input class="form-control" name="website" value="{{ $data->website }}" type="text">
                                                                            </div>
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Email Id</label>
                                                                                <input class="form-control" name="email" value="{{ $data->email_id }}" type="email">
                                                                            </div>
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Phone No.</label>
                                                                                <input class="form-control" name="phone" value="{{ $data->phone }}" type="text">
                                                                            </div>
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Contact Person</label>
                                                                                <input class="form-control" name="contact_person" value="{{ $data->contact_person }}" type="text">
                                                                            </div>
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Category</label>
                                                                                <input class="form-control" name="category" value="{{ $data->category }}" type="text">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                @foreach ($allEmployee as $elData)
                                                                                    <label class="form-label">
                                                                                        {{ $elData->user->first_name . ' ' . $elData->user->last_name }}
                                                                                    </label>
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        name="staff[{{ $elData->user->id }}]"
                                                                                        value="1"
                                                                                        @if(!empty($data->staff_names) && str_contains($data->staff_names, $elData->user->first_name . ' ' . $elData->user->last_name)) checked @endif>
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="form-group col-sm-12">
                                                                                <label>Remarks</label>
                                                                                <textarea class="form-control" name="remarks">{{ $data->remarks }}</textarea>
                                                                            </div>
                                                                            <div class="submit-section">
                                                                                <button class="btn btn-primary" type="submit">Update</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /Edit Sales Lead Modal -->
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="unallocated-leads" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name of company</th>
                                                    <th>Website</th>
                                                    <th>Email Id</th>
                                                    <th>Phone</th>
                                                    <th>Contact Person</th>
                                                    <th>Category</th>
                                                    <th>Remarks</th>
                                                    <th>Staff Assigned</th>
                                                    <th>Created On</th>
                                                    <th>Created By</th>
                                                    <th>Updated On</th>
                                                    <th>Updated By</th>
                                                    <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($unallocatedsalesLead as $data)
                                                    <tr>
                                                        <td>{{ $data->company_name }}</td>
                                                        <td>{{ $data->website }}</td>
                                                        <td>{{ $data->email_id }}</td>
                                                        <td>{{ $data->phone }}</td>
                                                        <td>{{ $data->contact_person }}</td>
                                                        <td>{{ $data->category }}</td>
                                                        <td>{{ $data->remarks }}</td>
                                                        <td>{{ $data->staff_names ?? 'No staff assigned' }}
                                                        <td>{{ $data->created_at }}</td>
                                                        <td>{{ $data->created_by }}</td>
                                                        <td>{{ $data->updated_at }}</td>
                                                        <td>{{ $data->updated_by }}</td>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#edit_salelead{{ $data->id }}"><i
                                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                    <!-- Add more actions if needed -->
                                                                </div>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    <!-- Edit Sales Lead Modal -->
                                                    <div id="edit_salelead{{ $data->id }}" class="modal custom-modal fade" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                                                                        <div class="row">
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Name of Company</label>
                                                                                <input class="form-control" name="company_name" value="{{ $data->company_name }}" type="text">
                                                                            </div>
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Website</label>
                                                                                <input class="form-control" name="website" value="{{ $data->website }}" type="text">
                                                                            </div>
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Email Id</label>
                                                                                <input class="form-control" name="email" value="{{ $data->email_id }}" type="email">
                                                                            </div>
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Phone No.</label>
                                                                                <input class="form-control" name="phone" value="{{ $data->phone }}" type="text">
                                                                            </div>
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Contact Person</label>
                                                                                <input class="form-control" name="contact_person" value="{{ $data->contact_person }}" type="text">
                                                                            </div>
                                                                            <div class="form-group col-sm-4">
                                                                                <label>Category</label>
                                                                                <input class="form-control" name="category" value="{{ $data->category }}" type="text">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                @foreach ($allEmployee as $elData)
                                                                                    <label class="form-label">
                                                                                        {{ $elData->user->first_name . ' ' . $elData->user->last_name }}
                                                                                    </label>
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        name="staff[{{ $elData->user->id }}]"
                                                                                        value="1"
                                                                                        @if(!empty($data->staff_names) && str_contains($data->staff_names, $elData->user->first_name . ' ' . $elData->user->last_name)) checked @endif>
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="form-group col-sm-12">
                                                                                <label>Remarks</label>
                                                                                <textarea class="form-control" name="remarks">{{ $data->remarks }}</textarea>
                                                                            </div>
                                                                            <div class="submit-section">
                                                                                <button class="btn btn-primary" type="submit">Update</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /Edit Sales Lead Modal -->
                                                @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

        </div>
        <!-- /Page Content -->

        <!-- Add Airline Modal -->
        <div id="add_salelead" class="modal custom-modal fade " role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Sales Lead</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body model-md">
                        <form action="{{ route('admin.saleslead.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>Name of Company</label>
                                    <input class="form-control" name="company_name" type="text">
                                    <input class="form-control" name="updated_at" value=" " type="hidden">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Website</label>
                                    <input class="form-control" name="website" type="text">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Email Id</label>
                                    <input class="form-control" name="email" type="email">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Phone No.</label>
                                    <input class="form-control" name="phone" type="text">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Contact Person</label>
                                    <input class="form-control" name="contact_person" type="text">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Category</label>
                                    <input class="form-control" name="category" type="text">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Assign Staff</label>
                                    <div class="form-group">
                                        @foreach ($allEmployee as $elData)
                                            <label class="form-label">
                                                <input type="checkbox" name="staff[{{ $elData->user->id }}]" value="active">
                                                {{ $elData->user->first_name . " " . $elData->user->last_name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remarks" type="text"></textarea>
                                </div>

                                <div class="submit-section">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
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
