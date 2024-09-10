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
                        <h3 class="page-title">View Staff</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">View Staff</li>
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


            <style>
                .profile-widget .user-name {
                    color: #333333;
                    margin-top: 30px !important;
                }
            </style>
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
                                @foreach ($employees as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if (!empty($data->avatar_filename))
                                                <img src="{{ asset('staff/storage/avatars/' . $data->avatar_directory . '/' . $data->avatar_filename) }}"
                                                    alt="">
                                            @else
                                                <img src="{{ asset('public/assets/img/user.jpg/') }}" alt="">
                                            @endif
                                        </td>
                                        <td style="color:#ed5b24;">{{ $data->first_name }}</td>
                                        <td style="color:#ed5b24;">{{ $data->last_name }}</td>
                                        <td>
                                            @if ($data->client_company_name)
                                                {{ $data->client_company_name }}
                                            @else
                                                Null
                                            @endif
                                        </td>
                                        <td>{{ $data->department }}</td>
                                        <td>{{ $data->position }}</td>
                                        <td>{{ $data->unique_id }}</td>
                                        <td>{{ $data->joining_date }}</td>
                                        <td>{{ $data->min_hrs }}</td>
                                        <td>{{ $data->max_hrs }}</td>
                                        <td>
                                            <a href="{{ route('admin.employee.list-profile', ['id' => $data->id]) }}"
                                             ><i class="fa fa-eye"></i></a>
                                                <a  data-bs-toggle="modal" data-bs-target="#edit_employee{{$data->id}}"><i class="fa fa-pencil m-r-5"></i></a>
                                        </td>
                                    </tr>
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
                                <form action="{{ route('admin.employee.update-profile', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">

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
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Personal Mobile </label>
                                                <input class="form-control" value="{{$data->personal_phone}}" name="personal_phone" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Company Mobile </label>
                                                <input class="form-control" value="{{$data->company_mobile}}" name="company_mobile" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Work Type </label>
                                                <input class="form-control" value="{{$data->work_type}}" name="work_type" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Branch </label>
                                                <input class="form-control" value="{{$data->branch}}" name="branch" type="text">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Date of Birth </label>
                                                <input class="form-control" value="{{$data->dob}}" name="dob" type="date">
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
                                <form method="post" action ="{{route('admin.employee.store-profile')}}"  >
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
                                                <select class="select" name="department">
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
                                                <select class="select" name="designation">
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
