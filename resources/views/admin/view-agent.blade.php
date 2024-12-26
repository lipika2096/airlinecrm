@extends('admin/layouts/head-main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <title>
        Agent Profile</title>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
        input[type=checkbox][disabled]{
            outline:1px solid grey; 
        }
        input[type=checkbox][disabled][ checked]{
            outline:1px solid #dddd;
            filter: invert(100%) hue-rotate(18deg) brightness(3);
        }
        .submit-section{
            margin-top:10px;
        }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                        <p class="d-inline text-dark font-weight-bolder">  <b class="d-inline text-capitalize">{{ $agent->company_name }}</b> profile</p>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->


            <div class="card tab-box">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item"><a href="#general" data-bs-toggle="tab" class="nav-link active">General</a>
                            </li>
                            <li class="nav-item"><a href="#address" data-bs-toggle="tab" class="nav-link">Address</a>
                            </li>
                            <li class="nav-item"><a href="#contact_details" data-bs-toggle="tab" class="nav-link">Contact
                                    Details</a></li>

                             <li class="nav-item"><a href="#products_type" data-bs-toggle="tab" class="nav-link">Products
                                    Type
                                </a>
                            </li>
                            <li class="nav-item"><a href="#airline_activation" data-bs-toggle="tab" class="nav-link">Airline
                                    Activation </a></li>

                            <li class="nav-item"><a href="#special_fares" data-bs-toggle="tab" class="nav-link">Special Fares
                                </a></li>
                            <li class="nav-item"><a href="#provision" data-bs-toggle="tab" class="nav-link">Provision / PLI
                                </a></li>
                            <li class="nav-item"><a href="#conversation" data-bs-toggle="tab" class="nav-link">Conversations
                                </a></li>
                            <li class="nav-item"><a href="#case_history" data-bs-toggle="tab" class="nav-link">Case History
                                </a></li>
                            <li class="nav-item"><a href="#accounts" data-bs-toggle="tab" class="nav-link">Accounts </a>
                            </li>
                            {{-- <li class="nav-item"><a href="#library" data-bs-toggle="tab" class="nav-link">Library </a>
                            </li> --}}
                        </ul>

                    </div>
                </div>
            </div>

            <div class="tab-content">
                <!-- Profile Info Tab -->


                <div id="general" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Company Name</div>
                                            <div class="text">{{ $agent->company_name }}</div>
                                        </li>

                                        <li>
                                            <div class="title">Brand Name</div>
                                            <div class="text">{{ $agent->owner_name }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Group</div>
                                            <div class="text">{{ $agent->agency_name }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Street</div>
                                            <div class="text">{{ $agent->address }}</div>
                                        </li>
                                        <li>
                                            <div class="title">State</div>
                                            <div class="text">{{ $agent->state }}</div>
                                        </li>
                                        <li>
                                            <div class="title">City</div>
                                            <div class="text">{{ $agent->city }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Pincode</div>
                                            <div class="text">{{ $agent->pincode }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Country</div>
                                            <div class="text">{{ $agent->country }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Company Registration No</div>
                                            <div class="text">{{ $agent->company_registration_no }}</div>
                                        </li>
                                        <ul id="field-list" class="list-unstyled">
                                            <li class="col-md-12 field-item">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="title">IATA Number:</div>
                                                        <div class="text">{{ $agent->iata }}</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="title">GDS Type:</div>
                                                        <div class="text">{{ $agent->gds_type }}</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="title">PCC/Office ID:</div>
                                                        <div class="text">{{ $agent->pcc_office_id }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>

                                        <li>
                                            <div class="title">Account Code</div>
                                            <div class="text">{{ $agent->account_code }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Discount</div>
                                            <div class="text">{{ $agent->discount }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Remarks</div>
                                            <div class="text">{{ $agent->remarks }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Business Model:</div>
                                            <div class="text">{{ $agent->business_mode }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Focused Destinations</div>
                                            <div class="text">
                                                <ul style="list-style: disc; margin-left: 20px;">
                                                    @foreach (json_decode($agent->focus_destinations) as $destination)
                                                        <li>{{ $destination }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">Key People</div>
                                            <div class="text">{{ $agent->key_people }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Parent Company</div>
                                            <div class="text">{{ $agent->parent_company }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Headquarters</div>
                                            <div class="text">{{ $agent->headquarters }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Website</div>
                                            <div class="text">
                                                <ul style="list-style: disc; margin-left: 20px;">
                                                    @foreach (json_decode($agent->websites) as $websites)
                                                        <li>{{ $websites }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">Employees</div>
                                            <div class="text">{{ $agent->no_of_employees }}</div>
                                        </li>

                                    </ul>
                                </div>

                                <!-- Edit Icon -->
                                <i class="fas fa-edit position-absolute top-0 end-0 m-3" data-bs-toggle="modal"
                                    data-bs-target="#edit_general{{ $agent->id }}"></i>

                                <div id="edit_general{{ $agent->id }}" class="modal custom-modal fade"
                                    role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit General Profile</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form
                                                    action="{{ route('admin.agent.edit', ['id' => $agent->id]) }}#general"
                                                    method="POST" enctype="multipart/form-data">@csrf
                                                    <!-- <ul class="personal-info">
                                                        <li> -->
                                                            <div class= "row form-group">
                                                            <!-- <div class="title">Company Name</div> -->
                                                            <div class="col-sm-4">
                                                                <lable class="form-lable">Company Name</lable>
                                                                <input type="text" class="form-control"
                                                                    name="company_name"
                                                                    value="{{ $agent->company_name }}">
                                                            </div>
                            <!-- </div> -->
                                                        <!-- </li> -->

                                                        <!-- <li> -->
                                                            <!-- <div class="title">Brand Name</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Brand Name</lable>
                                                                <input type="text" class="form-control"
                                                                    name="owner_name" value="{{ $agent->owner_name }}">
                                                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title">Group</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Group</lable>
                                                                <input type="text" class="form-control"
                                                                    name="agency_name" value="{{ $agent->agency_name }}">
                                                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title">Street</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Street</lable>
                                                                <input type="text" class="form-control" name="address"
                                                                    value="{{ $agent->address }}">
                                                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <div class="col-sm-4">
                                                                <lable class="form-lable">State</lable>
                                                                    <input type="text" class="form-control" name="state"
                                                                        value="{{ $agent->state }}">
                                                                </div>
                                                            <!-- <div class="title">City</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">City</lable>
                                                                <input type="text" class="form-control" name="city"
                                                                    value="{{ $agent->city }}">
                                                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title">Pincode</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Pincode</lable>
                                                                <input type="text" class="form-control" name="pincode"
                                                                    value="{{ $agent->pincode }}">
                                                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title">Country</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Country</lable>
                                                                <input type="text" class="form-control" name="country"
                                                                    value="{{ $agent->country }}">
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <!-- <div class="form-group"> -->
                                                                    <label class="col-form-label">Company Registration No.</label>
                                                                    <input class="form-control" type="text" name="company_registration_number" value="{{ $agent->company_registration_no }}">
                                                                </div>
                                                        </li>
                                                        <!-- <ul id="field-list" class="list-unstyled"> -->
                                                            <!-- <li class="col-md-12 field-item"> -->
                                                                <!-- <div class="row"> -->
                                                                    <!-- <div class="col-md-4"> -->
                                                                        <!-- <div class="title">IATA Number:</div> -->
                                                                        <div class="col-sm-4">
                                                                <lable class="form-lable">IATA Number</lable>
                                                                            <input type="text" class="form-control"
                                                                                name="iata"
                                                                                value="{{ $agent->iata }}">
                                                                        </div>
                                                                    <!-- </div> -->
                                                                    <!-- <div class="col-md-4"> -->
                                                                        <!-- <div class="title">GDS Type:</div> -->
                                                                        <div class="col-sm-4">
                                                                <lable class="form-lable">GDS Type</lable>
                                                                            <input type="text" class="form-control"
                                                                                name="gds_type"
                                                                                value="{{ $agent->gds_type }}">
                                                                        </div>
                                                                    <!-- </div> -->
                                                                    <!-- <div class="col-md-4"> -->
                                                                        <!-- <div class="title">PCC/Office ID:</div> -->
                                                                        <div class="col-sm-4">
                                                                <lable class="form-lable">PCC/Office ID:</lable>
                                                                            <input type="text" class="form-control"
                                                                                name="pcc_office_id"
                                                                                value="{{ $agent->pcc_office_id }}">
                                                                        </div>
                                                                    <!-- </div> -->
                                                                <!-- </div> -->
                                                            <!-- </li> -->
                                                        <!-- </ul> -->

                                                        <!-- <li> -->
                                                            <!-- <div class="title">Account Code</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Account Code</lable>
                                                                <input type="text" class="form-control"
                                                                    name="account_code"
                                                                    value="{{ $agent->account_code }}">
                                                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title">Discount</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Discount</lable>
                                                                <input type="text" class="form-control"
                                                                    name="discount" value="{{ $agent->discount }}">
                                                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title">Remarks</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Remarks</lable>
                                                                <input type="text" class="form-control" name="remarks"
                                                                    value="{{ $agent->remarks }}">
                                                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title">Business Model:</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Business Model</lable>
                                                                <input type="text" class="form-control"
                                                                    name="business_mode"
                                                                    value="{{ $agent->business_mode }}">
                                                            </div>
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Parent Company</lable>
                                                                <input type="text" class="form-control"
                                                                    name="parent_company"
                                                                    value="{{ $agent->parent_company }}">
                                                            </div>
                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title">Focused Destinations</div> -->
                                                            <div class="row form-group">
                                                            <lable class="form-lable">Focused Destinations</lable>
                                                                @foreach (json_decode($agent->focus_destinations) as $destination)
                                                                <div class=col-sm-4>
                                                                <input type="text" class="form-control"
                                                                        name="focus_destinations[]"
                                                                        value="{{ $destination }}">
                                                                        </div>
                                                                @endforeach
                                                            </div>
                            <!-- </div> -->
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <div class="row form-group">
                                                            <!-- <div class="title">Key People</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Key People</lable>
                                                                <input type="text" class="form-control"
                                                                    name="key_people" value="{{ $agent->key_people }}">
                                                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title">Parent Company</div> -->

                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title">Headquarters</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Headquarters</lable>
                                                                <input type="text" class="form-control"
                                                                    name="headquarters"
                                                                    value="{{ $agent->headquarters }}">
                                                            </div>
                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                        <!-- <div class="title">Employees</div> -->
                                                            <div class="col-sm-4">
                                                            <lable class="form-lable">Employees</lable>
                                                                <input type="text" class="form-control"
                                                                    name="no_of_employees"
                                                                    value="{{ $agent->no_of_employees }}">
                                                            </div>
                            </div>
                            <div class="row form-group">
                                                            <!-- <div class="title">Website</div> -->
                                                            <!-- <div class="row"> -->
                                                            <lable class="form-lable">Website</lable>

                                                                @foreach (json_decode($agent->websites) as $awebsites)
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"
                                                                        name="websites[]"
                                                                        value="{{ $awebsites }}">
                                                                        </div>
                                                                @endforeach

                                                                <!-- {{-- <input type="text" class="form-control"
                                                                    name="websites" value="{{ $agent->websites }}"
                                                                    placeholder="http://example.com"> --}} -->
                                                                    <!-- </div> -->
                                                        <!-- </li> -->
                                                        <!-- <li> -->

                                                        <!-- </li> -->
                                                        <!-- <li> -->
                                                            <!-- <div class="title"></div> -->
                                                            <div class="submit-section"><button class="btn btn-primary"
                                                                    type="submit">Update</button></div>
                                                                    </div>
                                                        <!-- </li> -->
                                                    <!-- </ul> -->

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div id="address" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill"
                                style="    background: none; border: none !important; box-shadow: none;">
                                <div class="card-header">
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_address"><i
                                            class="fa fa-plus"></i> Add Address</a>
                                </div>

                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Street Address</div>
                                                <div class="text">{{ $agent->address ?? 'null' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">City</div>
                                                <div class="text">{{ $agent->city ?? 'null' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">State</div>
                                                <div class="text">{{ $agent->state?? 'null' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Country</div>
                                                <div class="text">{{ $agent->country ?? 'null' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Pincode</div>
                                                <div class="text">{{ $agent->pincode ?? 'null' }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @foreach ($agentAddress as $address)
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Street Address</div>
                                                    <div class="text">{{ $address->street }}</div>
                                                </li>
                                                <li>
                                                    <div class="title">City</div>
                                                    <div class="text">{{ $address->city }}</div>
                                                </li>
                                                <li>
                                                    <div class="title">State</div>
                                                    <div class="text">{{ $address->state }}</div>
                                                </li>
                                                <li>
                                                    <div class="title">Country</div>
                                                    <div class="text">{{ $address->country }}</div>
                                                </li>
                                                <li>
                                                    <div class="title">Pincode</div>
                                                    <div class="text">{{ $address->pincode }}</div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Edit Icon -->
                                        <i class="fas fa-edit position-absolute top-0 end-0 m-3" data-bs-toggle="modal"
                                            data-bs-target="#edit_address{{ $address->id }}"></i>
                                        <div id="edit_address{{ $address->id }}" class="modal custom-modal fade"
                                            role="dialog">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="margin-bottom:-25px;">
                                                        <h5 class="modal-title">Edit Address</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ route('admin.agent.address.update', ['id' => $address->id]) }}#address"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">

                                                                    <div class="form-group">
                                                                        <input class="form-control" type="hidden"
                                                                            name="agent_id" value="{{ $agent->id }}">
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">Street Address <span
                                                                                class="text-danger">*</span></label>
                                                                        <input class="form-control"
                                                                            value="{{ $address->street }}"type="text"
                                                                            name="street">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">City</label>
                                                                        <input class="form-control"
                                                                            value="{{ $address->city }}" type="text"
                                                                            name="city">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">State</label>
                                                                        <input class="form-control"
                                                                            value="{{ $address->state }}" type="text"
                                                                            name="state">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">Country</label>
                                                                        <input class="form-control"
                                                                            value="{{ $address->country }}"
                                                                            type="text" name="country">
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">Pincode</label>
                                                                        <input class="form-control" type="text"
                                                                            required value="{{ $address->pincode }}"
                                                                            name="pincode">
                                                                    </div>
                                                                </div>
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
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div id="address" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill"
                                style="background: none; border: none !important; box-shadow: none;">
                                <div class="card-header">
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_address"><i
                                            class="fa fa-plus"></i> Add Address</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>Street Address</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Country</th>
                                                <th>Pincode</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                                <tr>
                                                    <td>{{ $agent->address ?? 'null' }}</td>
                                                    <td>{{ $agent->city ?? 'null' }}</td>
                                                    <td>{{ $agent->state?? 'null' }}</td>
                                                    <td>{{ $agent->country ?? 'null' }}</td>
                                                    <td>{{ $agent->pincode ?? 'null' }}</td>
                                                    <td><span class="badge badge-success p-2"> By default</span></td>

                                                </tr>
                                                @foreach ($agentAddress as $address)

                                                <tr>
                                                    <td>{{ $address->street }}</td>
                                                    <td>{{ $address->city }}</td>
                                                    <td>{{ $address->state }}</td>
                                                    <td>{{ $address->country }}</td>
                                                    <td>{{ $address->pincode }}</td>
                                                    <td>
                                                    <i class="fas fa-edit m-3" data-bs-toggle="modal"
                                            data-bs-target="#edit_address{{ $address->id }}"></i>
                                        <div id="edit_address{{ $address->id }}" class="modal custom-modal fade"
                                            role="dialog">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="margin-bottom:-25px;">
                                                        <h5 class="modal-title">Edit Address</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ route('admin.agent.address.update', ['id' => $address->id]) }}#address"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">

                                                                    <div class="form-group">
                                                                        <input class="form-control" type="hidden"
                                                                            name="agent_id" value="{{ $agent->id }}">
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">Street Address <span
                                                                                class="text-danger">*</span></label>
                                                                        <input class="form-control"
                                                                            value="{{ $address->street }}"type="text"
                                                                            name="street">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">City</label>
                                                                        <input class="form-control"
                                                                            value="{{ $address->city }}" type="text"
                                                                            name="city">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">State</label>
                                                                        <input class="form-control"
                                                                            value="{{ $address->state }}" type="text"
                                                                            name="state">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">Country</label>
                                                                        <input class="form-control"
                                                                            value="{{ $address->country }}"
                                                                            type="text" name="country">
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">Pincode</label>
                                                                        <input class="form-control" type="text"
                                                                            required value="{{ $address->pincode }}"
                                                                            name="pincode">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="submit-section">
                                                                <button class="btn btn-primary"
                                                                    type="submit">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                                    </td>
                                                </tr>
                                                @endforeach



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="contact_details" class="pro-overview tab-pane fade show ">

                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill"
                                style="    background: none; border: none !important; box-shadow: none;">
                                <div class="card-header">
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_contact"><i
                                            class="fa fa-plus"></i> Add Contacts</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Title</th>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Email Address</th>
                                                <th>Phone Number</th>
                                                <th>Add To Mail List</th>
                                                <th>Created On</th>
                                                <th>Created By</th>
                                                <th>Last Updated on</th>
                                                <th>Last Updated by</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($agentContact as $index => $contact)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $contact->title }}</td>
                                                    <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                                    <td>{{ $contact->position }}</td>
                                                    <td>{{ $contact->email_address }}</td>
                                                    <td>{{ $contact->phone_number }}</td>
                                                    <td>
                                                        <input type="checkbox" disabled {{ $contact->add_to_mail_list == 1 ? 'checked' : '' }}>
                                                    </td>

                                                    <td>{{ $contact->created_at }}</td>
                                                    <td>{{ $contact->created_by }}</td>
                                                    <td>{{ $contact->updated_at }}</td>
                                                    <td>{{ $contact->updated_by }}</td><!-- Edit Icon -->
                                                    <td>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#edit_contact{{ $contact->id }}"><i
                                                                class="fas fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                                <div id="edit_contact{{ $contact->id }}" class="modal custom-modal fade"
                                                    role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Contact</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('admin.agent.contact.update', ['id' => $contact->id]) }}#contact_details"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Title <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    value="{{ $contact->title }}"
                                                                                    type="text" name="title">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">

                                                                            <div class="form-group">
                                                                                <input class="form-control" type="hidden"
                                                                                    name="agent_id"
                                                                                    value="{{ $agent->id }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">First Name
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    value="{{ $contact->first_name }}"
                                                                                    type="text" name="first_name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Last
                                                                                    Name</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $contact->last_name }}"
                                                                                    type="text" name="last_name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Email</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $contact->email_address }}"
                                                                                    type="text" name="email_address">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Phone</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $contact->phone_number }}"
                                                                                    type="text" name="phone_number">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label">Position</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $contact->position }}"
                                                                                    type="text" name="position">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Add to mail List
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                        <input type="hidden" name="add_to_mail_list" value="0">
                                                                                        <input type="checkbox" name="add_to_mail_list" value="1"
                                                                                            {{ $contact->add_to_mail_list == 1 ? 'checked' : '' }}>
                                                                            </div>
                                                                        </div>
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
                                            @endforeach
                                            <!-- Repeat for other agents -->
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="special_fares" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <div class="card profile-box flex-fill">
                                                <div class="col-auto float-end ms-auto mt-2 mx-2">
                                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                                        style="border-radius:10px;" data-bs-target="#add_target"><i
                                                            class="fa fa-plus"></i> Add / Edit
                                                        Special Fares</a>

                                                    <a class="btn btn-info text-white" data-bs-toggle="modal"
                                                        style="margin-right:10px; border-radius:10px !important;"
                                                        data-bs-target="#view_fares"><i class="fa fa-plus"></i> View
                                                        Special Fares</a>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped custom-table mb-0 datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Airline</th>
                                                                    <th>Private Fare Type</th>
                                                                    <th>Status</th>
                                                                    <th>IATA</th>
                                                                    <th>PCC/ Office Id</th>
                                                                    <th>Account Code</th>
                                                                    <th>Discount</th>
                                                                    <th>remarks</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($specialFare as $fare)
                                                                    <tr>
                                                                        <td>{{ $fare->airline->airline_name }}</td>
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
                                                                        <td>{{ $fare->agent->discount }}</td>
                                                                        <td>{{ $fare->agent->remarks }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                <!-- Repeat for other agents -->
                                                            </tbody>
                                                        </table>

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
                                                                    action="{{ route('admin.agent.target.store') }}#special_fares"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="table-responsive text-nowrap" style="margin-top:-53px;">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="fw-bold">Airline/Service
                                                                                    </th>
                                                                                    @foreach ($fareType as $ft)
                                                                                        <th class="fw-bold">
                                                                                            {{ $ft->fare_type }}</th>
                                                                                    @endforeach
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($airline as $air)
                                                                                    <tr>
                                                                                        <div class="form-group">
                                                                                            <input class="form-control"
                                                                                                type="hidden"
                                                                                                name="agent_id"
                                                                                                value="{{ $agent->id }}">
                                                                                        </div>
                                                                                        <th class="fw-bold">
                                                                                            {{ $air->airline_name }}</th>
                                                                                        @foreach ($fareType as $ft)
                                                                                            @php
                                                                                                $status = DB::table(
                                                                                                    'special_fares',
                                                                                                )
                                                                                                    ->where(
                                                                                                        'airline_id',
                                                                                                        $air->id,
                                                                                                    )
                                                                                                    ->where(
                                                                                                        'fare_type',
                                                                                                        $ft->fare_type_name,
                                                                                                    )
                                                                                                    ->where(
                                                                                                        'agent_id',
                                                                                                        $agent->id,
                                                                                                    )
                                                                                                    ->value('status');
                                                                                            @endphp
                                                                                            <input type="hidden"
                                                                                                name="airline[{{ $air->id }}][{{ $ft->fare_type_name }}]"
                                                                                                value="2">
                                                                                            <th>
                                                                                                <input type="checkbox"
                                                                                                    name="airline[{{ $air->id }}][{{ $ft->fare_type_name }}]"
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
                                                                <div class="table-responsive text-nowrap" style="margin-top:-53px;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="fw-bold">
                                                                                    Airline/Service</th>
                                                                                @foreach ($fareType as $ft)
                                                                                    <th class="fw-bold">
                                                                                        {{ $ft->fare_type }}
                                                                                    </th>
                                                                                @endforeach
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($airline as $air)
                                                                                <tr>
                                                                                    <div class="form-group">
                                                                                        <input class="form-control"
                                                                                            type="hidden" name="agent_id"
                                                                                            value="{{ $agent->id }}">
                                                                                    </div>
                                                                                    <th class="fw-bold">
                                                                                        {{ $air->airline_name }}
                                                                                    </th>
                                                                                    @foreach ($fareType as $ft)
                                                                                        @php
                                                                                            $status = DB::table(
                                                                                                'special_fares',
                                                                                            )
                                                                                                ->where(
                                                                                                    'airline_id',
                                                                                                    $air->id,
                                                                                                )
                                                                                                ->where(
                                                                                                    'fare_type',
                                                                                                    $ft->fare_type_name,
                                                                                                )
                                                                                                ->where(
                                                                                                    'agent_id',
                                                                                                    $agent->id,
                                                                                                )
                                                                                                ->value('status');
                                                                                        @endphp
                                                                                        <input type="hidden"
                                                                                            name="airline[{{ $air->id }}][{{ $ft->fare_type_name }}]"
                                                                                            value="2">
                                                                                        <th>
                                                                                            <input type="checkbox"
                                                                                                name="airline[{{ $air->id }}][{{ $ft->fare_type_name }}]"
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

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="products_type" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <div class="card profile-box flex-fill">
                                                <div class="col-auto float-end ms-auto mt-2 mx-2">
                                                    <a class="btn add-btn" data-bs-toggle="modal"
                                                        data-bs-target="#add_product"><i class="fa fa-plus"></i> Add
                                                        Products types</a>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped custom-table mb-0 datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>List of Products </th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($agentProduct as $prod)
                                                                    <tr>
                                                                        <td>{{ $prod->product_type }}</td>
                                                                        <td>
                                                                            <a data-bs-toggle="modal"
                                                                                data-bs-target="#edit_product{{ $prod->id }}"><i
                                                                                    class="fa fa-pencil m-r-5"></i></a>

                                                                            <a data-bs-toggle="modal"
                                                                                data-bs-target="#delete_product{{ $prod->id }}"><i
                                                                                    class="fa fa-trash m-r-5"></i></a>

                                                                        </td>
                                                                    </tr>
                                                                    <div id="edit_product{{ $prod->id }}"
                                                                        class="modal custom-modal fade" role="dialog">
                                                                        <div
                                                                            class="modal-dialog modal-dialog-centered modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Edit Product
                                                                                    </h5>
                                                                                    <button type="button" class="close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form
                                                                                        action="{{ route('admin.agent.product.update', ['id' => $prod->id]) }}#products_type"
                                                                                        method="POST"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div class="row">
                                                                                            <div class="col-sm-6">
                                                                                                <div class="form-group">
                                                                                                    <input
                                                                                                        class="form-control"
                                                                                                        type="hidden"
                                                                                                        name="agent_id"
                                                                                                        value="{{ $agent->id }}">
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <label
                                                                                                        class="col-form-label">Product
                                                                                                        Name <span
                                                                                                            class="text-danger">*</span></label>
                                                                                                    <input
                                                                                                        class="form-control"
                                                                                                        type="text"
                                                                                                        name="product_type"
                                                                                                        value="{{ $prod->product_type }}">
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


                                                                    <!-- Delete Confirmation Modal -->
                                                                    <div id="delete_product{{ $prod->id }}"
                                                                        class="modal custom-modal fade" role="dialog">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Delete Product
                                                                                    </h5>
                                                                                    <button type="button" class="close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p>Are you sure you want to delete the
                                                                                        product
                                                                                        "{{ $prod->product_type }}"?</p>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <form
                                                                                        action="{{ route('admin.agent.product.delete', ['id' => $prod->id]) }}#products_type"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit"
                                                                                            class="btn btn-danger">Delete</button>
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-bs-dismiss="modal">Cancel</button>
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
                                                <div id="add_product" class="modal custom-modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="margin-bottom:-25px;">
                                                                <h5 class="modal-title">Add Product</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('admin.agent.product.store') }}#products_type"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                            <div class="form-group">
                                                                                <input class="form-control" type="hidden"
                                                                                    name="agent_id"
                                                                                    value="{{ $agent->id }}">
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Product Name
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="product_type" required>
                                                                            </div>
                                                                        </div>
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
                        </div>
                    </div>
                </div>

                <div id="conversation" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="col-auto float-end ms-auto mt-2 mx-2">
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_comments"><i
                                            class="fa fa-plus"></i> Add Comments</a>
                                </div>
                                <div class="card-body">
                                    @foreach ($agentConversation as $conversation)
                                        <div class="container">
                                            <div class="conversation-date">{{ $conversation->c_date }}</div>
                                            <div class="conversation-title">{{ $conversation->title }}</div>
                                            <div class="conversation-description">
                                                {{ $conversation->description }}
                                            </div>
                                            <div class="conversation-author">added by {{ $conversation->from}}</div>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="add_comments" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Comments</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.agent.conversation.store') }}#conversation"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input class="form-control" type="hidden" name="from"
                                                        value="{{ Auth()->user()->name }}">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <!-- <div class="form-group"> -->
                                                            <!-- </div> -->
                                                            <div class="form-group">
                                                                <label class="col-form-label">Airlines <span
                                                                        class="text-danger">*</span></label>
                                                                <select class="form-control" required
                                                                    name="airline_id">
                                                                    <option>Select Airline</option>
                                                                    @foreach ($airlineDetailData as $data )
                                                                        <option value="{{$data->airline_id}}">{{$data->airline->airline_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Subject <span
                                                                        class="text-danger">*</span></label>
                                                                <input class="form-control" type="text" required
                                                                    name="title">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Date of Contact <span
                                                                        class="text-danger">*</span></label>
                                                                <input class="form-control" type="date" required
                                                                    name="date_of_contact">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Remarks</label>
                                                                <textarea class="form-control"  required
                                                                    name="description"></textarea>
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
                    </div>
                </div>

                <div id="case_history" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">

                                <div class="col-auto float-end ms-auto mt-2 mx-2">
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_case"><i
                                            class="fa fa-plus"></i> Add Case History
                                        Data</a>
                                </div>

                                <div class="card-body">



                                    <div class="table-responsive">
                                        <table class="table custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                <th class="fw-bold">Case Status</th>
                                                <th class="fw-bold">Case Id</th>
                                                <th class="fw-bold">Airline</th>
                                                <th class="fw-bold">PNR</th>
                                                <th class="fw-bold">Ticket No</th>
                                                <th class="fw-bold">Remarks</th>
                                                <th class="fw-bold">Opened By</th>
                                                <th class="fw-bold">Case Opening Date</th>
                                                <th class="fw-bold">Case Closed by</th>
                                                <th class="fw-bold">Case Closing Date</th>
                                                    <th>Actions</th>

                                                </tr>

                                            </thead>
                                            <tbody>
                                                @foreach ($caseData as $data)
                                                    <tr>
                                                    <td>{{ $data->case_status }}</td>
                                                    <td>{{ $data->id }}</td>
                                                    <td>{{ $data->airline->airline_name?? '' }}</td>
                                                    <td>{{ $data->pnr }}</td>
                                                    <td>{{ $data->ticket_no }}</td>
                                                    <td>{{ $data->remarks }}</td>
                                                    <td>{{ $data->opened_by }}</td>
                                                    <td>{{ $data->case_opening_date }}</td>
                                                    <td>{{ $data->case_closed_by }}</td>
                                                    <td>{{ $data->case_closing_date }}</td>
                                                    <td>
                                                            <!-- View Button -->
                                                            <button class="btn btn-info text-light btn-sm" data-bs-toggle="modal"
                                                                data-bs-target="#viewCaseModal-{{ $data->id }}"><i
                                                                    class="fa fa-eye"></i></button>
                                                                    <div class="modal fade" id="viewCaseModal-{{ $data->id }}"
                                                        tabindex="-1" aria-labelledby="viewCaseModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewCaseModalLabel">View
                                                                        Case: {{ $data->case_id }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered custom-table mb-0 datatable">
                                                                        <thead>
                                                                            <tr>
                                                                            <th scope="col">Date</th>
                                                                            <th scope="col">PNR</th>
                                                                            <td scope="col">{{ $data->pnr }}</td>
                                                                            <th scope="col">Ticket No.</th>
                                                                            <td scope="col">{{ $data->ticket_no }}</td>
                                                                            <th scope="col">Case Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($data->updates as $update)
                                                                                <tr>
                                                                                    <td scope="row">{{ $update->update_date }}</td>
                                                                                    <td colspan="4">{{$update->comments}}</td>
                                                                                    <td>
                                                                                        Case @if ($update->status == 'Update')
                                                                                        Re-opened
                                                                                        @else {{$update->status}}
                                                                                        @endif  by {{$update->updated_by}}
                                                                                    </td>
                                                                                </tr>

                                                                            @endforeach
                                                                        </tbody>

                                                                    </table>
                                                                </div>
                                                                    <!-- <p><strong>PNR:</strong> {{ $data->pnr }}</p>
                                                                    <p><strong>Ticket No:</strong> {{ $data->ticket_no }}
                                                                    </p>
                                                                    <p><strong>Opened by:</strong> {{ $data->opened_by }}
                                                                    </p>
                                                                    <p><strong>Status:</strong> {{ $data->case_status }}
                                                                    </p>
                                                                    <p><strong>Closing Date:</strong>
                                                                        {{ $data->case_closing_date }}</p>
                                                                    <hr>
                                                                    <h5>Conversation History:</h5>
                                                                    @foreach ($data->updates as $update)
                                                                        <p><strong>{{ $update->update_date }}</strong> -
                                                                            {{ $update->comments }}</p>
                                                                    @endforeach -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                            <!-- Edit Button -->
                                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                                data-bs-target="#editCaseModal-{{ $data->id }}"><i
                                                                    class="fa fa-edit"></i></button>

                                                            <!-- Close Button -->
                                                            @if ($data->case_status !== 'Closed')
                                                                <button class="btn btn-danger btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#closeCaseModal-{{ $data->id }}">Close</button>
                                                            @endif
                                                        </td>
                                                    </tr>


                                                    <div class="modal fade" id="editCaseModal-{{ $data->id }}"
                                                        tabindex="-1" aria-labelledby="editCaseModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editCaseModalLabel">Edit
                                                                        Case: {{ $data->case_id }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('admin.agent.cases.update', ['id' => $data->id]) }}#case_history"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <div class="mb-3">
                                                                            <h5>Previous Conversations:</h5>
                                                                            @foreach ($data->updates as $update)
                                                                                <p><strong>{{ $update->update_date }}</strong>
                                                                                    - {{ $update->comments }}</p>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="status"
                                                                                class="form-label">Update Status</label>
                                                                            <select name="status" id="status"
                                                                                class="form-select">
                                                                                <option value="Update">Re-open</option>
                                                                                <option value="Close">Close</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="comments"
                                                                                class="form-label">Comments</label>
                                                                            <textarea name="comments" id="comments" class="form-control" rows="4" required></textarea>
                                                                        </div>
                                                                        <div class="text-end">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Save
                                                                                Changes</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- resources/views/cases/partials/close-modal.blade.php -->

                                                    <div class="modal fade" id="closeCaseModal-{{ $data->id }}"
                                                        tabindex="-1" aria-labelledby="closeCaseModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="closeCaseModalLabel">Close
                                                                        Case: {{ $data->case_id }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('admin.agent.cases.close', ['id' => $data->id]) }}#case_history"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <input class="form-control"
                                                                                        type="hidden" name="caseId"
                                                                                        value="{{ $data->id }}">
                                                                                </div>
                                                                            </div>
                                                                            <h5>Previous Conversations:</h5>
                                                                            @foreach ($data->updates as $update)
                                                                                <p><strong>{{ $update->update_date }}</strong>
                                                                                    - {{ $update->comments }}</p>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="comments"
                                                                                class="form-label">Closing Comments</label>
                                                                            <textarea name="comments" id="comments" class="form-control" rows="4" required></textarea>
                                                                        </div>
                                                                        <div class="text-end">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Close Case</button>
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
                                    <div id="add_case" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Case History</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.agent.case.store') }}#case_history"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf


                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Airline Id <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="form-control"
                                                                        name="airline_id" required>
                                                                        <option>Select Airline</option>
                                                                        @foreach ($airlineDetailData as $airData)
                                                                            <option value="{{$airData->airline_id}}">{{$airData->airline->airline_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Case Opening Date <span
                                                                            class="text-danger">*</span></label>
                                                                    <input class="form-control" type="date"
                                                                        name="case_opening_date" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Opened By <span
                                                                            class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text" required
                                                                        name="opened_by" readonly value="{{auth()->user()->name }}" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Ticket No <span
                                                                            class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text" required
                                                                        name="ticket_no" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">PNR <span
                                                                            class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text" required
                                                                        name="pnr" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Case Status <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="form-control" name="case_status">
                                                                        <option value="" disabled>Select status
                                                                        </option>
                                                                        <option name="opened" selected>Opened</option>
                                                                        <option name="updated">Updated</option>
                                                                        <option name="closed">Closed</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            {{-- <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Case Closed By</label>
                                                                    <input class="form-control" type="text" required
                                                                        name="case_closed_by">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Case Closing Date</label>
                                                                    <input class="form-control" type="date"
                                                                        name="case_closing_date">
                                                                </div>
                                                            </div> --}}

                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Remarks <span
                                                                            class="text-danger">*</span></label>
                                                                    <textarea class="form-control"
                                                                        required name="remarks" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <input class="form-control" type="hidden"
                                                                        name="agent_id" value="{{ $agent->id }}">
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
                        </div>
                    </div>
                </div>

                <div id="accounts" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="col-auto float-end ms-auto mt-2 mx-2">
                                    <a href="#" class="btn add-btn" data-bs-toggle="modal"
                                        data-bs-target="#add_agent"><i class="fa fa-plus"></i> Add transaction</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Remarks</th>
                                                    <th>Credit</th>
                                                    <th>Debit</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $balance = $agentAccountBal->balance?? 0;
                                                @endphp
                                                @foreach ($agentAccounts as $account)
                                                    @php
                                                        $balance += $account->credit - $account->debit;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $account->tr_date }}</td>
                                                        <td>{{ $account->tr_type }}</td>
                                                        <td>{{ $account->credit ?? 0 }}</td>
                                                        <td>{{ $account->debit ?? 0 }}</td>
                                                        <td>{{ $account->balance }}</td>
                                                    </tr>
                                                @endforeach
                                                <!-- Repeat for other agents -->
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div id="add_agent" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header " style="margin-bottom: -25px;">
                                                <h5 class="modal-title">Add Transactions</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.transaction.store') }}#accounts"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                            <div class="form-group">
                                                                <input class="form-control" type="hidden"
                                                                    name="agent_id" value="{{ $agent->id }}">
                                                            </div>
                                                            <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Debit Amount <span
                                                                        class="text-danger">*</span></label>
                                                                <input class="form-control" type="text" required
                                                                    name="debit" id="debit">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Credit Amount</label>
                                                                <input class="form-control" type="text" required
                                                                    name="credit" id="credit">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Transaction Date</label>
                                                                <input class="form-control" type="date"
                                                                    name="tr_date">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Remarks</label>
                                                                <textarea class="form-control" type="text"
                                                                    name="tr_type"></textarea>
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
                    </div>
                </div>


                <div id="provision" class="pro-overview tab-pane fade">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <div class="card profile-box flex-fill">
                                                <div class="col-auto float-end ms-auto mt-2 mx-2">
                                                    <a class="btn add-btn" data-bs-toggle="modal"
                                                        data-bs-target="#add_prov"><i class="fa fa-plus"></i> Add Prov.
                                                        Data</a>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table custom-table mb-0 datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2" style="padding-bottom: 70px;">Term
                                                                    </th>
                                                                    <th rowspan="2" style="padding-bottom: 70px;">
                                                                        Incentive Description</th>
                                                                    <th rowspan="2" style="padding-bottom: 70px;">
                                                                        Target</th>

                                                                    <th class="text-center" colspan="2">Buissness Class

                                                                    </th>
                                                                    <th class="text-center" colspan="2">Premium Class
                                                                    </th>
                                                                    <th class="text-center" colspan="2">Economy Class
                                                                    </th>
                                                                    <th>Valid From</th>
                                                                    <th>Valid Till</th>
                                                                    <th>Airline</th>
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

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($agentProv as $prov)
                                                                    <tr>
                                                                        <td>{{ $prov->term }}</td>
                                                                        <td>{{ $prov->incentive_description }}</td>
                                                                        <td>{{ $prov->target }}</td>
                                                                        <td>{{ $prov->businessclass_intl }}</td>
                                                                        <td>{{ $prov->businessclass_dom }}</td>
                                                                        <td>{{ $prov->premiumclass_intl }}</td>
                                                                        <td>{{ $prov->premiumclass_dom }}</td>
                                                                        <td>{{ $prov->economyclass_intl }}</td>
                                                                        <td>{{ $prov->economyclass_dom }}</td>
                                                                        <td>{{ $prov->valid_from }}</td>
                                                                        <td>{{ $prov->valid_till }}</td>
                                                                        <td>{{ $prov->airline->airline_name }}</td>

                                                                    </tr>

                                                            </tbody>
                                                            @endforeach
                                                            <!-- Repeat for other agents -->

                                                        </table>

                                                    </div>
                                                </div>
                                                <div id="add_prov" class="modal custom-modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Add Prov. Data</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.prov.store') }}#provision"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <input class="form-control" type="hidden"
                                                                            name="agent_id" value="{{ $agent->id }}">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Airline<span
                                                                                        class="text-danger">*</span></label>
                                                                                <select class="select form-control"
                                                                                    name="airline_id">
                                                                                    <option selected disabled>Select Airline
                                                                                    </option>
                                                                                    @foreach ($airline as $air)
                                                                                        <option
                                                                                            value="{{ $air->id }}">
                                                                                            {{ $air->airline_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Incentive
                                                                                    Description <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    required name="incentive_description"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Term <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="text" required
                                                                                    name="term" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Target <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="text" required
                                                                                    name="target" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Business
                                                                                    Class Intl <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="number"
                                                                                    name="businessclass_intl" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Business
                                                                                    Class Dom <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="number"
                                                                                    name="businessclass_dom"
                                                                                    id="numberInput" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Premium
                                                                                    Class
                                                                                    Intl <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="number"
                                                                                    name="premiumclass_intl" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Premium
                                                                                    Class
                                                                                    Dom <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="number"
                                                                                    name="premiumclass_dom" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Economy
                                                                                    Class
                                                                                    Intl <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="number"
                                                                                    name="economyclass_intl" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Economy
                                                                                    Class
                                                                                    Dom <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="number"
                                                                                    name="economyclass_dom" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Valid From
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="date" name="valid_from"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Valid Till
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control"
                                                                                    type="date" name="valid_till"
                                                                                    required>
                                                                            </div>
                                                                        </div>
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
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <div class="card profile-box flex-fill">
                                                <div class="col-auto float-end ms-auto mt-2 mx-2">
                                                    <a class="btn add-btn" data-bs-toggle="modal"
                                                        data-bs-target="#add_pli"><i class="fa fa-plus"></i> Add PLI
                                                        Data</a>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table custom-table mb-0 datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2" style="padding-bottom: 70px;">
                                                                        Term
                                                                    </th>
                                                                    <th rowspan="2" style="padding-bottom: 70px;">
                                                                        Incentive Description</th>
                                                                    <th rowspan="2" style="padding-bottom: 70px;">
                                                                        Target</th>
                                                                    <th class="text-center" colspan="2">Business
                                                                        Class
                                                                    </th>
                                                                    <th class="text-center" colspan="2">Premium Class
                                                                    </th>
                                                                    <th class="text-center" colspan="2">Economy Class
                                                                    </th>
                                                                    <th>Valid From</th>
                                                                    <th>Valid Time</th>
                                                                    <th>Airline</th>
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
                                                                </tr>
                                                            </thead>
                                                            <tbody>@php
                                                                // Initialize sum values to 0
                                                                $sumBusinessIntl = 0;
                                                                $sumBusinessDom = 0;
                                                                $sumPremiumIntl = 0;
                                                                $sumPremiumDom = 0;
                                                                $sumEconomyIntl = 0;
                                                                $sumEconomyDom = 0;
                                                            @endphp
                                                                @foreach ($agentPli as $pliGroup)
                                                                    @foreach ($pliGroup as $index => $pli)
                                                                        @php
                                                                            // Calculate the sum for each field within the group
                                                                            $sumBusinessIntl +=
                                                                                $pli->businessclass_intl;
                                                                            $sumBusinessDom += $pli->businessclass_dom;
                                                                            $sumPremiumIntl += $pli->premiumclass_intl;
                                                                            $sumPremiumDom += $pli->premiumclass_dom;
                                                                            $sumEconomyIntl += $pli->economyclass_intl;
                                                                            $sumEconomyDom += $pli->economyclass_dom;
                                                                        @endphp
                                                                        <tr>
                                                                            @if ($index == 0)
                                                                                <td rowspan="{{ count($pliGroup) }}">
                                                                                    {{ $pli->term }}</td>
                                                                            @endif
                                                                            <td>{{ $pli->incentive_description }}</td>
                                                                            <td>{{ $pli->target }}</td>
                                                                            <td>{{ $pli->businessclass_intl }}%</td>
                                                                            <td>{{ $pli->businessclass_dom }}%</td>
                                                                            <td>{{ $pli->premiumclass_intl }}%</td>
                                                                            <td>{{ $pli->premiumclass_dom }}%</td>
                                                                            <td>{{ $pli->economyclass_intl }}%</td>
                                                                            <td>{{ $pli->economyclass_dom }}%</td>
                                                                            @if ($index == 0)
                                                                                <td rowspan="{{ count($pliGroup) }}">
                                                                                    {{ $pli->valid_from }}</td>
                                                                                <td rowspan="{{ count($pliGroup) }}">
                                                                                    {{ $pli->valid_till }}</td>
                                                                                <td rowspan="{{ count($pliGroup) }}">
                                                                                    {{ $pli->airline->airline_name }}</td>
                                                                            @endif
                                                                        </tr>
                                                                    @endforeach
                                                                @endforeach
                                                                <tr>
                                                                    <td colspan="2">Total Max Payout</td>
                                                                    <td></td>
                                                                    <td>{{ $sumBusinessIntl }}%</td>
                                                                    <td>{{ $sumBusinessDom }}%</td>
                                                                    <td>{{ $sumPremiumIntl }}%</td>
                                                                    <td>{{ $sumPremiumDom }}%</td>
                                                                    <td>{{ $sumEconomyIntl }}%</td>
                                                                    <td>{{ $sumEconomyDom }}%</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="airline_activation" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body row ">
                                    <div class="col-sm-12 ">
                                        <div class="float-end">
                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                    style="border-radius:10px;" data-bs-target="#add_airline_activation"><i
                                        class="fa fa-plus"></i> Add / Edit Airline Activations</a></div>
                                        </div>
                                        <div class="col-sm-12">
                                    {{-- <form action="{{ route('admin.agent.target.store') }}#airline_activation"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf --}}
                                        <div class="table-responsive text-nowrap">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="fw-bold">Airline/Service</th>
                                                        @foreach ($fareType as $ft)
                                                            <th class="fw-bold">{{ $ft->fare_type }}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($airline as $air)
                                                        <tr>
                                                            <div class="form-group">
                                                                <input class="form-control" type="hidden"
                                                                    name="agent_id" value="{{ $agent->id }}">
                                                            </div>
                                                            <th class="fw-bold">{{ $air->airline_name }}</th>
                                                            @foreach ($fareType as $ft)
                                                                @php
                                                                    $status = DB::table('special_fares')
                                                                        ->where('airline_id', $air->id)
                                                                        ->where('fare_type', $ft->fare_type_name)
                                                                        ->where('agent_id', $agent->id)
                                                                        ->value('status');
                                                                @endphp
                                                                <input type="hidden"
                                                                    name="airline[{{ $air->id }}][{{ $ft->fare_type_name }}]"
                                                                    value="2">
                                                                <th>
                                                                    <input type="checkbox"
                                                                        name="airline[{{ $air->id }}][{{ $ft->fare_type_name }}]"
                                                                        value="1"
                                                                        {{ $status == 1 ? 'checked' : '' }}>
                                                                </th>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                        {{-- <div class="submit-section">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="add_airline_activation" class="modal custom-modal fade" role="dialog">
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
                                <form action="{{ route('admin.agent.target.store') }}#airline_activation"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="table-responsive text-nowrap" style="margin-top:-53px;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">Airline/Service</th>
                                                @foreach ($fareType as $ft)
                                                    <th class="fw-bold">{{ $ft->fare_type }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($airline as $air)
                                                <tr>
                                                    <div class="form-group">
                                                        <input class="form-control" type="hidden"
                                                            name="agent_id" value="{{ $agent->id }}">
                                                    </div>
                                                    <th class="fw-bold">{{ $air->airline_name }}</th>
                                                    @foreach ($fareType as $ft)
                                                        @php
                                                            $status = DB::table('special_fares')
                                                                ->where('airline_id', $air->id)
                                                                ->where('fare_type', $ft->fare_type_name)
                                                                ->where('agent_id', $agent->id)
                                                                ->value('status');
                                                        @endphp
                                                        <input type="hidden"
                                                            name="airline[{{ $air->id }}][{{ $ft->fare_type_name }}]"
                                                            value="2">
                                                        <th>
                                                            <input type="checkbox"
                                                                name="airline[{{ $air->id }}][{{ $ft->fare_type_name }}]"
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
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="add_pli" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add PLI Data</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.pli.store') }}#provision" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input class="form-control" type="hidden" name="agent_id"
                                            value="{{ $agent->id }}">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Airline<span
                                                        class="text-danger">*</span></label>
                                                <select class="select form-control" name="airline_id">
                                                    <option selected disabled>Select Airline</option>
                                                    @foreach ($airline as $air)
                                                        <option value="{{ $air->id }}">{{ $air->airline_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Incentive Description <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" required
                                                    name="incentive_description" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Term <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" required name="term"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Target <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" required name="target"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Business Class Intl <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="businessclass_intl"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Business Class Dom <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="businessclass_dom"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Premium Class Intl <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="premiumclass_intl"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Premium Class Dom <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="premiumclass_dom"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Economy Class Intl <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="economyclass_intl"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Economy Class Dom <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="economyclass_dom"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Valid From <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="date" name="valid_from" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Valid Till <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="date" name="valid_till" required>
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


                <div id="add_address" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="margin-bottom:-25px;">
                                <h5 class="modal-title">Add Address</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.agent.address.store') }}#address" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                    <div class="form-group">
                                                <input class="form-control" type="hidden" name="agent_id"
                                                    value="{{ $agent->id }}">
                                            </div>
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Street Address <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" required name="street">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">City</label>
                                                <input class="form-control" type="text" required name="city">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">State</label>
                                                <input class="form-control" type="text" required name="state">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Country</label>
                                                <input class="form-control" type="text" required name="country">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Pincode</label>
                                                <input class="form-control" type="text" required name="pincode">
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

                <div id="add_contact" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="margin-bottom:-25px;">
                                <h5 class="modal-title">Add Contact</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.agent.contact.store') }}#contact_details" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                    <div class="form-group">
                                                <input class="form-control" type="hidden" name="agent_id"
                                                    value="{{ $agent->id }}">
                                                    <input class="form-control" type="hidden" required name="updated_at" value=" ">
                                            </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Title <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" required name="title">
                                            </div>
                                        </div>
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">First Name <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" required name="first_name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Last Name</label>
                                                <input class="form-control" type="text" required name="last_name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Email</label>
                                                <input class="form-control" type="text" required
                                                    name="email_address">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Phone</label>
                                                <input class="form-control" type="text" required
                                                    name="phone_number">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Position</label>
                                                <input class="form-control" type="text" required name="position">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Add to mail List
                                                    <span
                                                        class="text-danger">*</span></label>
                                                        <input type="checkbox" name="add_to_mail_list" value="1">
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


            <style>
                .conversation-date {
                    font-weight: bold;
                    margin-bottom: 10px;
                }

                .conversation-title {
                    font-weight: bold;
                    font-size: 1.2em;
                    margin-bottom: 20px;
                }

                .conversation-description {
                    margin-bottom: 20px;
                }

                .conversation-author {
                    text-align: right;
                    font-style: italic;
                }
            </style>
            <script>
                document.addEventListener('input', function(e) {
                    if (e.target.type === 'number') {
                        e.target.value = e.target.value.replace(/[^0-9]/g, '');
                    }
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

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const debitField = document.getElementById('debit');
                    const creditField = document.getElementById('credit');

                    debitField.addEventListener('input', function() {
                        if (debitField.value.trim() !== '') {
                            creditField.disabled = true;
                        } else {
                            creditField.disabled = false;
                        }
                    });

                    creditField.addEventListener('input', function() {
                        if (creditField.value.trim() !== '') {
                            debitField.disabled = true;
                        } else {
                            debitField.disabled = false;
                        }
                    });
                });
            </script>
        @endsection
