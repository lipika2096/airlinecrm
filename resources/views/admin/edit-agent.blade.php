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
                        <h3 class="page-title">Update Agent Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Agent Profile</li>
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
                            {{-- <li class="nav-item"><a href="#airline_activation" data-bs-toggle="tab" class="nav-link">Airline
                                    Activation </a></li> --}}
                            <li class="nav-item"><a href="#provision" data-bs-toggle="tab" class="nav-link">Provision / PLI
                                </a></li>
                            {{-- <li class="nav-item"><a href="#conversation" data-bs-toggle="tab" class="nav-link">Conversations
                                </a></li> --}}
                            {{-- <li class="nav-item"><a href="#case_history" data-bs-toggle="tab" class="nav-link">Case History
                                </a></li> --}}
                            {{-- <li class="nav-item"><a href="#accounts" data-bs-toggle="tab" class="nav-link">Accounts </a>
                            </li> --}}
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
                                    <form action="{{ route('admin.agent.general.update', ['id'=>$agent->id]) }}" method="POST" enctype="multipart/form-data">@csrf
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Company Name</div>
                                            <div class="text"><input type="text"class="form-control" name="agency_name" value="{{$agent->agency_name}}"></div>
                                        </li>
                                        <li>
                                            <div class="title">Street</div>
                                            <div class="text"><input type="text" class="form-control" name="address"  value="{{$agent->address}}"></div>
                                        </li>
                                        <li>
                                            <div class="title">City</div>
                                            <div class="text"><input type="text" class="form-control" name="city"  value="{{$agent->city}}"></div>
                                        </li>
                                        <li>
                                            <div class="title">Pincode</div>
                                            <div class="text"><input type="text" class="form-control" name="pincode"  value="{{$agent->pincode}}"></div>
                                        </li>
                                        <li>
                                            <div class="title">Country</div>
                                            <div class="text"><input type="text"  class="form-control" name="country" value="{{$agent->country}}"></div>
                                        </li>
                                        <ul id="field-list" class="list-unstyled">
                                            <li class="col-md-12 field-item">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="title">IATA Number:</div>
                                                        <div class="text"><input type="text"  name="iata"  value="{{$agent->iata}}"class="form-control"></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="title">GDS Type:</div>
                                                        <div class="text"><input type="text" value="{{$agent->gds_type}}"  class="form-control"name="gds_type" ></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="title">PCC/Office ID:</div>
                                                        <div class="text"><input class="form-control"type="text" value="{{$agent->pcc_office_id}}"  name="pcc_office_id" ></div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <li>
                                            <div class="title">Business Mode:</div>
                                            <div class="text"><input type="text" value="{{$agent->business_mode}}"  class="form-control"name="business_mode" ></div>
                                        </li>
                                        <li>
                                            <div class="title">Focus Destinations</div>
                                            <div class="text"><input type="text"class="form-control" value="{{$agent->focus_destinations}}"  name="focus_destinations" ></div>
                                        </li>
                                        <li>
                                            <div class="title">Key People</div>
                                            <div class="text"><input type="text" class="form-control"value="{{$agent->key_people}}"  name="key_people" ></div>
                                        </li>
                                        <li>
                                            <div class="title">Parent Company</div>
                                            <div class="text"><input type="text" class="form-control" value="{{$agent->parent_company}}"  name="parent_company" ></div>
                                        </li>
                                        <li>
                                            <div class="title">Headquarters</div>
                                            <div class="text"><input type="text" value="{{$agent->headquarters}}"  name="headquarters"class="form-control" ></div>
                                        </li>
                                        <li>
                                            <div class="title">Website</div>
                                            <div class="text"><input type="text" value="{{$agent->websites}}"  name="websites" class="form-control"></div>
                                        </li>
                                        <li>
                                            <div class="title">Employees</div>
                                            <div class="text"><input type="text" value="{{$agent->no_of_employees}}"  name="no_of_employees"class="form-control" ></div>
                                        </li>
                                        <li>
                                            <div class="title"></div>
                                            <div class="text"><button class="btn btn-primary" type="submit">Update</button></div>
                                        </li>
                                    </ul>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="address" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <form action="{{ route('admin.agent.address.update', ['id'=>$agent->id]) }}" method="POST" enctype="multipart/form-data">@csrf
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Street Address</div>
                                                <div class="text">
                                                    <input type="hidden" class="form-control" name="agent_id" value="{{$agent->agent_id}}">
                                                    <input type="text" class="form-control" name="address" value="{{$agent->address}}">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">City</div>
                                                <div class="text">
                                                    <input type="text" class="form-control" name="city" value="{{$agent->city}}">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">State</div>
                                                <div class="text"><input type="text" class="form-control" name="state" value="{{$agent->state}}"></div>
                                            </li>
                                            <li>
                                                <div class="title">Country</div>
                                                <div class="text"><input type="text" class="form-control" name="country" value="{{$agent->country}}"></div>
                                            </li>
                                            <li>
                                                <div class="title">Pincode</div>
                                                <div class="text"><input type="text" class="form-control" name="pincode" value="{{$agent->pincode}}"></div>
                                            </li>
                                            <li>
                                                <div class="title"></div>
                                                <div class="text"><button class="btn btn-primary" type="submit">Update</button></div>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="contact_details" class="pro-overview tab-pane fade show ">

                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <form action="{{ route('admin.agent.contact.update', ['id'=>$agent->id]) }}" method="POST" enctype="multipart/form-data">@csrf
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Phone Number</div>
                                                <div class="text">
                                                    <input type="hidden" class="form-control" name="agent_id" value="{{$agent->agent_id}}">
                                                    <input type="text" class="form-control" name="phone" value="{{$agent->phone}}">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Emergency Contact Number</div>
                                                <div class="text">
                                                    <input type="text" class="form-control" name="emergency_phone" value="{{$agent->emergency_phone}}">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Office Number</div>
                                                <div class="text"><input type="text" class="form-control" name="office_number" value="{{$agent->office_phone}}"></div>
                                            </li>
                                            <li>
                                                <div class="title"></div>
                                                <div class="text"><button class="btn btn-primary" type="submit">Update</button></div>
                                            </li>
                                        </ul>
                                    </form>
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
                                                {{-- <div class="col-auto float-end ms-auto mt-2 mx-2">
                                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_target"><i
                                                            class="fa fa-plus"></i> Add Target</a>
                                                </div> --}}
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped custom-table mb-0 datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Target</th>
                                                                    <th>Business</th>
                                                                    <th>Pre Eco.</th>
                                                                    <th>Economy</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($agentTarget as $target)
                                                                <tr>
                                                                    <td>{{ $target->target }}</td>
                                                                    <td>{{ $target->business }}</td>
                                                                    <td>{{ $target->pre_economy }}</td>
                                                                    <td>{{ $target->economy }}</td>
                                                                    <td><a class="dropdown-item"data-bs-toggle="modal" data-bs-target="#edit_target{{$target->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a></td>
                                                                </tr>
                                                                <div id="edit_target{{$target->id}}" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit Target</h5>
                                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{ route('admin.agent.target.update', ['id' => $target->id]) }}" method="POST" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">

                                                                            <div class="form-group">
                                                                                <input class="form-control" type="hidden" name="agent_id" value="{{$agent->id}}">
                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Target <span class="text-danger">*</span></label>
                                                                                                <input class="form-control" type="text" name="target" value="{{$target->target}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Business</label>
                                                                                                <input class="form-control" type="text" name="business" value="{{$target->business}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Pre Economy</label>
                                                                                                <input class="form-control" type="text" name="pre_economy"  value="{{$target->pre_economy}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Economy</label>
                                                                                                <input class="form-control" type="text" name="economy"  value="{{$target->economy}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="submit-section">
                                                                                        <button class="btn btn-primary" type="submit">Update</button>
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
                                                {{-- <div class="col-auto float-end ms-auto mt-2 mx-2">
                                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_product"><i
                                                            class="fa fa-plus"></i> Add Products types</a>
                                                </div> --}}
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
                                                                @foreach($agentProduct as $prod)
                                                                <tr>
                                                                    <td>{{ $prod->product_type }}</td>
                                                                    <td><a class="dropdown-item"data-bs-toggle="modal" data-bs-target="#edit_product{{$prod->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a></td>
                                                                </tr>
                                                                <div id="edit_product{{$prod->id}}" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit Product</h5>
                                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{ route('admin.agent.product.update', ['id' => $prod->id]) }}" method="POST" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <input class="form-control" type="hidden" name="agent_id" value="{{$agent->id}}">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Product Name <span class="text-danger">*</span></label>
                                                                                                <input class="form-control" type="text" name="product_type" value="{{$prod->product_type}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="submit-section">
                                                                                        <button class="btn btn-primary" type="submit">Update</button>
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
                                    @foreach($agentConversation as $conversation)
                                    <div class="container">
                                        <div class="conversation-date">{{$conversation->c_date}}</div>
                                        <div class="conversation-title">{{$conversation->title}}</div>
                                        <div class="conversation-description">
                                            {{$conversation->description}}
                                        </div>
                                        <div class="conversation-author">added by {{$conversation->from}}</div>
                                    </div>
                                    @endforeach
                                </div>
                                <div id="add_comments" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Comments</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.agent.conversation.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" type="hidden" name="from" value="{{$agent->id}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="text" name="title">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Description</label>
                                                                <input class="form-control" type="text" name="description">
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
                    {{-- <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Case History </h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Case History</li>
                                </ul>
                            </div>
                            <div class="col-auto float-end ms-auto">
                                <a href="#" class="btn add-btn" data-bs-toggle="modal"
                                    data-bs-target="#add_group"><i class="fa fa-plus"></i> Add Groups</a>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    {{-- <h3 class="card-title">Group 1
                                        <a href="#" class="edit-icon" data-bs-toggle="modal"
                                            data-bs-target="#edit_group1"><i class="fa fa-pencil"></i></a>
                                    </h3> --}}
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Company Name</div>
                                            <div class="text">Airlines</div>
                                        </li>
                                        <li>
                                            <div class="title">Street</div>
                                            <div class="text">12</div>
                                        </li>
                                        <li>
                                            <div class="title">City</div>
                                            <div class="text">Bathinda</div>
                                        </li>
                                        <li>
                                            <div class="title">Pincode</div>
                                            <div class="text">151001</div>
                                        </li>
                                        <li>
                                            <div class="title">Country</div>
                                            <div class="text">India</div>
                                        </li>
                                        <li class="col-md-12">
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
                                                        <a href="#" class="edit-icon" data-bs-toggle="modal"
                                                            data-bs-target="#edit_group1"><i class="fa fa-plus"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">Business Mode:</div>
                                            <div class="text">Ref. Excel File (Agency Type)</div>
                                        </li>
                                        <li>
                                            <div class="title">Focus Destinations</div>
                                            <div class="text">Chennai International Airport (MAA)<br>
                                                Chennai International Airport (MAA)<br>
                                                Chennai International Airport (MAA)<br>
                                                Chennai International Airport (MAA)<br>
                                                Chennai International Airport (MAA)<br>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">Key People</div>
                                            <div class="text">J.R.D. Tata, Founder | N. Chandrasekaran (Chairman) |
                                                Campbell
                                                Wilson (CEO & MD)</div>
                                        </li>
                                        <li>
                                            <div class="title">Parent Company</div>
                                            <div class="text">Air India Limited (Tata Group)</div>
                                        </li>
                                        <li>
                                            <div class="title">Headquarters</div>
                                            <div class="text">113, Airlines House, Gurudwara Rakabganj Road, New Delhi,
                                                Delhi
                                                110001, India</div>
                                        </li>
                                        <li>
                                            <div class="title">Website</div>
                                            <div class="text"><a href="http://www.airindia.com"
                                                    target="_blank">www.airindia.com</a></div>
                                        </li>
                                        <li>
                                            <div class="title">Employees</div>
                                            <div class="text">8,407 (2022)</div>
                                        </li>
                                    </ul>
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
                                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_agent"><i
                                            class="fa fa-plus"></i> Add transaction</a>
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
                                                @foreach($agentAccounts as $account)
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
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.transaction.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" type="hidden" name="agent_id" value="{{$agent->id}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Debit Amount <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="text" name="debit">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Credit Amount</label>
                                                                <input class="form-control" type="text" name="credit">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Type</label>
                                                                <input class="form-control" type="yext" name="tr_type">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Transaction Date</label>
                                                                <input class="form-control" type="date" name="tr_date">
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
                                                {{-- <div class="col-auto float-end ms-auto mt-2 mx-2">
                                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_prov"><i
                                                            class="fa fa-plus"></i> Add Prov. Data</a>
                                                </div> --}}
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped custom-table mb-0 datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Prov.</th>
                                                                    <th>Business</th>
                                                                    <th>Pre Eco.</th>
                                                                    <th>Economy</th>
                                                                    <th>Valid From To</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($agentProv as $prov)
                                                                <tr>
                                                                    <td>{{ $prov->prov }}</td>
                                                                    <td>{{ $prov->business }}</td>
                                                                    <td>{{ $prov->pre_economy }}</td>
                                                                    <td>{{ $prov->economy }}</td>
                                                                    <td>{{ $prov->valid_from_to }}</td>
                                                                    <td><a class="dropdown-item"data-bs-toggle="modal" data-bs-target="#edit_prov{{$prov->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a></td>
                                                                </tr>
                                                                <div id="edit_prov{{$prov->id}}" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit Prov. Data</h5>
                                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{ route('admin.agent.prov.update', ['id' => $prov->id]) }}" method="POST" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <input class="form-control" type="hidden" name="agent_id" value="{{$agent->id}}">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Prov. <span class="text-danger">*</span></label>
                                                                                                <input class="form-control" type="text" name="prov" value="{{$prov->prov}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Business</label>
                                                                                                <input class="form-control" type="text" name="business" value="{{$prov->business}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Pre Economy</label>
                                                                                                <input class="form-control" type="text" name="pre_economy" value="{{$prov->pre_economy}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Economy</label>
                                                                                                <input class="form-control" type="text" name="economy" value="{{$prov->economy}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Valid from-to</label>
                                                                                                <input class="form-control" type="date" name="valid_from_to" value="{{$prov->valid_from_to}}">
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
                                                                @endforeach
                                                                <!-- Repeat for other agents -->
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

                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            <div class="card profile-box flex-fill">
                                                {{-- <div class="col-auto float-end ms-auto mt-2 mx-2">
                                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_pli"><i
                                                            class="fa fa-plus"></i> Add PLI Data</a>
                                                </div> --}}
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped custom-table mb-0 datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>PLI</th>
                                                                    <th>Business</th>
                                                                    <th>Pre Eco.</th>
                                                                    <th>Economy</th>
                                                                    <th>Valid From To</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($agentPli as $pli)
                                                                <tr>
                                                                    <td>{{ $pli->pli }}</td>
                                                                    <td>{{ $pli->business }}</td>
                                                                    <td>{{ $pli->pre_economy }}</td>
                                                                    <td>{{ $pli->economy }}</td>
                                                                    <td>{{ $pli->valid_from_to }}</td>
                                                                    <td><a class="dropdown-item"data-bs-toggle="modal" data-bs-target="#edit_pli{{$pli->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a></td>
                                                                </tr>
                                                                <div id="edit_pli{{$pli->id}}" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit PLI Data</h5>
                                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{ route('admin.agent.pli.update', ['id' => $pli->id]) }}" method="POST" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <input class="form-control" type="hidden" name="agent_id" value="{{$agent->id}}">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">pli. <span class="text-danger">*</span></label>
                                                                                                <input class="form-control" type="text" name="pli" value="{{$pli->pli}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Business</label>
                                                                                                <input class="form-control" type="text" name="business" value="{{$pli->business}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Pre Economy</label>
                                                                                                <input class="form-control" type="text" name="pre_economy" value="{{$pli->pre_economy}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Economy</label>
                                                                                                <input class="form-control" type="text" name="economy" value="{{$pli->economy}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Valid from-to</label>
                                                                                                <input class="form-control" type="date" name="valid_from_to" value="{{$pli->valid_from_to}}">
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
                                                                @endforeach
                                                                <!-- Repeat for other agents -->
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
