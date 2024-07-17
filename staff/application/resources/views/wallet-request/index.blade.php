
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


    <div class="card count-1" id="tickets-table-wrapper">
    <div class="card-body">

        <div class="table-responsive list-table-wrapper">
    <div class="backgroundheadingsection">
        <h1>Wallet Requests</h1>
        </div>
        <div class="col-md-12" style="text-align: right;">
            <a href="{{ route('bank.create') }}" class="btn btn-primary mb-3">Request Wallet</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Payment Mode</th>
                    <th>Bank Trans. Id</th>
                    <th>Bank Name</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($walletRequest as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->payment_mode }}</td>
                        <td>{{ $data->bank_tran_id }}</td>
                        <td>{{ $data->bank_name }}</td>
                        <td>{{ $data->created_at }}</td>
                        <td>
                            @if($data->status == 1)
                                <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                    <i class="fa fa-dot-circle-o text-success"></i>Approved
                                </a>
                            @elseif($data->status == 2)
                                <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                    <i class="fa fa-dot-circle-o text-purple"></i>Pending
                                </a>
                            @else
                                <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                    <i class="fa fa-dot-circle-o text-danger"></i>Rejected
                                </a>
                            @endif
                        </td>
                        <td><a href="{{ route('bank.show',['id'=> $data->id]) }}"
                            class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a></td>
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
@if(config('visibility.page_rendering') == 'print-page')
<script src="{{asset('/public/js/dynamic/print.js?v=')}}{{ config('system.versioning') }}"></script>
@endif

</html>
