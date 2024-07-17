@extends('admin/layouts/head-main')
@section('content')
@php
use Carbon\Carbon;
@endphp
<title>Employee Profile</title>
<!-- Page Wrapper -->
<div class="page-wrapper">
   <style>
      .profile-view .profile-img-wrap {
      height: 145px!important;
      width: 120px;
      position: absolute;
      }
      .profile-view .profile-img {
      width: 120px;
      height: 156px!important;
      }
      .personal-info li .title {
      text-wrap: nowrap!important;
      }

      .personal-info li .title {
    color: #333333;
    float: left;
    font-weight: 500;
    margin-right: 30px;
    width: 45%!important;
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
            </div>
         </div>
      </div>
      <!-- /Page Header -->
      <div class="card mb-0">
         <div class="card-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="profile-view">
                     <div class="profile-img-wrap">
                     @if ($agent)
                        <div class="profile-img">
                           <a href="#" ><img alt="" style="margin-top:20px;" src="{{  asset('staff/storage/avatars/'.$agent->avatar_directory.'/'. $agent->avatar_filename) }}"  class="avatar"></a>
                        </div>
                        @else
                        <a href="{{route('admin.admin-profile')}}" ><img class="avatar" src="{{asset('public/assets/img/user.jpg/')}}" alt=""></a>
                        @endif
                     </div>
                     <div class="profile-basic">
                        <div class="row">
                           <div class="col-md-5">
                              <div class="profile-info-left">
                                 @if ($agent)
                                 <h3 class="user-name m-t-0 mb-0">{{ $agent->first_name }} {{ $agent->last_name }}</h3>
                                 <small class="text-muted">Position: {{ $agent->position }}</small>
                                 <div class="staff-id">Employee ID : {{ $agent->unique_id }}</div>
                                 <div class="staff-id">Owner Name : {{ $client->client_custom_field_4 }}</div>
                                 @else
                                 <p>Agent not found.</p>
                                 @endif
                              </div>
                           </div>
                           <div class="col-md-7">
                              @if ($agent)
                              <ul class="personal-info">
                                 <li>
                                    <div class="title">Phone:</div>
                                    <div class="text"><a href="">{{ $agent->phone }}</a></div>
                                 </li>
                                 <li>
                                    <div class="title">Email:</div>
                                    <div class="text"><a href="">{{ $agent->email }}</a></div>
                                 </li>
                                 <li>
                                    <div class="title">Pincode:</div>
                                    <div class="text">{{ $client->client_billing_zip }}</div>
                                 </li>
                                 <li>
                                    <div class="title">Address:</div>
                                    <div class="text">{{ $client->client_billing_street }}</div>
                                 </li>
                                 <li>
                                    <div class="title">GST No.:</div>
                                    <div class="text">{{ $client->client_custom_field_2 }}</div>
                                 </li>
                                 <li>
                                    <div class="title">Pan Card.</div>
                                    <div class="text">{{ $client->client_custom_field_3 }}</div>
                                 </li>
                              </ul>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="pro-edit"><a data-bs-target="#profile_info{{ $agent->id }}" data-bs-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div id="profile_info{{$agent->id}}" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Agent</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.agent.edit', ['id' => $agent->id]) }}" method="POST" enctype="multipart/form-data">

                                @method('patch')
                                @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                                <input class="form-control"name="first_name"  value="{{$agent->first_name}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Last Name</label>
                                                <input class="form-control" name="last_name" value="{{$agent->last_name}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                                <input class="form-control" name="email"  value="{{$agent->email}}" type="email">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                                <input type="text" name="employee_id" value="{{$agent->unique_id}}" readonly class="form-control floating">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Phone </label>
                                                <input class="form-control" name="phone"  value="{{$agent->phone}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Designation <span class="text-danger">*</span></label>
                                                <select class="form-control"  name="designation">
                                                    <option>Select Designation</option>
                                                    @foreach($designation as $designation_data)
                                                        <option value="{{$designation_data->designation}}" @if ($agent->position == $designation_data->designation) selected @endif>{{$designation_data->designation}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Profile Image</label>
                                                <input type="file" class="form-control" name="avatar_filename">
                                            </div>
                                        </div> --}}

                                        <!-- Add image display -->
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profile Image:</label>
                                                @if ($agent->avatar_filename)
                                                    <img src="{{ asset('staff/storage/avatars/'.$agent->avatar_directory.'/'. $agent->avatar_filename) }}" style="height:100px;" class="img-fluid" alt="Agent Image">
                                                @else
                                                    <p>No image uploaded</p>
                                                @endif
                                            </div>
                                        </div> --}}

                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

      <div class="card tab-box">
         <div class="row user-tabs">
            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
               <ul class="nav nav-tabs nav-tabs-bottom">
                  <li class="nav-item"><a href="#groups" data-bs-toggle="tab" class="nav-link active">Groups</a></li>
                  <li class="nav-item"><a href="#wallets" data-bs-toggle="tab" class="nav-link">Wallets</a></li>
                  <li class="nav-item"><a href="#request" data-bs-toggle="tab" class="nav-link">Wallet Request</a></li>
                  <li class="nav-item"><a href="#airtickets" data-bs-toggle="tab" class="nav-link">Air Tickets </a></li>
                  <li class="nav-item"><a href="#comments" data-bs-toggle="tab" class="nav-link">Comments </a></li>
                  {{-- <li class="nav-item"><a href="#salesreports" data-bs-toggle="tab" class="nav-link">Sales Reports </a></li> --}}
               </ul>
            </div>
         </div>
      </div>
      <div class="tab-content">
         <!-- Profile Info Tab -->
         <div id="groups" class="pro-overview tab-pane fade show active">
            <div class="page-header">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="page-title">Groups</h3>
                     <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Groups</li>
                     </ul>
                  </div>
                  <div class="col-auto float-end ms-auto">
                     <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i class="fa fa-plus"></i> Add Groups</a>
                  </div>
               </div>
            </div>
            <div class="row">
               @foreach($group as $index => $data)
               <div class="col-md-6 d-flex">
                  <div class="card profile-box flex-fill">
                     <div class="card-body">
                        <h3 class="card-title">Group {{ $index + 1 }} <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#edit_group{{ $data->id }}"><i class="fa fa-pencil"></i></a></h3>
                        <ul class="personal-info">
                           <li>
                              <div class="title">Group Name</div>
                              <div class="text">{{ $data->name }}</div>
                           </li>
                           <li>
                              <div class="title">Airline Name</div>
                              <div class="text">{{ $data->airline->airline_code }}</div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div id="edit_group{{$data->id}}" class="modal custom-modal fade" role="dialog">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title">Edit Group</h5>
                           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <form id="edit_group_form{{$data->id}}" action="{{ route('admin.agentgroups.update', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('PUT')
                              <div class="form-group">
                                 <label>Select Airline <span class="text-danger">*</span></label>
                                 <select class="form-control" name="airline_id" id="edit_airline_id{{$data->id}}">
                                 @foreach($airlines as $airline_data)
                                 <option value="{{ $airline_data->id }}" {{ $airline_data->id == $data->airline_id ? 'selected' : '' }}>{{ $airline_data->airline_code }}</option>
                                 @endforeach
                                 </select>
                              </div>
                              <div class="form-group">
                                 <label>Group Name <span class="text-danger">*</span></label>
                                 <input class="form-control" name="name" id="edit_group_name{{$data->id}}" type="text" value="{{ $data->name }}" required>
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
            </div>
         </div>
         <div class="tab-pane fade" id="request">
            <div class="page-header">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="page-title">Wallet Request </h3>
                     <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Wallet Request</li>
                     </ul>
                  </div>
                  <!-- <div class="col-auto float-end ms-auto">
                     <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i
                             class="fa fa-plus"></i> Add Wallets</a>
                     </div> -->
               </div>
            </div>
            <div class="row">
               @foreach($walletRequests as $request)
               <div class="col-md-6 d-flex">
                  <div class="card profile-box flex-fill">
                     <div class="card-body">
                        <h3 class="card-title">Wallet Request #{{ $request->id }}  <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#delete_walletrequest{{ $request->id }}">
                           <i class="fa fa-trash"></i>
                           </a>
                        </h3>
                        <ul class="personal-info">
                           <li>
                              <div class="title">Payment Mode</div>
                              <div class="text">{{ $request->payment_mode }}</div>
                           </li>
                           <li>
                              <div class="title">Amount</div>
                              <div class="text">{{ $request->amount }}</div>
                           </li>
                           <li>
                              <div class="title">Bank Transaction ID</div>
                              <div class="text">{{ $request->bank_tran_id }}</div>
                           </li>
                           <!-- Add other fields as needed -->
                           <li>
                              <div class="title">Status</div>
                              <div class="text">{{ $request->status }}</div>
                           </li>
                           <li>
                              <div class="title">Created at</div>
                              <div class="text">{{ $request->created_at }}</div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div id="delete_walletrequest{{ $request->id }}" class="modal custom-modal fade" role="dialog">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title">Delete Wallet Request</h5>
                           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <p>Are you sure you want to delete this wallet request?</p>
                           <form action="{{ route('admin.wallet.requests.delete', ['id' => $request->id]) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">Delete</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
         <div class="tab-pane fade" id="wallets">
            <div class="page-header">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="page-title">Wallets</h3>
                     <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Wallets</li>
                     </ul>
                  </div>
                  <div class="col-auto float-end ms-auto">
                     <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_wallet">
                     <i class="fa fa-plus"></i> Add Wallets
                     </a>
                  </div>
               </div>
            </div>
            <div class="row">
               @foreach($wallets as $index => $wallet)
               <div class="col-md-4 mb-4">
                  <div class="card profile-box flex-fill">
                     <div class="card-body">
                        <h3 class="card-title">Wallet Details
                           <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#delete_wallet{{ $wallet->id }}">
                           <i class="fa fa-trash"></i>
                           </a>
                        </h3>
                        <ul class="personal-info">
                           <li>
                              <div class="title">Agent Name</div>
                              <div class="text">{{ $agent->first_name ?? '' }} {{ $agent->last_name ?? '' }}</div>
                           </li>
                           <li>
                              <div class="title">Wallet Payment</div>
                              <div class="text">{{ $wallet->wallet ?? '' }}</div>
                           </li>
                           <li>
                              <div class="title">Status</div>
                              <div class="text">{{ $wallet->status ?? '' }}</div>
                           </li>
                           <li>
                              <div class="title">Description</div>
                              <div class="text">{{ $wallet->description ?? '' }}</div>
                           </li>
                           <li>
                              <div class="title">Available Balance</div>
                              <div class="text">{{ $wallet->available_balance ?? '' }}</div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <!-- Modal for delete confirmation -->
               <div id="delete_wallet{{ $wallet->id }}" class="modal custom-modal fade" role="dialog">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title">Confirm Delete Wallet</h5>
                           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <p>Are you sure you want to delete this wallet entry?</p>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                           <form action="{{ route('admin.wallet.delete') }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <input type="hidden" name="wallet_id" value="{{ $wallet->id }}">
                              <button type="submit" class="btn btn-danger">Delete</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Close the row if it's the end of a group of three or the last item -->
               @if (($index + 1) % 3 == 0 || $loop->last)
            </div>
            <div class="row">
               @endif
               @endforeach
            </div>
         </div>

