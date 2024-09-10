@extends('admin/layouts/head-main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <title>Agent Profile</title>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
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
                            <li class="nav-item"><a href="#special_fares" data-bs-toggle="tab" class="nav-link">Special
                                    Fares
                                </a></li>
                            <li class="nav-item"><a href="#products_type" data-bs-toggle="tab" class="nav-link">Products
                                    Type
                                </a>
                            </li>
                            <li class="nav-item"><a href="#airline_activation" data-bs-toggle="tab" class="nav-link">Airline
                                    Activation </a></li>
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
                                            <div class="text"><a href="{{ $agent->websites }}"
                                                    target="_blank">{{ $agent->websites }}</a></div>
                                        </li>
                                        <li>
                                            <div class="title">Employees</div>
                                            <div class="text">{{ $agent->no_of_employees }}</div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="address" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill"
                                style="    background: none; border: none !important; box-shadow: none;">
                                <div class="card-header">
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_address"><i
                                            class="fa fa-plus"></i> Add Address</a>
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
                                    </div>
                                @endforeach
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
                                                <th>Last Updated on</th>
                                                <th>Last Updated by</th>
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
                                                    <td>{{ $contact->updated_at }}</td>
                                                    <td>{{ $contact->updated_by }}</td>
                                                </tr>
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
                                                                    <th>Discount</th>
                                                                    <th>remarks</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($specialFare as $fare)
                                                                    <tr>
                                                                        <td>{{ $fare->airline->airline_name }}</td>
                                                                        <td>{{ $fare->fare_type }}</td>
                                                                        <td>{{ $fare->status }}</td>
                                                                        <td>{{ $fare->agent->iata }}</td>
                                                                        <td>{{ $fare->agent->pcc_office_id }}</td>
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
                                                                <form action="{{ route('admin.agent.target.store') }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="table-responsive text-nowrap">
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
                                                                <div class="table-responsive text-nowrap">
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
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($agentProduct as $prod)
                                                                    <tr>
                                                                        <td>{{ $prod->product_type }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                <!-- Repeat for other agents -->
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                                <div id="add_product" class="modal custom-modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Add Product</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.agent.product.store') }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <input class="form-control" type="hidden"
                                                                                    name="agent_id"
                                                                                    value="{{ $agent->id }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Product Name
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="product_type">
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
                                            <div class="conversation-author">added by {{ $conversation->from }}</div>
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
                                                <form action="{{ route('admin.agent.conversation.store') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" type="hidden" name="from"
                                                                    value="{{ $agent->id }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Title <span
                                                                        class="text-danger">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="title">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Description</label>
                                                                <input class="form-control" type="text"
                                                                    name="description">
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
                                <div class="card-body">

                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_case"><i
                                            class="fa fa-plus"></i> Add Case History</a>

                                    <div class="table-responsive">
                                        <table class="table custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th class="fw-bold">Case Opening Date</th>
                                                    <th class="fw-bold">Case Id</th>
                                                    <th class="fw-bold">Opened By</th>
                                                    <th class="fw-bold">PNR</th>
                                                    <th class="fw-bold">Case Status</th>
                                                    <th class="fw-bold">Case Closed by</th>
                                                    <th class="fw-bold">Case Closing Date</th>
                                                    <th>Actions</th>

                                                </tr>

                                            </thead>
                                            <tbody>
                                                @foreach ($caseData as $data)
                                                    <td>{{ $data->case_opening_date }}</td>
                                                    <td>{{ $data->id }}</td>
                                                    <td>{{ $data->opened_by }}</td>
                                                    <td>{{ $data->pnr }}</td>
                                                    <td>{{ $data->case_status }}</td>
                                                    <td>{{ $data->case_closed_by }}</td>
                                                    <td>{{ $data->case_closing_date }}</td>
                                                    <td>
                                                        <!-- View Button -->
                                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#viewCaseModal-{{ $data->id }}"><i
                                                                class="fa fa-eye"></i></button>

                                                        <!-- Edit Button -->
                                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#editCaseModal-{{ $data->id }}"><i
                                                                class="fa fa-edit"></i></button>

                                                        <!-- Close Button -->
                                                        @if ($data->case_status !== 'Closed')
                                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                                data-bs-target="#closeCaseModal-{{ $data->id }}">Close</button>
                                                        @endif
                                                    </td>
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
                                                                    <p><strong>PNR:</strong> {{ $data->pnr }}</p>
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
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

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
                                                                        action="{{ route('admin.agent.cases.update', ['id' => $data->id]) }}"
                                                                        method="POST">
                                                                        @csrf
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
                                                                                <option value="Update">Update</option>
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
                                                                        action="{{ route('admin.agent.cases.close', ['id' => $data->id]) }}"
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
                                                    <form action="{{ route('admin.agent.case.store') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
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
                                                                    <input class="form-control" type="text"
                                                                        name="opened_by" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">PNR <span
                                                                            class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text"
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
                                                                        <option name="opened">Opened</option>
                                                                        <option name="updated">Updated</option>
                                                                        <option name="closed">Closed</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Case Closed By</label>
                                                                    <input class="form-control" type="text"
                                                                        name="case_closed_by">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Case Closing Date</label>
                                                                    <input class="form-control" type="date"
                                                                        name="case_closing_date">
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
                                                    <th>Type</th>
                                                    <th>Credit</th>
                                                    <th>Debit</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $balance = 0;
                                                @endphp
                                                @foreach ($agentAccounts as $account)
                                                    @php
                                                        $balance += $account->credit - $account->debit;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $account->tr_date }}</td>
                                                        <td>{{ $account->tr_type }}</td>
                                                        <td>{{ $account->credit }}</td>
                                                        <td>{{ $account->debit }}</td>
                                                        <td>{{ $balance }}</td>
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
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Travel Agent</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.transaction.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" type="hidden"
                                                                    name="agent_id" value="{{ $agent->id }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Debit Amount <span
                                                                        class="text-danger">*</span></label>
                                                                <input class="form-control" type="text"
                                                                    name="debit">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Credit Amount</label>
                                                                <input class="form-control" type="text"
                                                                    name="credit">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Type</label>
                                                                <input class="form-control" type="yext"
                                                                    name="tr_type">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Transaction Date</label>
                                                                <input class="form-control" type="date"
                                                                    name="tr_date">
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

                <div id="provision" class="pro-overview tab-pane fade show">
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
                                                        <table class="table table-striped custom-table mb-0 datatable">
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
                                                            <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>abcd</td>
                                                                    <td>read</td>
                                                                    <td>8596</td>
                                                                    <td>5453</td>
                                                                    <td>5454</td>
                                                                    <td>5454</td>
                                                                    <td>5454</td>
                                                                    <td>5454</td>
                                                                    <td>5454</td>
                                                                    <td>5454</td>
                                                                    <td>5454</td>

                                                                </tr>

                                                            </tbody>
                                                            @endforeach
                                                            <!-- Repeat for other agents -->
                                                            </tbody>
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
                                                                <form action="{{ route('admin.prov.store') }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <input class="form-control" type="hidden"
                                                                                    name="agent_id"
                                                                                    value="{{ $agent->id }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Prov. <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="prov">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label">Business</label>
                                                                                <input class="form-control" type="text"
                                                                                    name="business">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Pre
                                                                                    Economy</label>
                                                                                <input class="form-control" type="text"
                                                                                    name="pre_economy">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label">Economy</label>
                                                                                <input class="form-control" type="text"
                                                                                    name="economy">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Valid
                                                                                    from-to</label>
                                                                                <input class="form-control" type="date"
                                                                                    name="valid_from_to">
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
                                                        <table class="table table-striped custom-table mb-0 datatable">
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
                                                            <tbody>
                                                                @foreach ($agentPli as $pli)
                                                                    <tr>
                                                                        <td> 1</td>
                                                                        <td>abcd</td>
                                                                        <td>read</td>
                                                                        <td>8596</td>
                                                                        <td>5453</td>
                                                                        <td>5454</td>
                                                                        <td>5454</td>
                                                                        <td>5454</td>
                                                                        <td>5454</td>
                                                                        <td rowspan="2">5454</td>
                                                                        <td rowspan="2">5454</td>
                                                                        <td rowspan="2">5454</td>


                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">Total Max Payout</td>
                                                                        <td></td>
                                                                        <td>12</td>
                                                                        <td>12</td>
                                                                        <td>12</td>
                                                                        <td>12</td>
                                                                        <td>12</td>
                                                                        <td>12</td>
                                                                    </tr>
                                                                    <!-- Repeat for other agents -->
                                                                @endforeach
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
                                <div class="card-body">
                                    <form action="{{ route('admin.agent.target.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
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
                                        <div class="submit-section">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
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
                                <form action="{{ route('admin.pli.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="hidden" name="agent_id"
                                                    value="{{ $agent->id }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">PLI <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="pli">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Business</label>
                                                <input class="form-control" type="text" name="business">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Pre Economy</label>
                                                <input class="form-control" type="text" name="pre_economy">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Economy</label>
                                                <input class="form-control" type="text" name="economy">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Valid from-to</label>
                                                <input class="form-control" type="date" name="valid_from_to">
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
                            <div class="modal-header">
                                <h5 class="modal-title">Add Address</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.agent.address.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <input class="form-control" type="hidden" name="agent_id"
                                                    value="{{ $agent->id }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Street Address <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="street">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">City</label>
                                                <input class="form-control" type="text" name="city">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">State</label>
                                                <input class="form-control" type="text" name="state">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Country</label>
                                                <input class="form-control" type="text" name="country">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Pincode</label>
                                                <input class="form-control" type="text" name="pincode">
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
                            <div class="modal-header">
                                <h5 class="modal-title">Add Contact</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.agent.contact.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Title <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="title">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <input class="form-control" type="hidden" name="agent_id"
                                                    value="{{ $agent->id }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">First Name <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="first_name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Last Name</label>
                                                <input class="form-control" type="text" name="last_name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Email</label>
                                                <input class="form-control" type="text" name="email_address">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Phone</label>
                                                <input class="form-control" type="text" name="phone_number">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Position</label>
                                                <input class="form-control" type="text" name="position">
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
                <div class="edit-btn">
                    <a class="btn btn-primary" href="{{ route('admin.agent.update', ['id' => $agent->id]) }}">Edit</a>
                </div>

                <script>
                    document.getElementById('add-field').addEventListener('click', function() {
                        const fieldList = document.getElementById('field-list');
                        const newField = document.createElement('li');
                        newField.className = 'col-md-12 field-item';
                        newField.innerHTML = `
                        <div class="row">
                            <div class="col-md-4">
                                <div class="title">IATA Number:</div>
                                <div class="text">1234</div>
                            </div>
                            <div class="col-md-4">
                                <div class="title">GDS Type:</div>
                                <div class="text">India</div>
                            </div>
                            <div class="col-md-4">
                                <div class="title">PCC/Office ID:</div>
                                <div class="text">India
                                </div>
                            </div>
                        </div>
                    `;
                        fieldList.appendChild(newField);
                    });
                </script>

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
            @endsection
