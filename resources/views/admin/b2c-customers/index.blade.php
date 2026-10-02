@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <title>B2C Customers</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .profile-widget .user-name {
                color: #333333;
                margin-top: 30px !important;
            }

            .submit-section {
                margin-top: 10px !important;
            }
            .add-btn {
                background-color: #ff9b44;
                border: 1px solid #ff9b44;
                color: #ffffff;
                float: right;
                font-weight: 500;
                min-width: 140px;
                border-radius: 50px;
                font-size: 13px;
                transition: all 0.3s ease;
            }
            .add-btn:hover {
                background-color: #e88a3a;
                border-color: #e88a3a;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(255, 155, 68, 0.3);
            }

            /* Enhanced Card Styling */
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
            }
            .card:hover {
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            }
            .card-body {
                padding: 24px;
            }

            /* Enhanced Typography */
            .page-title {
                font-weight: 600;
                color: #1a1a2e;
                font-size: 24px;
                margin-bottom: 8px;
            }
            .breadcrumb-item a {
                color: #6c757d;
                transition: color 0.2s ease;
            }
            .breadcrumb-item a:hover {
                color: #ff9b44;
            }
            .breadcrumb-item.active {
                color: #ff9b44;
                font-weight: 500;
            }

            /* Enhanced Search & Filters */
            .form-control {
                border-radius: 8px;
                border: 1px solid #e0e0e0;
                padding: 12px 16px;
                font-size: 14px;
                transition: all 0.3s ease;
            }
            .form-control:focus {
                border-color: #ff9b44;
                box-shadow: 0 0 0 3px rgba(255, 155, 68, 0.1);
            }
            .btn-primary {
                background-color: #ff9b44;
                border-color: #ff9b44;
                border-radius: 8px;
                padding: 12px 24px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background-color: #e88a3a;
                border-color: #e88a3a;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(255, 155, 68, 0.3);
            }

            /* Enhanced Table Styling */
            .table-responsive {
                border-radius: 8px;
                overflow: hidden;
            }
            .custom-table {
                margin-bottom: 0;
            }
            .custom-table thead th {
                background-color: #f8f9fa;
                color: #495057;
                font-weight: 600;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 16px;
                border-bottom: 2px solid #e9ecef;
            }
            .custom-table tbody td {
                padding: 16px;
                vertical-align: middle;
                font-size: 14px;
                color: #495057;
                border-bottom: 1px solid #e9ecef;
            }
            .custom-table tbody tr:hover {
                background-color: #f8f9fa;
            }
            .custom-table tbody tr:last-child td {
                border-bottom: none;
            }

            /* Enhanced Action Icons */
            .action-icons {
                display: flex;
                gap: 8px;
                justify-content: center;
            }
            .action-icon {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #6c757d;
                transition: all 0.3s ease;
                background-color: #f8f9fa;
            }
            .action-icon:hover {
                color: #ff9b44;
                background-color: #fff3e6;
                transform: translateY(-2px);
            }

            /* Enhanced Badges */
            .badge {
                padding: 8px 12px;
                border-radius: 6px;
                font-size: 12px;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Enhanced Modal */
            .modal-content {
                border-radius: 12px;
                border: none;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            }
            .modal-header {
                border-bottom: 1px solid #e9ecef;
                padding: 20px 24px;
            }
            .modal-body {
                padding: 24px;
            }
            .modal-footer {
                border-top: 1px solid #e9ecef;
                padding: 16px 24px;
            }

            /* Enhanced Pagination */
            .pagination .page-link {
                color: #495057;
                border: 1px solid #dee2e6;
                border-radius: 6px;
                margin: 0 4px;
                padding: 8px 12px;
                transition: all 0.3s ease;
            }
            .pagination .page-link:hover {
                color: #ff9b44;
                border-color: #ff9b44;
                background-color: #fff3e6;
            }
            .pagination .page-item.active .page-link {
                background-color: #ff9b44;
                border-color: #ff9b44;
                color: white;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">B2C Customers</h3>
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.dashboard') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : route('staff.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">B2C Customers</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        @canCreate('b2c-customers.b2c-customers-list')
                            <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.create') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.create') : route('staff.b2c-customers.create')) }}" class="btn add-btn">
                                <i class="fa fa-plus me-2"></i> Add Customer
                            </a>
                        @endcanCreate
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted mb-4">Manage individual (B2C) customers with their travel preferences and passenger details.</p>

                            <!-- Search and Filters -->
                            <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.index') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.index') : route('staff.b2c-customers.index')) }}" method="get" class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control" placeholder="Search by name, email, phone..." value="{{ request()->search ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="customer_type">
                                            <option value="">Customer Type: All</option>
                                            <option value="individual" @if (request()->customer_type == 'individual') selected @endif>Individual</option>
                                            <option value="corporate" @if (request()->customer_type == 'corporate') selected @endif>Corporate</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="status">
                                            <option value="">Status: All</option>
                                            <option value="active" @if (request()->status == 'active') selected @endif>Active</option>
                                            <option value="inactive" @if (request()->status == 'inactive') selected @endif>Inactive</option>
                                            <option value="blocked" @if (request()->status == 'blocked') selected @endif>Blocked</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">Search</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Customers Table -->
                            <div class="table-responsive">
                                <table class="table table-hover custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($customers as $customer)
                                            <tr>
                                                <td><strong>{{ $customer->id }}</strong></td>
                                                <td>{{ $customer->full_name }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td><span class="badge bg-light text-dark">{{ ucfirst($customer->customer_type) }}</span></td>
                                                <td>
                                                    <span class="badge bg-{{ $customer->status == 'active' ? 'success' : ($customer->status == 'inactive' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($customer->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-icons">
                                                        @canView('b2c-customers.b2c-customers-list')
                                                            <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.show', $customer->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.show', $customer->id) : route('staff.b2c-customers.show', $customer->id)) }}" class="action-icon" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endcanView
                                                        @canEdit('b2c-customers.b2c-customers-list')
                                                            <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.edit', $customer->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.edit', $customer->id) : route('staff.b2c-customers.edit', $customer->id)) }}" class="action-icon" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcanEdit
                                                        @canDelete('b2c-customers.b2c-customers-list')
                                                            <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#delete_customer{{ $customer->id }}" title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endcanDelete
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fa fa-inbox fa-2x mb-2"></i>
                                                        <p>No B2C customers found</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if ($customers->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <p class="text-muted mb-0 small">Showing {{ $customers->firstItem() }}-{{ $customers->lastItem() }} of {{ $customers->total() }} customers</p>
                                    {{ $customers->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @foreach ($customers as $customer)
        <div class="modal fade" id="delete_customer{{ $customer->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="fa fa-exclamation-circle text-warning fa-3x"></i>
                            </div>
                            <p class="mb-0">Are you sure you want to delete <strong>{{ $customer->full_name }}</strong>?</p>
                            <p class="text-muted small mb-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.destroy', $customer->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.destroy', $customer->id) : route('staff.b2c-customers.destroy', $customer->id)) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection