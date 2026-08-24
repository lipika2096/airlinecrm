@extends('admin/layouts/head-main')
@section('content')
    <title>Airlines</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .profile-widget .user-name {
                color: #333333;
                margin-top: 30px !important;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Airline Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Airline Details</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_airline"><i
                                class="fa fa-plus"></i> Add Airline</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">

                        <table class="table table-striped custom-table mb-0 datatable">
                            <tr>
                                <th>Airline Logo</th>
                                <th>Airline Name</th>
                                <th>Airline Code</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($airlineDetails as $detail)
                                    <tr>
                                        <td>
                                            <img src="{{ asset($detail->airline->logo_path) }}"
                                                alt="{{ $detail->airline->name }}"
                                                style="max-width: 100px; max-height: 100px;">

                                        </td>
                                        <td>{{ $detail->airline->airline_name }}</td>
                                        <td>{{ $detail->airline->airline_code }}</td>
                                        <td>
                                            <div class="action-icons">
                                                <a href="#" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#view_modal_{{ $detail->id }}"
                                                    style="margin-right: 10px;">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <a href="#" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#edit_modal_{{ $detail->id }}"
                                                    style="margin-right: 10px;">
                                                    <i class="fa fa-pencil"></i>
                                                </a>



                                                <a href="#" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal_{{ $detail->id }}"
                                                    style="margin-right: 10px;">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- Repeat for other agents -->
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->

    <div id="add_airline" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Airline</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.airlines-details.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="airline_name">Airline Name</label>
                                    <input type="text" class="form-control" id="airline_name" name="airline_name"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" id="country" name="country" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="founded_on">Founded On</label>
                                    <input type="date" class="form-control" id="founded_on" name="founded_on" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="commenced_on">Commenced On</label>
                                    <input type="date" class="form-control" id="commenced_on" name="commenced_on"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hubs">Hubs</label>
                                    <input type="text" class="form-control" id="hubs" name="hubs" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="secondary_hub">Secondary Hub</label>
                                    <input type="text" class="form-control" id="secondary_hub" name="secondary_hub">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="focus_cities">Focus Cities</label>
                                    <input type="text" class="form-control" id="focus_cities" name="focus_cities[]"
                                        placeholder="Enter focus cities separated by commas">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="frequent_flyer_program">Frequent Flyer Program</label>
                                    <input type="text" class="form-control" id="frequent_flyer_program"
                                        name="frequent_flyer_program" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alliance">Alliance</label>
                                    <input type="text" class="form-control" id="alliance" name="alliance" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subsidiaries">Subsidiaries</label>
                                    <input type="text" class="form-control" id="subsidiaries" name="subsidiaries">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fleet_size">Fleet Size</label>
                                    <input type="number" class="form-control" id="fleet_size" name="fleet_size"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="destinations">Destinations</label>
                                    <input type="text" class="form-control" id="destinations" name="destinations"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slogan">Slogan</label>
                                    <input type="text" class="form-control" id="slogan" name="slogan" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($airlineDetails as $detail)
        <div id="view_modal_{{ $detail->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Airline Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Column 1 -->
                            <div class="col-md-6">
                                <p><strong>Airline Name:</strong> {{ $detail->airline->airline_name }}</p>
                                <p><strong>Airline Code:</strong> {{ $detail->airline_ticketing_code }}</p>
                                <p><strong>Contact Details:</strong> {{ $detail->airline_contact_details }}</p>
                                <p><strong>Rules Do:</strong> {{ $detail->rules_do }}</p>
                                <p><strong>Routes Flown From:</strong> {{ $detail->routes_flown_from }}</p>
                            </div>
                            <!-- Column 2 -->
                            <div class="col-md-6">
                                <p><strong>Rules Don't:</strong> {{ $detail->rules_dont }}</p>
                                <p><strong>Standard Cancellation Charges:</strong>
                                    {{ $detail->standard_cancellation_charges }}</p>
                                <p><strong>Date Change Charges:</strong> {{ $detail->date_change_charges }}</p>
                                <p><strong>Routes Flown To:</strong> {{ $detail->routes_flown_to }}</p>
                                <!-- Optional: Add the logo in this column or adjust as needed -->
                                <img src="{{ asset($detail->airline->logo_path) }}" alt="{{ $detail->airline->name }}"
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    @foreach ($airlineDetails as $detail)
        <div id="edit_modal_{{ $detail->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Airline Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="airline_id">Airline</label>
                                        <select class="form-control" id="airline_id" name="airline_id" required>
                                            @foreach ($airlines as $airline)
                                                <option value="{{ $airline->id }}"
                                                    {{ $detail->airline_id == $airline->id ? 'selected' : '' }}>
                                                    {{ $airline->airline_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="airline_ticketing_code">Airline Ticketing Code</label>
                                        <input type="text" class="form-control" id="airline_ticketing_code"
                                            name="airline_ticketing_code"
                                            value="{{ old('airline_ticketing_code', $detail->airline_ticketing_code) }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="airline_contact_details">Airline Contact Details</label>
                                        <input type="text" class="form-control" id="airline_contact_details"
                                            name="airline_contact_details"
                                            value="{{ old('airline_contact_details', $detail->airline_contact_details) }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="rules_do">Rules Do</label>
                                        <input type="text" class="form-control" id="rules_do" name="rules_do"
                                            value="{{ old('rules_do', $detail->rules_do) }}" required>
                                    </div>
                                </div>
                                <!-- Column 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rules_dont">Rules Don't</label>
                                        <input type="text" class="form-control" id="rules_dont" name="rules_dont"
                                            value="{{ old('rules_dont', $detail->rules_dont) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="standard_cancellation_charges">Standard Cancellation Charges</label>
                                        <input type="text" class="form-control" id="standard_cancellation_charges"
                                            name="standard_cancellation_charges"
                                            value="{{ old('standard_cancellation_charges', $detail->standard_cancellation_charges) }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_change_charges">Date Change Charges</label>
                                        <input type="text" class="form-control" id="date_change_charges"
                                            name="date_change_charges"
                                            value="{{ old('date_change_charges', $detail->date_change_charges) }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="routes_flown_from">Routes Flown From</label>
                                        <input type="text" class="form-control" id="routes_flown_from"
                                            name="routes_flown_from"
                                            value="{{ old('routes_flown_from', $detail->routes_flown_from) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="routes_flown_to">Routes Flown To</label>
                                        <input type="text" class="form-control" id="routes_flown_to"
                                            name="routes_flown_to"
                                            value="{{ old('routes_flown_to', $detail->routes_flown_to) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($airlineDetails as $detail)
        <div id="delete_modal_{{ $detail->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Airline Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.airlines-details.destroy', $detail->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this?');">
                            @csrf
                            @method('DELETE')
                            <p>Are you sure you want to delete the details for
                                <strong>{{ $detail->airline->name }}</strong>?
                            </p>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
