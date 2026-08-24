@extends('admin/layouts/head-main')
@section('content')

    <title>Bank Statement</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Bank Statement</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.customer.accounts.all') }}">Accounts</a></li>
                            <li class="breadcrumb-item active">Bank Statement</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white" id="download-pdf"><i class="fa fa-file-pdf"></i> PDF</button>
                            <button class="btn btn-white" id="print-statement" onclick="window.print()">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row bank-statement">
                <div class="col-md-12">
                    <div class="card bank-statement-card">
                        <div class="card-body">
                            <!-- Bank Header -->
                            <div class="bank-header">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="bank-logo">
                                            <h2 class="bank-name">{{$account->bank_name}}</h2>
                                            <p class="bank-tagline">Your Trusted Financial Partner</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <div class="statement-info">
                                            <h4 class="statement-title">ACCOUNT STATEMENT</h4>
                                            <p class="statement-date">Statement as of: {{ date('d M Y') }}</p>
                                            <p class="statement-ref">Reference: #{{$account->id}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="bank-divider">

                            <!-- Account Holder Information -->
                            <div class="account-holder-info">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="holder-details">
                                            <h5 class="section-title">ACCOUNT HOLDER DETAILS</h5>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td class="label">Bank Name:</td>
                                                    <td class="value"><strong>{{$account->bank_name}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="label">Account Name:</td>
                                                    <td class="value"><strong>{{$account->admin->name}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="label">Account Number:</td>
                                                    <td class="value"><strong>{{$account->acc_no}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="label">IFSC Code:</td>
                                                    <td class="value">{{$account->ifsc_code}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="label">MISC Code:</td>
                                                    <td class="value">{{$account->misc_code}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="balance-summary">
                                            <h5 class="section-title text-white">BALANCE SUMMARY</h5>
                                            <div class="balance-box">
                                                <p class="balance-label">Current Balance</p>
                                                <p class="balance-amount">${{ number_format($account->balance + $creditamount - $debitamount, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="bank-divider">

                            <!-- Transaction Summary -->
                            <div class="transaction-summary">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="summary-box opening-balance">
                                            <p class="summary-label">Opening Balance</p>
                                            <p class="summary-value">${{ number_format($account->balance, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="summary-box credit-balance">
                                            <p class="summary-label">Total Credits</p>
                                            <p class="summary-value text-success">${{ number_format($creditamount, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="summary-box debit-balance">
                                            <p class="summary-label">Total Debits</p>
                                            <p class="summary-value text-danger">${{ number_format($debitamount, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Transaction Table -->
                            <div class="transaction-table-section">
                                <h5 class="section-title">TRANSACTION HISTORY</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered bank-table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th class="text-end">Debit</th>
                                                <th class="text-end">Credit</th>
                                                <th class="text-end">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $runningBalance = $account->balance;
                                            @endphp

                                            <!-- Opening Balance Entry -->
                                            <tr class="opening-row">
                                                <td>{{ $account->created_at->format('d M Y H:i') }}</td>
                                                <td><strong>Opening Balance</strong></td>
                                                <td class="text-end">-</td>
                                                <td class="text-end">${{ number_format($account->balance, 2) }}</td>
                                                <td class="text-end"><strong>${{ number_format($account->balance, 2) }}</strong></td>
                                            </tr>

                                            @foreach($transactions as $transaction)
                                                @php
                                                    $runningBalance = $runningBalance + $transaction->credit - $transaction->debit;
                                                @endphp
                                                <tr>
                                                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                                    <td>
                                                        <span class="transaction-desc">{{$transaction->tr_type ?? 'Transaction'}}</span>
                                                        @if($transaction->booking_id)
                                                            <br><small class="text-muted">Booking ID: {{$transaction->booking_id}}</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        @if($transaction->debit > 0)
                                                            <span class="text-danger">${{ number_format($transaction->debit, 2) }}</span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        @if($transaction->credit > 0)
                                                            <span class="text-success">${{ number_format($transaction->credit, 2) }}</span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-end"><strong>${{ number_format($runningBalance, 2) }}</strong></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-dark">
                                            <tr>
                                                <td colspan="4"><strong>Closing Balance</strong></td>
                                                <td class="text-end"><strong>${{ number_format($runningBalance, 2) }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- Pagination -->
                                @if($transactions->hasPages())
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $transactions->appends(request()->query())->links() }}
                                    </div>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="bank-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="footer-text">This is a computer-generated statement. No signature required.</p>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <p class="footer-text">For queries, contact: support@airlinecrmbank.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->

<style>
    .bank-statement-card {
        border: 2px solid #004085;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .bank-header {
        padding: 20px 0;
    }

    .bank-name {
        color: #004085;
        font-weight: bold;
        margin: 0;
        font-size: 24px;
    }

    .bank-tagline {
        color: #6c757d;
        margin: 5px 0 0 0;
        font-style: italic;
    }

    .statement-info {
        text-align: right;
    }

    .statement-title {
        color: #004085;
        font-weight: bold;
        margin: 0;
        font-size: 18px;
    }

    .statement-date, .statement-ref {
        color: #6c757d;
        margin: 3px 0;
        font-size: 14px;
    }

    .bank-divider {
        border-color: #004085;
        margin: 20px 0;
    }

    .section-title {
        color: #004085;
        font-weight: bold;
        margin-bottom: 15px;
        font-size: 16px;
        border-bottom: 2px solid #004085;
        padding-bottom: 5px;
    }

    .holder-details .label {
        width: 140px;
        color: #6c757d;
        font-weight: 500;
    }

    .holder-details .value {
        color: #212529;
    }

    .balance-summary {
        background: linear-gradient(135deg, #004085 0%, #0056b3 100%);
        padding: 20px;
        border-radius: 8px;
        color: white;
    }

    .balance-box {
        text-align: center;
    }

    .balance-label {
        margin: 0;
        font-size: 14px;
        opacity: 0.9;
    }

    .balance-amount {
        margin: 10px 0 0 0;
        font-size: 28px;
        font-weight: bold;
    }

    .transaction-summary {
        margin: 20px 0;
    }

    .summary-box {
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        border: 1px solid #dee2e6;
    }

    .opening-balance {
        background-color: #f8f9fa;
    }

    .credit-balance {
        background-color: #d4edda;
    }

    .debit-balance {
        background-color: #f8d7da;
    }

    .summary-label {
        margin: 0;
        font-size: 13px;
        color: #6c757d;
    }

    .summary-value {
        margin: 8px 0 0 0;
        font-size: 20px;
        font-weight: bold;
    }

    .transaction-table-section {
        margin-top: 25px;
    }

    .bank-table {
        font-size: 14px;
    }

    .bank-table thead th {
        background-color: #004085;
        border-color: #004085;
        color: white;
        font-weight: 500;
    }

    .bank-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .opening-row {
        background-color: #e9ecef;
        font-weight: 500;
    }

    .transaction-desc {
        font-weight: 500;
    }

    .bank-footer {
        margin-top: 30px;
        padding-top: 15px;
        border-top: 1px solid #dee2e6;
    }

    .footer-text {
        margin: 5px 0;
        font-size: 12px;
        color: #6c757d;
    }

    @media print {
        .page-header, .sidebar, .header {
            display: none !important;
        }
        .bank-statement-card {
            border: 2px solid #000;
        }
        .bank-name {
            color: #000;
        }
        .statement-title {
            color: #000;
        }
        .section-title {
            color: #000;
            border-bottom: 2px solid #000;
        }
        .balance-summary {
            background: #f0f0f0;
            color: #000;
        }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.getElementById('download-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        html2canvas(document.querySelector('.bank-statement')).then(canvas => {
            var imgData = canvas.toDataURL('image/png');
            var imgWidth = 210; 
            var pageHeight = 295;  
            var imgHeight = canvas.height * imgWidth / canvas.width;
            var heightLeft = imgHeight;

            var position = 0;

            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                doc.addPage();
                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }
            doc.save('bank_statement.pdf');
        });
    });
</script>

@endsection
