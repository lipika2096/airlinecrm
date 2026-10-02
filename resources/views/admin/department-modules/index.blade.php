@extends('admin/layouts/head-main')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Department Module Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Department Modules</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Assign Modules to Departments</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Department Name</label>
                                <select id="departmentName" class="form-control">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $departmentId => $departmentName)
                                        <option value="{{ $departmentName }}">{{ $departmentName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Module Name</label>
                                <select id="moduleName" class="form-control">
                                    <option value="">Select Module</option>
                                    @foreach($availableModules as $moduleKey => $moduleName)
                                        <option value="{{ $moduleKey }}">{{ $moduleName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" id="assignModule" class="btn btn-primary w-100">
                                    <i class="fa fa-plus"></i> Assign Module
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Module</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="departmentModulesTable">
                                    @foreach($departmentModules as $departmentName => $modules)
                                        @foreach($modules as $module)
                                        <tr data-department="{{ $module->department_name }}" data-module="{{ $module->module_name }}">
                                            <td>{{ $module->department_name }}</td>
                                            <td>{{ ucfirst(str_replace('-', ' ', $module->module_name)) }}</td>
                                            <td>
                                                @if($module->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info toggle-status"
                                                    data-department="{{ $module->department_name }}"
                                                    data-module="{{ $module->module_name }}">
                                                    <i class="fa fa-toggle-on"></i> Toggle
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger remove-module"
                                                    data-department="{{ $module->department_name }}"
                                                    data-module="{{ $module->module_name }}">
                                                    <i class="fa fa-trash"></i> Remove
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Assign module to department
        document.getElementById('assignModule').addEventListener('click', function() {
            const departmentName = document.getElementById('departmentName').value;
            const moduleName = document.getElementById('moduleName').value;

            if (!departmentName || !moduleName) {
                alert('Please select both department and module');
                return;
            }

            fetch('{{ route('admin.department-modules.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    department_name: departmentName,
                    module_name: moduleName
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Module assigned successfully');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });

        // Remove module from department
        document.querySelectorAll('.remove-module').forEach(function(button) {
            button.addEventListener('click', function() {
                const departmentName = this.dataset.department;
                const moduleName = this.dataset.module;

                if (!confirm('Are you sure you want to remove this module from the department?')) {
                    return;
                }

                fetch('{{ route('admin.department-modules.destroy') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        department_name: departmentName,
                        module_name: moduleName,
                        _method: 'DELETE'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Module removed successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
            });
        });

        // Toggle module status
        document.querySelectorAll('.toggle-status').forEach(function(button) {
            button.addEventListener('click', function() {
                const departmentName = this.dataset.department;
                const moduleName = this.dataset.module;

                fetch('{{ route('admin.department-modules.toggle') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        department_name: departmentName,
                        module_name: moduleName
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status updated successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
            });
        });
    });
</script>
@endsection
