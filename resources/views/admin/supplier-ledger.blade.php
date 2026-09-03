@extends('admin/layouts/head-main')
@section('title', 'Supplier Ledger')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Supplier Ledger</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                        <li class="breadcrumb-item active">Supplier Ledger</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <!-- Filter Section -->
                        <div class="filter-section mb-4">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From Date:</label>
                                        <input type="date" class="form-control" id="fromDate" value="{{ request('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>To Date:</label>
                                        <input type="date" class="form-control" id="toDate" value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Supplier Name:</label>
                                        <input type="text" class="form-control" id="supplierFilter" value="{{ request('supplier_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-primary w-100" id="applyFilter">
                                            <i class="fa fa-search"></i> Apply Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(count($groupedLedger) > 0)
                            @foreach($groupedLedger as $supplierName => $supplierData)
                                <!-- Supplier Summary Card -->
                                <div class="supplier-summary mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $supplierName }}</h5>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="summary-item">
                                                        <label>Total Bills</label>
                                                        <p class="amount text-danger">€{{ number_format($supplierData['total_bills'], 2) }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="summary-item">
                                                        <label>Total Payments</label>
                                                        <p class="amount text-success">€{{ number_format($supplierData['total_payments'], 2) }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="summary-item">
                                                        <label>Balance Due</label>
                                                        <p class="amount {{ $supplierData['balance_due'] > 0 ? 'text-danger' : 'text-success' }}">
                                                            €{{ number_format($supplierData['balance_due'], 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Supplier Transactions Table -->
                                <div class="table-responsive mb-5">
                                    <table class="table table-striped custom-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Reference</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($supplierData['transactions'] as $transaction)
                                                <tr>
                                                    <td>{{ $transaction['date'] ? \Carbon\Carbon::parse($transaction['date'])->format('d/m/Y') : '-' }}</td>
                                                    <td>
                                                        <span class="badge {{ $transaction['type'] == 'Bill' ? 'bg-danger' : 'bg-success' }}">
                                                            {{ $transaction['type'] }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $transaction['reference'] }}</td>
                                                    <td class="text-danger">
                                                        {{ $transaction['debit'] > 0 ? number_format($transaction['debit'], 2) : '-' }}
                                                    </td>
                                                    <td class="text-success">
                                                        {{ $transaction['credit'] > 0 ? number_format($transaction['credit'], 2) : '-' }}
                                                    </td>
                                                    <td><strong>{{ number_format($transaction['balance'], 2) }}</strong></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <p class="text-muted">No supplier transactions found</p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->

<style>
    .filter-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
    }

    .supplier-summary {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .summary-item label {
        font-weight: 600;
        color: #555;
        margin-bottom: 5px;
    }

    .summary-item .amount {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }
</style>

<script>
    document.getElementById('applyFilter').addEventListener('click', function() {
        const fromDate = document.getElementById('fromDate').value;
        const toDate = document.getElementById('toDate').value;
        const supplierName = document.getElementById('supplierFilter').value;
        
        const params = new URLSearchParams();
        if (fromDate) params.append('from_date', fromDate);
        if (toDate) params.append('to_date', toDate);
        if (supplierName) params.append('supplier_name', supplierName);
        
        window.location.href = '{{ route('admin.supplier-ledger') }}?' + params.toString();
    });
</script>

@endsection
