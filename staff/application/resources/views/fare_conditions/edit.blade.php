<!-- resources/views/fare_conditions/edit.blade.php -->
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
    <script src="https://cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
    <div class="container">


    <div class="card count-1" id="tickets-table-wrapper">
    <div class="card-body">

        <div class="table-responsive list-table-wrapper">
    <div class="backgroundheadingsection">

        </div>
@section('content')
    <div class="container">
        <h1>Edit Fare Condition</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fare_conditions.update', $fareCondition->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="fare_condition_details">Fare Condition Details</label>
                <textarea name="fare_condition_details" id="editor1" class="form-control" required>{{ $fareCondition->fare_condition_details }}</textarea>
            </div>

            <div class="form-group">
                <label for="cancellation_policy">Cancellation Policy</label>
                <textarea name="cancellation_policy" id="editor2" class="form-control" required>{{ $fareCondition->cancellation_policy }}</textarea>
            </div>

            <div class="form-group">
                <label for="date_change_policy">Date Change Policy</label>
                <textarea name="date_change_policy" id="editor3" class="form-control" required>{{ $fareCondition->date_change_policy }}</textarea>
            </div>

            <div class="form-group">
                <label for="updated_by">Updated By</label>
                <input type="text" name="updated_by" class="form-control" value="{{ $fareCondition->updated_by }}" required>
            </div>

            <div class="form-group">
                <label for="effective_from_date">Effective From Date</label>
                <input type="date" name="effective_from_date" class="form-control" value="{{ $fareCondition->effective_from_date }}" required>
            </div>

            <div class="form-group">
                <label for="valid_till_date">Valid Till Date</label>
                <input type="date" name="valid_till_date" class="form-control" value="{{ $fareCondition->valid_till_date }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    </div>

</div>
</div>
</div>
</div>


<script>
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
    CKEDITOR.replace('editor3');
</script>
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

