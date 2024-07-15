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
    <h1>Refunds</h1>
    </div>
    <div class="col-md-6" style="text-align: right;">

        </div>
 </div>
       <div class="col-md-12">

       <form action="{{ route('refunds.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="booking_id">Booking ID</label>
            <select class="form-control" id="booking_id" name="booking_id" required>
                <option value="">Select Booking</option>
                @foreach($bookings as $booking)
                    <option value="{{ $booking->id }}">{{ $booking->booking_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
    <label for="agent_id">Passenger ID</label>
    <select class="form-control" id="passenger_id" name="passenger_id" required>
        <option value="">Select Passenger</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->unique_id }}</option>
        @endforeach
    </select>
</div>
        <div class="form-group">
            <label for="refund_amount">Refund Amount</label>
            <input type="number" class="form-control" id="refund_amount" name="refund_amount" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="refund_status" required>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <div class="form-group">
            <label for="request_date">Request Date</label>
            <input type="date" class="form-control" id="request_date" name="request_date" required>
        </div>
        <div class="form-group">
            <label for="processed_date">Processed Date</label>
            <input type="date" class="form-control" id="processed_date" name="processed_date">
        </div>
        <div class="form-group">
            <label for="reason">Reason</label>
            <textarea class="form-control" id="reason" name="reason"></textarea>
        </div>
        <button type="submit" class="btn btn-primary kr">Submit</button>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="{{ asset('public/js/core/app.js') }}"></script>
    <script src="{{ asset('public/css/custom.css') }}"></script>
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
