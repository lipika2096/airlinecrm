@extends('admin/layouts/head-main')
@section('title', 'Booking / Reservation')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">
    <style>
        .booking-form-card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .booking-form-card h4 {
            color: #333;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #dee2e6;
        }
        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            border-bottom: 2px solid transparent;
            padding: 10px 20px;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            background: transparent;
        }
        .nav-tabs .nav-link:hover {
            color: #007bff;
            border-bottom: 2px solid #007bff;
        }
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        .summary-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .summary-item:last-child {
            margin-bottom: 0;
        }
        .summary-item strong {
            font-weight: 600;
        }
        .summary-item.profit strong {
            color: #28a745;
        }
        .btn-group-custom {
            margin-top: 20px;
        }
        .btn-save {
            background: #007bff;
            border-color: #007bff;
        }
        .btn-confirm {
            background: #28a745;
            border-color: #28a745;
        }
        .btn-invoice {
            background: #6c757d;
            border-color: #6c757d;
        }
        .btn-back {
            background: #6c757d;
            border-color: #6c757d;
        }
        .btn-next {
            background: #007bff;
            border-color: #007bff;
        }
        .btn-next:disabled {
            background: #ccc;
            border-color: #ccc;
            cursor: not-allowed;
        }
        .tab-save-btn {
            margin-top: 10px;
        }
        .booking-details-save {
            margin-top: 15px;
        }
    </style>

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Booking / Reservation</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.accounts.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.accounts.index') : route('admin.accounts.index')) }}">
                                Accounts
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Booking / Reservation</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Booking Form -->
        <form action="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.store') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.store') : route('admin.booking.store')) }}" method="POST">
            @csrf
            <div class="booking-form-card">
                <h4>Booking Details</h4>

                <div class="row form-group">
                    <div class="col-md-3">
                        <label class="form-label">Booking No <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="booking_no" value="{{ $bookingNo ?? 'BK000126' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Booking Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="booking_date" required>
                    </div>
                    
                <div class="col-md-3">
                    <label class="form-label">Customer Type</label>
                    <select class="form-control" name="customer_type">
                        <option value="b2b">B2B</option>
                        <option value="b2c">B2C</option>
                    </select>
                </div>
            </div>

            


            <!-- Customer Search Box -->
            <div class="row form-group mt-3">
                <div class="col-md-12">
                    <label class="form-label">Search Customer</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="customer-search" placeholder="Search by name, email, or phone...">
                        <button type="button" class="btn btn-primary" id="search-customer-btn">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                    <div id="search-results" class="mt-2" style="display: none;">
                        <div class="list-group">
                            <!-- Search results will be populated here -->
                        </div>
                    </div>
                    <input type="hidden" name="selected_customer_id" id="selected_customer_id" value="">
                    <input type="hidden" name="selected_customer_type" id="selected_customer_type" value="">
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="bookingTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="customer-tab" data-bs-toggle="tab" href="#customer" role="tab">Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="services-tab" data-bs-toggle="tab" href="#services" role="tab">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="passengers-tab" data-bs-toggle="tab" href="#passengers" role="tab">Passengers </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="documents-tab" data-bs-toggle="tab" href="#documents" role="tab">Documents</a>
                </li>                
                <li class="nav-item">
                    <a class="nav-link" id="invoice-tab" data-bs-toggle="tab" href="#invoice" role="tab">Invoice</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="payments-tab" data-bs-toggle="tab" href="#payments" role="tab">Payment Recieved</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="notes-tab" data-bs-toggle="tab" href="#notes" role="tab">Notes</a>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <!-- Customer Tab -->
                <div class="tab-pane fade show active" id="customer" role="tabpanel">
                    <!-- B2C Form -->
                    <div id="b2c-form" class="customer-form" style="display: none;">
                        <div class="booking-form-card">
                            <h4>B2C Customer Details</h4>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="b2c_first_name" id="b2c_first_name" placeholder="First Name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="b2c_last_name" id="b2c_last_name" placeholder="Last Name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="b2c_email" id="b2c_email" placeholder="Email">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="b2c_phone" id="b2c_phone" placeholder="Phone">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Street</label>
                                    <input type="text" class="form-control" name="b2c_street" id="b2c_street" placeholder="Street">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">House No.</label>
                                    <input type="text" class="form-control" name="b2c_house_no" id="b2c_house_no" placeholder="House No.">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="b2c_city" id="b2c_city" placeholder="City">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" class="form-control" name="b2c_pincode" id="b2c_pincode" placeholder="Pincode">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" name="b2c_state" id="b2c_state" placeholder="State">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-label">Country</label>
                                    <input type="text" class="form-control" name="b2c_country" id="b2c_country" placeholder="Country">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Language</label>
                                    <input type="text" class="form-control" name="b2c_language" id="b2c_language" placeholder="Language">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Responsible</label>
                                    <input type="text" class="form-control" name="b2c_responsible" id="b2c_responsible" placeholder="Responsible">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" name="b2c_remarks" id="b2c_remarks" rows="3" placeholder="Remarks"></textarea>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-save btn-sm tab-save-btn" data-tab="customer">
                                    <i class="fa fa-save"></i> Save Customer Details
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- B2B Form -->
                    <div id="b2b-form" class="customer-form" style="display: none;">
                        <div class="booking-form-card">
                            <h4>B2B Customer Details</h4>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-label">Company Group <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="b2b_group" id="b2b_group" placeholder="Company Group">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="b2b_company_name" id="b2b_company_name" placeholder="Company Name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="b2b_email" id="b2b_email" placeholder="Email">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="b2b_phone" id="b2b_phone" placeholder="Phone">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Street</label>
                                    <input type="text" class="form-control" name="b2b_street" id="b2b_street" placeholder="Street">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">House No.</label>
                                    <input type="text" class="form-control" name="b2b_house_no" id="b2b_house_no" placeholder="House No.">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="b2b_city" id="b2b_city" placeholder="City">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" class="form-control" name="b2b_pincode" id="b2b_pincode" placeholder="Pincode">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" name="b2b_state" id="b2b_state" placeholder="State">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-label">Country</label>
                                    <input type="text" class="form-control" name="b2b_country" id="b2b_country" placeholder="Country">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Language</label>
                                    <input type="text" class="form-control" name="b2b_language" id="b2b_language" placeholder="Language">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Responsible</label>
                                    <input type="text" class="form-control" name="b2b_responsible" id="b2b_responsible" placeholder="Responsible">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" name="b2b_remarks" id="b2b_remarks" rows="3" placeholder="Remarks"></textarea>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-save btn-sm tab-save-btn" data-tab="customer">
                                    <i class="fa fa-save"></i> Save Customer Details
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- No form selected message -->
                    <div id="no-customer-form" class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Please select a Customer Type (B2B or B2C) in the Booking Details section above to view the customer form.
                    </div>
                </div>

                <!-- Services Tab -->
                <div class="tab-pane fade" id="services" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Supplier</th>
                                    <th>Cost (EUR)</th>
                                    <th>Sell (EUR)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control" name="service_type[]">
                                            <option value="flight">Flight</option>
                                            <option value="hotel">Hotel</option>
                                            <option value="insurance">Insurance</option>
                                            <option value="car">Car Rental</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="service_description[]" placeholder="Description">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="service_supplier[]" placeholder="Supplier">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="service_cost[]" placeholder="0.00" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="service_sell[]" placeholder="0.00" step="0.01">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-service">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mt-2" id="addService">
                        <i class="fa fa-plus"></i> Add Service
                    </button>

                    <!-- Summary Section -->
                    <div class="summary-section">
                        <div class="summary-item">
                            <span>Total Cost:</span>
                            <strong>€ <span id="totalCost">0</span></strong>
                        </div>
                        <div class="summary-item">
                            <span>Total Sell:</span>
                            <strong>€ <span id="totalSell">0</span></strong>
                        </div>
                        <div class="summary-item profit">
                            <span>Profit:</span>
                            <strong>€ <span id="totalProfit">0</span></strong>
                        </div>
                    </div>

                    <!-- Tab Save Button -->
                    <div class="mt-3">
                        <button type="button" class="btn btn-save btn-sm tab-save-btn" data-tab="services">
                            <i class="fa fa-save"></i> Save Services
                        </button>
                    </div>
                </div>

                <!-- Passengers Tab -->
                <div class="tab-pane fade" id="passengers" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Gender</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Date of Birth</th>
                                    <th>Nationality</th>
                                    <th>Passport No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control passenger-title" name="passenger_title[]">
                                            <option value="">Select Title</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Dr">Dr</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control passenger-gender" name="passenger_gender[]" placeholder="Gender" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="passenger_first_name[]" placeholder="First Name">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="passenger_last_name[]" placeholder="Last Name">
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="dob[]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="nationality[]" placeholder="Nationality">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="passport_no[]" placeholder="Passport Number">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-passenger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mt-2" id="addPassenger">
                        <i class="fa fa-plus"></i> Add Passenger
                    </button>

                    <!-- Tab Save Button -->
                    <div class="mt-3">
                        <button type="button" class="btn btn-save btn-sm tab-save-btn" data-tab="passengers">
                            <i class="fa fa-save"></i> Save Passengers
                        </button>
                    </div>
                </div>

                <!-- Payments Tab -->
                <div class="tab-pane fade" id="payments" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Payment Date</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="date" class="form-control" name="payment_date[]">
                                    </td>
                                    <td>
                                        <select class="form-control" name="payment_method[]">
                                            <option value="cash">Cash</option>
                                            <option value="card">Credit Card</option>
                                            <option value="bank">Bank Transfer</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="payment_amount[]" placeholder="0.00" step="0.01">
                                    </td>
                                    <td>
                                        <select class="form-control" name="payment_status[]">
                                            <option value="pending">Pending</option>
                                            <option value="paid">Paid</option>
                                            <option value="partial">Partial</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="payment_remarks[]" placeholder="Add remarks...">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-payment">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mt-2" id="addPayment">
                        <i class="fa fa-plus"></i> Add Payment
                    </button>

                    <!-- Tab Save Button -->
                    <div class="mt-3">
                        <button type="button" class="btn btn-save btn-sm tab-save-btn" data-tab="payments">
                            <i class="fa fa-save"></i> Save Payments
                        </button>
                    </div>
                </div>

                <!-- Documents Tab -->
                <div class="tab-pane fade" id="documents" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Document Name</th>
                                    <th>Upload</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control" name="document_type[]">
                                            <option value="ticket">Ticket</option>
                                            <option value="invoice">Invoice</option>
                                            <option value="passport">Passport Copy</option>
                                            <option value="visa">Visa</option>
                                            <option value="insurance">Insurance</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="document_name[]" placeholder="Document Name">
                                    </td>
                                    <td>
                                        <input type="file" class="form-control" name="document_file[]">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-document">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mt-2" id="addDocument">
                        <i class="fa fa-plus"></i> Add Document
                    </button>

                    <!-- Tab Save Button -->
                    <div class="mt-3">
                        <button type="button" class="btn btn-save btn-sm tab-save-btn" data-tab="documents">
                            <i class="fa fa-save"></i> Save Documents
                        </button>
                    </div>
                </div>

                <!-- Notes Tab -->
                <div class="tab-pane fade" id="notes" role="tabpanel">
                    <div class="form-group">
                        <label class="form-label">Booking Notes</label>
                        <textarea class="form-control" name="booking_notes" rows="5" placeholder="Add any notes or special instructions for this booking..."></textarea>
                    </div>

                    <!-- Tab Save Button -->
                    <div class="mt-3">
                        <button type="button" class="btn btn-save btn-sm tab-save-btn" data-tab="notes">
                            <i class="fa fa-save"></i> Save Notes
                        </button>
                    </div>
                </div>

                <!-- Invoice Tab -->
                <div class="tab-pane fade" id="invoice" role="tabpanel">
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" name="invoice_number" placeholder="INV-000001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Invoice Date</label>
                            <input type="date" class="form-control" name="invoice_date">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="form-label">Due Date</label>
                            <input type="date" class="form-control" name="invoice_due_date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tax Rate (%)</label>
                            <input type="number" class="form-control" name="invoice_tax_rate" placeholder="0" step="0.01">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="form-label">Invoice Notes</label>
                            <textarea class="form-control" name="invoice_notes" rows="3" placeholder="Additional invoice notes or terms..."></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="form-label">Billing Address</label>
                            <textarea class="form-control" name="billing_address" rows="3" placeholder="Enter billing address..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Shipping Address</label>
                            <textarea class="form-control" name="shipping_address" rows="3" placeholder="Enter shipping address..."></textarea>
                        </div>
                    </div>

                    <!-- Tab Save Button -->
                    <div class="mt-3">
                        <button type="button" class="btn btn-save btn-sm tab-save-btn" data-tab="invoice">
                            <i class="fa fa-save"></i> Save Invoice
                        </button>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="btn-group-custom text-end">
                <button type="button" class="btn btn-back" id="backBtn">
                    <i class="fa fa-arrow-left"></i> Back
                </button>
                <button type="button" class="btn btn-next" id="nextBtn">
                    Next <i class="fa fa-arrow-right"></i>
                </button>
                <button type="submit" class="btn btn-confirm" id="confirmBookingBtn" style="display: none;">
                    <i class="fa fa-check"></i> Confirm Booking
                </button>
                <button type="submit" class="btn btn-invoice" name="generate_invoice" value="1">
                    <i class="fa fa-file-invoice"></i> Generate Invoice
                </button>
            </div>
        </div>
        </form>

    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->

