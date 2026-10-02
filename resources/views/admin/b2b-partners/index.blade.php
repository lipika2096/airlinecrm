@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <title>B2B Travel Partners</title>

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
            span.select2-selection.select2-selection--multiple {
                height: 44px;
            }
            .select2-container--bootstrap-5.select2-container--focus .select2-selection, .select2-container--bootstrap-5.select2-container--open .select2-selection{
                box-shadow:none !important;
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
                        <h3 class="page-title">View B2B Travel Partners List</h3>
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.dashboard') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : route('staff.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">B2B Travel Partners</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <!-- @canView('travel-agent.reports') -->
                            <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.reports') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners.reports') : route('staff.b2b-partners.reports')) }}" class="btn btn-primary me-2">
                                <i class="fa fa-chart-bar me-2"></i> Reports
                            </a>
                        <!-- @endcanView -->
                        @canCreate('b2b-partners.b2b-partners-list')
                            <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.create') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners.create') : route('staff.b2b-partners.create')) }}" class="btn add-btn">
                                <i class="fa fa-plus me-2"></i> Add Partner
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
                            <p class="text-muted mb-4">See all existing travel agents and partners with key details. Use search, filters or click the + Add Partner button.</p>

                            <!-- Search and Filters -->
                            <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners') : route('staff.b2b-partners')) }}" method="get" class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control" placeholder="Search by name, IATA, email..." value="{{ request()->search ?? '' }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="partner_type">
                                            <option value="">Partner Type: All</option>
                                            <option value="Travel Agent" @if (request()->partner_type == 'Travel Agent') selected @endif>Travel Agent</option>
                                            <option value="Tour Operator" @if (request()->partner_type == 'Tour Operator') selected @endif>Tour Operator</option>
                                            <option value="Corporate" @if (request()->partner_type == 'Corporate') selected @endif>Corporate</option>
                                            <option value="TMC" @if (request()->partner_type == 'TMC') selected @endif>TMC</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="status">
                                            <option value="">Status: All</option>
                                            <option value="Active" @if (request()->status == 'Active') selected @endif>Active</option>
                                            <option value="Pending" @if (request()->status == 'Pending') selected @endif>Pending</option>
                                            <option value="Inactive" @if (request()->status == 'Inactive') selected @endif>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">Search</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Partners Table -->
                            <div class="table-responsive">
                                <table class="table table-hover custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Partner Name</th>
                                            <th>Type</th>
                                            <th>IATA / TIDS No.</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($partners as $partner)
                                            <tr>
                                                <td><strong>{{ $partner->partner_code }}</strong></td>
                                                <td>{{ $partner->partner_name }}</td>
                                                <td><span class="badge bg-light text-dark">{{ $partner->partner_type }}</span></td>
                                                <td>{{ $partner->iata_tids_no ?? '-' }}</td>
                                                <td>{{ $partner->country }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $partner->status == 'Active' ? 'success' : ($partner->status == 'Pending' ? 'warning' : 'danger') }}">
                                                        {{ $partner->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-icons">
                                                        @canView('b2b-partners.b2b-partners-list')
                                                            <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.show', $partner->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners.show', $partner->id) : route('staff.b2b-partners.show', $partner->id)) }}" class="action-icon" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endcanView
                                                        @canEdit('b2b-partners.b2b-partners-list')
                                                            <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.edit', $partner->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners.edit', $partner->id) : route('staff.b2b-partners.edit', $partner->id)) }}" class="action-icon" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcanEdit
                                                        @canDelete('b2b-partners.b2b-partners-list')
                                                            <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#delete_partner{{ $partner->id }}" title="Delete">
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
                                                        <p>No B2B partners found</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if ($partners->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <p class="text-muted mb-0 small">Showing {{ $partners->firstItem() }}-{{ $partners->lastItem() }} of {{ $partners->total() }} partners</p>
                                    {{ $partners->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @foreach ($partners as $partner)
        <div class="modal fade" id="delete_partner{{ $partner->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Partner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="fa fa-exclamation-circle text-warning fa-3x"></i>
                            </div>
                            <p class="mb-0">Are you sure you want to delete <strong>{{ $partner->partner_name }}</strong>?</p>
                            <p class="text-muted small mb-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.destroy', $partner->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners.destroy', $partner->id) : route('staff.b2b-partners.destroy', $partner->id)) }}" method="POST" style="display: inline;">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection