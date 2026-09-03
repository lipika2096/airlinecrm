@extends('admin/layouts/head-main')
@section('content')
    <title>Add Ticket Status</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add Ticket Status</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.ticket-status.index') }}">Ticket Status</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.ticket-status.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Status Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Color <span class="text-danger">*</span></label>
                                    <input class="form-control" type="color" name="color" value="#6c757d" required>
                                    <small class="text-muted">Choose a color for this status</small>
                                </div>
                                <div class="form-group">
                                    <label>Sort Order</label>
                                    <input class="form-control" type="number" name="sort_order" value="0">
                                    <small class="text-muted">Lower numbers appear first</small>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="is_active" value="1" checked>
                                        Active
                                    </label>
                                    <small class="text-muted">Uncheck to make this status inactive</small>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{ route('admin.ticket-status.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->
@endsection