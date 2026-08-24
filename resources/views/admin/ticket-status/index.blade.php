@extends('admin/layouts/head-main')
@section('content')
    <title>Ticket Status</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Ticket Status</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ticket Status</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.ticket-status.create') }}" class="btn add-btn"><i
                                class="fa fa-plus"></i> Add Ticket Status</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div>
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Status Name</th>
                                    <th>Slug</th>
                                    <th>Color</th>
                                    <th>Active</th>
                                    <th>Sort Order</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticketStatuses as $status)
                                    <tr>
                                        <td>{{ $status->name }}</td>
                                        <td>{{ $status->slug }}</td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $status->color }}; color: white;">{{ $status->color }}</span>
                                        </td>
                                        <td>
                                            @if($status->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $status->sort_order }}</td>
                                        <td class="text-end">
                                            <div class="dropdown-action">
                                                <a href="{{ route('admin.ticket-status.edit', $status->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.ticket-status.destroy', $status->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this status?')">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->
@endsection