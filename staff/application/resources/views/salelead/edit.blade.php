<!DOCTYPE html>
<html lang="en" >

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
    <h1>Leads Update</h1>
    </div>
    <div class="col-md-6" style="text-align: right;">

        </div>
 </div>
       <div class="col-md-12">

       <form method="POST" action="{{ route('saleleads.update', $lead->id) }}">
                        @csrf
                        @method('PUT') <!-- Use PUT method for updates -->

                        <div class="form-group">
                            <label for="lead_firstname">Full Name</label>
                            <input type="text" id="lead_firstname" name="name" class="form-control" value="{{ $lead->name }}" required>
                        </div>


                        <div class="form-group">
                            <label for="lead_email">Email</label>
                            <input type="email" id="lead_email" name="email" class="form-control" value="{{ $lead->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="lead_phone">Phone</label>
                            <input type="text" id="lead_phone" name="phone" class="form-control" value="{{ $lead->phone }}">
                        </div>

                        <div class="form-group">
                            <label for="lead_website">Website</label>
                            <input type="text" id="lead_website" name="project" class="form-control" value="{{ $lead->project }}">
                        </div>

                        <div class="form-group">
                            <label for="lead_company_name">Company Name</label>
                            <input type="text" id="lead_company_name" name="company" class="form-control" value="{{ $lead->company }}">
                        </div>

                        <button type="submit" class="btn btn-primary kr">Update</button>
                    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('css/custom.css') }}"></script>
<!--common modals-->


    <!--js footer-->
    @include('layout.footerjs')

    <!--js automations-->
    @include('layout.automationjs')

    <!--[note: no sanitizing required] for this trusted content, which is added by the admin-->
    {!! config('system.settings_theme_body') !!}
</body>


</html>
