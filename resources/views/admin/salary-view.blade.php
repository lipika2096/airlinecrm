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
                        <h3 class="page-title">Payslip</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payslip</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white" id="download-pdf">PDF</button>
                            <!--<button class="btn btn-white" id="print-payslip"><i class="fa fa-print fa-lg"></i> Print</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row slippay">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="payslip-title">Payslip for the month of {{$paySlip->pay_for_month}}</h4>
                            <div class="row">
                                <div class="col-sm-6 m-b-20">
                                    <img src="{{asset('public/assets/img/logo2.png')}}" class="inv-logo" alt="">
                                    <ul class="list-unstyled mb-0">
                                        <li>{{Auth::user()->name}}</li>
                                        <li>{{Auth::user()->address}}</li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase">Payslip #{{$paySlip->payslip_id}}</h3>
                                        <!--<ul class="list-unstyled">-->
                                        <!--    <li>Salary Month: <span>March, 2019</span></li>-->
                                        <!--</ul>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 m-b-20">
                                    <ul class="list-unstyled">
                                        <li><h5 class="mb-0"><strong>{{$paySlip->user->first_name}} {{$paySlip->user->last_name}}</strong></h5></li>
                                        <li><span>{{$paySlip->user->position}}</span></li>
                                        <li>Employee ID: {{$paySlip->user->unique_id}}</li>
                                        <li>Joining Date: {{$paySlip->user->joining_date}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Earnings</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Basic Salary</strong> <span class="float-end">{{$paySlip->basic}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>D.A.</strong> <span class="float-end">{{$paySlip->da}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>House Rent Allowance (H.R.A.)</strong> <span class="float-end">{{$paySlip->hra}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Conveyance</strong> <span class="float-end">{{$paySlip->conveyance}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Allowance</strong> <span class="float-end">{{$paySlip->allowance}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Medical Allowance</strong> <span class="float-end">{{$paySlip->medical_allowance}}</span></td>
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
                                        <h4 class="m-b-10"><strong>Deductions</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Tax Deducted at Source (T.D.S.)</strong> <span class="float-end">{{$paySlip->tds}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Provident Fund</strong> <span class="float-end">{{$paySlip->pf}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>ESI</strong> <span class="float-end">{{$paySlip->esi}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Leave</strong> <span class="float-end">{{$paySlip->leave_dd}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Prof. Tax</strong> <span class="float-end">{{$paySlip->prof_tax}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Labour Welfare</strong> <span class="float-end"><strong>{{$paySlip->labour_welfare}}</strong></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <p><strong>Net Salary: {{$paySlip->salary}}</strong><span id="salary-in-words" style="text-transform:capitalize;"></span></p>
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
        var salary = {{$paySlip->salary}};
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
                doc.save('payslip.pdf');
            });
        });
    });
</script>



@endsection
