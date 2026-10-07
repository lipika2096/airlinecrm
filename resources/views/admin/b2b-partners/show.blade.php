@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <title>View Partner Profile</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .profile-widget .user-name {
                color: #333333;
                margin-top: 30px !important;
            }

            .submit-section {
                margin-top: 10px !important;
            }
            .add-btn {
                background-color: #ff9b44;
                border: 1px solid #ff9b44;
                color: #ffffff;
                float: right;
                font-weight: 500;
                min-width: 140px;
                border-radius: 50px;
                font-size: 13px;
                transition: all 0.3s ease;
            }
            .add-btn:hover {
                background-color: #e88a3a;
                border-color: #e88a3a;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(255, 155, 68, 0.3);
            }

            /* Enhanced Card Styling */
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
            }
            .card:hover {
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            }
            .card-body {
                padding: 24px;
            }

            /* Enhanced Typography */
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

            /* Enhanced Tabs */
            .nav-tabs {
                border-bottom: 2px solid #e9ecef;
                margin-bottom: 24px;
            }
            .nav-tabs .nav-link {
                color: #6c757d;
                border: none;
                border-bottom: 3px solid transparent;
                border-radius: 0;
                padding: 12px 20px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .nav-tabs .nav-link:hover {
                color: #ff9b44;
                border-bottom-color: #ff9b44;
            }
            .nav-tabs .nav-link.active {
                background-color: transparent;
                color: #ff9b44;
                border-bottom: 3px solid #ff9b44;
            }

            /* Enhanced Stat Cards */
            .stat-card {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border-radius: 12px;
                padding: 24px;
                text-align: center;
                border: 1px solid #e9ecef;
                transition: all 0.3s ease;
            }
            .stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            }
            .stat-value {
                font-size: 28px;
                font-weight: 700;
                color: #ff9b44;
                margin-bottom: 8px;
            }
            .stat-label {
                color: #6c757d;
                font-size: 13px;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Enhanced Table Styling */
            .table-responsive {
                border-radius: 8px;
                overflow: hidden;
            }
            .table-bordered {
                border: 1px solid #e9ecef;
            }
            .table-bordered th,
            .table-bordered td {
                border: 1px solid #e9ecef;
            }
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: #f8f9fa;
            }
            .table thead th {
                background-color: #f8f9fa;
                color: #495057;
                font-weight: 600;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 16px;
                border-bottom: 2px solid #e9ecef;
            }
            .table tbody td {
                padding: 16px;
                vertical-align: middle;
                font-size: 14px;
                color: #495057;
                border-bottom: 1px solid #e9ecef;
            }
            .table tbody tr:hover {
                background-color: #f1f3f5;
            }

            /* Enhanced Badges */
            .badge {
                padding: 8px 12px;
                border-radius: 6px;
                font-size: 12px;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Enhanced Action Icons */
            .action-icon {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: #6c757d;
                transition: all 0.3s ease;
                background-color: #f8f9fa;
                margin-right: 8px;
            }
            .action-icon:hover {
                color: #ff9b44;
                background-color: #fff3e6;
                transform: translateY(-2px);
            }
            .action-icon.text-danger:hover {
                color: #dc3545;
                background-color: #fee;
            }

            /* Enhanced Modal */
            .modal-content {
                border-radius: 12px;
                border: none;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            }
            .modal-header {
                border-bottom: 1px solid #e9ecef;
                padding: 20px 24px;
            }
            .modal-body {
                padding: 24px;
            }
            .modal-footer {
                border-top: 1px solid #e9ecef;
                padding: 16px 24px;
            }

            /* Enhanced Form Styling */
            .form-group {
                margin-bottom: 20px;
            }
            .form-group label {
                font-weight: 500;
                color: #495057;
                margin-bottom: 8px;
                font-size: 14px;
            }
            .form-control {
                border-radius: 8px;
                border: 1px solid #e0e0e0;
                padding: 12px 16px;
                font-size: 14px;
                transition: all 0.3s ease;
            }
            .form-control:focus {
                border-color: #ff9b44;
                box-shadow: 0 0 0 3px rgba(255, 155, 68, 0.1);
            }

            /* Enhanced Buttons */
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
            .btn-secondary {
                background-color: #6c757d;
                border-color: #6c757d;
                border-radius: 8px;
                padding: 12px 24px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .btn-secondary:hover {
                background-color: #5a6268;
                border-color: #5a6268;
                transform: translateY(-2px);
            }

            /* Tab Content */
            .tab-content {
                padding: 8px 0;
            }
            .tab-pane h5 {
                color: #1a1a2e;
                font-weight: 600;
                margin-bottom: 20px;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">View Partner Profile</h3>
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.dashboard') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : route('staff.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners') : route('staff.b2b-partners')) }}">B2B Partners</a></li>
                            <li class="breadcrumb-item active">{{ $partner->partner_name }}</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.edit', $partner->id) : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners.edit', $partner->id) : route('staff.b2b-partners.edit', $partner->id)) }}" class="btn add-btn">
                            <i class="fa fa-edit me-2"></i> Edit Partner
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <!-- Partner Summary Card -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 class="mb-2">{{ $partner->partner_name }}</h4>
                                    <p class="text-muted mb-3">{{ $partner->partner_type }} | {{ $partner->country }}</p>
                                    <div class="mb-3">
                                        <span class="badge bg-{{ $partner->status == 'Active' ? 'success' : ($partner->status == 'Pending' ? 'warning' : 'danger') }}">
                                            {{ $partner->status }}
                                        </span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>IATA/TIDS:</strong> {{ $partner->iata_tids_no ?? '-' }}</p>
                                            <p class="mb-2"><strong>Email:</strong> {{ $partner->email }}</p>
                                            <p class="mb-2"><strong>Phone:</strong> {{ $partner->phone ?? '-' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Website:</strong> {{ $partner->website ?? '-' }}</p>
                                            <p class="mb-2"><strong>Responsible Person:</strong> {{ $partner->responsible_person ?? '-' }}</p>
                                            <p class="mb-2"><strong>Region:</strong> {{ $partner->region ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-3">Partner Summary</h5>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="stat-card">
                                                <div class="stat-value">{{ $partner->total_bookings }}</div>
                                                <div class="stat-label">Total Bookings</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="stat-card">
                                                <div class="stat-value">{{ $partner->total_passengers }}</div>
                                                <div class="stat-label">Total Passengers</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="stat-card">
                                                <div class="stat-value">{{ number_format($partner->revenue, 2) }}</div>
                                                <div class="stat-label">Revenue (INR)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs for different sections -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="partnerTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="bookings-tab" data-bs-toggle="tab" data-bs-target="#bookings" type="button" role="tab">Bookings</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab">Contact Persons</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="airlines-tab" data-bs-toggle="tab" data-bs-target="#airlines" type="button" role="tab">Airlines & Products</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">Documents & Notes</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">History</button>
                                </li>
                            </ul>

                            <div class="tab-content mt-4" id="partnerTabsContent">
                                <!-- Overview Tab -->
                                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                    <h5 class="mb-3">Partner Overview</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Partner Code</th>
                                                    <td>{{ $partner->partner_code }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Partner Type</th>
                                                    <td>{{ $partner->partner_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Country</th>
                                                    <td>{{ $partner->country }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>{{ $partner->status }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>TSA Status</th>
                                                    <td>{{ $partner->tsa_status ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Airline Responsibility</th>
                                                    <td>{{ $partner->airline_responsibility ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Product Responsibility</th>
                                                    <td>{{ $partner->product_responsibility ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Remarks</th>
                                                    <td>{{ $partner->remarks ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bookings Tab -->
                                <div class="tab-pane fade" id="bookings" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Partner Bookings</h5>
                                        <div class="d-flex gap-2">
                                            <input type="text" id="bookingSearch" class="form-control form-control-sm" placeholder="Search bookings..." style="width: 200px;">
                                            <select id="bookingStatusFilter" class="form-control form-control-sm" style="width: 150px;">
                                                <option value="">All Status</option>
                                                <option value="Confirmed">Confirmed</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Booking No</th>
                                                    <th>Date</th>
                                                    <th>Passenger</th>
                                                    <th>Airline</th>
                                                    <th>Status</th>
                                                    <th>Amount</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bookingsTableBody">
                                                @forelse ($bookings as $booking)
                                                    <tr>
                                                        <td>{{ $booking->booking_no }}</td>
                                                        <td>{{ $booking->booking_date ? $booking->booking_date->format('d M Y') : '-' }}</td>
                                                        <td>{{ $booking->customer_name ?? '-' }}</td>
                                                        <td>{{ $booking->b2b_company_name ?? '-' }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $booking->status == 'Confirmed' ? 'success' : ($booking->status == 'Pending' ? 'warning' : 'danger') }}">
                                                                {{ $booking->status }}
                                                            </span>
                                                        </td>
                                                        <td>₹{{ number_format($booking->total_sell, 2) }}</td>
                                                        <td>
                                                            <span class="text-muted">View</span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="fa fa-inbox fa-2x mb-2"></i>
                                                                <p>No bookings found</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($bookings->hasPages())
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $bookings->links() }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Contact Persons Tab -->
                                <div class="tab-pane fade" id="contacts" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Contact Persons</h5>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addContactModal">
                                            <i class="fa fa-plus"></i> Add Contact
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Designation</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($partner->contacts as $contact)
                                                    <tr>
                                                        <td>{{ $contact->name }}</td>
                                                        <td>{{ $contact->designation }}</td>
                                                        <td>{{ $contact->phone }}</td>
                                                        <td>{{ $contact->email }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $contact->role == 'Primary' ? 'primary' : 'secondary' }}">
                                                                {{ $contact->role }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="action-icon"><i class="fa fa-edit"></i></a>
                                                            <a href="#" class="action-icon text-danger" onclick="event.preventDefault(); document.getElementById('delete-contact-{{ $contact->id }}').submit();">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                            <form id="delete-contact-{{ $contact->id }}" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.contacts.destroy', $contact->id) : route('staff.b2b-partners.contacts.destroy', $contact->id) }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="fa fa-users fa-2x mb-2"></i>
                                                                <p>No contacts found</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Airlines & Products Tab -->
                                <div class="tab-pane fade" id="airlines" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Airlines Represented</h5>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Airline Name</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($partner->airlines as $airline)
                                                            <tr>
                                                                <td>{{ $airline->airline ? $airline->airline->airline_name : $airline->airline_name }}</td>
                                                                <td>
                                                                    <a href="#" class="action-icon text-danger" onclick="event.preventDefault(); if(confirm('Remove this airline?')) { document.getElementById('delete-airline-{{ $airline->id }}').submit(); }">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                    <form id="delete-airline-{{ $airline->id }}" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.airlines.destroy', $airline->id) : route('staff.b2b-partners.airlines.destroy', $airline->id) }}" method="POST" style="display: none;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="2" class="text-center py-4">
                                                                    <div class="text-muted">
                                                                        <i class="fa fa-plane fa-2x mb-2"></i>
                                                                        <p>No airlines linked</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Products / Services</h5>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Product Name</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($partner->products as $product)
                                                            <tr>
                                                                <td>{{ $product->product_name }}</td>
                                                                <td>
                                                                    <a href="#" class="action-icon text-danger" onclick="event.preventDefault(); if(confirm('Remove this product?')) { document.getElementById('delete-product-{{ $product->id }}').submit(); }">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                    <form id="delete-product-{{ $product->id }}" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.products.destroy', $product->id) : route('staff.b2b-partners.products.destroy', $product->id) }}" method="POST" style="display: none;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="2" class="text-center py-4">
                                                                    <div class="text-muted">
                                                                        <i class="fa fa-box fa-2x mb-2"></i>
                                                                        <p>No products linked</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documents & Notes Tab -->
                                <div class="tab-pane fade" id="documents" role="tabpanel">
                                    <ul class="nav nav-tabs mb-3" id="docsNotesTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="documents-sub-tab" data-bs-toggle="tab" data-bs-target="#documents-sub" type="button" role="tab">Documents</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="notes-sub-tab" data-bs-toggle="tab" data-bs-target="#notes-sub" type="button" role="tab">Notes</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="docsNotesTabsContent">
                                        <!-- Documents Sub-tab -->
                                        <div class="tab-pane fade show active" id="documents-sub" role="tabpanel">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0">Documents</h5>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                                                    <i class="fa fa-upload"></i> Upload Document
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>File Name</th>
                                                            <th>Document Type</th>
                                                            <th>Uploaded On</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($partner->documents as $document)
                                                            <tr>
                                                                <td>{{ $document->file_name }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $document->document_type == 'TSA' ? 'info' : ($document->document_type == 'Agreement' ? 'success' : ($document->document_type == 'Contract' ? 'warning' : 'secondary')) }}">
                                                                        {{ $document->document_type ?? 'Other' }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $document->created_at->format('d M Y') }}</td>
                                                                <td>
                                                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="action-icon">
                                                                        <i class="fa fa-download"></i>
                                                                    </a>
                                                                    <a href="#" class="action-icon text-danger" onclick="event.preventDefault(); if(confirm('Delete this document?')) { document.getElementById('delete-document-{{ $document->id }}').submit(); }">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                    <form id="delete-document-{{ $document->id }}" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.documents.destroy', $document->id) : route('staff.b2b-partners.documents.destroy', $document->id) }}" method="POST" style="display: none;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center py-4">
                                                                    <div class="text-muted">
                                                                        <i class="fa fa-file-alt fa-2x mb-2"></i>
                                                                        <p>No documents found</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Notes Sub-tab -->
                                        <div class="tab-pane fade" id="notes-sub" role="tabpanel">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0">Notes</h5>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                                                    <i class="fa fa-plus"></i> Add Note
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Author</th>
                                                            <th>Note</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($partner->notes as $note)
                                                            <tr>
                                                                <td>{{ $note->created_at->format('d M Y H:i') }}</td>
                                                                <td>{{ $note->creator_name }}</td>
                                                                <td>{{ $note->note }}</td>
                                                                <td>
                                                                    <a href="#" class="action-icon text-danger" onclick="event.preventDefault(); if(confirm('Delete this note?')) { document.getElementById('delete-note-{{ $note->id }}').submit(); }">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                    <form id="delete-note-{{ $note->id }}" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.notes.destroy', $note->id) : route('staff.b2b-partners.notes.destroy', $note->id) }}" method="POST" style="display: none;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center py-4">
                                                                    <div class="text-muted">
                                                                        <i class="fa fa-sticky-note fa-2x mb-2"></i>
                                                                        <p>No notes found</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- History Tab -->
                                <div class="tab-pane fade" id="history" role="tabpanel">
                                    <h5 class="mb-3">Activity History</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Date & Time</th>
                                                    <th>Activity</th>
                                                    <th>Description</th>
                                                    <th>Performed By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($activities as $activity)
                                                    <tr>
                                                        <td>{{ $activity->created_at->format('d M Y H:i') }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $activity->activity_type == 'created' ? 'success' : ($activity->activity_type == 'updated' ? 'primary' : ($activity->activity_type == 'deleted' ? 'danger' : 'info')) }}">
                                                                {{ ucfirst($activity->activity_type) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $activity->description ?? '-' }}</td>
                                                        <td>{{ $activity->performed_by_name }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No activity history found</td>
                                                    </tr>
                                                @endforelse
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

    <!-- Add Contact Modal -->
    <div class="modal fade" id="addContactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Contact Person</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.contacts.store', $partner->id) : route('staff.b2b-partners.contacts.store', $partner->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-control" required>
                                <option value="Secondary">Secondary</option>
                                <option value="Primary">Primary</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Contact</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Document Modal -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.documents.store', $partner->id) : route('staff.b2b-partners.documents.store', $partner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Document Type <span class="text-danger">*</span></label>
                            <select name="document_type" class="form-control" required>
                                <option value="Agreement">Agreement</option>
                                <option value="TSA">TSA</option>
                                <option value="Contract">Contract</option>
                                <option value="License">License</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>File <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Note Modal -->
    <div class="modal fade" id="addNoteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.notes.store', $partner->id) : route('staff.b2b-partners.notes.store', $partner->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Note <span class="text-danger">*</span></label>
                            <textarea name="note" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection