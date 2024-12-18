@extends('admin/layouts/head-main')
@section('content')
    <title>Salary</title>
    <style>
.form-control {height:35px;}

</style>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Employee Salary</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Salary</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i
                                class="fa fa-plus"></i> Add Salary</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
            <!--<div class="row filter-row">-->
            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
            <!--        <div class="form-group form-focus">-->
            <!--            <input type="text" class="form-control floating">-->
            <!--            <label class="focus-label">Employee Name</label>-->
            <!--        </div>-->
            <!--   </div>-->
            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
            <!--        <div class="form-group form-focus select-focus">-->
            <!--            <select class="select floating">-->
            <!--                <option value=""> -- Select -- </option>-->
            <!--                <option value="">Employee</option>-->
            <!--                <option value="1">Manager</option>-->
            <!--            </select>-->
            <!--            <label class="focus-label">Role</label>-->
            <!--        </div>-->
            <!--   </div>-->
            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
            <!--        <div class="form-group form-focus select-focus">-->
            <!--            <select class="select floating">-->
            <!--                <option> -- Select -- </option>-->
            <!--                <option> Pending </option>-->
            <!--                <option> Approved </option>-->
            <!--                <option> Rejected </option>-->
            <!--            </select>-->
            <!--            <label class="focus-label">Leave Status</label>-->
            <!--        </div>-->
            <!--   </div>-->
            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
            <!--        <div class="form-group form-focus">-->
            <!--            <div class="cal-icon">-->
            <!--                <input class="form-control floating datetimepicker" type="text">-->
            <!--            </div>-->
            <!--            <label class="focus-label">From</label>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
            <!--        <div class="form-group form-focus">-->
            <!--            <div class="cal-icon">-->
            <!--                <input class="form-control floating datetimepicker" type="text">-->
            <!--            </div>-->
            <!--            <label class="focus-label">To</label>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">-->
            <!--        <a href="#" class="btn btn-success w-100"> Search </a>-->
            <!--    </div>-->
            <!--</div>-->
            <!-- /Search Filter -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Employee ID</th>
                                    <th>Email</th>
                                    <th>Join Date</th>
                                    <th>Role</th>
                                    <th>Salary</th>
                                    <!--<th>Document</th>-->
                                    <th>Payslip</th>
                                    <!--<th class="text-end">Action</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employeeSalaryId as $data)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript:void()">{{ $data->user->first_name }}
                                                    {{ $data->user->last_name }}</a>
                                            </h2>
                                        </td>
                                        <td>{{ $data->user->unique_id }}</td>
                                        <td>{{ $data->user->email }}</td>
                                        <td>{{ $data->user->joining_date }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a href=""
                                                    class="btn btn-white btn-sm btn-rounded "aria-expanded="false">{{ $data->user->position }}
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ $data->salary }}</td>
                                        <td><a class="btn btn-sm btn-primary"
                                                href="{{ asset('public/assets/docs/' . $data->salary_doc) }}">View Slip</a>
                                        </td>
                                        <!--<td><a class="btn btn-sm btn-primary" href="{{ route('admin.salary-view', ['id' => $data->id]) }}">Generate Slip</a></td>-->
                                        <!--<td class="text-end">-->
                                        <!--    <div class="dropdown dropdown-action">-->
                                        <!--        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>-->
                                        <!--        <div class="dropdown-menu dropdown-menu-right">-->
                                        <!--            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_salary"><i class="fa fa-pencil m-r-5"></i> Edit</a>-->
                                        <!--       </div>-->
                                        <!--    </div>-->
                                        <!--</td>-->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Salary Modal -->
        <div id="add_salary" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Staff Salary</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form id="salaryForm" method="post" action="{{ route('admin.manage-salary.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $id }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select Month</label>
                                        <select class="select" name="month">
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select Year</label>
                                        <select class="select" name="year">
                                            @for ($year = date('Y'); $year >= date('Y') - 10; $year--)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">


                                <div class="col-sm-6">
                                    <label>Salary Doc.</label>
                                    <input id="salary_doc" class="form-control" type="file" name="salary_doc">
                                </div>

                                <div class="col-sm-6">
                                    <label>Net Salary</label>
                                    <input id="netSalary" class="form-control" type="text" readonly name="netsalary">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="text-primary">Earnings</h4>
                                    <div class="form-group">
                                        <label>Basic</label>
                                        <input id="basic" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="basic">
                                    </div>
                                    <div class="form-group">
                                        <label>DA(40%)</label>
                                        <input id="da" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="da">
                                    </div>
                                    <div class="form-group">
                                        <label>HRA(15%)</label>
                                        <input id="hra" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="hra">
                                    </div>
                                    <div class="form-group">
                                        <label>Conveyance</label>
                                        <input id="conveyance" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="conveyance">
                                    </div>
                                    <div class="form-group">
                                        <label>Allowance</label>
                                        <input id="allowance" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="allowance">
                                    </div>
                                    <div class="form-group">
                                        <label>Medical Allowance</label>
                                        <input id="medicalAllowance" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="medical_allowance">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="text-primary">Deductions</h4>
                                    <div class="form-group">
                                        <label>TDS</label>
                                        <input id="tds" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="tds">
                                    </div>
                                    <div class="form-group">
                                        <label>ESI</label>
                                        <input id="esi" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="esi">
                                    </div>
                                    <div class="form-group">
                                        <label>PF</label>
                                        <input id="pf" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="pf">
                                    </div>
                                    <div class="form-group">
                                        <label>Leave</label>
                                        <input id="leave" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="leave_dd">
                                    </div>
                                    <div class="form-group">
                                        <label>Prof. Tax</label>
                                        <input id="profTax" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="prof_tax">
                                    </div>
                                    <div class="form-group">
                                        <label>Labour Welfare</label>
                                        <input id="labourWelfare" class="form-control" type="text"
                                            oninput="calculateNetSalary()" name="labour_welfare">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Salary Modal -->

        <!-- Edit Salary Modal -->
        <div id="edit_salary" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Staff Salary</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select Staff</label>
                                        <select class="select">
                                            <option>John Doe</option>
                                            <option>Richard Miles</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Net Salary</label>
                                    <input class="form-control" type="text" value="$4000">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="text-primary">Earnings</h4>
                                    <div class="form-group">
                                        <label>Basic</label>
                                        <input class="form-control" type="text" value="$6500">
                                    </div>
                                    <div class="form-group">
                                        <label>DA(40%)</label>
                                        <input class="form-control" type="text" value="$2000">
                                    </div>
                                    <div class="form-group">
                                        <label>HRA(15%)</label>
                                        <input class="form-control" type="text" value="$700">
                                    </div>
                                    <div class="form-group">
                                        <label>Conveyance</label>
                                        <input class="form-control" type="text" value="$70">
                                    </div>
                                    <div class="form-group">
                                        <label>Allowance</label>
                                        <input class="form-control" type="text" value="$30">
                                    </div>
                                    <div class="form-group">
                                        <label>Medical Allowance</label>
                                        <input class="form-control" type="text" value="$20">
                                    </div>
                                    <div class="form-group">
                                        <label>Others</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="text-primary">Deductions</h4>
                                    <div class="form-group">
                                        <label>TDS</label>
                                        <input class="form-control" type="text" value="$300">
                                    </div>
                                    <div class="form-group">
                                        <label>ESI</label>
                                        <input class="form-control" type="text" value="$20">
                                    </div>
                                    <div class="form-group">
                                        <label>PF</label>
                                        <input class="form-control" type="text" value="$20">
                                    </div>
                                    <div class="form-group">
                                        <label>Leave</label>
                                        <input class="form-control" type="text" value="$250">
                                    </div>
                                    <div class="form-group">
                                        <label>Prof. Tax</label>
                                        <input class="form-control" type="text" value="$110">
                                    </div>
                                    <div class="form-group">
                                        <label>Labour Welfare</label>
                                        <input class="form-control" type="text" value="$10">
                                    </div>
                                    <div class="form-group">
                                        <label>Fund</label>
                                        <input class="form-control" type="text" value="$40">
                                    </div>
                                    <div class="form-group">
                                        <label>Others</label>
                                        <input class="form-control" type="text" value="$15">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Salary Modal -->

        <!-- Delete Salary Modal -->
        <div class="modal custom-modal fade" id="delete_salary" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Salary</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal"
                                        class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Salary Modal -->

    </div>
    <!-- /Page Wrapper -->


    <script>
        function calculateNetSalary() {
            // Get the values from the earnings fields
            const basic = parseFloat(document.getElementById('basic').value) || 0;
            const da = parseFloat(document.getElementById('da').value) || 0;
            const hra = parseFloat(document.getElementById('hra').value) || 0;
            const conveyance = parseFloat(document.getElementById('conveyance').value) || 0;
            const allowance = parseFloat(document.getElementById('allowance').value) || 0;
            const medicalAllowance = parseFloat(document.getElementById('medicalAllowance').value) || 0;

            // Get the values from the deductions fields
            const tds = parseFloat(document.getElementById('tds').value) || 0;
            const esi = parseFloat(document.getElementById('esi').value) || 0;
            const pf = parseFloat(document.getElementById('pf').value) || 0;
            const leave = parseFloat(document.getElementById('leave').value) || 0;
            const profTax = parseFloat(document.getElementById('profTax').value) || 0;
            const labourWelfare = parseFloat(document.getElementById('labourWelfare').value) || 0;

            // Calculate total earnings and total deductions
            const totalEarnings = basic + da + hra + conveyance + allowance + medicalAllowance;
            const totalDeductions = tds + esi + pf + leave + profTax + labourWelfare;

            // Calculate net salary
            const netSalary = totalEarnings - totalDeductions;

            // Display the net salary
            document.getElementById('netSalary').value = netSalary.toFixed(2);
        }
    </script>
@endsection
