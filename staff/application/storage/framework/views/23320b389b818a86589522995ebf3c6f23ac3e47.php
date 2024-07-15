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
    <div class="row">
    <div class="col-md-6">
    <h2>Leads Update</h2>
    </div>
    <div class="col-md-6" style="text-align: right;">

        </div>
 </div><br>
    <div class="backgroundheadingsection">


       <div class="col-md-12">

       <form method="POST" action="<?php echo e(route('saleleads.update', $lead->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?> <!-- Use PUT method for updates -->

                        <div class="form-group">
                            <label for="lead_firstname">Full Name</label>
                            <input type="text" id="lead_firstname" name="name" class="form-control" value="<?php echo e($lead->name); ?>" required>
                        </div>


                        <div class="form-group">
                            <label for="lead_email">Email</label>
                            <input type="email" id="lead_email" name="email" class="form-control" value="<?php echo e($lead->email); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="lead_phone">Phone</label>
                            <input type="text" id="lead_phone" name="phone" class="form-control" value="<?php echo e($lead->phone); ?>">
                        </div>

                        <div class="form-group">
                            <label for="lead_website">Website</label>
                            <input type="text" id="lead_website" name="project" class="form-control" value="<?php echo e($lead->project); ?>">
                        </div>

                        <div class="form-group">
                            <label for="lead_company_name">Company Name</label>
                            <input type="text" id="lead_company_name" name="company" class="form-control" value="<?php echo e($lead->company); ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('css/custom.css')); ?>"></script>
<!--common modals-->


    <!--js footer-->
    <?php echo $__env->make('layout.footerjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!--js automations-->
    <?php echo $__env->make('layout.automationjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!--[note: no sanitizing required] for this trusted content, which is added by the admin-->
    <?php echo config('system.settings_theme_body'); ?>

</body>


</html>
<?php /**PATH /home/pentasof/hrcrm.testpentas.in/agent/application/resources/views/salelead/edit.blade.php ENDPATH**/ ?>