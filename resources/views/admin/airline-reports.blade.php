@extends('admin/layouts/head-main')

@section('content')
    <title>Airline Reports</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Airline Reports</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Airline Reports</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Filter Form -->
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('admin.airline-reports') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="airline_id">Select Airline</label>
                                <select name="airline_id" class="form-control" onchange="document.getElementById('report-form').submit()">
                                    <option value="">Select Airline</option>
                                    @foreach($airlines as $airline)
                                        <option value="{{ $airline->id }}">
                                            {{ ucfirst($airline->airline_name) }}
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
                        <table class="table table-striped custom-table mb-0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Airline</th>
                                    <th>Name</th>
                                    <th>Brand Name</th>
                                    <th>Group</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($specialFares as $index => $specialFare)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $specialFare->airline->airline_name ?? 'Null' }}</td>
                                        <td>{{ $specialFare->agent->company_name }} {{ $specialFare->agent->last_name }}</td>
                                        <td>{{ $specialFare->agent->owner_name }}</td>
                                        <td>{{ $specialFare->agent->agency_name }}</td>
                                        <td class="text-end">
                                            <div class="action-icons">
                                                <a href="{{route('admin.agent.view', ['id' => $specialFare->agent->id])}}" class="action-icon"><i class="fa fa-eye"></i></a>
                                                <a class="btn btn-white" id="print-account" onclick="window.print()">
                                                    <i class="fa fa-print fa-lg"></i> Print
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Results Table -->
        </div>
    </div>
@endsection
