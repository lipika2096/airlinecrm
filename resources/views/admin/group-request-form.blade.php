@extends('admin/layouts/head-main')
@section('content')
    <div class="main-wrapper">
        @include ('admin/layouts/menu')
        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <!-- Page Content -->

            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Basic Information
                            </h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Basic Information</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="PATCH" action="{{ route('admin.group.request.form.update' , ['id' => $data->id]) }}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="groupName"></label>
                            <input type="text" class="form-control" id="groupName" name="group_name"
                                placeholder="Group Name *" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tourName"></label>
                            <input type="text" class="form-control" id="tourName" name="tour_name"
                                placeholder="Tour Name" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="groupType">Group Type</label>
                            <select id="groupType" class="form-control" name="group_type" required>
                                <option value="Business">Business</option>
                                <option value="Corporate">Corporate</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="corporate">Corporate</label>
                            <input type="text" class="form-control" id="corporate" name="corporate" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="corporateCode">Corporate Code</label>
                            <input type="text" class="form-control" id="corporateCode" name="corporate_code" required>
                        </div>
                    </div>

                    <h2>Itinerary Information</h2>
                    <div class="form-group">
                        <label style="font-weight: 500;">Please Select Trip Type</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="trip_type" id="RoundTrip"
                                value="Round Trip" checked onclick="tripTypeChanged('Round Trip')">
                            <label class="form-check-label" for="RoundTrip">Round Trip</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="trip_type" id="OneWay" value="One Way"
                                onclick="tripTypeChanged('One Way')">
                            <label class="form-check-label" for="OneWay">One Way</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="trip_type" id="multiple" value="Multiple"
                                onclick="tripTypeChanged('Multiple')">
                            <label class="form-check-label" for="multiple">Multiple</label>
                        </div>
                        <div class="form-check form-check-inline" style="margin-left: 11pc;">
                            <input class="form-check-input" type="checkbox" id="flexibleDate" name="flexible_date">
                            <label class="form-check-label" for="flexibleDate">Flexible Travel Date</label>
                        </div>
                    </div>

                    <div id="itinerarySection">
                        <!-- Itinerary Information for Round Trip / One Way -->
                        <div id="roundtripsection" style="display: block;">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="origin1">Origin</label>
                                    <input type="text" class="form-control" id="origin1" name="origin[]" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="destination1">Destination</label>
                                    <input type="text" class="form-control" id="destination1" name="destination[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="date1">Date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="date1"
                                            name="date[]" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="calendar-date1"><i
                                                    class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="flightNo1">Flight No.</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]" value="{{$data->flight_number}}"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="flighttime1">Flight Time</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="travelduration1">Travel Duration</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="arrivalDate1">Arrival Date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="arrivalDate1"
                                            name="date[]" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="calendar-arrivalDate1"><i
                                                    class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="origin1">Origin</label>
                                    <input type="text" class="form-control" id="origin1" name="origin[]" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="destination1">Destination</label>
                                    <input type="text" class="form-control" id="destination1" name="destination[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="date2">Date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="date2"
                                            name="date[]" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="calendar-date2"><i
                                                    class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="flightNo1">Flight No.</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="flighttime1">Flight Time</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="travelduration1">Travel Duration</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="arrivalDate2">Arrival Date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="arrivalDate2"
                                            name="date[]" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="calendar-arrivalDate2"><i
                                                    class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Itinerary Information for One Way -->
                        <div id="onewaysection" style="display: none;">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="origin1">Origin</label>
                                    <input type="text" class="form-control" id="origin1" name="origin[]" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="destination1">Destination</label>
                                    <input type="text" class="form-control" id="destination1" name="destination[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="date3">Date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="date3"
                                            name="date[]" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="calendar-date3"><i
                                                    class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="flightNo1">Flight No.</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="flighttime1">Flight Time</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="travelduration1">Travel Duration</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="arrivalDate3">Arrival Date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="arrivalDate3"
                                            name="date[]" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="calendar-arrivalDate3"><i
                                                    class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Additional Itinerary Information for Multiple Trip Type -->
                        <div id="multipleTripSection" style="display: none;">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="origin1">Origin</label>
                                    <input type="text" class="form-control" id="origin1" name="origin[]" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="destination1">Destination</label>
                                    <input type="text" class="form-control" id="destination1" name="destination[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="date4">Date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="date4"
                                            name="date[]" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="calendar-date4"><i
                                                    class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="flightNo1">Flight No.</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="flighttime1">Flight Time</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="travelduration1">Travel Duration</label>
                                    <input type="text" class="form-control" id="flightNo1" name="flight_no[]"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="arrivalDate4">Arrival Date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="arrivalDate4"
                                            name="date[]" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="calendar-arrivalDate4"><i
                                                    class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                    <h2>Pax Fare Information</h2>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="expectedFare"></label>
                            <input type="number" class="form-control" id="expectedFare" name="expected_fare"
                                placeholder="EUR | Expected Fare per pax" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="notifyOthers">Notify Others</label>
                            <textarea class="form-control" id="notifyOthers" name="notify_others"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="remark">Remark</label>
                            <textarea class="form-control" id="remark" name="remark"></textarea>
                        </div>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="agreePolicy" required>
                        <label class="form-check-label" for="agreePolicy">I agree to have read and I accept Vistara's
                            Privacy
                            Policy.</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd'
                    });

                    $('#calendar-date1').click(function() {
                        $('#date1').focus();
                    });

                    $('#calendar-date2').click(function() {
                        $('#date2').focus();
                    });

                    $('#calendar-date3').click(function() {
                        $('#date3').focus();
                    });

                    $('#calendar-date4').click(function() {
                        $('#date4').focus();
                    });

                    $('#calendar-arrivalDate1').click(function() {
                        $('#arrivalDate1').focus();
                    });

                    $('#calendar-arrivalDate2').click(function() {
                        $('#arrivalDate2').focus();
                    });

                    $('#calendar-arrivalDate3').click(function() {
                        $('#arrivalDate3').focus();
                    });

                    $('#calendar-arrivalDate4').click(function() {
                        $('#arrivalDate4').focus();
                    });

                    $('input[name="trip_type"]').change(function() {
                        var type = $(this).val();
                        if (type === 'Round Trip') {
                            $('#roundtripsection').show();
                            $('#onewaysection').hide();
                            $('#multipleTripSection').hide();
                        } else if (type === 'One Way') {
                            $('#roundtripsection').hide();
                            $('#onewaysection').show();
                            $('#multipleTripSection').hide();
                        } else if (type === 'Multiple') {
                            $('#roundtripsection').hide();
                            $('#onewaysection').hide();
                            $('#multipleTripSection').show();
                        }
                    });
                });
            </script>

            <!-- /Page Content -->

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- end main wrapper-->

    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .btn-search {
            margin-top: 30px;
        }

        .btn-primary {
            color: #fff;
            background-color: #ff9b44;
            border-color: #ff9b44;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #fd8e2d;
            border-color: #fd8e2d;
        }

        .form-check-inline {
            display: inline-flex;
            align-items: center;
            padding-left: 20px;
            margin-right: .75rem;
        }

        .input-group-text {
            background-color: #ff9b44;
            color: #fff;
        }

        h2 {
            color: #ff9b44;
        }
    </style>
@endsection
