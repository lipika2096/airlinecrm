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
                        <h3 class="page-title">Fare Conditions</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Fare Conditions</li>
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

        <form action="{{ route('admin.fare_conditions.store') }}" method="POST">
            @csrf
            <div class="form-group">
            <label for="agent_id">Select Agent</label>
            <select  class="form-control" name="agent_id" id="agent_id">
                @foreach ($agents as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->first_name }} {{ $agent->last_name }}</option>
                @endforeach
            </select>
        </div>

            <div class="form-group">
                <label for="fare_condition_details">Fare Condition Details</label>
                <textarea name="fare_condition_details" id="editor1" rows="10" cols="80">
                {{ old('fare_condition_details') }}
    </textarea>
            </div>

            <div class="form-group">
                <label for="cancellation_policy">Cancellation Policy</label>
                <textarea name="cancellation_policy" class="form-control" id="editor2" required>{{ old('cancellation_policy') }}</textarea>
            </div>

            <div class="form-group">
                <label for="date_change_policy">Date Change Policy</label>
                <textarea name="date_change_policy" class="form-control" id="editor3" required>{{ old('date_change_policy') }}</textarea>
            </div>

            <div class="form-group">
                <label for="updated_by">Updated By</label>
                <input type="text" name="updated_by" class="form-control" value="{{ old('updated_by') }}" required>
            </div>

            <div class="form-group">
                <label for="effective_from_date">Effective From Date</label>
                <input type="date" name="effective_from_date" class="form-control" value="{{ old('effective_from_date') }}" required>
            </div>

            <div class="form-group">
                <label for="valid_till_date">Valid Till Date</label>
                <input type="date" name="valid_till_date" class="form-control" value="{{ old('valid_till_date') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    </div>
    </div>
    </div>
    </div>


    <script>
        CKEDITOR.replace('editor1');
        CKEDITOR.replace('editor2');
        CKEDITOR.replace('editor3');
    </script>


@endsection
