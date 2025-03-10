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
                        <h3 class="page-title">Roles & Permissions</h3>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3 ">
                    <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#add_role"><i
                            class="fa fa-plus"></i> Add Roles</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
                    <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#edit_role"><i
                            class="fa fa-plus"></i> Edit Roles</a>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    @foreach ($permissions as $permission)
                                        <th class="text-center">{{ $permission->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        @foreach ($permissions as $permission)
                                            <td class="text-center">
                                                <input type="checkbox" name="permissions[{{ $role->id }}][]"
                                                    value="{{ $permission->id }}"
                                                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
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
        <!-- /Page Content -->

        <!-- Add Role Modal -->
        <!-- Add Role Modal -->
        <div id="add_role" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Role</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.roles.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Role Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Permissions</label>
                                <div>
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                                value="{{ $permission->id }}">
                                            <label class="form-check-label">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Role Modal -->

        <!-- /Add Role Modal -->

        <!-- Edit Role Modal -->
        <div id="edit_role" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Role</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Role Selection -->
                        <div class="form-group">
                            <label for="roleSelect">Select Role</label>
                            <select id="roleSelect" class="form-control">
                                <option value="" disabled selected>Select a Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Permissions Form -->
                        <form id="editRoleForm" action="{{ route('admin.roles.update') }}" method="POST"
                            style="display: none;">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="role_id" id="role_id" value="">

                            <div class="">
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
                                            <th>Permission</th>
                                            <th class="text-center">Assign</th>
                                        </tr>
                                    </thead>
                                    <tbody id="permissionsTable">
                                        <!-- Permissions checkboxes will be dynamically loaded here -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="submit-section mt-3">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Edit Role Modal -->

        <!-- Delete Role Modal -->
        <div class="modal custom-modal fade" id="delete_role" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Role</h3>
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
        <!-- /Delete Role Modal -->

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
