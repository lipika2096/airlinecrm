@extends('admin/layouts/head-main')
@section('content')
    <title>Supplier Register</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .status-badge {
                display: inline-flex;
                align-items: center;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
            }
            .status-active {
                background-color: #d4edda;
                color: #155724;
            }
            .status-inactive {
                background-color: #f8d7da;
                color: #721c24;
            }
            .status-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                margin-right: 6px;
            }
            .status-active .status-dot {
                background-color: #28a745;
            }
            .status-inactive .status-dot {
                background-color: #dc3545;
            }
            .modal-body .card {
                border: 1px solid #e9ecef;
                box-shadow: none;
            }
            .modal-body .card-body {
                padding: 20px;
            }
            .form-label {
                font-weight: 500;
                color: #495057;
            }
            .modal-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid #dee2e6;
            }
            .modal-footer {
                background-color: #f8f9fa;
                border-top: 1px solid #dee2e6;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Supplier Register</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Supplier Register</li>
                        </ul>
                        <p class="text-muted" style="margin-top: 5px;">Manage your suppliers, add new suppliers and keep their information up to date.</p>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.suppliers.create') }}" class="btn add-btn"><i
                                class="fa fa-plus"></i> Add Supplier</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Search and Filters -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="searchInput" placeholder="Search supplier by name, code or email..." value="{{ request('q') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="searchSuppliers()">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" id="categoryFilter" onchange="searchSuppliers()">
                                        <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Suppliers</option>
                                        <option value="Airline" {{ request('category') == 'Airline' ? 'selected' : '' }}>Airline</option>
                                        <option value="Hotel" {{ request('category') == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                                        <option value="Transport" {{ request('category') == 'Transport' ? 'selected' : '' }}>Transport</option>
                                        <option value="Food" {{ request('category') == 'Food' ? 'selected' : '' }}>Food</option>
                                        <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" id="statusFilter" onchange="searchSuppliers()">
                                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-4 text-end">
                                    <span class="text-muted">Total: {{ $suppliers->total() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Supplier Code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Contact Person</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->supplier_code }}</td>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->category }}</td>
                                        <td>{{ $supplier->contact_person }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td>
                                            <span class="status-badge {{ $supplier->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                                <span class="status-dot"></span>
                                                {{ ucfirst($supplier->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-icons">
                                                <a href="{{ route('admin.suppliers.show', $supplier->id) }}" class="btn btn-sm btn-primary me-1">
                                                    <i class="fa fa-eye text-white"></i>
                                                </a>
                                                <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-info me-1">
                                                    <i class="fa fa-pencil text-white"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal_{{ $supplier->id }}">
                                                    <i class="fa fa-trash text-white"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No suppliers found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="text-end">
                        {{ $suppliers->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->

    <!-- Delete Supplier Modal -->
    @foreach ($suppliers->items() as $supplier)
        <div id="delete_modal_{{ $supplier->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Supplier</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i>
                            <strong>Warning:</strong> This action cannot be undone.
                        </div>
                        <p>Are you sure you want to delete this supplier?</p>
                        <div class="card bg-light">
                            <div class="card-body">
                                <p class="mb-0"><strong>{{ $supplier->name }}</strong></p>
                                <p class="mb-0 text-muted">Code: {{ $supplier->supplier_code }}</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <div class="submit-section">
                                <button type="submit" class="btn btn-danger">Delete</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function searchSuppliers() {
            const searchValue = document.getElementById('searchInput').value;
            const category = document.getElementById('categoryFilter').value;
            const status = document.getElementById('statusFilter').value;

            const url = new URL("{{ route('admin.suppliers') }}", window.location.origin);
            url.searchParams.set('q', searchValue);
            url.searchParams.set('category', category);
            url.searchParams.set('status', status);

            window.location.href = url.toString();
        }

        // Allow search on Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchSuppliers();
            }
        });
    </script>
@endsection
