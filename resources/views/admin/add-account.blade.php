@extends('admin/layouts/head-main')
@section('title', 'Add Account')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Accounts</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Accounts</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_accounts"><i class="fa fa-plus"></i> Add Accounts</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Agent Name</th>
                                <th>Account Number</th>
                                <th>IFSC Code</th>
                                <th>MISC Code</th>
                                <th>Booking Id</th>
                                <th>PNR</th>
                                <th>Ticket No </th>
                                <th>Status</th>
                                <!-- <th>Sub-account Name</th> -->
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $index => $account)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $account->agent->company_name }}</td>
                                <td>{{ $account->acc_no }}</td>
                                <td>{{ $account->ifsc_code }}</td>
                                <td>{{ $account->misc_code }}</td>
                                <td>{{ $account->booking_id }}</td>
                                <td>{{ $account->pnr }}</td>
                                <td>{{ $account->ticket_no }}</td>
                                <td>
                                    <!-- Toggle Switch -->
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $account->id }}" {{ $account->status ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <!-- <td>Hardware Expenses</td> -->
                                <td class="text-end">
                                    @if($account->payment_pool == 'pending' || $account->payment_pool == NULL)
                                        <div class="dropdown-action">
                                            <a href="#" class="btn btn-primary m-r-5" data-bs-toggle="modal" data-bs-target="#edit_account{{$account->id}}">Payment to Pool</a>
                                        </div>
                                    @elseif($account->payment_pool == 'declined')
                                     <span class="btn btn-danger btn-sm" style="text-transform:capitalize;">Payment {{$account->payment_pool}}</span>
                                     @elseif($account->payment_pool == 'recieved')
                                     <span class="btn btn-success btn-sm" style="text-transform:capitalize;">Payment {{$account->payment_pool}}</span>
                                    @endif
                                </td>
                            </tr>
                            <!-- Edit account Modal -->
    <div class="modal custom-modal fade" id="edit_account{{$account->id}}" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment to Pool</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.account.update', $account->id)}}" method="post">
                    @csrf
                    @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Payment Pool <span class="text-danger">*</span></label>
                                    <select name="payment_pool" id="payment_pool" class="select form-control">
                                        <option value="pending">Pending</option>
                                        <option value="recieved">Receieved</option>
                                        <option value="declined">Declined</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>Account No. <span class="text-danger">*</span></label>
                                    <input type="text" name="acc_no" class="form-control" placeholder="Account No" value="{{$account->acc_no}}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>IFS Code <span class="text-danger">*</span></label>
                                    <input type="text" name="ifsc_code" class="form-control" placeholder="IFSC Code" value="{{$account->ifsc_code}}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>MISC Code <span class="text-danger">*</span></label>
                                    <input type="text" name="misc_code" class="form-control" placeholder="MISC Code" value="{{$account->misc_code}}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Booking Id <span class="text-danger">*</span></label>
                                    <input type="text" name="booking_id" class="form-control" placeholder="Booking Id" value="{{$account->booking_id}}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PNR <span class="text-danger">*</span></label>
                                    <input type="text" name="pnr" class="form-control" placeholder="PNR" value="{{$account->pnr}}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ticket No. <span class="text-danger">*</span></label>
                                    <input type="text" name="ticket_no" class="form-control" placeholder="Ticket No" value="{{$account->ticket_no}}" required />
                                </div>
                            </div> -->
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit account Modal -->
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add account Modal -->
    <div class="modal custom-modal fade" id="add_accounts" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Accounts</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.account.store')}}" method="post">
                    @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Agent Name <span class="text-danger">*</span></label>
                                    <select name="agent_id" id="agent_id" class="form-control select2">
                                        <option value=""> Select Agent</option>
                                        @foreach ($agents as $agent)
                                            <option value="{{$agent->id}}">{{$agent->company_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Account No. <span class="text-danger">*</span></label>
                                    <input type="text" name="acc_no" class="form-control" placeholder="Account No" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>IFS Code <span class="text-danger">*</span></label>
                                    <input type="text" name="ifsc_code" class="form-control" placeholder="IFSC Code" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>MISC Code <span class="text-danger">*</span></label>
                                    <input type="text" name="misc_code" class="form-control" placeholder="MISC Code" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Booking Id <span class="text-danger">*</span></label>
                                    <input type="text" name="booking_id" class="form-control" placeholder="Booking Id" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PNR <span class="text-danger">*</span></label>
                                    <input type="text" name="pnr" class="form-control" placeholder="PNR" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ticket No. <span class="text-danger">*</span></label>
                                    <input type="text" name="ticket_no" class="form-control" placeholder="Ticket No" required />
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Add Initial Bal. <span class="text-danger">*</span></label>
                                    <input type="text" name="balance" class="form-control" placeholder="Initial Balance" required />
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add account Modal -->

    
</div>
<!-- /Page Wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-toggle').change(function() {
            var accountId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("admin.account.updateStatus") }}', // Change this to your actual route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: accountId,
                    status: status
                },
                success: function(response) {
                    //alert('Account status updated successfully!');
                    window.location.reload();
                },
                error: function(response) {
                    alert('Failed to update Account status.');
                }
            });
        });
    });
</script>

@endsection
