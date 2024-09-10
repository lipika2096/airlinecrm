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
                                <h3 class="page-title">Employee</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Employee</li>
                                </ul>
                            </div>
                            <div class="col-auto float-end ms-auto">
                                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i class="fa fa-plus"></i> Add Employee</a>
                                {{-- <div class="view-icons">
                                    <a href="employees.php" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                                    <a href="employees-list.php" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <!-- Search Filter -->
                    {{-- <div class="row filter-row">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">
                                <input type="text" class="form-control floating">
                                <label class="focus-label">Employee ID</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">
                                <input type="text" class="form-control floating">
                                <label class="focus-label">Employee Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus select-focus">
                                <select class="select floating">
                                    <option>Select Designation</option>
                                    <option>Web Developer</option>
                                    <option>Web Designer</option>
                                    <option>Android Developer</option>
                                    <option>Ios Developer</option>
                                </select>
                                <label class="focus-label">Designation</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="d-grid">
                                <a href="#" class="btn btn-success w-100"> Search </a>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Search Filter -->
   
        <style>
            .profile-widget .user-name {
                color: #333333;
                margin-top: 30px !important;
            }
        </style>
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="#allstaff" data-bs-toggle="tab" class="nav-link active">All Current Staff</a></li>
                                <li class="nav-item"><a href="#branch" data-bs-toggle="tab" class="nav-link">By Department</a></li>
                            </ul>
                        </div>
                    </div>
                </div>   

                <div class="tab-content">
                    <!-- All Current Staff Tab -->
                    <div id="allstaff" class="pro-overview tab-pane fade show active">  
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
                                                    <td>{{ $data->department }}</td>
                                                    <td>{{ $data->position }}</td>
                                                    <td>{{ $data->unique_id }}</td>
                                                    <td>{{ $data->joining_date }}</td>
                                                    <td>{{ $data->min_hrs }}</td>
                                                    <td>{{ $data->max_hrs }}</td>
                                                    <td>
                                                        <div class="action-icons" style="display: flex; flex-direction: row;">
                                                        <a class="dropdown-item" href="{{ route('admin.view-staff', ['id' => $data->id]) }}">
                                                            <i class="fa fa-eye m-r-5"></i>
                                                        </a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee{{$data->id}}"><i class="fa fa-pencil m-r-5"></i></a>
                                                            <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#delete_modal_{{ $data->id }}" style="margin-right: 10px;">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>    

                    <!-- By Department Tab -->
                    <div id="branch" class="pro-overview tab-pane fade show">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Picture</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Airlines</th>
                                                <th>Position</th>
                                                <th>Staff No</th>
                                                <th>DOJ</th>
                                                <th>Min Hrs</th>
                                                <th>Max Hrs</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($departmentEmployees as $index => $data)
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
                                                    <td>
                                                        @if(!empty($data->client->client_company_name))
                                                            {{ $data->client->client_company_name }}
                                                        @else
                                                            Null
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->position }}</td>
                                                    <td>{{ $data->unique_id }}</td>
                                                    <td>{{ $data->joining_date }}</td>
                                                    <td>{{ $data->min_hrs }}</td>
                                                    <td>{{ $data->max_hrs }}</td>
                                                    <td>
                                                        
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee{{$data->id}}"><i class="fa fa-pencil m-r-5"></i></a>
                                                            <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#delete_modal_{{ $data->id }}" style="margin-right: 10px;">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


                    <div class="row staff-grid-row">
                        @foreach($employees as $data)
                        <!--<div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                            <div class="profile-widget">
                                <div class="profile-img">
                                    <a href="{{route('admin.admin-profile')}}" class="avatar">
                                        @if(!empty($data->avatar_filename))
                                            <img src="{{ asset('staff/storage/avatars/'.$data->avatar_directory."/" . $data->avatar_filename) }}" alt="">
                                        @else
                                        <img src="{{asset('public/assets/img/user.jpg/')}}" alt="">
                                        @endif
                                    </a>
                                </div>
                                <div class="dropdown profile-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee{{$data->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        {{-- <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a> --}}
                                    </div>
                                </div>
                                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="javascript:void(0)">{{$data->first_name}} {{$data->last_name}}</a></h4>
                                <div class="small text-muted">{{$data->position}}</div>
                            </div>
                        </div>-->
                 

                <!-- Edit Employee Modal -->
                <div id="edit_employee{{$data->id}}" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Employee</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.employees.edit', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">

                                @method('patch')
                                @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                                <input class="form-control"name="first_name"  value="{{$data->first_name}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Last Name</label>
                                                <input class="form-control" name="last_name" value="{{$data->last_name}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                                <input class="form-control" name="email"  value="{{$data->email}}" type="email">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                                <input type="text" name="employee_id" value="{{$data->unique_id}}" class="form-control floating">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label"></label>Joining Date<span class="text-danger">*</span></label>
                                                <input type="date" name="joining_date" value="{{$data->joining_date}}" class="form-control floating">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Phone </label>
                                                <input class="form-control" name="phone"  value="{{$data->phone}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Department <span class="text-danger">*</span></label>
                                                <select class="select" name="department">
                                                    <option>Select Department</option>
                                                    @foreach($department as $department_data)
                                                        <option value="{{$department_data->department_name}}" @if ($data->department == $department_data->department_name) selected @endif>{{$department_data->department_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Designation <span class="text-danger">*</span></label>
                                                <select class="select" name="designation">
                                                    <option>Select Designation</option>
                                                    @foreach($designation as $designation_data)
                                                        <option value="{{$designation_data->designation}}" @if ($data->position == $designation_data->designation) selected @endif>{{$designation_data->designation}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Min Hrs </label>
                                                <input class="form-control" name="min_hrs"  value="{{$data->min_hrs}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Max Hrs </label>
                                                <input class="form-control" name="max_hrs"  value="{{$data->max_hrs}}" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Edit Employee Modal -->
                <div id="delete_modal_{{ $data->id }}" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Employee</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.employee.destroy', $data->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this?');">
                                    @csrf
                                    @method('DELETE')
                                    <p>Are you sure want to delete?</p>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                        @endforeach
                    </div>
                </div>
                <!-- /Page Content -->

               <!-- Add Employee Modal -->
                <div id="add_employee" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Employee</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
 +                           <div class="modal-body">
                                <form method="post" action ="{{route('admin.employees.store')}}"  >
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="first_name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Last Name</label>
                                                <input class="form-control" type="text" name="last_name">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                                <input class="form-control" type="email" name="email">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Password</label>
                                                <input class="form-control" type="password" name="password">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="employee_id">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Total Leave <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="leave_count">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Phone </label>
                                                <input class="form-control" name="phone" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Personal Mobile </label>
                                                <input class="form-control" name="personal_phone" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Company Mobile </label>
                                                <input class="form-control" name="company_mobile" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Work Type </label>
                                                <input class="form-control" name="work_type" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Branch </label>
                                                <input class="form-control" name="branch" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Date of Birth </label>
                                                <input class="form-control" name="dob" type="date">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                                <div class=""><input class="form-control" type="date" name="joining_date"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Department <span class="text-danger">*</span></label>
                                                <select class="select form-control" name="department">
                                                    <option>Select Department</option>
                                                    @foreach($department as $department_data)
                                                        <option value="{{$department_data->department_name}}">{{$department_data->department_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Designation <span class="text-danger">*</span></label>
                                                <select class="select form-control" name="designation">
                                                    <option>Select Designation</option>
                                                    @foreach($designation as $data)
                                                        <option value="{{$data->designation}}">{{$data->designation}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Min Hrs </label>
                                                <input class="form-control" name="min_hrs" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Max Hrs </label>
                                                <input class="form-control" name="max_hrs"  type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary " type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Add Employee Modal -->

              
     

            </div>
            <!-- /Page Wrapper -->





@endsection
