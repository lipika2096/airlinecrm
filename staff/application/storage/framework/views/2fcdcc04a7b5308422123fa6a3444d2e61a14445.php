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
                                        <h1>Fare Conditions</h1>
                                    </div>
                                    <div class="col-md-6" style="text-align:right">
                                        <!--<a href="<?php echo e(route('fare_conditions.create')); ?>" class="btn btn-primary">Add </a>-->
                                    </div>
                                </div>

                                <div class="container">


                                    <?php if(session('success')): ?>
                                        <div class="alert alert-success">
                                            <?php echo e(session('success')); ?>

                                        </div>
                                    <?php endif; ?>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Fare Condition Details</th>
                                                <th>Cancellation Policy</th>
                                                <th>Date Change Policy</th>
                                                <th>Updated By</th>
                                                <th>Effective From</th>
                                                <th>Valid Till</th>
                                                <!--<th>Actions</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $fareConditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fareCondition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($fareCondition->id); ?></td>
                                                    <td><?php echo e($fareCondition->fare_condition_details); ?></td>
                                                    <td><?php echo e($fareCondition->cancellation_policy); ?></td>
                                                    <td><?php echo e($fareCondition->date_change_policy); ?></td>
                                                    <td><?php echo e($fareCondition->updated_by); ?></td>
                                                    <td><?php echo e($fareCondition->effective_from_date); ?></td>
                                                    <td><?php echo e($fareCondition->valid_till_date); ?></td>
                                                    <!--<td>-->
                                                    <!--    <a href="<?php echo e(route('fare_conditions.edit', $fareCondition->id)); ?>" class="btn btn-sm btn-success">Edit</a>-->
                                                    <!--    <form action="<?php echo e(route('fare_conditions.destroy', $fareCondition->id)); ?>" method="POST" style="display:inline-block;">-->
                                                    <!--        <?php echo csrf_field(); ?>-->
                                                    <!--        <?php echo method_field('DELETE'); ?>-->
                                                    <!--        <button type="submit" class="btn btn-sm btn-danger">Delete</button>-->
                                                    <!--    </form>-->
                                                    <!--</td>-->
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
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
<?php /**PATH C:\xampp\htdocs\hrcrm\staff\application\resources\views/fare_conditions/index.blade.php ENDPATH**/ ?>