@extends('admin/layouts/head-main')
@section('content')

<title>Wallets</title>

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
                    <h3 class="page-title">Wallet List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Wallet List</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_Wallet"><i class="fa fa-plus"></i> Add Wallet</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="row staff-grid-row">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Agent Name</th>
                                           <th>WALLET PAYMENT</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($agents as $agent)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $agent->first_name }} {{ $agent->last_name }}</td>
                                                <td>{{ $agent->total_wallet ?? 'N/A' }}</td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#view_Wallet{{ $agent->id }}"><i class="fa fa-eye m-r-5"></i> View</a>
                                                           <form action="{{ route('admin.wallet.destroy', $agent->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item"><i class="fa fa-trash m-r-5"></i> Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- View Wallet Modal -->
                                            <div id="view_Wallet{{ $agent->id }}" class="modal custom-modal fade" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">View Wallet</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                        <div class="row" style="display:flex">
                                                            <p><strong>Agent Name:</strong> {{ $agent->first_name }} {{ $agent->last_name }}</p>
                                                            <p><strong>Total Wallet:</strong> {{ $agent->total_wallet }}</p>

    </div>
                                                            <ul class="row" style="display:flex">
                                                                @foreach ($agent->wallets as $wallet)
                                                                    <li class="col-md-4 card">
                                                                        <p><strong>Wallet:</strong> {{ $wallet->wallet }}</p>
                                                                        <p><strong>Available Balance:</strong> {{ $wallet->available_balance }}</p>
                                                                        <p><strong>Razorpay ID:</strong> {{ $wallet->razorpay_id }}</p>
                                                                        <p><strong>Status:</strong> {{ $wallet->status }}</p>
                                                                        <p><strong>Parent ID:</strong> {{ $wallet->parent_id }}</p>
                                                                        <p><strong>Description:</strong> {{ $wallet->description }}</p>
                                                                        <p><strong>Date:</strong> {{ $wallet->date }}</p>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
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
            <!-- /Page Content -->
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Wallet Modal -->
    <div id="add_Wallet" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Wallet</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.wallet.store')}}" class="forms-sample" method="POST" enctype="multipart/form-data" autocomplete="on">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                            <div class="form-group">
                                    <label for="agent_id">Agent <span class="text-danger">*</span></label>
                                    <select name="agent_id" class="form-control" required>
                                        <option value="">Select Agent</option>
                                        @foreach ($eligibleAgents as $eligibleAgent)
                                            <option value="{{ $eligibleAgent->id }}">{{ $eligibleAgent->first_name }} {{ $eligibleAgent->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('agent_id'))
                                        <p class="text-danger">{{ $errors->first('agent_id') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="wallet">Wallet<span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="wallet" class="form-control" placeholder="Wallet" value="{{ old('wallet') }}">
                                    @if($errors->has('wallet'))
                                        <p class="text-danger">{{ $errors->first('wallet') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                                    @if($errors->has('description'))
                                        <p class="text-danger">{{ $errors->first('description') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ old('date') }}">
                                    @if($errors->has('date'))
                                        <p class="text-danger">{{ $errors->first('date') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mr-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
