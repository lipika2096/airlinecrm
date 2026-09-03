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
                        <label class="form-label">Customer <span class="text-danger">*</span></label>
                        <select class="form-control" name="customer_id">
                            <option value="">Select Customer</option>
                            <option value="1">John Smith</option>
                            <option value="2">ADC Travels</option>
                            <option value="3">Maria Garcia</option>
                        </select>
                    </div>
                <div class="col-md-3">
                    <label class="form-label">Customer Type</label>
                    <select class="form-control" name="customer_type">
                        <option value="individual">Individual</option>
                        <option value="corporate">Corporate</option>
                        <option value="agent">Agent</option>
                    </select>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-4">
                    <label class="form-label">Customer Name</label>
                    <input type="text" class="form-control" name="customer_name">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="customer_email">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="customer_phone">
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="bookingTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="services-tab" data-bs-toggle="tab" href="#services" role="tab">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="passengers-tab" data-bs-toggle="tab" href="#passengers" role="tab">Passengers (2)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="payments-tab" data-bs-toggle="tab" href="#payments" role="tab">Payments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="documents-tab" data-bs-toggle="tab" href="#documents" role="tab">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="notes-tab" data-bs-toggle="tab" href="#notes" role="tab">Notes</a>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <!-- Services Tab -->
                <div class="tab-pane fade show active" id="services" role="tabpanel">
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
                            <strong>€ <span id="totalCost">1,115.00</span></strong>
                        </div>
                        <div class="summary-item">
                            <span>Total Sell:</span>
                            <strong>€ <span id="totalSell">1,590.00</span></strong>
                        </div>
                        <div class="summary-item profit">
                            <span>Profit:</span>
                            <strong>€ <span id="totalProfit">475.00</span></strong>
                        </div>
                    </div>
                </div>

                <!-- Passengers Tab -->
                <div class="tab-pane fade" id="passengers" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Passport No</th>
                                    <th>Nationality</th>
                                    <th>Date of Birth</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" name="passenger_name[]" placeholder="Full Name">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="passport_no[]" placeholder="Passport Number">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="nationality[]" placeholder="Nationality">
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="dob[]">
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
                </div>

                <!-- Notes Tab -->
                <div class="tab-pane fade" id="notes" role="tabpanel">
                    <div class="form-group">
                        <label class="form-label">Booking Notes</label>
                        <textarea class="form-control" name="booking_notes" rows="5" placeholder="Add any notes or special instructions for this booking..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="btn-group-custom text-end">
                <button type="submit" class="btn btn-save">
                    <i class="fa fa-save"></i> Save
                </button>
                <button type="submit" class="btn btn-confirm">
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
                <input type="text" class="form-control" name="passenger_name[]" placeholder="Full Name">
            </td>
            <td>
                <input type="text" class="form-control" name="passport_no[]" placeholder="Passport Number">
            </td>
            <td>
                <input type="text" class="form-control" name="nationality[]" placeholder="Nationality">
            </td>
            <td>
                <input type="date" class="form-control" name="dob[]">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-passenger">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(newRow);
    });

    // Remove Passenger Row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-passenger')) {
            e.target.closest('tr').remove();
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
</script>

@endsection
