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
                <form action="{{route('admin.customer.account.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer Name <span class="text-danger">*</span></label>
                                <select name="customer_id" id="customer_id" class="form-control select2">
                                    <option value=""> Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bank Name <span class="text-danger">*</span></label>
                                <input type="text" name="bank_name" class="form-control" placeholder="Bank Name" required />
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
    <!-- /Page Content -->



</div>
<!-- /Page Wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-toggle').change(function() {
            var accountId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("admin.customer.account.updateStatus") }}', // Change this to your actual route
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
