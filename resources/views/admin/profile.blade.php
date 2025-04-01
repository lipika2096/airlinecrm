@extends('admin/layouts/head-main')
@section('content')

@php
    use Carbon\Carbon;
@endphp
    <title>Employee Profile</title>


     <!-- Page Wrapper -->
    <div class="page-wrapper">

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

            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped  ">
                                            <tbody>

                                                <tr class="alignedText">
                                                    <th>Company name</th>
                                                    <td colspan="5">{{ $customer->adminDetail->company_name ?? '-' }}
                                                    </td>
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
                                                                <div class="col-sm-6  focus-destination-item">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#"><img alt="" src="{{asset('public/assets/img/user.jpg')}}"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{session('admin_name')}}</h3>
                                                <small class="text-muted">{{session('role')}}</small>
                                                <div class="small doj text-muted">Date of Creation : {{Carbon::parse(Auth::guard('admin')->user()->created_at)->format('jS M Y')}}</div>
                                                <div class="staff-msg"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                {{-- <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a href="">9876543210</a></div>
                                                </li> --}}
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a href="">{{Auth::guard('admin')->user()->email}}</a></div>
                                                </li>
                                                {{-- <li>
                                                    <div class="title">Birthday:</div>
                                                    <div class="text">24th July</div>
                                                </li>
                                                <li>
                                                    <div class="title">Address:</div>
                                                    <div class="text">1861 Bayonne Ave, Manchester Township, NJ, 08759</div>
                                                </li>
                                                <li>
                                                    <div class="title">Gender:</div>
                                                    <div class="text">Male</div>
                                                </li>
                                                <li>
                                                    <div class="title">Reports to:</div>
                                                    <div class="text">
                                                       <div class="avatar-box">
                                                          <div class="avatar avatar-xs">
                                                             <img src="{{asset('public/assets/img/profiles/avatar-16.jpg')}}" alt="">
                                                          </div>
                                                       </div>
                                                       <a href="{{route('admin.admin-profile')}}">
                                                            Jeffery Lalor
                                                        </a>
                                                    </div>
                                                </li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="pro-edit"><a data-bs-target="#profile_info" data-bs-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- /Page Content -->

        <!-- Profile Modal -->
        <div id="profile_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Profile Information</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- <div class="profile-img-wrap edit-img">
                                        <img class="inline-block" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}" alt="user">
                                        <div class="fileupload btn">
                                            <span class="btn-text">edit</span>
                                            <input class="upload" type="file">
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" value="{{Auth::guard('admin')->user()->name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" value="{{Auth::guard('admin')->user()->email}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Profile Modal -->

        <!-- Personal Info Modal -->
        <div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Personal Information</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Passport No</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Passport Expiry Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tel</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nationality <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Religion</label>
                                        <div class="cal-icon">
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Marital status <span class="text-danger">*</span></label>
                                        <select class="select form-control">
                                            <option>-</option>
                                            <option>Single</option>
                                            <option>Married</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Employment of spouse</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. of children </label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Personal Info Modal -->

        <!-- Family Info Modal -->
        <div id="family_info_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Family Informations</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-scroll">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Family Member <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Relationship <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of birth <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Relationship <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of birth <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Family Info Modal -->

        <!-- Emergency Contact Modal -->
        <div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Personal Information</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Primary Contact</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone 2</label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Primary Contact</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone 2</label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Emergency Contact Modal -->

        <!-- Education Modal -->
        <div id="education_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Education Informations</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-scroll">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Oxford University" class="form-control floating">
                                                    <label class="focus-label">Institution</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Computer Science" class="form-control floating">
                                                    <label class="focus-label">Subject</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <div class="cal-icon">
                                                        <input type="text" value="01/06/2002" class="form-control floating datetimepicker">
                                                    </div>
                                                    <label class="focus-label">Starting Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <div class="cal-icon">
                                                        <input type="text" value="31/05/2006" class="form-control floating datetimepicker">
                                                    </div>
                                                    <label class="focus-label">Complete Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="BE Computer Science" class="form-control floating">
                                                    <label class="focus-label">Degree</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Grade A" class="form-control floating">
                                                    <label class="focus-label">Grade</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Oxford University" class="form-control floating">
                                                    <label class="focus-label">Institution</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Computer Science" class="form-control floating">
                                                    <label class="focus-label">Subject</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <div class="cal-icon">
                                                        <input type="text" value="01/06/2002" class="form-control floating datetimepicker">
                                                    </div>
                                                    <label class="focus-label">Starting Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <div class="cal-icon">
                                                        <input type="text" value="31/05/2006" class="form-control floating datetimepicker">
                                                    </div>
                                                    <label class="focus-label">Complete Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="BE Computer Science" class="form-control floating">
                                                    <label class="focus-label">Degree</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Grade A" class="form-control floating">
                                                    <label class="focus-label">Grade</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Education Modal -->

        <!-- Experience Modal -->
        <div id="experience_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Experience Informations</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-scroll">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="Digital Devlopment Inc">
                                                    <label class="focus-label">Company Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="United States">
                                                    <label class="focus-label">Location</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="Web Developer">
                                                    <label class="focus-label">Job Position</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <div class="cal-icon">
                                                        <input type="text" class="form-control floating datetimepicker" value="01/07/2007">
                                                    </div>
                                                    <label class="focus-label">Period From</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <div class="cal-icon">
                                                        <input type="text" class="form-control floating datetimepicker" value="08/06/2018">
                                                    </div>
                                                    <label class="focus-label">Period To</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="Digital Devlopment Inc">
                                                    <label class="focus-label">Company Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="United States">
                                                    <label class="focus-label">Location</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="Web Developer">
                                                    <label class="focus-label">Job Position</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <div class="cal-icon">
                                                        <input type="text" class="form-control floating datetimepicker" value="01/07/2007">
                                                    </div>
                                                    <label class="focus-label">Period From</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <div class="cal-icon">
                                                        <input type="text" class="form-control floating datetimepicker" value="08/06/2018">
                                                    </div>
                                                    <label class="focus-label">Period To</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Experience Modal -->

    </div>
    <!-- /Page Wrapper -->






@endsection
