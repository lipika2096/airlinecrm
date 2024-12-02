@extends('admin/layouts/head-main')
@section('title', 'Leave Type')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Leave Type</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Leave Type</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_leavetype"><i class="fa fa-plus"></i> Add Leave Type</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Leave Type</th>
                                    {{-- <th>Leave Days</th> --}}
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaves as $index => $leave)
                                <tr>
                                    <td>
                                        {{ $index + 1 }}
                                    </td>
                                    <td>{{$leave->name}}</td>
                                    {{-- <td>{{$leave->days}}</td> --}}
                                    <td>
                                        <!-- Toggle Switch -->
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $leave->id }}" {{ $leave->status ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown-action">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#edit_leavetype{{$leave->id}}"><i class="fa fa-pencil m-r-5"></i></a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#delete_leavetype{{$leave->id}}"><i class="fa fa-trash m-r-5"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Edit Leavetype Modal -->
                                <div id="edit_leavetype{{$leave->id}}" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Leave Type</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('admin.leave-type.update',$leave->id)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                    <div class="form-group">
                                                        <label>Leave Type <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="name" type="text" value="{{$leave->name}}">
                                                    </div>
                                                    <div class="form-group">
                                                        {{-- <label>Number of days <span class="text-danger">*</span></label> --}}
                                                        <input class="form-control" name="days" type="hidden" value="0">
                                                    </div>
                                                    <div class="submit-section">
                                                        <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Edit Leavetype Modal -->
                                <!-- Edit Leavetype Modal -->
                                <div id="delete_leavetype{{$leave->id}}" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Leave Type</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('admin.leave-type.delete',$leave->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <p>Are you sure you want to delete
                                                        <strong>{{$leave->name}}</strong>  Leave Type?
                                                    </p>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Delete Leavetype Modal -->
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Leavetype Modal -->
        <div id="add_leavetype" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leave Type</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.leave-type.store')}}" method="post">
                        @csrf
                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" type="text">
                            </div>
                            <div class="form-group">
                                {{-- <label>Number of days <span class="text-danger">*</span></label> --}}
                                <input class="form-control" name="days" type="hidden" value="0">
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Leavetype Modal -->



        <!-- Delete Leavetype Modal -->
        <div class="modal custom-modal fade" id="delete_leavetype" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Leave Type</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Leavetype Modal -->

    </div>
    <!-- /Page Wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-toggle').change(function() {
            var leaveTypeId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("admin.leave-type.updateStatus") }}', // Change this to your actual route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: leaveTypeId,
                    status: status
                },
                success: function(response) {
                    //alert('Leave Type status updated successfully!');

                    window.location.reload();
                },
                error: function(response) {
                    alert('Failed to update Leave Type status.');
                }
            });
        });
    });
</script>


@endsection
