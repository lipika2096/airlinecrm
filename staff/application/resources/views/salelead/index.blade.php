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

        <!-- <div class="table-responsive list-table-wrapper"> -->

    <!-- <div class="backgroundheadingsection"> -->

    <div class="row">
        <div class="col-md-6">
            <h1>leads</h1>
        </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="{{ route('saleleads.create') }}" class="btn btn-primary mb-3">Create +</a>
            </div>
    </div>

       

        @if ($leads->isEmpty())
            <p>No leads found.</p>
        @else
        <div class="table-responsive">
            <table class="table">
            <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                         <th>Email</th>
                        <th>Phone</th>
                        <th>Project</th>
                        <th>Company</th>
                        <th>Created At</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leads as $lead)
                        <tr>
                            <td>{{ $lead->id }}</td>
                            <td>{{ $lead->name }}</td>
                             <td>{{ $lead->email }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ $lead->project }}</td>
                            <td>{{ $lead->company }}</td>
                            <td>{{ $lead->created_at }}</td>
                            <td style="width: 130px;">
                                <a href="{{ route('saleleads.edit', $lead->id) }}" class="btn btn-sm btn-primary" >Edit</a>
                                <form action="{{ route('saleleads.destroy', $lead->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <a type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this refund?')">Delete</a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
   
    <!-- </div> -->
    <!-- </div> -->
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
