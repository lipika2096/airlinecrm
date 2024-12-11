@extends('admin/layouts/head-main')
@section('title', 'Fare Types')
@section('content')


<style>
    .accordion-button:focus{
        box-shadow: none !important;
    }
    .accordion-button{
        color: #000 !important;
    }
</style>
   <!-- Page Wrapper -->
            <div class="page-wrapper">

                <!-- Page Content -->
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Airline Discounts</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Admin</li>
                                </ul>
                            </div>
                            <div class="col-auto float-end ms-auto">
                                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_discounts"><i class="fa fa-plus"></i> Add Discounts</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="accordion" id="discountAccordion">
                                @foreach($discounts as $airlineId => $groupedDiscounts)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $airlineId }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $airlineId }}" aria-expanded="true" aria-controls="collapse{{ $airlineId }}">
                                            <strong style="padding-right:10px;">Airline:</strong> {{ $groupedDiscounts->first()->airline->airline_name }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $airlineId }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $airlineId }}" data-bs-parent="#discountAccordion">
                                        <div class="accordion-body p-0">
                                            <table class="table table-striped custom-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fare Type</th>
                                                        <th>Discount</th>
                                                        <th class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($groupedDiscounts as $index => $data)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $data->faretype->fare_type }}</td>
                                                        <td>{{ $data->discount }}</td>
                                                        <td class="text-end">
                                                            <div class="dropdown-action">
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit_discounts{{ $data->id }}">
                                                                    <i class="fa fa-pencil m-r-5"></i>
                                                                </a>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#delete_discounts{{ $data->id }}">
                                                                    <i class="fa fa-trash m-r-5"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                        <!-- Edit Discount Modal -->
                                        <div class="modal custom-modal fade" id="edit_discounts{{$data->id}}" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Discount</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.discounts.update', $data->id)}}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                            <div class="form-group">
                                                                <label>Airline <span class="text-danger">*</span></label>
                                                                <select class="form-control" name="airline_id">
                                                                    <option selected disabled> Select Airline </option>
                                                                    @foreach ( $airline as $air )
                                                                        <option value="{{$air->airline_id}}" {{ $data->airline_id == $air->airline_id ? 'selected' : '' }}> {{$air->airline->airline_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Fare Type <span class="text-danger">*</span></label>
                                                                <select class="form-control" name="fare_type_id">
                                                                    <option selected disabled> Select Fare Type </option>
                                                                    @foreach ( $fare_type as $ft )
                                                                        <option {{ $ft->fare_type == $data->fare_type ? 'selected' : '' }} value="{{$ft->id}}"> {{$ft->fare_type}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Discount <span class="text-danger">*</span></label>
                                                                <input class="form-control" name="discount" value="{{$data->discount}}" type="text">
                                                            </div>

                                                            <div class="submit-section">
                                                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Edit Discount Modal -->
                                        <div class="modal fade" id="delete_discounts{{$data->id}}" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteCategoryModalLabel">Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.discounts.delete', ['id'=> $data->id]) }}" method="POST" enctype="multipart/form-data">
                                                    @method('delete')
                                                    @csrf
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this Airline based fare types discounts?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Content -->

                 <!-- Add Discount Modal -->
                 <div class="modal custom-modal fade" id="add_discounts" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Discount</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.discounts.store')}}" method="post">
                                @csrf
                                    <div class="form-group">
                                        <label>Airline <span class="text-danger">*</span></label>
                                        <select class="form-control" name="airline_id">
                                            <option selected disabled> Select Airline </option>
                                            @foreach ( $airline as $air )
                                                <option value="{{$air->airline_id}}"> {{$air->airline->airline_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Fare Type <span class="text-danger">*</span></label>
                                        <select class="form-control" name="fare_type_id">
                                            <option selected disabled> Select Fare Type </option>
                                            @foreach ( $fare_type as $ft )
                                                <option value="{{$ft->fare_type_name}}"> {{$ft->fare_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Discount <span class="text-danger">*</span></label>
                                        <input class="form-control" name="discount" type="text">
                                    </div>

                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Add Discount Modal -->
            </div>
            <!-- /Page Wrapper -->



@endsection
