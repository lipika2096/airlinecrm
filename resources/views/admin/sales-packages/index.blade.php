@extends('admin/layouts/head-main')
@section('content')
    <title>Sales Packages</title>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Sales Packages</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sales Packages</li>
                        </ul>
                    </div>
                    <div class="col-auto text-end">
                        <a href="{{ route('admin.sales-packages.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add Package
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Package Name</th>
                                            <th>Rate</th>
                                            <th>Monthly Rate</th>
                                            <th>Annual Rate</th>
                                            <th>Modules</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($packages as $package)
                                            <tr>
                                                <td>{{ $package->package_name }}</td>
                                                <td>${{ number_format($package->rate, 2) }}</td>
                                                <td>{{ $package->monthly_rate ? '$' . number_format($package->monthly_rate, 2) : '-' }}</td>
                                                <td>{{ $package->annual_rate ? '$' . number_format($package->annual_rate, 2) : '-' }}</td>
                                                <td>{{ $package->modules_list }}</td>
                                                <td>{{ Str::limit($package->description, 50) ?? '-' }}</td>
                                                <td>
                                                    @if($package->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.sales-packages.edit', $package->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.sales-packages.toggle-status', $package->id) }}" class="btn btn-sm {{ $package->is_active ? 'btn-warning' : 'btn-success' }}">
                                                        <i class="fa {{ $package->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                                    </a>
                                                    <form action="{{ route('admin.sales-packages.destroy', $package->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this package?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
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
@endsection
