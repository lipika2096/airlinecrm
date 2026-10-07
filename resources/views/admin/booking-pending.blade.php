@extends('admin/layouts/head-main')
@section('title', 'Pending Reservations')
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
            color: #fff !important;
        }
        .btn-view-details {
            background: #007bff;
            border-color: #007bff;
            color: #fff !important;
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
                    <h3 class="page-title">Pending Reservations</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.index') : route('admin.booking.index')) }}">Reservations</a></li>
                        <li class="breadcrumb-item active">Pending Reservations</li>
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
            <h4>Pending Reservations</h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Total Cost</th>
                            <th>Total Sell</th>
                            <th>Profit</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($bookings->count() > 0)
                            @foreach($bookings as $booking)
                                <tr>
                                    <td><strong>{{ $booking->booking_no ?? 'N/A' }}</strong></td>
                                    <td>{{ $booking->booking_date ? $booking->booking_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $booking->customer_name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="customer-type-badge {{ $booking->customer_type == 'b2b' ? 'type-corporate' : 'type-individual' }}">
                                            {{ $booking->customer_type == 'b2b' ? 'B2B' : 'B2C' }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($booking->total_cost ?? 0, 2) }}</td>
                                    <td>${{ number_format($booking->total_sell ?? 0, 2) }}</td>
                                    <td class="{{ $booking->profit >= 0 ? 'text-success' : 'text-danger' }}">${{ number_format($booking->profit ?? 0, 2) }}</td>
                                    <td>
                                        <span class="status-badge {{ $booking->status == 'pending' ? 'status-pending' : ($booking->status == 'confirmed' ? 'status-confirmed' : 'status-cancelled') }}">
                                            {{ ucfirst($booking->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.edit', $booking->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.edit', $booking->id) : route('admin.booking.edit', $booking->id)) }}"
                                           class="btn btn-sm btn-view-details">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        @if($booking->invoice_number)
                                            <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.invoice', $booking->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.invoice', $booking->id) : route('admin.booking.invoice', $booking->id)) }}"
                                               class="btn btn-sm btn-view-invoice">
                                                <i class="fa fa-file-invoice"></i> Invoice
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center">
                                    <p class="text-muted">No pending reservations found.</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /Booking Index Card -->

    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->

@endsection
