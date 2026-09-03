@extends('admin/layouts/head-main')
@section('title', 'Bookings')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">
    <style>
        .booking-index-card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .booking-index-card h4 {
            color: #333;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #dee2e6;
        }
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        .btn-view-invoice {
            background: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }
        .btn-view-details {
            background: #007bff;
            border-color: #007bff;
            color: #fff;
        }
        .customer-type-badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .type-individual {
            background: #e3f2fd;
            color: #0d47a1;
        }
        .type-corporate {
            background: #f3e5f5;
            color: #4a148c;
        }
        .type-agent {
            background: #fff3e0;
            color: #e65100;
        }
    </style>

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Bookings</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.accounts.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.accounts.index') : route('admin.accounts.index')) }}">
                                Accounts
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Bookings</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.create') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.create') : route('admin.booking.create')) }}" 
                       class="btn btn-primary">
                        <i class="fa fa-plus"></i> New Booking
                    </a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Booking Index Card -->
        <div class="booking-index-card">
            <h4>All Bookings</h4>
            
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Booking No</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Type</th>
                                <th>Total (€)</th>
                                <th>Profit (€)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->booking_no }}</strong>
                                    </td>
                                    <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                    <td>
                                        <strong>{{ $booking->customer_name }}</strong>
                                        @if($booking->customer_email)
                                            <br><small>{{ $booking->customer_email }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="customer-type-badge type-{{ $booking->customer_type }}">
                                            {{ $booking->customer_type }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>€{{ number_format($booking->total_sell, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-success">€{{ number_format($booking->profit, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $booking->status ?? 'pending' }}">
                                            {{ ucfirst($booking->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.invoice', $booking->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.invoice', $booking->id) : route('admin.booking.invoice', $booking->id)) }}" 
                                               class="btn btn-view-invoice" title="View Invoice">
                                                <i class="fa fa-file-invoice"></i>
                                            </a>
                                            <a href="#" class="btn btn-view-details" title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No bookings found</h5>
                    <p class="text-muted">Create your first booking to get started.</p>
                    <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.create') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.create') : route('admin.booking.create')) }}" 
                       class="btn btn-primary">
                        <i class="fa fa-plus"></i> Create Booking
                    </a>
                </div>
            @endif
        </div>

    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->

@endsection