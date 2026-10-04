@extends('admin/layouts/head-main')
@section('content')
    <title>View Supplier</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
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
                            <li class="breadcrumb-item active">View Supplier</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-primary">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <a href="{{ route('admin.suppliers') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
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
                                            @if($supplier->description)
                                                <p class="text-muted small mt-3">{{ $supplier->description }}</p>
                                            @endif
                                        </div>

                                        <!-- Middle Column - Information Grid -->
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-card">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fa fa-hashtag info-icon"></i>
                                                            <div>
                                                                <div class="info-label">Supplier Code</div>
                                                                <div class="info-value">{{ $supplier->supplier_code }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-card">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fa fa-globe info-icon"></i>
                                                            <div>
                                                                <div class="info-label">Website</div>
                                                                <div class="info-value">
                                                                    @if($supplier->website)
                                                                        <a href="{{ $supplier->website }}" target="_blank">{{ $supplier->website }}</a>
                                                                    @else
                                                                        <span class="text-muted">N/A</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-card">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fa fa-tag info-icon"></i>
                                                            <div>
                                                                <div class="info-label">Category</div>
                                                                <div class="info-value">
                                                                    <span class="badge bg-info">{{ $supplier->category }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-card">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fa fa-calendar info-icon"></i>
                                                            <div>
                                                                <div class="info-label">Created On</div>
                                                                <div class="info-value">{{ $supplier->created_at ? $supplier->created_at->format('d-m-Y') : 'N/A' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-card">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fa fa-clock-o info-icon"></i>
                                                            <div>
                                                                <div class="info-label">Payment Terms</div>
                                                                <div class="info-value">{{ $supplier->payment_terms ?? 'N/A' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-card">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fa fa-money info-icon"></i>
                                                            <div>
                                                                <div class="info-label">Currency</div>
                                                                <div class="info-value">{{ $supplier->currency ?? 'N/A' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-card">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fa fa-id-card info-icon"></i>
                                                            <div>
                                                                <div class="info-label">Tax ID / VAT No.</div>
                                                                <div class="info-value">{{ $supplier->tax_id ?? 'N/A' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-card">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fa fa-check-circle info-icon"></i>
                                                            <div>
                                                                <div class="info-label">Status</div>
                                                                <div class="info-value">
                                                                    <span class="status-badge {{ $supplier->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                                                        <span class="status-dot"></span>
                                                                        {{ ucfirst($supplier->status) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column - Contact and Address -->
                                        <div class="col-md-3">
                                            <div class="info-card">
                                                <h6 class="mb-3"><i class="fa fa-user"></i> Key Contact</h6>
                                                <div class="mb-2">
                                                    <div class="info-label">Contact Person</div>
                                                    <div class="info-value">{{ $supplier->contact_person }}</div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="info-label">Email</div>
                                                    <div class="info-value">
                                                        <a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="info-label">Phone</div>
                                                    <div class="info-value">{{ $supplier->phone }}</div>
                                                </div>
                                            </div>
                                            @if($supplier->address)
                                                <div class="info-card">
                                                    <h6 class="mb-3"><i class="fa fa-map-marker"></i> Address</h6>
                                                    <p class="text-muted small mb-0">{{ $supplier->address }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Details Tab -->
                                <div class="tab-pane fade" id="contact" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="mb-3">Contact Persons</h5>
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
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle"></i>
                                                    No contacts added yet.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Details Tab -->
                                <div class="tab-pane fade" id="account" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="mb-3">Bank Accounts</h5>
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
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle"></i>
                                                    No accounts added yet.
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
                                    </style>

                                    <!-- Summary Cards -->
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <div class="ledger-summary-card summary-card-blue">
                                                <div class="summary-label">Opening Balance</div>
                                                <p class="summary-value" id="viewOpeningBalance">{{ $supplier->currency ?? 'INR' }}0.00 (Dr)</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ledger-summary-card summary-card-orange">
                                                <div class="summary-label">Total Invoiced / Debit</div>
                                                <p class="summary-value" id="viewTotalDebit">{{ $supplier->currency ?? 'INR' }}0.00 (Dr)</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ledger-summary-card summary-card-green">
                                                <div class="summary-label">Total Paid / Credit</div>
                                                <p class="summary-value" id="viewTotalCredit">{{ $supplier->currency ?? 'INR' }}0.00 (Cr)</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ledger-summary-card summary-card-purple">
                                                <div class="summary-label">Current Outstanding Balance</div>
                                                <p class="summary-value" id="viewClosingBalance">{{ $supplier->currency ?? 'INR' }}0.00 (Dr)</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filter Section -->
                                    <div class="ledger-filter-section">
                                        <div class="row align-items-end">
                                            <div class="col-md-2">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">From Date</label>
                                                    <input type="date" class="form-control" id="viewLedgerFromDate">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">To Date</label>
                                                    <input type="date" class="form-control" id="viewLedgerToDate">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">Transaction Type</label>
                                                    <select class="form-control" id="viewLedgerTransactionType">
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
                                                    <input type="text" class="form-control" id="viewLedgerSearch" placeholder="Search by reference or description...">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label class="form-label">&nbsp;</label>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-primary" onclick="loadViewLedgerData()">
                                                            <i class="fa fa-search"></i> Apply Filter
                                                        </button>
                                                        <button type="button" class="btn btn-secondary" onclick="resetViewLedgerFilters()">
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
                                            <button type="button" class="btn btn-outline-secondary" onclick="exportViewLedger()">
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
                                                </tr>
                                            </thead>
                                            <tbody id="viewLedgerTableBody">
                                                <tr>
                                                    <td colspan="8" class="text-center">Loading...</td>
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
                                                            <strong>Total Debit:</strong> <span id="viewBottomTotalDebit">₹0.00</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>Total Credit:</strong> <span id="viewBottomTotalCredit">₹0.00</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>Closing Balance:</strong> <span id="viewBottomClosingBalance">₹0.00 (Dr)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div id="viewLedgerPagination"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Info Bar -->
                            <div class="alert alert-secondary mt-3 mb-0">
                                <i class="fa fa-lightbulb"></i>
                                <small>Use the tabs above to manage contact details, account information and view the supplier ledger.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->

    <script>
        // View Ledger Functions
        let viewCurrentPage = 1;
        const viewSupplierCurrency = '{{ $supplier->currency ?? "INR" }}';

        function loadViewLedgerData(page = 1) {
            const fromDate = document.getElementById('viewLedgerFromDate').value;
            const toDate = document.getElementById('viewLedgerToDate').value;
            const transactionType = document.getElementById('viewLedgerTransactionType').value;
            const search = document.getElementById('viewLedgerSearch').value;

            const params = new URLSearchParams();
            if (fromDate) params.append('from_date', fromDate);
            if (toDate) params.append('to_date', toDate);
            if (transactionType && transactionType !== 'all') params.append('transaction_type', transactionType);
            if (search) params.append('search', search);
            params.append('page', page);

            fetch(`{{ route('admin.suppliers.ledger.data', $supplier->id) }}?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    updateViewLedgerUI(data);
                    viewCurrentPage = page;
                })
                .catch(error => console.error('Error loading ledger data:', error));
        }

        function updateViewLedgerUI(data) {
            // Update summary cards
            document.getElementById('viewOpeningBalance').textContent = formatViewCurrency(data.opening_balance) + (data.opening_balance >= 0 ? ' (Dr)' : ' (Cr)');
            document.getElementById('viewTotalDebit').textContent = formatViewCurrency(data.total_debit) + ' (Dr)';
            document.getElementById('viewTotalCredit').textContent = formatViewCurrency(data.total_credit) + ' (Cr)';
            document.getElementById('viewClosingBalance').textContent = formatViewCurrency(data.closing_balance) + (data.closing_balance >= 0 ? ' (Dr)' : ' (Cr)');

            // Update bottom summary
            document.getElementById('viewBottomTotalDebit').textContent = formatViewCurrency(data.total_debit);
            document.getElementById('viewBottomTotalCredit').textContent = formatViewCurrency(data.total_credit);
            document.getElementById('viewBottomClosingBalance').textContent = formatViewCurrency(data.closing_balance) + (data.closing_balance >= 0 ? ' (Dr)' : ' (Cr)');

            // Update table
            const tbody = document.getElementById('viewLedgerTableBody');
            if (data.transactions.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center">No transactions found</td></tr>';
            } else {
                tbody.innerHTML = data.transactions.data.map(transaction => `
                    <tr>
                        <td>${formatViewDate(transaction.transaction_date)}</td>
                        <td>${transaction.reference_no}</td>
                        <td><span class="transaction-type-badge ${getViewTransactionTypeBadge(transaction.transaction_type)}">${transaction.transaction_type}</span></td>
                        <td>${transaction.description || '-'}</td>
                        <td class="text-danger">${transaction.debit > 0 ? formatViewCurrency(transaction.debit) : '-'}</td>
                        <td class="text-success">${transaction.credit > 0 ? formatViewCurrency(transaction.credit) : '-'}</td>
                        <td><strong>${formatViewCurrency(transaction.running_balance)} ${transaction.running_balance >= 0 ? '(Dr)' : '(Cr)'}</strong></td>
                        <td><span class="status-posted">${transaction.status}</span></td>
                    </tr>
                `).join('');
            }

            // Update pagination
            if (data.transactions.links && data.transactions.links.length > 0) {
                const paginationHtml = '<nav><ul class="pagination justify-content-end">';
                data.transactions.links.forEach(link => {
                    if (link.url === null) {
                        paginationHtml += `<li class="page-item disabled"><span class="page-link">${link.label}</span></li>`;
                    } else if (link.active) {
                        paginationHtml += `<li class="page-item active"><span class="page-link">${link.label}</span></li>`;
                    } else {
                        const pageNum = getViewPageNumber(link.url);
                        paginationHtml += `<li class="page-item"><a class="page-link" href="#" onclick="loadViewLedgerData(${pageNum})">${link.label}</a></li>`;
                    }
                });
                paginationHtml += '</ul></nav>';
                document.getElementById('viewLedgerPagination').innerHTML = paginationHtml;
            } else {
                document.getElementById('viewLedgerPagination').innerHTML = '';
            }
        }

        function formatViewCurrency(amount) {
            return viewSupplierCurrency + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        function formatViewDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' });
        }

        function getViewTransactionTypeBadge(type) {
            const badges = {
                'Invoice': 'badge-invoice',
                'Payment': 'badge-payment',
                'Credit Note': 'badge-credit-note',
                'Adjustment': 'badge-adjustment'
            };
            return badges[type] || 'badge-invoice';
        }

        function getViewPageNumber(url) {
            const match = url.match(/page=(\d+)/);
            return match ? parseInt(match[1]) : 1;
        }

        function resetViewLedgerFilters() {
            document.getElementById('viewLedgerFromDate').value = '';
            document.getElementById('viewLedgerToDate').value = '';
            document.getElementById('viewLedgerTransactionType').value = 'all';
            document.getElementById('viewLedgerSearch').value = '';
            loadViewLedgerData(1);
        }

        function exportViewLedger() {
            alert('Export functionality will be implemented soon.');
        }

        // Load ledger data when ledger tab is shown
        const viewLedgerTab = document.getElementById('ledger-tab');
        if (viewLedgerTab) {
            viewLedgerTab.addEventListener('shown.bs.tab', function() {
                loadViewLedgerData(1);
            });
        }
    </script>
@endsection
