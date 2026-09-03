@extends('admin.layouts.head-main')

@section('content')
    <title>Delay Codes</title>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Delay Codes</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Delay Codes</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_delaycode"><i class="fa fa-plus"></i> Add Delay Code</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Flight Number</th>
                                    <th>Date</th>
                                    <th>Delay Code</th>
                                    <th>Delay Duration (Minutes)</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($delayCodes as $delayCode)
                                    <tr>
                                        <td>{{ $delayCode->flight_number }}</td>
                                        <td>{{ $delayCode->date }}</td>
                                        <td>
    @if($delayCode->category)
        {{ $delayCode->category->delay_code }}
    @else
        N/A
    @endif
</td>
                                        <td>{{ $delayCode->delay_duration }}</td>
                                        <td>{{ $delayCode->description }}</td>
                                        <td>
                                            <div class="action-icons">
                                                <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#edit_delaycode_{{ $delayCode->id }}" style="margin-right: 10px;">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.delaycodes.destroy', $delayCode->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-icon" style="border:none;background:none;padding:0;color:inherit;">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Delay Code Modal -->
    <div id="add_delaycode" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Delay Code</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.delaycodes.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Flight Number <span class="text-danger">*</span></label>
                                    <input class="form-control" name="flight_number" type="text" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon"><input class="form-control" type="date" name="date" required></div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
        <label for="category_id">Filter by Category:</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">All Categories</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">
                   ({{ $category->delay_code }}) {{ ($category->delay_type) }}
                </option>
            @endforeach
        </select>
    </div>
    </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Delay Duration (Minutes) <span class="text-danger">*</span></label>
                                    <input class="form-control" name="delay_duration" type="number" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description" rows="3" required></textarea>
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

    <!-- Edit Delay Code Modal -->
    @foreach($delayCodes as $delayCode)
        <div id="edit_delaycode_{{ $delayCode->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Delay Code</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.delaycodes.update', $delayCode->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Flight Number <span class="text-danger">*</span></label>
                                        <input class="form-control" name="flight_number" value="{{ $delayCode->flight_number }}" type="text" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon"><input class="form-control" type="date" name="date" value="{{ $delayCode->date }}" required></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                <div class="form-group">
        <label for="category_id">Filter by Category:</label>
        <select name="category_id" id="category_id" class="form-control" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->delay_code }} ({{ $category->delay_type }})</option>
                                        @endforeach
                                    </select>
    </div>
    </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Delay Duration (Minutes) <span class="text-danger">*</span></label>
                                        <input class="form-control" name="delay_duration" value="{{ $delayCode->delay_duration }}" type="number" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="description" rows="3" required>{{ $delayCode->description }}</textarea>
                                    </div>
                                </div>
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
@endsection