<script>
    // Customer Type Change Handler
    document.querySelector('select[name="customer_type"]').addEventListener('change', function() {
        const customerType = this.value;
        const b2cForm = document.getElementById('b2c-form');
        const b2bForm = document.getElementById('b2b-form');
        const noFormMessage = document.getElementById('no-customer-form');

        // Hide all forms initially
        b2cForm.style.display = 'none';
        b2bForm.style.display = 'none';
        noFormMessage.style.display = 'none';

        // Show appropriate form based on customer type
        if (customerType === 'b2c') {
            b2cForm.style.display = 'block';
        } else if (customerType === 'b2b') {
            b2bForm.style.display = 'block';
        } else {
            noFormMessage.style.display = 'block';
        }
    });

    // Customer Search Functionality
    document.getElementById('search-customer-btn').addEventListener('click', function() {
        const searchTerm = document.getElementById('customer-search').value.trim();
        const customerType = document.querySelector('select[name="customer_type"]').value;
        const searchResults = document.getElementById('search-results');
        const resultsList = searchResults.querySelector('.list-group');

        if (!searchTerm) {
            alert('Please enter a search term');
            return;
        }

        // Show loading state
        this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Searching...';
        this.disabled = true;

        // AJAX request to search customers based on type
        let searchUrl;
        if (customerType === 'b2b') {
            @if(\App\Helpers\RouteHelper::isCustomer())
                searchUrl = `{{ route('customer.b2b-partners.search') }}?q=${encodeURIComponent(searchTerm)}`;
            @elseif(\App\Helpers\RouteHelper::isStaff())
                searchUrl = `{{ route('staff.b2b-partners.search') }}?q=${encodeURIComponent(searchTerm)}`;
            @else
                searchUrl = `{{ route('admin.b2b-partners.search') }}?q=${encodeURIComponent(searchTerm)}`;
            @endif
        } else {
            @if(\App\Helpers\RouteHelper::isCustomer())
                searchUrl = `{{ route('customer.b2c-customers.search') }}?q=${encodeURIComponent(searchTerm)}`;
            @elseif(\App\Helpers\RouteHelper::isStaff())
                searchUrl = `{{ route('staff.b2c-customers.search') }}?q=${encodeURIComponent(searchTerm)}`;
            @else
                searchUrl = `{{ route('admin.b2c-customers.search') }}?q=${encodeURIComponent(searchTerm)}`;
            @endif
        }

        fetch(searchUrl)
            .then(response => response.json())
            .then(data => {
                // Clear previous results
                resultsList.innerHTML = '';

                if (data.length === 0) {
                    resultsList.innerHTML = '<div class="list-group-item text-muted">No customers found</div>';
                } else {
                    data.forEach(customer => {
                        const displayName = customerType === 'b2b' 
                            ? customer.partner_name || customer.name 
                            : (customer.first_name + ' ' + customer.last_name);

                        const item = document.createElement('a');
                        item.className = 'list-group-item list-group-item-action';
                        item.href = '#';
                        item.innerHTML = `
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">${displayName}</h6>
                                <small class="text-muted">${customerType.toUpperCase()}</small>
                            </div>
                            <p class="mb-1">${customer.email}</p>
                            <small>${customer.phone || 'No phone'}</small>
                        `;
                        item.addEventListener('click', function(e) {
                            e.preventDefault();
                            autofillCustomerForm(customer, customerType);
                            searchResults.style.display = 'none';
                        });
                        resultsList.appendChild(item);
                    });
                }

                searchResults.style.display = 'block';
            })
            .catch(error => {
                console.error('Error searching customers:', error);
                resultsList.innerHTML = '<div class="list-group-item text-danger">Error searching customers. Please try again.</div>';
                searchResults.style.display = 'block';
            })
            .finally(() => {
                this.innerHTML = '<i class="fa fa-search"></i> Search';
                this.disabled = false;
            });
    });

    // Auto-fill customer form based on search result
    function autofillCustomerForm(customer, customerType) {
        // Set customer type dropdown
        const customerTypeSelect = document.querySelector('select[name="customer_type"]');
        customerTypeSelect.value = customerType;
        customerTypeSelect.dispatchEvent(new Event('change'));

        // Set hidden fields for selected customer
        document.getElementById('selected_customer_id').value = customer.id;
        document.getElementById('selected_customer_type').value = customerType;

        // Set customer in the customer dropdown
        const customerSelect = document.querySelector('select[name="customer_id"]');
        if (customerSelect) {
            // Check if customer exists in dropdown, if not add it
            let optionExists = false;
            for (let option of customerSelect.options) {
                if (option.value == customer.id) {
                    optionExists = true;
                    break;
                }
            }
            
            if (!optionExists) {
                const newOption = document.createElement('option');
                newOption.value = customer.id;
                newOption.textContent = customerType === 'b2b' ? customer.partner_name : (customer.first_name + ' ' + customer.last_name);
                customerSelect.appendChild(newOption);
            }
            customerSelect.value = customer.id;
        }

        // Fill the appropriate form based on customer type
        if (customerType === 'b2c') {
            document.getElementById('b2c_first_name').value = customer.first_name || '';
            document.getElementById('b2c_last_name').value = customer.last_name || '';
            document.getElementById('b2c_email').value = customer.email || '';
            document.getElementById('b2c_phone').value = customer.phone || '';
            document.getElementById('b2c_street').value = customer.address ? customer.address.split(',')[0] : '';
            document.getElementById('b2c_house_no').value = '';
            document.getElementById('b2c_city').value = '';
            document.getElementById('b2c_pincode').value = '';
            document.getElementById('b2c_state').value = '';
            document.getElementById('b2c_country').value = customer.country || '';
            document.getElementById('b2c_language').value = '';
            document.getElementById('b2c_responsible').value = '';
            document.getElementById('b2c_remarks').value = customer.special_requests || '';
        } else if (customerType === 'b2b') {
            document.getElementById('b2b_group').value = customer.partner_type || '';
            document.getElementById('b2b_company_name').value = customer.partner_name || '';
            document.getElementById('b2b_email').value = customer.email || '';
            document.getElementById('b2b_phone').value = customer.phone || '';
            document.getElementById('b2b_street').value = '';
            document.getElementById('b2b_house_no').value = '';
            document.getElementById('b2b_city').value = '';
            document.getElementById('b2b_pincode').value = '';
            document.getElementById('b2b_state').value = '';
            document.getElementById('b2b_country').value = customer.country || '';
            document.getElementById('b2b_language').value = '';
            document.getElementById('b2b_responsible').value = customer.responsible_person || '';
            document.getElementById('b2b_remarks').value = customer.remarks || '';
        }

        // Also fill the quick customer details in booking details
        const customerNameInput = document.querySelector('input[name="customer_name"]');
        const customerEmailInput = document.querySelector('input[name="customer_email"]');
        const customerPhoneInput = document.querySelector('input[name="customer_phone"]');

        if (customerNameInput) {
            customerNameInput.value = customerType === 'b2b' ? customer.partner_name : (customer.first_name + ' ' + customer.last_name);
        }
        if (customerEmailInput) {
            customerEmailInput.value = customer.email || '';
        }
        if (customerPhoneInput) {
            customerPhoneInput.value = customer.phone || '';
        }

        // Switch to Customer tab to show the filled form
        const customerTab = document.getElementById('customer-tab');
        customerTab.click();
    }

    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        const searchContainer = document.querySelector('.input-group');
        const searchResults = document.getElementById('search-results');
        if (!searchContainer.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

    // Initialize customer form visibility on page load
    document.addEventListener('DOMContentLoaded', function() {
        const customerType = document.querySelector('select[name="customer_type"]').value;
        const b2cForm = document.getElementById('b2c-form');
        const b2bForm = document.getElementById('b2b-form');
        const noFormMessage = document.getElementById('no-customer-form');

        // Hide all forms initially
        b2cForm.style.display = 'none';
        b2bForm.style.display = 'none';
        noFormMessage.style.display = 'none';

        // Show appropriate form based on initial customer type
        if (customerType === 'b2c') {
            b2cForm.style.display = 'block';
        } else if (customerType === 'b2b') {
            b2bForm.style.display = 'block';
        } else {
            noFormMessage.style.display = 'block';
        }
    });

    // Add Service Row
    document.getElementById('addService').addEventListener('click', function() {
        const tbody = document.querySelector('#services tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select class="form-control" name="service_type[]">
                    <option value="flight">Flight</option>
                    <option value="hotel">Hotel</option>
                    <option value="insurance">Insurance</option>
                    <option value="car">Car Rental</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" name="service_description[]" placeholder="Description">
            </td>
            <td>
                <input type="text" class="form-control" name="service_supplier[]" placeholder="Supplier">
            </td>
            <td>
                <input type="number" class="form-control" name="service_cost[]" placeholder="0.00" step="0.01">
            </td>
            <td>
                <input type="number" class="form-control" name="service_sell[]" placeholder="0.00" step="0.01">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-service">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(newRow);
    });

    // Remove Service Row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-service')) {
            e.target.closest('tr').remove();
            calculateTotals();
        }
    });

    // Add Passenger Row
    document.getElementById('addPassenger').addEventListener('click', function() {
        const tbody = document.querySelector('#passengers tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select class="form-control passenger-title" name="passenger_title[]">
                    <option value="">Select Title</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                    <option value="Ms">Ms</option>
                    <option value="Dr">Dr</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control passenger-gender" name="passenger_gender[]" placeholder="Gender" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="passenger_first_name[]" placeholder="First Name">
            </td>
            <td>
                <input type="text" class="form-control" name="passenger_last_name[]" placeholder="Last Name">
            </td>
            <td>
                <input type="date" class="form-control" name="dob[]">
            </td>
            <td>
                <input type="text" class="form-control" name="nationality[]" placeholder="Nationality">
            </td>
            <td>
                <input type="text" class="form-control" name="passport_no[]" placeholder="Passport Number">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-passenger">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(newRow);
        updatePassengerCount();
    });

    // Remove Passenger Row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-passenger')) {
            e.target.closest('tr').remove();
            updatePassengerCount();
        }
    });

    // Update passenger count
    function updatePassengerCount() {
        const passengerRows = document.querySelectorAll('#passengers tbody tr');
        const countElement = document.getElementById('passengerCount');
        if (countElement) {
            countElement.textContent = `(${passengerRows.length})`;
        }
    }

    // Auto-fill gender based on title selection
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('passenger-title')) {
            const title = e.target.value;
            const genderInput = e.target.closest('tr').querySelector('.passenger-gender');

            // Set gender based on title
            if (title === 'Mr') {
                genderInput.value = 'Male';
            } else if (title === 'Mrs' || title === 'Miss' || title === 'Ms') {
                genderInput.value = 'Female';
            } else if (title === 'Dr') {
                genderInput.value = ''; // Dr can be any gender, leave blank
            } else {
                genderInput.value = ''; // No title selected, clear gender
            }
        }
    });

    // Add Payment Row
    document.getElementById('addPayment').addEventListener('click', function() {
        const tbody = document.querySelector('#payments tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <input type="date" class="form-control" name="payment_date[]">
            </td>
            <td>
                <select class="form-control" name="payment_method[]">
                    <option value="cash">Cash</option>
                    <option value="card">Credit Card</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="cheque">Cheque</option>
                </select>
            </td>
            <td>
                <input type="number" class="form-control" name="payment_amount[]" placeholder="0.00" step="0.01">
            </td>
            <td>
                <select class="form-control" name="payment_status[]">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="partial">Partial</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" name="payment_remarks[]" placeholder="Add remarks...">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-payment">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(newRow);
    });

    // Remove Payment Row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-payment')) {
            e.target.closest('tr').remove();
        }
    });

    // Add Document Row
    document.getElementById('addDocument').addEventListener('click', function() {
        const tbody = document.querySelector('#documents tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select class="form-control" name="document_type[]">
                    <option value="ticket">Ticket</option>
                    <option value="invoice">Invoice</option>
                    <option value="passport">Passport Copy</option>
                    <option value="visa">Visa</option>
                    <option value="insurance">Insurance</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" name="document_name[]" placeholder="Document Name">
            </td>
            <td>
                <input type="file" class="form-control" name="document_file[]">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-document">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(newRow);
    });

    // Remove Document Row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-document')) {
            e.target.closest('tr').remove();
        }
    });

    // Calculate Totals
    function calculateTotals() {
        const costs = document.querySelectorAll('input[name="service_cost[]"]');
        const sells = document.querySelectorAll('input[name="service_sell[]"]');
        
        let totalCost = 0;
        let totalSell = 0;
        
        costs.forEach(input => {
            totalCost += parseFloat(input.value) || 0;
        });
        
        sells.forEach(input => {
            totalSell += parseFloat(input.value) || 0;
        });
        
        const profit = totalSell - totalCost;
        
        document.getElementById('totalCost').textContent = totalCost.toFixed(2);
        document.getElementById('totalSell').textContent = totalSell.toFixed(2);
        document.getElementById('totalProfit').textContent = profit.toFixed(2);
    }

    // Listen for changes in cost and sell inputs
    document.addEventListener('input', function(e) {
        if (e.target.name === 'service_cost[]' || e.target.name === 'service_sell[]') {
            calculateTotals();
        }
    });

    // Tab Navigation Logic
    const tabs = document.querySelectorAll('#bookingTabs .nav-link');
    const tabContents = document.querySelectorAll('.tab-pane');
    const backBtn = document.getElementById('backBtn');
    const nextBtn = document.getElementById('nextBtn');
    const confirmBookingBtn = document.getElementById('confirmBookingBtn');
    let currentTab = 0;

    function updateTabButtons() {
        // Disable back button on first tab
        backBtn.disabled = currentTab === 0;

        // Show confirm booking button and hide next button on last tab
        if (currentTab === tabs.length - 1) {
            nextBtn.style.display = 'none';
            confirmBookingBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            confirmBookingBtn.style.display = 'none';
        }
    }

    function switchTab(index) {
        // Remove active class from all tabs and contents
        tabs.forEach(tab => tab.classList.remove('active'));
        tabContents.forEach(content => {
            content.classList.remove('show', 'active');
        });

        // Add active class to current tab and content
        tabs[index].classList.add('active');
        tabContents[index].classList.add('show', 'active');

        currentTab = index;
        updateTabButtons();
    }

    // Back button click handler
    backBtn.addEventListener('click', function() {
        if (currentTab > 0) {
            switchTab(currentTab - 1);
        }
    });

    // Next button click handler
    nextBtn.addEventListener('click', function() {
        if (currentTab < tabs.length - 1) {
            switchTab(currentTab + 1);
        }
    });

    // Initialize tab buttons
    updateTabButtons();

    // Initialize passenger count
    updatePassengerCount();

    // Auto-save functionality
    let autoSaveTimeout;
    const form = document.querySelector('form');

    function autoSave() {
        // Collect form data
        const formData = new FormData(form);
        const formDataObj = {};
        formData.forEach((value, key) => {
            if (formDataObj[key]) {
                if (!Array.isArray(formDataObj[key])) {
                    formDataObj[key] = [formDataObj[key]];
                }
                formDataObj[key].push(value);
            } else {
                formDataObj[key] = value;
            }
        });

        // Handle migration: if old passenger_name exists, convert to passenger_first_name
        if (formDataObj['passenger_name[]'] && !formDataObj['passenger_first_name[]']) {
            formDataObj['passenger_first_name[]'] = formDataObj['passenger_name[]'];
            delete formDataObj['passenger_name[]'];
        }

        // Save to localStorage
        localStorage.setItem('bookingFormData', JSON.stringify(formDataObj));

        // Optional: Show auto-save indicator
        console.log('Auto-saved at:', new Date().toLocaleTimeString());
    }

    // Listen for form changes and trigger auto-save
    form.addEventListener('input', function(e) {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(autoSave, 20000); // Auto-save after 20 second of inactivity
    });

    form.addEventListener('change', function(e) {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(autoSave, 20000);
    });

    // Load saved data on page load
    window.addEventListener('load', function() {
        const savedData = localStorage.getItem('bookingFormData');
        if (savedData) {
            try {
                const formDataObj = JSON.parse(savedData);

                // Handle migration from old passenger_name to new first_name/last_name
                if (formDataObj['passenger_name'] && !formDataObj['passenger_first_name']) {
                    formDataObj['passenger_first_name'] = formDataObj['passenger_name'];
                    delete formDataObj['passenger_name'];
                }

                Object.keys(formDataObj).forEach(key => {
                    const values = Array.isArray(formDataObj[key]) ? formDataObj[key] : [formDataObj[key]];
                    const inputs = document.querySelectorAll(`[name="${key}"]`);
                    inputs.forEach((input, index) => {
                        if (values[index] !== undefined) {
                            if (input.type === 'checkbox' || input.type === 'radio') {
                                input.checked = values[index];
                            } else {
                                input.value = values[index];
                            }
                        }
                    });
                });

                // Trigger gender auto-fill for loaded title values
                document.querySelectorAll('.passenger-title').forEach(titleSelect => {
                    if (titleSelect.value) {
                        // Trigger change event to auto-fill gender
                        titleSelect.dispatchEvent(new Event('change'));
                    }
                });

                console.log('Loaded saved form data');
            } catch (e) {
                console.error('Error loading saved data:', e);
            }
        }
    });

    // Clear saved data on form submission
    form.addEventListener('submit', function() {
        localStorage.removeItem('bookingFormData');
    });

    // Tab-specific save buttons
    document.querySelectorAll('.tab-save-btn').forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');

            // Trigger auto-save
            autoSave();

            // Show save confirmation
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fa fa-check"></i> Saved!';
            this.classList.remove('btn-save');
            this.classList.add('btn-success');

            setTimeout(() => {
                this.innerHTML = originalText;
                this.classList.remove('btn-success');
                this.classList.add('btn-save');
            }, 2000);

            console.log(`Saved data for ${tabName} tab at:`, new Date().toLocaleTimeString());
        });
    });
</script>

@endsection
