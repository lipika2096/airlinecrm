@extends('admin/layouts/head-main')
@section('content')


    <title>Fare Conditions</title>


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Commissions</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">commissions</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">



                    </div>
                </div>
            </div>
            <!-- /Page Header -->

    <script src="https://cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>

    <!--main wrapper-->
    <div id="main-wrapper" style="margin-top:50px;">


    <div class="container">


    <div class="card count-1" id="tickets-table-wrapper">
    <div class="card-body">

        <div class="table-responsive list-table-wrapper">


    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('admin.commissions.update', $commission->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="commission_rate">Commission Rate:</label>
            <input class="form-control" type="text" id="commission_rate" name="commissions_rate" value="{{ old('commissions_rate', $commission->commissions_rate) }}" required>
        </div>

        <div class="form-group">
            <label for="airline_id">Airline:</label>
            <select id="airline_id" name="airline_id" class="form-control" required>
                <option value="">Select Airline</option>
                @foreach ($airlines as $airline)
                    <option value="{{ $airline->id }}" {{ $commission->airline_id == $airline->id ? 'selected' : '' }}>{{ $airline->airline_code }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="agent_id">Agent:</label>
            <select id="agent_id" name="agent_id" class="form-control" required>
                <option value="">Select Agent</option>
                @foreach ($agents as $agent)
                    <option value="{{ $agent->id }}" {{ $commission->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->first_name }} {{ $agent->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection
