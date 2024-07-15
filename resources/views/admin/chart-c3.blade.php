@extends('admin/layouts/head-main')
@section('title', 'Flot Chart')
@section('content')

<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Flot Chart</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Flot Charts</li>
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
                                    <div class="card-title mb-0">Bar Chart</div>
                                </div>
                                <div class="card-body">
                                    <div id="chart-bar-stacked"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Multiple Bar Chart</div>
                                </div>
                                <div class="card-body">
                                    <div  id="chart-bar"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Horizontal Bar Chart</div>
                                </div>
                                <div class="card-body">
                                    <div  id="chart-bar-rotated" ></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Line Chart</div>
                                </div>
                                <div class="card-body">
                                    <div id="chart-sracked"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Line Chart</div>
                                </div>
                                <div class="card-body">
                                    <div id="chart-spline-rotated"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Line Chart</div>
                                </div>
                                <div class="card-body">
                                    <div id="chart-area-spline-sracked"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Pie Chart</div>
                                </div>
                                <div class="card-body">
                                    <div id="chart-pie"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Donut Chart</div>
                                </div>
                                <div class="card-body">
                                    <div id="chart-donut"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                    </div>

                </div>
            </div>
            <!-- /Page Wrapper -->

@endsection
