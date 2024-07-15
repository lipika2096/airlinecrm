@extends('admin/layouts/head-main')
@section('content')

<title>Tickets</title>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Tickets</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Ticket Number</th>
                                <th>EMD</th>
                                <th>MCO</th>
                                <th>Date Change</th>
                                <th>Refund</th>
                                <th>Ticket Issued From</th>
                                <th>Ticket Issued To</th>
                                <th>Departure Date</th>
                                <th>Return Date</th>
                                <th>Airline</th>
                                <th>Base Fare</th>
                                <th>Taxes</th>
                                <th>Amount Paid to Airlines</th>
                                <th>Amount Charged from Pax</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->ticket_number }}</td>
                                <td>{{ $ticket->emd }}</td>
                                <td>{{ $ticket->mco }}</td>
                                <td>{{ $ticket->date_change ? 'Yes' : 'No' }}</td>
                                <td>{{ $ticket->refund ? 'Yes' : 'No' }}</td>
                                <td>{{ $ticket->ticket_issued_from }}</td>
                                <td>{{ $ticket->ticket_issued_to }}</td>
                                <td>{{ $ticket->departure_date }}</td>
                                <td>{{ $ticket->return_date }}</td>
                                <td>{{ $ticket->airline }}</td>
                                <td>{{ $ticket->base_fare }}</td>
                                <td>{{ $ticket->taxes }}</td>
                                <td>{{ $ticket->amount_paid_to_airlines}}</td>
                                <td>{{ $ticket->amount_charged_from_pax }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->





@endsection
