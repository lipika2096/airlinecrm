@extends('admin/layouts/head-main')
@section('content')

    <title>Case History</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Case History</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Case History</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Filter Form -->
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="agent_id">Select Agent</label>
                                <select name="agent_id" class="form-control" onchange="document.getElementById('report-form').submit()">
                                    <option value="">Select Agent</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{$agent->id}}" {{ old('agent_id', $agent_id) == $agent->id ? 'selected' : '' }}>{{$agent->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="caseId">Case ID</label>
                                <input type="text" name="id" id="caseId" class="form-control" value="{{ old('id', $caseId) }}">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="pnr">PNR</label>
                                <input type="text" name="pnr" id="pnr" class="form-control" value="{{ old('pnr', $pnr) }}">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="ticket_no">Ticket No</label>
                                <input type="text" name="ticket_no" id="ticket_no" class="form-control" value="{{ old('ticket_no', $ticket_no) }}">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="status">Case Status</label>
                                <select name="case_status" id="status" class="form-control">
                                    <option value="">-- Select Status --</option>
                                    <option value="Opened" {{ old('case_status', $status) == 'Opened' ? 'selected' : '' }}>Opened</option>
                                    <option value="Closed" {{ old('case_status', $status) == 'Closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="Updated" {{ old('case_status', $status) == 'Updated' ? 'selected' : '' }}>Updated</option>
                                    <!-- Add more statuses as needed -->
                                </select>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="openDate">Case Opening Date</label>
                                <input type="date" name="case_opening_date" id="openDate" class="form-control" value="{{ old('case_opening_date', $openDate) }}">
                            </div>

                            <div class="col-md-2 form-group" style="align-self: center; text-align: center;">
                                <label for="search"></label>
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Search</button>
                            </div>                    
                        </div>
                    </form>
                </div>
            </div>

            <!-- Filter Form End -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Opening Date</th>
                                    <th>Opened By </th>
                                    <th>PNR</th>
                                    <th>Status</th>
                                    <th>Closed By</th>
                                    <th>Closed Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cases as $index => $case)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $case->case_opening_date }}</td>
                                        <td>{{ $case->opened_by }}</td>
                                        <td>{{ $case->pnr }}</td>
                                        <td>{{ $case->case_status }}</td>
                                        <td>{{ $case->case_closed_by }}</td>
                                        <td>{{ $case->case_closing_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- Page Content -->
    </div> <!-- Page Wrapper -->

@endsection