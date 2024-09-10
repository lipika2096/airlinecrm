@extends('admin/layouts/head-main')
@section('content')


<div class="main-wrapper">
    @include ('admin/layouts/menu')
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="welcome-box">
                        <!--<div class="welcome-img">-->
                        <!--    <img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}">-->
                        <!--</div>-->
                        <div class="welcome-det">
                            <h3>Welcome, John Doe</h3>
                            <p>Monday, 20 May 2019</p>
                        </div>
                    </div>
                </div>
            </div>

            

        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->

</div>
<!-- end main wrapper-->


@endsection
