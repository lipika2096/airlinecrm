@extends('admin/layouts/head-main')
@section('content')
    <title>Designations</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .profile-widget .user-name {
                color: #333333;
                margin-top: 30px !important;
            }
            .submit-section{                margin-top:10px !important;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    @if (!request()->is('admin/deleted/agent'))

                    <div class="col">
                        <h3 class="page-title">Travel Agent List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                            <li class="breadcrumb-item active">Travel Agent List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn btn btn-info mt-3" data-bs-toggle="modal" data-bs-target="#add_agent"><i
                                class="fa fa-plus "></i> Add Travel Agent</a>
                    </div>
                    @else
                    <div class="col">
                        <h3 class="page-title">Travel Agent List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                            <li class="breadcrumb-item">Travel Agent List</li>
                            <li class="breadcrumb-item active">Deleted Travel Agent List</li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('admin.agents') }}" method="get">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Search"
                                    value="{{ request()->search ?? '' }}">
                            </div>

                            <div class="col-md-3">
                                <select class="form-control" name="search_type" id="search_type">
                                    <option value="" selected disabled>Select Search Type</option>
                                    <option value="agent_name" @if(request()->search_type == 'agent_name') selected @endif >Agent Name</option>
                                    <option value="pincode" @if(request()->search_type == 'pincode') selected @endif >Pincode</option>
                                    <option value="city" @if(request()->search_type == 'city') selected @endif >City</option>
                                    <option value="state" @if(request()->search_type == 'state') selected @endif >State</option>
                                    <option value="country" @if(request()->search_type == 'country') selected @endif >Country</option>
                                    <option value="agent_group" @if(request()->search_type == 'agent_group') selected @endif >Agent Group</option>
                                    <option value="company_registration_no" @if(request()->search_type == 'company_registration_no') selected @endif>Company Registration No</option>
                                    <option value="iata_number" @if(request()->search_type == 'iata_number') selected @endif>IATA Number</option>
                                    <option value="gds_number" @if(request()->search_type == 'gds_number') selected @endif>GDS Number</option>
                                    <option value="gds_type" @if(request()->search_type == 'gds_type') selected @endif>GDS Type</option>
                                    <option value="focus_destinations" @if(request()->search_type == 'focus_destinations') selected @endif> Focus Destinations</option>
                                    <option value="business_model" @if(request()->search_type == 'business_model') selected @endif>Business Model</option>
                                    <option value="website" @if(request()->search_type == 'website') selected @endif>Website</option>
                                    <option value="product_type" @if(request()->search_type == 'product_type') selected @endif>Product Type</option>
                                    <option value="fare_type" @if(request()->search_type == 'fare_type') selected @endif>Fare Type</option>
                                    <option value="account_code" @if(request()->search_type == 'account_code') selected @endif>Account Code</option>
                                </select>
                            </div>


                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">

                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Brand Name</th>
                                    <th>Group</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agents as $agent)
                                    <tr>
                                        <td>{{ $agent->company_name }}</td>
                                        <td>{{ $agent->owner_name }}</td>
                                        <td>{{ $agent->agency_name }}</td>
                                        {{-- <td>Taj Travels</td> --}}
                                        <td>
                                            <div class="action-icons">
                                                <a href="{{ route('admin.agent.view', ['id' => $agent->id]) }}"
                                                    class="action-icon" style="margin-right: 10px;">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if (!request()->is('admin/deleted/agent'))
                                                    <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#delete_agent{{$agent->id}}"><i class="fa fa-trash m-r-5"></i></a>
                                                @endif
                                                {{-- <form action="" method="POST" style="display:inline;">
                                                <a class="action-icon" href="" data-bs-toggle="modal"
                                                data-bs-target="#edit_agent{{ $agent->id }}"d
                                                    style="border:none;background:none;padding:0;color:inherit; margin-right: 10px;">
                                                    <i class="fa fa-pencil"></i></a>
                                            </form> --}}
                                                <!--<a class="activate-btn" onclick="toggleActivation(this)"-->
                                                <!--    style="margin-right: 10px;">-->
                                                <!--    <i class="fas fa-toggle-on"></i>-->
                                                <!--</a>-->
                                                <!--<a class="activate-btn" onclick="toggleActivation(this)">-->
                                                <!--    <i class="fas fa-toggle-off"></i>-->
                                                <!--</a>-->
                                            </div>


                                        </td>
                                    </tr>

                                    <!-- Delete Agent Modal -->
                                    <div id="delete_agent{{$agent->id}}" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Leave Type</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('admin.agent.delete',$agent->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <p>Are you sure you want to delete
                                                            <strong>{{$agent->company_name}}</strong>  Agent?
                                                        </p>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Delete Agent Modal -->
                                @endforeach
                                <!-- Repeat for other agents -->
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
                    <h5 class="modal-title">Add Travel Agent</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.agent.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-group">
                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Company Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="company_name" required>
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Group <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="agency_name" required>
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Brand Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="owner_name" required>
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Street</label>
                                    <input class="form-control" type="text" name="address">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                <label class="col-form-label">State</label>
                                <input class="form-control" type="text" name="state">
                            </div>

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">City</label>
                                    <input class="form-control" type="text" name="city">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Pincode</label>
                                    <input class="form-control" type="text" name="pincode">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Country</label>
                                    <input class="form-control" type="text" name="country">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Company Registration No.</label>
                                    <input class="form-control" type="text" name="company_registration_number">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">IATA Number</label>
                                    <input class="form-control" type="text" name="iata">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">GDS Type</label>
                                    <input class="form-control" type="text" name="gds_type">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">PCC/Office ID</label>
                                    <input class="form-control" type="text" name="pcc_office_id">
                                </div>
                            <!-- </div> -->
                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Account Code</label>
                                    <input class="form-control" type="text" name="account_code">
                                </div>
                            <!-- </div> -->



                            <div class="col-sm-8">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Focus Destinations</label>
                                    <div id="focus-destinations-container">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="focus_destinations[]"
                                                placeholder="Enter destination">
                                            <button class="btn btn-danger remove-destination"
                                                type="button">Remove</button>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="button" id="add-destination">Add More</button>
                                </div>
                            <!-- </div> -->
                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Discount</label>
                                    <input class="form-control" type="text" name="discount">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Remarks</label>
                                    <input class="form-control" type="text" name="remarks">
                                </div>
                            <!-- </div> -->
                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Business Mode</label>
                                    <input class="form-control" type="text" name="business_mode">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Key People</label>
                                    <input class="form-control" type="text" name="key_people">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Parent Company</label>
                                    <input class="form-control" type="text" name="parent_company">
                                </div>
                            <!-- </div> -->

                            <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Headquarters</label>
                                    <input class="form-control" type="text" name="headquarters">
                                </div>
                            <!-- </div> -->

                            <!-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">Website</label>
                                    <input class="form-control" type="url" name="websites">
                                </div> -->
                                <div class="col-sm-4">
                                <!-- <div class="form-group"> -->
                                    <label class="col-form-label">Number of Employees</label>
                                    <input class="form-control" type="number" name="no_of_employees">
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-form-label">Websites</label>
                                    <div id="website-address-container">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="websites[]"
                                                placeholder="Enter website address">
                                            <button class="btn btn-danger remove-website-address"
                                                type="button">Remove</button>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="button" id="add-website-address">Add More</button>
                                </div>
                            <!-- </div> -->
                        <!-- </div> -->
                        <div class="submit-section">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-destination').addEventListener('click', function() {
            const container = document.getElementById('focus-destinations-container');
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-2');
            newInputGroup.innerHTML = `
                <input type="text" class="form-control" name="focus_destinations[]" placeholder="Enter destination">
                <button class="btn btn-danger remove-destination" type="button">Remove</button>
            `;
            container.appendChild(newInputGroup);

            // Add event listener to the remove button
            newInputGroup.querySelector('.remove-destination').addEventListener('click', function() {
                container.removeChild(newInputGroup);
            });
        });

        document.getElementById('add-website-address').addEventListener('click', function() {
            const container = document.getElementById('website-address-container');
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-2');
            newInputGroup.innerHTML = `
                <input type="text" class="form-control" name="websites[]" placeholder="Enter Website address">
                <button class="btn btn-danger remove-website-address" type="button">Remove</button>
            `;
            container.appendChild(newInputGroup);

            // Add event listener to the remove button
            newInputGroup.querySelector('.remove-website-address').addEventListener('click', function() {
                container.removeChild(newInputGroup);
            });
        });
    </script>
@endsection
