@extends('admin/layouts/head-main')
@section('content')
    <title>Customer Subscriptions</title>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Customer Subscriptions</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::getDashboardRoute() }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customer Subscriptions</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="card-title">New Subscription</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('admin.customer.subscriptions.store') }}" method="POST" id="subscriptionForm">
                                @csrf

                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Select Customer</label>
                                        <select class="form-control select" name="customer_id" id="customerSelect" required>
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ $selectedCustomer && $selectedCustomer->id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Billing Frequency</label>
                                        <select class="form-control select" name="billing_frequency" id="billingFrequency" required>
                                            <option value="monthly" {{ $existingSubscription && $existingSubscription->subscription_type == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="annual" {{ $existingSubscription && $existingSubscription->subscription_type == 'annual' ? 'selected' : '' }}>Annual</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="button" class="btn btn-info" id="loadExistingBtn" @if(!$selectedCustomer) disabled @endif>
                                            <i class="fa fa-refresh"></i> Load Existing Subscription
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5 class="mb-3">Select Modules</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="50"></th>
                                                    <th>Module</th>
                                                    <th>Description</th>
                                                    <th>Monthly Price</th>
                                                    <th>Annual Price</th>
                                                    <th width="80">View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($modules as $module)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="form-check-input module-checkbox"
                                                                   name="modules[]" value="{{ $module->id }}"
                                                                   data-monthly="{{ $module->monthly_price }}"
                                                                   data-annual="{{ $module->monthly_price * 12 }}"
                                                                   @if(in_array($module->id, $existingModules)) checked @endif>
                                                        </td>
                                                        <td>{{ ucfirst(str_replace('-', ' ', $module->name)) }}</td>
                                                        <td>{{ $module->description ?? '-' }}</td>
                                                        <td>${{ number_format($module->monthly_price, 2) }}</td>
                                                        <td>${{ number_format($module->monthly_price * 12, 2) }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-outline-primary view-submodules-btn"
                                                                    data-module="{{ $module->name }}"
                                                                    data-module-id="{{ $module->id }}">
                                                                <i class="fa fa-cog"></i> View
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Setup Fee (Optional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" name="setup_fee" id="setupFee"
                                                   value="100.00" step="0.01" min="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5>Monthly Total</h5>
                                                        <h3 class="text-primary" id="monthlyTotal">$0.00</h3>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5>Annual Total (with {{ $annualDiscount }}% discount)</h5>
                                                        <h3 class="text-success" id="annualTotal">$0.00</h3>
                                                        <small class="text-danger" id="savingsAmount"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">Request Approval</button>
                                    <a href="{{ \App\Helpers\RouteHelper::getDashboardRoute() }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Store module data for JavaScript -->
    <script>
        window.modulesData = {!! json_encode($allPermissions->map(function($module) {
            return [
                'name' => $module->name,
                'description' => $module->description
            ];
        })->toArray()) !!};
    </script>

    <!-- Submodule View Modal -->
    <div id="submoduleViewModal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Configure Submodule Permissions</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6 id="modalModuleName" class="text-primary font-weight-bold"></h6>
                        <p class="text-muted">Configure access for individual submodules and their actions</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Submodule</th>
                                    <th class="text-center">View</th>
                                    <th class="text-center">Create</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="submoduleTableBody">
                                <!-- Submodules will be loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveSubmodulePermissions">Save Permissions</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const moduleCheckboxes = document.querySelectorAll('.module-checkbox');
            const setupFeeInput = document.getElementById('setupFee');
            const monthlyTotalEl = document.getElementById('monthlyTotal');
            const annualTotalEl = document.getElementById('annualTotal');
            const savingsAmountEl = document.getElementById('savingsAmount');
            const annualDiscount = {{ $annualDiscount }};
            const customerSelect = document.getElementById('customerSelect');
            const loadExistingBtn = document.getElementById('loadExistingBtn');

            // Track current module and customer for submodule permissions
            let currentModule = null;
            let currentCustomerId = null;

            function calculateTotals() {
                let monthlyTotal = 0;
                let annualTotal = 0;

                moduleCheckboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        monthlyTotal += parseFloat(checkbox.dataset.monthly);
                        annualTotal += parseFloat(checkbox.dataset.annual);
                    }
                });

                const discountAmount = (annualTotal * annualDiscount) / 100;
                const annualTotalWithDiscount = annualTotal - discountAmount;

                monthlyTotalEl.textContent = '$' + monthlyTotal.toFixed(2);
                annualTotalEl.textContent = '$' + annualTotalWithDiscount.toFixed(2);

                if (discountAmount > 0) {
                    savingsAmountEl.textContent = 'Save $' + discountAmount.toFixed(2);
                } else {
                    savingsAmountEl.textContent = '';
                }
            }

            moduleCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', calculateTotals);
            });

            setupFeeInput.addEventListener('input', calculateTotals);

            // Load existing subscription when customer is selected
            customerSelect.addEventListener('change', function() {
                const customerId = this.value;
                if (customerId) {
                    window.location.href = '{{ route('admin.customer.subscriptions') }}?customer_id=' + customerId;
                }
            });

            // Load existing subscription button
            loadExistingBtn.addEventListener('click', function() {
                // Uncheck all first
                moduleCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });

                // Check existing modules
                const existingModules = {!! json_encode($existingModules) !!};
                moduleCheckboxes.forEach(function(checkbox) {
                    if (existingModules.includes(parseInt(checkbox.value))) {
                        checkbox.checked = true;
                    }
                });

                // Update totals
                calculateTotals();
            });

            // Initial calculation
            calculateTotals();

            // View Submodules Modal functionality
            document.querySelectorAll('.view-submodules-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const moduleName = this.dataset.module;
                    const moduleDisplayName = this.dataset.moduleDisplay;
                    const moduleId = this.dataset.moduleId;
                    const customerId = document.getElementById('customerSelect').value;

                    // Set current module and customer
                    currentModule = moduleName;
                    currentCustomerId = customerId;

                    // Set modal title
                    document.getElementById('modalModuleName').textContent = moduleDisplayName;

                    // Load submodules for this module
                    loadSubmodules(moduleName, moduleId, customerId);

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('submoduleViewModal'));
                    modal.show();
                });
            });

            function loadSubmodules(moduleName, moduleId, customerId) {
                // Get all permissions from global window.modulesData
                const allPermissions = window.modulesData || [];

                // Get existing permissions for this customer's module
                fetch('{{ route('admin.module.permissions', ':id') }}'.replace(':id', customerId))
                    .then(response => response.json())
                    .then(permissionData => {
                        const existingPermissions = permissionData.data || {};

                        // Filter submodules that belong to this module (format: module-name.submodule-name)
                        const moduleSubmodules = allPermissions.filter(perm =>
                            perm.name && perm.name.startsWith(moduleName + '.')
                        ).map(perm => {
                            const parts = perm.name.split('.');
                            const submoduleKey = parts[1];
                            const permissionKey = perm.name;

                            // Get existing permission for this submodule
                            const existingPerm = existingPermissions[permissionKey] || {};

                            return {
                                key: submoduleKey,
                                name: submoduleKey.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()),
                                description: perm.description || '',
                                can_view: existingPerm.can_view || false,
                                can_create: existingPerm.can_create || false,
                                can_edit: existingPerm.can_edit || false,
                                can_delete: existingPerm.can_delete || false
                            };
                        });

                        renderSubmoduleTable(moduleSubmodules);
                    })
                    .catch(error => {
                        console.error('Error loading permissions:', error);
                        // Load without existing permissions on error
                        const moduleSubmodules = allPermissions.filter(perm =>
                            perm.name && perm.name.startsWith(moduleName + '.')
                        ).map(perm => {
                            const parts = perm.name.split('.');
                            const submoduleKey = parts[1];
                            return {
                                key: submoduleKey,
                                name: submoduleKey.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()),
                                description: perm.description || '',
                                can_view: false,
                                can_create: false,
                                can_edit: false,
                                can_delete: false
                            };
                        });
                        renderSubmoduleTable(moduleSubmodules);
                    });
            }

            function renderSubmoduleTable(submodules) {
                const tbody = document.getElementById('submoduleTableBody');
                tbody.innerHTML = '';

                if (submodules.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center">No submodules available for this module</td></tr>';
                    return;
                }

                submodules.forEach(submodule => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>
                            <strong>${submodule.name}</strong>
                            ${submodule.description ? `<br><small class="text-muted">${submodule.description}</small>` : ''}
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="form-check-input submodule-action-toggle"
                                   data-submodule="${submodule.key}"
                                   data-action="view"
                                   ${submodule.can_view ? 'checked' : ''}>
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="form-check-input submodule-action-toggle"
                                   data-submodule="${submodule.key}"
                                   data-action="create"
                                   ${submodule.can_create ? 'checked' : ''}>
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="form-check-input submodule-action-toggle"
                                   data-submodule="${submodule.key}"
                                   data-action="edit"
                                   ${submodule.can_edit ? 'checked' : ''}>
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="form-check-input submodule-action-toggle"
                                   data-submodule="${submodule.key}"
                                   data-action="delete"
                                   ${submodule.can_delete ? 'checked' : ''}>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }

            // Save submodule permissions
            document.getElementById('saveSubmodulePermissions').addEventListener('click', function() {
                if (!currentCustomerId) {
                    alert('Please select a customer first');
                    return;
                }

                const permissionsData = {};

                document.querySelectorAll('.submodule-action-toggle').forEach(function(checkbox) {
                    const submodule = checkbox.dataset.submodule;
                    const action = checkbox.dataset.action;
                    const permissionKey = currentModule + '.' + submodule;

                    if (!permissionsData[permissionKey]) {
                        permissionsData[permissionKey] = {
                            has_access: true,
                            can_view: false,
                            can_create: false,
                            can_edit: false,
                            can_delete: false
                        };
                    }

                    if (checkbox.checked) {
                        permissionsData[permissionKey]['can_' + action] = true;
                    }
                });

                // Send update request
                fetch('{{ route('admin.update.module.access') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        employee_id: currentCustomerId,
                        module: currentModule,
                        access: true,
                        permissions: permissionsData
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Submodule permissions saved successfully');
                        const modal = bootstrap.Modal.getInstance(document.getElementById('submoduleViewModal'));
                        modal.hide();
                    } else {
                        alert('Error saving permissions: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error saving permissions: ' + error);
                });
            });
        });
    </script>
@endsection
