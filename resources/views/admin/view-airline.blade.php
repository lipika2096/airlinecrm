@extends('admin/layouts/head-main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <title>
        Airline
    </title>

    <head>
        <!-- Other meta tags -->
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />


    </head>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .headlinetitle {
                text-align: center;
                padding: 10px;
                font-weight: 500;
                font-size: 14px
            }

            .headline {
                margin: 10px;
                background: #e8e8e8;
                margin-right: 5px !important;
                margin-left: 5px !important;
                "

            }

            .bluetext {
                color: blue;
                font-weight: 500;
                font-size: 14px
            }

            .skybluetext {
                color: #40add9;
                font-size: 14px
            }

            .cke_notification_warning {
                background: #c83939;
                border: 1px solid #902b2b;
                display: none !important;
            }
            .switch {
                position: relative;
                display: inline-block;
                width: 0px !important;
                height: 1px !important;
                margin-top: 8px;
                margin-right: 15px;
            }

            .switch span:after {
                content: "";
                background-color: #ffffff;
                width: 7px !important;
                -webkit-box-shadow: 1px 1px 3px rgb(0 0 0 / 25%);
                -moz-box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.25);
                box-shadow: 1px 1px 3px rgb(0 0 0 / 25%);
                position: absolute;
                top: 1px;
                bottom: 1px;
                border-radius: 30px;
                -webkit-transition: all 0.2s ease;
                -ms-transition: all 0.2s ease;
                transition: all 0.2s ease;
                left: 2px;
            }

            .switch input:checked+span {
                background-color: #000000 !important;
            }

            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .switch input:checked+span:after {
                left: 10px !important;
            }

            /* Slider */
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
                border-radius: 34px;
            }

            /* Before the slider */
            .slider:before {
                position: absolute;
                content: "";
                height: 8px;
                width: 0px;
                border-radius: 50%;
                left: 4px;
                bottom: 4px;
                background-color: white;
                transition: .4s;
            }

            .switch span {
                position: relative;
                width: 20px !important;
                height: 12px !important;
                background-color: #ffffff;
                border: 1px solid #000;
                border-color: rgba(0, 0, 0, 0.1);
                display: inline-block;
                -webkit-transition: all 0.2s ease;
                -ms-transition: all 0.2s ease;
                transition: all 0.2s ease;
                border-radius: 30px;
            }

            /* Toggle switch colors */
            input:checked+.slider {
                background-color: #2196F3;
            }

            /* Move the slider when checked */
            input:checked+.slider:before {
                transform: translateX(26px);
            }

            /* Rounded sliders */
            .slider.round {
                border-radius: 34px;
            }

            .slider.round:before {
                border-radius: 50%;
            }
            .padding-custom{
                padding: 0px 150px 0px 150px;
            }
            .submit-section{
                margin-top:10px;
            }
            .modal-header{
                margin-bottom:-20px;
            }
            .add-btn {
                background-color: #ff9b44;
                border: 1px solid #ff9b44;
                color: #ffffff;
                float: right;
                font-weight: 500;
                min-width: 140px;
                border-radius: 50px;
                font-size: 13px;
            }
         a{
            text-decoration:none;
         }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Airline</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Airline</li>
                        </ul>
                        <p class="d-inline text-dark font-weight-bolder">Welcome to  <b class="d-inline text-capitalize">{{ $airlineDetails->airline->airline_name }}</b> airlines</p>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card tab-box">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item">
                                <a href="#general" data-bs-toggle="tab" class="nav-link active">General</a>
                            </li>
                            <li class="nav-item">
                                <a href="#sla" data-bs-toggle="tab" class="nav-link">SLA</a>
                            </li>
                            <li class="nav-item">
                                <a href="#aircraft" data-bs-toggle="tab" class="nav-link">Head Office Con.</a>
                            </li>
                            <li class="nav-item">
                                <a href="#fleet" data-bs-toggle="tab" class="nav-link">Fleet</a>
                            </li>
                            <li class="nav-item">
                                <a href="#approved_staffs" data-bs-toggle="tab" class="nav-link">Approved Staff</a>
                            </li>
                            <!-- <li class="nav-item"><a href="#license_approvals" data-bs-toggle="tab" class="nav-link">License Approval</a></li> -->
                            <li class="nav-item">
                                <a href="#schedule" data-bs-toggle="tab" class="nav-link">Schedule</a>
                            </li>
                            <li class="nav-item">
                                <a href="#library" data-bs-toggle="tab" class="nav-link">Library</a>
                            </li>
                            <li class="nav-item">
                                <a href="#rules" data-bs-toggle="tab" class="nav-link">Rules</a>
                            </li>
                            <li class="nav-item">
                                <a href="#provision" data-bs-toggle="tab" class="nav-link">Agreements/PLI</a>
                            </li>
                            <li class="nav-item">
                                <a href="#special_fares" data-bs-toggle="tab" class="nav-link">Special Fares</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <!-- Profile Info Tab -->

                {{-- <div id="general" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="row headline" style="">
                                    <div class="col-md-2 headlinetitle">
                                        <div class="title">IATA Code</div>
                                        <div class="bluetext">{{ $airlineDetails->IATA ?? Null }}</div>
                                    </div>
                                    <div class="col-md-2 headlinetitle">
                                        <div class="title">ICAO</div>
                                        <div class="bluetext">{{ $airlineDetails->ICAO ?? Null }}</div>
                                    </div>
                                    <div class="col-md-2 headlinetitle">
                                        <div class="title">Numeric Code</div>
                                        <div class="bluetext">{{ $airlineDetails->numeric_code ?? Null }}</div>
                                    </div>
                                    <div class="col-md-2 headlinetitle">
                                        <div class="title">Airline Code</div>
                                        <div class="skybluetext">{{ $airlineDetails->airline->airline_code ?? Null }}</div>
                                    </div>
                                    <div class="col-md-2 headlinetitle">
                                        <div class="title">Callsign</div>
                                        <div class="bluetext">{{ $airlineDetails->callsign ?? Null }}</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Airline</div>
                                            <div class="text">{{ $airlineDetails->airline->airline_name }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Country</div>
                                            <div class="text">{{ $airlineDetails->country }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Founded</div>
                                            <div class="text">{{ $airlineDetails->founded_on }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Commenced</div>
                                            <div class="text">{{ $airlineDetails->commenced_on }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Hub</div>
                                            <div class="text">{{ $airlineDetails->hubs }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Secondary Hub</div>
                                            <div class="text">{{ $airlineDetails->secondary_hubs }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Focus Cities</div>
                                            <div class="text">
                                                @if (!empty($airlineDetails->focus_cities))
                                                    @foreach (json_decode($airlineDetails->focus_cities) as $fc)
                                                        {{ $fc }}<br>
                                                    @endforeach
                                                @else
                                                    No focus cities available.
                                                @endif
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">Frequent-flyer Program</div>
                                            <div class="text">{{ $airlineDetails->frequent_flyer_program }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Alliance</div>
                                            <div class="text">{{ $airlineDetails->alliance }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Subsidiaries</div>
                                            <div class="text">{{ $airlineDetails->subsidiaries }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Fleet Size</div>
                                            <div class="text">{{ $airlineDetails->fleet_size }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Destinations</div>
                                            <div class="text">{{ $airlineDetails->destinations }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Slogan</div>
                                            <div class="text">{{ $airlineDetails->slogan }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Key People</div>
                                            <div class="text">{{ $airlineDetails->key_people }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Parent Company</div>
                                            <div class="text">{{ $airlineDetails->parent_company }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Headquarters</div>
                                            <div class="text">{{ $airlineDetails->head_quarters }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Website</div>
                                            <div class="text"><a href="{{ $airlineDetails->website }}"
                                                    target="_blank">{{ $airlineDetails->website }}</a></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div id="general" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0 datatable">
                                            <tbody>
                                                <tr></tr>
                                                <tr>
                                                    <th>Airline</th>
                                                    <td>{{ $airlineDetails->airline->airline_name ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Country</th>
                                                    <td>{{ $airlineDetails->country ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th> Founded</th>
                                                    <td>{{ $airlineDetails->founded_on ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Commenced</th>
                                                    <td>{{ $airlineDetails->commenced_on ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Hub</th>
                                                    <td>{{ $airlineDetails->hubs ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Secondary Hub</th>
                                                    <td>{{ $airlineDetails->secondary_hubs ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Focus Cities</th>
                                                    <td> @if (!empty($airlineDetails->focus_cities))
                                                        @foreach (json_decode($airlineDetails->focus_cities) as $fc)
                                                            {{ $fc }}<br>
                                                        @endforeach
                                                    @else
                                                        No focus cities available.
                                                    @endif</td>
                                                </tr>
                                                <tr>
                                                    <th>Frequent-flyer Program</th>
                                                    <td> {{ $airlineDetails->frequent_flyer_program ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Alliance</th>
                                                    <td>{{ $airlineDetails->alliance ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Subsidiaries</th>
                                                    <td>{{ $airlineDetails->subsidiaries ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Fleet Size</th>
                                                    <td>{{ $airlineDetails->fleet_size ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Destinations</th>
                                                    <td>{{ $airlineDetails->destinations ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Slogan</th>
                                                    <td>{{ $airlineDetails->slogan ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Key People</th>
                                                    <td>{{ $airlineDetails->key_people ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Parent Company</th>
                                                    <td>{{ $airlineDetails->parent_company ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Headquarters</th>
                                                    <td>{{ $airlineDetails->head_quarters ?? 'none' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Website</th>
                                                    <td class="text-danger"><a href="{{ $airlineDetails->website }}"
                                                        target="_blank">{{ $airlineDetails->website }}</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sla" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                            <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_sla"><i
                                    class="fa fa-plus"></i> Add SLA</a>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Content</th>
                                            <th>Attachment</th>
                                            <th>Created On </th>
                                                <th>Created By</th>
                                                <th>Updated On</th>
                                                <th>Upadted By</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($slas as $index => $sla)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $sla->title }}</td>
                                                <td>{{ $sla->category }}</td>
                                                <td
                                                    style="width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    {!! $sla->content !!}
                                                </td>
                                                <td>
                                                    @if ($sla->document)
                                                        <a href="{{ asset('public/assets/docs/' . $sla->document) }}"
                                                            target="_blank">View Document</a>
                                                    @else
                                                        No Document
                                                    @endif
                                                </td>
                                                <td>{{ $sla->created_at }}</td>
                                                    <td>{{ $sla->created_by }}</td>
                                                    <td>{{ $sla->updated_at }}</td>
                                                    <td>{{ $sla->updated_by }}</td>
                                                <td>
                                                    @if ($sla->status == 1)
                                                        <span style="color: green;">Active</span>
                                                    @elseif($sla->status == 2)
                                                        <span style="color: red;">Inactive</span>
                                                    @else
                                                        <span>Status Unknown</span>
                                                    @endif
                                                </td>
                                                <td style="    display: flex;">
                                                    <a class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#edit_sla{{ $sla->id }}"><i
                                                            class="fa fa-edit"></i></a>
                                                            <a class="btn" data-bs-toggle="modal"
                                                            data-bs-target="#delete_sla{{ $sla->id }}"><i
                                                                class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                          <!-- Delete sla Modal -->
                                          <div id="delete_sla{{$sla->id}}" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete SLA</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.airline.sla.destroy',$sla->id)}}#sla" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <p>Are you sure you want to Deactive
                                                                <strong>{{$sla->title}}</strong>?
                                                            </p>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <textarea class="form-control" name="remarks" col="1"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete sla Modal -->
                                            <!-- Edit Modal -->
                                            <div id="edit_sla{{ $sla->id }}" class="modal custom-modal fade" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-dark" style="font-size: 22px !important;    ">Edit SLA</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.airline.sla.update', $sla->id) }}#sla"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="form-group">
                                                                    <input type="hidden" class="form-control"
                                                                        name="airline_id" value="{{ $sla->airline_id }}">
                                                                    <input type="hidden" class="form-control"
                                                                        value="{{ $sla->id }}">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6 form-group">
                                                                        <label>Title</label>
                                                                        <input type="text" class="form-control"
                                                                            placeholder="title" name="title"
                                                                            value="{{ $sla->title }}">
                                                                    </div>
                                                                    <div class="col-sm-6 form-group">
                                                                        <label>Category</label>
                                                                        <input type="text" class="form-control"
                                                                            placeholder="category" name="category"
                                                                            value="{{ $sla->category }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        <input type="checkbox"
                                                                            id="toggleUpload_{{ $sla->id }}"> Upload
                                                                        Documents
                                                                    </label>
                                                                </div>
                                                                <div class="form-group"
                                                                    id="uploadSection_{{ $sla->id }}"
                                                                    style="display: none;">
                                                                    <label>Upload Documents</label>
                                                                    <input class="form-control" type="file"
                                                                        name="document">
                                                                </div>
                                                                @if ($sla->document)
                                                                    <div class="form-group">
                                                                        <label>Current Document</label>
                                                                        <a href="{{ asset('public/' . $sla->document) }}"
                                                                            target="_blank">View Current Document</a>
                                                                    </div>
                                                                @endif
                                                                <div class="form-group">
                                                                    <label>Content</label>
                                                                    <textarea name="content" id="editor{{ $sla->id }}">{{ $sla->content }}</textarea>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                            </form>
                                                            <script src="https://cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
                                                            <script>
                                                                CKEDITOR.replace('editor{{ $sla->id }}');

                                                                document.getElementById('toggleUpload_{{ $sla->id }}').addEventListener('change', function() {
                                                                    var uploadSection = document.getElementById('uploadSection_{{ $sla->id }}');
                                                                    if (this.checked) {
                                                                        uploadSection.style.display = 'block';
                                                                    } else {
                                                                        uploadSection.style.display = 'none';
                                                                    }
                                                                });
                                                            </script>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="add_sla" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add SLA</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.airline.sla.store') }}#sla" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" name="airline_id"
                                                    id="airline" value="{{ $airlineDetails->airline_id }}">
                                                    <input type="hidden" class="form-control" name="updated_at"
                                                    id="updated_at" value=" ">
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label>Title <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Title"
                                                        name="title" id="title">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label>Category <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="category"
                                                        placeholder="Category" id="category">
                                                </div>
                                            </div>
                                            <!-- Checkbox to toggle upload section -->
                                            <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <label>
                                                    <input type="checkbox" id="toggleUpload"> Upload Documents
                                                </label>
                                            </div>
                                            <!-- Upload Documents Section -->
                                            <div class="form-group col-md-6" id="uploadSection" style="display: none;">
                                                <!-- <label>Upload Documents </label> -->
                                                <input class="form-control" type="file" name="document">
                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Content </label>
                                                <script src="https://cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
                                                <textarea name="content" id="editorunique"></textarea>
                                                <script>
                                                    CKEDITOR.replace('editorunique');
                                                </script>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </form>
                                        <script>
                                            document.getElementById('toggleUpload').addEventListener('change', function() {
                                                var uploadSection = document.getElementById('uploadSection');
                                                if (this.checked) {
                                                    uploadSection.style.display = 'block';
                                                } else {
                                                    uploadSection.style.display = 'none';
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="aircraft" class="pro-overview tab-pane fade show ">
                    <div class="row">
                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                            <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_headoffice"><i
                                    class="fa fa-plus"></i> Add Contact Detail</a>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Title</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Position</th>
                                                <th>Department</th>
                                                <th>Email Address</th>
                                                <th>Phone Number</th>
                                                <th>Add To Mail List</th>
                                                <th>Created On</th>
                                                <th>Created By</th>
                                                <th>Last Updated on</th>
                                                <th>Last Updated by</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($headOffices as $index => $headOffice)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $headOffice->title }}</td>
                                                    <td>{{ $headOffice->first_name }}</td>
                                                    <td>{{ $headOffice->last_name }}</td>
                                                    <td>{{ $headOffice->position }}</td>
                                                    <td>{{ $headOffice->department }}</td>
                                                    <td>{{ $headOffice->email_address }}</td>
                                                    <td>{{ $headOffice->phone_number }}</td>
                                                    <td>
                                                        <input type="checkbox" disabled {{ $headOffice->add_to_mail_list == 1 ? 'checked' : '' }}>
                                                    </td>
                                                    <td>{{ $headOffice->created_at }}</td>
                                                    <td>{{ $headOffice->created_by }}</td>
                                                    <td>{{ $headOffice->last_updated_on }}</td>
                                                    <td>{{ $headOffice->last_updated_by }}</td>
                                                    <td style="display:flex;">
                                                        <a class="btn" data-bs-toggle="modal"
                                                            data-bs-target="#edit_headoffice{{ $headOffice->id }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                        <a class="btn" data-bs-toggle="modal"
                                                            data-bs-target="#delete_headoffice{{ $headOffice->id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>

                                                    </td>
                                                </tr>

                                        <!-- Delete head office Modal -->
                                        <div id="delete_headoffice{{$headOffice->id}}" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header mb-1">
                                                        <h5 class="modal-title">Delete head office contact details</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.airline.head_office.destroy',$headOffice->id)}}#aircraft" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <p>Are you sure you want to Deactive
                                                                <strong>{{$headOffice->first_name}} {{$headOffice->last_name}}'s</strong>contact detail?
                                                            </p>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <textarea class="form-control" name="remarks" col="1"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete head office Modal -->
                                                <div id="edit_headoffice{{ $headOffice->id }}"
                                                    class="modal custom-modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Head Office Contact Details
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('admin.airline.head_office.update', ['id' => $headOffice->id]) }}#aircraft"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="row">
                                                                            <div class="form-group">
                                                                                <input class="form-control" type="hidden"
                                                                                    name="airline_id"
                                                                                    value="{{ $airlineDetails->airline_id }}">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Title
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    value="{{ $headOffice->title }}"
                                                                                    type="text" name="title">
                                                                            </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Position
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    value="{{ $headOffice->position }}"
                                                                                    name="position" required>
                                                                            </div>
                                                                            </div>
                                                                            <div class="form-group col-sm-6">
                                                                                <label class="col-form-label">Department
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="department"
                                                                                    value="{{ $headOffice->department }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="col-sm-6 form-group">
                                                                                <label class="col-form-label">First Name
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="first_name"
                                                                                    value="{{ $headOffice->first_name }}">
                                                                            </div>
                                                                            <div class="col-sm-6 form-group">
                                                                                <label class="col-form-label">Last Name
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="last_name"
                                                                                    value="{{ $headOffice->last_name }}">
                                                                            </div>



                                                                            <div class="col-sm-6 form-group">
                                                                                <label class="col-form-label">Phone Number
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="phone_number"
                                                                                    value="{{ $headOffice->phone_number }}">
                                                                            </div>

                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Email Address
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="email_address"
                                                                                    value="{{ $headOffice->email_address }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group " >
                                                                                <label class="col-form-label " style="margin-bottom:-5px;" >Add to mail List
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                        <input type="hidden" name="add_to_mail_list" value="0">
                                                                                        <input type="checkbox" name="add_to_mail_list" value="1"
                                                                                            {{ $headOffice->add_to_mail_list == 1 ? 'checked' : '' }}>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 submit-section">
                                                                        <button class="btn btn-primary"
                                                                            type="submit">Update</button>
                                                                     </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <!-- Repeat for other agents -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="add_headoffice" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Head office Contact Details</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.airline.head_office.store') }}#aircraft" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="airline_id"
                                                        id="airline" value="{{ $airlineDetails->airline_id }}">
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Title</label>
                                                        <input type="text" class="form-control" id="title"
                                                            name="title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="position">Position</label>
                                                        <input type="text" class="form-control" id="position"
                                                            name="position">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="lastName">Last Name</label>
                                                        <input type="text" class="form-control" id="lastName"
                                                            name="last_name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="department">Department</label>
                                                        <input type="text" class="form-control" id="department"
                                                            name="department">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="firstName">First Name</label>
                                                        <input type="text" class="form-control" id="firstName"
                                                            name="first_name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phoneNumber">Phone Number</label>
                                                        <input type="text" class="form-control" id="phoneNumber"
                                                            name="phone_number">
                                                    </div>
                                                    <div class="form-group">
                                                        {{-- <label for="created_by">Created By</label> --}}
                                                        <input type="hidden" class="form-control" id="created_by"
                                                            name="created_by" value="{{Auth()->user()->name}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12" style="margin-top:-12px;">
                                                <div class="form-group">
                                                        <label for="emailAddress">Email Address</label>
                                                        <input type="email" class="form-control" id="emailAddress"
                                                            name="email_address">
                                                    </div>
                                                </div>
                                                <div class="form-group" style="margin-top:-12px;">
                                                        <label class="col-form-label">Add to mail List
                                                            <span
                                                                class="text-danger">*</span></label>
                                                                <input type="checkbox" name="add_to_mail_list" value="1" >
                                                    </div>
                                            </div>
                                            <div class="submit-section">
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="fleet" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                            <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_fleet"><i
                                    class="fa fa-plus"></i> Add Fleet</a>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            {{-- <th>Name</th> --}}
                                            <th>Aircraft reg.</th>
                                            {{-- <th>Number of aircraft</th> --}}
                                            <th style="text-align:center" colspan="3">Airline</th>
                                            <th>Fleet Type</th>
                                            <th style="text-align:center" colspan="4">Configuration</th>
                                            <th>Created On</th>
                                            <th>Created By</th>
                                            <th>Updated On</th>
                                            <th>Updated By</th>
                                            <th>Actions</th>
                                        </tr>
                                        <tr>
                                            <!-- Empty cells to align the F, C, W, Y headers under the Configuration header -->
                                            <th></th>
                                            {{-- <th></th> --}}
                                            <th></th>
                                            <th>Name</th>
                                            <th>IATA</th>
                                            <th>ICAO</th>
                                            <th></th>
                                            <th>F</th>
                                            <th>C</th>
                                            <th>W</th>
                                            <th>Y</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fleets as $index => $fleet)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $fleet->aircraft_reg }}</td>
                                                {{-- <td>{{ $fleet->name }}</td> --}}
                                                {{-- <td>{{ $fleet->iata }}</td>
                                                <td>{{ $fleet->icao }}</td> --}}
                                                {{-- <td>{{ $fleet->number_of_aircraft }}</td> --}}
                                                <td>{{ $fleet->airlineData->airline_name }}</td>
                                                <td>{{ $fleet->airlineData->iata }}</td>
                                                <td>{{ $fleet->airlineData->icao }}</td>
                                                <td>{{ $fleet->fleet_type}}</td>
                                                <td>{{ $fleet->configuration_f }}</td>
                                                <td>{{ $fleet->configuration_c }}</td>
                                                <td>{{ $fleet->configuration_w }}</td>
                                                <td>{{ $fleet->configuration_y }}</td>
                                                <td>{{$fleet->created_at}}</td>
                                                <td>{{$fleet->created_by}}</td>
                                                <td>{{$fleet->updated_at}}</td>
                                                <td>{{$fleet->updated_by}}</td>
                                                <td style="display:flex;">
                                                    <a class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#edit_fleet{{ $fleet->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a class="btn" data-bs-toggle="modal"
                                                            data-bs-target="#delete_fleet{{ $fleet->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                        <!-- Delete fleet Modal -->
                                        <div id="delete_fleet{{$fleet->id}}" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered " role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header mb-1">
                                                        <h5 class="modal-title">Delete fleet</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.airline.fleet.destroy',$fleet->id)}}#fleet" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <p>Are you sure you want to delete
                                                                <strong>{{$fleet->name}}</strong>?
                                                            </p>
                                                            <div class="row">
                                                                <!-- <div class="col-sm-12"> -->
                                                                    <div class="form-group">
                                                                        <textarea class="form-control" name="remarks" col="1"></textarea>
                                                                    </div>
                                                                <!-- </div> -->
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete fleet Modal -->
                                            <div id="edit_fleet{{ $fleet->id }}" class="modal custom-modal fade"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Fleet</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.airline.fleet.update', ['id' => $fleet->id]) }}#fleet"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="row">
                                                                    <!-- <div class="col-sm-12"> -->
                                                                        <input class="form-control" type="hidden"
                                                                            name="airline_id"
                                                                            value="{{ $airlineDetails->airline_id }}">
                                                                        <input class="form-control" type="hidden"
                                                                            name="fleet_id"
                                                                            value="{{ $fleet->id ?? '' }}">
                                                                        <div class="col-sm-6 form-group">
                                                                            <label class="col-form-label">Aircraft reg.
                                                                                <span class="text-danger">*</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="aircraft_reg"
                                                                                value="{{ $fleet->aircraft_reg ?? '' }}"
                                                                                required>
                                                                        </div>
                                                                            {{-- <label class="col-form-label">Name <span
                                                                                    class="text-danger">*</span></label> --}}
                                                                            <input class="form-control" type="hidden"
                                                                                name="name"
                                                                                value="null" required>
                                                                            {{-- <label class="col-form-label">IATA <span
                                                                                    class="text-danger">*</span></label> --}}
                                                                            <input class="form-control" type="hidden"
                                                                                name="iata"
                                                                                value="{{ $fleet->iata ?? '' }}" required>
                                                                            {{-- <label class="col-form-label">ICAO <span
                                                                                    class="text-danger">*</span></label> --}}
                                                                            <input class="form-control" type="hidden"
                                                                                name="icao"
                                                                                value="{{ $fleet->icao ?? '' }}" required>
                                                                            {{-- <label class="col-form-label">Number of
                                                                                Aircraft <span
                                                                                    class="text-danger">*</span></label> --}}
                                                                            <input class="form-control" type="hidden"
                                                                                name="number_of_aircraft"
                                                                                value="1"
                                                                                required>
                                                                        <div class="col-sm-6 form-group">
                                                                            <label class="col-form-label">Fleet Type <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="fleet_type"
                                                                                value="{{ $fleet->fleet_type ?? '' }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-sm-6 form-group">
                                                                            <label class="col-form-label">Configuration
                                                                                F</label>
                                                                            <input class="form-control" type="text"
                                                                                name="configuration_f"
                                                                                value="{{ $fleet->configuration_f ?? '' }}">
                                                                        </div>
                                                                        <div class=" col-sm-6 form-group">
                                                                            <label class="col-form-label">Configuration
                                                                                C</label>
                                                                            <input class="form-control" type="text"
                                                                                name="configuration_c"
                                                                                value="{{ $fleet->configuration_c ?? '' }}">
                                                                        </div>
                                                                        <div class=" col-sm-6 form-group">
                                                                            <label class="col-form-label">Configuration
                                                                                W</label>
                                                                            <input class="form-control" type="text"
                                                                                name="configuration_w"
                                                                                value="{{ $fleet->configuration_w ?? '' }}">
                                                                        </div>
                                                                        <div class="col-sm-6 form-group">
                                                                            <label class="col-form-label">Configuration
                                                                                Y</label>
                                                                            <input class="form-control" type="text"
                                                                                name="configuration_y"
                                                                                value="{{ $fleet->configuration_y ?? '' }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input class="form-control" type="hidden"
                                                                                name="updated_by"
                                                                                value="{{Auth()->user()->name}}">
                                                                        </div>
                                                                    </div>
                                                                <!-- </div> -->
                                                                <div class="submit-section">
                                                                    <button class="btn btn-primary"
                                                                        type="submit">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- Repeat for other agents -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="add_fleet" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Fleet/Aircraft Reg.</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.airline.fleet.store') }}#fleet" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="hidden" name="airline_id"
                                                        value="{{ $airlineDetails->airline_id }}">
                                                    <input class="form-control" type="hidden" name="fleet_id"
                                                        value="">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Aircraft reg. <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="aircraft_reg"
                                                            value="" required>
                                                    </div>
                                                </div>
                                                    {{-- <div class="col-sm-6">
                                                        <div class="form-group"> --}}
                                                            {{-- <label class="col-form-label">Name <span
                                                                    class="text-danger">*</span></label> --}}
                                                            <input class="form-control" type="hidden" name="name"
                                                                value="null" required>
                                                            {{-- <label class="col-form-label">IATA <span
                                                                    class="text-danger">*</span></label> --}}
                                                            <input class="form-control" type="hidden" name="iata"
                                                                value="null" required>
                                                            {{-- <label class="col-form-label">ICAO <span
                                                                    class="text-danger">*</span></label> --}}
                                                            <input class="form-control" type="hidden" name="icao"
                                                                value="null" required>

                                                            {{-- <label class="col-form-label">Number of Aircraft <span
                                                                    class="text-danger">*</span></label> --}}
                                                            <input class="form-control" type="hidden"
                                                                name="number_of_aircraft" value="1" required>
                                                        {{-- </div>
                                                    </div> --}}
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Fleet Type <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="fleet_type"
                                                            value="" required>
                                                    </div>
                                                </div>
                                                    <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Configuration F</label>
                                                        <input class="form-control" type="text" name="configuration_f"
                                                            value="">
                                                    </div>
                                                </div>
                                                    <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Configuration C</label>
                                                        <input class="form-control" type="text" name="configuration_c"
                                                            value="">
                                                    </div>
                                                </div>
                                                    <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Configuration W</label>
                                                        <input class="form-control" type="text" name="configuration_w"
                                                            value="">
                                                    </div>
                                                </div>
                                                    <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Configuration Y</label>
                                                        <input class="form-control" type="text" name="configuration_y"
                                                            value="">
                                                    </div>
                                                </div>
                                                    <div class="col-sm-6">

                                                    <div class="form-group">
                                                        <input class="form-control" type="hidden"
                                                            name="updated_at"
                                                            value=" ">
                                                    </div>
                                                </div>
                                                    <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input class="form-control" type="hidden"
                                                            name="created_by"
                                                            value="{{Auth()->user()->name}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="submit-section">
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="add_approvedStaff" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Approved Staff</h5>
                                <button type="button" class="close" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form
                                    action="{{ route('admin.airline.approved-staff-rights.store') }}#approved_staffs"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="fw-bold">Staff
                                                    </th>
                                                    @foreach ($duty as $ft)
                                                        <th class="fw-bold">
                                                            {{ $ft->name }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($Staffs as $air)
                                                    <tr>
                                                        <div class="form-group">
                                                            <input class="form-control"
                                                                type="hidden"
                                                                name="airline_id"
                                                                value="{{ $airlineDetails->airline_id }}">

                                                                <input class="form-control"
                                                                type="hidden"
                                                                name="updated_at"
                                                                value="  ">
                                                                <input class="form-control"
                                                                type="hidden"
                                                                name="created_by"
                                                                value="{{auth()->user()->name}}">
                                                        </div>
                                                        <th class="fw-bold">
                                                            {{ $air->first_name }}</th>
                                                        @foreach ($duty as $ft)
                                                            @php
                                                                $status = DB::table(
                                                                    'approved_staffs',
                                                                )
                                                                    ->where(
                                                                        'staff_id',
                                                                        $air->id,
                                                                    )
                                                                    ->where(
                                                                        'duties',
                                                                        $ft->name,
                                                                    )
                                                                    ->where(
                                                                        'airline_id',
                                                                        $airlineDetails->airline_id,
                                                                    )
                                                                    ->value('status');
                                                            @endphp
                                                            <input type="hidden"
                                                                name="staff[{{ $air->id }}][{{ $ft->name }}]"
                                                                value="2">
                                                            <th>
                                                                <input type="checkbox"
                                                                    name="staff[{{ $air->id }}][{{ $ft->name }}]"
                                                                    value="1"
                                                                    {{ $status == 1 ? 'checked' : '' }}>
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary"
                                            type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="approved_staffs" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                        <a class="btn add-btn"  data-bs-toggle="modal" data-bs-target="#add_approvedStaff"><i
                        class="fa fa-plus"></i> Add/Edit Approved Staff</a>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold">Staff
                                            </th>
                                            @foreach ($duty as $ft)
                                                <th class="fw-bold">
                                                    {{ $ft->name }}</th>
                                            @endforeach
                                            <th>Created On</th>
                                            <th>Created By</th>
                                            <th>Updated On</th>
                                            <th>Updated By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Staffs as $air)
                                            <tr>
                                                <div class="form-group">
                                                    <input class="form-control"
                                                        type="hidden"
                                                        name="airline_id"
                                                        value="{{ $airlineDetails->airline_id }}">

                                                        <input class="form-control"
                                                        type="hidden"
                                                        name="updated_at"
                                                        value="  ">
                                                </div>
                                                <th class="fw-bold">
                                                    {{ $air->first_name }}</th>
                                                @foreach ($duty as $ft)
                                                    @php
                                                        $approvedStaff = DB::table('approved_staffs')
                                                                            ->where('staff_id', $air->id)
                                                                            ->where('duties', $ft->name)
                                                                            ->where('airline_id', $airlineDetails->airline_id)
                                                                            ->first();
                                                    @endphp
                                                    <input type="hidden"
                                                        name="staff[{{ $air->id }}][{{ $ft->name }}]"
                                                        value="2">
                                                    <th>
                                                        <input type="checkbox"
                                                            name="staff[{{ $air->id }}][{{ $ft->name }}]"
                                                            value="1"
                                                            {{ $approvedStaff && $approvedStaff->status == 1 ? 'checked' : '' }}>
                                                    </th>
                                                @endforeach
                                                <td>{{ $approvedStaff->created_at ?? 'N/A' }}</td>
                                                <td>{{ $approvedStaff->created_by ?? 'N/A' }}</td>
                                                <td>{{ $approvedStaff->updated_at ?? 'N/A' }}</td>
                                                <td>{{ $approvedStaff->updated_by ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="schedule" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                            <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_aircraft"><i
                                    class="fa fa-plus"></i> Add Schedule
                            </a>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Flight No</th>
                                                <th>Origin Station</th>
                                                <th>Arrival Station</th>
                                                <th>Departure Time</th>
                                                <th>Arrival Time</th>
                                                <th>Aircraft Type</th>
                                                <th>Valid Till</th>
                                                <th>Frequency</th>
                                                <th>Created On</th>
                                                <th>Created By</th>
                                                <th>Updated on</th>
                                                <th>Updated by</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($aircrafts as $index => $data)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $data->flight_no }}</td>
                                                    <td>{{ $data->origin_station }}</td>
                                                    <td>{{ $data->arrival_station }}</td>
                                                    <td>{{ $data->departure_time }}</td>
                                                    <td>{{ $data->arrival_time }}</td>
                                                    <td>{{ $data->aircraft_type }}</td>
                                                    <td>{{ $data->valid_till }}</td>
                                                    <td>{{ $data->frequency }}</td>
                                                    <td>{{ $data->created_at }}</td>
                                                    <td>{{ $data->created_by }}</td>
                                                    <td>{{ $data->updated_at }}</td>
                                                    <td>{{ $data->updated_by }}</td>
                                                    <td style="display:flex;">
                                                        <a style="margin-right: 10px;" class="btnedit-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit_aircraft{{ $data->id }}"><i
                                                                class="fa fa-edit"></i></a>

                                                        <a style="margin-right: 10px;" class="btnedit-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#delete_aircraft{{ $data->id }}"><i
                                                            class="fa fa-trash"></i></a>

                                                    </td>
                                                </tr>

                                        <!-- Delete schedule Modal -->
                                        <div id="delete_aircraft{{$data->id}}" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header mb-1">
                                                        <h5 class="modal-title">Delete schedule</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.airline.aircraft.destroy',$data->id)}}#schedule" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <p>Are you sure you want to delete?
                                                            </p>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <textarea class="form-control" name="remarks" col="1"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete fleet Modal -->
                                                <div id="edit_aircraft{{ $data->id }}"
                                                    class="modal custom-modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Schedule </h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('admin.airline.aircraft.update', ['id' => $data->id]) }}#schedule"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="row">
                                                                            <div class="form-group">
                                                                                <input class="form-control" type="hidden"
                                                                                    name="airline_id"
                                                                                    value="{{ $airlineDetails->airline_id }}">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Flight Number
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    value="{{ $data->flight_no }}"
                                                                                    type="text" name="flight_no"
                                                                                    required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Origin
                                                                                    Station <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    value="{{ $data->origin_station }}"
                                                                                    name="origin_station" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Arrival
                                                                                    Station <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="arrival_station"
                                                                                    value="{{ $data->arrival_station }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Valid Till
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="date"
                                                                                    name="valid_till"
                                                                                    value="{{ $data->valid_till }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Departure
                                                                                    Time <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="datetime-local"
                                                                                    name="departure_time"
                                                                                    value="{{ $data->departure_time }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Arrival Time
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="datetime-local"
                                                                                    name="arrival_time"
                                                                                    value="{{ $data->arrival_time }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Aircraft Type
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="aircraft_type"
                                                                                    value="{{ $data->aircraft_type }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Frequency
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="frequency"
                                                                                    value="{{ $data->frequency }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                {{-- <label for="created_by">Created By</label> --}}
                                                                                <input type="hidden" class="form-control" id="created_by"
                                                                                    name="updated_by" value="{{Auth()->user()->name}}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="submit-section">
                                                                        <button class="btn btn-primary"
                                                                            type="submit">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <!-- Repeat for other agents -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="add_aircraft" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Schedule</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.airline.aircraft.store') }}#schedule" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row form-group">
                                                <!-- <div class="col-sm-6"> -->
                                                    <div class=" ">
                                                        <input class="form-control" type="hidden" name="airline_id"
                                                            value="{{ $airlineDetails->airline_id }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label">Flight Number <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="flight_no"
                                                            required>
                                                    </div>


                                                    <div class="col-sm-6">
                                                        <label class="col-form-label">Origin Station <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="origin_station"
                                                            required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label">Arrival Station <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="arrival_station"
                                                            required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label">Valid Till <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="date" name="valid_till"
                                                            required>
                                                    </div>

                                                <!-- <div class="col-sm-6"> -->
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label">Departure Time <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="datetime-local"
                                                            name="departure_time" required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label">Arrival Time <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="datetime-local"
                                                            name="arrival_time" required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label">Aircraft Type <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="aircraft_type"
                                                            required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label">Frequency <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="frequency"
                                                            required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        {{-- <label for="created_by">Created By</label> --}}
                                                        <input type="hidden" class="form-control" id="updated_at"
                                                            name="updated_at" value=" ">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        {{-- <label for="created_by">Created By</label> --}}
                                                        <input type="hidden" class="form-control" id="created_by"
                                                            name="created_by" value="{{Auth()->user()->name}}">
                                                    </div>
                                                </div>
                                            <!-- </div> -->
                                            <div class="submit-section">
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="library" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                            <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_library"><i
                                    class="fa fa-plus"></i> Add Library</a>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Read & Sign</th>
                                            <th>Issue Date</th>
                                            <th>Effective Date</th>
                                            <th>Edition No.</th>
                                            <th class="text-center" colspan="2">Uploaded
                                            </th>
                                            <th class="text-center" colspan="2">Updated</th>
                                            <th>Attachment</th>
                                            <th>Actions</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th> </th>
                                            <th> </th>
                                            <th> </th>
                                            <th>DateTime</th>
                                            <th>User</th>
                                            <th>DateTime</th>
                                            <th>User</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($library as $index => $data)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $data->doc_name }}</td>
                                                <td>
                                                    <i class=" fas {{ $data->read_sign == 1 ? 'fa-check' : '' }}"
                                                        data-field="read_sign"
                                                        data-staff-id="{{ $data->staff_id }}"></i>
                                                </td>
                                                <td>{{ $data->issue_date }}</td>
                                                <td>{{ $data->effective_date }}</td>
                                                <td>{{ $data->edition_no }}</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>{{ $data->admin->name ??  ($data->user->first_name ." ".$data->user->last_name) }}</td>
                                                <td>{{ $data->updated_at }}</td>
                                                <td>
                                                    {{ $data->adminUpdated->name ?? ($data->userUpdated ? $data->userUpdated->first_name . ' ' . $data->userUpdated->last_name : '') }}
                                                </td>

                                                <td>
                                                    @if($data->attachment && $decodedAttachments = json_decode($data->attachment))
                                                        @foreach($decodedAttachments as $index => $docLibrary)

                                                                <a href="{{$docLibrary}}" target="_blank">
                                                                <i
                                                            class="fa fa-eye"></i>
                                                                </a>
                                                        @endforeach
                                                    @else
                                                        <li>No documents available</li>
                                                    @endif
                                                    <!--<a target="_blank"-->
                                                    <!--    href="{{ asset('public/assets/docs/' . $data->attachment) }}"> <i-->
                                                    <!--        class="fa fa-eye"></i></a>-->
                                                    <!--<i class="fa fa-download"></i>-->
                                                    <!--<i class="fa fa-trash"></i>-->
                                                </td>
                                                <td style="display:flex;">
                                                    <a class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#edit_library{{ $data->id }}"><i
                                                            class="fa fa-edit"></i></a>

                                                            <a style="margin-right: 10px; margin-top: 7px;" class="btnedit-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete_library{{ $data->id }}"><i
                                                                class="fa fa-trash"></i></a>

                                                </td>
                                            </tr>

                                        <!-- Delete fleet Modal -->
                                        <div id="delete_library{{$data->id}}" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete Library</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.airline.library.destroy',$data->id)}}#library" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <p>Are you sure you want to delete?
                                                            </p>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <textarea class="form-control" name="remarks" col="1"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete fleet Modal -->
                                            <div id="edit_library{{ $data->id }}" class="modal custom-modal fade"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Library</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.airline.library.update', $data->id) }}#library"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input class="form-control" type="hidden"
                                                                    name="airline_id"
                                                                    value="{{ $airlineDetails->airline_id }}">
                                                                <input class="form-control" type="hidden"
                                                                    name="staff_id" value="{{ $data->id }}">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="doc_name">Document Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="doc_name" name="doc_name"
                                                                                value="{{ $data->doc_name }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="issue_date">Issue Date</label>
                                                                            <input type="date" class="form-control"
                                                                                id="issue_date" name="issue_date"
                                                                                value="{{ $data->issue_date }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="edition_no">Edition No</label>
                                                                            <input type="text" class="form-control"
                                                                                id="edition_no" name="edition_no"
                                                                                value="{{ $data->edition_no }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="attachment">Attachment</label>
                                                                            <input type="file" class="form-control"
                                                                                id="attachment" name="attachment">
                                                                            @if ($data->attachment)
                                                                                <p>Current Document: <a target="_blank"
                                                                                        href="{{ asset('public/assets/docs/' . $data->attachment) }}">View
                                                                                        Doc</a>
                                                                                </p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="submit-section">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- Repeat for other documents -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="add_library" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Library</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.library.viewstore') }}#library" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" name="airline_id"
                                                    id="airline" value="{{ $airlineDetails->airline_id }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Document Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="doc_name"
                                                    id="doc_name">
                                            </div>
                                            <div class="form-group">
                                                <label>Edition No <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="edition_no"
                                                    id="edition_no">
                                            </div>
                                            <div class="form-group">
                                                <label>Issue Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="issue_date"
                                                    id="issue_date">
                                            </div>
                                            <div class="form-group">
                                                <label>Upload Documents <span class="text-danger">*</span></label>
                                                <input class="form-control" type="file" name="documents" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="rules" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                            <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_rules"><i
                                    class="fa fa-plus"></i> Add Rules</a>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Do's</th>
                                            <th>Dont's</th>
                                            <th>Cancellation Policy</th>
                                            <th>Date Change Policy</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rules as $rule)
                                            <tr>
                                                <td>{!! $rule->dos !!}</td>
                                                <td>{!! $rule->donts !!}</td>
                                                <td>{!! $rule->cancellation_policy !!}</td>
                                                <td>{!! $rule->date_change_policy !!}</td>
                                                <td style="display:flex;">
                                                    <a class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#edit_rules{{ $rule->id }}">
                                                        <i class="fa fa-edit"></i></a>

                                                    <form id="toggle-status-form5-{{ $rule->id }}"
                                                        action="{{ route('admin.airline.rules.statusupdate', $rule->id) }}#rules"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <label class="switch">
                                                            <input type="checkbox"
                                                                onchange="updateStatus5({{ $rule->id }}, this)"
                                                                {{ $rule->status == 1 ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div id="edit_rules{{ $rule->id }}" class="modal fade"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Rules</h5>
                                                            <button type="button" class="close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.airline.rules.update', $rule->id) }}#rules"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="form-group">
                                                                    <label for="dos">Do's</label>
                                                                    <textarea name="dos" id="dos" class="form-control ckeditor">{{ $rule->dos }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="donts">Dont's</label>
                                                                    <textarea name="donts" id="donts" class="form-control ckeditor">{{ $rule->donts }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="cancellation_policy">Cancellation
                                                                        Policy</label>
                                                                    <textarea name="cancellation_policy" id="cancellation_policy" class="form-control ckeditor">{{ $rule->cancellation_policy }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="date_change_policy">Date Change
                                                                        Policy</label>
                                                                    <textarea name="date_change_policy" id="date_change_policy" class="form-control ckeditor">{{ $rule->date_change_policy }}</textarea>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-success">Update</button>
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
                        <div id="add_rules" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Rules</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.airline.rules.store') }}#rules" method="POST">
                                            @csrf

                                            <input type="hidden" class="form-control" name="airline_id"
                                                id="airline" value="{{ $airlineDetails->airline_id }}">

                                            <div class="form-group">
                                                <label for="dos">Do's</label>
                                                <textarea name="dos" id="dos" class="form-control ckeditor"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="donts">Dont's</label>
                                                <textarea name="donts" id="donts" class="form-control ckeditor"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="cancellation_policy">Cancellation Policy</label>
                                                <textarea name="cancellation_policy" id="cancellation_policy" class="form-control ckeditor"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="date_change_policy">Date Change Policy</label>
                                                <textarea name="date_change_policy" id="date_change_policy" class="form-control ckeditor"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div id="provision" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                            <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_agreements"><i
                                    class="fa fa-plus"></i> Add Agreements</a>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Incentive Description</th>
                                            <th>Term</th>
                                            <th>Agency</th>
                                            <th>IATA</th>
                                            <th>Remarks</th>
                                            <th>Agreement Status</th>
                                            <th>Created On </th>
                                            <th>Created By</th>
                                            <th>Updated On</th>
                                            <th>Upadted By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agreements as $agreement)
                                            <tr>
                                                <td>{{ $agreement->incentive_description }}</td>
                                                <td>{{ $agreement->term }}</td>
                                                <td>{{ $agreement->agent->agency_name }}</td>
                                                <td>{{ $agreement->agent->iata }}</td>
                                                <td>{{ $agreement->agent->remarks }}</td>

                                                <td>
                                                    @if ($agreement->agreement_status == 1)
                                                        <span>Signed</span>
                                                    @elseif($agreement->agreement_status == 2)
                                                        <span>Expired</span>
                                                    @elseif($agreement->agreement_status == 3)
                                                        <span>Not Renewed</span>
                                                    @else
                                                        <span>Status Unknown</span>
                                                    @endif
                                                </td>

                                                <td>{{ $agreement->created_at }}</td>
                                                <td>{{ $agreement->created_by }}</td>
                                                <td>{{ $agreement->updated_at }}</td>
                                                <td>{{ $agreement->updated_by }}</td>

                                                <td>
                                                    <div style="display:flex">
                                                        <a class="btn" data-bs-toggle="modal"
                                                            data-bs-target="#edit_agreements{{ $agreement->id }}"><i
                                                                class="fa fa-edit"></i></a>




                                                                <a class="btn" data-bs-toggle="modal"
                                                                data-bs-target="#delete_agreements{{ $agreement->id }}"><i
                                                                    class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                             <!-- Delete agreements Modal -->
                                             <div id="delete_agreements{{$agreement->id}}" class="modal custom-modal fade" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Agreement</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('admin.airline.agreements.destroy',$agreement->id)}}#agreement" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <p>Are you sure you want to Deactive
                                                                    <strong>{{$agreement->title}}</strong>?
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <textarea class="form-control" name="remarks" col="1"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Delete agreements Modal -->
                                            <div id="edit_agreements{{ $agreement->id }}" class="modal fade"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered ">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Agreements</h5>
                                                            <button type="button" class="close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.airline.agreements.update', $agreement->id) }}#provision"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PATCH')

                                                                <div class="row">

                                                                    <div class="form-group">
                                                                        <label for="doc_name">Incentive
                                                                            Description</label>
                                                                        <input type="text" class="form-control"
                                                                            id="doc_name" name="incentive_description"
                                                                            value="{{ $agreement->incentive_description }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="term">Term</label>
                                                                        <input type="text" class="form-control"
                                                                            id="term" name="term"
                                                                            value="{{ $agreement->term }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="status"> Agreement Status</label>
                                                                        <select id="agreement_status"
                                                                            name="agreement_status"
                                                                            class="form-control">
                                                                            <option value="1"
                                                                                {{ $agreement->agreement_status == 1 ? 'selected' : '' }}>
                                                                                Signed</option>
                                                                            <option value="2"
                                                                                {{ $agreement->specialFare && $data->agreement_status->status == 2 ? 'selected' : '' }}>
                                                                                Expired</option>
                                                                            <option value="3"
                                                                                {{ $agreement->specialFare && $data->agreement_status->status == 3 ? 'selected' : '' }}>
                                                                                Not Renewed</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="submit-section">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- Repeat for other documents -->
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="col-auto float-end ms-auto mt-2 mx-4 mb-2">
                            <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_pli"><i
                                    class="fa fa-plus"></i> Add PLI</a>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="padding-bottom: 70px;">Term</th>
                                            <th rowspan="2" style="padding-bottom: 70px;">Incentive Description</th>
                                            <th rowspan="2" style="padding-bottom: 70px;">Target</th>

                                            <th class="text-center" colspan="2">Buissness Class

                                            </th>
                                            <th class="text-center" colspan="2">Premium Class</th>
                                            <th class="text-center" colspan="2">Economy Class</th>
                                            <th>Valid From</th>
                                            <th>Valid Till</th>
                                            <th>Created On </th>
                                            <th>Created By</th>
                                        </tr>
                                        <tr>




                                            <th>Intl</th>
                                            <th>Dom</th>



                                            <th>Intl</th>
                                            <th>Dom</th>



                                            <th>Intl</th>
                                            <th>Dom</th>

                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agreements as $agreement)
                                            <tr>
                                                <td>{{ $agreement->term }}</td>

                                                <td>{{ $agreement->incentive_description }}</td>
                                                <td>{{ $agreement->target }}</td>
                                                <td>{{ $agreement->businessclass_intl }}</td>
                                                <td>{{ $agreement->businessclass_dom }}</td>
                                                <td>{{ $agreement->premiumclass_intl }}</td>
                                                <td>{{ $agreement->premiumclass_dom }}</td>
                                                <td>{{ $agreement->economyclass_intl }}</td>
                                                <td>{{ $agreement->economyclass_dom }}</td>
                                                <td>{{ $agreement->valid_from }}</td>
                                                <td>{{ $agreement->valid_from }}</td>
                                                <td>{{ $agreement->created_at }}</td>
                                                <td>{{ $agreement->created_by }}</td>



                                            </tr>
                                        @endforeach
                                        <!-- Repeat for other documents -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="add_pli" class="modal  custom-modal fade"  role="dialog">
                            <div class="modal-dialog container padding-custom modal-dialog-centered modal-xl " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add PLI</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.airline.pli.store') }}#provision" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" class="form-control" name="airline_id"
                                                id="airline" value="{{ $airlineDetails->airline_id }}">
                                                <input type="hidden" class="form-control" name="updated_at"
                                                        id="updated_at" value="  ">

                                            <div class="row form-group">
                                                <!-- <div class="col-md-6"> -->
                                                    <div class="col-sm-4">
                                                        <label for="agent_id">Agent</label>
                                                        <select name="agent_id" class="form-control">
                                                            @foreach ($agents as $agent)
                                                                <option value="{{ $agent->id }}">
                                                                    {{ $agent->company_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                <!-- </div> -->
                                                <!-- <div class="col-md-6"> -->
                                                    <div class="col-sm-4">
                                                        <label for="incentive_description">Target</label>
                                                        <input type="text" name="target" class="form-control">
                                                    </div>
                                                <!-- </div> -->
                                                 <!-- <div class="col-md-6"> -->

                                                 <div class="col-sm-4 ">
                                                        <label for="incentive_description">Incentive Description</label>
                                                        <input type="text" name="incentive_description"
                                                            class="form-control">
                                                    </div>
                                                <!-- </div> -->
                                            </div>

                                            <div class="row form-group">

                                                <!-- <div class=" col-md-6"> -->
                                                    <div class="col-sm-4 ">
                                                        <lable> &nbsp;</lable><br>
                                                        <label for="term">Term</label>
                                                        <input type="text" name="term" class="form-control">
                                                    </div>
                                                <!-- </div> -->
                                                <div class="col-sm-4">
                                                <label for="term">Business Class</label><br>
                                                        <label for="term">INTL:</label>
                                                        <input type="number" name="businessclass_intl"
                                                            class="form-control">
                                                    </div>

                                                    <div class="col-sm-4">
                                                    <label for="term">Business Class</label><br>
                                                        <label for="term">DOM:</label>
                                                        <input type="number" name="businessclass_dom"
                                                            class="form-control">
                                                    </div>
                                            </div>


                                            <!-- <div class="form-group">
                                                <div class="row">

                                                </div>
                                            </div> -->

                                            <div class=" row form-group">
                                                <!-- <div class="row"> -->
                                                    <div class="col-sm-4">
                                                <label for="term">Preimum Class</label><br>
                                                        <label for="term">INTL:</label>
                                                        <input type="number" name="premiumclass_intl"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-sm-4">
                                                <label for="term">Preimum Class</label><br>
                                                        <label for="term">DOM:</label>
                                                        <input type="number" name="premiumclass_dom"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-sm-4">
                                                <label for="term">Economy Class</label><br>
                                                        <label for="term">INTL:</label>
                                                        <input type="number" name="economyclass_intl"
                                                            class="form-control">
                                                    </div>
                                                <!-- </div> -->
                                            </div>

                                            <div class="row form-group">
                                                <!-- <div class="row"> -->

                                                    <div class="col-sm-4">
                                                <label for="term">Economy Class</label><br>
                                                        <label for="term">DOM:</label>
                                                        <input type="number" name="economyclass_dom"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-sm-4">
                                                    <lable> &nbsp;</lable><br>
                                                        <label>Valid From <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="valid_from"
                                                            id="edition_no">
                                                    </div>
                                                    <div class="col-sm-4">
                                                    <lable> &nbsp;</lable><br>
                                                        <label>Valid Till <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="valid_till"
                                                            id="issue_date">
                                                    </div>
                                                <!-- </div> -->
                                            </div>
                                            <div class="row">

                                                <!-- <div class="col-sm-6"> -->

                                                <!-- </div> -->
                                                <!-- <div class="col-md-6"> -->

                                                <!-- </div> -->
                                            </div>


                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="add_agreements" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Agreements</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('admin.airline.agreements.store') }}#provision" method="POST">
                                            @csrf
                                            <input type="hidden" class="form-control" name="airline_id"
                                                id="airline" value="{{ $airlineDetails->airline_id }}">

                                                <input type="hidden" class="form-control" name="updated_at"
                                                        id="updated_at" value="  ">

                                            <div class="form-group">
                                                <label for="agent_id">Agent</label>
                                                <select name="agent_id" class="form-control">
                                                    @foreach ($agents as $agent)
                                                        <option value="{{ $agent->id }}">{{ $agent->company_name }}
                                                            </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="incentive_description">Incentive Description</label>
                                                <input type="text" name="incentive_description"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="term">Term</label>
                                                <input type="text" name="term" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Agreement Status</label>
                                                <select id="status" name="agreement_status" class="form-control">


                                                    <option value="1">Signed</option>
                                                    <option value="2">Expired</option>
                                                    <option value="3">Not Renewed</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="special_fares" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-7 mt-2">
                            <form id="specialFareSearchForm" method="get">
                                    <input type="hidden" name="airline_id" value="{{ $airlineDetails->airline_id }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <!-- <label class="col-form-label">Search<span class="text-danger">*</span></label> -->
                                                <input class="form-control " style="line-height:38px !important;" placeholder="Search" type="text" name="search"
                                                    id="search">
                                            </div>
                                        </div>
                                        <div class="col-md-5 ">
                                            <div class="form-group">
                                                <select class="form-control" name="search_type[]" id="search_type" data-placeholder="Select Type" multiple>
                                                    <option value="company_name" >Agent Name</option>
                                                    <option value="agency_name " >Agent Group</option>
                                                    <option value="company_registration_no">Company Registration No</option>
                                                    <option value="iata" >IATA Number</option>
                                                    <option value="product_type" >Product Type</option>
                                                    <option value="fare_type" >Fare Type</option>
                                                    <option value="gds_type" >GDS Type</option>
                                                    <option value="focus_destinations" >Focus Destinations</option>
                                                    <option value="business_mode">Agent Type</option>
                                                    <option value="website" >Website</option>
                                                    <option value="account_code">Account Code</option>
                                                    <option value="pincode">Pincode</option>
                                                    <option value="city">City</option>
                                                    <option value="state">State</option>
                                                    <option value="country">Country</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <button type="button"  id="searchButton"
                                                    class="btn add-btn text-right" style="width:20px !important; padding:5px;">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                </div>
                                <div class="col-md-5">
                        <div class=" ms-auto mt-2  mb-2">
                            <a class="btn add-btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#add_target"><i
                                class="fa fa-plus"></i> Add / Edit
                            Special Fares</a>

                            <a class=" btn add-btn mx-2 btn-info text-white" data-bs-toggle="modal"

                                data-bs-target="#view_fares"><i class="fa fa-plus"></i> View
                                Special Fares</a>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Agent Company Name</th>
                                            <th>Private Fare Type</th>
                                            <th>Status</th>
                                            <th>IATA</th>
                                            <th>PCC/ Office Id</th>
                                            <th>Account Code</th>
                                            <th>Discount</th>
                                            <th>remarks</th>
                                            <th>Created On</th>
                                                <th>Created By</th>
                                                <th>Updated On</th>
                                                <th>Updated By</th>
                                        </tr>
                                    </thead>
                                    <tbody id="searchResults">
                                        @foreach ($specialFare as $fare)
                                            <tr>
                                                <td>{{ $fare->agent->company_name }}</td>
                                                <td>{{ $fare->fare_type }}</td>
                                                <td>
                                                    @if ($fare->status == 1)
                                                        Active
                                                    @else
                                                        Inactive
                                                    @endif

                                                </td>
                                                <td>{{ $fare->agent->iata }}</td>
                                                <td>{{ $fare->agent->pcc_office_id }}</td>
                                                <td>{{$fare->agent->account_code}}</td>
                                                <td> {{ $fare->fareDiscount ? $fare->fareDiscount->discount : 'N/A' }}</td>
                                                <td>{{ $fare->agent->remarks }}</td>
                                                <td>{{$fare->created_at}}</td>
                                                    <td>{{$fare->created_by}}</td>
                                                    <td>{{$fare->updated_at}}</td>
                                                    <td>{{$fare->updated_by}}</td>
                                            </tr>
                                        @endforeach
                                        <!-- Repeat for other agents -->
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
                <div id="view_fares" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Target</h5>
                                <button type="button" class="close"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{-- <form action="{{ route('admin.agent.target.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf --}}
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">
                                                    Agent</th>
                                                @foreach ($fareType as $ft)
                                                    <th class="fw-bold">
                                                        {{ $ft->fare_type }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($agents as $air)
                                                <tr>
                                                    <div class="form-group">
                                                        <input class="form-control"
                                                            type="hidden" name="airline_id"
                                                            value="{{ $airlineDetails->airline_id }}">
                                                    </div>
                                                    <th class="fw-bold">
                                                        {{ $air->company_name }}
                                                    </th>
                                                    @foreach ($fareType as $ft)
                                                        @php
                                                            $status = DB::table(
                                                                'special_fares',
                                                            )
                                                                ->where(
                                                                    'agent_id',
                                                                    $air->id,
                                                                )
                                                                ->where(
                                                                    'fare_type',
                                                                    $ft->fare_type_name,
                                                                )
                                                                ->where(
                                                                    'airline_id',
                                                                    $airlineDetails->airline_id,
                                                                )
                                                                ->value('status');
                                                        @endphp
                                                        <input type="hidden"
                                                            name="agent[{{ $air->id }}][{{ $ft->fare_type_name }}]"
                                                            value="2">
                                                        <th>
                                                            <input type="checkbox"
                                                                name="agent[{{ $air->id }}][{{ $ft->fare_type_name }}]"
                                                                value="1"
                                                                {{ $status == 1 ? 'checked' : '' }}>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="add_target" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Target</h5>
                                <button type="button" class="close"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form
                                    action="{{ route('admin.airline.target.store') }}#special_fares"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="fw-bold">Agent
                                                    </th>
                                                    @foreach ($fareType as $ft)
                                                        <th class="fw-bold">
                                                            {{ $ft->fare_type }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($agents as $air)
                                                    <tr>
                                                        <div class="form-group">
                                                            <input class="form-control"
                                                                type="hidden"
                                                                name="airline_id"
                                                                value="{{ $airlineDetails->airline_id }}">

                                                                <input class="form-control"
                                                                type="hidden"
                                                                name="updated_at"
                                                                value="  ">
                                                        </div>
                                                        <th class="fw-bold">
                                                            {{ $air->company_name }}</th>
                                                        @foreach ($fareType as $ft)
                                                            @php
                                                                $status = DB::table(
                                                                    'special_fares',
                                                                )
                                                                    ->where(
                                                                        'agent_id',
                                                                        $air->id,
                                                                    )
                                                                    ->where(
                                                                        'fare_type',
                                                                        $ft->fare_type_name,
                                                                    )
                                                                    ->where(
                                                                        'airline_id',
                                                                        $airlineDetails->airline_id,
                                                                    )
                                                                    ->value('status');
                                                            @endphp
                                                            <input type="hidden"
                                                                name="agent[{{ $air->id }}][{{ $ft->fare_type_name }}]"
                                                                value="2">
                                                            <th>
                                                                <input type="checkbox"
                                                                    name="agent[{{ $air->id }}][{{ $ft->fare_type_name }}]"
                                                                    value="1"
                                                                    {{ $status == 1 ? 'checked' : '' }}>
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary"
                                            type="submit">Submit</button>
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



<script src="https://cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('dos');
    CKEDITOR.replace('donts');
    CKEDITOR.replace('cancellation_policy');
    CKEDITOR.replace('date_change_policy');
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>


        $('#search_type').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });


$(document).ready(function() {
            $('#searchButton').on('click', function() {
                $('#searchResults').html('<tr><td colspan="8" class="text-center">Loading...</td></tr>');
                var searchData = $('#specialFareSearchForm').serialize();
                var airlineId = "{{ $airlineDetails->airline_id }}";
                const baseUrl = "{{ url('/') }}";

                $.ajax({
                    url: baseUrl + '/admin/airlines/get-special-fare/' + airlineId,
                    method: 'GET',
                    data: searchData,
                    success: function(response) {
                        $('#searchResults').empty();

                        if (response.specialFares.length === 0) {
                            $('#searchResults').html(
                                '<tr><td colspan="12" class="text-center">No records found</td></tr>'
                                );
                        } else {

                            response.specialFares.forEach(function(fare) {
                                var row = `<tr>
                                    <td>${fare.company_name}</td>
                                    <td>${fare.fare_type}</td>
                                    <td>${fare.status}</td>
                                    <td>${fare.iata}</td>
                                    <td>${fare.pcc_office_id}</td>
                                    <td>${fare.account_code}</td>
                                    <td>${fare.discount}</td>
                                    <td>${fare.remarks}</td>
                                    <td>${fare.created_at}</td>
                                    <td>${fare.created_by}</td>
                                    <td>${fare.updated_at}</td>
                                    <td>${fare.updated_by}</td>

                                </tr>`;

                                $('#searchResults').append(row);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error during search:', error);
                    }
                });
            });
        });



    function updateStatus(id, checkbox) {
        var form = document.getElementById('toggle-status-form-' + id);

        if (!form) {
            console.error('Form element not found');
            return;
        }

        var formData = new FormData(form);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    console.log('Status updated successfully');
                    window.location.reload();
                } else {
                    console.error('Status update failed');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', xhr.responseText);
            }
        });
    }

    function updateStatus1(id, checkbox) {
        var form = document.getElementById('toggle-status-form1-' + id);

        if (!form) {
            console.error('Form element not found');
            return;
        }

        var formData = new FormData(form);
        formData.append('_token', '{{ csrf_token() }}'); // Include CSRF token

        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    console.log('Status updated successfully');
                    window.location.reload();
                } else {
                    console.error('Status update failed');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', xhr.responseText);
            }
        });
    }

    function updateStatus2(id, checkbox) {
        var form = document.getElementById('toggle-status-form2-' + id);
        var formData = new FormData(form);

        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    console.log('Status updated successfully');
                    window.location.reload();
                } else {
                    console.error('Status update failed');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    }

    function updateStatus3(id, checkbox) {
        var form = document.getElementById('toggle-status-form3-' + id);
        var formData = new FormData(form);

        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    console.log('Status updated successfully');
                    window.location.reload();
                } else {
                    console.error('Status update failed');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    }

    function updateStatus4(id, checkbox) {
        var form = document.getElementById('toggle-status-form4-' + id);
        var formData = new FormData(form);

        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    console.log('Status updated successfully');
                    window.location.reload();
                } else {
                    console.error('Status update failed');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    }

    function updateStatus5(id, checkbox) {
        var form = document.getElementById('toggle-status-form5-' + id);
        var formData = new FormData(form);

        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    console.log('Status updated successfully');
                    window.location.reload();
                } else {
                    console.error('Status update failed');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    }

    function updateStatus6(id, checkbox) {
        var form = document.getElementById('toggle-status-form6-' + id);
        var formData = new FormData(form);

        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    console.log('Status updated successfully');
                    window.location.reload();
                } else {
                    console.error('Status update failed');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    }

    function updateStatus7(id, checkbox) {
        var form = document.getElementById('toggle-status-form7-' + id);
        var formData = new FormData(form);

        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    console.log('Status updated successfully');
                    // Optionally, you can add code here to handle UI updates
                    window.location.reload();
                } else {
                    console.error('Status update failed:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if there's a hash in the URL
        if (window.location.hash) {
            const activeTab = window.location.hash;
            // Find the corresponding tab and show it
            const tabElement = document.querySelector(`a[href="${activeTab}"]`);
            if (tabElement) {
                tabElement.click();
            }
        }

        // Optional: update the form action with the current tab on form submit
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const activeTab = document.querySelector('.nav-tabs .active a');
                if (activeTab) {
                    form.action += activeTab.getAttribute('href');
                }
            });
        });
    });
</script>
<script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Check if there's a hash in the URL
                    if (window.location.hash) {
                        const activeTab = window.location.hash;
                        // Find the corresponding tab and show it
                        const tabElement = document.querySelector(`a[href="${activeTab}"]`);
                        if (tabElement) {
                            tabElement.click();
                        }
                    }

                    // Optional: update the form action with the current tab on form submit
                    const forms = document.querySelectorAll('form');
                    forms.forEach(form => {
                        form.addEventListener('submit', function() {
                            const activeTab = document.querySelector('.nav-tabs .active a');
                            if (activeTab) {
                                form.action += activeTab.getAttribute('href');
                            }
                        });
                    });
                });
            </script>

@endsection
