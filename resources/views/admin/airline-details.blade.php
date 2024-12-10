@extends('admin/layouts/head-main')
@section('content')
    <title>Designations</title>

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
                    @if (!request()->is('admin/deleted/airlines'))
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
                    @else
                        <div class="col">
                            <h3 class="page-title">Airline Details</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Airline Details</li>
                                <li class="breadcrumb-item active">Deleted Airline Details</li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">

                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
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
                                                alt="{{ $detail->airline->airline_name }}"
                                                style="max-width: 100px; max-height: 100px;">
                                        </td>
                                        <td>{{ $detail->airline->airline_name }}</td>
                                        <td>{{ $detail->airline->airline_code }}</td>
                                        <td>
                                            <div class="action-icons">
                                                <a href="{{ route('admin.airlines.view', ['id' => $detail->airline_id]) }}"
                                                    class="action-icon" style="margin-right: 10px;">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if (!request()->is('admin/deleted/airlines'))
                                                    <a data-bs-toggle="modal" data-bs-target="#edit_airline{{ $detail->id }}"
                                                        class="action-icon" style="margin-right: 10px;">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a data-bs-toggle="modal" data-bs-target="#delete_airline{{$detail->id}}" class="action-icon" style="margin-right: 10px;">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <div id="edit_airline{{ $detail->id }}" class="modal custom-modal fade"
                                        role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Airline</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ route('admin.airlines-details.update', ['airlineDetail' => $detail->id]) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="airline_name">Airline Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="airline_name" name="airline_name"
                                                                        value="{{ $detail->airline->airline_name }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="airline_code">Airline Code</label>
                                                                    <input type="text" class="form-control"
                                                                        id="airline_code" name="airline_code"
                                                                        value="{{ $detail->airline->airline_code }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="country">Country</label>
                                                                    <input type="text" class="form-control"
                                                                        id="country" name="country"
                                                                        value="{{ $detail->country }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="founded_on">Founded On</label>
                                                                    <input type="date" class="form-control"
                                                                        id="founded_on" name="founded_on"
                                                                        value="{{ $detail->founded_on }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="commenced_on">Commenced On</label>
                                                                    <input type="date" class="form-control"
                                                                        id="commenced_on" name="commenced_on"
                                                                        value="{{ $detail->commenced_on }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="hubs">Hubs</label>
                                                                    <input type="text" class="form-control"
                                                                        id="hubs" name="hubs"
                                                                        value="{{ $detail->hubs }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="secondary_hub">Secondary Hub</label>
                                                                    <input type="text" class="form-control"
                                                                        id="secondary_hub" name="secondary_hub"
                                                                        value="{{ $detail->secondary_hubs }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="focus_cities">Focus Cities</label>
                                                                    <input type="text" class="form-control"
                                                                        id="focus_cities" name="focus_cities[]"
                                                                        value="@foreach (json_decode($detail->focus_cities) as $fc){{ $fc }}<br> @endforeach"
                                                                        placeholder="Enter focus cities separated by commas">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="frequent_flyer_program">Frequent Flyer
                                                                        Program</label>
                                                                    <input type="text" class="form-control"
                                                                        id="frequent_flyer_program"
                                                                        name="frequent_flyer_program"
                                                                        value="{{ $detail->frequent_flyer_program }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="alliance">Alliance</label>
                                                                    <input type="text" class="form-control"
                                                                        id="alliance" name="alliance"
                                                                        value="{{ $detail->alliance }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="subsidiaries">Subsidiaries</label>
                                                                    <input type="text" class="form-control"
                                                                        id="subsidiaries" name="subsidiaries"
                                                                        value="{{ $detail->subsidiaries }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="fleet_size">Fleet Size</label>
                                                                    <input type="number" class="form-control"
                                                                        id="fleet_size" name="fleet_size"
                                                                        value="{{ $detail->fleet_size }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="destinations">Destinations</label>
                                                                    <input type="text" class="form-control"
                                                                        id="destinations" name="destinations"
                                                                        value="{{ $detail->destinations }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="slogan">Slogan</label>
                                                                    <input type="text" class="form-control"
                                                                        id="slogan" name="slogan"
                                                                        value="{{ $detail->slogan }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="logo">Logo</label>
                                                                    <input type="file" class="form-control"
                                                                        id="logo" name="logo">
                                                                    <img style="height:50px; width:50px;"
                                                                        src="{{ asset($detail->airline->logo_path) }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="key_people">Key People</label>
                                                                    <input type="text" class="form-control"
                                                                        id="key_people" name="key_people"
                                                                        value="{{ old('key_people', $detail->key_people) }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="parent_company">Parent Company</label>
                                                                    <input type="text" class="form-control"
                                                                        id="parent_company" name="parent_company"
                                                                        value="{{ old('parent_company', $detail->parent_company) }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="head_quarters">Headquarters</label>
                                                                    <input type="text" class="form-control"
                                                                        id="head_quarters" name="head_quarters"
                                                                        value="{{ old('head_quarters', $detail->head_quarters) }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="website">Website</label>
                                                                    <input type="text" class="form-control"
                                                                        id="website" name="website"
                                                                        value="{{ old('website', $detail->website) }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="IATA">IATA</label>
                                                                    <input type="text" class="form-control"
                                                                        id="IATA" name="IATA"
                                                                        value="{{ old('IATA', $detail->IATA) }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="ICAO">ICAO</label>
                                                                    <input type="text" class="form-control"
                                                                        id="ICAO" name="ICAO"
                                                                        value="{{ old('ICAO', $detail->ICAO) }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="callsign">Callsign</label>
                                                                    <input type="text" class="form-control"
                                                                        id="callsign" name="callsign"
                                                                        value="{{ old('callsign', $detail->callsign) }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="numeric_code">Numeric Code</label>
                                                                    <input type="number" class="form-control"
                                                                        id="numeric_code" name="numeric_code"
                                                                        value="{{ old('numeric_code', $detail->numeric_code) }}">
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


                                    <!-- Delete Airline Modal -->
                                    <div id="delete_airline{{$detail->id}}" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Airline</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('admin.airlines-details.delete',$detail->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <p>Are you sure you want to delete
                                                            <strong>{{$detail->airline->airline_name}}</strong>  Airline?
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
                                    <!-- /Delete Airline Modal -->
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
                    <form action="{{ route('admin.airlines-details.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="airline_name">Airline Name</label>
                                    <input type="text" class="form-control" id="airline_name" name="airline_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="airline_code">Airline Code</label>
                                    <input type="text" class="form-control" id="airline_code" name="airline_code">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" id="country" name="country">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="founded_on">Founded On</label>
                                    <input type="date" class="form-control" id="founded_on" name="founded_on">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="commenced_on">Commenced On</label>
                                    <input type="date" class="form-control" id="commenced_on" name="commenced_on">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hubs">Hubs</label>
                                    <input type="text" class="form-control" id="hubs" name="hubs">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="secondary_hub">Secondary Hub</label>
                                    <input type="text" class="form-control" id="secondary_hub" name="secondary_hub">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="focus_cities">Focus Cities</label>
                                    <div id="focus-destinations-container">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="focus_cities[]"
                                                placeholder="Enter focus cities">
                                            <button class="btn btn-danger remove-destination"
                                                type="button">Remove</button>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="button" id="add-destination">Add More</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="frequent_flyer_program">Frequent Flyer Program</label>
                                    <input type="text" class="form-control" id="frequent_flyer_program"
                                        name="frequent_flyer_program">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alliance">Alliance</label>
                                    <input type="text" class="form-control" id="alliance" name="alliance">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subsidiaries">Subsidiaries</label>
                                    <input type="text" class="form-control" id="subsidiaries" name="subsidiaries">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fleet_size">Fleet Size</label>
                                    <input type="number" class="form-control" id="fleet_size" name="fleet_size">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="destinations">Destinations</label>
                                    <input type="text" class="form-control" id="destinations" name="destinations">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slogan">Slogan</label>
                                    <input type="text" class="form-control" id="slogan" name="slogan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="key_people">Key People</label>
                                    <input type="text" class="form-control" id="key_people" name="key_people">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_company">Parent Company</label>
                                    <input type="text" class="form-control" id="parent_company"
                                        name="parent_company">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="head_quarters">Head Quarters</label>
                                    <input type="text" class="form-control" id="head_quarters" name="head_quarters">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Website">Website</label>
                                    <input type="text" class="form-control" id="website" name="website">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="IATA">IATA Code</label>
                                    <input type="text" class="form-control" id="IATA" name="IATA">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ICAO">ICAO Code</label>
                                    <input type="text" class="form-control" id="ICAO" name="ICAO">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="callsign">Callsign</label>
                                    <input type="text" class="form-control" id="callsign" name="callsign">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numeric_code">Numeric Code</label>
                                    <input type="number" class="form-control" id="numeric_code" name="numeric_code">
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
                        <form action="{{ route('admin.airlines-details.update', $detail->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="airline_id">Airline</label>
                                        <select class="form-control" id="airline_id" name="airline_id">
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
                                            value="{{ old('airline_ticketing_code', $detail->airline_ticketing_code) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="airline_contact_details">Airline Contact Details</label>
                                        <input type="text" class="form-control" id="airline_contact_details"
                                            name="airline_contact_details"
                                            value="{{ old('airline_contact_details', $detail->airline_contact_details) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="rules_do">Rules Do</label>
                                        <input type="text" class="form-control" id="rules_do" name="rules_do"
                                            value="{{ old('rules_do', $detail->rules_do) }}">
                                    </div>
                                </div>
                                <!-- Column 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rules_dont">Rules Don't</label>
                                        <input type="text" class="form-control" id="rules_dont" name="rules_dont"
                                            value="{{ old('rules_dont', $detail->rules_dont) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="standard_cancellation_charges">Standard Cancellation
                                            Charges</label>
                                        <input type="text" class="form-control" id="standard_cancellation_charges"
                                            name="standard_cancellation_charges"
                                            value="{{ old('standard_cancellation_charges', $detail->standard_cancellation_charges) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="date_change_charges">Date Change Charges</label>
                                        <input type="text" class="form-control" id="date_change_charges"
                                            name="date_change_charges"
                                            value="{{ old('date_change_charges', $detail->date_change_charges) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="routes_flown_from">Routes Flown From</label>
                                        <input type="text" class="form-control" id="routes_flown_from"
                                            name="routes_flown_from"
                                            value="{{ old('routes_flown_from', $detail->routes_flown_from) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="routes_flown_to">Routes Flown To</label>
                                        <input type="text" class="form-control" id="routes_flown_to"
                                            name="routes_flown_to"
                                            value="{{ old('routes_flown_to', $detail->routes_flown_to) }}">
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

    <script>
        document.getElementById('add-destination').addEventListener('click', function() {
            const container = document.getElementById('focus-destinations-container');
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-2');
            newInputGroup.innerHTML = `
                <input type="text" class="form-control" name="focus_cities[]" placeholder="Enter focus cities separated by commas">
                <button class="btn btn-danger remove-destination" type="button">Remove</button>
            `;
            container.appendChild(newInputGroup);

            // Add event listener to the remove button
            newInputGroup.querySelector('.remove-destination').addEventListener('click', function() {
                container.removeChild(newInputGroup);
            });
        });
    </script>
@endsection
