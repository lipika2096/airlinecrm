@extends('admin/layouts/head-main')
@section('content')

<title>Designations</title>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">License Approvals Details</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">License Approvals Details</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#addFlightModal"><i class="fa fa-plus"></i> Add</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <table class="table table-striped custom-table mb-0 datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Staff</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($licenseApprovals as $licenseApproval)
                <tr>
                    <td>{{ $licenseApproval->id}}</td>
                    <td>{{ $licenseApproval->staff->first_name }} {{ $licenseApproval->staff->last_name }}</td>
                    <td><a href="{{ asset('storage/' . $licenseApproval->file) }}" target="_blank">View File</a></td>
                    <td>
                        {{-- {{dd($licenseApproval)}} --}}
                        <div class="dropdown action-label dropdown-item">
                            @if($licenseApproval->status)
                            <a class="btn btn-white btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#status_update{{ $licenseApproval->id }}" style="text-transform:capitalize;">
                                <i class="fa fa-dot-circle-o text-purple"></i>
                                {{ $licenseApproval->status }}
                            </a>
                            @else
                            <span class="btn btn-white btn-sm btn-rounded">No Status</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('admin.license_approvals.destroy', $licenseApproval->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-icon" onclick="return confirm('Are you sure you want to delete this license approval?')" style="border:none;background:none;padding:0;color:inherit;"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- status change modal-->
                <div id="status_update{{ $licenseApproval->id }}" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Todo Status</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.license_approvals.updateStatus', $licenseApproval->id) }}" method="POST" enctype="multipart/form-data">
                                    @method('patch')
                                    @csrf
                                    <div class="form-group">
                                        <label>Status<span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option>Select Status</option>
                                            <option>Pending</option>
                                            <option>Approved</option>
                                            <option>Rejected</option>
                                        </select>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /status change modal-->
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="addFlightModal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create License Approval</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('admin.license.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="staff_id">Staff</label>
                            <select name="staff_id" id="staff_id" class="form-control">
                                <option Value="">Select</option>
                                @foreach($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
