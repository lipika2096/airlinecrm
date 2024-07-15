
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

        <div class="table-responsive list-table-wrapper">
    <div class="backgroundheadingsection">
        <h1>Bookings History</h1>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>

                    <th>Passenger ID</th>
                    <th>Booking Number</th>
                    <th>Origin</th>

                    <th>Destination</th>
                    <th>Airline Name</th>
                    <th>Passenger Name</th>
                    <th>Booking Reference</th>
                    <th>Booking Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($booking->id); ?></td>

                        <td><?php echo e($booking->passenger_id); ?></td>
                        <td><?php echo e($booking->booking_number); ?></td>
                        <td><?php echo e($booking->origin); ?></td>

                        <td><?php echo e($booking->destination); ?></td>
                        <td><?php echo e($booking->airline_name); ?></td>
                        <td><?php echo e($booking->passenger_name); ?></td>
                        <td><?php echo e($booking->booking_reference); ?></td>
                        <td><?php echo e($booking->booking_date); ?></td>
                        <td><?php echo e($booking->total_amount); ?></td>
                        <td><?php echo e($booking->status); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
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
<?php /**PATH C:\xampp\htdocs\hrcrm\staff\application\resources\views/bookings/history.blade.php ENDPATH**/ ?>