 <?php $__env->startSection('content'); ?>
<!-- main content -->
<div class="container-fluid ticket" id="ticket">

    <!--page heading-->
    <div class="row page-titles">

        <!-- Page Title & Bread Crumbs -->
        <?php echo $__env->make('misc.heading-crumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('pages.ticket.components.misc.actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
    <!--page heading-->


    <!-- page content -->
    <div class="row">
        <div class="col-12" id="tickets-table-wrapper">
            <!--ticket-->
            <?php echo $__env->make('pages.ticket.components.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--ticket-->
        </div>
    </div>
    <!--page content -->
</div>
<!--main content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pentasof/hrcrm.testpentas.in/staff/application/resources/views/pages/ticket/wrapper.blade.php ENDPATH**/ ?>