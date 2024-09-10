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
                                <h1>Leaves</h1>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="{{ route('leave.create') }}" class="btn btn-primary mb-3">Add Leave</a>
                            </div>
                        </div>



                        <style>
                            .stats-info {
                                background-color: #ffffff;
                                border: 1px solid #e5e5e5;
                                text-align: center;
                                border-radius: 4px;
                                margin: 0 0 20px;
                                padding: 15px;
                            }

                            .stats-info h4 {
                                font-size: 24px;
                                margin-bottom: 0;
                            }

                            .stats-info h6 {
                                color: #1f1f1f;
                                font-size: 16px;
                                font-weight: normal;
                                line-height: 18px;
                                margin-bottom: 5px;
                            }
                        </style>

                        <!-- Leave Statistics -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="stats-info">
                                    <h6>Annual Leave</h6>
                                    <h4>12</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-info">
                                    <h6>Medical Leave</h6>
                                    <h4>{{ $medicalLeave }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-info">
                                    <h6>Other Leave</h6>
                                    <h4>{{ $otherLeave }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-info">
                                    <h6>Remaining Leave</h6>
                                    <h4>{{ $remainingLeave }}</h4>
                                </div>
                            </div>
                        </div>

                        <!-- /Leave Statistics -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>Leave Type</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>No of Days</th>
                                                <th>Reason</th>
                                                <th class="text-center">Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employee_leaves as $leave)
                                                <tr>
                                                    <td>{{ $leave->leave_type }}</td>
                                                    <td>{{ $leave->from }}</td>
                                                    <td>{{ $leave->to }}</td>
                                                    <td>{{ $leave->number_of_days }} days</td>
                                                    <td>{{ $leave->reason }}</td>
                                                    <td class="text-center">
                                                        <div class="action-label">
                                                            @if ($leave->status == 1)
                                                                <a class="btn btn-white btn-sm btn-rounded"
                                                                    href="javascript:void(0);">
                                                                    <i class="fa fa-dot-circle-o text-purple"></i>
                                                                    New
                                                                </a>
                                                            @elseif ($leave->status == 2)
                                                                <a class="btn btn-white btn-sm btn-rounded"
                                                                    href="javascript:void(0);">
                                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                                    Pending
                                                                </a>
                                                            @elseif ($leave->status == 3)
                                                                <a class="btn btn-white btn-sm btn-rounded"
                                                                    href="javascript:void(0);">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i>
                                                                    Approved
                                                                </a>
                                                            @else
                                                                <a class="btn btn-white btn-sm btn-rounded"
                                                                    href="javascript:void(0);">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i>
                                                                    Declined
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    {{-- <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#" class="avatar avatar-xs"><img
                                                                            src="{{ asset('public/assets/img/profiles/avatar-09.jpg') }}"
                                                                            alt=""></a>
                                                                    <a href="#">{{ $leave->approved_by }}</a>
                                                                </h2>
                                                            </td> --}}

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
