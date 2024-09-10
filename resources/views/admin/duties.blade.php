@extends('admin/layouts/head-main')
@section('title', 'Duties')
@section('content')



   <!-- Page Wrapper -->
            <div class="page-wrapper">

                <!-- Page Content -->
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Duties</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Admin</li>
                                </ul>
                            </div>
                            <div class="col-auto float-end ms-auto">
                                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_duties"><i class="fa fa-plus"></i> Add Duties</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Duty Name </th>
                                            <th>status</th>
                                            <!-- <th>Sub-Category Name</th> -->
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($duties as $index => $duty)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $duty->name }}</td>
                                            <td>
                                                <!-- Toggle Switch -->
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $duty->id }}" {{ $duty->status ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <!-- <td>Hardware Expenses</td> -->
                                            <td class="text-end">
                                                <div class="dropdown-action">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit_duties{{$duty->id}}"><i class="fa fa-pencil m-r-5"></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                    <!-- Edit Duty Modal -->
                                    <div class="modal custom-modal fade" id="edit_duties{{$duty->id}}" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Duties</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('admin.duties.update', $duty->id)}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                        <div class="form-group">
                                                            <label>Duties Name <span class="text-danger">*</span></label>
                                                            <input class="form-control" name="name" type="text" value="{{$duty->name}}">
                                                        </div>
                    
                                                        <div class="submit-section">
                                                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Edit Duty Modal -->
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Content -->

                <!-- Add Holiday Modal -->
                <div class="modal custom-modal fade" id="add_duties" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Duties</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.duties.store')}}" method="post">
                                @csrf
                                    <div class="form-group">
                                        <label>Duties Name <span class="text-danger">*</span></label>
                                        <input class="form-control" name="name" type="text">
                                    </div>

                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Add Holiday Modal -->
            </div>
            <!-- /Page Wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-toggle').change(function() {
            var dutyId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("admin.duties.updateStatus") }}', // Change this to your actual route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: dutyId,
                    status: status
                },
                success: function(response) {
                    //alert('Duty status updated successfully!');
                    
                    window.location.reload();
                },
                error: function(response) {
                    alert('Failed to update duty status.');
                }
            });
        });
    });
</script>


@endsection
