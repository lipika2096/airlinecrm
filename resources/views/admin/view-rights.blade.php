@extends('admin/layouts/head-main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <title>
    Agent Profile</title>
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
                        <h3 class="page-title">User Rights</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">User Rights</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->


           

            

                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <div class="card profile-box flex-fill">
                                                <div class="col-auto float-end ms-auto mt-2 mx-2">
                                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                                        style="border-radius:10px;" data-bs-target="#add_target"><i
                                                            class="fa fa-plus"></i> Add / Edit
                                                        User Rights</a>

                                                    <a class="btn btn-info text-white" data-bs-toggle="modal"
                                                        style="margin-right:10px; border-radius:10px !important;"
                                                        data-bs-target="#view_fares"><i class="fa fa-plus"></i> View
                                                        User Rights</a>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped custom-table mb-0 datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Department</th>
                                                                    <th>Duties</th>
                                                                    <th>Status</th>
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($department_rights as $fare)
                                                                    <tr>
                                                                        <td>{{ $fare->department->department_name }}</td>
                                                                        <td>{{ $fare->duty->name }}</td>
                                                                        <td>
                                                                            @if($fare->status == 1)
                                                                            Active
                                                                            @else
                                                                            Inactive
                                                                            @endif
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                <!-- Repeat for other agents -->
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                                <div id="add_target" class="modal custom-modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Add Rights</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('admin.employee.rights.store') }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="table-responsive text-nowrap">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="fw-bold">Department
                                                                                    </th>
                                                                                    @foreach ($duties as $ft)
                                                                                        <th class="fw-bold">
                                                                                            {{ $ft->name }}</th>
                                                                                    @endforeach
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($department as $air)
                                                                                    <tr>
                                                                                        <div class="form-group">
                                                                                            <input class="form-control"
                                                                                                type="hidden"
                                                                                                name="staff_id"
                                                                                                value="0">
                                                                                        </div>
                                                                                        <th class="fw-bold">
                                                                                            {{ $air->department_name }}</th>
                                                                                        @foreach ($duties as $ft)
                                                                                            @php
                                                                                                $status = DB::table(
                                                                                                    'department_rights',
                                                                                                )
                                                                                                    ->where(
                                                                                                        'department_id',
                                                                                                        $air->id,
                                                                                                    )
                                                                                                    ->where(
                                                                                                        'duties_id',
                                                                                                        $ft->name,
                                                                                                    )
                                                                                                    ->value('status');
                                                                                            @endphp
                                                                                            <input type="hidden"
                                                                                                name="department[{{ $air->id }}][{{ $ft->id }}]"
                                                                                                value="2">
                                                                                            <th>
                                                                                                <input type="checkbox"
                                                                                                    name="department[{{ $air->id }}][{{ $ft->id }}]"
                                                                                                    value="1"
                                                                                                    {{ $status == 1 ? 'checked' : '' }}>
                                                                                            </th>
                                                                                        @endforeach
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="submit-section">
                                                                        <button class="btn btn-primary"
                                                                            type="submit">Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="view_fares" class="modal custom-modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Add Target</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{-- <form action="{{ route('admin.employee.rights.store') }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf --}}
                                                                <div class="table-responsive text-nowrap">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="fw-bold">
                                                                                    Department</th>
                                                                                @foreach ($duties as $ft)
                                                                                    <th class="fw-bold">
                                                                                        {{ $ft->name }}
                                                                                    </th>
                                                                                @endforeach
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($department as $air)
                                                                                <tr>
                                                                                    <div class="form-group">
                                                                                        <input class="form-control"
                                                                                            type="hidden" name="staff_id"
                                                                                            value="null">
                                                                                    </div>
                                                                                    <th class="fw-bold">
                                                                                        {{ $air->department_name }}
                                                                                    </th>
                                                                                    @foreach ($duties as $ft)
                                                                                        @php
                                                                                            $status = DB::table(
                                                                                                'department_rights',
                                                                                            )
                                                                                                ->where(
                                                                                                    'department_id',
                                                                                                    $air->id,
                                                                                                )
                                                                                                ->where(
                                                                                                    'duties_id',
                                                                                                    $ft->id,
                                                                                                )
                                                                                                ->value('status');
                                                                                        @endphp
                                                                                        <input type="hidden"
                                                                                            name="department[{{ $air->id }}][{{ $ft->id }}]"
                                                                                            value="2">
                                                                                        <th>
                                                                                            <input type="checkbox"
                                                                                                name="department[{{ $air->id }}][{{ $ft->id }}]"
                                                                                                value="1"
                                                                                                {{ $status == 1 ? 'checked' : '' }}>
                                                                                        </th>
                                                                                    @endforeach
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                {{-- </form> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<script>
    document.addEventListener('input', function (e) {
        if (e.target.type === 'number') {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        }
    });
</script>

        @endsection
