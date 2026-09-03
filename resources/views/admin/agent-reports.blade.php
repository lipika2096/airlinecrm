@extends('admin/layouts/head-main')

@section('content')
    <title>Agent Reports</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Agent Reports</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Agent Reports</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Filter Form -->
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('admin.agent-reports') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="agent_id">Select Agent</label>
                                <select name="agent_id" class="form-control" onchange="document.getElementById('report-form').submit()">
                                    <option value="">Select Agent</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}">
                                            {{ ucfirst($agent->company_name) }}
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
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Airline Logo</th>
                                    <th>Airline Name</th>
                                    <th>Airline Code</th>
                                    <th>Account Report</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($specialFares as $index => $specialFare)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <img src="{{ asset($specialFare->airline->logo_path) }}"
                                                alt="{{ $specialFare->airline->airline_name }}"
                                                style="max-width: 100px; max-height: 100px;">
                                        </td>
                                        <td>{{ $specialFare->airline->airline_name }}</td>
                                        <td>{{ $specialFare->airline->airline_name }}</td>
                                        <td><a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#account_report{{$agent_id}}">Account Report</a></td>
                                        <!-- View account Modal -->
                                        <div class="modal custom-modal fade" id="account_report{{$agent_id}}" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> Account Report </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <!-- {{$agent_account_detail}} -->
                                                                    <div class="form-group">
                                                                        <label>Account No. <span class="text-danger">*</span></label>
                                                                        <input type="text" name="acc_no" class="form-control" value="{{$agent_account_detail->acc_no??'null'}}" disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>IFSC Code <span class="text-danger">*</span></label>
                                                                        <input type="text" name="ifsc_code" class="form-control" value="{{$agent_account_detail->ifsc_code??'null'}}" disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>MISC Code <span class="text-danger">*</span></label>
                                                                        <input type="text" name="misc_code" class="form-control" value="{{$agent_account_detail->misc_code??'null'}}" disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Booking Id <span class="text-danger">*</span></label>
                                                                        <input type="text" name="booking_id" class="form-control" value="{{$agent_account_detail->booking_id??'null'}}" disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>PNR <span class="text-danger">*</span></label>
                                                                        <input type="text" name="pnr" class="form-control" value="{{$agent_account_detail->pnr??'null'}}" disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Ticket No. <span class="text-danger">*</span></label>
                                                                        <input type="text" name="ticket_no" class="form-control" value="{{$agent_account_detail->ticket_no??'null'}}" disabled />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Add account Modal -->
                                        <td class="text-end">
                                            <div class="action-icons">
                                                <a href="{{ route('admin.agent.view', ['id' => $specialFare->agent_id]) }}" class="action-icon"><i class="fa fa-eye"></i></a>
                                                <a id="print-account" onclick="window.print()">
                                                    <i class="fa fa-print fa-lg"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Results Table -->
        </div>
    </div>
@endsection
