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
                        <h3 class="page-title">Fare Conditions</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Fare Conditions</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">



                        <a href="{{ route('admin.fare_conditions.create') }}" class="btn add-btn" ><i class="fa fa-plus"></i> Add</a>
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
                    <td>Agent</td>
                    <th>Fare Condition Details</th>
                    <th>Cancellation Policy</th>
                    <th>Date Change Policy</th>
                    <th>Updated By</th>
                    <th>Effective From</th>
                    <th>Valid Till</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fareConditions as $fareCondition)
                    <tr>
                        <td>{{ $fareCondition->id }}</td>
                        <td>
                        @if ($fareCondition->agent)
                            {{ $fareCondition->agent->first_name }} {{ $fareCondition->agent->last_name }}
                        @else
                            N/A
                        @endif
                    </td>
                        <td>{{ $fareCondition->fare_condition_details }}</td>
                        <td>{{ $fareCondition->cancellation_policy }}</td>
                        <td>{{ $fareCondition->date_change_policy }}</td>
                        <td>{{ $fareCondition->updated_by }}</td>
                        <td>{{ $fareCondition->effective_from_date }}</td>
                        <td>{{ $fareCondition->valid_till_date }}</td>
                        <td class="text-end">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('admin.fare_conditions.edit', $fareCondition->id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                <!-- Add more actions if needed -->
                            </div>
                        </div>
                    </td>
                        <!--<td>-->
                        <!--    <a href="{{ route('admin.fare_conditions.edit', $fareCondition->id) }}" class="btn btn-sm btn-success">Edit</a>-->
                        <!--    <form action="{{ route('admin.fare_conditions.destroy', $fareCondition->id) }}" method="POST" style="display:inline-block;">-->
                        <!--        @csrf-->
                        <!--        @method('DELETE')-->
                        <!--        <button type="submit" class="btn btn-sm btn-danger">Delete</button>-->
                        <!--    </form>-->
                        <!--</td>-->
                    </tr>
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





@endsection


