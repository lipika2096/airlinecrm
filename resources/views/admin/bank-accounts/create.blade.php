@extends('admin/layouts/head-main')
@section('content')
    <title>Add Bank Account</title>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">My Bank Accounts</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.bank-accounts.index') }}">My Bank Accounts</a></li>
                            <li class="breadcrumb-item active">Add Bank Account</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Bank Account</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.bank-accounts.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Bank Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="bank_name" required placeholder="Enter Bank Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Account Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="account_name" required placeholder="Enter Account Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Account Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="account_number" required placeholder="Enter Account Number">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>IFSC Code</label>
                                        <input type="text" class="form-control" name="ifsc_code" placeholder="Enter IFSC Code">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control" name="branch_name" placeholder="Enter Branch Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Account Type <span class="text-danger">*</span></label>
                                        <select class="form-control" name="account_type" required>
                                            <option value="savings">Savings</option>
                                            <option value="current">Current</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Opening Balance <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control" name="opening_balance" required placeholder="Enter Opening Balance">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Notes</label>
                                        <textarea class="form-control" name="notes" rows="4" placeholder="Enter any additional notes"></textarea>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Add Bank Account</button>
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
