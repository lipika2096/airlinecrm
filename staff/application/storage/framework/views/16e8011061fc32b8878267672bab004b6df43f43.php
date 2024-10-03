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
            <h3>Wallet Request View</h3><br/>
        </div>
    </div>
       <div class="col-md-12">

       
        
        <div class="form-group">
            <label for="booking_id" class="text-bold">Payment Mode : </label> <?php echo e($walletDetail->payment_mode); ?>

        </div>

        <div class="form-group">
            <label for="refund_amount" class="text-bold">Amount:</label> <?php echo e($walletDetail->amount); ?>


        </div>
        <div class="form-group">
            <label for="request_date" class="text-bold">Bank Transaction Id: </label> <?php echo e($walletDetail->bank_tran_id); ?>

        </div>

        <div class="form-group">
            <label for="request_date" class="text-bold">Bank Name: </label> <?php echo e($walletDetail->bank_name); ?>

        </div>

        <div class="form-group">
            <label for="processed_date" class="text-bold">Branch: </label> <?php echo e($walletDetail->bank_branch); ?>

        </div>

        <div class="form-group">
            <label for="processed_date" class="text-bold">Status: </label> <?php if($walletDetail->status == 1): ?>
            <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                <i class="fa fa-dot-circle-o text-success"></i>Approved
            </a>
        <?php elseif($walletDetail->status == 2): ?>
            <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                <i class="fa fa-dot-circle-o text-purple"></i>Pending
            </a>
        <?php else: ?>
            <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                <i class="fa fa-dot-circle-o text-danger"></i>Rejected
            </a>
        <?php endif; ?>
        </div>
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
<?php /**PATH C:\xampp\htdocs\hrcrm\staff\application\resources\views/wallet-request/view-wallet.blade.php ENDPATH**/ ?>