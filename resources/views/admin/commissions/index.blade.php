@extends('admin/layouts/head-main')
@section('content')


    <title>Fare Conditions</title>


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Commission</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Commission</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">



                        <a href="{{ route('admin.commissions.create') }}" class="btn add-btn" ><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif



 <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Airline</th>
                <th>Commission Rate</th>

                <!-- <th>Actions</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach ($commissions as $commission)
                <tr>
                    <td>{{ $commission->id }}</td>
                    <td>{{ $commission->airline->airline_code }}</td>
                    <td>{{ $commission->commissions_rate }}</td>
                    <td class="text-end">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('admin.commissions.edit', $commission->id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                <!-- Add more actions if needed -->
                            </div>
                        </div>
                    </td>
 <!--<td>-->
 <!--                       <a href="{{ route('admin.commissions.edit', $commission->id) }}" class="btn btn-primary">Edit</a>-->
 <!--                       <form action="{{ route('admin.commissions.destroy', $commission->id) }}" method="POST" style="display: inline;">-->
 <!--                           @csrf-->
 <!--                           @method('DELETE')-->
 <!--                           <button type="submit" class="btn btn-danger">Delete</button>-->
 <!--                       </form>-->
 <!--                   </td>-->
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
    </div>
    </div>
    </div>
    </div>


    @endsection

