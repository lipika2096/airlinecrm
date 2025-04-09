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
                                                    <a class="btn btn-primary" href="{{route('admin.customer.view', ['id'=> $data->id])}}" title="view customer profile"><i
                                                            class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                                <label>Brand Name</label>
                                <input class="form-control" name="full_name" type="text" required placeholder="Enter Brand Name">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Email</label>
                                <input class="form-control" name="email" type="email" required placeholder="Enter Email">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Company Name</label>
                                <input class="form-control" name="company_name" type="text" required placeholder="Enter Company Name">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Group</label>
                                <input class="form-control" name="group" type="text" required placeholder="Enter Group">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Street</label>
                                <input class="form-control" name="address" type="address" required placeholder="Enter Street">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>City</label>
                                <input class="form-control" name="city" type="city" required placeholder="Enter City">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>State</label>
                                <input class="form-control" name="state" type="state" required placeholder="Enter State">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Pincode</label>
                                <input class="form-control" name="pincode" type="text" required placeholder="Enter Pincode">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Country</label>
                                <input class="form-control" name="country" type="text" required placeholder="Enter Country">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Company Registration No</label>
                                <input class="form-control" name="company_registration_no" type="text" required placeholder="Enter Company Registration No">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>No. of Modules</label>
                                <input class="form-control" name="no_modules" type="text" required placeholder="Enter No.of Modules">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Subscription Type</label>
                                <input class="form-control" name="subscription_type" type="text" required placeholder="Enter Subscription Type">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Subscription Charges</label>
                                <input class="form-control" name="subscription_charge" type="text" required placeholder="Enter Subscription Charges">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Subscription Expiring</label>
                                <input class="form-control" name="subscription_expiring" type="text" required placeholder="Enter Subscription Expiring">
                            </div>
                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                <label class="col-form-label">Business Focus</label>
                                <div id="focus-destinations-container">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="focus_destinations[]"
                                            placeholder="Enter Business Focus">
                                        <button class="btn btn-danger remove-destination" type="button">Remove</button>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="button" id="add-destination">Add More</button>
                            </div>

                            <div class="form-group col-sm-4">
                                <label>Remarks</label>
                                <input class="form-control" name="remarks" type="text" required placeholder="Enter Remarks">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Business Mode</label>
                                <input class="form-control" name="business_mode" type="text" required placeholder="Enter Business Mode">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Key People</label>
                                <input class="form-control" name="key_people" type="text" required placeholder="Enter Key People">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Parent Company</label>
                                <input class="form-control" name="parent_company" type="text" required placeholder="Enter Parent Company">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Headquarters</label>
                                <input class="form-control" name="headquarters" type="text" required placeholder="Enter Headquarter Name">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>No. of Employees</label>
                                <input class="form-control" name="no_employees" type="number" required placeholder="Enter No. of employees">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Password</label>
                                <input class="form-control" name="password" type="password" required placeholder="Enter Password">
                            </div>
                            {{-- <div class="form-group col-sm-4">
                                <label>Select Role</label>
                                <select class="form-control" name="role" required>
                                    <option>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-sm-8">
                                <label class="col-form-label">Websites</label>
                                <div id="website-address-container">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="websites[]"
                                            placeholder="Enter website address">
                                        <button class="btn btn-danger remove-website-address"
                                            type="button">Remove</button>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="button" id="add-website-address">Add More</button>
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
    </div>
    <script>
        document.getElementById('add-destination').addEventListener('click', function() {
            const container = document.getElementById('focus-destinations-container');
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-2');
            newInputGroup.innerHTML = `
                <input type="text" class="form-control" name="focus_destinations[]" placeholder="Enter destination">
                <button class="btn btn-danger remove-destination" type="button">Remove</button>
            `;
            container.appendChild(newInputGroup);

            // Add event listener to the remove button
            newInputGroup.querySelector('.remove-destination').addEventListener('click', function() {
                container.removeChild(newInputGroup);
            });
        });
        document.getElementById('add-website-address').addEventListener('click', function() {
                const container = document.getElementById('website-address-container');
                const newInputGroup = document.createElement('div');
                newInputGroup.classList.add('input-group', 'mb-2');
                newInputGroup.innerHTML = `
                    <input type="text" class="form-control" name="websites[]" placeholder="Enter Website address">
                    <button class="btn btn-danger remove-website-address" type="button">Remove</button>
                `;
                container.appendChild(newInputGroup);

                // Add event listener to the remove button
                newInputGroup.querySelector('.remove-website-address').addEventListener('click', function() {
                    container.removeChild(newInputGroup);
                });
            });
    </script>
@endsection
