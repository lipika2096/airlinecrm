<!DOCTYPE html>
<html lang="en" >

<!--CRM - GROWCRM.IO-->
<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
     <!--top nav-->
     <?php echo $__env->make('nav.topnav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php echo $__env->make('nav.leftmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--top nav-->
        <link rel="stylesheet" href="<?php echo e(asset('public/css/custom.css')); ?>">

        <!--page wrapper-->
        <div class="page-wrapper">

            <!--overlay-->
            <div class="page-wrapper-overlay js-close-side-panels hidden" data-target=""></div>
            <!--overlay-->

            <!--preloader-->

<body id="main-body"
    class="loggedin fix-header card-no-border fix-sidebar ">

    <!--main wrapper-->
    <div id="main-wrapper" style="margin-top:50px;">


    <div class="container">


    <div class="card count-1" id="tickets-table-wrapper">
    <div class="card-body">

        <div class="table-responsive list-table-wrapper">

    <div class="backgroundheadingsection">

    <div class="row">
    <div class="col-md-6">
    <h1>Leads Add </h1><br>
    </div>
    <div class="col-md-6" style="text-align: right;">

        </div>
 </div>


       <div class="col-md-12">


    <form action="<?php echo e(route('airtickets.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
    <label for="airline_id">Airline</label>
    <select class="form-control" id="airline_id" name="airline_id" required>
        <?php $__currentLoopData = $airlines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $airline_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($id); ?>"><?php echo e($airline_code); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
        <div class="form-group">
            <label for="ticket_number">Ticket Number</label>
            <input type="text" class="form-control" id="ticket_number" name="ticket_number" required>
        </div>

        <div class="form-group">
            <label for="emd">EMD</label>
            <input type="text" class="form-control" id="emd" name="emd">
        </div>

        <div class="form-group">
            <label for="mco">MCO</label>
            <input type="text" class="form-control" id="mco" name="mco">
        </div>

        <div class="form-group">
            <label for="date_change">Date Change</label>
            <input type="text" class="form-control" id="date_change" name="date_change" >
        </div>

        <div class="form-group">
            <label for="refund">Refund</label>
            <input type="text" class="form-control" id="refund" name="refund" >
        </div>
<div class="row">
<div class="col-md-3">
        <div class="form-group">
            <label for="ticket_issued_from">Ticket Issued From</label>
            <input type="date" class="form-control" id="ticket_issued_from" name="ticket_issued_from">
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
            <label for="ticket_issued_to">Ticket Issued To</label>
            <input type="date" class="form-control" id="ticket_issued_to" name="ticket_issued_to">
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
            <label for="departure_date">Departure Date</label>
            <input type="date" class="form-control" id="departure_date" name="departure_date">
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
            <label for="return_date">Return Date</label>
            <input type="date" class="form-control" id="return_date" name="return_date">
        </div>
        </div>
        </div>



        <div class="form-group">
            <label for="base_fare">Base Fare</label>
            <input type="number" step="0.01" class="form-control" id="base_fare" name="base_fare" required>
        </div>

        <div class="form-group">
            <label for="taxes">Taxes</label>
            <input type="number" step="0.01" class="form-control" id="taxes" name="taxes" required>
        </div>

        <div class="form-group">
            <label for="amount_paid_to_airlines">Amount Paid to Airlines</label>
            <input type="number" step="0.01" class="form-control" id="amount_paid_to_airlines" name="amount_paid_to_airlines" required>
        </div>

        <div class="form-group">
            <label for="amount_charged_from_pax">Amount Charged from Pax</label>
            <input type="number" step="0.01" class="form-control" id="amount_charged_from_pax" name="amount_charged_from_pax" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Air Ticket</button>
    </form>


    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('css/custom.css')); ?>"></script>
<!--common modals-->
<?php echo $__env->make('modals.actions-modal-wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('modals.common-modal-wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('modals.plain-modal-wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('pages.authentication.modal.relogin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!--selector - modals-->
    <?php echo $__env->make('modals.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <!--js footer-->
    <?php echo $__env->make('layout.footerjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!--js automations-->
    <?php echo $__env->make('layout.automationjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!--[note: no sanitizing required] for this trusted content, which is added by the admin-->
    <?php echo config('system.settings_theme_body'); ?>

</body>


<!--[PRINTING]-->
<?php if(config('visibility.page_rendering') == 'print-page'): ?>
<script src="<?php echo e(asset('/public/js/dynamic/print.js?v=')); ?><?php echo e(config('system.versioning')); ?>"></script>
<?php endif; ?>

</html>
<?php /**PATH /home/pentasof/hrcrm.testpentas.in/agent/application/resources/views/airtickets/create.blade.php ENDPATH**/ ?>