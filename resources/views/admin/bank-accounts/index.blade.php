@extends('admin/layouts/head-main')
@section('content')
    <title>My Bank Accounts</title>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">My Bank Accounts</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Bank Accounts</li>
                        </ul>
                    </div>
                    <div class="col-auto text-end">
                        <a href="{{ route('admin.bank-accounts.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add Bank Account
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Bank Name</th>
                                            <th>Account Name</th>
                                            <th>Account Number</th>
                                            <th>IFSC Code</th>
                                            <th>Branch</th>
                                            <th>Type</th>
                                            <th>Opening Balance</th>
                                            <th>Current Balance</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bankAccounts as $bankAccount)
                                            <tr>
                                                <td>{{ $bankAccount->bank_name }}</td>
                                                <td>{{ $bankAccount->account_name }}</td>
                                                <td>{{ $bankAccount->account_number }}</td>
                                                <td>{{ $bankAccount->ifsc_code ?? '-' }}</td>
                                                <td>{{ $bankAccount->branch_name ?? '-' }}</td>
                                                <td>{{ ucfirst($bankAccount->account_type) }}</td>
                                                <td>${{ number_format($bankAccount->opening_balance, 2) }}</td>
                                                <td>${{ number_format($bankAccount->current_balance, 2) }}</td>
                                                <td>
                                                    @if($bankAccount->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.bank-accounts.edit', $bankAccount->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.bank-accounts.toggle-status', $bankAccount->id) }}" class="btn btn-sm {{ $bankAccount->is_active ? 'btn-warning' : 'btn-success' }}">
                                                        <i class="fa {{ $bankAccount->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                                    </a>
                                                    <form action="{{ route('admin.bank-accounts.destroy', $bankAccount->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this bank account?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
