@extends('admin/layouts/head-main')
@section('content')
    <title>New Reservation</title>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Reservations</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">New Reservation</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">New Reservation</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.reservation.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Account Type</label>
                                        <select class="form-control" name="account_type" required>
                                            <option value="">Select Account Type</option>
                                            <option value="b2b">B2B</option>
                                            <option value="b2c">B2C</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Sale Type</label>
                                        <select class="form-control" name="sale_type" required>
                                            <option value="">Select Sale Type</option>
                                            <option value="deposit">Deposit</option>
                                            <option value="date change">Date Change</option>
                                            <option value="seat payment">Seat Payment</option>
                                            <option value="air ticket">Air Ticket</option>
                                            <option value="emd">EMD</option>
                                            <option value="mco">MCO</option>
                                            <option value="refund">Refund</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Sale Status</label>
                                        <select class="form-control" name="sale_status" required>
                                            <option value="">Select Status</option>
                                            <option value="confirmed">Confirmed</option>
                                            <option value="pending">Pending</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Booking Reference</label>
                                        <input type="text" class="form-control" name="booking_ref" required placeholder="Enter Booking Reference">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Adult</label>
                                        <input type="number" class="form-control" name="adult" required placeholder="0" min="0">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Child</label>
                                        <input type="number" class="form-control" name="child" required placeholder="0" min="0">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Infant</label>
                                        <input type="number" class="form-control" name="infant" required placeholder="0" min="0">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Date</label>
                                        <input type="date" class="form-control" name="date" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Airline</label>
                                        <select class="form-control" name="airline_id" required>
                                            <option value="">Select Airline</option>
                                            @foreach($airlines as $airline)
                                                <option value="{{ $airline->id }}">{{ $airline->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Customer Type</label>
                                        <select class="form-control" name="customer_type" required>
                                            <option value="">Select Customer Type</option>
                                            <option value="individual">Individual</option>
                                            <option value="corporate">Corporate</option>
                                            <option value="agent">Agent</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Purchased</label>
                                        <input type="text" class="form-control" name="purchased" required placeholder="Enter Amount">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Service Charges</label>
                                        <input type="text" class="form-control" name="service_charges" required placeholder="Enter Service Charges">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Sold</label>
                                        <input type="text" class="form-control" name="sold" required placeholder="Enter Sold Amount">
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <label>
                                            <strong style="text-align:center;">Passenger Details</strong>
                                        </label>
                                        <div id="passenger-details-container">
                                            <!-- Passenger details will be dynamically added here -->
                                        </div>
                                        <button type="button" class="btn btn-primary" id="generate-passenger-fields">Generate Passenger Fields</button>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <label>
                                            <strong>Flight Details</strong>
                                        </label>
                                        <div id="flight-details-container">
                                            <div class="flight-detail-row row mb-2">
                                                <div class="form-group col-md-3">
                                                    <label>Flight Number</label>
                                                    <input type="text" class="form-control" name="flight_number[]" required placeholder="Enter Flight Number">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>Departure City</label>
                                                    <input type="text" class="form-control" name="departure_city[]" required placeholder="Enter Departure City">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>Arrival City</label>
                                                    <input type="text" class="form-control" name="arrival_city[]" required placeholder="Enter Arrival City">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label>Flight Date</label>
                                                    <input type="date" class="form-control" name="flight_date[]" required>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label>&nbsp;</label>
                                                    <button type="button" class="btn btn-danger remove-flight-detail" style="width: 100%;">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="add-flight-detail">Add Flight Detail</button>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks" rows="3" placeholder="Enter Remarks"></textarea>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Generate passenger fields based on passenger count
            $('#generate-passenger-fields').click(function() {
                var adultCount = parseInt($('input[name="adult"]').val()) || 0;
                var childCount = parseInt($('input[name="child"]').val()) || 0;
                var infantCount = parseInt($('input[name="infant"]').val()) || 0;
                var totalPassengers = adultCount + childCount + infantCount;

                if (totalPassengers === 0) {
                    alert('Please enter passenger counts first.');
                    return;
                }

                $('#passenger-details-container').empty();

                for (var i = 0; i < totalPassengers; i++) {
                    var passengerType = '';
                    if (i < adultCount) passengerType = 'Adult';
                    else if (i < adultCount + childCount) passengerType = 'Child';
                    else passengerType = 'Infant';

                    var passengerHtml = `
                        <div class="passenger-row row mb-3 p-3 border">
                            <div class="col-md-12 mb-2">
                                <strong>Passenger ${i + 1} (${passengerType})</strong>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Title</label>
                                <select class="form-control" name="pnr_title[]" required>
                                    <option value="">Select</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Dr">Dr</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>PNR Number</label>
                                <input type="text" class="form-control" name="pnr_number[]" required placeholder="PNR">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Ticket Number</label>
                                <input type="text" class="form-control" name="ticket_no[]" required placeholder="Ticket No">
                            </div>
                            <div class="form-group col-md-3">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="pax_first_name[]" required placeholder="First Name">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="pax_last_name[]" required placeholder="Last Name">
                            </div>
                        </div>
                    `;
                    $('#passenger-details-container').append(passengerHtml);
                }
            });

            // Add new flight detail row
            $('#add-flight-detail').click(function() {
                var newRow = $('.flight-detail-row:first').clone();
                newRow.find('input').val('');
                newRow.find('.remove-flight-detail').show();
                $('#flight-details-container').append(newRow);
            });

            // Remove flight detail row
            $(document).on('click', '.remove-flight-detail', function() {
                if ($('.flight-detail-row').length > 1) {
                    $(this).closest('.flight-detail-row').remove();
                } else {
                    alert('At least one flight detail is required.');
                }
            });

            // Hide remove button for first row
            $('.flight-detail-row:first .remove-flight-detail').hide();
        });
    </script>
@endsection         