<!DOCTYPE html>
<html lang="en" class="{{ auth()->user()->type ?? '' }} {{ config('visibility.page_rendering') }}">

@php 
        use Carbon\Carbon;
        @endphp
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
    <div class="container profile-container">
    <h4>Profile</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        <div class=" row">
            <div class="col-md-6">
                <div class="row profile-card">
                    <div class="col-md-1">
                    <img src="{{asset('storage/avatars/'.$agent->avatar_directory.'/'.$agent->avatar_filename)}}" alt="Profile Image">
                    </div>
                    <div class="col-md-5" style="padding: 0 35px;border-right: dotted;">
                    <h5>{{$agent->first_name}} {{$agent->last_name}}</h5>
                    <p>Agent</p>
                    <p>Date of Creation: {{Carbon::parse($agent->created_at)->format('jS M Y')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <span style="font-weight: bold;">Unique ID:</span> <a style="display: inline;position: absolute;">{{$agent->unique_id}}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span style="font-weight: bold;">Email:</span> <a style="display: inline;position: absolute;">{{$agent->email}}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span style="font-weight: bold;">Phone:</span> <a style="display: inline;position: absolute;">{{$agent->phone}}</a>
                    </div>
                </div>
            </div>
            <!-- <img src="https://via.placeholder.com/80" alt="Profile Image">
            <div class="profile-info">
                <h5>{{$agent->first_name}} {{$agent->last_name}}</h5>
                <p>Agent</p>
                <p>Date of Creation: {{Carbon::parse($agent->created_at)->format('jS M Y')}}</p>
            </div>
            <div class="profile-email">
                <span>Email:</span>
                <a href="mailto:admin@example.com">{{$agent->email}}</a>
            </div>
            <div class="profile-email">
                <span>Phone:</span>
                <a href="mailto:admin@example.com">{{$agent->phone}}</a>
            </div> -->
        </div>
    </div>
    </div>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 15px;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
        }

        .profile-container {
            padding: 20px;
        }

        .profile-card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            align-items: center;
            width: 1018px;
            height: 160px;
        }

        .profile-card img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            margin-right: 20px;
        }

        .profile-info {
            flex-grow: 1;
        }

        .profile-info h5 {
            margin: 0;
            font-weight: bold;
        }

        .profile-info p {
            margin: 0;
            color: #6c757d;
        }

        .profile-email {
            margin-left: auto;
            text-align: right;
        }

        .profile-email span {
            font-weight: bold;
        }

        .profile-email a {
            color: #007bff;
            text-decoration: none;
        }

        .profile-email a:hover {
            text-decoration: underline;
        }
    </style>
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
