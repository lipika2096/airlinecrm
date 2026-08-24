@extends('admin/layouts/head-main')
@section('title', 'View Accounts')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Accounts</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Accounts</li>
                    </ul>
                </div>
                <!-- <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_accounts"><i class="fa fa-plus"></i> Add Accounts</a>
                </div> -->
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Account Number</th>
                                <th>IFSC Code</th>
                                <th>MISC Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $index => $account)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $account->admin->name }}</td>
                                <td>{{ $account->acc_no }}</td>
                                <td>{{ $account->ifsc_code }}</td>
                                <td>{{ $account->misc_code }}</td>
                                <td>
                                    <a href="{{route('admin.customer.account.invoice',$account->id)}}" class="btn btn-primary">View Account Statement</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->

@endsection
