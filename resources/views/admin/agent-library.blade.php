@extends('admin/layouts/head-main')

@section('content')
    <title>Airline Library</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Airline Library</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Airline Library</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_airline"><i
                                class="fa fa-plus"></i> Add Library</a>
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
                                    <th>Name</th>
                                    <th>List of documents</th>
                                    <th>Uploaded By</th>
                                    <th>Uploaded on</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($libraries as $library)
                                    <tr>
                                        <td>{{ $library->agent->company_name }}</td>
                                        <td>
                                            <ul style="list-style:disc !important;">
                                            @foreach(json_decode($library->attachment) as $index => $docLibrary)
                                                <li>
                                                    <a href = "{{$docLibrary}}" target="_blank">Document {{$index+1}}</a>
                                                </li>
                                            @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $library->admin->name ??  ($library->user->first_name ?? '-' ." ") }}</td>

                                        <td>{{ $library->updated_at->format('d-m-Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Airline Modal -->
        <div id="add_airline" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Agent library</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.agent.library.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="airline">Select Agent:</label>
                                <select class="form-control" name="agent_id" id="airline" required>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Upload Documents <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="documents[]" multiple required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Airline Modal -->

    </div>
    <!-- /Page Wrapper -->
@endsection
