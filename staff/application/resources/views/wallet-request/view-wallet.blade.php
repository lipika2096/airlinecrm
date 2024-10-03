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
            <h3>Wallet Request View</h3><br/>
        </div>
    </div>
       <div class="col-md-12">

       {{-- <form action="{{ route('bank.store') }}" method="POST"> --}}
        {{-- @csrf --}}
        <div class="form-group">
            <label for="booking_id" class="text-bold">Payment Mode : </label> {{$walletDetail->payment_mode}}
        </div>

        <div class="form-group">
            <label for="refund_amount" class="text-bold">Amount:</label> {{$walletDetail->amount}}

        </div>
        <div class="form-group">
            <label for="request_date" class="text-bold">Bank Transaction Id: </label> {{$walletDetail->bank_tran_id}}
        </div>

        <div class="form-group">
            <label for="request_date" class="text-bold">Bank Name: </label> {{$walletDetail->bank_name}}
        </div>

        <div class="form-group">
            <label for="processed_date" class="text-bold">Branch: </label> {{$walletDetail->bank_branch}}
        </div>

        <div class="form-group">
            <label for="processed_date" class="text-bold">Status: </label> @if($walletDetail->status == 1)
            <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                <i class="fa fa-dot-circle-o text-success"></i>Approved
            </a>
        @elseif($walletDetail->status == 2)
            <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                <i class="fa fa-dot-circle-o text-purple"></i>Pending
            </a>
        @else
            <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                <i class="fa fa-dot-circle-o text-danger"></i>Rejected
            </a>
        @endif
        </div>
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
