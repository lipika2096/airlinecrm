@extends('admin/layouts/head-main')
@section('content')

    <title>Designations</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
<style>

.profile-widget .user-name {
    color: #333333;
    margin-top: 30px!important;
}
</style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Agent List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Agent List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_agent"><i class="fa fa-plus"></i> Add Agent</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
            <div class="col-md-12">
                <div class="row staff-grid-row">

                 @foreach($agents as $agent)
                    <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                        <div class="profile-widget">
                            <div class="profile-img">
                            @if ($agent->avatar_filename)
                            <a href="#"><img alt="" class="avatar" style="margin-top:20px;" src="{{ asset('staff/storage/avatars/'.$agent->avatar_directory."/" . $agent->avatar_filename) }}"></a>
                        @else
                            <a href="#"><img alt="" style="margin-top:20px;" class="avatar" src="{{ asset('public/assets/img/user.jpg') }}"></a>
                        @endif


                            </div>
                            <div class="dropdown profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#edit_agent{{$agent->id}}"><i class="fa fa-pencil m-r-5"></i>
                                        Edit</a>
                                        <a class="dropdown-item" href="{{ route('admin.agent.view', ['id' => $agent->id]) }}"><i class="fa fa-eye m-r-5"></i> View</a>
                                    {{-- <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a> --}}
                                </div>
                            </div>
                            <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a
                                    href="{{ route('admin.agent.view', ['id' => $agent->id]) }}">{{$agent->first_name}}
                                    {{$agent->last_name}}</a></h4>
                            <div class="small text-muted">
                                <td>{{ $agent->client_company_name }}</td>
                            </div>
                        </div>
                    </div>



             <div id="edit_agent{{$agent->id}}" class="modal custom-modal fade" role="dialog">
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

                                        {{-- <!-- Add image display -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profile Image:</label>
                                                @if ($agent->avatar_filename)
                                                    <img src="{{ asset('storage/app/public/agent_images/' . $agent->avatar_filename) }}" style="height:100px;" class="img-fluid" alt="Agent Image">
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



                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Agent Modal -->
    <div id="add_agent" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Agent</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="{{ route('admin.agent.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">First Name <span class="text-danger">*</span></label>
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
                                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                                <input class="form-control" type="email" name="email">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Password</label>
                                                <input class="form-control" type="password" name="password">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="employee_id">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Phone </label>
                                                <input class="form-control" name="phone" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Emergency No </label>
                                                <input class="form-control" name="client_phone" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Address </label>
                                                <input class="form-control" name="client_billing_street" type="text">
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">City </label>
                                                <input class="form-control" name="client_billing_city" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">State </label>
                                                <input class="form-control" name="client_billing_state" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Country </label>
                                                <input class="form-control" name="client_billing_country" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Pincode </label>
                                                <input class="form-control" name="client_billing_zip" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Owner Name </label>
                                                <input class="form-control" name="client_custom_field_4" type="text">
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">GST No. </label>
                                                <input class="form-control" name="client_custom_field_2" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Pan Card. </label>
                                                <input class="form-control" name="client_custom_field_3" type="text">
                                            </div>
                                        </div>



                                        {{-- <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                                <div class="cal-icon"><input class="form-control" type="date" name="joining_date"></div>
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Designation <span class="text-danger">*</span></label>
                                                <select class="form-control"  name="designation">
                                                    <option>Select Designation</option>
                                                    @foreach($designation as $agent)
                                                        <option value="{{$agent->designation}}">{{$agent->designation}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label>Profile Image</label>
                                <input type="file" class="form-control" name="avatar_filename">
                            </div>
                        </div> --}}

                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Hold <span class="text-danger">*</span></label>
                                                <select class="form-control"  name="client_custom_field_1">
                                                    <option>Select</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Deactive">Deactive</option>
                                                </select>
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




@endsection
