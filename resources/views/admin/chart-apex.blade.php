@extends('admin/layouts/head-main')
@section('title', 'Chart Apex')
@section('content')


  <!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Charts</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Charts</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="row">

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Apex Simple</h5>
                                </div>
                                <div class="card-body">
                                    <div id="s-line"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Area Chart</h5>
                                </div>
                                <div class="card-body">
                                    <div id="s-line-area"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Column Chart</h5>
                                </div>
                                <div class="card-body">
                                    <div id="s-col"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Column Stacked Chart</h5>
                                </div>
                                <div class="card-body">
                                    <div id="s-col-stacked"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->


                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Bar Chart</h5>
                                </div>
                                <div class="card-body">
                                    <div id="s-bar"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Mixed Chart</h5>
                                </div>
                                <div class="card-body">
                                    <div id="mixed-chart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Donut Chart</h5>
                                </div>
                                <div class="card-body">
                                    <div id="donut-chart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Radial Chart</h5>
                                </div>
                                <div class="card-body">
                                    <div id="radial-chart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                    </div>

                </div>
            </div>
            <!-- /Page Wrapper -->

@endsection
