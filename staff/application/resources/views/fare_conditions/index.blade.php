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
                                        <h1>Fare Conditions</h1>
                                    </div>
                                    <div class="col-md-6" style="text-align:right">
                                        <!--<a href="{{ route('fare_conditions.create') }}" class="btn btn-primary">Add </a>-->
                                    </div>
                                </div>

                                <div class="container">


                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Fare Condition Details</th>
                                                <th>Cancellation Policy</th>
                                                <th>Date Change Policy</th>
                                                <th>Updated By</th>
                                                <th>Effective From</th>
                                                <th>Valid Till</th>
                                                <!--<th>Actions</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fareConditions as $fareCondition)
                                                <tr>
                                                    <td>{{ $fareCondition->id }}</td>
                                                    <td>{{ $fareCondition->fare_condition_details }}</td>
                                                    <td>{{ $fareCondition->cancellation_policy }}</td>
                                                    <td>{{ $fareCondition->date_change_policy }}</td>
                                                    <td>{{ $fareCondition->updated_by }}</td>
                                                    <td>{{ $fareCondition->effective_from_date }}</td>
                                                    <td>{{ $fareCondition->valid_till_date }}</td>
                                                    <!--<td>-->
                                                    <!--    <a href="{{ route('fare_conditions.edit', $fareCondition->id) }}" class="btn btn-sm btn-success">Edit</a>-->
                                                    <!--    <form action="{{ route('fare_conditions.destroy', $fareCondition->id) }}" method="POST" style="display:inline-block;">-->
                                                    <!--        @csrf-->
                                                    <!--        @method('DELETE')-->
                                                    <!--        <button type="submit" class="btn btn-sm btn-danger">Delete</button>-->
                                                    <!--    </form>-->
                                                    <!--</td>-->
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    @if (config('visibility.page_rendering') == 'print-page')
        <script src="{{ asset('/public/js/dynamic/print.js?v=') }}{{ config('system.versioning') }}"></script>
    @endif

</html>
