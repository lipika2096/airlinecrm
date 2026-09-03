@extends('admin/layouts/head-main')
@section('content')


    <div class="main-wrapper">
        @include ('admin/layouts/menu')
        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Group Request</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Group Request</li>
                            </ul>
                        </div>
                        {{-- <div class="col-auto float-end ms-auto">
                            <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_Inventory"><i
                                    class="fa fa-plus"></i> Add Inventory</a>
                        </div> --}}
                    </div>
                </div>
                <form method="GET" action="{{ route('admin.requests.search') }}" class="form-inline search-bar">
                    <div class="search-wrapper">
                        <i class="fa fa-search"></i>
                        <input class="form-control mr-sm-2" type="text" placeholder="Request Id / PNR" aria-label="Search" name="query">
                    </div>
                    {{-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> --}}
                </form>

                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Request Id</th>
                                <th>Raised Date</th>
                                <th>Trip Type</th>
                                <th>Departure</th>
                                <th>Arrival</th>
                                <th>Flight Number</th>
                                <th>Travel Date</th>
                                <th>Class Type</th>
                                <th>Pax Count</th>
                                <th>Request Status</th>
                                <th>Actions</th> <!-- New Actions Column -->
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($groupRequest) && $groupRequest->count() > 0)
                                @foreach ($groupRequest as $data)
                                    <tr>
                                        <td>{{ $data->request_id }}</td>
                                        <td>{{ $data->raised_date }}</td>
                                        <td>{{ $data->trip_type }}</td>
                                        <td>{{ $data->departure }}</td>
                                        <td>{{ $data->arrival }}</td>
                                        <td>{{ $data->flight_number }}</td>
                                        <td>{{ $data->travel_date }}</td>
                                        <td>{{ $data->class_type }}</td>
                                        <td>{{ $data->pax_count }}</td>
                                        <td>{{ $data->request_status }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                    <!-- Add more actions here if needed -->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11">No Data found</td> <!-- Adjust colspan as needed -->
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#search-input').on('keyup', function() {
                        var value = $(this).val().toLowerCase();
                        $('table tbody tr').filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                        });
                    });
                });
            </script>
            <!-- /Page Content -->

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- end main wrapper-->

    <style>
        .search-wrapper {
            position: relative;
            display: inline-block;
            margin-left: 50pc;
            margin-bottom: 12px;
        }

        .search-wrapper .form-control {
            padding-right: 2.5rem;
            /* Adjust the padding to fit the icon */
        }

        .search-wrapper .fa-search {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
    </style>


@endsection
