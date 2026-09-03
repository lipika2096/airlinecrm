@extends('admin/layouts/head-main')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Customer Permitted Modules</h3>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs" id="permissionTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="published-tab" data-bs-toggle="tab" href="#published" role="tab">Published</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="unpublished-tab" data-bs-toggle="tab" href="#unpublished" role="tab">Unpublished</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="customer-permitted-tab" data-bs-toggle="tab" href="#customer-permitted" role="tab">Customer Permitted</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="staff-permitted-tab" data-bs-toggle="tab" href="#staff-permitted" role="tab">Staff Permitted</a>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content mt-3">
                                <!-- Published Tab -->
                                <div class="tab-pane fade show active" id="published" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table datatable">
                                            <thead>
                                                <tr>
                                                    <th>Permission Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($publishedPermissions as $permission)
                                                    <tr>
                                                        <td>{{ ucfirst(str_replace('access ', '', $permission->name)) }}</td>
                                                        <td><span class="badge bg-success">{{ $permission->status }}</span></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-sm btn-warning change-status" data-id="{{ $permission->id }}" data-status="unpublished">Unpublish</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Unpublished Tab -->
                                <div class="tab-pane fade" id="unpublished" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table datatable">
                                            <thead>
                                                <tr>
                                                    <th>Permission Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($unpublishedPermissions as $permission)
                                                    <tr>
                                                        <td>{{ ucfirst(str_replace('access ', '', $permission->name)) }}</td>
                                                        <td><span class="badge bg-secondary">{{ $permission->status }}</span></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-sm btn-success change-status" data-id="{{ $permission->id }}" data-status="published">Publish</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Customer Permitted Tab -->
                                <div class="tab-pane fade" id="customer-permitted" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table datatable">
                                            <thead>
                                                <tr>
                                                    <th>Customer</th>
                                                    @foreach ($publishedPermissions as $permission)
                                                        <th class="text-center">{{ ucfirst(str_replace('access ', '', $permission->name)) }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customers as $customer)
                                                    <tr>
                                                        <td>{{ $customer->name }}</td>
                                                        @foreach ($publishedPermissions as $permission)
                                                            <td class="text-center">
                                                                <input type="checkbox" class="permission-checkbox"
                                                                    data-customer-id="{{ $customer->id }}"
                                                                    data-permission-id="{{ $permission->id }}"
                                                                    {{ $customer->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Staff Permitted Tab -->
                                <div class="tab-pane fade" id="staff-permitted" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table datatable">
                                            <thead>
                                                <tr>
                                                    <th>Staff Member</th>
                                                    @foreach ($publishedPermissions as $permission)
                                                        <th class="text-center">{{ ucfirst(str_replace('access ', '', $permission->name)) }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($staff as $staffMember)
                                                    <tr>
                                                        <td>{{ $staffMember->name }}</td>
                                                        @foreach ($publishedPermissions as $permission)
                                                            <td class="text-center">
                                                                <input type="checkbox" class="staff-permission-checkbox"
                                                                    data-staff-id="{{ $staffMember->id }}"
                                                                    data-permission-id="{{ $permission->id }}"
                                                                    {{ $staffMember->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                            </td>
                                                        @endforeach
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
            </div>
        </div>
        <!-- /Page Content -->



        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Add this inside the <head> tag -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <!-- Add this before closing </body> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            $('.permission-checkbox').on('change', function () {
                var customerId = $(this).data('customer-id');
                var permissionId = $(this).data('permission-id');
                var isChecked = $(this).is(':checked');

                $.ajax({
                    url: '{{ route("admin.update.customer.permission") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        customer_id: customerId,
                        permission_id: permissionId,
                        assign: isChecked
                    },
                    success: function (response) {
                        toastr.success(response.message);
                    },
                    error: function (xhr) {
                        let msg = 'Something went wrong!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        toastr.error(msg);
                    }
                });
            });

            $('.staff-permission-checkbox').on('change', function () {
                var staffId = $(this).data('staff-id');
                var permissionId = $(this).data('permission-id');
                var isChecked = $(this).is(':checked');

                $.ajax({
                    url: '{{ route("admin.update.staff.permission") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        staff_id: staffId,
                        permission_id: permissionId,
                        assign: isChecked
                    },
                    success: function (response) {
                        toastr.success(response.message);
                    },
                    error: function (xhr) {
                        let msg = 'Something went wrong!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        toastr.error(msg);
                    }
                });
            });

            // Change permission status
            $('.change-status').on('click', function () {
                var permissionId = $(this).data('id');
                var newStatus = $(this).data('status');
                var button = $(this);

                $.ajax({
                    url: '{{ route("admin.update.permission.status") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        permission_id: permissionId,
                        status: newStatus
                    },
                    success: function (response) {
                        toastr.success(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        let msg = 'Something went wrong!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        toastr.error(msg);
                    }
                });
            });

        </script>


    </div>
    <!-- /Page Wrapper -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        document.getElementById('roleSelect').addEventListener('change', function() {
            const roleId = this.value;

            if (roleId) {
                // Make an AJAX request to get role permissions
                fetch(`roles/${roleId}/permissions`)
                    .then(response => response.json())
                    .then(data => {
                        const permissionsTable = document.getElementById('permissionsTable');
                        const editRoleForm = document.getElementById('editRoleForm');
                        const roleIdInput = document.getElementById('role_id');

                        // Clear existing table rows
                        permissionsTable.innerHTML = '';

                        // Update hidden input with role ID
                        roleIdInput.value = roleId;

                        // Populate permissions table
                        data.permissions.forEach(permission => {
                            const isChecked = data.role_permissions.includes(permission.id) ?
                                'checked' : '';
                            permissionsTable.innerHTML += `
                        <tr>
                            <td>${permission.name}</td>
                            <td class="text-center">
                                <input type="checkbox" name="permissions[]" value="${permission.id}" ${isChecked}>
                            </td>
                        </tr>
                    `;
                        });

                        // Show the form
                        editRoleForm.style.display = 'block';
                    })
                    .catch(error => console.error('Error fetching permissions:', error));
            }
        });
    </script>
@endsection
