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

                                <div class="row">
                                    <div class="col-md-6">
                                        <h1>Reservations</h1>
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <a href="<?php echo e(route('airtickets.create')); ?>" class="btn btn-primary mb-3">Add</a>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Flight Number</th>
                                            <th>EMD</th>
                                            <th>MCO</th>
                                            <th>Date Change</th>
                                            <th>Refund</th>
                                            <th>Ticket Issued From</th>
                                            <th>Ticket Issued To</th>
                                            <th>Departure Date</th>
                                            <th>Return Date</th>
                                            <th>Airline</th>
                                            <th>Base Fare</th>
                                            <th>Taxes</th>
                                            <th>Amount Paid to Airlines</th>
                                            <th>Amount Charged from Pax</th>
                                            <th>Status</th>
                                            <th>Update Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $airTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $airTicket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($airTicket->id); ?></td>
                                                <td><?php echo e($airTicket->ticket_number); ?></td>
                                                <td><?php echo e($airTicket->emd); ?></td>
                                                <td><?php echo e($airTicket->mco); ?></td>
                                                <td><?php echo e($airTicket->date_change ? 'Yes' : 'No'); ?></td>
                                                <td><?php echo e($airTicket->refund ? 'Yes' : 'No'); ?></td>
                                                <td><?php echo e($airTicket->ticket_issued_from); ?></td>
                                                <td><?php echo e($airTicket->ticket_issued_to); ?></td>
                                                <td><?php echo e($airTicket->departure_date); ?></td>
                                                <td><?php echo e($airTicket->return_date); ?></td>
                                                <td><?php echo e($airTicket->airline->airline_code); ?></td>
                                                <td><?php echo e($airTicket->base_fare); ?></td>
                                                <td><?php echo e($airTicket->taxes); ?></td>
                                                <td><?php echo e($airTicket->amount_paid_to_airlines); ?></td>
                                                <td><?php echo e($airTicket->amount_charged_from_pax); ?></td>

                                                <td>
                                                    <?php switch($airTicket->status):
                                                        case ('approved'): ?>
                                                            <span
                                                                class="badge badge-success"><?php echo e(ucfirst($airTicket->status)); ?></span>
                                                        <?php break; ?>

                                                        <?php case ('canceled'): ?>
                                                            <span
                                                                class="badge badge-warning"><?php echo e(ucfirst($airTicket->status)); ?></span>
                                                        <?php break; ?>

                                                        <?php case ('rejected'): ?>
                                                            <span
                                                                class="badge badge-danger"><?php echo e(ucfirst($airTicket->status)); ?></span>
                                                        <?php break; ?>

                                                        <?php default: ?>
                                                            <span><?php echo e(ucfirst($airTicket->status)); ?></span>
                                                    <?php endswitch; ?>
                                                </td>
                                                <td>
                                                    <form
                                                        action="<?php echo e(route('airtickets.update_status', $airTicket->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <select name="status" class="form-control" required>
                                                            <option value="approved"
                                                                <?php echo e($airTicket->status == 'approved' ? 'selected' : ''); ?>>
                                                                Approved</option>
                                                            <option value="canceled"
                                                                <?php echo e($airTicket->status == 'canceled' ? 'selected' : ''); ?>>
                                                                Canceled</option>
                                                            <option value="rejected"
                                                                <?php echo e($airTicket->status == 'rejected' ? 'selected' : ''); ?>>
                                                                Rejected</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </form>
                                                </td>
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
<?php /**PATH C:\xampp\htdocs\hrcrm\staff\application\resources\views/airtickets/index.blade.php ENDPATH**/ ?>