<div class="tab-pane fade" id="comments">
    <div class="page-header">
        <!-- Breadcrumb and page title -->
    </div>
    <div class="row">
        @foreach($tickets as $ticket)
        <div class="col-md-6 d-flex">
            <div class="card profile-box flex-fill">
                <div class="card-body">
                    <h3 class="card-title">Ticket ID: {{ $ticket->id }}</h3>
                    <ul class="personal-info">
                        <li>
                            <div class="title">Subject</div>
                            <div class="text">{{ $ticket->ticket_subject }}</div>
                        </li>
                        <li>
                            <div class="title">Date</div>
                            <div class="text">{{ $ticket->ticket_last_updated }}</div>
                        </li>
                        <li>
                            <div class="title">Priority</div>
                            <div class="text">{{ $ticket->ticket_priority }}</div>
                        </li>
                        <li>
                        <div class="title">Status</div>
                        <div class="text">
                            @php
                                switch($ticket->ticket_status) {
                                    case 1:
                                        echo 'Open';
                                        break;
                                    case 2:
                                        echo 'Closed';
                                        break;
                                    case 3:
                                        echo 'On Hold';
                                        break;
                                    case 4:
                                        echo 'Answered';
                                        break;
                                    default:
                                        echo 'Unknown';
                                }
                            @endphp
                        </div>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="tab-pane fade" id="airtickets">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Air Tickets</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Air Tickets</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <!-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i class="fa fa-plus"></i> Add Tickets</a> -->
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($airtickets as $ticket)
        <div class="col-md-4 d-flex">
            <div class="card profile-box flex-fill">
                <div class="card-body">
                    <h3 class="card-title">Ticket {{ $loop->iteration }} </h3>
                    <ul class="personal-info">
                        <li>
                            <div class="title">Ticket Number</div>
                            <div class="text">{{ $ticket->ticket_number }}</div>
                        </li>
                        <li>
                            <div class="title">EMD</div>
                            <div class="text">{{ $ticket->emd }}</div>
                        </li>
                        <li>
                            <div class="title">MCO</div>
                            <div class="text">{{ $ticket->mco }}</div>
                        </li>
                        <li>
                            <div class="title">Date Change</div>
                            <div class="text">{{ $ticket->date_change }}</div>
                        </li>
                        <li>
                            <div class="title">Refund</div>
                            <div class="text">{{ $ticket->refund }}</div>
                        </li>
                        <li>
                            <div class="title">Ticket Issued From</div>
                            <div class="text">{{ $ticket->ticket_issued_from }}</div>
                        </li>
                        <li>
                            <div class="title">Ticket Issued To</div>
                            <div class="text">{{ $ticket->ticket_issued_to }}</div>
                        </li>
                        <li>
                            <div class="title">Departure Date</div>
                            <div class="text">{{ $ticket->departure_date }}</div>
                        </li>
                        <li>
                            <div class="title">Return Date</div>
                            <div class="text">{{ $ticket->return_date }}</div>
                        </li>
                        <li>
                            <div class="title">Airline</div>
                            <div class="text">{{ $ticket->airline->airline_code }}</div>
                        </li>
                        <li>
                            <div class="title">Base Fare</div>
                            <div class="text">{{ $ticket->base_fare }}</div>
                        </li>
                        <li>
                            <div class="title">Taxes</div>
                            <div class="text">{{ $ticket->taxes }}</div>
                        </li>
                        <li>
                            <div class="title">Amount Paid to Airlines</div>
                            <div class="text">{{ $ticket->amount_paid_to_airlines }}</div>
                        </li>
                        <li>
                            <div class="title">Amount Charged from Pax</div>
                            <div class="text">{{ $ticket->amount_charged_from_pax }}</div>
                        </li>
                        <li>
                            <div class="title">Status</div>
                            <div class="text">{{ $ticket->status }}</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- <div class="tab-pane fade" id="salesreports">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Sales Reports</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sales Reports</li>
                            </ul>
                        </div>
                        <!-- <div class="col-auto float-end ms-auto">
                            <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i
                                    class="fa fa-plus"></i> Add Tickets</a>
                        </div> -->
                    </div>
                </div>
                <div class="row">
                    @foreach($group as $index => $data)
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Group {{ $index + 1 }}
                                 <!-- <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#edit_group{{ $data->id }}"><i
                                            class="fa fa-eye"></i></a> -->
                                          </h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Book Id</div>
                                        <div class="text">{{ $data->name }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Flight Number</div>
                                        <div class="text">{{ $data->name }}</div>
                                    </li>
                                    <li>
                                        <div class="title">P. No.</div>
                                        <div class="text">{{ $data->airline->airline_code }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Agent Name</div>
                                        <div class="text"><a href="">{{ $agent->first_name ?? '' }}
                                                {{ $agent->last_name ?? '' }}</a></div>
                                    </li>
                                    <li>
                                        <div class="title">Package</div>
                                        <div class="text"><a href="">{{ $agent->first_name ?? '' }}
                                                {{ $agent->last_name ?? '' }}</a></div>
                                    </li>
                                    <li>
                                        <div class="title">Seat</div>
                                        <div class="text"><a href="">{{ $agent->first_name ?? '' }}
                                                {{ $agent->last_name ?? '' }}</a></div>
                                    </li>
                                    <li>
                                        <div class="title">Selling Cost</div>
                                        <div class="text"><a href="">{{ $agent->first_name ?? '' }}
                                                {{ $agent->last_name ?? '' }}</a></div>
                                    </li>
                                    <li>
                                        <div class="title">Purchasing Cost</div>
                                        <div class="text"><a href="">{{ $agent->first_name ?? '' }}
                                                {{ $agent->last_name ?? '' }}</a></div>
                                    </li>
                                    <li>
                                        <div class="title">Departure</div>
                                        <div class="text"><a href="">{{ $agent->first_name ?? '' }}
                                                {{ $agent->last_name ?? '' }}</a></div>
                                    </li>
                                    <li>
                                        <div class="title">Destination</div>
                                        <div class="text"><a href="">{{ $agent->first_name ?? '' }}
                                                {{ $agent->last_name ?? '' }}</a></div>
                                    </li>
                                    <li>
                                        <div class="title">Date</div>
                                        <div class="text"><a href="">{{ $agent->first_name ?? '' }}
                                                {{ $agent->last_name ?? '' }}</a></div>
                                    </li>
                                    <li>
                                        <div class="title">Time</div>
                                        <div class="text"><a href="">{{ $agent->first_name ?? '' }}
                                                {{ $agent->last_name ?? '' }}</a></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Designation Modal -->
                    <!-- Edit Group Modal -->
                    <div id="edit_group{{$data->id}}" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Group</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit_group_form{{$data->id}}" action="" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Select Agent <span class="text-danger">*</span></label>
                                            <select class="form-control" name="agent_id"
                                                id="edit_agent_id{{$data->id}}">
                                                @foreach($agents as $agent_data)
                                                <option value="{{ $agent_data->id }}"
                                                    {{ $agent_data->id == $data->agent_id ? 'selected' : '' }}>
                                                    {{ $agent_data->first_name }} {{ $agent_data->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Airline <span class="text-danger">*</span></label>
                                            <select class="form-control" name="airline_id"
                                                id="edit_airline_id{{$data->id}}">
                                                @foreach($airlines as $airline_data)
                                                <option value="{{ $airline_data->id }}"
                                                    {{ $airline_data->id == $data->airline_id ? 'selected' : '' }}>
                                                    {{ $airline_data->airline_code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Group Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="name" id="edit_group_name{{$data->id}}"
                                                type="text" value="{{ $data->name }}" required>
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

                </div>
            </div>

</div> --}}
<div id="add_wallet" class="modal custom-modal fade" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add Payment Wallet</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form method="POST" action="{{ route('admin.store.wallet') }}">
               @csrf
               <div class="row">
                  <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Payment <span class="text-danger">*</span></label>
                        <input class="form-control" name="payment" type="number" step="any" required>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Date <span class="text-danger">*</span></label>
                        <input class="form-control" name="date" type="date" required>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <input class="form-control" name="description" type="text" required>
                     </div>
                  </div>
               </div>
               <div class="submit-section">
                  <button type="submit" class="btn btn-primary submit-btn">Submit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


<div id="add_group" class="modal custom-modal fade" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add Agent</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="{{ route('admin.agentgroups.store') }}" method="POST" enctype="multipart/form-data">
               @csrf

               <input type="hidden" name="agent_id" value="{{ $agent->id }}">
               <div class="form-group">
                  <label>Select Airline <span class="text-danger">*</span></label>
                  <select class="form-control" name="airline_id">
                     <option>Select Airline</option>
                     @foreach($airlines as $airline_data)
                     <option value="{{ $airline_data->id }}">{{ $airline_data->airline_name }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>Group Name<span class="text-danger">*</span></label>
                  <input class="form-control" name="name" type="text" required>
               </div>
               <div class="submit-section">
                  <button class="btn btn-primary" type="submit">Submit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<div id="add_commission_modal" class="modal custom-modal fade" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add Commission</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="add_commission_form" action="" method="POST">
               @csrf
               <!-- Agent ID (hidden input, assuming it's passed via route or session) -->
               <input type="hidden" name="agent_id" value="{{ $agent->id }}">
               <!-- Commission Rate -->
               <div class="form-group">
                  <label for="add_commission_rate">Commission Rate</label>
                  <input type="text" class="form-control" id="add_commission_rate" name="commission_rate" required>
               </div>
               <!-- Airline -->
               <div class="form-group">
                  <label for="add_airline_id">Airline</label>
                  <select class="form-control" id="add_airline_id" name="airline_id" required>
                     <option value="">Select Airline</option>
                     @foreach($airlines as $airline)
                     <option value="{{ $airline->id }}">{{ $airline->airline_name }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="submit-section">
                  <button class="btn btn-primary" type="submit">Add</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
