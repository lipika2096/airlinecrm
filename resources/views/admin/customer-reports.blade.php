@extends('admin/layouts/head-main')

@section('content')
    <title>Customer Reports</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Customer Reports</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customer Reports</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Filter Form -->
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('admin.customer-reports') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="agent_id">Select Customer</label>
                                <select name="customer_id" class="form-control" onchange="document.getElementById('report-form').submit()">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">
                                            {{ ucfirst($customer->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group" style="align-self: center; text-align: center;">
                                <label for="search"></label>
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Filter Form -->

            <!-- Results Table -->
            <div class="row">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Company Name</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Address</th>
                                            <th>Password</th>
                                            <th>Kyc Documents</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($searchedCustomer as $data)
                                            <tr>
                                                <td>{{ $data->getRoleNames()->implode(', ') }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->adminDetail->company_name ??'-' }}</td>
                                                <td>{{ $data->adminDetail->city ??'-'}}</td>
                                                <td>{{ $data->adminDetail->state??'-' }}</td>
                                                <td>{{ $data->adminDetail->country ??'-'}}</td>
                                                <td>{{ $data->adminDetail->address??'-' }}</td>
                                                <td>{{ $data->plain_password }}</td>
                                                <td>
                                                    @foreach($data->kycDocuments as $document)
                                                       <b>Document Name:</b> {{ $document->doc_name ?? '-' }}<br>

                                                       <b>File:</b>
                                                        @foreach (json_decode($document->doc_file, true) as $key => $file)
                                                            <li>({{ $key + 1 }}.) <a href="{{ $file }}" target="_blank">{{ basename($file) }}</a></li>
                                                        @endforeach<br>
                                                    @endforeach
                                                </td>
                                            </tr>
                            @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Results Table -->
        </div>
    </div>
@endsection
