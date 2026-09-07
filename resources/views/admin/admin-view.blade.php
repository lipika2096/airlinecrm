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
                        <h3 class="page-title">Customer List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customer List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ \App\Helpers\RouteHelper::isStaff() ? route('staff.admin.add-customer') : route('admin.admin.add-customer') }}" class="btn btn-primary text-white" ><i class="fa fa-plus"></i> Add Customer</a>

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
                                            <!-- <th>Role</th> -->
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Company Name</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admin as $data)
                                            <tr>
                                                <!-- <td>{{ $data->getRoleNames()->implode(', ') }}</td> -->
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->adminDetail->company_name ??'-' }}</td>
                                                <td>{{ $data->adminDetail->city ??'-'}}</td>
                                                <td>{{ $data->adminDetail->state??'-' }}</td>
                                                <td>{{ $data->adminDetail->country ??'-'}}</td>
                                                <td style="word-wrap: break-word; max-width: 200px;">{{ $data->adminDetail->address??'-' }}</td>
                                                <td>
                                                    @if($data->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-default" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="{{\App\Helpers\RouteHelper::isStaff() ? route('staff.customer.view', ['id'=> $data->id]) :route('admin.customer.view', ['id'=> $data->id])}}">
                                                                    <i class="fa fa-eye me-2"></i> View Profile
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ \App\Helpers\RouteHelper::isStaff() ? route('staff.toggle.status', ['id'=> $data->id]) : route('admin.toggle.status', ['id'=> $data->id]) }}">
                                                                    <i class="fa {{ $data->is_active ? 'fa-ban' : 'fa-check' }} me-2"></i>
                                                                    {{ $data->is_active ? 'Deactivate' : 'Activate' }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
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

        // Auto-fill modules when sales package is selected
        document.getElementById('sales_package_select').addEventListener('change', function() {
            const packageId = this.value;
            const modulesSelect = document.getElementById('modules_select');
            
            if (packageId) {
                // Fetch package data via AJAX
                fetch(`./superadmin/sales-packages/${packageId}`)
                    .then(response => response.json())
                    .then(data => {
                        
                        console.log(data);
                        document.getElementById('modules_input').value = data.modules_list;
                        document.getElementById('modules_ids').value = JSON.stringify(data.modules);
                        document.getElementById('subscription_charge').value = data.rate;
                    })
                    .catch(error => console.error('Error fetching package:', error));
            } else {
                // Clear all selections if no package selected
                Array.from(modulesSelect.options).forEach(option => {
                    option.selected = false;
                });
            }
        });
    </script>
@endsection
