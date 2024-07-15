<!DOCTYPE html>
<html lang="en" class="<?php echo e(auth()->user()->type ?? ''); ?> <?php echo e(config('visibility.page_rendering')); ?>">

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
    <?php if(config('visibility.page_rendering') == '' || config('visibility.page_rendering') != 'print-page'): ?>
        <div class="preloader">
            <div class="loader">
                <div class="loader-loading"></div>
            </div>
        </div>
    <?php endif; ?>
    <!--preloader-->

    <body id="main-body"
        class="loggedin fix-header card-no-border fix-sidebar <?php echo e(config('settings.css_kanban')); ?> <?php echo e(runtimePreferenceLeftmenuPosition(auth()->user()->left_menu_position)); ?> <?php echo e($page['page'] ?? ''); ?>">

        <!--main wrapper-->
        <div id="main-wrapper" style="margin-top:50px;">


            <div class="container">


                <div class="card count-1" id="tickets-table-wrapper">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <h1>Refunds</h1>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="<?php echo e(route('refunds.create')); ?>" class="btn btn-primary mb-3">Create
                                    +</a>
                            </div>
                        </div>



                        <?php if($refunds->isEmpty()): ?>
                            <p>No refunds found.</p>
                        <?php else: ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Booking ID</th>
                                        <th>Refund Reason</th>
                                        <th>Refund Amount</th>
                                        <th>Refund Status</th>
                                        <th>Request Date</th>
                                        <th>Processed Date</th>

                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $refunds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $refund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($refund->id); ?></td>
                                            <td><?php echo e($refund->booking_id); ?></td>

                                            <td><?php echo e($refund->reason); ?></td>
                                            <td><?php echo e($refund->refund_amount); ?></td>
                                            <td><?php echo e($refund->refund_status); ?></td>
                                            <td><?php echo e($refund->request_date); ?></td>
                                            <td><?php echo e($refund->processed_date); ?></td>

                                            <td style="width:130px;">
                                                <a href="<?php echo e(route('refunds.edit', $refund->id)); ?>"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form action="<?php echo e(route('refunds.destroy', $refund->id)); ?>"
                                                    method="POST" style="display: inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this refund?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\hrcrm\staff\application\resources\views/refunds/index.blade.php ENDPATH**/ ?>