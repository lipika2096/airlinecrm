@extends('admin/layouts/head-main')
@section('content')


    <title>Search Results</title>


 <!-- Page Wrapper -->
            <div class="page-wrapper">

                <!-- Page Content -->
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Search</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Search</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <!-- Content Starts -->
                        <div class="row">
                            <div class="col-12">

                                <!-- Search Form -->
                                <div class="main-search">
                                    <form action="#">
                                        <div class="input-group">
                                            <input type="text" class="form-control">
                                            <button class="btn btn-primary" type="button">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /Search Form -->

                                <div class="search-result">
                                    <h3>Search Result Found For: <u>Keyword</u></h3>
                                    <p>215 Results found</p>
                                </div>

                                <div class="search-lists">
                                    <ul class="nav nav-tabs nav-tabs-solid">
                                        <li class="nav-item"><a class="nav-link active" href="#results_projects" data-bs-toggle="tab">Projects</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#results_clients" data-bs-toggle="tab">Clients</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#results_users" data-bs-toggle="tab">Users</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="results_projects">

                                            <div class="row">
                                                <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="dropdown dropdown-action profile-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_project"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_project"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                </div>
                                                            </div>
                                                            <h4 class="project-title"><a href="{{route('admin.project-view')}}">Office Management</a></h4>
                                                            <small class="block text-ellipsis m-b-15">
                                                                <span class="text-xs">1</span> <span class="text-muted">open tasks, </span>
                                                                <span class="text-xs">9</span> <span class="text-muted">tasks completed</span>
                                                            </small>
                                                            <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. When an unknown printer took a galley of type and
                                                                scrambled it...
                                                            </p>
                                                            <div class="pro-deadline m-b-15">
                                                                <div class="sub-title">
                                                                    Deadline:
                                                                </div>
                                                                <div class="text-muted">
                                                                    17 Apr 2019
                                                                </div>
                                                            </div>
                                                            <div class="project-members m-b-15">
                                                                <div>Project Leader :</div>
                                                                <ul class="team-members">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}"></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="project-members m-b-15">
                                                                <div>Team :</div>
                                                                <ul class="team-members">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="John Doe"><img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Richard Miles"><img alt="" src="{{asset('public/assets/img/profiles/avatar-09.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="John Smith"><img alt="" src="{{asset('public/assets/img/profiles/avatar-10.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Mike Litorus"><img alt="" src="{{asset('public/assets/img/profiles/avatar-05.jpg')}}"></a>
                                                                    </li>
                                                                    <li class="dropdown avatar-dropdown">
                                                                        <a href="#" class="all-users dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">+15</a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <div class="avatar-group">
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-09.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-10.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-05.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-11.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-12.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-13.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-01.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}">
                                                                                </a>
                                                                            </div>
                                                                            <div class="avatar-pagination">
                                                                                <ul class="pagination">
                                                                                    <li class="page-item">
                                                                                        <a class="page-link" href="#" aria-label="Previous">
                                                                                            <span aria-hidden="true">«</span>
                                                                                            <span class="visually-hidden">Previous</span>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                                                    <li class="page-item">
                                                                                        <a class="page-link" href="#" aria-label="Next">
                                                                                            <span aria-hidden="true">»</span>
                                                                                        <span class="visually-hidden">Next</span>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <p class="m-b-5">Progress <span class="text-success float-end">40%</span></p>
                                                            <div class="progress progress-xs mb-0">
                                                                <div class="progress-bar bg-success" role="progressbar" data-bs-toggle="tooltip" title="40%" style="width: 40%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="dropdown dropdown-action profile-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_project"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_project"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                </div>
                                                            </div>
                                                            <h4 class="project-title"><a href="{{route('admin.project-view')}}">Project Management</a></h4>
                                                            <small class="block text-ellipsis m-b-15">
                                                                <span class="text-xs">2</span> <span class="text-muted">open tasks, </span>
                                                                <span class="text-xs">5</span> <span class="text-muted">tasks completed</span>
                                                            </small>
                                                            <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. When an unknown printer took a galley of type and
                                                                scrambled it...
                                                            </p>
                                                            <div class="pro-deadline m-b-15">
                                                                <div class="sub-title">
                                                                    Deadline:
                                                                </div>
                                                                <div class="text-muted">
                                                                    17 Apr 2019
                                                                </div>
                                                            </div>
                                                            <div class="project-members m-b-15">
                                                                <div>Project Leader :</div>
                                                                <ul class="team-members">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}"></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="project-members m-b-15">
                                                                <div>Team :</div>
                                                                <ul class="team-members">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="John Doe"><img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Richard Miles"><img alt="" src="{{asset('public/assets/img/profiles/avatar-09.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="John Smith"><img alt="" src="{{asset('public/assets/img/profiles/avatar-10.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Mike Litorus"><img alt="" src="{{asset('public/assets/img/profiles/avatar-05.jpg')}}"></a>
                                                                    </li>
                                                                    <li class="dropdown avatar-dropdown">
                                                                        <a href="#" class="all-users dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">+15</a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <div class="avatar-group">
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-09.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-10.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-05.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-11.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-12.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-13.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-01.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}">
                                                                                </a>
                                                                            </div>
                                                                            <div class="avatar-pagination">
                                                                                <ul class="pagination">
                                                                                    <li class="page-item">
                                                                                        <a class="page-link" href="#" aria-label="Previous">
                                                                                            <span aria-hidden="true">«</span>
                                                                                            <span class="visually-hidden">Previous</span>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                                                    <li class="page-item">
                                                                                        <a class="page-link" href="#" aria-label="Next">
                                                                                            <span aria-hidden="true">»</span>
                                                                                        <span class="visually-hidden">Next</span>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <p class="m-b-5">Progress <span class="text-success float-end">40%</span></p>
                                                            <div class="progress progress-xs mb-0">
                                                                <div class="progress-bar bg-success" role="progressbar" data-bs-toggle="tooltip" title="40%" style="width: 40%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="dropdown dropdown-action profile-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_project"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_project"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                </div>
                                                            </div>
                                                            <h4 class="project-title"><a href="{{route('admin.project-view')}}">Video Calling App</a></h4>
                                                            <small class="block text-ellipsis m-b-15">
                                                                <span class="text-xs">3</span> <span class="text-muted">open tasks, </span>
                                                                <span class="text-xs">3</span> <span class="text-muted">tasks completed</span>
                                                            </small>
                                                            <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. When an unknown printer took a galley of type and
                                                                scrambled it...
                                                            </p>
                                                            <div class="pro-deadline m-b-15">
                                                                <div class="sub-title">
                                                                    Deadline:
                                                                </div>
                                                                <div class="text-muted">
                                                                    17 Apr 2019
                                                                </div>
                                                            </div>
                                                            <div class="project-members m-b-15">
                                                                <div>Project Leader :</div>
                                                                <ul class="team-members">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}"></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="project-members m-b-15">
                                                                <div>Team :</div>
                                                                <ul class="team-members">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="John Doe"><img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Richard Miles"><img alt="" src="{{asset('public/assets/img/profiles/avatar-09.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="John Smith"><img alt="" src="{{asset('public/assets/img/profiles/avatar-10.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Mike Litorus"><img alt="" src="{{asset('public/assets/img/profiles/avatar-05.jpg')}}"></a>
                                                                    </li>
                                                                    <li class="dropdown avatar-dropdown">
                                                                        <a href="#" class="all-users dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">+15</a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <div class="avatar-group">
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-09.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-10.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-05.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-11.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-12.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-13.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-01.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}">
                                                                                </a>
                                                                            </div>
                                                                            <div class="avatar-pagination">
                                                                                <ul class="pagination">
                                                                                    <li class="page-item">
                                                                                        <a class="page-link" href="#" aria-label="Previous">
                                                                                            <span aria-hidden="true">«</span>
                                                                                            <span class="visually-hidden">Previous</span>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                                                    <li class="page-item">
                                                                                        <a class="page-link" href="#" aria-label="Next">
                                                                                            <span aria-hidden="true">»</span>
                                                                                        <span class="visually-hidden">Next</span>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <p class="m-b-5">Progress <span class="text-success float-end">40%</span></p>
                                                            <div class="progress progress-xs mb-0">
                                                                <div class="progress-bar bg-success" role="progressbar" data-bs-toggle="tooltip" title="40%" style="width: 40%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="dropdown dropdown-action profile-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_project"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_project"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                </div>
                                                            </div>
                                                            <h4 class="project-title"><a href="{{route('admin.project-view')}}">Hospital Administration</a></h4>
                                                            <small class="block text-ellipsis m-b-15">
                                                                <span class="text-xs">12</span> <span class="text-muted">open tasks, </span>
                                                                <span class="text-xs">4</span> <span class="text-muted">tasks completed</span>
                                                            </small>
                                                            <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. When an unknown printer took a galley of type and
                                                                scrambled it...
                                                            </p>
                                                            <div class="pro-deadline m-b-15">
                                                                <div class="sub-title">
                                                                    Deadline:
                                                                </div>
                                                                <div class="text-muted">
                                                                    17 Apr 2019
                                                                </div>
                                                            </div>
                                                            <div class="project-members m-b-15">
                                                                <div>Project Leader :</div>
                                                                <ul class="team-members">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}"></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="project-members m-b-15">
                                                                <div>Team :</div>
                                                                <ul class="team-members">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="John Doe"><img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Richard Miles"><img alt="" src="{{asset('public/assets/img/profiles/avatar-09.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="John Smith"><img alt="" src="{{asset('public/assets/img/profiles/avatar-10.jpg')}}"></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="tooltip" title="Mike Litorus"><img alt="" src="{{asset('public/assets/img/profiles/avatar-05.jpg')}}"></a>
                                                                    </li>
                                                                    <li class="dropdown avatar-dropdown">
                                                                        <a href="#" class="all-users dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">+15</a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <div class="avatar-group">
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-09.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-10.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-05.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-11.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-12.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-13.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-01.jpg')}}">
                                                                                </a>
                                                                                <a class="avatar avatar-xs" href="#">
                                                                                    <img alt="" src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}">
                                                                                </a>
                                                                            </div>
                                                                            <div class="avatar-pagination">
                                                                                <ul class="pagination">
                                                                                    <li class="page-item">
                                                                                        <a class="page-link" href="#" aria-label="Previous">
                                                                                            <span aria-hidden="true">«</span>
                                                                                            <span class="visually-hidden">Previous</span>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                                                    <li class="page-item">
                                                                                        <a class="page-link" href="#" aria-label="Next">
                                                                                            <span aria-hidden="true">»</span>
                                                                                        <span class="visually-hidden">Next</span>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <p class="m-b-5">Progress <span class="text-success float-end">40%</span></p>
                                                            <div class="progress progress-xs mb-0">
                                                                <div class="progress-bar bg-success" role="progressbar" data-bs-toggle="tooltip" title="40%" style="width: 40%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane" id="results_clients">

                                            <div class="row staff-grid-row">
                                                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                                                    <div class="profile-widget">
                                                        <div class="profile-img">
                                                            <a href="client-{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-19.jpg')}}"></a>
                                                        </div>
                                                        <div class="dropdown profile-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                        </div>
                                                        <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Global Technologies</a></h4>
                                                        <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Barry Cuda</a></h5>
                                                        <div class="small text-muted">CEO</div>
                                                        <a href="chat.php" class="btn btn-white btn-sm m-t-10">Message</a>
                                                        <a href="client-{{route('admin.admin-profile')}}" class="btn btn-white btn-sm m-t-10">View Profile</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                                                    <div class="profile-widget">
                                                        <div class="profile-img">
                                                            <a href="client-{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-29.jpg')}}"></a>
                                                        </div>
                                                        <div class="dropdown profile-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                        </div>
                                                        <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Delta Infotech</a></h4>
                                                        <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Tressa Wexler</a></h5>
                                                        <div class="small text-muted">Manager</div>
                                                        <a href="chat.php" class="btn btn-white btn-sm m-t-10">Message</a>
                                                        <a href="client-{{route('admin.admin-profile')}}" class="btn btn-white btn-sm m-t-10">View Profile</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                                                    <div class="profile-widget">
                                                        <div class="profile-img">
                                                            <a href="client-{{route('admin.admin-profile')}}" class="avatar"><img src="{{asset('public/assets/img/profiles/avatar-07.jpg')}}" alt=""></a>
                                                        </div>
                                                        <div class="dropdown profile-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                        </div>
                                                        <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Cream Inc</a></h4>
                                                        <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Ruby Bartlett</a></h5>
                                                        <div class="small text-muted">CEO</div>
                                                        <a href="chat.php" class="btn btn-white btn-sm m-t-10">Message</a>
                                                        <a href="client-{{route('admin.admin-profile')}}" class="btn btn-white btn-sm m-t-10">View Profile</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                                                    <div class="profile-widget">
                                                        <div class="profile-img">
                                                            <a href="client-{{route('admin.admin-profile')}}" class="avatar"><img src="{{asset('public/assets/img/profiles/avatar-06.jpg')}}" alt=""></a>
                                                        </div>
                                                        <div class="dropdown profile-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                        </div>
                                                        <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Wellware Company</a></h4>
                                                        <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Misty Tison</a></h5>
                                                        <div class="small text-muted">CEO</div>
                                                        <a href="chat.php" class="btn btn-white btn-sm m-t-10">Message</a>
                                                        <a href="client-{{route('admin.admin-profile')}}" class="btn btn-white btn-sm m-t-10">View Profile</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                                                    <div class="profile-widget">
                                                        <div class="profile-img">
                                                            <a href="client-{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-14.jpg')}}"></a>
                                                        </div>
                                                        <div class="dropdown profile-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                        </div>
                                                        <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Mustang Technologies</a></h4>
                                                        <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Daniel Deacon</a></h5>
                                                        <div class="small text-muted">CEO</div>
                                                        <a href="chat.php" class="btn btn-white btn-sm m-t-10">Message</a>
                                                        <a href="client-{{route('admin.admin-profile')}}" class="btn btn-white btn-sm m-t-10">View Profile</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                                                    <div class="profile-widget">
                                                        <div class="profile-img">
                                                            <a href="client-{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-18.jpg')}}"></a>
                                                        </div>
                                                        <div class="dropdown profile-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                        </div>
                                                        <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">International Software Inc</a></h4>
                                                        <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Walter Weaver</a></h5>
                                                        <div class="small text-muted">CEO</div>
                                                        <a href="chat.php" class="btn btn-white btn-sm m-t-10">Message</a>
                                                        <a href="client-{{route('admin.admin-profile')}}" class="btn btn-white btn-sm m-t-10">View Profile</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                                                    <div class="profile-widget">
                                                        <div class="profile-img">
                                                            <a href="client-{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-28.jpg')}}"></a>
                                                        </div>
                                                        <div class="dropdown profile-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                        </div>
                                                        <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Mercury Software Inc</a></h4>
                                                        <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Amanda Warren</a></h5>
                                                        <div class="small text-muted">CEO</div>
                                                        <a href="chat.php" class="btn btn-white btn-sm m-t-10">Message</a>
                                                        <a href="client-{{route('admin.admin-profile')}}" class="btn btn-white btn-sm m-t-10">View Profile</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                                                    <div class="profile-widget">
                                                        <div class="profile-img">
                                                            <a href="client-{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-13.jpg')}}"></a>
                                                        </div>
                                                        <div class="dropdown profile-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                        </div>
                                                        <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Carlson Tech</a></h4>
                                                        <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-{{route('admin.admin-profile')}}">Betty Carlson</a></h5>
                                                        <div class="small text-muted">CEO</div>
                                                        <a href="chat.php" class="btn btn-white btn-sm m-t-10">Message</a>
                                                        <a href="client-{{route('admin.admin-profile')}}" class="btn btn-white btn-sm m-t-10">View Profile</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane" id="results_users">
                                            <div class="table-responsive">
                                                <table class="table table-striped custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Company</th>
                                                            <th>Created Date</th>
                                                            <th>Role</th>
                                                            <th class="text-end">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="{{route('admin.admin-profile')}}" class="avatar"><img src="{{asset('public/assets/img/profiles/avatar-21.jpg')}}" alt=""></a>
                                                                    <a href="{{route('admin.admin-profile')}}">Daniel Porter <span>Admin</span></a>
                                                                </h2>
                                                            </td>
                                                            <td>danielporter@example.com</td>
                                                            <td>Dreamguy's Technologies</td>
                                                            <td>1 Jan 2013</td>
                                                            <td>
                                                                <span class="badge bg-inverse-danger">Admin</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}"></a>
                                                                    <a href="{{route('admin.admin-profile')}}">John Doe <span>Web Designer</span></a>
                                                                </h2>
                                                            </td>
                                                            <td>johndoe@example.com</td>
                                                            <td>Dreamguy's Technologies</td>
                                                            <td>1 Jan 2013</td>
                                                            <td>
                                                            <span class="badge bg-inverse-success">Employee</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-09.jpg')}}"></a>
                                                                    <a href="{{route('admin.admin-profile')}}">Richard Miles <span>Admin</span></a>
                                                                </h2>
                                                            </td>
                                                            <td>richardmiles@example.com</td>
                                                            <td>Dreamguy's Technologies</td>
                                                            <td>1 Jan 2013</td>
                                                            <td>
                                                                <span class="badge bg-inverse-success">Employee</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-10.jpg')}}"></a>
                                                                    <a href="{{route('admin.admin-profile')}}">John Smith <span>Android Developer</span></a>
                                                                </h2>
                                                            </td>
                                                            <td>johnsmith@example.com</td>
                                                            <td>Dreamguy's Technologies</td>
                                                            <td>1 Jan 2013</td>
                                                            <td>
                                                                <span class="badge bg-inverse-success">Employee</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-05.jpg')}}"></a>
                                                                    <a href="{{route('admin.admin-profile')}}">Mike Litorus <span>IOS Developer</span></a>
                                                                </h2>
                                                            </td>
                                                            <td>mikelitorus@example.com</td>
                                                            <td>Dreamguy's Technologies</td>
                                                            <td>1 Jan 2013</td>
                                                            <td>
                                                                <span class="badge bg-inverse-success">Employee</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="{{route('admin.admin-profile')}}" class="avatar"><img alt="" src="{{asset('public/assets/img/profiles/avatar-11.jpg')}}"></a>
                                                                    <a href="{{route('admin.admin-profile')}}">Wilmer Deluna <span>Team Leader</span></a>
                                                                </h2>
                                                            </td>
                                                            <td>wilmerdeluna@example.com</td>
                                                            <td>Dreamguy's Technologies</td>
                                                            <td>1 Jan 2013</td>
                                                            <td>
                                                                <span class="badge bg-inverse-success">Employee</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="{{route('admin.admin-profile')}}" class="avatar"><img src="{{asset('public/assets/img/profiles/avatar-19.jpg')}}" alt=""></a>
                                                                    <a href="{{route('admin.admin-profile')}}">Barry Cuda <span>Global Technologies</span></a>
                                                                </h2>
                                                            </td>
                                                            <td>barrycuda@example.com</td>
                                                            <td>Global Technologies</td>
                                                            <td>1 Jan 2013</td>
                                                            <td>
                                                                <span class="badge bg-inverse-info">Client</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    <!-- /Content End -->

                </div>
                <!-- /Page Content -->

            </div>
            <!-- /Page Wrapper -->






@endsection
