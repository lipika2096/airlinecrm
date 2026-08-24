@extends('admin/layouts/head-main')
@section('content')
    <title>Create Sales Package</title>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Sales Packages</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.sales-packages.index') }}">Sales Packages</a></li>
                            <li class="breadcrumb-item active">Create Package</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Create Sales Package</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.sales-packages.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Package Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="package_name" required placeholder="Enter Package Name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Rate <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control" name="rate" required placeholder="Enter Rate">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Monthly Rate</label>
                                        <input type="number" step="0.01" class="form-control" name="monthly_rate" placeholder="Enter Monthly Rate">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Annual Rate</label>
                                        <input type="number" step="0.01" class="form-control" name="annual_rate" placeholder="Enter Annual Rate">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Modules (Permissions) <span class="text-danger">*</span></label>
                                        <div class="border p-3 rounded" style="max-height: 300px; overflow-y: auto;">
                                            @foreach($permissions as $permission)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="modules[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}">
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <small class="text-muted">Select at least one module</small>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" rows="4" placeholder="Enter Package Description"></textarea>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Create Package</button>
                                    <a href="{{ route('admin.sales-packages.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
