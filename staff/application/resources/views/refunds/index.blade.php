<!DOCTYPE html>
<html lang="en" class="{{ auth()->user()->type ?? '' }} {{ config('visibility.page_rendering') }}">

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
    @if (config('visibility.page_rendering') == '' || config('visibility.page_rendering') != 'print-page')
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

                        <div class="row">
                            <div class="col-md-6">
                                <h1>Refunds</h1>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="{{ route('refunds.create') }}" class="btn btn-primary mb-3">Create
                                    +</a>
                            </div>
                        </div>



                        @if ($refunds->isEmpty())
                            <p>No refunds found.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Booking ID</th>
                                        <th>Refund Reason</th>
                                        <th>Refund Amount</th>
                                        <th>Refund Status</th>
                                        <th>Request Date</th>
                                        <th>Processed Date</th>

                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($refunds as $refund)
                                        <tr>
                                            <td>{{ $refund->id }}</td>
                                            <td>{{ $refund->booking_id }}</td>

                                            <td>{{ $refund->reason }}</td>
                                            <td>{{ $refund->refund_amount }}</td>
                                            <td>{{ $refund->refund_status }}</td>
                                            <td>{{ $refund->request_date }}</td>
                                            <td>{{ $refund->processed_date }}</td>

                                            <td style="width:130px;">
                                                <a href="{{ route('refunds.edit', $refund->id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('refunds.destroy', $refund->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this refund?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
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
    @if (config('visibility.page_rendering') == 'print-page')
        <script src="{{ asset('/public/js/dynamic/print.js?v=') }}{{ config('system.versioning') }}"></script>
    @endif

</html>
