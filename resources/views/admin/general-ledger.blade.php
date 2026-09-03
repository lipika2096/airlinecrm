@extends('admin/layouts/head-main')
@section('title', 'General Ledger')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">General Ledger</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                        <li class="breadcrumb-item active">General Ledger</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <!-- Date Filter Section -->
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
                                        <label>Customer:</label>
                                        <select class="form-control" id="customerFilter">
                                            <option value="">All Customers</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
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

                        <!-- General Ledger Table -->
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Account</th>
                                        <th>Ref</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($ledgerEntries) > 0)
                                        @foreach($ledgerEntries as $entry)
                                            <tr>
                                                <td>{{ $entry['date'] ? \Carbon\Carbon::parse($entry['date'])->format('d/m/Y') : '-' }}</td>
                                                <td>{{ $entry['account'] }}</td>
                                                <td>{{ $entry['ref'] }}</td>
                                                <td class="text-danger">
                                                    {{ $entry['debit'] > 0 ? number_format($entry['debit'], 2) : '-' }}
                                                </td>
                                                <td class="text-success">
                                                    {{ $entry['credit'] > 0 ? number_format($entry['credit'], 2) : '-' }}
                                                </td>
                                                <td><strong>{{ number_format($entry['balance'], 2) }}</strong></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No ledger entries found</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="table-primary">
                                        <td colspan="3"><strong>Total</strong></td>
                                        <td class="text-danger"><strong>€{{ number_format($totalDebit, 2) }}</strong></td>
                                        <td class="text-success"><strong>€{{ number_format($totalCredit, 2) }}</strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
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

<style>
    .filter-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
    }
</style>

<script>
    document.getElementById('applyFilter').addEventListener('click', function() {
        const fromDate = document.getElementById('fromDate').value;
        const toDate = document.getElementById('toDate').value;
        const customerId = document.getElementById('customerFilter').value;
        
        const params = new URLSearchParams();
        if (fromDate) params.append('from_date', fromDate);
        if (toDate) params.append('to_date', toDate);
        if (customerId) params.append('customer_id', customerId);
        
        window.location.href = '{{ route('admin.general-ledger') }}?' + params.toString();
    });
</script>

@endsection
