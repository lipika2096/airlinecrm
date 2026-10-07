@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <title>Add Passenger</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .submit-section {
                margin-top: 10px !important;
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
            .btn-secondary {
                border-radius: 8px;
                padding: 12px 24px;
                font-weight: 500;
            }
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            }
            .card-body {
                padding: 24px;
            }
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
            .form-label {
                font-weight: 500;
                color: #495057;
                margin-bottom: 8px;
            }
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
            .invalid-feedback {
                display: block;
                color: #dc3545;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }
            .is-invalid {
                border-color: #dc3545 !important;
            }
            .is-invalid:focus {
                border-color: #dc3545 !important;
                box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add Passenger</h3>
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.dashboard') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : route('staff.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.index') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.index') : route('staff.b2c-customers.index')) }}">B2C Customers</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.show', $customer->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.show', $customer->id) : route('staff.b2c-customers.show', $customer->id)) }}">{{ $customer->full_name }}</a></li>
                            <li class="breadcrumb-item active">Add Passenger</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.passengers.store', $customer->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.passengers.store', $customer->id) : route('staff.b2c-customers.passengers.store', $customer->id)) }}" method="POST">
                                @csrf

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Passenger Type</label>
                                        <select class="form-control @error('passenger_type') is-invalid @enderror" name="passenger_type" required>
                                            <option value="">Select Type</option>
                                            <option value="adult" {{ old('passenger_type') == 'adult' ? 'selected' : '' }}>Adult</option>
                                            <option value="child" {{ old('passenger_type') == 'child' ? 'selected' : '' }}>Child</option>
                                            <option value="infant" {{ old('passenger_type') == 'infant' ? 'selected' : '' }}>Infant</option>
                                        </select>
                                        @error('passenger_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Title</label>
                                        <select class="form-control @error('title') is-invalid @enderror" name="title">
                                            <option value="">Select</option>
                                            <option value="Mr" {{ old('title') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                            <option value="Mrs" {{ old('title') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                            <option value="Miss" {{ old('title') == 'Miss' ? 'selected' : '' }}>Miss</option>
                                            <option value="Dr" {{ old('title') == 'Dr' ? 'selected' : '' }}>Dr</option>
                                            <option value="Master" {{ old('title') == 'Master' ? 'selected' : '' }}>Master</option>
                                        </select>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">First Name</label>
                                        <input class="form-control @error('first_name') is-invalid @enderror" name="first_name" type="text" required placeholder="Enter First Name" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Last Name</label>
                                        <input class="form-control @error('last_name') is-invalid @enderror" name="last_name" type="text" required placeholder="Enter Last Name" value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" type="date" required value="{{ old('date_of_birth') }}">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Passport Number</label>
                                        <input class="form-control @error('passport_number') is-invalid @enderror" name="passport_number" type="text" placeholder="Enter Passport Number" value="{{ old('passport_number') }}">
                                        @error('passport_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Nationality</label>
                                        <input class="form-control @error('nationality') is-invalid @enderror" name="nationality" type="text" placeholder="Enter Nationality" value="{{ old('nationality') }}">
                                        @error('nationality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Frequent Flyer Number</label>
                                        <input class="form-control @error('frequent_flyer_number') is-invalid @enderror" name="frequent_flyer_number" type="text" placeholder="Enter Frequent Flyer Number" value="{{ old('frequent_flyer_number') }}">
                                        @error('frequent_flyer_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="submit-section mt-4">
                                    <button class="btn btn-primary" type="submit">Add Passenger</button>
                                    <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.show', $customer->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.show', $customer->id) : route('staff.b2c-customers.show', $customer->id)) }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection