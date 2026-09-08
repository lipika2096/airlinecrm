@extends('admin/layouts/head-main')
@section('content')


    <title>Blank Page</title>


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Blank Page</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Blank Page</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Content Starts -->
                Content Starts Here
            <!-- /Content End -->

        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->






@endsection
