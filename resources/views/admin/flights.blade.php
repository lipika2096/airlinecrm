@extends('admin/layouts/head-main')
@section('content')
    <title>Designations</title>


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Flights Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Flight Details</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#addFlightModal"><i
                                class="fa fa-plus"></i> Add Flight</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <table class="table table-striped custom-table mb-0 datatable">
                <thead>
                    <tr>
                        <th>Flight No</th>
                        <th>Airline</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Departure Time</th>
                        <th>Arrival Time</th>
                        <th>Available Seats</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($flights as $flight)
                        <tr>
                            <td>{{ $flight->flight_no }}</td>
                            <td>{{ $flight->airline->name ?? 'N/A' }}</td>
                            <td>{{ $flight->origin->name ?? 'N/A' }}</td>
                            <td>{{ $flight->destination->name ?? 'N/A' }}</td>
                            <td>{{ $flight->departure_time }}</td>
                            <td>{{ $flight->arrival_time }}</td>
                            <td>{{ $flight->available_seats }}</td>
                            <td>
                                <div class="action-icons">
                                    <a href="#" class="action-icon" data-bs-toggle="modal"
                                        data-bs-target="#edit_airline{{ $flight->id }}" style="margin-right: 10px;"><i
                                            class="fa fa-pencil"></i> </a>

                                    <form action="{{ route('admin.flights.destroy', $flight->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-icon"
                                            style="border:none;background:none;padding:0;color:inherit; "><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                            </td>
                        </tr>

                        <!-- Edit Flight Modal -->
                        <div id="edit_airline{{ $flight->id }}" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Flight</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.flights.update', $flight->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group">
                                                <label for="flight_no">Flight No</label>
                                                <input type="text" class="form-control" id="flight_no" name="flight_no"
                                                    value="{{ old('flight_no', $flight->flight_no) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="airline_id">Airline</label>
                                                <select name="airline_id" class="form-control" required>
                                                    <option value="">Select Airline</option>
                                                    @foreach ($airlines as $airline)
                                                        <option value="{{ $airline->id }}"
                                                            {{ (old('airline_id') ?? $flight->airline_id) == $airline->id ? 'selected' : '' }}>
                                                            {{ $airline->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="origin_id">Origin</label>
                                                <select name="origin_id" class="form-control" required>
                                                    <option value="">Select Origin</option>
                                                    @foreach ($sectors as $sector)
                                                        <option value="{{ $sector->id }}"
                                                            {{ (old('origin_id') ?? $flight->origin_id) == $sector->id ? 'selected' : '' }}>
                                                            {{ $sector->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="destination_id">Destination</label>
                                                <select name="destination_id" class="form-control" required>
                                                    <option value="">Select Destination</option>
                                                    @foreach ($sectors as $sector)
                                                        <option value="{{ $sector->id }}"
                                                            {{ (old('destination_id') ?? $flight->destination_id) == $sector->id ? 'selected' : '' }}>
                                                            {{ $sector->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="departure_time">Departure Time</label>
                                                <input type="datetime-local" class="form-control" id="departure_time"
                                                    name="departure_time"
                                                    value="{{ old('departure_time', $flight->departure_time) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="arrival_time">Arrival Time</label>
                                                <input type="datetime-local" class="form-control" id="arrival_time"
                                                    name="arrival_time"
                                                    value="{{ old('arrival_time', $flight->arrival_time) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="available_seats">Available Seats</label>
                                                <input type="number" class="form-control" id="available_seats"
                                                    name="available_seats"
                                                    value="{{ old('available_seats', $flight->available_seats) }}"
                                                    required>
                                            </div>

                                            <div class="submit-section">
                                                <button class="btn btn-primary" type="submit">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Edit Flight Modal -->
                    @endforeach
                </tbody>
            </table>
        </div>


        <div id="addFlightModal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Flight</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.flights.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="flight_no">Flight No</label>
                                <input type="text" class="form-control" id="flight_no" name="flight_no"
                                    value="{{ old('flight_no') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="airline_id">Airline</label>
                                <select name="airline_id" class="form-control" required>
                                    <option value="">Select Airline</option>
                                    @foreach ($airlines as $airline)
                                        <option value="{{ $airline->id }}"
                                            {{ old('airline_id') == $airline->id ? 'selected' : '' }}>
                                            {{ $airline->airline_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="origin_id">Origin</label>
                                <select name="origin_id" class="form-control" required>
                                    <option value="">Select Origin</option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}"
                                            {{ old('origin_id') == $sector->id ? 'selected' : '' }}>
                                            {{ $sector->city_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="destination_id">Destination</label>
                                <select name="destination_id" class="form-control" required>
                                    <option value="">Select Destination</option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}"
                                            {{ old('destination_id') == $sector->id ? 'selected' : '' }}>
                                            {{ $sector->city_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="departure_time">Departure Time</label>
                                <input type="datetime-local" class="form-control" id="departure_time"
                                    name="departure_time" value="{{ old('departure_time') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="arrival_time">Arrival Time</label>
                                <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time"
                                    value="{{ old('arrival_time') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="available_seats">Available Seats</label>
                                <input type="number" class="form-control" id="available_seats" name="available_seats"
                                    value="{{ old('available_seats') }}" required>
                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary" type="submit">Add Flight</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
