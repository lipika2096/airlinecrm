@extends('admin/layouts/head-main')
@section('content')
    <title>Edit Supplier</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .form-label {
                font-weight: 500;
                color: #495057;
            }
            .status-badge {
                display: inline-flex;
                align-items: center;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
            }
            .status-active {
                background-color: #d4edda;
                color: #155724;
            }
            .status-inactive {
                background-color: #f8d7da;
                color: #721c24;
            }
            .status-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                margin-right: 6px;
            }
            .status-active .status-dot {
                background-color: #28a745;
            }
            .status-inactive .status-dot {
                background-color: #dc3545;
            }
            .info-icon {
                font-size: 20px;
                color: #6c757d;
                margin-right: 10px;
            }
            .info-label {
                color: #6c757d;
                font-size: 13px;
                font-weight: 500;
            }
            .info-value {
                color: #212529;
                font-size: 14px;
                font-weight: 500;
            }
            .info-card {
                background: #f8f9fa;
                border-radius: 8px;
                padding: 15px;
                margin-bottom: 15px;
            }
            .supplier-logo {
                width: 80px;
                height: 80px;
                object-fit: contain;
                border-radius: 8px;
                background: white;
                border: 1px solid #dee2e6;
            }
            .nav-tabs .nav-link {
                color: #495057;
                font-weight: 500;
            }
            .nav-tabs .nav-link.active {
                color: #007bff;
                font-weight: 600;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">View and manage supplier details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.suppliers') }}">Suppliers</a></li>
                            <li class="breadcrumb-item active">Edit Supplier</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.suppliers.show', $supplier->id) }}" class="btn btn-primary">
                            <i class="fa fa-eye"></i> View
                        </a>
                        <a href="{{ route('admin.suppliers') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="supplierTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab">
                                            <i class="fa fa-info-circle"></i> General
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab">
                                            <i class="fa fa-address-book"></i> Contact Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-tab" data-bs-toggle="tab" href="#account" role="tab">
                                            <i class="fa fa-university"></i> Account Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="ledger-tab" data-bs-toggle="tab" href="#ledger" role="tab">
                                            <i class="fa fa-book"></i> Ledger
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content pt-4" id="supplierTabsContent">
                                    <!-- General Tab -->
                                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                                        <div class="row">
                                            <!-- Left Column - Logo and Description -->
                                            <div class="col-md-3">
                                                <div class="text-center mb-3">
                                                    @if($supplier->logo_path)
                                                        <img src="{{ asset($supplier->logo_path) }}" alt="{{ $supplier->name }}" class="supplier-logo mb-2">
                                                    @else
                                                        <div class="supplier-logo mb-2 d-flex align-items-center justify-content-center">
                                                            <i class="fa fa-building fa-2x text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <h5 class="mb-1">{{ $supplier->name }}</h5>
                                                    <span class="status-badge {{ $supplier->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                                        <span class="status-dot"></span>
                                                        {{ ucfirst($supplier->status) }}
                                                    </span>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3">{{ $supplier->description ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Middle Column - Information Grid -->
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="supplier_code" class="form-label">Supplier Code</label>
                                                            <input type="text" class="form-control" id="supplier_code" name="supplier_code"
                                                                value="{{ $supplier->supplier_code }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="website" class="form-label">Website</label>
                                                            <input type="text" class="form-control" id="website" name="website"
                                                                value="{{ $supplier->website ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="category" class="form-label">Category</label>
                                                            <select class="form-control" id="category" name="category" required>
                                                                <option value="Airline" {{ $supplier->category == 'Airline' ? 'selected' : '' }}>Airline</option>
                                                                <option value="Hotel" {{ $supplier->category == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                                                                <option value="Transport" {{ $supplier->category == 'Transport' ? 'selected' : '' }}>Transport</option>
                                                                <option value="Food" {{ $supplier->category == 'Food' ? 'selected' : '' }}>Food</option>
                                                                <option value="Other" {{ $supplier->category == 'Other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select class="form-control" id="status" name="status" required>
                                                                <option value="active" {{ $supplier->status == 'active' ? 'selected' : '' }}>Active</option>
                                                                <option value="inactive" {{ $supplier->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="payment_terms" class="form-label">Payment Terms</label>
                                                            <input type="text" class="form-control" id="payment_terms" name="payment_terms"
                                                                value="{{ $supplier->payment_terms ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="currency" class="form-label">Currency</label>
                                                            <input type="text" class="form-control" id="currency" name="currency"
                                                                value="{{ $supplier->currency ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="tax_id" class="form-label">Tax ID / VAT No.</label>
                                                            <input type="text" class="form-control" id="tax_id" name="tax_id"
                                                                value="{{ $supplier->tax_id ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Column - Contact and Address -->
                                            <div class="col-md-3">
                                                <div class="info-card">
                                                    <h6 class="mb-3"><i class="fa fa-user"></i> Key Contact</h6>
                                                    <div class="form-group mb-2">
                                                        <label for="contact_person" class="form-label">Contact Person</label>
                                                        <input type="text" class="form-control form-control-sm" id="contact_person" name="contact_person"
                                                            value="{{ $supplier->contact_person }}" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control form-control-sm" id="email" name="email"
                                                            value="{{ $supplier->email }}" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label for="phone" class="form-label">Phone</label>
                                                        <input type="text" class="form-control form-control-sm" id="phone" name="phone"
                                                            value="{{ $supplier->phone }}" required>
                                                    </div>
                                                </div>
                                                <div class="info-card">
                                                    <h6 class="mb-3"><i class="fa fa-map-marker"></i> Address</h6>
                                                    <div class="form-group mb-2">
                                                        <label for="address" class="form-label">Address</label>
                                                        <textarea class="form-control form-control-sm" id="address" name="address" rows="3">{{ $supplier->address ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Details Tab -->
                                    <div class="tab-pane fade" id="contact" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="mb-0">Contact Persons</h5>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addContactModal">
                                                        <i class="fa fa-plus"></i> Add Contact
                                                    </button>
                                                </div>

                                                @if($supplier->contacts->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Email</th>
                                                                    <th>Phone</th>
                                                                    <th>Position</th>
                                                                    <th>Department</th>
                                                                    <th>Primary</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($supplier->contacts as $contact)
                                                                    <tr>
                                                                        <td>{{ $contact->title }} {{ $contact->first_name }} {{ $contact->last_name }}</td>
                                                                        <td>{{ $contact->email }}</td>
                                                                        <td>{{ $contact->phone }}</td>
                                                                        <td>{{ $contact->position ?? '-' }}</td>
                                                                        <td>{{ $contact->department ?? '-' }}</td>
                                                                        <td>
                                                                            @if($contact->is_primary)
                                                                                <span class="badge badge-success">Yes</span>
                                                                            @else
                                                                                <span class="badge badge-danger">No</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-sm btn-info edit-contact-btn"
                                                                                    data-contact-id="{{ $contact->id }}"
                                                                                    data-title="{{ $contact->title ?? '' }}"
                                                                                    data-first-name="{{ $contact->first_name }}"
                                                                                    data-last-name="{{ $contact->last_name }}"
                                                                                    data-email="{{ $contact->email }}"
                                                                                    data-phone="{{ $contact->phone }}"
                                                                                    data-position="{{ $contact->position ?? '' }}"
                                                                                    data-department="{{ $contact->department ?? '' }}"
                                                                                    data-is-primary="{{ $contact->is_primary ? 'true' : 'false' }}">
                                                                                <i class="fa fa-edit"></i>
                                                                            </button>
                                                                            <form action="{{ route('admin.suppliers.contacts.destroy', [$supplier->id, $contact->id]) }}" method="POST" style="display: inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this contact?')">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        <i class="fa fa-info-circle"></i>
                                                        No contacts added yet. Click "Add Contact" to add a new contact person.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Details Tab -->
                                    <div class="tab-pane fade" id="account" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="mb-0">Bank Accounts</h5>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                                                        <i class="fa fa-plus"></i> Add Account
                                                    </button>
                                                </div>

                                                @if($supplier->accounts->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Bank Name</th>
                                                                    <th>Account Number</th>
                                                                    <th>Account Name</th>
                                                                    <th>Account Type</th>
                                                                    <th>Currency</th>
                                                                    <th>Primary</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($supplier->accounts as $account)
                                                                    <tr>
                                                                        <td>{{ $account->bank_name }}</td>
                                                                        <td>{{ $account->account_number }}</td>
                                                                        <td>{{ $account->account_name }}</td>
                                                                        <td>{{ ucfirst($account->account_type) }}</td>
                                                                        <td>{{ $account->currency }}</td>
                                                                        <td>
                                                                            @if($account->is_primary)
                                                                                <span class="badge badge-success">Yes</span>
                                                                            @else
                                                                                <span class="badge badge-danger">No</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-sm btn-info edit-account-btn"
                                                                                    data-account-id="{{ $account->id }}"
                                                                                    data-bank-name="{{ $account->bank_name }}"
                                                                                    data-account-number="{{ $account->account_number }}"
                                                                                    data-account-name="{{ $account->account_name }}"
                                                                                    data-account-type="{{ $account->account_type }}"
                                                                                    data-currency="{{ $account->currency }}"
                                                                                    data-swift-code="{{ $account->swift_code ?? '' }}"
                                                                                    data-iban="{{ $account->iban ?? '' }}"
                                                                                    data-routing-number="{{ $account->routing_number ?? '' }}"
                                                                                    data-bank-address="{{ $account->bank_address ?? '' }}"
                                                                                    data-is-primary="{{ $account->is_primary ? 'true' : 'false' }}">
                                                                                <i class="fa fa-edit"></i>
                                                                            </button>
                                                                            <form action="{{ route('admin.suppliers.accounts.destroy', [$supplier->id, $account->id]) }}" method="POST" style="display: inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this account?')">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        <i class="fa fa-info-circle"></i>
                                                        No accounts added yet. Click "Add Account" to add a new bank account.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ledger Tab -->
                                    <div class="tab-pane fade" id="ledger" role="tabpanel">
                                        <style>
                                            .ledger-summary-card {
                                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                                color: white;
                                                border-radius: 10px;
                                                padding: 20px;
                                                margin-bottom: 20px;
                                            }
                                            .ledger-summary-card .summary-value {
                                                font-size: 1.8rem;
                                                font-weight: 700;
                                                margin: 0;
                                            }
                                            .ledger-summary-card .summary-label {
                                                font-size: 0.9rem;
                                                opacity: 0.9;
                                                margin-bottom: 5px;
                                            }
                                            .summary-card-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
                                            .summary-card-green { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
                                            .summary-card-orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
                                            .summary-card-purple { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
                                            .ledger-filter-section {
                                                background-color: #f8f9fa;
                                                padding: 20px;
                                                border-radius: 8px;
                                                margin-bottom: 20px;
                                            }
                                            .transaction-type-badge {
                                                padding: 5px 12px;
                                                border-radius: 20px;
                                                font-size: 12px;
                                                font-weight: 500;
                                            }
                                            .badge-invoice { background-color: #e3f2fd; color: #1976d2; }
                                            .badge-payment { background-color: #e8f5e9; color: #388e3c; }
                                            .badge-credit-note { background-color: #fff3e0; color: #f57c00; }
                                            .badge-adjustment { background-color: #f3e5f5; color: #7b1fa2; }
                                            .status-posted { background-color: #e8f5e9; color: #388e3c; padding: 4px 10px; border-radius: 12px; font-size: 11px; }
                                            .ledger-table th {
                                                background-color: #f8f9fa;
                                                font-weight: 600;
                                                color: #495057;
                                            }
                                            .ledger-actions-dropdown {
                                                position: relative;
                                            }
                                        </style>

                                        <!-- Summary Cards -->
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <div class="ledger-summary-card summary-card-blue">
                                                    <div class="summary-label">Opening Balance</div>
                                                    <p class="summary-value" id="openingBalance">{{ $supplier->currency ?? 'INR' }}0.00 (Dr)</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="ledger-summary-card summary-card-orange">
                                                    <div class="summary-label">Total Invoiced / Debit</div>
                                                    <p class="summary-value" id="totalDebit">{{ $supplier->currency ?? 'INR' }}0.00 (Dr)</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="ledger-summary-card summary-card-green">
                                                    <div class="summary-label">Total Paid / Credit</div>
                                                    <p class="summary-value" id="totalCredit">{{ $supplier->currency ?? 'INR' }}0.00 (Cr)</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="ledger-summary-card summary-card-purple">
                                                    <div class="summary-label">Current Outstanding Balance</div>
                                                    <p class="summary-value" id="closingBalance">{{ $supplier->currency ?? 'INR' }}0.00 (Dr)</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Filter Section -->
                                        <div class="ledger-filter-section">
                                            <div class="row align-items-end">
                                                <div class="col-md-2">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">From Date</label>
                                                        <input type="date" class="form-control" id="ledgerFromDate">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">To Date</label>
                                                        <input type="date" class="form-control" id="ledgerToDate">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">Transaction Type</label>
                                                        <select class="form-control" id="ledgerTransactionType">
                                                            <option value="all">All</option>
                                                            <option value="Invoice">Invoice</option>
                                                            <option value="Payment">Payment</option>
                                                            <option value="Credit Note">Credit Note</option>
                                                            <option value="Adjustment">Adjustment</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">Search</label>
                                                        <input type="text" class="form-control" id="ledgerSearch" placeholder="Search by reference or description...">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">&nbsp;</label>
                                                        <div class="d-flex gap-2">
                                                            <button type="button" class="btn btn-primary" onclick="loadLedgerData()">
                                                                <i class="fa fa-search"></i> Apply Filter
                                                            </button>
                                                            <button type="button" class="btn btn-secondary" onclick="resetLedgerFilters()">
                                                                <i class="fa fa-refresh"></i> Reset
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="row mb-3">
                                            <div class="col-md-12 text-end">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLedgerTransactionModal">
                                                    <i class="fa fa-plus"></i> Add Transaction
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" onclick="exportLedger()">
                                                    <i class="fa fa-download"></i> Export
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Transaction Table -->
                                        <div class="table-responsive">
                                            <table class="table table-striped ledger-table">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Reference No.</th>
                                                        <th>Transaction Type</th>
                                                        <th>Description</th>
                                                        <th>Debit (INR)</th>
                                                        <th>Credit (INR)</th>
                                                        <th>Running Balance (INR)</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="ledgerTableBody">
                                                    <tr>
                                                        <td colspan="9" class="text-center">Loading...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Bottom Summary -->
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <strong>Total Debit:</strong> <span id="bottomTotalDebit">₹0.00</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Total Credit:</strong> <span id="bottomTotalCredit">₹0.00</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Closing Balance:</strong> <span id="bottomClosingBalance">₹0.00 (Dr)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pagination -->
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div id="ledgerPagination"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bottom Info Bar -->
                                <div class="alert alert-secondary mt-3 mb-0">
                                    <i class="fa fa-lightbulb"></i>
                                    <small>Use the tabs above to manage contact details, account information and view the supplier ledger.</small>
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

    <!-- Add Ledger Transaction Modal -->
    <div class="modal fade" id="addLedgerTransactionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Transaction</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.suppliers.ledger.store', $supplier->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="ledger_transaction_date" class="form-label">Transaction Date</label>
                                    <input type="date" class="form-control" id="ledger_transaction_date" name="transaction_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="ledger_reference_no" class="form-label">Reference No.</label>
                                    <input type="text" class="form-control" id="ledger_reference_no" name="reference_no" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="ledger_transaction_type" class="form-label">Transaction Type</label>
                                    <select class="form-control" id="ledger_transaction_type" name="transaction_type" required>
                                        <option value="Invoice">Invoice</option>
                                        <option value="Payment">Payment</option>
                                        <option value="Credit Note">Credit Note</option>
                                        <option value="Adjustment">Adjustment</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="ledger_status" class="form-label">Status</label>
                                    <select class="form-control" id="ledger_status" name="status" required>
                                        <option value="posted">Posted</option>
                                        <option value="pending">Pending</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="ledger_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="ledger_description" name="description" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="ledger_debit" class="form-label">Debit Amount</label>
                                    <input type="number" step="0.01" class="form-control" id="ledger_debit" name="debit" value="0" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="ledger_credit" class="form-label">Credit Amount</label>
                                    <input type="number" step="0.01" class="form-control" id="ledger_credit" name="credit" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Transaction</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Contact Modal -->
    <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Contact Person</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.suppliers.contacts.store', $supplier->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="contact_title" class="form-label">Title</label>
                                    <select class="form-control" id="contact_title" name="title">
                                        <option value="">Select Title</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Dr.">Dr.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="contact_first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="contact_first_name" name="first_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="contact_last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="contact_last_name" name="last_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="contact_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="contact_email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="contact_phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="contact_phone" name="phone" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="contact_position" class="form-label">Position</label>
                                    <input type="text" class="form-control" id="contact_position" name="position">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="contact_department" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="contact_department" name="department">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="contact_is_primary" class="form-label">Primary Contact</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" id="contact_is_primary" name="is_primary">
                                        <label class="form-check-label" for="contact_is_primary">Mark as primary contact</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Contact</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Contact Modal -->
    <div class="modal fade" id="editContactModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Contact Person</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editContactForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_contact_title" class="form-label">Title</label>
                                    <select class="form-control" id="edit_contact_title" name="title">
                                        <option value="">Select Title</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Dr.">Dr.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_contact_first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="edit_contact_first_name" name="first_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_contact_last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="edit_contact_last_name" name="last_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_contact_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="edit_contact_email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_contact_phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="edit_contact_phone" name="phone" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_contact_position" class="form-label">Position</label>
                                    <input type="text" class="form-control" id="edit_contact_position" name="position">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_contact_department" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="edit_contact_department" name="department">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_contact_is_primary" class="form-label">Primary Contact</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" id="edit_contact_is_primary" name="is_primary">
                                        <label class="form-check-label" for="edit_contact_is_primary">Mark as primary contact</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Contact</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Account Modal -->
    <div class="modal fade" id="addAccountModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Bank Account</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.suppliers.accounts.store', $supplier->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="account_bank_name" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="account_bank_name" name="bank_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="account_account_number" class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id="account_account_number" name="account_number" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="account_account_name" class="form-label">Account Name</label>
                                    <input type="text" class="form-control" id="account_account_name" name="account_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="account_account_type" class="form-label">Account Type</label>
                                    <select class="form-control" id="account_account_type" name="account_type" required>
                                        <option value="checking">Current</option>
                                        <option value="savings">Savings</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="account_currency" class="form-label">Currency</label>
                                    <input type="text" class="form-control" id="account_currency" name="currency" value="USD" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="account_swift_code" class="form-label">SWIFT Code</label>
                                    <input type="text" class="form-control" id="account_swift_code" name="swift_code">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="account_iban" class="form-label">IBAN</label>
                                    <input type="text" class="form-control" id="account_iban" name="iban">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="account_routing_number" class="form-label">Routing Number</label>
                                    <input type="text" class="form-control" id="account_routing_number" name="routing_number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="account_bank_address" class="form-label">Bank Address</label>
                                    <textarea class="form-control" id="account_bank_address" name="bank_address" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="account_is_primary" class="form-label">Primary Account</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" id="account_is_primary" name="is_primary">
                                        <label class="form-check-label" for="account_is_primary">Mark as primary account</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Account Modal -->
    <div class="modal fade" id="editAccountModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Bank Account</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editAccountForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_account_bank_name" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="edit_account_bank_name" name="bank_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_account_account_number" class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id="edit_account_account_number" name="account_number" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_account_account_name" class="form-label">Account Name</label>
                                    <input type="text" class="form-control" id="edit_account_account_name" name="account_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_account_account_type" class="form-label">Account Type</label>
                                    <select class="form-control" id="edit_account_account_type" name="account_type" required>
                                        <option value="checking">Checking</option>
                                        <option value="savings">Savings</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_account_currency" class="form-label">Currency</label>
                                    <input type="text" class="form-control" id="edit_account_currency" name="currency" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_account_swift_code" class="form-label">SWIFT Code</label>
                                    <input type="text" class="form-control" id="edit_account_swift_code" name="swift_code">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_account_iban" class="form-label">IBAN</label>
                                    <input type="text" class="form-control" id="edit_account_iban" name="iban">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_account_routing_number" class="form-label">Routing Number</label>
                                    <input type="text" class="form-control" id="edit_account_routing_number" name="routing_number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="edit_account_bank_address" class="form-label">Bank Address</label>
                                    <textarea class="form-control" id="edit_account_bank_address" name="bank_address" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="edit_account_is_primary" class="form-label">Primary Account</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" id="edit_account_is_primary" name="is_primary">
                                        <label class="form-check-label" for="edit_account_is_primary">Mark as primary account</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Edit Contact Modal
        document.querySelectorAll('.edit-contact-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const contactId = this.getAttribute('data-contact-id');
                const title = this.getAttribute('data-title');
                const firstName = this.getAttribute('data-first-name');
                const lastName = this.getAttribute('data-last-name');
                const email = this.getAttribute('data-email');
                const phone = this.getAttribute('data-phone');
                const position = this.getAttribute('data-position');
                const department = this.getAttribute('data-department');
                const isPrimary = this.getAttribute('data-is-primary') === 'true';

                document.getElementById('edit_contact_title').value = title;
                document.getElementById('edit_contact_first_name').value = firstName;
                document.getElementById('edit_contact_last_name').value = lastName;
                document.getElementById('edit_contact_email').value = email;
                document.getElementById('edit_contact_phone').value = phone;
                document.getElementById('edit_contact_position').value = position;
                document.getElementById('edit_contact_department').value = department;
                document.getElementById('edit_contact_is_primary').checked = isPrimary;

                const form = document.getElementById('editContactForm');
                form.action = '{{ route('admin.suppliers.contacts.update', [$supplier->id, 'PLACEHOLDER']) }}'.replace('PLACEHOLDER', contactId);

                const modal = new bootstrap.Modal(document.getElementById('editContactModal'));
                modal.show();
            });
        });

        // Edit Account Modal
        document.querySelectorAll('.edit-account-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const accountId = this.getAttribute('data-account-id');
                const bankName = this.getAttribute('data-bank-name');
                const accountNumber = this.getAttribute('data-account-number');
                const accountName = this.getAttribute('data-account-name');
                const accountType = this.getAttribute('data-account-type');
                const currency = this.getAttribute('data-currency');
                const swiftCode = this.getAttribute('data-swift-code');
                const iban = this.getAttribute('data-iban');
                const routingNumber = this.getAttribute('data-routing-number');
                const bankAddress = this.getAttribute('data-bank-address');
                const isPrimary = this.getAttribute('data-is-primary') === 'true';

                document.getElementById('edit_account_bank_name').value = bankName;
                document.getElementById('edit_account_account_number').value = accountNumber;
                document.getElementById('edit_account_account_name').value = accountName;
                document.getElementById('edit_account_account_type').value = accountType;
                document.getElementById('edit_account_currency').value = currency;
                document.getElementById('edit_account_swift_code').value = swiftCode;
                document.getElementById('edit_account_iban').value = iban;
                document.getElementById('edit_account_routing_number').value = routingNumber;
                document.getElementById('edit_account_bank_address').value = bankAddress;
                document.getElementById('edit_account_is_primary').checked = isPrimary;

                const form = document.getElementById('editAccountForm');
                form.action = '{{ route('admin.suppliers.accounts.update', [$supplier->id, 'PLACEHOLDER']) }}'.replace('PLACEHOLDER', accountId);

                const modal = new bootstrap.Modal(document.getElementById('editAccountModal'));
                modal.show();
            });
        });

        // Ledger Functions
        let currentPage = 1;
        const supplierCurrency = '{{ $supplier->currency ?? "INR" }}';

        function loadLedgerData(page = 1) {
            const fromDate = document.getElementById('ledgerFromDate').value;
            const toDate = document.getElementById('ledgerToDate').value;
            const transactionType = document.getElementById('ledgerTransactionType').value;
            const search = document.getElementById('ledgerSearch').value;

            const params = new URLSearchParams();
            if (fromDate) params.append('from_date', fromDate);
            if (toDate) params.append('to_date', toDate);
            if (transactionType && transactionType !== 'all') params.append('transaction_type', transactionType);
            if (search) params.append('search', search);
            params.append('page', page);

            fetch(`{{ route('admin.suppliers.ledger.data', $supplier->id) }}?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    updateLedgerUI(data);
                    currentPage = page;
                })
                .catch(error => console.error('Error loading ledger data:', error));
        }

        function updateLedgerUI(data) {
            // Update summary cards
            document.getElementById('openingBalance').textContent = formatCurrency(data.opening_balance) + (data.opening_balance >= 0 ? ' (Dr)' : ' (Cr)');
            document.getElementById('totalDebit').textContent = formatCurrency(data.total_debit) + ' (Dr)';
            document.getElementById('totalCredit').textContent = formatCurrency(data.total_credit) + ' (Cr)';
            document.getElementById('closingBalance').textContent = formatCurrency(data.closing_balance) + (data.closing_balance >= 0 ? ' (Dr)' : ' (Cr)');

            // Update bottom summary
            document.getElementById('bottomTotalDebit').textContent = formatCurrency(data.total_debit);
            document.getElementById('bottomTotalCredit').textContent = formatCurrency(data.total_credit);
            document.getElementById('bottomClosingBalance').textContent = formatCurrency(data.closing_balance) + (data.closing_balance >= 0 ? ' (Dr)' : ' (Cr)');

            // Update table
            const tbody = document.getElementById('ledgerTableBody');
            if (data.transactions.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" class="text-center">No transactions found</td></tr>';
            } else {
                tbody.innerHTML = data.transactions.data.map(transaction => `
                    <tr>
                        <td>${formatDate(transaction.transaction_date)}</td>
                        <td>${transaction.reference_no}</td>
                        <td><span class="transaction-type-badge ${getTransactionTypeBadge(transaction.transaction_type)}">${transaction.transaction_type}</span></td>
                        <td>${transaction.description || '-'}</td>
                        <td class="text-danger">${transaction.debit > 0 ? formatCurrency(transaction.debit) : '-'}</td>
                        <td class="text-success">${transaction.credit > 0 ? formatCurrency(transaction.credit) : '-'}</td>
                        <td><strong>${formatCurrency(transaction.running_balance)} ${transaction.running_balance >= 0 ? '(Dr)' : '(Cr)'}</strong></td>
                        <td><span class="status-posted">${transaction.status}</span></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="editLedgerTransaction(${transaction.id})"><i class="fa fa-edit"></i> Edit</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteLedgerTransaction(${transaction.id})"><i class="fa fa-trash"></i> Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                `).join('');
            }

            // Update pagination
            if (data.transactions.links && data.transactions.links.length > 0) {
                const paginationHtml = '<nav><ul class="pagination justify-content-end">';
                data.transactions.links.forEach(link => {
                    if (link.url === null) {
                        // Disabled link (Previous/Next when not available)
                        paginationHtml += `<li class="page-item disabled"><span class="page-link">${link.label}</span></li>`;
                    } else if (link.active) {
                        // Active page
                        paginationHtml += `<li class="page-item active"><span class="page-link">${link.label}</span></li>`;
                    } else {
                        // Regular link
                        const pageNum = getPageNumber(link.url);
                        paginationHtml += `<li class="page-item"><a class="page-link" href="#" onclick="loadLedgerData(${pageNum})">${link.label}</a></li>`;
                    }
                });
                paginationHtml += '</ul></nav>';
                document.getElementById('ledgerPagination').innerHTML = paginationHtml;
            } else {
                document.getElementById('ledgerPagination').innerHTML = '';
            }
        }

        function formatCurrency(amount) {
            return supplierCurrency + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' });
        }

        function getTransactionTypeBadge(type) {
            const badges = {
                'Invoice': 'badge-invoice',
                'Payment': 'badge-payment',
                'Credit Note': 'badge-credit-note',
                'Adjustment': 'badge-adjustment'
            };
            return badges[type] || 'badge-invoice';
        }

        function getPageNumber(url) {
            const match = url.match(/page=(\d+)/);
            return match ? parseInt(match[1]) : 1;
        }

        function resetLedgerFilters() {
            document.getElementById('ledgerFromDate').value = '';
            document.getElementById('ledgerToDate').value = '';
            document.getElementById('ledgerTransactionType').value = 'all';
            document.getElementById('ledgerSearch').value = '';
            loadLedgerData(1);
        }

        function exportLedger() {
            alert('Export functionality will be implemented soon.');
        }

        function editLedgerTransaction(transactionId) {
            alert('Edit transaction functionality will be implemented with a modal.');
        }

        function deleteLedgerTransaction(transactionId) {
            if (confirm('Are you sure you want to delete this transaction?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ route('admin.suppliers.ledger.destroy', [$supplier->id, '']) }}${transactionId}`;
                form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">';
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Load ledger data when ledger tab is shown
        const ledgerTab = document.getElementById('ledger-tab');
        if (ledgerTab) {
            ledgerTab.addEventListener('shown.bs.tab', function() {
                loadLedgerData(1);
            });
        }
    </script>
@endsection
