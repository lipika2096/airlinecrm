@extends('admin/layouts/head-main')

@section('content')
<style>
    .department-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .department-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .department-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .department-header h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .module-badge {
        display: inline-block;
        padding: 4px 12px;
        margin: 4px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .module-badge:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
    }

    .module-badge.active {
        background: #dcfce7;
        color: #166534;
        border-color: #86efac;
    }

    .module-badge.inactive {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fca5a5;
    }

    .module-badge .module-actions {
        margin-left: 8px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .module-badge:hover .module-actions {
        opacity: 1;
    }

    .module-badge .btn-action {
        padding: 2px 6px;
        font-size: 11px;
        margin-left: 2px;
    }

    .empty-department {
        padding: 30px;
        text-align: center;
        color: #94a3b8;
    }

    .assign-form {
        background: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        border: 1px solid #e2e8f0;
    }
</style>

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
                <div class="assign-form">
                    <h5 class="mb-3">Assign Module to Department</h5>
                    <div class="row">
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
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($departmentModules as $departmentName => $modules)
                <div class="col-md-6 col-lg-4">
                    <div class="department-card">
                        <div class="department-header">
                            <h5>
                                <i class="fa fa-building-o me-2"></i>
                                {{ $departmentName }}
                            </h5>
                            <span class="badge bg-light text-dark">
                                {{ count($modules) }} Module{{ count($modules) > 1 ? 's' : '' }}
                            </span>
                        </div>
                        <div class="card-body">
                            @if(count($modules) > 0)
                                <div class="modules-container">
                                    @foreach($modules as $module)
                                        <span class="module-badge {{ $module->is_active ? 'active' : 'inactive' }}">
                                            <i class="fa fa-cube me-1"></i>
                                            {{ ucfirst(str_replace('-', ' ', $module->module_name)) }}
                                            <span class="module-actions">
                                                <button type="button" class="btn btn-sm btn-info btn-action toggle-status"
                                                    data-department="{{ $module->department_name }}"
                                                    data-module="{{ $module->module_name }}"
                                                    title="Toggle Status">
                                                    <i class="fa fa-toggle-on"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger btn-action remove-module"
                                                    data-department="{{ $module->department_name }}"
                                                    data-module="{{ $module->module_name }}"
                                                    title="Remove Module">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </span>
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-department">
                                    <i class="fa fa-inbox fa-2x mb-2"></i>
                                    <p>No modules assigned</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
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
            button.addEventListener('click', function(e) {
                e.stopPropagation();
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
            button.addEventListener('click', function(e) {
                e.stopPropagation();
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
