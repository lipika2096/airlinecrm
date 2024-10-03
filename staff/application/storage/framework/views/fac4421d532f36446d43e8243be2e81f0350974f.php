<!DOCTYPE html>
<html lang="en" >
<style>
    
.table-responsive {
    overflow-x: hidden !important;

}
</style>
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
    <h1>Refunds</h1>
    </div>
    <div class="col-md-6" style="text-align: right;">

        </div>
 </div>
       <div class="col-md-12">

       <form action="<?php echo e(route('refunds.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="booking_id">Booking ID</label>
            <select class="form-control" id="booking_id" name="booking_id" required>
                <option value="">Select Booking</option>
                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($booking->id); ?>"><?php echo e($booking->booking_number); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
    <label for="agent_id">Passenger ID</label>
    <select class="form-control" id="passenger_id" name="passenger_id" required>
        <option value="">Select Passenger</option>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($user->id); ?>"><?php echo e($user->unique_id); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
        <div class="form-group">
            <label for="refund_amount">Refund Amount</label>
            <input type="number" class="form-control" id="refund_amount" name="refund_amount" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="refund_status" required>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <div class="form-group">
            <label for="request_date">Request Date</label>
            <input type="date" class="form-control" id="request_date" name="request_date" required>
        </div>
        <div class="form-group">
            <label for="processed_date">Processed Date</label>
            <input type="date" class="form-control" id="processed_date" name="processed_date">
        </div>
        <div class="form-group">
            <label for="reason">Reason</label>
            <textarea class="form-control" id="reason" name="reason"></textarea>
        </div>
        <button type="submit" class="btn btn-primary kr">Submit</button>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="<?php echo e(asset('public/js/core/app.js')); ?>"></script>
    <script src="<?php echo e(asset('public/css/custom.css')); ?>"></script>
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
<?php /**PATH C:\xampp\htdocs\hrcrm\staff\application\resources\views/refunds/create.blade.php ENDPATH**/ ?>