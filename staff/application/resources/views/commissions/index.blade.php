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
                                <h1>Commissions</h1>
                            </div>
                            <div class="col-md-6" style="text-align: right;">

                            </div>
                        </div>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Airline</th>
                                                <th>Commission Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($commissions as $commission)
                                                <tr>
                                                    <td>{{ $commission->id }}</td>
                                                    <td>{{ $commission->airline->airline_code }}</td>
                                                    <td>{{ $commission->commissions_rate }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

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
    @if (config('visibility.page_rendering') == 'print-page')
        <script src="{{ asset('/public/js/dynamic/print.js?v=') }}{{ config('system.versioning') }}"></script>
    @endif

</html>
