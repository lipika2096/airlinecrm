@extends('admin/layouts/head-main')
@section('content')

    <title>Designations</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
<style>

.profile-widget .user-name {
    color: #333333;
    margin-top: 30px!important;
}
</style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Sector List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sector List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_Sector"><i class="fa fa-plus"></i> Add Sector</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
            <div class="col-md-12">
                <div class="row staff-grid-row">

                <div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0 datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>AIRPORT CODE</th>
                        <th>CITY NAME</th>
                        <th>AIRPORT NAME</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->airport_code ?? 'N/A' }}</td>
                            <td>{{ $value->city_name ?? 'N/A' }}</td>
                            <td>{{ $value->country_code ?? 'N/A' }}</td>
                            <td class="text-end">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_Sector{{ $value->id }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <form action="{{ route('admin.sector.delete', $value->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"><i class="fa fa-trash m-r-5"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Sector Modal -->
                        <div id="edit_Sector{{ $value->id }}" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Sector</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.sector.update', $value->id) }}" class="forms-sample" method="POST" enctype="multipart/form-data" autocomplete="on">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-6 p-2">
                                                    <div class="form-group">
                                                        <label for="city_name">CITY NAME <span class="text-danger">*</span></label>
                                                        <input type="text" name="city_name" class="form-control" placeholder="CITY NAME" value="{{ $value->city_name }}">
                                                        @if ($errors->has('city_name'))
                                                            <p class="text-danger">{{ $errors->first('city_name') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-6 p-2">
                                                    <div class="form-group">
                                                        <label for="airport_code">AIRPORT CODE <span class="text-danger">*</span></label>
                                                        <input type="text" name="airport_code" class="form-control" placeholder="AIRPORT CODE" value="{{ $value->airport_code }}">
                                                        @if ($errors->has('airport_code'))
                                                            <p class="text-danger">{{ $errors->first('airport_code') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 p-2">
                                                    <div class="form-group">
                                                        <label for="country_code">AIRPORT NAME <span class="text-danger">*</span></label>
                                                        <input type="text" name="country_code" class="form-control" placeholder="AIRPORT NAME" value="{{ $value->country_code }}">
                                                        @if ($errors->has('country_code'))
                                                            <p class="text-danger">{{ $errors->first('country_code') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary mr-3">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

        </div>

    </div>
    <!-- /Page Wrapper -->

    <!-- Add Sector Modal -->
    <div id="add_Sector" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Sector</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.sector.store')}}" class="forms-sample" method="POST" enctype="multipart/form-data" autocomplete="on">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city_name">CITY NAME<span class="text-danger">*</span></label>
                                <input type="text" name="city_name" class="form-control" placeholder="CITY NAME" value="{{ old('city_name') }}">
                                @if($errors->has('city_name'))
                                    <p class="text-danger">{{ $errors->first('city_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="airport_code">AIRPORT CODE<span class="text-danger">*</span></label>
                                <input type="text" name="airport_code" class="form-control" placeholder="AIRPORT CODE" value="{{ old('airport_code') }}">
                                @if($errors->has('airport_code'))
                                    <p class="text-danger">{{ $errors->first('airport_code') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="country_code">AIRPORT NAME <span class="text-danger">*</span></label>
                                <input type="text" name="country_code" class="form-control" placeholder="AIRPORT NAME" value="{{ old('country_code') }}">
                                @if($errors->has('country_code'))
                                    <p class="text-danger">{{ $errors->first('country_code') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mr-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
                </div>
            </div>
        </div>
    </div>




@endsection
