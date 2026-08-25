@extends('admin/layouts/head-main')
@section('content')


    <title>Employees</title>



   <div class="page-wrapper">

                <!-- Page Content -->
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Manage Staff</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Manage Staff</li>
                                </ul>
                            </div>
                            <div class="col-auto float-end ms-auto">
                            {{--  <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i class="fa fa-plus"></i> Add Employee</a>--}}
                                {{-- <div class="view-icons">
                                    <a href="employees.php" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                                    <a href="employees-list.php" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

   
        <style>
            .profile-widget .user-name {
                color: #333333;
                margin-top: 30px !important;
            }
        </style>
                
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-info">
                                        <h6>Today Presents</h6>
                                        <h4>{{$noofpresentemployeestoday}} / {{$total_employee}}</h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stats-info">
                                        <h6>Total Leaves</h6>
                                        <h4>{{$total_leaves}} <span>Today</span></h4>
                                    </div>
                                </div>
                                <!--<div class="col-md-3">-->
                                <!--    <div class="stats-info">-->
                                <!--        <h6>Unplanned Leaves</h6>-->
                                <!--        <h4>0 <span>Today</span></h4>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="col-md-4">
                                    <div class="stats-info">
                                        <h6>Pending Requests</h6>
                                        <h4>{{$total_pending_leaves}}</h4>
                                    </div>
                                </div>
                            </div>


                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Picture</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Airlines</th>
                                                <th>Department</th>
                                                <th>Position</th>
                                                <th>Staff No</th>
                                                <th>DOJ</th>
                                                <th>Min Hrs</th>
                                                <th>Max Hrs</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($employees as $index => $data)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td>
                                                        @if(!empty($data->avatar_filename))
                                                            <img src="{{ asset('staff/storage/avatars/'.$data->avatar_directory."/" . $data->avatar_filename) }}" alt="">
                                                        @else
                                                            <img src="{{ asset('public/assets/img/user.jpg/') }}" alt="">
                                                        @endif
                                                    </td>
                                                    <td style="color:#ed5b24;">{{ $data->first_name }}</td>
                                                    <td style="color:#ed5b24;">{{ $data->last_name }}</td>
                                                    <td>@if($data->client_company_name)
                                                            {{ $data->client_company_name }}
                                                        @else
                                                            Null
                                                        @endif</td>
                                                    <td>
                                                        @if(!empty($data->department_names))
                                                            {{ implode(', ', $data->department_names) }}
                                                        @else
                                                            {{ $data->department ?? '-' }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->position }}</td>
                                                    <td>{{ $data->unique_id }}</td>
                                                    <td>{{ $data->joining_date }}</td>
                                                    <td>{{ $data->min_hrs }}</td>
                                                    <td>{{ $data->max_hrs }}</td>
                                                    <td>
                                                            <a href="{{ route('admin.manage-salary', ['id' => $data->id]) }}" class="btn btn-primary">Manage Salary</a>
                                                        </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    


                   
                </div>
                <!-- /Page Content -->

          

              
     

            </div>
            <!-- /Page Wrapper -->





@endsection
