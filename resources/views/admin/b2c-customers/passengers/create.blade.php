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
                                
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Passenger Type</label>
                                        <select class="form-control" name="passenger_type" required>
                                            <option value="">Select Type</option>
                                            <option value="adult">Adult</option>
                                            <option value="child">Child</option>
                                            <option value="infant">Infant</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Title</label>
                                        <select class="form-control" name="title">
                                            <option value="">Select</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Dr">Dr</option>
                                            <option value="Master">Master</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">First Name</label>
                                        <input class="form-control" name="first_name" type="text" required placeholder="Enter First Name">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Last Name</label>
                                        <input class="form-control" name="last_name" type="text" required placeholder="Enter Last Name">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input class="form-control" name="date_of_birth" type="date" required>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Passport Number</label>
                                        <input class="form-control" name="passport_number" type="text" placeholder="Enter Passport Number">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Nationality</label>
                                        <input class="form-control" name="nationality" type="text" placeholder="Enter Nationality">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Frequent Flyer Number</label>
                                        <input class="form-control" name="frequent_flyer_number" type="text" placeholder="Enter Frequent Flyer Number">
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