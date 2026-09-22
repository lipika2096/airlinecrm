@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <title>Products & Services</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
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
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Products & Services</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Products & Services</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.products.create') }}" class="btn add-btn mt-3">
                            <i class="fa fa-plus"></i> Add Product
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted">Manage all products and services available for B2B partners. Add, edit, or remove products as needed.</p>
                            
                            <!-- Products Table -->
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->description ?? '-' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $product->status == 'Active' ? 'success' : 'danger' }}">
                                                        {{ $product->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-icons">
                                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="action-icon" style="margin-right: 10px;">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#delete_product{{ $product->id }}">
                                                            <i class="fa fa-trash m-r-5"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No products found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if ($products->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <p class="text-muted mb-0">Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }}</p>
                                    {{ $products->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @foreach ($products as $product)
        <div class="modal fade" id="delete_product{{ $product->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete {{ $product->product_name }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection