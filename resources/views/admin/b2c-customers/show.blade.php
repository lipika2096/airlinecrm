@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <title>Customer Profile</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            }
            .card-body {
                padding: 24px;
            }
            .nav-tabs .nav-link {
                border: none;
                color: #6c757d;
                font-weight: 500;
                padding: 12px 20px;
                transition: all 0.3s ease;
            }
            .nav-tabs .nav-link.active {
                background-color: #ff9b44;
                color: white;
                border-radius: 8px 8px 0 0;
            }
            .nav-tabs .nav-link:hover:not(.active) {
                color: #ff9b44;
            }
            .btn-primary {
                background-color: #ff9b44;
                border-color: #ff9b44;
                border-radius: 8px;
                padding: 12px 24px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background-color: #e88a3a;
                border-color: #e88a3a;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(255, 155, 68, 0.3);
            }
            .btn-sm {
                padding: 8px 16px;
                font-size: 13px;
            }
            .action-icons {
                display: flex;
                gap: 8px;
                justify-content: center;
            }
            .action-icon {
                width: 32px;
                height: 32px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #6c757d;
                transition: all 0.3s ease;
                background-color: #f8f9fa;
            }
            .action-icon:hover {
                color: #ff9b44;
                background-color: #fff3e6;
                transform: translateY(-2px);
            }
            .table-responsive {
                border-radius: 8px;
                overflow: hidden;
            }
            .custom-table {
                margin-bottom: 0;
            }
            .custom-table thead th {
                background-color: #f8f9fa;
                color: #495057;
                font-weight: 600;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 12px;
                border-bottom: 2px solid #e9ecef;
            }
            .custom-table tbody td {
                padding: 12px;
                vertical-align: middle;
                font-size: 14px;
                color: #495057;
                border-bottom: 1px solid #e9ecef;
            }
            .custom-table tbody tr:hover {
                background-color: #f8f9fa;
            }
            .badge {
                padding: 6px 10px;
                border-radius: 6px;
                font-size: 11px;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .page-title {
                font-weight: 600;
                color: #1a1a2e;
                font-size: 24px;
                margin-bottom: 8px;
            }
            .breadcrumb-item a {
                color: #6c757d;
                transition: color 0.2s ease;
            }
            .breadcrumb-item a:hover {
                color: #ff9b44;
            }
            .breadcrumb-item.active {
                color: #ff9b44;
                font-weight: 500;
            }
            .customer-info {
                background-color: #f8f9fa;
                border-radius: 8px;
                padding: 20px;
            }
            .customer-info h4 {
                color: #1a1a2e;
                font-weight: 600;
                margin-bottom: 15px;
            }
            .customer-info p {
                margin-bottom: 8px;
                color: #495057;
            }
            .customer-info strong {
                color: #1a1a2e;
                font-weight: 500;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Customer Profile</h3>
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.dashboard') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : route('staff.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.index') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.index') : route('staff.b2c-customers.index')) }}">B2C Customers</a></li>
                            <li class="breadcrumb-item active">{{ $customer->full_name }}</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.edit', $customer->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.edit', $customer->id) : route('staff.b2c-customers.edit', $customer->id)) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit me-2"></i> Edit Customer
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <!-- Customer Info Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="customer-info">
                                <h4>{{ $customer->full_name }}</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <p><strong>Status:</strong> 
                                            <span class="badge bg-{{ $customer->status == 'active' ? 'success' : ($customer->status == 'inactive' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($customer->status) }}
                                            </span>
                                        </p>
                                        <p><strong>Customer Type:</strong> {{ ucfirst($customer->customer_type) }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><strong>Phone:</strong> {{ $customer->phone }}</p>
                                        <p><strong>Email:</strong> {{ $customer->email }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><strong>Address:</strong> {{ $customer->address ?? '-' }}</p>
                                        <p><strong>Country:</strong> {{ $customer->country ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><strong>Preferred Airline:</strong> {{ $customer->preferred_airline ?? '-' }}</p>
                                        <p><strong>Preferred Class:</strong> {{ $customer->preferred_class ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Card -->
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-4" id="customerTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="passengers-tab" data-bs-toggle="tab" data-bs-target="#passengers" type="button" role="tab">Passengers</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="bookings-tab" data-bs-toggle="tab" data-bs-target="#bookings" type="button" role="tab">Bookings</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">Notes</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">History</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="customerTabsContent">
                                <!-- Passengers Tab -->
                                <div class="tab-pane fade show active" id="passengers" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Passengers</h5>
                                        <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.passengers.create', $customer->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.passengers.create', $customer->id) : route('staff.b2c-customers.passengers.create', $customer->id)) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus me-2"></i> Add Passenger
                                        </a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover custom-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>DOB</th>
                                                    <th>Passport</th>
                                                    <th>Nationality</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($customer->passengers as $passenger)
                                                    <tr>
                                                        <td>{{ $passenger->full_name }}</td>
                                                        <td><span class="badge bg-light text-dark">{{ ucfirst($passenger->passenger_type) }}</span></td>
                                                        <td>{{ $passenger->date_of_birth ? $passenger->date_of_birth->format('d/m/Y') : '-' }}</td>
                                                        <td>{{ $passenger->passport_number ?? '-' }}</td>
                                                        <td>{{ $passenger->nationality ?? '-' }}</td>
                                                        <td>
                                                            <div class="action-icons">
                                                                <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.passengers.edit', [$customer->id, $passenger->id]) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.passengers.edit', [$customer->id, $passenger->id]) : route('staff.b2c-customers.passengers.edit', [$customer->id, $passenger->id])) }}" class="action-icon" title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#delete_passenger{{ $passenger->id }}" title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="fa fa-users fa-2x mb-2"></i>
                                                                <p>No passengers added yet</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Bookings Tab -->
                                <div class="tab-pane fade" id="bookings" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Bookings</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover custom-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Booking No</th>
                                                    <th>Date</th>
                                                    <th>Total Cost</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($customer->bookings as $booking)
                                                    <tr>
                                                        <td>{{ $booking->booking_no }}</td>
                                                        <td>{{ $booking->booking_date ? $booking->booking_date->format('d/m/Y') : '-' }}</td>
                                                        <td>${{ number_format($booking->total_cost, 2) }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'danger') }}">
                                                                {{ ucfirst($booking->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="action-icons">
                                                                <a href="#" class="action-icon" title="View">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="fa fa-plane fa-2x mb-2"></i>
                                                                <p>No bookings found</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Notes Tab -->
                                <div class="tab-pane fade" id="notes" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Notes</h5>
                                    </div>
                                    
                                    <!-- Add Note Form -->
                                    <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2c-customers.notes.store', $customer->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2c-customers.notes.store', $customer->id) : route('staff.b2c-customers.notes.store', $customer->id)) }}" method="POST" class="mb-4">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-10">
                                                <textarea class="form-control" name="note" rows="2" placeholder="Add a note..." required></textarea>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary w-100">Add Note</button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Notes List -->
                                    <div class="notes-list">
                                        @forelse ($customer->notes as $note)
                                            <div class="card mb-2">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <p class="mb-1">{{ $note->note }}</p>
                                                            <small class="text-muted">
                                                                <i class="fa fa-user me-1"></i> {{ $note->createdBy->name ?? 'System' }}
                                                                <i class="fa fa-clock ms-2 me-1"></i> {{ $note->created_at->format('d/m/Y H:i') }}
                                                            </small>
                                                        </div>
                                                        <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#delete_note{{ $note->id }}" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fa fa-sticky-note fa-2x mb-2"></i>
                                                    <p>No notes added yet</p>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- History Tab -->
                                <div class="tab-pane fade" id="history" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Activity History</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover custom-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                    <th>User</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>Customer created</td>
                                                    <td>{{ $customer->createdBy->name ?? 'System' }}</td>
                                                </tr>
                                                @if ($customer->updated_at != $customer->created_at)
                                                    <tr>
                                                        <td>{{ $customer->updated_at->format('d/m/Y H:i') }}</td>
                                                        <td>Customer updated</td>
                                                        <td>{{ $customer->updatedBy->name ?? 'System' }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Passenger Modals -->
    @foreach ($customer->passengers as $passenger)
        <div class="modal fade" id="delete_passenger{{ $passenger->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Passenger</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="fa fa-exclamation-circle text-warning fa-3x"></i>
                            </div>
                            <p class="mb-0">Are you sure you want to delete <strong>{{ $passenger->full_name }}</strong>?</p>
                            <p class="text-muted small mb-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin()? route('admin.b2c-customers.passengers.delete', [$customer->id, $passenger->id]):route('staff.b2c-customers.passengers.delete', [$customer->id, $passenger->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Delete Note Modals -->
    @foreach ($customer->notes as $note)
        <div class="modal fade" id="delete_note{{ $note->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="fa fa-exclamation-circle text-warning fa-3x"></i>
                            </div>
                            <p class="mb-0">Are you sure you want to delete this note?</p>
                            <p class="text-muted small mb-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin()? route('admin.b2c-customers.notes.delete', [$customer->id, $note->id]):route('staff.b2c-customers.notes.delete', [$customer->id, $note->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection