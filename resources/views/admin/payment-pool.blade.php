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
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
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
                                                <td>{{ $transaction->admin->name ?? 'N/A' }}</td>
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
                                                    @elseif($transaction->payment_pool == 'allocated' && $transaction->allocatedToCustomerAccount)
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
                <h5 class="modal-title">Allocate to Customer Account</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="allocateForm">
                    @csrf
                    <input type="hidden" name="transaction_id" id="allocateTransactionId">
                    <div class="form-group">
                        <label>Select Customer Account</label>
                        <select class="form-control" name="customer_account_id" id="customerAccountSelect" required>
                            <option value="">Select Account</option>
                            @foreach($customerAccounts as $account)
                                <option value="{{ $account->admin->id }}">
                                    {{ $account->admin->name ?? 'N/A' }} - {{ $account->acc_no }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmAllocate">Allocate</button>
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
            document.getElementById('allocateTransactionId').value = transactionId;
            const modal = new bootstrap.Modal(document.getElementById('allocateModal'));
            modal.show();
        });
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
</script>

@endsection
