@extends('admin/layouts/head-main')
@section('content')
    <title>Admin List</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Admin List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Admin List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal"
                            data-bs-target="#add_admin"><i class="fa fa-plus"></i> Add Admin</a>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Company Name</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Address</th>
                                            <th>Password</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admin as $data)
                                            <tr>
                                                <td>{{ $data->getRoleNames()->implode(', ') }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->adminDetail->company_name ??'-' }}</td>
                                                <td>{{ $data->adminDetail->city ??'-'}}</td>
                                                <td>{{ $data->adminDetail->state??'-' }}</td>
                                                <td>{{ $data->adminDetail->country ??'-'}}</td>
                                                <td>{{ $data->adminDetail->address??'-' }}</td>
                                                <td>{{ $data->plain_password }}</td>
                                                </td>
                                                <td class="text-end">
                                                    <a class="btn btn-primary" href="#" title="edit profile"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit_admin{{ $data->id }}"><i
                                                            class="fa fa-pencil"></i></a>
                                                </td>
                                            </tr>
                                            <!-- Edit Admin Modal -->
                                            <div id="edit_admin{{ $data->id }}"
                                                class="modal custom-modal fade" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Admin</h5>
                                                            <button type="button" class="close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.admin.update', ['id' => $data->id]) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @method('patch')
                                                                @csrf
                                                                <div class="form-group col-sm-4">
                                                                    <label>Full Name</label>
                                                                    <input class="form-control" name="full_name" type="text" value=
                                                                    "{{$data->name}}" placeholder="Enter Full Name">
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label>Email</label>
                                                                    <input class="form-control" value=
                                                                    "{{$data->email}}" name="email" type="email">
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label>Company Name</label>
                                                                    <input class="form-control" value=
                                                                    "{{$data->adminDetail->company_name ?? ''}}" name="company_name" type="company_name" required>
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label>City</label>
                                                                    <input class="form-control" value=
                                                                    "{{$data->adminDetail->city  ?? ''}}" name="city" type="city" required>
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label>State</label>
                                                                    <input class="form-control" value=
                                                                    "{{$data->adminDetail->state  ?? ''}}" name="state" type="state" required>
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label>Country</label>
                                                                    <input class="form-control" value=
                                                                    "{{$data->adminDetail->country  ?? ''}}"name="country" type="country" required>
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label>Address</label>
                                                                    <input class="form-control" value=
                                                                    "{{$data->adminDetail->address  ?? ''}}" name="address" type="address" required>
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label>Password</label>
                                                                    <input class="form-control" value=
                                                                    "{{$data->plain_password}}" name="password" type="password">
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label>Role</label>
                                                                    <select class="form-control" name="role">
                                                                        @foreach ($roles as $role)
                                                                            <option value="{{ $role->name }}"
                                                                                {{ $data->hasRole($role->name) ? 'selected' : '' }}>
                                                                                {{ $role->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="submit-section">
                                                                    <button class="btn btn-primary"
                                                                        type="submit">Update</button>
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
    <div id="add_admin" class="modal custom-modal fade " role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Admin</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body model-md">
                    <form action="{{ route('admin.admin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label>Full Name</label>
                                <input class="form-control" name="full_name" type="text" required placeholder="Enter Full Name">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Email</label>
                                <input class="form-control" name="email" type="email" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Company Name</label>
                                <input class="form-control" name="company_name" type="company_name" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>City</label>
                                <input class="form-control" name="city" type="city" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>State</label>
                                <input class="form-control" name="state" type="state" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Country</label>
                                <input class="form-control" name="country" type="country" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Address</label>
                                <input class="form-control" name="address" type="address" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Password</label>
                                <input class="form-control" name="password" type="password" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Select Role</label>
                                <select class="form-control" name="role" required>
                                    <option>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
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


    </div>
@endsection
