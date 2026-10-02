@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <title>Edit B2C Customer</title>

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
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit B2C Customer</h3>
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.dashboard') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : route('staff.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.index') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.index') : route('staff.b2c-customers.index')) }}">B2C Customers</a></li>
                            <li class="breadcrumb-item active">Edit Customer</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.update', $customer->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.update', $customer->id) : route('staff.b2c-customers.update', $customer->id)) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
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
                                                <select class="form-control" name="customer_type" required>
                                                    <option value="">Select Type</option>
                                                    <option value="individual" {{ $customer->customer_type == 'individual' ? 'selected' : '' }}>Individual</option>
                                                    <option value="corporate" {{ $customer->customer_type == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Salutation</label>
                                                <select class="form-control" name="salutation">
                                                    <option value="">Select</option>
                                                    <option value="Mr" {{ $customer->salutation == 'Mr' ? 'selected' : '' }}>Mr</option>
                                                    <option value="Mrs" {{ $customer->salutation == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                                    <option value="Miss" {{ $customer->salutation == 'Miss' ? 'selected' : '' }}>Miss</option>
                                                    <option value="Dr" {{ $customer->salutation == 'Dr' ? 'selected' : '' }}>Dr</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">First Name</label>
                                                <input class="form-control" name="first_name" type="text" required value="{{ $customer->first_name }}" placeholder="Enter First Name">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Last Name</label>
                                                <input class="form-control" name="last_name" type="text" required value="{{ $customer->last_name }}" placeholder="Enter Last Name">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Email</label>
                                                <input class="form-control" name="email" type="email" required value="{{ $customer->email }}" placeholder="Enter Email">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Phone</label>
                                                <input class="form-control" name="phone" type="text" required value="{{ $customer->phone }}" placeholder="Enter Phone Number">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" name="address" rows="3" placeholder="Enter Address">{{ $customer->address }}</textarea>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Country</label>
                                                <input class="form-control" name="country" type="text" value="{{ $customer->country }}" placeholder="Enter Country">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="form-label">Status</label>
                                                <select class="form-control" name="status" required>
                                                    <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    <option value="blocked" {{ $customer->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Travel Preferences Tab -->
                                    <div class="tab-pane fade" id="travel-preferences" role="tabpanel">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label class="form-label">Preferred Airline</label>
                                                <input class="form-control" name="preferred_airline" type="text" value="{{ $customer->preferred_airline }}" placeholder="Enter Preferred Airline">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="form-label">Preferred Class</label>
                                                <select class="form-control" name="preferred_class">
                                                    <option value="">Select Class</option>
                                                    <option value="Economy" {{ $customer->preferred_class == 'Economy' ? 'selected' : '' }}>Economy</option>
                                                    <option value="Business" {{ $customer->preferred_class == 'Business' ? 'selected' : '' }}>Business</option>
                                                    <option value="First Class" {{ $customer->preferred_class == 'First Class' ? 'selected' : '' }}>First Class</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="form-label">Meal Preference</label>
                                                <select class="form-control" name="meal_preference">
                                                    <option value="">Select Preference</option>
                                                    <option value="Standard" {{ $customer->meal_preference == 'Standard' ? 'selected' : '' }}>Standard</option>
                                                    <option value="Vegetarian" {{ $customer->meal_preference == 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                                                    <option value="Vegan" {{ $customer->meal_preference == 'Vegan' ? 'selected' : '' }}>Vegan</option>
                                                    <option value="Kosher" {{ $customer->meal_preference == 'Kosher' ? 'selected' : '' }}>Kosher</option>
                                                    <option value="Halal" {{ $customer->meal_preference == 'Halal' ? 'selected' : '' }}>Halal</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="form-label">Seat Preference</label>
                                                <select class="form-control" name="seat_preference">
                                                    <option value="">Select Preference</option>
                                                    <option value="Window" {{ $customer->seat_preference == 'Window' ? 'selected' : '' }}>Window</option>
                                                    <option value="Aisle" {{ $customer->seat_preference == 'Aisle' ? 'selected' : '' }}>Aisle</option>
                                                    <option value="Middle" {{ $customer->seat_preference == 'Middle' ? 'selected' : '' }}>Middle</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-8">
                                                <label class="form-label">Special Requests</label>
                                                <textarea class="form-control" name="special_requests" rows="3" placeholder="Enter any special requests">{{ $customer->special_requests }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="submit-section mt-4">
                                    <button class="btn btn-primary" type="submit">Update Customer</button>
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