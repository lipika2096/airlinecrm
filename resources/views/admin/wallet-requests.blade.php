@extends('admin/layouts/head-main')
@section('content')

    <title>Wallet Requests</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Wallet Requests</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Wallet Requests</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                      </div>
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
                                    <th>User ID</th>
                                    <th>Payment Mode</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Bank Name</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($walletRequests as $walletRequest)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $walletRequest->user_id }}</td>
                                        <td>{{ $walletRequest->payment_mode }}</td>
                                        <td>{{ $walletRequest->amount }}</td>
                                        <td>{{ $walletRequest->date }}</td>
                                        <td>{{ $walletRequest->bank_name }}</td>
                                        <td>{{ $walletRequest->status }}</td>

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
