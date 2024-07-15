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
    <script src="https://cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>

    <!--main wrapper-->
    <div id="main-wrapper" style="margin-top:50px;">


    <div class="container">


    <div class="card count-1" id="tickets-table-wrapper">
    <div class="card-body">

        <div class="table-responsive list-table-wrapper">
    <div class="backgroundheadingsection">
        <h1>Confirmed Bookings</h1>
        </div>

    <div class="container">

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('fare_conditions.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="fare_condition_details">Fare Condition Details</label>
                <textarea name="fare_condition_details" id="editor1" rows="10" cols="80">
                <?php echo e(old('fare_condition_details')); ?>

    </textarea>
            </div>

            <div class="form-group">
                <label for="cancellation_policy">Cancellation Policy</label>
                <textarea name="cancellation_policy" class="form-control" id="editor2" required><?php echo e(old('cancellation_policy')); ?></textarea>
            </div>

            <div class="form-group">
                <label for="date_change_policy">Date Change Policy</label>
                <textarea name="date_change_policy" class="form-control" id="editor3" required><?php echo e(old('date_change_policy')); ?></textarea>
            </div>

            <div class="form-group">
                <label for="updated_by">Updated By</label>
                <input type="text" name="updated_by" class="form-control" value="<?php echo e(old('updated_by')); ?>" required>
            </div>

            <div class="form-group">
                <label for="effective_from_date">Effective From Date</label>
                <input type="date" name="effective_from_date" class="form-control" value="<?php echo e(old('effective_from_date')); ?>" required>
            </div>

            <div class="form-group">
                <label for="valid_till_date">Valid Till Date</label>
                <input type="date" name="valid_till_date" class="form-control" value="<?php echo e(old('valid_till_date')); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    </div>
    </div>
    </div>
    </div>


    <script>
        CKEDITOR.replace('editor1');
        CKEDITOR.replace('editor2');
        CKEDITOR.replace('editor3');
    </script>
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

<?php /**PATH /home/pentasof/hrcrm.testpentas.in/agent/application/resources/views/fare_conditions/create.blade.php ENDPATH**/ ?>