@extends('admin/layouts/head-main')
@section('content')


    <title>Tasks Report</title>


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Task Reports</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Task Reports</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

                <!-- Content Starts -->
                <!-- Search Filter -->
            <div class="row filter-row">

                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <select class="form-control floating select">
                                <option>
                                    Name1
                                </option>
                                <option>
                                    Name2
                                </option>
                            </select>
                        </div>
                        <label class="focus-label">Project Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <select class="form-control floating select">
                                <option>
                                    All
                                </option>
                                <option>
                                    Pending
                                </option>
                                <option>
                                    Completed
                                </option>
                            </select>
                        </div>
                        <label class="focus-label">Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <a href="#" class="btn btn-success w-100"> Search </a>
                </div>
            </div>
            <!-- /Search Filter -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Task Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Hospital Administration</td>
                                    <td>26 Mar 2019</td>
                                    <td>26 Apr 2021</td>
                                    <td>
                                        <div class="dropdown action-label">
                                            <a href="#" class="btn btn-white btn-sm btn-rounded"><i class="fa fa-dot-circle-o text-success"></i> Active </a>

                                        </div>
                                    </td>
                                    <td>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" title="" data-original-title="Jeffery Lalor"><img alt="" src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}"></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Hospital Administration</td>
                                    <td>26 Mar 2019</td>
                                    <td>26 Apr 2021</td>
                                    <td>
                                        <div class="dropdown action-label">
                                            <a href="#" class="btn btn-white btn-sm btn-rounded"><i class="fa fa-dot-circle-o text-success"></i> Active </a>

                                        </div>
                                    </td>
                                    <td>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" title="" data-original-title="Jeffery Lalor"><img alt="" src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}"></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- /Content End -->

        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->





@endsection
