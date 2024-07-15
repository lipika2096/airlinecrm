<!DOCTYPE html>
<html lang="en" class="<?php echo e(auth()->user()->type ?? ''); ?> <?php echo e(config('visibility.page_rendering')); ?>">

<?php 
        use Carbon\Carbon;
        ?>
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
    <div class="container profile-container">
    <h4>Profile</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        <div class=" row">
            <div class="col-md-6">
                <div class="row profile-card">
                    <div class="col-md-1">
                    <img src="<?php echo e(asset('storage/avatars/'.$agent->avatar_directory.'/'.$agent->avatar_filename)); ?>" alt="Profile Image">
                    </div>
                    <div class="col-md-5" style="padding: 0 35px;border-right: dotted;">
                    <h5><?php echo e($agent->first_name); ?> <?php echo e($agent->last_name); ?></h5>
                    <p>Agent</p>
                    <p>Date of Creation: <?php echo e(Carbon::parse($agent->created_at)->format('jS M Y')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <span style="font-weight: bold;">Unique ID:</span> <a style="display: inline;position: absolute;"><?php echo e($agent->unique_id); ?></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span style="font-weight: bold;">Email:</span> <a style="display: inline;position: absolute;"><?php echo e($agent->email); ?></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span style="font-weight: bold;">Phone:</span> <a style="display: inline;position: absolute;"><?php echo e($agent->phone); ?></a>
                    </div>
                </div>
            </div>
            <!-- <img src="https://via.placeholder.com/80" alt="Profile Image">
            <div class="profile-info">
                <h5><?php echo e($agent->first_name); ?> <?php echo e($agent->last_name); ?></h5>
                <p>Agent</p>
                <p>Date of Creation: <?php echo e(Carbon::parse($agent->created_at)->format('jS M Y')); ?></p>
            </div>
            <div class="profile-email">
                <span>Email:</span>
                <a href="mailto:admin@example.com"><?php echo e($agent->email); ?></a>
            </div>
            <div class="profile-email">
                <span>Phone:</span>
                <a href="mailto:admin@example.com"><?php echo e($agent->phone); ?></a>
            </div> -->
        </div>
    </div>
    </div>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 15px;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
        }

        .profile-container {
            padding: 20px;
        }

        .profile-card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            align-items: center;
            width: 1018px;
            height: 160px;
        }

        .profile-card img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            margin-right: 20px;
        }

        .profile-info {
            flex-grow: 1;
        }

        .profile-info h5 {
            margin: 0;
            font-weight: bold;
        }

        .profile-info p {
            margin: 0;
            color: #6c757d;
        }

        .profile-email {
            margin-left: auto;
            text-align: right;
        }

        .profile-email span {
            font-weight: bold;
        }

        .profile-email a {
            color: #007bff;
            text-decoration: none;
        }

        .profile-email a:hover {
            text-decoration: underline;
        }
    </style>
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
<?php /**PATH /home/pentasof/hrcrm.testpentas.in/agent/application/resources/views/user/view.blade.php ENDPATH**/ ?>