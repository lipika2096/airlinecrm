@extends('admin/layouts/head-main')
@section('title', 'Chart JS')
@section('content')


  <!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Chartjs</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Chartjs</li>
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
                                    <div>
                                        <canvas id="chartBar1" class="h-300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Transparency </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <canvas id="chartBar2" class="h-300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                    <div class="card-header">
                                        <div class="card-title mb-0">Gradient Bar Chart</div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <canvas id="chartBar3" class="h-300"></canvas>
                                        </div>
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
                                        <div class="chartjs-wrapper-demo">
                                            <canvas id="chartBar4" class="h-300"></canvas>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Horizontal Bar Chart Style2</div>
                                </div>
                                <div class="card-body">
                                    <div class="chartjs-wrapper-demo">
                                        <canvas id="chartBar5" class="h-300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Vertical Stacked Bar Chart</div>
                                </div>
                                <div class="card-body">
                                    <div class="chartjs-wrapper-demo">
                                        <canvas id="chartStacked1" class="h-300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Horizontal Stacked Bar Chart</div>
                                </div>
                                <div class="card-body">
                                    <div class="chartjs-wrapper-demo">
                                        <canvas id="chartStacked2" class="h-300"></canvas>
                                    </div>
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
                                    <div class="chartjs-wrapper-demo">
                                        <canvas id="chartLine1" class="h-300"></canvas>
                                    </div>
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
                                    <div class="chartjs-wrapper-demo">
                                        <canvas id="chartPie" class="h-300"></canvas>
                                    </div>
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
                                    <div class="chartjs-wrapper-demo">
                                        <canvas id="chartDonut" class="h-300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart -->

                        <!-- Chart -->
                        <div class="col-md-6">
                            <div class="card">
                                    <div class="card-header">
                                        <div class="card-title mb-0">Area Chart</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="chartjs-wrapper-demo">
                                            <canvas id="chartArea1" class="h-300"></canvas>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!-- /Chart -->

                    </div>

                </div>
            </div>
            <!-- /Page Wrapper -->


@endsection
