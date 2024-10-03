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
    <h1>Leaves</h1>
    </div>
    <div class="col-md-6" style="text-align: right;">

        </div>
 </div>
       <div class="col-md-12">

    <div class="container">
        <div class="card count-1" id="tickets-table-wrapper">
            <div class="card-body">
                <div class="table-responsive list-table-wrapper">
                    <div class="backgroundheadingsection">
                        <div class="row">

                            <div class="col-md-6" style="text-align: right;"></div>
                        </div>
                        <div class="col-md-12">
                            <form action="<?php echo e(route('leave.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label>Leave Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="leave_type">
                                        <option>Casual Leave </option>
                                        <option>Medical Leave</option>
                                        <option>Loss of Pay</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>From <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="from" id="from" required>
                                </div>
                                <div class="form-group">
                                    <label>To <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="to" id="to" required>
                                </div>
                                <div class="form-group">
                                    <label>Number of Days <span class="text-danger">*</span></label>
                                    <input id="no_of_days" type="text" class="form-control" readonly required>
                                </div>
                                <div class="form-group">
                                    <label>Remaining Leaves <span class="text-danger">*</span></label>
                                    <input id="remaining_leaves" type="text" class="form-control" readonly required>
                                </div>
                                <div class="form-group">
                                    <label>Reason <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="reason" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
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


<script>
    // Function to calculate number of days between two dates
    function calculateDays() {
        var from_date = document.getElementById('from').value;
        var to_date = document.getElementById('to').value;

        if (from_date && to_date) {
            // Calculate number of days between dates
            var startDate = new Date(from_date);
            var endDate = new Date(to_date);
            var timeDiff = endDate.getTime() - startDate.getTime();
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

            // Update number of days field
            document.getElementById('no_of_days').value = diffDays + 1; // Include both start and end dates

            // Calculate remaining leaves (assuming 12 as default total)
            var totalLeaves = 12;
            var usedLeaves = 0; // You need to implement logic to fetch used leaves dynamically

            var remainingLeaves = totalLeaves - usedLeaves;
            document.getElementById('remaining_leaves').value = remainingLeaves;
        }
    }

    // Attach event listeners to from and to date inputs
    document.getElementById('from').addEventListener('change', calculateDays);
    document.getElementById('to').addEventListener('change', calculateDays);

    // Calculate days on page load (if you want initial calculation)
    calculateDays();
</script>

<!--[PRINTING]-->
<?php if(config('visibility.page_rendering') == 'print-page'): ?>
    <script src="<?php echo e(asset('/public/js/dynamic/print.js?v=')); ?><?php echo e(config('system.versioning')); ?>"></script>
<?php endif; ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\hrcrm\staff\application\resources\views/leaves/create.blade.php ENDPATH**/ ?>