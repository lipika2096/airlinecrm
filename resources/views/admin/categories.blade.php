@extends('admin/layouts/head-main')
@section('title', 'Categories')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Categories</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Accounts</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_categories"><i class="fa fa-plus"></i> Add Categories</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name </th>
                                <th>Status</th>
                                <!-- <th>Sub-Category Name</th> -->
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <!-- Toggle Switch -->
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $category->id }}" {{ $category->status ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <!-- <td>Hardware Expenses</td> -->
                                <td class="text-end">
                                    <div class="dropdown-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#edit_categories{{$category->id}}"><i class="fa fa-pencil m-r-5"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Category Modal -->
                            <div class="modal custom-modal fade" id="edit_categories{{$category->id}}" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Categories</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('admin.categories.update', $category->id)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                                <div class="form-group">
                                                    <label>Categories Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" name="name" type="text" value="{{$category->name}}">
                                                </div>

                                                <div class="submit-section">
                                                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Edit Category Modal -->
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Category Modal -->
    <div class="modal custom-modal fade" id="add_categories" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Categories</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.categories.store')}}" method="post">
                    @csrf
                        <div class="form-group">
                            <label>Categories Name <span class="text-danger">*</span></label>
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
    <!-- /Add Category Modal -->


</div>
<!-- /Page Wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-toggle').change(function() {
            var categoryId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("admin.category.updateStatus") }}', // Change this to your actual route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: categoryId,
                    status: status
                },
                success: function(response) {
                    //alert('Category status updated successfully!');
                    window.location.reload();
                },
                error: function(response) {
                    alert('Failed to update category status.');
                }
            });
        });
    });
</script>

@endsection
