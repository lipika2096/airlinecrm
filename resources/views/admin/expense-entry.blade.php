@extends('admin/layouts/head-main')
@section('title', 'Expense Entry')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Expense Entry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                        <li class="breadcrumb-item active">Expense Entry</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.expense-entry') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Expense Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="expense_date" required value="{{ old('expense_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category <span class="text-danger">*</span></label>
                                        <select class="form-control" name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="Office Rent" {{ old('category') == 'Office Rent' ? 'selected' : '' }}>Office Rent</option>
                                            <option value="Office Supplies" {{ old('category') == 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
                                            <option value="Utilities" {{ old('category') == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                                            <option value="Travel" {{ old('category') == 'Travel' ? 'selected' : '' }}>Travel</option>
                                            <option value="Marketing" {{ old('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                            <option value="Salary" {{ old('category') == 'Salary' ? 'selected' : '' }}>Salary</option>
                                            <option value="Software" {{ old('category') == 'Software' ? 'selected' : '' }}>Software</option>
                                            <option value="Insurance" {{ old('category') == 'Insurance' ? 'selected' : '' }}>Insurance</option>
                                            <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Paid From <span class="text-danger">*</span></label>
                                        <select class="form-control" name="paid_from" required>
                                            <option value="">Select Account</option>
                                            <option value="Bank - Sparkasse" {{ old('paid_from') == 'Bank - Sparkasse' ? 'selected' : '' }}>Bank - Sparkasse</option>
                                            <option value="Bank - Deutsche Bank" {{ old('paid_from') == 'Bank - Deutsche Bank' ? 'selected' : '' }}>Bank - Deutsche Bank</option>
                                            <option value="Cash" {{ old('paid_from') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="Credit Card" {{ old('paid_from') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount (EUR) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control" name="amount" id="amount" required value="{{ old('amount') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>VAT Rate (%)</label>
                                        <select class="form-control" name="vat_rate" id="vatRate">
                                            <option value="0" {{ old('vat_rate') == 0 ? 'selected' : '' }}>0%</option>
                                            <option value="7" {{ old('vat_rate') == 7 ? 'selected' : '' }}>7%</option>
                                            <option value="19" {{ old('vat_rate') == 19 ? 'selected' : '' }}>19%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>VAT Amount (EUR)</label>
                                        <input type="number" step="0.01" class="form-control" name="vat_amount" id="vatAmount" readonly value="{{ old('vat_amount') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Receipt Upload</label>
                                <input type="file" class="form-control" name="receipt" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Accepted formats: PDF, JPG, JPEG, PNG (Max 2MB)</small>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Expense
                                </button>
                                <a href="{{ route('admin.expense-entry') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Clear
                                </a>
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

<script>
    // Calculate VAT amount automatically
    document.getElementById('vatRate').addEventListener('change', function() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const vatRate = parseFloat(this.value) || 0;
        const vatAmount = (amount * vatRate) / 100;
        document.getElementById('vatAmount').value = vatAmount.toFixed(2);
    });

    document.getElementById('amount').addEventListener('input', function() {
        const amount = parseFloat(this.value) || 0;
        const vatRate = parseFloat(document.getElementById('vatRate').value) || 0;
        const vatAmount = (amount * vatRate) / 100;
        document.getElementById('vatAmount').value = vatAmount.toFixed(2);
    });
</script>

@endsection
