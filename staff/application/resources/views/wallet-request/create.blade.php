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
    <h1>Wallet Request</h1>
    </div>
    <div class="col-md-6" style="text-align: right;">

        </div>
 </div>
       <div class="col-md-12">

       <form action="{{ route('bank.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="booking_id">Payment Mode</label>
            <select class="form-control" id="payment_mode" name="payment_mode" required>
                <option value="">Select Mode</option>
                <option value="Cash Deposit">Cash Deposit</option>
                <option value="Online Bank Transfer"> Online Bank Transfer</option>
                <option value="Cheque Transfer"> Cheque Transfer</option>
                <option value="Demand Draft"> Demand Draft</option>
            </select>
        </div>

        <div class="form-group">
            <label for="refund_amount">Amount</label>
            <input type="number" placeholder="Enter Amount Deposited" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="form-group">
            <label for="request_date">Bank Transaction Id</label>
            <input type="text" class="form-control" placeholder="Transaction id" id="bank_tran_id" name="bank_tran_id" required>
        </div>

        <div class="form-group">
            <label for="request_date">Bank Name</label>
            <input type="text" class="form-control" placeholder="Bank name in which money has been deposited" id="bank_name" name="bank_name" required>
        </div>

        <div class="form-group">
            <label for="processed_date">Branch</label>
            <input type="text" class="form-control" id="bank_branch" name="bank_branch">
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
