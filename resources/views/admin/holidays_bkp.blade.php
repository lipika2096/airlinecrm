@extends('admin/layouts/head-main')
@section('content')


    <title>Holidays</title>



    <!-- Page Wrapper -->
            <div class="page-wrapper">

                <!-- Page Content -->
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Holidays 2019</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Holidays</li>
                                </ul>
                            </div>
                            <div class="col-auto float-end ms-auto">
                                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_holiday"><i class="fa fa-plus"></i> Add Holiday</a>
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
                                            <th>Title </th>
                                            <th>Holiday Date</th>
                                            <th>Day</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($holidays as $data)
                                        <tr class="holiday-completed">
                                            <td>{{$data->title}}</td>
                                            <td>{{$data->holiday_date}}</td>
                                            <td>{{$data->holiday_day}}</td>
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_holiday{{$data->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr><!-- Edit Holiday Modal -->
                <div class="modal custom-modal fade" id="edit_holiday{{$data->id}}" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Holiday</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action ="{{route('admin.holidays.update', ['id' => $data->id])}}">
                                    @method('patch')
                                    @csrf
                                    <div class="form-group">
                                        <label>Holiday Name <span class="text-danger">*</span></label>
                                        <input class="form-control" value="{{$data->title}}" type="text" name="title">
                                    </div>
                                    <div class="form-group">
                                        <label>Holiday Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon"><input class="form-control" name="holiday_date" value="{{ date('Y-m-d\TH:i', strtotime($data->holiday_date)) }}" type="datetime-local" ></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Holiday Day <span class="text-danger">*</span></label>
                                        <input class="form-control" value="{{$data->holiday_day}}" type="text" name="holiday_day">
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Edit Holiday Modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Content -->

                <!-- Add Holiday Modal -->
                <div class="modal custom-modal fade" id="add_holiday" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Holiday</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action ="{{route('admin.holidays.store')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Holiday Name <span class="text-danger">*</span></label>
                                        <input class="form-control" name="title" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Holiday Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon"><input class="form-control" type="date" name="holiday_date"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Holiday Day <span class="text-danger">*</span></label>
                                        <input class="form-control" name="holiday_day" type="text">
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Add Holiday Modal -->



                <!-- Delete Holiday Modal -->
                <div class="modal custom-modal fade" id="delete_holiday" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>Delete Holiday</h3>
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
                <!-- /Delete Holiday Modal -->

            </div>
            <!-- /Page Wrapper -->
@endsection
