@extends('admin/layouts/head-main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <title>Staff Profile</title>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">

                <div class="col-md-12">

                    <div class="card mt-3" style="padding: 3pc;margin-right: 33px;">
                        <div class="row">
                            <div class="col-9">
                                <div class="row">
                            <div class="col-md-2 fw-bold ">
                                <p>First Name</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->first_name}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p>Last Name</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->last_name}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p> Email</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->email}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p>DOB</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->dob}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p>DOJ</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->joiing_date}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p>Branch</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->branch}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p>Department </p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->department}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p>Position</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->position}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p>Work Type</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->work_type}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p>Phone</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->phone}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p> Mobile(personal)</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->personal_phone}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p>Mobile( Company)</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->company_mobile}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 fw-bold">
                                <p>Company</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{$employees->client->client_company_name}}</p>
                            </div>
                        </div>
                       
                            </div>
                            
                        <div class="col-3">
                            @if (!empty($employees->avatar_filename))
                                <img src="{{ asset('staff/storage/avatars/' . $employees->avatar_directory . '/' . $employees->avatar_filename) }}"
                                    alt=""  width="60%" style="width: 150px;border-radius: 85px;margin-top:20px;height: 150px!important;" class="ms-5">
                            @else
                                <img src="{{ asset('public/assets/img/user.jpg/') }}" alt=""  width="60%" style="width: 150px;border-radius: 85px;margin-top:20px;height: 150px!important;" class="ms-5">
                            @endif
                        </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        @endsection
