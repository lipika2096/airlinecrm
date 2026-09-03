@extends('admin/layouts/head-main')
@section('title', 'Payment Pool')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Payment Pool</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Payment Pool</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <!-- Search/Filter Section -->
                        <div class="filter-section mb-4">
                            <div class="row align-items-end">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>From:</label>
                                        <input type="date" class="form-control" id="fromDate" value="{{ request('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>To:</label>
                                        <input type="date" class="form-control" id="toDate" value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-primary w-100" id="submitFilter">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                                            <i class="fa fa-plus"></i> Add Transaction
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Year Navigation -->
                        <div class="year-navigation mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button class="btn btn-outline-secondary btn-sm" id="prevYear">
                                            <i class="fa fa-chevron-left"></i>
                                        </button>
                                        <h4 class="mx-3 mb-0" id="currentYear">Year {{ date('Y') }}</h4>
                                        <button class="btn btn-outline-secondary btn-sm" id="nextYear">
                                            <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Month Buttons -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 1 ? 'active' : '' }}" data-month="1">JAN</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 2 ? 'active' : '' }}" data-month="2">FEB</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 3 ? 'active' : '' }}" data-month="3">MAR</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 4 ? 'active' : '' }}" data-month="4">APR</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 5 ? 'active' : '' }}" data-month="5">MAY</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 6 ? 'active' : '' }}" data-month="6">JUN</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 7 ? 'active' : '' }}" data-month="7">JUL</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 8 ? 'active' : '' }}" data-month="8">AUG</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 9 ? 'active' : '' }}" data-month="9">SEP</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 10 ? 'active' : '' }}" data-month="10">OCT</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 11 ? 'active' : '' }}" data-month="11">NOV</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 12 ? 'active' : '' }}" data-month="12">DEC</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fund Type Filters -->
                        <div class="fund-type-filters mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="btn btn-outline-secondary fund-filter active" data-filter="all">
                                            All Funds: {{ number_format($allFunds, 2) }}
                                        </button>
                                        <button class="btn btn-outline-secondary fund-filter" data-filter="unallocated">
                                            Un-allocated Funds: {{ number_format($unallocatedFunds, 2) }}
                                        </button>
                                        <button class="btn btn-outline-secondary fund-filter" data-filter="allocated">
                                            Allocated Funds: {{ number_format($allocatedFunds, 2) }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Pool Table -->
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0" id="paymentPoolTable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Account Holder Name</th>
                                        <th>Bank Name</th>
                                        <th>Description</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        <th>Allocate to A/C</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="paymentPoolBody">
                                    @if(isset($transactions) && count($transactions) > 0)
                                        @foreach($transactions as $index => $transaction)
                                            <tr class="payment-pool-row {{ $transaction->is_opening ?? false ? 'opening-row' : '' }} {{ $transaction->payment_pool == 'allocated' ? 'allocated-row' : '' }}" 
                                                data-date="{{ $transaction->tr_date }}"
                                                data-status="{{ $transaction->payment_pool ?? 'unallocated' }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $transaction->tr_date ? \Carbon\Carbon::parse($transaction->tr_date)->format('d M Y H:i:s A') : '-' }}</td>
                                                <td>{{ $transaction->admin ? $transaction->admin->name : 'N/A' }}</td>
                                                <td>{{ $transaction->bank_name ?? '-' }}</td>
                                                <td>{{ $transaction->tr_type ?? '-' }}</td>
                                                <td class="text-danger">
                                                    {{ $transaction->debit > 0 ? number_format($transaction->debit, 2) : '-' }}
                                                </td>
                                                <td class="text-success">
                                                    {{ $transaction->credit > 0 ? number_format($transaction->credit, 2) : '-' }}
                                                </td>
                                                <td><strong>{{ number_format($transaction->running_balance, 2) }}</strong></td>
                                                <td>
                                                    @if($transaction->is_opening ?? false)
                                                        <span class="badge bg-info">Opening Balance</span>
                                                    @elseif($transaction->payment_pool == 'allocated' && $transaction->allocatedToCustomerAccount && $transaction->allocatedToCustomerAccount->admin)
                                                        <span class="badge bg-success">
                                                            {{ $transaction->allocatedToCustomerAccount->admin->name ?? 'N/A' }}
                                                        </span>
                                                    @else
                                                        <button class="btn btn-sm btn-primary allocate-btn" 
                                                                data-id="{{ $transaction->id }}"
                                                                {{ $transaction->payment_pool == 'allocated' ? 'disabled' : '' }}>
                                                            Allocate
                                                        </button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!($transaction->is_opening ?? false))
                                                        @if($transaction->payment_pool == 'allocated')
                                                            <button class="btn btn-sm btn-warning deallocate-btn" data-id="{{ $transaction->id }}">
                                                                <i class="fa fa-undo"></i>
                                                            </button>
                                                        @endif
                                                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $transaction->id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">No transactions found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Payment Pool Action Menu -->
                        <div class="payment-pool-actions mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex gap-2 flex-wrap justify-content-center">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                                            <i class="fa fa-plus"></i> Add to Pool
                                        </button>
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#allocateModal">
                                            <i class="fa fa-share"></i> Allocate
                                        </button>
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createExpenseModal">
                                            <i class="fa fa-file-invoice-dollar"></i> Create Expense
                                        </button>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#supplierPaymentModal">
                                            <i class="fa fa-money-bill-wave"></i> Create Supplier Payment
                                        </button>
                                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#splitAllocationModal">
                                            <i class="fa fa-divide"></i> Split Allocation
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->

