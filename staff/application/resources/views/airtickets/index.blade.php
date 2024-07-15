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

                        <div class="table-responsive list-table-wrapper">

                            <div class="backgroundheadingsection">

                                <div class="row">
                                    <div class="col-md-6">
                                        <h1>Air Tickets</h1>
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <a href="{{ route('airtickets.create') }}" class="btn btn-primary mb-3">Add</a>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
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
                                            <th>Status</th>
                                            <th>Update Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($airTickets as $airTicket)
                                            <tr>
                                                <td>{{ $airTicket->id }}</td>
                                                <td>{{ $airTicket->ticket_number }}</td>
                                                <td>{{ $airTicket->emd }}</td>
                                                <td>{{ $airTicket->mco }}</td>
                                                <td>{{ $airTicket->date_change ? 'Yes' : 'No' }}</td>
                                                <td>{{ $airTicket->refund ? 'Yes' : 'No' }}</td>
                                                <td>{{ $airTicket->ticket_issued_from }}</td>
                                                <td>{{ $airTicket->ticket_issued_to }}</td>
                                                <td>{{ $airTicket->departure_date }}</td>
                                                <td>{{ $airTicket->return_date }}</td>
                                                <td>{{ $airTicket->airline->airline_code }}</td>
                                                <td>{{ $airTicket->base_fare }}</td>
                                                <td>{{ $airTicket->taxes }}</td>
                                                <td>{{ $airTicket->amount_paid_to_airlines }}</td>
                                                <td>{{ $airTicket->amount_charged_from_pax }}</td>

                                                <td>
                                                    @switch($airTicket->status)
                                                        @case('approved')
                                                            <span
                                                                class="badge badge-success">{{ ucfirst($airTicket->status) }}</span>
                                                        @break

                                                        @case('canceled')
                                                            <span
                                                                class="badge badge-warning">{{ ucfirst($airTicket->status) }}</span>
                                                        @break

                                                        @case('rejected')
                                                            <span
                                                                class="badge badge-danger">{{ ucfirst($airTicket->status) }}</span>
                                                        @break

                                                        @default
                                                            <span>{{ ucfirst($airTicket->status) }}</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <form
                                                        action="{{ route('airtickets.update_status', $airTicket->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <select name="status" class="form-control" required>
                                                            <option value="approved"
                                                                {{ $airTicket->status == 'approved' ? 'selected' : '' }}>
                                                                Approved</option>
                                                            <option value="canceled"
                                                                {{ $airTicket->status == 'canceled' ? 'selected' : '' }}>
                                                                Canceled</option>
                                                            <option value="rejected"
                                                                {{ $airTicket->status == 'rejected' ? 'selected' : '' }}>
                                                                Rejected</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    @if (config('visibility.page_rendering') == 'print-page')
        <script src="{{ asset('/public/js/dynamic/print.js?v=') }}{{ config('system.versioning') }}"></script>
    @endif

</html>
