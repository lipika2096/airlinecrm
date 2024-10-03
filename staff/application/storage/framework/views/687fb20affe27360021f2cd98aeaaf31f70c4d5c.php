<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" id="js-trigger-nav-team"> <!--[fix] keep id as "js-trigger-nav-team"-->
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" id="main-scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul data-modular-id="main_menu_client" id="sidebarnav">

                <!--home-->
                <li data-modular-id="main_menu_client_home"
                    class="sidenav-menu-item <?php echo e($page['mainmenu_home'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                    title="<?php echo e(cleanLang(__('lang.home'))); ?>">
                    <a class="waves-effect waves-dark" href="<?php echo e(url('/')); ?>" aria-expanded="false" target="_self">
                        <i class="ti-home"></i>
                        <span class="hide-menu"><?php echo e(cleanLang(__('lang.dashboard'))); ?>

                        </span>
                    </a>
                </li>
                <!--home-->


                <!--projects[home]-->
                <?php if(config('visibility.modules.projects') && auth()->user()->is_client_owner): ?>
                    <li data-modular-id="main_menu_client_projects"
                        class="sidenav-menu-item <?php echo e($page['mainmenu_projects'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                        title="<?php echo e(cleanLang(__('lang.viewProfile'))); ?>">
                        <a class="waves-effect waves-dark" href="<?php echo e(route('profile.show')); ?>" aria-expanded="false"
                            target="_self">
                            <i class="ti-user"></i>
                            <span class="hide-menu"><?php echo e(cleanLang(__('lang.viewProfile'))); ?>

                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <!--projects-->


                <?php if(auth()->user()->is_client_owner): ?>
                <li data-modular-id="main_menu_client_projects"
                class="sidenav-menu-item <?php echo e($page['mainmenu_projects'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                title="<?php echo e(cleanLang(__('lang.leaves'))); ?>">
                    <a class="waves-effect waves-dark" href="<?php echo e(route('leaves-employee')); ?>" aria-expanded="false"
                        target="_self">
                        <i class="ti-user"></i>
                        <span class="hide-menu"><?php echo e(cleanLang(__('lang.leaves'))); ?>

                        </span>
                    </a>
                </li>
                    <li data-modular-id="main_menu_client_projects"
                        class="sidenav-menu-item <?php echo e($page['mainmenu_projects'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                        title="<?php echo e(cleanLang(__('lang.attendance'))); ?>">
                        <a class="waves-effect waves-dark" href="<?php echo e(route('attendance')); ?>" aria-expanded="false"
                            target="_self">
                            <i class="ti-user"></i>
                            <span class="hide-menu"><?php echo e(cleanLang(__('lang.attendance'))); ?>

                            </span>
                        </a>
                    </li>
                    
                <?php endif; ?>



                <?php if(auth()->user()->is_client_owner): ?>
                    <li data-modular-id="main_menu_client_billing"
                        class="sidenav-menu-item <?php echo e($page['mainmenu_client_billing'] ?? ''); ?>">
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                            <i class="ti-wallet"></i>
                            <span class="hide-menu"><?php echo e(cleanLang(__('lang.bookings'))); ?>

                            </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <?php if(config('visibility.modules.projects') && auth()->user()->is_client_owner): ?>
                                <li data-modular-id="main_menu_client_projects"
                                    class="sidenav-menu-item <?php echo e($page['mainmenu_projects'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                                    title="<?php echo e(cleanLang(__('lang.bookTickets'))); ?>">
                                    <a class="waves-effect waves-dark" href="<?php echo e(route('airtickets.index')); ?>"
                                        aria-expanded="false" target="_self">
                                        
                                        <span class="hide-menu"><?php echo e(cleanLang(__('lang.bookTickets'))); ?>

                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(config('visibility.modules.payments')): ?>
                                <li class="sidenav-submenu <?php echo e($page['submenu_payments'] ?? ''); ?>"
                                    id="submenu_payments">
                                    <a href="<?php echo e(route('bookings.index')); ?>"
                                        class=" <?php echo e($page['submenu_payments'] ?? ''); ?>"><?php echo e(cleanLang(__('lang.manageBooking'))); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(config('visibility.modules.estimates')): ?>
                                <li class="sidenav-submenu <?php echo e($page['submenu_estimates'] ?? ''); ?>"
                                    id="submenu_estimates">
                                    <a href="<?php echo e(route('bookings.cancel')); ?>"
                                        class=" <?php echo e($page['submenu_estimates'] ?? ''); ?>"><?php echo e(cleanLang(__('lang.cancelBooking'))); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(config('visibility.modules.subscriptions')): ?>
                                <li class="sidenav-submenu <?php echo e($page['submenu_subscriptions'] ?? ''); ?>"
                                    id="submenu_subscriptions">
                                    <a href="<?php echo e(route('bookings.history')); ?>"
                                        class=" <?php echo e($page['submenu_subscriptions'] ?? ''); ?>"><?php echo e(cleanLang(__('lang.bookingHistory'))); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!--projects[home]-->
                <?php if(auth()->user()->is_client_owner): ?>
                    <li data-modular-id="main_menu_client_projects"
                        class="sidenav-menu-item <?php echo e($page['mainmenu_projects'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                        title="Leads">
                        <a class="waves-effect waves-dark" href="<?php echo e(route('saleleads.indexa')); ?>" aria-expanded="false"
                            target="_self">
                            <i class="ti-user"></i>
                            <span class="hide-menu"><?php echo e(cleanLang(__('lang.leads'))); ?>

                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <!--projects-->



                <?php if(auth()->user()->is_client_owner): ?>
                    <li data-modular-id="main_menu_client_projects"
                        class="sidenav-menu-item <?php echo e($page['mainmenu_projects'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                        title="<?php echo e(cleanLang(__('lang.refunds'))); ?>">
                        <a class="waves-effect waves-dark" href="<?php echo e(route('refunds.index')); ?>" aria-expanded="false"
                            target="_self">
                            <i class="ti-wallet"></i>
                            <span class="hide-menu"><?php echo e(cleanLang(__('lang.refunds'))); ?>

                            </span>
                        </a>
                    </li>
                <?php endif; ?>



                <!--[MODULES] - dynamic menu-->
                <?php echo config('module_menus.main_menu_client'); ?>


                <!--tickets-->
                <?php if(config('visibility.modules.tickets')): ?>
                    <li data-modular-id="main_menu_client_tickets"
                        class="sidenav-menu-item <?php echo e($page['mainmenu_tickets'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                        title="<?php echo e(cleanLang(__('lang.support_tickets'))); ?>">
                        <a class="waves-effect waves-dark" href="<?php echo e(url('tickets')); ?>" aria-expanded="false"
                            target="_self">
                            <i class="ti-comments"></i>
                            <span class="hide-menu"><?php echo e(cleanLang(__('lang.support'))); ?>

                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <!--tickets-->
                <!--proposals-->
                

                <?php echo config('menus.main_menu_client'); ?>


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<?php /**PATH C:\xampp\htdocs\hrcrm\staff\application\resources\views/nav/leftmenu-client.blade.php ENDPATH**/ ?>