<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Transaction to Pool</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addTransactionForm">
                    @csrf
                    <div class="form-group">
                        <label>Transaction Date</label>
                        <input type="date" class="form-control" name="tr_date" required>
                    </div>
                    <div class="form-group">
                        <label>Bank Name</label>
                        <input type="text" class="form-control" name="bank_name">
                    </div>
                    <div class="form-group">
                        <label>Transaction Type</label>
                        <input type="text" class="form-control" name="tr_type">
                    </div>
                    <div class="form-group">
                        <label>Debit</label>
                        <input type="number" step="0.01" class="form-control" name="debit" value="0" required>
                    </div>
                    <div class="form-group">
                        <label>Credit</label>
                        <input type="number" step="0.01" class="form-control" name="credit" value="0" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveTransaction">Save Transaction</button>
            </div>
        </div>
    </div>
</div>

<!-- Allocate Modal -->
<div class="modal fade" id="allocateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Allocation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Transaction Summary -->
                <div class="transaction-summary mb-4">
                    <h6 class="mb-3">Transaction Details</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Date:</strong> <span id="transDate">-</span></p>
                            <p><strong>Bank:</strong> <span id="transBank">-</span></p>
                            <p><strong>Reference:</strong> <span id="transReference">-</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Amount:</strong> <span id="transAmount" class="text-success">-</span></p>
                            <p><strong>Type:</strong> <span id="transType">-</span></p>
                        </div>
                    </div>
                </div>

                <form id="allocateForm">
                    @csrf
                    <input type="hidden" name="transaction_id" id="allocateTransactionId">
                    <input type="hidden" name="allocation_type" id="allocationType" value="booking">
                    
                    <!-- Allocate To Section -->
                    <div class="allocate-to-section mb-4">
                        <h6 class="mb-3">Allocate To</h6>
                        <div class="radio-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="allocation_option" id="bookingOption" value="booking" checked>
                                <label class="form-check-label" for="bookingOption">
                                    Booking / Invoice
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="allocation_option" id="expenseOption" value="expense">
                                <label class="form-check-label" for="expenseOption">
                                    Expense
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="allocation_option" id="supplierOption" value="supplier">
                                <label class="form-check-label" for="supplierOption">
                                    Supplier Payment
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Fields Based on Selection -->
                    <div id="bookingFields" class="allocation-fields mb-4">
                        <div class="form-group">
                            <label>Booking No</label>
                            <select class="form-control" name="booking_id" id="bookingSelect">
                                <option value="">Select Booking</option>
                                @if(isset($bookings))
                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->id }}">
                                            {{ $booking->booking_no }} - {{ $booking->customer_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Outstanding</label>
                            <input type="text" class="form-control" id="outstandingAmount" readonly>
                        </div>
                        <div class="form-group">
                            <label>Allocate Amount</label>
                            <input type="number" step="0.01" class="form-control" name="allocate_amount" id="allocateAmount" required>
                        </div>
                    </div>

                    <div id="expenseFields" class="allocation-fields mb-4" style="display: none;">
                        <div class="form-group">
                            <label>Expense Category</label>
                            <select class="form-control" name="expense_category">
                                <option value="">Select Category</option>
                                <option value="office">Office</option>
                                <option value="travel">Travel</option>
                                <option value="marketing">Marketing</option>
                                <option value="utilities">Utilities</option>
                                <option value="salary">Salary</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Allocate Amount</label>
                            <input type="number" step="0.01" class="form-control" name="allocate_amount" id="expenseAllocateAmount" required>
                        </div>
                    </div>

                    <div id="supplierFields" class="allocation-fields mb-4" style="display: none;">
                        <div class="form-group">
                            <label>Supplier Name</label>
                            <input type="text" class="form-control" name="supplier_name">
                        </div>
                        <div class="form-group">
                            <label>Invoice Number</label>
                            <input type="text" class="form-control" name="invoice_number">
                        </div>
                        <div class="form-group">
                            <label>Allocate Amount</label>
                            <input type="number" step="0.01" class="form-control" name="allocate_amount" id="supplierAllocateAmount" required>
                        </div>
                    </div>

                    <!-- Remarks Section -->
                    <div class="form-group mb-4">
                        <label>Remarks</label>
                        <textarea class="form-control" name="remarks" rows="3" placeholder="Add any notes or description..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmAllocate">Allocate & Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Expense Modal -->
<div class="modal fade" id="createExpenseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Expense</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createExpenseForm">
                    @csrf
                    <div class="form-group">
                        <label>Expense Date</label>
                        <input type="date" class="form-control" name="expense_date" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category" required>
                            <option value="">Select Category</option>
                            <option value="office">Office</option>
                            <option value="travel">Travel</option>
                            <option value="marketing">Marketing</option>
                            <option value="utilities">Utilities</option>
                            <option value="salary">Salary</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" step="0.01" class="form-control" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label>Payment Method</label>
                        <select class="form-control" name="payment_method">
                            <option value="cash">Cash</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="card">Credit Card</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveExpense">Create Expense</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Supplier Payment Modal -->
<div class="modal fade" id="supplierPaymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Supplier Payment</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="supplierPaymentForm">
                    @csrf
                    <div class="form-group">
                        <label>Payment Date</label>
                        <input type="date" class="form-control" name="payment_date" required>
                    </div>
                    <div class="form-group">
                        <label>Supplier Name</label>
                        <input type="text" class="form-control" name="supplier_name" required>
                    </div>
                    <div class="form-group">
                        <label>Invoice Number</label>
                        <input type="text" class="form-control" name="invoice_number">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" step="0.01" class="form-control" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label>Payment Method</label>
                        <select class="form-control" name="payment_method">
                            <option value="bank">Bank Transfer</option>
                            <option value="cash">Cash</option>
                            <option value="card">Credit Card</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveSupplierPayment">Create Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- Split Allocation Modal -->
<div class="modal fade" id="splitAllocationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Split Allocation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="splitAllocationForm">
                    @csrf
                    <div class="form-group">
                        <label>Select Transaction</label>
                        <select class="form-control" name="transaction_id" id="splitTransactionSelect" required>
                            <option value="">Select Transaction</option>
                            @if(isset($transactions) && count($transactions) > 0)
                                @foreach($transactions as $transaction)
                                    @if(!($transaction->is_opening ?? false) && $transaction->payment_pool != 'allocated')
                                        <option value="{{ $transaction->id }}">
                                            {{ $transaction->tr_date ? \Carbon\Carbon::parse($transaction->tr_date)->format('d M Y') : '-' }} - 
                                            {{ number_format($transaction->credit > 0 ? $transaction->credit : $transaction->debit, 2) }}
                                        </option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div id="splitAllocationFields">
                        <div class="form-group split-row">
                            <label>Customer Account 1</label>
                            <select class="form-control split-account" name="accounts[]" required>
                                <option value="">Select Account</option>
                                @foreach($customerAccounts as $account)
                                    @if($account->admin)
                                        <option value="{{ $account->admin->id }}">
                                            {{ $account->admin->name ?? 'N/A' }} - {{ $account->acc_no }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <input type="number" step="0.01" class="form-control split-amount mt-2" name="amounts[]" placeholder="Amount" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addSplitRow">
                        <i class="fa fa-plus"></i> Add Another Account
                    </button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmSplitAllocation">Split Allocate</button>
            </div>
        </div>
    </div>
</div>

<style>
    .filter-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
    }

    .year-navigation {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .fund-type-filters {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }

    .fund-filter.active {
        background-color: #007bff !important;
        color: white !important;
        border-color: #007bff !important;
    }

    .month-btn.active {
        background-color: #007bff !important;
        color: white !important;
    }

    .allocated-row {
        background-color: #e8f5e9;
    }

    .opening-row {
        background-color: #fff3cd;
        font-weight: bold;
    }

    .payment-pool-row:hover {
        background-color: #f8f9fa;
    }

    .payment-pool-actions {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-top: 20px;
    }

    .payment-pool-actions .btn {
        min-width: 180px;
        font-weight: 500;
    }

    .split-row {
        margin-bottom: 15px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .split-row label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .transaction-summary {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .transaction-summary h6 {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .transaction-summary p {
        margin-bottom: 5px;
        font-size: 14px;
    }

    .transaction-summary strong {
        color: #555;
        font-weight: 500;
    }

    .allocate-to-section {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .allocate-to-section h6 {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .radio-group {
        display: flex;
        gap: 20px;
    }

    .form-check-label {
        cursor: pointer;
        font-weight: 500;
    }

    .allocation-fields {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .allocation-fields .form-group {
        margin-bottom: 15px;
    }

    .allocation-fields .form-group:last-child {
        margin-bottom: 0;
    }
</style>

<script>
    let currentYear = {{ date('Y') }};
    let selectedMonth = {{ date('m') }};
    let selectedFilter = 'all';

    // Year Navigation
    document.getElementById('prevYear').addEventListener('click', function() {
        currentYear--;
        document.getElementById('currentYear').textContent = 'Year ' + currentYear;
        filterPaymentPool();
    });

    document.getElementById('nextYear').addEventListener('click', function() {
        currentYear++;
        document.getElementById('currentYear').textContent = 'Year ' + currentYear;
        filterPaymentPool();
    });

    // Month Selection
    document.querySelectorAll('.month-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.month-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            this.classList.add('active');
            selectedMonth = this.getAttribute('data-month');
            filterPaymentPool();
        });
    });

    // Fund Type Filters
    document.querySelectorAll('.fund-filter').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.fund-filter').forEach(function(b) {
                b.classList.remove('active');
            });
            this.classList.add('active');
            selectedFilter = this.getAttribute('data-filter');
            filterPaymentPool();
        });
    });

    // Submit Filter
    document.getElementById('submitFilter').addEventListener('click', function() {
        filterPaymentPool();
    });

    function filterPaymentPool() {
        const fromDate = document.getElementById('fromDate').value;
        const toDate = document.getElementById('toDate').value;
        
        const rows = document.querySelectorAll('.payment-pool-row');
        let visibleCount = 0;

        rows.forEach(function(row) {
            const rowDate = row.getAttribute('data-date');
            const status = row.getAttribute('data-status');
            
            let showRow = true;

            // Filter by date range
            if (fromDate && rowDate < fromDate) {
                showRow = false;
            }
            if (toDate && rowDate > toDate) {
                showRow = false;
            }

            // Filter by year
            const rowYear = new Date(rowDate).getFullYear();
            if (rowYear !== currentYear) {
                showRow = false;
            }

            // Filter by month
            if (selectedMonth) {
                const rowMonth = new Date(rowDate).getMonth() + 1;
                if (rowMonth !== parseInt(selectedMonth)) {
                    showRow = false;
                }
            }

            // Filter by fund type
            if (selectedFilter !== 'all') {
                if (selectedFilter === 'unallocated' && status !== 'unallocated' && status !== null) {
                    showRow = false;
                }
                if (selectedFilter === 'allocated' && status !== 'allocated') {
                    showRow = false;
                }
            }

            if (showRow) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update serial numbers
        let sno = 1;
        rows.forEach(function(row) {
            if (row.style.display !== 'none') {
                row.querySelector('td:first-child').textContent = sno++;
            }
        });
    }

    // Add Transaction
    document.getElementById('saveTransaction').addEventListener('click', function() {
        const form = document.getElementById('addTransactionForm');
        const formData = new FormData(form);
        
        fetch('{{ route("admin.payment-pool.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload();
            } else if (data.errors) {
                let errors = '';
                for (let key in data.errors) {
                    errors += data.errors[key] + '\n';
                }
                alert(errors);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Allocate Modal
    document.querySelectorAll('.allocate-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const transactionId = this.getAttribute('data-id');
            const row = this.closest('tr');
            
            // Get transaction details from the row
            const transDate = row.querySelector('td:nth-child(2)').textContent;
            const transBank = row.querySelector('td:nth-child(4)').textContent;
            const transAmount = row.querySelector('td:nth-child(7)').textContent;
            const transType = row.querySelector('td:nth-child(6)').textContent;
            const transReference = row.querySelector('td:nth-child(3)').textContent;
            
            // Populate transaction summary
            document.getElementById('transDate').textContent = transDate;
            document.getElementById('transBank').textContent = transBank;
            document.getElementById('transAmount').textContent = transAmount;
            document.getElementById('transType').textContent = transType;
            document.getElementById('transReference').textContent = transReference;
            
            // Set transaction ID
            document.getElementById('allocateTransactionId').value = transactionId;
            
            // Extract numeric amount for allocation field
            const amountText = transAmount.replace(/[^\d.-]/g, '');
            const amountValue = parseFloat(amountText) || 0;
            
            // Set allocation amount
            document.getElementById('allocateAmount').value = amountValue;
            document.getElementById('expenseAllocateAmount').value = amountValue;
            document.getElementById('supplierAllocateAmount').value = amountValue;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('allocateModal'));
            modal.show();
        });
    });

    // Handle allocation type radio buttons
    document.querySelectorAll('input[name="allocation_option"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Hide all allocation fields
            document.getElementById('bookingFields').style.display = 'none';
            document.getElementById('expenseFields').style.display = 'none';
            document.getElementById('supplierFields').style.display = 'none';
            
            // Show selected allocation fields
            const selectedValue = this.value;
            if (selectedValue === 'booking') {
                document.getElementById('bookingFields').style.display = 'block';
            } else if (selectedValue === 'expense') {
                document.getElementById('expenseFields').style.display = 'block';
            } else if (selectedValue === 'supplier') {
                document.getElementById('supplierFields').style.display = 'block';
            }
            
            // Update hidden allocation type field
            document.getElementById('allocationType').value = selectedValue;
        });
    });

    // Handle booking selection to show outstanding amount
    document.getElementById('bookingSelect').addEventListener('change', function() {
        const bookingId = this.value;
        if (bookingId) {
            // Get outstanding amount from the booking data
            // For now, set a placeholder - you may need to fetch this via AJAX
            document.getElementById('outstandingAmount').value = '€1,649.00'; // Placeholder
        } else {
            document.getElementById('outstandingAmount').value = '';
        }
    });

    // Confirm Allocate
    document.getElementById('confirmAllocate').addEventListener('click', function() {
        const transactionId = document.getElementById('allocateTransactionId').value;
        const customerAccountId = document.getElementById('customerAccountSelect').value;
        
        if (!customerAccountId) {
            alert('Please select a customer account');
            return;
        }

        const formData = new FormData();
        formData.append('customer_account_id', customerAccountId);
        
        fetch('{{ route("admin.payment-pool.allocate", ":id") }}'.replace(':id', transactionId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload();
            } else if (data.errors) {
                let errors = '';
                for (let key in data.errors) {
                    errors += data.errors[key] + '\n';
                }
                alert(errors);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Deallocate
    document.querySelectorAll('.deallocate-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const transactionId = this.getAttribute('data-id');
            
            if (confirm('Are you sure you want to deallocate this transaction?')) {
                fetch('{{ route("admin.payment-pool.deallocate", ":id") }}'.replace(':id', transactionId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });

    // Delete Transaction
    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const transactionId = this.getAttribute('data-id');
            
            if (confirm('Are you sure you want to delete this transaction?')) {
                fetch('{{ route("admin.payment-pool.destroy", ":id") }}'.replace(':id', transactionId), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });

    // Create Expense
    document.getElementById('saveExpense').addEventListener('click', function() {
        const form = document.getElementById('createExpenseForm');
        const formData = new FormData(form);
        
        fetch('{{ route("admin.payment-pool.create-expense") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload();
            } else if (data.errors) {
                let errors = '';
                for (let key in data.errors) {
                    errors += data.errors[key] + '\n';
                }
                alert(errors);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Create Supplier Payment
    document.getElementById('saveSupplierPayment').addEventListener('click', function() {
        const form = document.getElementById('supplierPaymentForm');
        const formData = new FormData(form);
        
        fetch('{{ route("admin.payment-pool.create-supplier-payment") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload();
            } else if (data.errors) {
                let errors = '';
                for (let key in data.errors) {
                    errors += data.errors[key] + '\n';
                }
                alert(errors);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Add Split Row
    document.getElementById('addSplitRow').addEventListener('click', function() {
        const splitFields = document.getElementById('splitAllocationFields');
        const rowCount = splitFields.querySelectorAll('.split-row').length + 1;
        
        const newRow = document.createElement('div');
        newRow.className = 'form-group split-row';
        newRow.innerHTML = `
            <label>Customer Account ${rowCount}</label>
            <select class="form-control split-account" name="accounts[]" required>
                <option value="">Select Account</option>
                @foreach($customerAccounts as $account)
                    @if($account->admin)
                        <option value="{{ $account->admin->id }}">
                            {{ $account->admin->name ?? 'N/A' }} - {{ $account->acc_no }}
                        </option>
                    @endif
                @endforeach
            </select>
            <input type="number" step="0.01" class="form-control split-amount mt-2" name="amounts[]" placeholder="Amount" required>
            <button type="button" class="btn btn-sm btn-danger mt-2 remove-split-row">
                <i class="fa fa-trash"></i>
            </button>
        `;
        
        splitFields.appendChild(newRow);
        
        // Add remove functionality
        newRow.querySelector('.remove-split-row').addEventListener('click', function() {
            newRow.remove();
        });
    });

    // Split Allocation
    document.getElementById('confirmSplitAllocation').addEventListener('click', function() {
        const form = document.getElementById('splitAllocationForm');
        const formData = new FormData(form);
        
        fetch('{{ route("admin.payment-pool.split-allocation") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload();
            } else if (data.errors) {
                let errors = '';
                for (let key in data.errors) {
                    errors += data.errors[key] + '\n';
                }
                alert(errors);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

@endsection
