<!--ALL THIRD PART JAVASCRIPTS-->
<script src="{{asset('/public/vendor/js/vendor.footer.js?v=')}}{{ config('system.versioning') }}"></script>

<!--nextloop.core.js-->
<script src="{{asset('/public/js/core/ajax.js?v=')}}{{ config('system.versioning') }}"></script>

<!--MAIN JS - AT END-->
<script src="{{asset('/public/js/core/boot.js?v=')}}{{ config('system.versioning') }}"></script>

<!--EVENTS-->
<script src="{{asset('/public/js/core/events.js?v=')}}{{ config('system.versioning') }}"></script>

<!--CORE-->
<script src="{{asset('/public/js/core/app.js?v=')}}{{ config('system.versioning') }}"></script>

<!--BILLING-->
<script src="{{asset('/public/js/core/billing.js?v=')}}{{ config('system.versioning') }}"></script>

<!--project page charts-->
@if(@config('visibility.projects_d3_vendor'))
<script src="{{asset('/public/vendor/js/d3/d3.min.js?v=')}}{{ config('system.versioning') }}"></script>
<script src="{{asser('/public/vendor/js/c3-master/c3.min.js?v=')}}{{ config('system.versioning') }}"></script>
@endif

<!--form builder-->
@if(@config('visibility.web_form_builder'))
<script src="{{asset('/public/vendor/js/formbuilder/form-builder.min.js?v=')}}{{ config('system.versioning') }}"></script>
<script src="{{asset('/public/js/webforms/webforms.js?v=')}}{{ config('system.versioning') }}"></script>
@endif