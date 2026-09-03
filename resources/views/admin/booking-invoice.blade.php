@extends('admin/layouts/head-main')
@section('title', 'Booking Invoice')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">
    <style>
        .invoice-container {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #dee2e6;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        .invoice-number {
            font-size: 18px;
            color: #007bff;
            font-weight: 500;
        }
        .billing-section {
            margin-bottom: 30px;
        }
        .billing-section h5 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
        .billing-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .billing-info p {
            margin-bottom: 8px;
            color: #555;
        }
        .billing-info strong {
            color: #333;
        }
        .invoice-table {
            margin-bottom: 30px;
        }
        .invoice-table .table {
            margin-bottom: 0;
        }
        .invoice-table thead th {
            background: #007bff;
            color: #fff;
            font-weight: 600;
            border: none;
        }
        .invoice-table tbody td {
            vertical-align: middle;
        }
        .totals-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .total-row:last-child {
            margin-bottom: 0;
            font-size: 18px;
            font-weight: 600;
            color: #007bff;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .btn-email {
            background: #28a745;
            border-color: #28a745;
            color: #fff;
        }
        .btn-print {
            background: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
        }
        .btn-pdf {
            background: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
        @media print {
            .action-buttons, .page-header {
                display: none !important;
            }
            .invoice-container {
                box-shadow: none;
            }
        }
    </style>

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Booking Invoice</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.accounts.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.accounts.index') : route('admin.accounts.index')) }}">
                                Accounts
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.create') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.create') : route('admin.booking.create')) }}">
                                Booking
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Invoice</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Invoice Container -->
        <div class="invoice-container" id="invoice-content">
            <!-- Invoice Header -->
            <div class="invoice-header">
                <div>
                    <h4 class="invoice-title">INVOICE</h4>
                    <p class="invoice-number">{{ $invoiceNo }}</p>
                </div>
                <div class="text-end">
                    <p><strong>Date:</strong> {{ $booking->booking_date->format('d M Y') }}</p>
                    <p><strong>Booking No:</strong> {{ $booking->booking_no }}</p>
                </div>
            </div>

            <!-- Billing Information -->
            <div class="billing-section">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Bill To:</h5>
                        <div class="billing-info">
                            <p><strong>{{ $booking->customer_name }}</strong></p>
                            <p><strong>Type:</strong> {{ ucfirst($booking->customer_type) }}</p>
                            @if($booking->customer_email)
                                <p><strong>Email:</strong> {{ $booking->customer_email }}</p>
                            @endif
                            @if($booking->customer_phone)
                                <p><strong>Phone:</strong> {{ $booking->customer_phone }}</p>
                            @endif
                            <p><strong>VAT Number:</strong> VAT-{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Payment Details:</h5>
                        <div class="billing-info">
                            <p><strong>Total Due:</strong> €{{ number_format($total, 2) }}</p>
                            <p><strong>Payment Method:</strong> {{ $booking->payments->first()->payment_method ?? 'N/A' }}</p>
                            <p><strong>Payment Status:</strong> {{ ucfirst($booking->payments->first()->status ?? 'pending') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Table -->
            <div class="invoice-table">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Price (€)</th>
                                <th>VAT ({{ $vatRate }}%)</th>
                                <th class="text-end">Amount (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->services as $service)
                                <tr>
                                    <td>
                                        <strong>{{ ucfirst($service->service_type) }}</strong>
                                        @if($service->description)
                                            <br><small>{{ $service->description }}</small>
                                        @endif
                                        @if($service->supplier)
                                            <br><small>Supplier: {{ $service->supplier }}</small>
                                        @endif
                                    </td>
                                    <td>1</td>
                                    <td>{{ number_format($service->sell, 2) }}</td>
                                    <td>{{ number_format(($service->sell * $vatRate) / 100, 2) }}</td>
                                    <td class="text-end">{{ number_format($service->sell + (($service->sell * $vatRate) / 100), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totals Section -->
            <div class="totals-section">
                <div class="row">
                    <div class="col-md-6">
                        @if($booking->passengers->count() > 0)
                            <h5>Passengers:</h5>
                            <ul class="list-unstyled">
                                @foreach($booking->passengers as $passenger)
                                    <li>{{ $passenger->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="total-row">
                            <span>Subtotal:</span>
                            <span>€{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="total-row">
                            <span>VAT ({{ $vatRate }}%):</span>
                            <span>€{{ number_format($vatAmount, 2) }}</span>
                        </div>
                        <div class="total-row">
                            <span>Total:</span>
                            <span>€{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="total-row">
                            <span>Amount Due:</span>
                            <span>€{{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button type="button" class="btn btn-email" onclick="sendEmail()">
                    <i class="fa fa-envelope"></i> Send Email
                </button>
                <button type="button" class="btn btn-print" onclick="window.print()">
                    <i class="fa fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-pdf" onclick="downloadPDF()">
                    <i class="fa fa-file-pdf"></i> Download PDF
                </button>
            </div>
        </div>

    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    function sendEmail() {
        // Implement email functionality
        alert('Email functionality would be implemented here with a backend email service.');
    }

    function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const element = document.getElementById('invoice-content');
        
        html2canvas(element, {
            scale: 2,
            useCORS: true,
            logging: false
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            const imgWidth = 210; // A4 width in mm
            const pageHeight = 297; // A4 height in mm
            const imgHeight = canvas.height * imgWidth / canvas.width;
            let heightLeft = imgHeight;
            let position = 0;

            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            pdf.save('booking-invoice-{{ $booking->booking_no }}.pdf');
        });
    }
</script>

@endsection