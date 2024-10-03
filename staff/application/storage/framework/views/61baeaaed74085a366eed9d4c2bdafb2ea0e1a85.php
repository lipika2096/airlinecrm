<!DOCTYPE html>
<html lang="en" class="<?php echo e(auth()->user()->type ?? ''); ?> <?php echo e(config('visibility.page_rendering')); ?>">
<?php
    use Carbon\Carbon;
?>
<!--CRM - GROWCRM.IO-->
<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('nav.topnav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('nav.leftmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!--page wrapper-->
<div class="page-wrapper">
    <!--overlay-->
    <div class="page-wrapper-overlay js-close-side-panels hidden" data-target=""></div>
    <!--overlay-->
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
        <div id="main-wrapper">
            <div class="container profile-container">
                <h4>Profile</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-6">
                        <div class="profile-card">
                            <div class="col-md-1">
                                <img src="<?php echo e(asset('storage/avatars/'.$agent->avatar_directory.'/'.$agent->avatar_filename)); ?>" alt="Profile Image">
                            </div>
                            <div class="col-md-5" style="padding: 0 35px;border-right: dotted;">
                                <h5><?php echo e($agent->first_name); ?> <?php echo e($agent->last_name); ?></h5>
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
                </div>
                
                <div class="row nav nav-tabs ">
                    <button class="tablinks btn btn-default" onclick="openCity(event, 'ReadandSign')">Read and Sign</button>
                    <button class="tablinks btn btn-default" onclick="openCity(event, 'Services')">Services</button>
                    <button class="tablinks btn btn-default" onclick="openCity(event, 'LicencesApprovals')">Licences Approvals</button>
                    <button class="tablinks btn btn-default" onclick="openCity(event, 'LeaveInformation')">Leave Information</button>
                    <button class="tablinks btn btn-default" onclick="openCity(event, 'LeaveRequests')">Leave Requests</button>
                </div>
                <div id="ReadandSign" class="tabcontent">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Airline</th>
                                <th>Created</th>
                                <th>Last Viewed</th>
                                <th>Viewed & Signed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">No data found</td>
                            </tr>
                        </tbody>
                    </table>
                        </div>
                    </div>
                    
                  </div>

                  <div id="Services" class="tabcontent">
                   <div class="card">
                        <div class="card-body">
                            <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">No data found</td>
                            </tr>
                        </tbody>
                    </table>
                        </div>
                    </div>
                  </div>

                  <div id="LicencesApprovals" class="tabcontent">
                     <div class="card">
                        <div class="card-body">
                            <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>File</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">No data found</td>
                            </tr>
                        </tbody>
                    </table>
                        </div>
                    </div>
                  </div>

                  <div id="LeaveRequests" class="tabcontent">
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
                                                <input id="remaining_leaves" type="text" class="form-control" value="<?php echo e($remainingLeave); ?>" readonly required>
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

                  <div id="LeaveInformation" class="tabcontent">
                    <!-- Leave Statistics -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="stats-info">
                                        <h6>Annual Leave</h6>
                                        <h4>12</h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stats-info">
                                        <h6>Medical Leave</h6>
                                        <h4><?php echo e($medicalLeave); ?></h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stats-info">
                                        <h6>Other Leave</h6>
                                        <h4><?php echo e($otherLeave); ?></h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stats-info">
                                        <h6>Remaining Leave</h6>
                                        <h4><?php echo e($remainingLeave); ?></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- /Leave Statistics -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>Leave Type</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>No of Days</th>
                                                    <th>Reason</th>
                                                    <th class="text-center">Status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $employee_leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($leave->leave_type); ?></td>
                                                        <td><?php echo e($leave->from); ?></td>
                                                        <td><?php echo e($leave->to); ?></td>
                                                        <td><?php echo e($leave->number_of_days); ?> days</td>
                                                        <td><?php echo e($leave->reason); ?></td>
                                                        <td class="text-center">
                                                            <div class="action-label">
                                                                <?php if($leave->status == 1): ?>
                                                                    <a class="btn btn-white btn-sm btn-rounded"
                                                                        href="javascript:void(0);">
                                                                        <i class="fa fa-dot-circle-o text-purple"></i>
                                                                        New
                                                                    </a>
                                                                <?php elseif($leave->status == 2): ?>
                                                                    <a class="btn btn-white btn-sm btn-rounded"
                                                                        href="javascript:void(0);">
                                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                                        Pending
                                                                    </a>
                                                                <?php elseif($leave->status == 3): ?>
                                                                    <a class="btn btn-white btn-sm btn-rounded"
                                                                        href="javascript:void(0);">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                                                        Approved
                                                                    </a>
                                                                <?php else: ?>
                                                                    <a class="btn btn-white btn-sm btn-rounded"
                                                                        href="javascript:void(0);">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                                                        Declined
                                                                    </a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        

                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                  </div>
                
            </div>
        </div>
        <script>
            function openCity(evt, cityName) {
              var i, tabcontent, tablinks;
              tabcontent = document.getElementsByClassName("tabcontent");
              for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
              }
              tablinks = document.getElementsByClassName("tablinks");
              for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
              }
              document.getElementById(cityName).style.display = "block";
              evt.currentTarget.className += " active";
            }
            </script>
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
                width: 1098px;
                height: 160px;
                margin-left: -2px;
            }
            .profile-card img {
                border-radius: 50%;
                width: 80px;
                height: 80px;
                margin-right: 20px;
            }
            .wallet-request-card {
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
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
            .nav-tabs {
                border-bottom: 1px solid #dee2e6;
                position: relative;
                margin-left: 3px !important;
                margin: 5px 0px !important;
                background: #fff;
                border-radius: 5px;
            }
            button.tablinks {
    background: #fff;
    margin-right: 5px;
    border: none;
}
        </style>
        <script src="<?php echo e(asset('public/js/core/app.js')); ?>"></script>
        <script src="<?php echo e(asset('public/css/custom.css')); ?>"></script>
        <?php echo $__env->make('modals.actions-modal-wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('modals.common-modal-wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('modals.plain-modal-wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('pages.authentication.modal.relogin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('modals.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.footerjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.automationjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo config('system.settings_theme_body'); ?>


    </body>

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

                // // Calculate remaining leaves (assuming 12 as default total)
                // var totalLeaves = 12;
                // var usedLeaves = 0; // You need to implement logic to fetch used leaves dynamically

                // var remainingLeaves = totalLeaves - usedLeaves;
                // document.getElementById('remaining_leaves').value = remainingLeaves;
            }
        }

        // Attach event listeners to from and to date inputs
        document.getElementById('from').addEventListener('change', calculateDays);
        document.getElementById('to').addEventListener('change', calculateDays);

        // Calculate days on page load (if you want initial calculation)
        calculateDays();
    </script>
    <?php if(config('visibility.page_rendering') == 'print-page'): ?>
        <script src="<?php echo e(asset('/public/js/dynamic/print.js?v=')); ?><?php echo e(config('system.versioning')); ?>"></script>
    <?php endif; ?>
</div>
</html>
<?php /**PATH /home/pentasof/hrcrm.testpentas.in/staff/application/resources/views/user/view.blade.php ENDPATH**/ ?>