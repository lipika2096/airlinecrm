@extends('admin/layouts/head-main')
@section('content')
    <title>Add Staff</title>

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add Staff</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.employees') }}">Staff List</a></li>
                            <li class="breadcrumb-item active">Add Staff</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add New Staff</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action ="{{ route('admin.employees.store') }}">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="first_name">
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Last Name<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="last_name">
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Employee ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="employee_id ">
                                    </div>

                                    <div class="col-sm-8">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" required>
                                        <small class="text-muted">A random password will be generated and sent to this email address.</small>
                                    </div>
                                    <!-- </div> -->

                                    <!-- </div> -->
                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Total Leave <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="leave_count">
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Phone </label>
                                        <input class="form-control" name="phone" type="text">
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Personal Mobile </label>
                                        <input class="form-control" name="personal_phone" type="text">
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Company Mobile </label>
                                        <input class="form-control" name="company_mobile" type="text">
                                    </div>
                                    <!-- </div> -->

                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Work Type </label>
                                        <input class="form-control" name="work_type" type="text">
                                    </div>
                                    <!-- </div> -->

                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Branch </label>
                                        <input class="form-control" name="branch" type="text">
                                    </div>
                                    <!-- </div> -->

                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Date of Birth </label>
                                        <input class="form-control" name="dob" type="date">
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Joining Date <span class="text-danger">*</span></label>
                                        <div class=""><input class="form-control" type="date" name="joining_date">
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-md-4">
                                        <!-- <div class="form-group"> -->
                                        <label>Department</label>
                                        <select class="select form-control" name="department">
                                            <option value="">No Department Selected</option>
                                            @foreach ($department as $department_data)
                                                <option value="{{ $department_data->department_name }}">
                                                    {{ $department_data->department_name }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Staff can create their own departments after login</small>
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-md-4">
                                        <!-- <div class="form-group"> -->
                                        <label>Designation</label>
                                        <select class="select form-control" name="designation">
                                            <option value="">No Designation Selected</option>
                                            @foreach ($designation as $data)
                                                <option value="{{ $data->designation }}">{{ $data->designation }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Staff can create their own designations after login</small>
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-sm-4">
                                        <!-- <div class="form-group"> -->
                                        <label class="form-label">Min Hrs </label>
                                        <input class="form-control" name="min_hrs" type="text">
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Max Hrs </label>
                                            <input class="form-control" name="max_hrs" type="text">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Date of Resignation</label>
                                            <input class="form-control" name="date_of_resignation" type="text">
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                    <div class="submit-section">
                                        <button class="btn btn-primary " type="submit">Submit</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection