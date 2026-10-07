@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <title>Add B2C Customer</title>

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
            .card-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid #e9ecef;
                padding: 16px 24px;
                border-radius: 12px 12px 0 0;
            }
            .nav-tabs .nav-link {
                border: none;
                color: #6c757d;
                font-weight: 500;
                padding: 12px 20px;
                transition: all 0.3s ease;
            }
            .nav-tabs .nav-link.active {
                background-color: #ff9b44;
                color: white;
                border-radius: 8px 8px 0 0;
            }
            .nav-tabs .nav-link:hover:not(.active) {
                color: #ff9b44;
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
                        <h3 class="page-title">Add B2C Customer</h3>
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.dashboard') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : route('staff.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.index') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.index') : route('staff.b2c-customers.index')) }}">B2C Customers</a></li>
                            <li class="breadcrumb-item active">Add Customer</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.store') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.store') : route('staff.b2c-customers.store')) }}" method="POST">
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

                                <!-- Tabs -->
                                <ul class="nav nav-tabs mb-4" id="customerTabs" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" id="customer-details-tab" data-bs-toggle="tab" data-bs-target="#customer-details" type="button" role="tab">Customer Details</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="travel-preferences-tab" data-bs-toggle="tab" data-bs-target="#travel-preferences" type="button" role="tab">Travel Preferences</button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content" id="customerTabsContent">
                                    <!-- Customer Details Tab -->
                                    <div class="tab-pane fade show active" id="customer-details" role="tabpanel">
                                        <div class="row">
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Customer Type</label>
                                                <select class="form-control @error('customer_type') is-invalid @enderror" name="customer_type" required>
                                                    <option value="">Select Type</option>
                                                    <option value="individual" {{ old('customer_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                                                    <option value="corporate" {{ old('customer_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                                </select>
                                                @error('customer_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Salutation</label>
                                                <select class="form-control @error('salutation') is-invalid @enderror" name="salutation">
                                                    <option value="">Select</option>
                                                    <option value="Mr" {{ old('salutation') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                                    <option value="Mrs" {{ old('salutation') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                                    <option value="Miss" {{ old('salutation') == 'Miss' ? 'selected' : '' }}>Miss</option>
                                                    <option value="Dr" {{ old('salutation') == 'Dr' ? 'selected' : '' }}>Dr</option>
                                                </select>
                                                @error('salutation')
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
                                                <label class="form-label">Email</label>
                                                <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" required placeholder="Enter Email" value="{{ old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Phone</label>
                                                <input class="form-control @error('phone') is-invalid @enderror" name="phone" type="text" required placeholder="Enter Phone Number" value="{{ old('phone') }}">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" placeholder="Enter Address">{{ old('address') }}</textarea>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Country</label>
                                                <input class="form-control @error('country') is-invalid @enderror" name="country" type="text" placeholder="Enter Country" value="{{ old('country') }}">
                                                @error('country')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Status</label>
                                                <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Travel Preferences Tab -->
                                    <div class="tab-pane fade" id="travel-preferences" role="tabpanel">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label class="form-label">Preferred Airline</label>
                                                <input class="form-control @error('preferred_airline') is-invalid @enderror" name="preferred_airline" type="text" placeholder="Enter Preferred Airline" value="{{ old('preferred_airline') }}">
                                                @error('preferred_airline')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="form-label">Preferred Class</label>
                                                <select class="form-control @error('preferred_class') is-invalid @enderror" name="preferred_class">
                                                    <option value="">Select Class</option>
                                                    <option value="Economy" {{ old('preferred_class') == 'Economy' ? 'selected' : '' }}>Economy</option>
                                                    <option value="Business" {{ old('preferred_class') == 'Business' ? 'selected' : '' }}>Business</option>
                                                    <option value="First Class" {{ old('preferred_class') == 'First Class' ? 'selected' : '' }}>First Class</option>
                                                </select>
                                                @error('preferred_class')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="form-label">Meal Preference</label>
                                                <select class="form-control @error('meal_preference') is-invalid @enderror" name="meal_preference">
                                                    <option value="">Select Preference</option>
                                                    <option value="Standard" {{ old('meal_preference') == 'Standard' ? 'selected' : '' }}>Standard</option>
                                                    <option value="Vegetarian" {{ old('meal_preference') == 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                                                    <option value="Vegan" {{ old('meal_preference') == 'Vegan' ? 'selected' : '' }}>Vegan</option>
                                                    <option value="Kosher" {{ old('meal_preference') == 'Kosher' ? 'selected' : '' }}>Kosher</option>
                                                    <option value="Halal" {{ old('meal_preference') == 'Halal' ? 'selected' : '' }}>Halal</option>
                                                </select>
                                                @error('meal_preference')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="form-label">Seat Preference</label>
                                                <select class="form-control @error('seat_preference') is-invalid @enderror" name="seat_preference">
                                                    <option value="">Select Preference</option>
                                                    <option value="Window" {{ old('seat_preference') == 'Window' ? 'selected' : '' }}>Window</option>
                                                    <option value="Aisle" {{ old('seat_preference') == 'Aisle' ? 'selected' : '' }}>Aisle</option>
                                                    <option value="Middle" {{ old('seat_preference') == 'Middle' ? 'selected' : '' }}>Middle</option>
                                                </select>
                                                @error('seat_preference')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-8">
                                                <label class="form-label">Special Requests</label>
                                                <textarea class="form-control @error('special_requests') is-invalid @enderror" name="special_requests" rows="3" placeholder="Enter any special requests">{{ old('special_requests') }}</textarea>
                                                @error('special_requests')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="submit-section mt-4">
                                    <button class="btn btn-primary" type="submit">Create Customer</button>
                                    <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.index') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.index') : route('staff.b2c-customers.index')) }}" class="btn btn-secondary">Cancel</a>
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