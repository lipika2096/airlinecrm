@extends('admin/layouts/head-main')
@section('content')
    <title>Edit Ticket Status</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Ticket Status</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.ticket-status.index') }}">Ticket Status</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.ticket-status.update', $ticketStatus->id) }}">
                                @csrf
                                @method('patch')
                                <div class="form-group">
                                    <label>Status Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" value="{{ $ticketStatus->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" rows="3">{{ $ticketStatus->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Color <span class="text-danger">*</span></label>
                                    <input class="form-control" type="color" name="color" value="{{ $ticketStatus->color }}" required>
                                    <small class="text-muted">Choose a color for this status</small>
                                </div>
                                <div class="form-group">
                                    <label>Sort Order</label>
                                    <input class="form-control" type="number" name="sort_order" value="{{ $ticketStatus->sort_order }}">
                                    <small class="text-muted">Lower numbers appear first</small>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="is_active" value="1" {{ $ticketStatus->is_active ? 'checked' : '' }}>
                                        Active
                                    </label>
                                    <small class="text-muted">Uncheck to make this status inactive</small>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary" type="submit">Update</button>
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