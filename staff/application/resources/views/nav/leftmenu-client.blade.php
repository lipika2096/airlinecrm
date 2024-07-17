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
                    class="sidenav-menu-item {{ $page['mainmenu_home'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.home')) }}">
                    <a class="waves-effect waves-dark" href="{{ url('/') }}" aria-expanded="false" target="_self">
                        <i class="ti-home"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.dashboard')) }}
                        </span>
                    </a>
                </li>
                <!--home-->


                <!--projects[home]-->
                @if (config('visibility.modules.projects') && auth()->user()->is_client_owner)
                    <li data-modular-id="main_menu_client_projects"
                        class="sidenav-menu-item {{ $page['mainmenu_projects'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.viewProfile')) }}">
                        <a class="waves-effect waves-dark" href="{{ route('profile.show') }}" aria-expanded="false"
                            target="_self">
                            <i class="ti-user"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.viewProfile')) }}
                            </span>
                        </a>
                    </li>
                @endif
                <!--projects-->


                @if (auth()->user()->is_client_owner)
                    {{-- <li data-modular-id="main_menu_client_projects"
                        class="sidenav-menu-item {{ $page['mainmenu_projects'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.group_request')) }}">
                        <a class="waves-effect waves-dark" href="{{ route('attendance') }}" aria-expanded="false"
                            target="_self">
                            <i class="ti-user"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.group_request')) }}
                            </span>
                        </a>

                    </li> --}}
                    <li data-modular-id="main_menu_client_projects"
                        class="sidenav-menu-item {{ $page['mainmenu_projects'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.bank')) }}">
                        <a class="waves-effect waves-dark" href="{{ route('bank') }}" aria-expanded="false"
                            target="_self">
                            <i class="ti-wallet"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.bank')) }}
                            </span>
                        </a>

                    </li>
                @endif



                @if (auth()->user()->is_client_owner)
                    <li data-modular-id="main_menu_client_billing"
                        class="sidenav-menu-item {{ $page['mainmenu_client_billing'] ?? '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                            <i class="ti-wallet"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.bookings')) }}
                            </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            @if (config('visibility.modules.projects') && auth()->user()->is_client_owner)
                                <li data-modular-id="main_menu_client_projects"
                                    class="sidenav-menu-item {{ $page['mainmenu_projects'] ?? '' }} menu-tooltip menu-with-tooltip"
                                    title="{{ cleanLang(__('lang.bookTickets')) }}">
                                    <a class="waves-effect waves-dark" href="{{ route('airtickets.index') }}"
                                        aria-expanded="false" target="_self">
                                        {{-- <i class="ti-wallet"></i> --}}
                                        <span class="hide-menu">{{ cleanLang(__('lang.bookTickets')) }}
                                        </span>
                                    </a>
                                </li>
                            @endif
                            @if (config('visibility.modules.payments'))
                                <li class="sidenav-submenu {{ $page['submenu_payments'] ?? '' }}"
                                    id="submenu_payments">
                                    <a href="{{ route('bookings.index') }}"
                                        class=" {{ $page['submenu_payments'] ?? '' }}">{{ cleanLang(__('lang.manageBooking')) }}</a>
                                </li>
                            @endif
                            @if (config('visibility.modules.estimates'))
                                <li class="sidenav-submenu {{ $page['submenu_estimates'] ?? '' }}"
                                    id="submenu_estimates">
                                    <a href="{{ route('bookings.cancel') }}"
                                        class=" {{ $page['submenu_estimates'] ?? '' }}">{{ cleanLang(__('lang.cancelBooking')) }}</a>
                                </li>
                            @endif
                            @if (config('visibility.modules.subscriptions'))
                                <li class="sidenav-submenu {{ $page['submenu_subscriptions'] ?? '' }}"
                                    id="submenu_subscriptions">
                                    <a href="{{ route('bookings.history') }}"
                                        class=" {{ $page['submenu_subscriptions'] ?? '' }}">{{ cleanLang(__('lang.bookingHistory')) }}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!--projects[home]-->
                @if (auth()->user()->is_client_owner)
                    <li data-modular-id="main_menu_client_projects"
                        class="sidenav-menu-item {{ $page['mainmenu_projects'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="Leads">
                        <a class="waves-effect waves-dark" href="{{ route('saleleads.indexa') }}" aria-expanded="false"
                            target="_self">
                            <i class="ti-user"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.leads')) }}
                            </span>
                        </a>
                    </li>
                @endif
                <!--projects-->



                @if (auth()->user()->is_client_owner)
                    <li data-modular-id="main_menu_client_projects"
                        class="sidenav-menu-item {{ $page['mainmenu_projects'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.refunds')) }}">
                        <a class="waves-effect waves-dark" href="{{ route('refunds.index') }}" aria-expanded="false"
                            target="_self">
                            <i class="ti-wallet"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.refunds')) }}
                            </span>
                        </a>
                    </li>
                @endif



                <!--[MODULES] - dynamic menu-->
                {!! config('module_menus.main_menu_client') !!}

                <!--tickets-->
                @if (config('visibility.modules.tickets'))
                    <li data-modular-id="main_menu_client_tickets"
                        class="sidenav-menu-item {{ $page['mainmenu_tickets'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.support_tickets')) }}">
                        <a class="waves-effect waves-dark" href="{{ url('tickets') }}" aria-expanded="false"
                            target="_self">
                            <i class="ti-comments"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.support')) }}
                            </span>
                        </a>
                    </li>
                @endif
                <!--tickets-->
                <!--proposals-->
                @if (config('visibility.modules.proposals') && auth()->user()->is_client_owner)
                    <li data-modular-id="main_menu_client_billing"
                        class="sidenav-menu-item {{ $page['mainmenu_client_billing'] ?? '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);"
                            aria-expanded="false">
                            <i class="ti-wallet"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.fareConditions')) }}
                            </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            @if (config('visibility.modules.invoices'))
                                <li class="sidenav-submenu {{ $page['submenu_invoices'] ?? '' }}"
                                    id="submenu_invoices">
                                    <a href="{{ route('fare_conditions.index') }}"
                                        class=" {{ $page['submenu_invoices'] ?? '' }}">{{ cleanLang(__('lang.fareConditions')) }}</a>
                                </li>
                                <li class="sidenav-submenu {{ $page['submenu_invoices'] ?? '' }}"
                                    id="submenu_invoices">
                                    <a href="{{ route('commissions.index') }}"
                                        class=" {{ $page['submenu_invoices'] ?? '' }}">{{ cleanLang(__('lang.commission')) }}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {!! config('menus.main_menu_client') !!}

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
