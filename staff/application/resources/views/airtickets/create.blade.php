<!DOCTYPE html>
<html lang="en" >
<style>

.table-responsive {
    overflow-x: hidden !important;

}
</style>
<!--CRM - GROWCRM.IO-->
@include('layout.header')
     <!--top nav-->
     @include('nav.topnav') @include('nav.leftmenu')
        <!--top nav-->
        <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">

        <!--page wrapper-->
        <div class="page-wrapper">

            <!--overlay-->
            <div class="page-wrapper-overlay js-close-side-panels hidden" data-target=""></div>
            <!--overlay-->

            <!--preloader-->

<body id="main-body"
    class="loggedin fix-header card-no-border fix-sidebar ">

    <!--main wrapper-->
    <div id="main-wrapper" style="margin-top:50px;">


    <div class="container">


    <div class="card count-1" id="tickets-table-wrapper">
    <div class="card-body">

        <div class="table-responsive list-table-wrapper">

    <div class="backgroundheadingsection">

    <div class="row">
    <div class="col-md-6">
    <h1>Reservations </h1><br>
    </div>
    <div class="col-md-6" style="text-align: right;">

        </div>
 </div>


       <div class="col-md-12">


    <form action="{{ route('airtickets.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="airline_id">Airline</label>
            <select class="form-control" id="airline_id" name="airline_id" required>
                @foreach ($airlines as $id => $airline_code)
                    <option value="{{ $id }}">{{  $airline_code }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="airline_id">Service Type</label>
            <select class="form-control" id="airline_id" name="airline_id" required>
                <!--@foreach ($airlines as $id => $airline_code)-->
                <!--    <option value="{{ $id }}">{{  $airline_code }}</option>-->
                <!--@endforeach-->
                <option value="{{ $id }}">New Tickets</option>
                <option value="{{ $id }}">Date Of change</option><!-- Excess Baggage
Excess Weight
Paid Seat -->
            </select>
        </div>
        <div class="form-group">
            <label for="ticket_number">Flight Number</label>
            <input type="text" class="form-control" id="ticket_number" name="ticket_number" required>
        </div>

        <div class="form-group">
            <label for="emd">EMD</label>
            <input type="text" class="form-control" id="emd" name="emd">
        </div>

        <div class="form-group">
            <label for="mco">MCO</label>
            <input type="text" class="form-control" id="mco" name="mco">
        </div>

        {{-- <div class="form-group">
            <label for="date_change">Date Change</label>
            <input type="date" class="form-control" id="date_change" name="date_change" >
        </div> --}}

        {{-- <div class="form-group">
            <label for="refund">Refund</label>
            <input type="text" class="form-control" id="refund" name="refund" >
        </div> --}}
<div class="row">
<div class="col-md-3">
        <div class="form-group">
            <label for="ticket_issued_from">Ticket Issued From</label>
            <input type="date" class="form-control" id="ticket_issued_from" name="ticket_issued_from">
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
            <label for="ticket_issued_to">Ticket Issued To</label>
            <input type="date" class="form-control" id="ticket_issued_to" name="ticket_issued_to">
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
            <label for="departure_date">Departure Date</label>
            <input type="date" class="form-control" id="departure_date" name="departure_date">
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
            <label for="return_date">Return Date</label>
            <input type="date" class="form-control" id="return_date" name="return_date">
        </div>
        </div>
        </div>



        <div class="form-group">
            <label for="base_fare">Base Fare</label>
            <input type="number" step="0.01" class="form-control" id="base_fare" name="base_fare" required>
        </div>

        <div class="form-group">
            <label for="taxes">Taxes</label>
            <input type="number" step="0.01" class="form-control" id="taxes" name="taxes" required>
        </div>

        <div class="form-group">
            <label for="amount_paid_to_airlines">Amount Paid to Airlines</label>
            <input type="number" step="0.01" class="form-control" id="amount_paid_to_airlines" name="amount_paid_to_airlines" required>
        </div>

        <div class="form-group">
            <label for="amount_charged_from_pax">Amount Charged from Pax</label>
            <input type="number" step="0.01" class="form-control" id="amount_charged_from_pax" name="amount_charged_from_pax" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Air Ticket</button>
    </form>


    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('css/custom.css') }}"></script>
<!--common modals-->
@include('modals.actions-modal-wrapper')
    @include('modals.common-modal-wrapper')
    @include('modals.plain-modal-wrapper')
    @include('pages.authentication.modal.relogin')

    <!--selector - modals-->
    @include('modals.create')


    <!--js footer-->
    @include('layout.footerjs')

    <!--js automations-->
    @include('layout.automationjs')

    <!--[note: no sanitizing required] for this trusted content, which is added by the admin-->
    {!! config('system.settings_theme_body') !!}
</body>


<!--[PRINTING]-->
@if(config('visibility.page_rendering') == 'print-page')
<script src="{{asset('/public/js/dynamic/print.js?v=')}}{{ config('system.versioning') }}"></script>
@endif

</html>
