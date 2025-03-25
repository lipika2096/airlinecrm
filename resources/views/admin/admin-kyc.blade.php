@extends('admin/layouts/head-main')
@section('content')
    <title>Admin List</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Admin List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Admin List</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Document Name(s)</th>
                                            <th>Document File(s)</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admin as $admin)
                                            <tr>
                                                <td>{{ $admin->name }}</td>
                                                <td>
                                                    <ul>
                                                        @forelse ($admin->kycDocuments as $data)
                                                            <li>{{ $data->doc_name ?? '-' }}</li>
                                                        @empty
                                                            <li>-</li>
                                                        @endforelse
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        @forelse ($admin->kycDocuments as $data)
                                                            @foreach (json_decode($data->doc_file ?? '[]', true) as $key => $file)
                                                                <li style="list-style:disc !important;">
                                                                    {{ $key + 1 }} <a href="{{ $file }}" target="_blank">{{ basename($file) }}</a>
                                                                </li>
                                                            @endforeach
                                                        @empty
                                                            <li>-</li>
                                                        @endforelse
                                                    </ul>
                                                </td>
                                                <td class="text-end">
                                                    <a class="btn btn-primary" href="#" title="Add/Update KYC Documents"
                                                        data-bs-toggle="modal" data-bs-target="#add_kyc_docs{{ $admin->id }}">
                                                        Add Documents
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Modal -->
                                            <div id="add_kyc_docs{{ $admin->id }}" class="modal custom-modal fade" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Add KYC Documents</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.kyc.document.store', ['id' => $admin->id]) }}" method="POST" enctype="multipart/form-data">
                                                                @method('patch')
                                                                @csrf
                                                                <div class="form-group col-sm-4">
                                                                    <label>Document Name</label>
                                                                    <input class="form-control" name="doc_name" type="text" placeholder="Enter Document Name">
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label>Document</label>
                                                                    <input class="form-control" name="doc_file[]" multiple type="file">
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label>Remarks</label>
                                                                    <textarea class="form-control" name="remarks" required></textarea>
                                                                </div>
                                                                <div class="submit-section">
                                                                    <button class="btn btn-primary" type="submit">Submit</button>
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

        </div>
        <!-- /Page Header -->

    </div>
    <!-- /Page Content -->
    </div>
@endsection
