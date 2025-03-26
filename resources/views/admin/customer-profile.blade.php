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
            .card-header {
                border-bottom: none !important;
                background: none !important;
            }

            input[type=checkbox][disabled] {
                outline: 1px solid grey;
            }

            input[type=checkbox][disabled][ checked] {
                outline: 1px solid filter: invert(100%) hue-rotate(18deg) brightness(3);
            }

            .submit-section {
                margin-top: 10px;
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
                        <p class="d-inline text-dark font-weight-bolder"> <b
                                class="d-inline text-capitalize">{{ $customer->adminDetail->company_name ?? '-' }}</b> profile
                        </p>
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

                            <li class="nav-item"><a href="#case_history" data-bs-toggle="tab" class="nav-link">Case History
                            </a></li>

                            <li class="nav-item"><a href="#conversation" data-bs-toggle="tab" class="nav-link">Conversations
                            </a></li>
                        </ul>

                    </div>
                </div>
            </div>

            <div class="tab-content">
                <!-- Profile Info Tab -->

                <div id="general" class="pro-overview tab-pane fade show active" class="customizeData">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped  ">
                                            <tbody>

                                                <tr class="alignedText">
                                                    <th>Company name</th>
                                                    <td colspan="5">{{ $customer->adminDetail->company_name ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Brand name</th>
                                                    <td colspan="5">{{ $customer->name ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Group</th>
                                                    <td colspan="5">{{ $customer->adminDetail->group ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Street</th>
                                                    <td colspan="5">{{ $customer->adminDetail->address ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>City</th>
                                                    <td colspan="5">{{ $customer->adminDetail->city ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Pincode</th>
                                                    <td colspan="5">{{ $customer->adminDetail->pincode ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Country</th>
                                                    <td colspan="5">{{ $customer->adminDetail->country ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Company Reg. No.</th>
                                                    <td colspan="5">
                                                        {{ $customer->adminDetail->company_registration_no ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th class="text-red">Subscription Type</th>
                                                    <td colspan="5" class="text-red">
                                                        {{ $customer->adminDetail->subscription_type ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th class="text-red">Subscription Charge</th>
                                                    <td colspan="5" class="text-red">
                                                        {{ $customer->adminDetail->subscription_charge ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th class="text-red">Subscription Expiring</th>
                                                    <td colspan="5" class="text-red">
                                                        {{ $customer->adminDetail->subscription_expiring ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th class="text-red">Remarks</th>
                                                    <td colspan="5" class="text-red">
                                                        {{ $customer->adminDetail->remarks ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th class="text-red">Business Model:</th>
                                                    <td colspan="5" class="text-red">
                                                        {{ $customer->adminDetail->business_mode ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Focused Destinations</th>
                                                    <td colspan="5">
                                                        <ul>
                                                            @if (!empty($customer->adminDetail?->business_focus))
                                                                @foreach (json_decode($customer->adminDetail->business_focus, true) ?? [] as $destination)
                                                                    <li style="list-style:disc !important;">
                                                                        {{ $destination ?? '-' }}
                                                                    </li>
                                                                @endforeach
                                                            @endif

                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Key People</th>
                                                    <td colspan="5">{{ $customer->adminDetail->key_people ?? '-' }}</td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Parent Company</th>
                                                    <td colspan="5">{{ $customer->adminDetail->parent_company ?? '-' }}
                                                    </td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Headquarters</th>
                                                    <td colspan="5">{{ $customer->adminDetail->headquarters ?? '-' }}
                                                    </td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Website</th>
                                                    <td colspan="5">

                                                        <ul>

                                                            @if (!empty($customer->adminDetail?->websites))
                                                                @foreach (json_decode($customer->adminDetail->websites, true) ?? [] as $awebsites)
                                                                    <li style="list-style:disc !important;">
                                                                        {{ $websites ?? '-' }}
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr class="alignedText">
                                                    <th>Employees</th>
                                                    <td colspan="5">{{ $customer->adminDetail->no_employees ?? '-' }}
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <!-- Edit Icon -->
                                <i class="fas fa-edit position-absolute top-0 end-0 m-3" data-bs-toggle="modal"
                                    data-bs-target="#edit_general{{ $customer->id }}"></i>

                                <div id="edit_general{{ $customer->id }}" class="modal custom-modal fade" role="dialog">
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
                                                    action="{{ route('admin.customer.update', ['id' => $customer->id]) }}#general"
                                                    method="POST" enctype="multipart/form-data">@csrf
                                                    @method('PATCH')
                                                    <div class= "row form-group">
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Company Name</lable>
                                                            <input type="text" class="form-control"
                                                                name="company_name"
                                                                value="{{ $customer->adminDetail->company_name ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Brand Name</lable>
                                                            <input type="text" class="form-control" name="full_name"
                                                                value="{{ $customer->name ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Group</lable>
                                                            <input type="text" class="form-control" name="group"
                                                                value="{{ $customer->adminDetail->group ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Street</lable>
                                                            <input type="text" class="form-control" name="address"
                                                                value="{{ $customer->adminDetail->address ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">State</lable>
                                                            <input type="text" class="form-control" name="state"
                                                                value="{{ $customer->adminDetail->state ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">City</lable>
                                                            <input type="text" class="form-control" name="city"
                                                                value="{{ $customer->adminDetail->city ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Pincode</lable>
                                                            <input type="text" class="form-control" name="pincode"
                                                                value="{{ $customer->adminDetail->pincode ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Country</lable>
                                                            <input type="text" class="form-control" name="country"
                                                                value="{{ $customer->adminDetail->country ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label class="col-form-label">Company Registration No.</label>
                                                            <input class="form-control" type="text"
                                                                name="company_registration_no"
                                                                value="{{ $customer->adminDetail->company_registration_no ?? '' }}">
                                                        </div>
                                                        </li>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">No of Modules</lable>
                                                            <input type="text" class="form-control"
                                                                name="subscription_type"
                                                                value="{{ $customer->adminDetail->no_modules ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Subscription Type</lable>
                                                            <input type="text" class="form-control"
                                                                name="subscription_type"
                                                                value="{{ $customer->adminDetail->subscription_type ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Subscription Charge</lable>
                                                            <input type="text" class="form-control"
                                                                name="subscription_type"
                                                                value="{{ $customer->adminDetail->subscription_charge ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Subscription Expiring</lable>
                                                            <input type="text" class="form-control"
                                                                name="subscription_type"
                                                                value="{{ $customer->adminDetail->subscription_expiring ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Remarks</lable>
                                                            <input type="text" class="form-control" name="remarks"
                                                                value="{{ $customer->adminDetail->remarks ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Business Model</lable>
                                                            <input type="text" class="form-control"
                                                                name="business_mode"
                                                                value="{{ $customer->adminDetail->business_mode ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Parent Company</lable>
                                                            <input type="text" class="form-control"
                                                                name="parent_company"
                                                                value="{{ $customer->adminDetail->parent_company ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <lable class="form-lable">Focused Destinations</lable>
                                                        @if (!empty($customer->adminDetail?->business_focus))
                                                            @foreach (json_decode($customer->adminDetail->business_focus, true) ?? [] as $destination)
                                                                <div class="col-sm-4  focus-destination-item">
                                                                    <input type="text" class="form-control"
                                                                        name="focus_destinations[]"
                                                                        value="{{ $destination }}">
                                                                    <button class="btn btn-danger remove-destination"
                                                                        type="button">Remove</button>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        <div class="col-sm-4" id="focus-destinations-container">
                                                            <button class="btn btn-primary" type="button"
                                                                id="add-destination">Add More</button>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Key People</lable>
                                                            <input type="text" class="form-control" name="key_people"
                                                                value="{{ $customer->adminDetail->key_people ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Headquarters</lable>
                                                            <input type="text" class="form-control"
                                                                name="headquarters"
                                                                value="{{ $customer->adminDetail->headquarters ?? '' }}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <lable class="form-lable">Employees</lable>
                                                            <input type="text" class="form-control"
                                                                name="no_of_employees"
                                                                value="{{ $customer->adminDetail->no_employees ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <lable class="form-lable">Website</lable>

                                                        @if (!empty($customer->adminDetail?->websites))
                                                            @foreach (json_decode($customer->adminDetail->websites, true) ?? [] as $awebsites)
                                                                <div class="col-sm-4 website-address-item">
                                                                    <input type="text" class="form-control"
                                                                        name="websites[]" value="{{ $awebsites }}">
                                                                    <button class="btn btn-danger remove-website-address"
                                                                        type="button">Remove</button>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        <div class="col-sm-4" id="website-address-container">
                                                            <button class="btn btn-primary" type="button"
                                                                id="add-website-address">Add More</button>
                                                        </div>
                                                        <div class="submit-section"><button class="btn btn-primary"
                                                                type="submit">Update</button></div>
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

                <div id="address" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill"
                                style="background: none; border: none !important; box-shadow: none;">
                                <div class="card-header">
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_address"
                                            class="fa fa-plus"></i> Add Address</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped datatable">
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
                                                <td>{{ $customer->adminDetail->address ?? '-' }}</td>
                                                <td>{{ $customer->adminDetail->city ?? '-' }}</td>
                                                <td>{{ $customer->adminDetail->state ?? '-' }}</td>
                                                <td>{{ $customer->adminDetail->country ?? '-' }}</td>
                                                <td>{{ $customer->adminDetail->pincode ?? '-' }}</td>
                                                <td><span class="badge badge-success p-2"> By default</span></td>

                                            </tr>
                                            @foreach ($customerAddress as $address)
                                                <tr>
                                                    <td>{{ $address->street }}</td>
                                                    <td>{{ $address->city }}</td>
                                                    <td>{{ $address->state }}</td>
                                                    <td>{{ $address->country }}</td>
                                                    <td>{{ $address->pincode }}</td>
                                                    <td>
                                                        <i class="fas fa-edit m-3" data-bs-toggle="modal"
                                                            data-bs-target="#edit_address{{ $address->id }}"></i>
                                                        <div id="edit_address{{ $address->id }}"
                                                            class="modal custom-modal fade" role="dialog">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header"
                                                                        style="margin-bottom:-25px;">
                                                                        <h5 class="modal-title">Edit Address</h5>
                                                                        <button type="button" class="close"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('admin.customer.address.update', ['id' => $address->id]) }}#address"
                                                                            method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <div class="row">

                                                                                <div class="form-group">
                                                                                    <input class="form-control"
                                                                                        type="hidden" name="agent_id"
                                                                                        value="{{ $customer->id }}">
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="col-form-label">Street
                                                                                            Address <span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input class="form-control"
                                                                                            value="{{ $address->street }}"type="text"
                                                                                            name="street">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="col-form-label">City</label>
                                                                                        <input class="form-control"
                                                                                            value="{{ $address->city }}"
                                                                                            type="text" name="city">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="col-form-label">State</label>
                                                                                        <input class="form-control"
                                                                                            value="{{ $address->state }}"
                                                                                            type="text" name="state">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="col-form-label">Country</label>
                                                                                        <input class="form-control"
                                                                                            value="{{ $address->country }}"
                                                                                            type="text" name="country">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="col-form-label">Pincode</label>
                                                                                        <input class="form-control"
                                                                                            type="text" required
                                                                                            value="{{ $address->pincode }}"
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
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_contact"
                                            class="fa fa-plus"></i> Add Contacts</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped datatable">
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
                                            @foreach ($customerContact as $index => $contact)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $contact->title }}</td>
                                                    <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                                    <td>{{ $contact->position }}</td>
                                                    <td>{{ $contact->email_address }}</td>
                                                    <td>{{ $contact->phone_number }}</td>
                                                    <td>
                                                        <input type="checkbox" disabled
                                                            {{ $contact->add_to_mail_list == 1 ? 'checked' : '' }}>
                                                    </td>

                                                    <td>{{ $contact->created_at }}</td>
                                                    <td>{{ $contact->createdBy->first_name ?? '-' }}
                                                        {{ $contact->createdBy->last_name ?? '' }}</td>
                                                    <td>{{ $contact->updated_at }}</td>
                                                    <td>{{ $contact->updatedBy->first_name ?? '-' }}
                                                        {{ $contact->updatedBy->last_name ?? '' }}</td><!-- Edit Icon -->
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
                                                                    action="{{ route('admin.customer.contact.update', ['id' => $contact->id]) }}#contact_details"
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
                                                                                    value="{{ $customer->id }}">
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
                                                                                <label class="col-form-label">Add to mail
                                                                                    List
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="hidden"
                                                                                    name="add_to_mail_list"
                                                                                    value="0">
                                                                                <input type="checkbox"
                                                                                    name="add_to_mail_list" value="1"
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

                <div id="conversation" class="pro-overview tab-pane fade show">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="col-auto float-end ms-auto mt-2 mx-2">
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_comments"
                                            class="fa fa-plus"></i> Add Comments</a>
                                </div>
                                <div class="card-body">
                                    @foreach ($customerConversation as $conversation)
                                        <div class="container">
                                            <div class="conversation-date">{{ $conversation->date_of_contact }}</div>
                                            <div class="conversation-title"><span
                                                    class="text-danger text-capitalize">Title:
                                                </span> {{ $conversation->title }}</div>
                                            <div class="conversation-description">
                                                {{ $conversation->description }}
                                            </div>
                                            <div class="conversation-author">added by {{ $conversation->from }} <br />
                                                {{ $conversation->c_date }}</div>
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
                                                <form action="{{ route('admin.customer.conversation.store') }}#conversation"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <input class="form-control" type="hidden" name="customer_id"
                                                        value="{{ $customer->adminDetail->admin_id }}">
                                                    <input class="form-control" type="hidden" name="from"
                                                        value="{{ auth('admin')->user()->name ?? '-' }}">
                                                    <div class="row">
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
                                                                <textarea class="form-control" required name="description"></textarea>
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
                                    <a class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_case"
                                            class="fa fa-plus"></i> Add Case History
                                        Data</a>
                                </div>

                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table datatable">
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
                                                        <td>{{ $data->airline->airline_name ?? '' }}</td>
                                                        <td>{{ $data->pnr }}</td>
                                                        <td>{{ $data->ticket_no }}</td>
                                                        <td>{{ $data->remarks }}</td>
                                                        <td>{{ $data->opened_by }}</td>
                                                        <td>{{ $data->case_opening_date }}</td>
                                                        <td>{{ $data->case_closed_by }}</td>
                                                        <td>
                                                            @if ($data->case_status != 'Updated')
                                                                {{ $data->case_closing_date }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <!-- View Button -->
                                                            <button class="btn btn-info text-light btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewCaseModal-{{ $data->id }}"><i
                                                                    class="fa fa-eye"></i></button>
                                                            <div class="modal fade"
                                                                id="viewCaseModal-{{ $data->id }}" tabindex="-1"
                                                                aria-labelledby="viewCaseModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="viewCaseModalLabel">View
                                                                                Case: {{ $data->case_id }}</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                            <div class="table-responsive">
                                                                                <table
                                                                                    class="table table-bordered datatable">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th scope="col">Date</th>
                                                                                            <th scope="col">PNR</th>
                                                                                            <td scope="col">
                                                                                                {{ $data->pnr }}</td>
                                                                                            <th scope="col">Ticket No.
                                                                                            </th>
                                                                                            <td scope="col">
                                                                                                {{ $data->ticket_no }}
                                                                                            </td>
                                                                                            <th scope="col">Case Status
                                                                                            </th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($data->updates as $update)
                                                                                            <tr>
                                                                                                <td scope="row">
                                                                                                    {{ $update->update_date }}
                                                                                                </td>
                                                                                                <td colspan="4">
                                                                                                    {{ $update->comments }}
                                                                                                </td>
                                                                                                <td>
                                                                                                    Case @if ($update->status == 'Update')
                                                                                                        Re-opened
                                                                                                    @else
                                                                                                        {{ $update->status }}
                                                                                                    @endif by
                                                                                                    {{ $update->updated_by }}
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
                                                                        action="{{ route('admin.customer.cases.update', ['id' => $data->id]) }}#case_history"
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
                                                                        action="{{ route('admin.customer.cases.close', ['id' => $data->id]) }}#case_history"
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
                                                    <form action="{{ route('admin.customer.case.store') }}#case_history"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Case Opening Date <span
                                                                            class="text-danger">*</span></label>
                                                                            <input class="form-control" type="hidden"
                                                                            name="customer_id" value="{{$customer->adminDetail->admin_id}}">
                                                                    <input class="form-control" type="date"
                                                                        name="case_opening_date" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Opened By <span
                                                                            class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text" required
                                                                        name="opened_by" readonly
                                                                        value="{{ auth('admin')->user()->name ?? '-' }}"
                                                                        required>
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
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Remarks <span
                                                                            class="text-danger">*</span></label>
                                                                    <textarea class="form-control" required name="remarks" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <input class="form-control" type="hidden"
                                                                        name="agent_id" value="{{ $customer->id }}">
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
                                <form action="{{ route('admin.customer.address.store') }}#address" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group">
                                            <input class="form-control" type="hidden" name="customer_id"
                                                value="{{ $customer->adminDetail->admin_id }}">
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
                                <form action="{{ route('admin.customer.contact.store') }}#contact_details" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group">
                                            <input class="form-control" type="hidden" name="customer_id"
                                                value="{{ $customer->adminDetail->admin_id }}">
                                            <input class="form-control" type="hidden" required name="updated_at"
                                                value=" ">
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
                                                <input class="form-control" type="text" required name="email_address">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Phone</label>
                                                <input class="form-control" type="text" required name="phone_number">
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
                                                    <span class="text-danger">*</span></label>
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
                document.addEventListener('click', function(event) {
                    if (event.target && event.target.classList.contains('remove-destination')) {
                        event.target.closest('.focus-destination-item').remove();
                    }
                });
                document.getElementById('add-destination').addEventListener('click', function() {
                    const container = document.getElementById('focus-destinations-container');
                    const newInputGroup = document.createElement('div');
                    newInputGroup.classList.add('input-group', 'mb-2');
                    newInputGroup.innerHTML = `
                        <input type="text" class="form-control" name="focus_destinations[]" placeholder="Enter destination">
                        <button class="btn btn-danger remove-destination" type="button">Remove</button>
                    `;
                    container.appendChild(newInputGroup);

                    newInputGroup.querySelector('.remove-destination').addEventListener('click', function() {
                        container.removeChild(newInputGroup);
                    });
                });

                document.addEventListener('click', function(event) {
                    if (event.target && event.target.classList.contains('remove-website-address')) {
                        event.target.closest('.website-address-item').remove();
                    }
                });
                document.getElementById('add-website-address').addEventListener('click', function() {
                    const container = document.getElementById('website-address-container');
                    const newInputGroup = document.createElement('div');
                    newInputGroup.classList.add('input-group', 'mb-2');
                    newInputGroup.innerHTML = `
                        <input type="text" class="form-control" name="websites[]" placeholder="Enter Website Address">
                        <button class="btn btn-danger remove-website-address" type="button">Remove</button>
                    `;
                    container.appendChild(newInputGroup);

                    newInputGroup.querySelector('.remove-website-address').addEventListener('click', function() {
                        container.removeChild(newInputGroup);
                    });
                });

                document.addEventListener('input', function(e) {
                    if (e.target.type === 'number') {
                        e.target.value = e.target.value.replace(/[^0-9]/g, '');
                    }
                });
                document.addEventListener("DOMContentLoaded", function() {
                    if (window.location.hash) {
                        const activeTab = window.location.hash;
                        const tabElement = document.querySelector(`a[href="${activeTab}"]`);
                        if (tabElement) {
                            tabElement.click();
                        }
                    }

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

            <style>
                .alignedText {
                    text-align: justify !important;
                }
            </style>
            <!-- Include jQuery & DataTables -->

<!-- Include jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<script>
    $(document).ready(function () {
        let table = $('#accountDataTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "searching" : false
        });

        // Ensure DataTable is reloaded when there are data changes
        if (!$.fn.DataTable.isDataTable("#accountDataTable")) {
            table.destroy();
            $('#accountDataTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "searching" : false
            });
        }
    });
</script>
        @endsection
