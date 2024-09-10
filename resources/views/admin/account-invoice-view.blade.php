@extends('admin/layouts/head-main')
@section('content')


    <title>Salary</title>


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Account</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Account</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white" id="download-pdf">PDF</button>
                            <button class="btn btn-white" id="print-account" onclick="window.print()">
                                <i class="fa fa-print fa-lg"></i> Print
                            </button>
                            <!--<button class="btn btn-white" id="print-account"><i class="fa fa-print fa-lg"></i> Print</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row slippay">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="account-title">Account Invoice of {{$account->agent->company_name}}</h4>
                            <div class="row">
                                <div class="col-sm-6 m-b-20">
                                    <!-- <img src="{{asset('public/assets/img/logo2.png')}}" class="inv-logo" alt=""> -->
                                    <!-- <ul class="list-unstyled mb-0">
                                        <li>{{Auth::user()->name}}</li>
                                        <li>{{Auth::user()->address}}</li>
                                    </ul> -->
                                </div>
                                <div class="col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase">Account #{{$account->id}}</h3>
                                        <!--<ul class="list-unstyled">-->
                                        <!--    <li>Salary Month: <span>March, 2019</span></li>-->
                                        <!--</ul>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 m-b-20">
                                    <ul class="list-unstyled">
                                        <li><h5 class="mb-0"><strong>{{$account->agent->company_name}} {{$account->agent->last_name}}</strong></h5></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Account Details</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Account No.</strong> <span class="float-end">{{$account->acc_no}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>IFSC CODE</strong> <span class="float-end">{{$account->ifsc_code}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>MISC CODE</strong> <span class="float-end">{{$account->misc_code}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Booking Id</strong> <span class="float-end">{{$account->booking_id}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>PNR</strong> <span class="float-end">{{$account->pnr}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Ticket No.</strong> <span class="float-end">{{$account->ticket_no}}</span></td>
                                                </tr>
                                                <!--<tr>-->
                                                <!--    <td><strong>Total Earnings</strong> <span class="float-end"><strong>$55</strong></span></td>-->
                                                <!--</tr>-->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Transaction Details</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Initial Amount</strong> <span class="float-end">{{$account->balance}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Credit Amount</strong> <span class="float-end">{{$creditamount}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Debit Amount</strong> <span class="float-end">{{$debitamount}}</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <p><strong>Total Amount: {{$newbalance->balance}}</strong><span id="salary-in-words" style="text-transform:capitalize;"></span></p>
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

<script src="https://cdn.jsdelivr.net/npm/number-to-words"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var salary = {{$account->salary}};
        var salaryInWords = numberToWords.toWords(salary);
        document.getElementById('salary-in-words').innerText = `(${salaryInWords} only.)`;

        
        document.getElementById('download-pdf').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            html2canvas(document.querySelector('.slippay')).then(canvas => {
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
                doc.save('account.pdf');
            });
        });
    });
</script>



@endsection
