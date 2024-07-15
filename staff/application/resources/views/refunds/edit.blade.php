<!DOCTYPE html>
<html lang="en" class="{{ auth()->user()->type ?? '' }} {{ config('visibility.page_rendering') }}">
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
    @if(config('visibility.page_rendering') == '' || config('visibility.page_rendering') != 'print-page')
            <div class="preloader">
                <div class="loader">
                    <div class="loader-loading"></div>
                </div>
            </div>
            @endif
            <!--preloader-->

<body id="main-body"
    class="loggedin fix-header card-no-border fix-sidebar {{ config('settings.css_kanban') }} {{ runtimePreferenceLeftmenuPosition(auth()->user()->left_menu_position) }} {{ $page['page'] ?? '' }}">

    <!--main wrapper-->
    <div id="main-wrapper" style="margin-top:50px;">


    <div class="container">


    <div class="card count-1" id="tickets-table-wrapper">
    <div class="card-body">

        <div class="table-responsive list-table-wrapper">

    <div class="backgroundheadingsection">

    <div class="row">
    <div class="col-md-6">
    <h1>Edit Refund</h1>
    </div>
    <div class="col-md-6" style="text-align: right;">

        </div>
 </div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">Edit Refund Request</div> -->

                <div class="card-body">
                    <form action="{{ route('refunds.update', $refund->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="booking_id">Booking ID</label>
                            <select class="form-control" id="booking_id" name="booking_id" required>
                                <option value="">Select Booking</option>
                                @foreach($bookings as $booking)
                                    <option value="{{ $booking->id }}" {{ $booking->id == $refund->booking_id ? 'selected' : '' }}>{{ $booking->booking_number }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="passenger_id">Passenger ID</label>
                            <select class="form-control" id="passenger_id" name="passenger_id" required>
                                <option value="">Select Passenger</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $refund->passenger_id ? 'selected' : '' }}>{{ $user->unique_id }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="refund_amount">Refund Amount</label>
                            <input type="number" class="form-control" id="refund_amount" name="refund_amount" value="{{ $refund->refund_amount }}" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending" {{ $refund->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $refund->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $refund->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="request_date">Request Date</label>
                            <input type="date" class="form-control" id="request_date" name="request_date" value="{{ $refund->request_date }}" required>
                        </div>

                        <div class="form-group">
                            <label for="processed_date">Processed Date</label>
                            <input type="date" class="form-control" id="processed_date" name="processed_date" value="{{ $refund->processed_date }}">
                        </div>

                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <textarea class="form-control" id="reason" name="reason">{{ $refund->reason }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary kr">Update</button>
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
