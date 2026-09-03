@extends('admin/layouts/head-main')
@section('content')
    <title>Edit Bank Account</title>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">My Bank Accounts</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.bank-accounts.index') }}">My Bank Accounts</a></li>
                            <li class="breadcrumb-item active">Edit Bank Account</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Bank Account</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.bank-accounts.update', $bankAccount->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Bank Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="bank_name" required value="{{ $bankAccount->bank_name }}" placeholder="Enter Bank Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Account Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="account_name" required value="{{ $bankAccount->account_name }}" placeholder="Enter Account Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Account Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="account_number" required value="{{ $bankAccount->account_number }}" placeholder="Enter Account Number">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>IFSC Code</label>
                                        <input type="text" class="form-control" name="ifsc_code" value="{{ $bankAccount->ifsc_code ?? '' }}" placeholder="Enter IFSC Code">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control" name="branch_name" value="{{ $bankAccount->branch_name ?? '' }}" placeholder="Enter Branch Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Account Type <span class="text-danger">*</span></label>
                                        <select class="form-control" name="account_type" required>
                                            <option value="savings" {{ $bankAccount->account_type == 'savings' ? 'selected' : '' }}>Savings</option>
                                            <option value="current" {{ $bankAccount->account_type == 'current' ? 'selected' : '' }}>Current</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Notes</label>
                                        <textarea class="form-control" name="notes" rows="4" placeholder="Enter any additional notes">{{ $bankAccount->notes ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Update Bank Account</button>
                                    <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
