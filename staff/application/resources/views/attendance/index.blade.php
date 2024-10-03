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


                <div class="count-1" id="tickets-table-wrapper">
                    <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h1>Attendance</h1>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="punch-status">
                                                <div class="card-body col-md-12">
                                                    <h5 class="card-title">Timesheet <small class="text-muted" id="current-date"></small></h5>
                                                    <div class="punch-det">
                                                        <h6 id="punch-in-label">Punch In at</h6>
                                                        <p id="punch-in-time">--:--</p>
                                                    </div>
                                                    <div class="punch-det">
                                                        <h6 id="punch-out-label">Punch Out at</h6>
                                                        <p id="punch-out-time">--:--</p>
                                                    </div>

                                                    <div class="punch-btn-section">
                                                        <button type="button" class="btn btn-primary punch-btn" id="punch-button" onclick="handlePunch()">Punch In</button>
                                                    </div>
                                                    <!--<div class="statistics">-->
                                                    <!--    <div class="row">-->
                                                    <!--        <div class="col-md-12 col-12 text-center">-->
                                                    <!--            <div class="stats-box">-->
                                                    <!--                <p>Break</p>-->
                                                    <!--                <h6>1.21 hrs</h6>-->
                                                    <!--            </div>-->
                                                    <!--        </div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="col-md-6">-->
                                    <!--    <div class="card">-->
                                    <!--        <div class="card recent-activity">-->
                                    <!--            <div class="card-body">-->
                                    <!--                <h5 class="card-title">Today Activity</h5>-->
                                    <!--                <ul class="res-activity-list">-->
                                    <!--                    <li>-->
                                    <!--                        <p class="mb-0">Punch In at</p>-->
                                    <!--                        <p class="res-activity-time">-->
                                    <!--                            <i class="fa fa-clock-o"></i>-->
                                    <!--                            10.00 AM.-->
                                    <!--                        </p>-->
                                    <!--                    </li>-->
                                    <!--                    <li>-->
                                    <!--                        <p class="mb-0">Punch Out at</p>-->
                                    <!--                        <p class="res-activity-time">-->
                                    <!--                            <i class="fa fa-clock-o"></i>-->
                                    <!--                            11.00 AM.-->
                                    <!--                        </p>-->
                                    <!--                    </li>-->
                                    <!--                    <li>-->
                                    <!--                        <p class="mb-0">Punch In at</p>-->
                                    <!--                        <p class="res-activity-time">-->
                                    <!--                            <i class="fa fa-clock-o"></i>-->
                                    <!--                            11.15 AM.-->
                                    <!--                        </p>-->
                                    <!--                    </li>-->
                                    <!--                    <li>-->
                                    <!--                        <p class="mb-0">Punch Out at</p>-->
                                    <!--                        <p class="res-activity-time">-->
                                    <!--                            <i class="fa fa-clock-o"></i>-->
                                    <!--                            1.30 PM.-->
                                    <!--                        </p>-->
                                    <!--                    </li>-->
                                    <!--                    <li>-->
                                    <!--                        <p class="mb-0">Punch In at</p>-->
                                    <!--                        <p class="res-activity-time">-->
                                    <!--                            <i class="fa fa-clock-o"></i>-->
                                    <!--                            2.00 PM.-->
                                    <!--                        </p>-->
                                    <!--                    </li>-->
                                    <!--                    <li>-->
                                    <!--                        <p class="mb-0">Punch Out at</p>-->
                                    <!--                        <p class="res-activity-time">-->
                                    <!--                            <i class="fa fa-clock-o"></i>-->
                                    <!--                            7.30 PM.-->
                                    <!--                        </p>-->
                                    <!--                    </li>-->
                                    <!--                </ul>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>

                                <!--<table class="table table-striped">-->
                                <!--    <thead>-->
                                <!--        <tr>-->
                                <!--            <th>#</th>-->
                                <!--            <th>Date</th>-->
                                <!--            <th>Punch In</th>-->
                                <!--            <th>Punch Out</th>-->
                                <!--            <th>Production</th>-->
                                <!--            <th>Break</th>-->
                                <!--            {{-- <th>Overtime</th> --}}-->
                                <!--        </tr>-->
                                <!--    </thead>-->
                                <!--    <tbody>-->
                                <!--        <tr>-->
                                <!--            <td></td>-->
                                <!--            <td></td>-->
                                <!--            <td></td>-->
                                <!--            <td></td>-->
                                <!--            <td></td>-->
                                <!--            <td></td>-->
                                <!--        </tr>-->
                                <!--    </tbody>-->
                                <!--</table>-->
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

    <script>
        document.getElementById('current-date').innerText = new Date().toLocaleDateString();

        function handlePunch() {
            const punchButton = document.getElementById('punch-button');
            const isPunchIn = punchButton.innerText === 'Punch In';
            const url = isPunchIn ? 'staff/punch-in' : 'staff/punch-out';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    employee_id: '{{ auth()->user()->id }}',
                    time: new Date().toISOString()
                })
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      if (isPunchIn) {
                          document.getElementById('punch-in-time').innerText = new Date().toLocaleTimeString();
                          punchButton.innerText = 'Punch Out';
                      } else {
                          document.getElementById('punch-out-time').innerText = new Date().toLocaleTimeString();
                          punchButton.innerText = 'Punch In';
                      }
                  }
              });
        }
    </script>
</html>
