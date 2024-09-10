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
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Documents</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($libraries as $library)
                                    <tr>

                                        <td>
                                            <img src="{{ asset($library->airline->logo_path) }}"
                                                alt="{{ $library->airline->logo_name }}"
                                                style="max-width: 100px; max-height: 100px;">
                                        </td>
                                        <td>{{ $library->airline->airline_name }}</td>
                                        <td>
                                        <ul style="list-style:disc !important;">
                        @if($library->attachment && $decodedAttachments = json_decode($library->attachment))
                            @foreach($decodedAttachments as $index => $docLibrary)
                                <li>
                                    <a href="{{ asset('public/assets/docs/'.$docLibrary) }}" target="_blank">
                                        Document {{ $index + 1 }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li>No documents available</li>
                        @endif
                    </ul>
                                        </td>
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
                        <h5 class="modal-title">Add Airline</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.library.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="airline">Select Airline:</label>
                                <select class="form-control" name="airline_id" id="airline" required>
                                    @foreach ($airlines as $airline)
                                        <option value="{{ $airline->id }}">{{ $airline->airline_name }}</option>
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
