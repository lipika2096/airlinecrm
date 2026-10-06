<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="sidebar-vertical">

                <li class="">
                    <a class="{{ request()->routeIs('admin.dashboard', 'customer.dashboard', 'staff.dashboard') ? 'active' : '' }}" href="{{ \App\Helpers\RouteHelper::getDashboardRoute() }}"><i class="la la-dashboard"></i> <span> Dashboard</span></a>
                </li>
                
                @if(\App\Helpers\RouteHelper::isSuperAdmin())
                    <li><a class="{{ request()->routeIs('admin.events') ? 'active' : '' }}" href="{{ route('admin.events') }}"><i class="la la-list"></i> <span> My Todo(s)</span></a>
                    </li>
                    <li><a class="{{ request()->routeIs('admin.support-tickets.dashboard') ? 'active' : '' }}" href="{{ route('admin.support-tickets.dashboard') }}"><i class="la la-life-ring"></i> <span> Support Tickets</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i class="la la-bar-chart"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li>
                                <a class="{{ request()->routeIs('admin.reports.support-tickets') ? 'active' : '' }}" href="{{ route('admin.reports.support-tickets') }}">Support Tickets Report</a>
                            </li>
                        </ul>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isCustomer() && auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'support-tickets'))
                    <li><a class="{{ request()->routeIs('customer.support-tickets.index') ? 'active' : '' }}" href="{{ route('customer.support-tickets.index') }}"><i class="la la-life-ring"></i> <span> Support Tickets</span></a>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isStaff())
                    @canAccessModule('support-tickets')
                        <li class="submenu">
                            <a href="#" class="{{ request()->routeIs('staff.support-tickets.*') ? 'active' : '' }}"><i class="la la-life-ring"></i> <span> Support Tickets</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                @canAccessSubmodule('support-tickets.dashboard')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.support-tickets.index') ? 'active' : '' }}" href="{{ route('staff.support-tickets.index') }}">Dashboard</a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('support-tickets.my-created-tickets')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.support-tickets.my-created') ? 'active' : '' }}" href="{{ route('staff.support-tickets.my-created') }}">My Created Tickets</a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('support-tickets.assigned-tickets')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.support-tickets.assigned') ? 'active' : '' }}" href="{{ route('staff.support-tickets.assigned') }}">Assigned Tickets</a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('support-tickets.create-ticket')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.support-tickets.create') ? 'active' : '' }}" href="{{ route('staff.support-tickets.create') }}">Create Ticket</a>
                                    </li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'hr'))
                    @if(\App\Helpers\RouteHelper::isSuperAdmin() )
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-user"></i> <span> HR</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                
                                    <li>
                                        <a class="{{ request()->routeIs('admin.add-staff') ? 'active' : '' }}"
                                        href="{{ route('admin.add-staff') }}">
                                        Add Staff
                                        </a>
                                    </li>
                                <li>
                                    <a class="{{ request()->routeIs('admin.employees') ? 'active' : '' }}"
                                    href="{{ route('admin.employees') }}">
                                    Staff List
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('admin.manage-staff') ? 'active' : '' }}"
                                    href="{{ route('admin.manage-staff') }}">
                                    Manage Staff
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('admin.holidays') ? 'active' : '' }}"
                                    href="{{ route('admin.holidays') }}">
                                    Holidays & Leaves
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('admin.leaves') ? 'active' : '' }}"
                                    href="{{ route('admin.leaves') }}">
                                    Pending Approvals
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('admin.employee.view-profile') ? 'active' : '' }}"
                                    href="{{ route('admin.employee.view-profile') }}">
                                    User Profiles
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('admin.employee.rights') ? 'active' : '' }}"
                                    href="{{ route('admin.employee.rights') }}">
                                    User Rights
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('admin.staff-reports') ? 'active' : '' }}"
                                    href="{{ route('admin.staff-reports') }}">
                                    Reports
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @elseif(\App\Helpers\RouteHelper::isCustomer())
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-user"></i> <span> HR</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                
                                    <li>
                                        <a class="{{ request()->routeIs('customer.add-staff') ? 'active' : '' }}"
                                        href="{{ route('customer.add-staff') }}">
                                        Add Staff
                                        </a>
                                    </li>
                                <li>
                                    <a class="{{ request()->routeIs('customer.employees') ? 'active' : '' }}"
                                    href="{{ route('customer.employees') }}">
                                    Staff List
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('customer.manage-staff') ? 'active' : '' }}"
                                    href="{{ route('customer.manage-staff') }}">
                                    Manage Staff
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('customer.holidays') ? 'active' : '' }}"
                                    href="{{ route('customer.holidays') }}">
                                    Holidays & Leaves
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('customer.leaves') ? 'active' : '' }}"
                                    href="{{ route('customer.leaves') }}">
                                    Pending Approvals
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('customer.employee.view-profile') ? 'active' : '' }}"
                                    href="{{ route('customer.employee.view-profile') }}">
                                    User Profiles
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('customer.employee.rights') ? 'active' : '' }}"
                                    href="{{ route('customer.employee.rights') }}">
                                    User Rights
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('customer.staff-reports') ? 'active' : '' }}"
                                    href="{{ route('customer.staff-reports') }}">
                                    Reports
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        @canAccessModule('hr')
                            <li class="submenu">
                                <a href="#" class=""><i class="la la-user"></i> <span> HR</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    
                                        <li>
                                            <a class="{{ request()->routeIs('staff.add-staff') ? 'active' : '' }}"
                                            href="{{ route('staff.add-staff') }}">
                                            Add Staff
                                            </a>
                                        </li>
                                    <li>
                                        <a class="{{ request()->routeIs('staff.employees') ? 'active' : '' }}"
                                        href="{{ route('staff.employees') }}">
                                        Staff List
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('staff.manage-staff') ? 'active' : '' }}"
                                        href="{{ route('staff.manage-staff') }}">
                                        Manage Staff
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('staff.holidays') ? 'active' : '' }}"
                                        href="{{ route('staff.holidays') }}">
                                        Holidays & Leaves
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('staff.leaves') ? 'active' : '' }}"
                                        href="{{ route('staff.leaves') }}">
                                        Pending Approvals
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('staff.employee.view-profile') ? 'active' : '' }}"
                                        href="{{ route('staff.employee.view-profile') }}">
                                        User Profiles
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('staff.employee.rights') ? 'active' : '' }}"
                                        href="{{ route('staff.employee.rights') }}">
                                        User Rights
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('staff.staff-reports') ? 'active' : '' }}"
                                        href="{{ route('staff.staff-reports') }}">
                                        Reports
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcanAccessModule
                    @endif
                @elseif(\App\Helpers\RouteHelper::isStaff())
                    @canAccessModule('hr')
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-user"></i> <span> HR</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                @canAccessSubmodule('hr.add-staff')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.add-staff') ? 'active' : '' }}"
                                        href="{{ route('staff.add-staff') }}">
                                        Add Staff
                                        </a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('hr.staff-list')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.employees') ? 'active' : '' }}"
                                        href="{{ route('staff.employees') }}">
                                        Staff List
                                        </a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('hr.manage-staff')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.manage-staff') ? 'active' : '' }}"
                                        href="{{ route('staff.manage-staff') }}">
                                        Manage Staff
                                        </a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('hr.holidays-leaves')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.holidays') ? 'active' : '' }}"
                                        href="{{ route('staff.holidays') }}">
                                        Holidays & Leaves
                                        </a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('hr.pending-approvals')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.leaves') ? 'active' : '' }}"
                                        href="{{ route('staff.leaves') }}">
                                        Pending Approvals
                                        </a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('hr.user-profiles')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.employee.view-profile') ? 'active' : '' }}"
                                        href="{{ route('staff.employee.view-profile') }}">
                                        User Profiles
                                        </a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('hr.user-rights')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.employee.rights') ? 'active' : '' }}"
                                        href="{{ route('staff.employee.rights') }}">
                                        User Rights
                                        </a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('hr.reports')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.staff-reports') ? 'active' : '' }}"
                                        href="{{ route('staff.staff-reports') }}">
                                        Reports
                                        </a>
                                    </li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                @endif
                @if(auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin') )
                    <li class="submenu">
                        <a href="javascript:void(0);"><i class="la la-users"></i> <span>Customer</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li>
                                <a class="{{ request()->routeIs('admin.admin.add-customer') ? 'active' : '' }}" href="{{ route('admin.admin.add-customer') }}">Add Customer</a>
                            </li>
                            <li>
                                <a class="{{ request()->routeIs('admin.admin.view') ? 'active' : '' }}" href="{{ route('admin.admin.view') }}">Manage Customer</a>
                            </li>
                            <li>
                                <a class="{{ request()->routeIs('admin.kyc.documents') ? 'active' : '' }}" href="{{ route('admin.kyc.documents') }}">Library</a>
                            </li>
                            <li>
                                <a class="{{ request()->routeIs('admin.customer-reports') ? 'active' : '' }}" href="{{ route('admin.customer-reports') }}">Reports</a>
                            </li>
                             <li>
                                <a class="{{ request()->routeIs('admin.customer.case-history') ? 'active' : '' }}" href="{{ route('admin.customer.case-history') }}">Case History</a>
                            </li>
                        </ul>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isCustomer())
                    <li class="submenu">
                        <a href="javascript:void(0);"><i class="la la-users"></i> <span>My Cases</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li>
                                <a class="{{ request()->routeIs('customer.view.case-history') ? 'active' : '' }}" href="{{ route('customer.view.case-history') }}">Case History</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="{{ request()->routeIs('customer.subscriptions.index') ? 'active' : '' }}" href="{{ route('customer.subscriptions.index') }}"><i class="la la-cog"></i> <span>Subscriptions</span></a></li>
                    <!-- <li class="submenu">
                        <a href="javascript:void(0);"><i class="la la-user"></i> <span>B2C Customers</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li>
                                <a class="{{ request()->routeIs('customer.b2c-customers.index') ? 'active' : '' }}" href="{{ route('customer.b2c-customers.index') }}">B2C Customers List</a>
                            </li>
                        </ul>
                    </li> -->
                @elseif(\App\Helpers\RouteHelper::isStaff())
                    @canAccessModule('customer')
                        <li class="submenu">
                            <a href="javascript:void(0);"><i class="la la-users"></i> <span>Customer</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                @canAccessSubmodule('customer.add-customer')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.admin.add-customer') ? 'active' : '' }}" href="{{ route('staff.admin.add-customer') }}">Add Customer</a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('customer.manage-customer')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.admin.view') ? 'active' : '' }}" href="{{ route('staff.admin.view') }}">Manage Customer</a>
                                    </li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('customer.library')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.kyc.documents') ? 'active' : '' }}" href="{{ route('staff.kyc.documents') }}">Library</a>
                                    </li>
                                @endcanAccessSubmodule


                                @canAccessSubmodule('customer.reports')
                                    <li>
                                        <a class="{{ request()->routeIs('staff.customer-reports') ? 'active' : '' }}" href="{{ route('staff.customer-reports') }}">Reports</a>
                                    </li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                    @canAccessModule('b2b-partners')
                        <li class="submenu">
                            <a href="javascript:void(0);"><i class="la la-users"></i> <span>B2B Partners</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @canAccessSubmodule('b2b-partners.b2b-partners-list')
                                <li>
                                    <a class="{{ request()->routeIs('staff.b2b-partners') ? 'active' : '' }}" href="{{ route('staff.b2b-partners') }}">B2B Partners List</a>
                                </li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                    @canAccessModule('b2c-customers')
                        <li class="submenu">
                            <a href="javascript:void(0);"><i class="la la-user"></i> <span>B2C Customers</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                
                                @canAccessSubmodule('b2c-customers.b2c-customers-list')
                                <li>
                                    <a class="{{ request()->routeIs('staff.b2c-customers.index') ? 'active' : '' }}" href="{{ route('staff.b2c-customers.index') }}">B2C Customers List</a>
                                </li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                @endif
                @if(auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin'))
                    <li>
                        <a class="{{ request()->routeIs('admin.roles-permissions.index') ? 'active' : '' }}" href="{{ route('admin.roles-permissions.index') }}"><i class="la la-cog"></i> <span>Manage Modules</span></a>
                    </li>
                    <li><a class="{{ request()->routeIs('admin.sales-packages.index') ? 'active' : '' }}" href="{{ route('admin.sales-packages.index') }}"><i class="la la-cog"></i> <span>Sales Packages</span></a></li>
                    <li class="submenu">
                        <a href="#" class="{{ request()->routeIs('admin.subscriptions.*', 'admin.customer.subscriptions') ? 'active' : '' }}"><i class="la la-hand-o-up"></i> <span> Subscriptions </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.subscriptions.index') ? 'active' : '' }}" href="{{ route('admin.subscriptions.index') }}"> Subscription Rules</a></li>
                            <li><a class="{{ request()->routeIs('admin.customer.subscriptions') ? 'active' : '' }}" href="{{ route('admin.customer.subscriptions') }}"> Customer Subscriptions</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i class="la la-bar-chart"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.reports.support-tickets') ? 'active' : '' }}" href="{{ route('admin.reports.support-tickets') }}"> Support Tickets Report</a></li>
                        </ul>
                    </li>
                 @elseif(\App\Helpers\RouteHelper::isStaff())
                    @canAccessModule('roles-permissions')
                        @canAccessSubmodule('roles-permissions.manage-modules')
                            <li>
                                <a class="{{ request()->routeIs('staff.roles-permissions.index') ? 'active' : '' }}" href="{{ route('staff.roles-permissions.index') }}"><i class="la la-cog"></i> <span>Manage Modules</span></a>
                            </li>
                        @endcanAccessSubmodule
                    @endcanAccessModule
                    @canAccessModule('sales-packages')
                        @canAccessSubmodule('sales-packages.manage-packages')
                            <li><a class="{{ request()->routeIs('staff.sales-packages.index') ? 'active' : '' }}" href="{{ route('staff.sales-packages.index') }}"><i class="la la-cog"></i> <span>Sales Packages</span></a></li>
                        @endcanAccessSubmodule
                    @endcanAccessModule
                    @canAccessModule('subscriptions')
                        @canAccessSubmodule('subscriptions.manage-subscriptions')
                            <li><a class="{{ request()->routeIs('staff.subscriptions.index') ? 'active' : '' }}" href="{{ route('staff.subscriptions.index') }}"><i class="la la-cog"></i> <span>Subscriptions</span></a></li>
                        @endcanAccessSubmodule
                    @endcanAccessModule
                    @canAccessModule('accounts')
                        @canAccessSubmodule('accounts.bank-accounts')
                            <li><a class="{{ request()->routeIs('staff.bank-accounts.index') ? 'active' : '' }}" href="{{ route('staff.bank-accounts.index') }}"><i class="la la-bank"></i> <span>Bank Accounts</span></a></li>
                        @endcanAccessSubmodule
                    @endcanAccessModule
                    @canAccessModule('reports')
                        @canAccessSubmodule('reports.support-tickets')
                            <li class="submenu">
                                <a href="#" class="{{ request()->routeIs('staff.reports.*') ? 'active' : '' }}"><i class="la la-bar-chart"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ request()->routeIs('staff.reports.support-tickets') ? 'active' : '' }}" href="{{ route('staff.reports.support-tickets') }}"> Support Tickets Report</a></li>
                                </ul>
                            </li>
                        @endcanAccessSubmodule
                    @endcanAccessModule
                @endif
                @if(auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin'))
                    <li class="submenu">
                        <a href="javascript:void(0);"><i class="la la-cube"></i> <span>System Admin</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.departments') ? 'active' : '' }}" href="{{route('admin.departments')}}">Add Departments</a></li>
                            <li><a class="{{ request()->routeIs('admin.designations') ? 'active' : '' }}" href="{{route('admin.designations')}}">Add Designations</a></li>
                            <li><a class="{{ request()->routeIs('admin.department-modules.index') ? 'active' : '' }}" href="{{route('admin.department-modules.index')}}">Department Modules</a></li>
                            <li><a class="{{ request()->routeIs('admin.categories.view') ? 'active' : '' }}" href="{{route('admin.categories.view')}}">Add Category</a></li>

                            <li><a class="{{ request()->routeIs('admin.duties') ? 'active' : '' }}" href="{{route('admin.duties')}}">Add Duties</a></li>
                            <!-- <li><a class="" href="javascript:void(0);">Add Public Holidays</a></li> -->
                            <li><a class="{{ request()->routeIs('admin.events.status') ? 'active' : '' }}" href="{{ route('admin.events.status') }}">Add Status</a></li>
                            <li><a class="{{ request()->routeIs('admin.ticket-status.index') ? 'active' : '' }}" href="{{ route('admin.ticket-status.index') }}">Add Ticket Status</a></li>
                            <li><a class="{{ request()->routeIs('admin.leave-type') ? 'active' : '' }}" href="{{ route('admin.leave-type') }}">Add Leave Types</a></li>
                            <li><a class="{{ request()->routeIs('admin.products') ? 'active' : '' }}" href="{{ route('admin.products') }}">Products & Services</a></li>
                            @if(auth('admin')->check() && auth('admin')->user()->getRoleNames()->first() != 'SuperAdmin')
                                <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{ route('admin.comingSoon') }}">Add Agent Types</a></li>
                                <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{ route('admin.comingSoon') }}">Add Report Types</a></li>
                                <li><a class="{{ request()->routeIs('admin.faretypes') ? 'active' : '' }}" href="{{route('admin.faretypes')}}">Add Fare Types</a></li>
                                <li><a class="{{ request()->routeIs('admin.discounts') ? 'active' : '' }}" href="{{route('admin.discounts')}}">Add Discounts</a></li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"><span>Deleted Data</span> <span
                                            class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li>
                                            <a class="{{ request()->routeIs('admin.deleted.agents') ? 'active' : '' }}" href="{{route('admin.deleted.agents')}}">Deleted Travel Agents</a>
                                        </li>
                                        <li>
                                           <a class="{{ request()->routeIs('admin.deleted.airlines') ? 'active' : '' }}" href="{{route('admin.deleted.airlines')}}">Deleted Airlines List</a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{ route('admin.comingSoon') }}">Add Customer Types</a></li>
                            @endif
                        </ul>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isStaff())
                    @canAccessModule('system-admin')
                        <li class="submenu">
                            <a href="javascript:void(0);"><i class="la la-cube"></i> <span>System Admin</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                @canAccessSubmodule('system-admin.add-departments')
                                    <li><a class="{{ request()->routeIs('staff.departments') ? 'active' : '' }}" href="{{route('staff.departments')}}">Add Departments</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-designations')
                                    <li><a class="{{ request()->routeIs('staff.designations') ? 'active' : '' }}" href="{{route('staff.designations')}}">Add Designations</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.department-modules')
                                    <li><a class="{{ request()->routeIs('staff.department-modules.index') ? 'active' : '' }}" href="{{route('staff.department-modules.index')}}">Department Modules</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-category')
                                    <li><a class="{{ request()->routeIs('staff.categories.view') ? 'active' : '' }}" href="{{route('staff.categories.view')}}">Add Category</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-duties')
                                    <li><a class="{{ request()->routeIs('staff.duties') ? 'active' : '' }}" href="{{route('staff.duties')}}">Add Duties</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-status')
                                    <li><a class="{{ request()->routeIs('staff.events.status') ? 'active' : '' }}" href="{{ route('staff.events.status') }}">Add Status</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-ticket-status')
                                    <li><a class="{{ request()->routeIs('staff.ticket-status.index') ? 'active' : '' }}" href="{{ route('staff.ticket-status.index') }}">Add Ticket Status</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-leave-types')
                                    <li><a class="{{ request()->routeIs('staff.leave-type') ? 'active' : '' }}" href="{{ route('staff.leave-type') }}">Add Leave Types</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.products-services')
                                    <li><a class="{{ request()->routeIs('staff.products') ? 'active' : '' }}" href="{{ route('staff.products') }}">Products & Services</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-agent-types')
                                    <li><a class="{{ request()->routeIs('staff.comingSoon') ? 'active' : '' }}" href="{{ route('staff.comingSoon') }}">Add Agent Types</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-report-types')
                                    <li><a class="{{ request()->routeIs('staff.comingSoon') ? 'active' : '' }}" href="{{ route('staff.comingSoon') }}">Add Report Types</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-fare-types')
                                    <li><a class="{{ request()->routeIs('staff.faretypes') ? 'active' : '' }}" href="{{route('staff.faretypes')}}">Add Fare Types</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-discounts')
                                    <li><a class="{{ request()->routeIs('staff.discounts') ? 'active' : '' }}" href="{{route('staff.discounts')}}">Add Discounts</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.deleted-travel-agents')
                                    <li><a class="{{ request()->routeIs('staff.deleted.agents') ? 'active' : '' }}" href="{{route('staff.deleted.agents')}}">Deleted Travel Agents</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.deleted-airlines-list')
                                    <li><a class="{{ request()->routeIs('staff.deleted.airlines') ? 'active' : '' }}" href="{{route('staff.deleted.airlines')}}">Deleted Airlines List</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('system-admin.add-customer-types')
                                    <li><a class="{{ request()->routeIs('staff.comingSoon') ? 'active' : '' }}" href="{{ route('staff.comingSoon') }}">Add Customer Types</a></li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                @elseif(\App\Helpers\RouteHelper::isCustomer())
                    <li class="submenu">
                        <a href="javascript:void(0);"><i class="la la-cube"></i> <span>System Admin</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('customer.departments') ? 'active' : '' }}" href="{{route('customer.departments')}}">Add Departments</a></li>
                            <li><a class="{{ request()->routeIs('customer.designations') ? 'active' : '' }}" href="{{route('customer.designations')}}">Add Designations</a></li>
                            <li><a class="{{ request()->routeIs('customer.department-modules.index') ? 'active' : '' }}" href="{{route('customer.department-modules.index')}}">Department Modules</a></li>
                            <li><a class="{{ request()->routeIs('customer.categories.view') ? 'active' : '' }}" href="{{route('customer.categories.view')}}">Add Category</a></li>
                            <li><a class="{{ request()->routeIs('customer.duties') ? 'active' : '' }}" href="{{route('customer.duties')}}">Add Duties</a></li>
                            <li><a class="{{ request()->routeIs('customer.events.status') ? 'active' : '' }}" href="{{ route('customer.events.status') }}">Add Status</a></li>
                            <li><a class="{{ request()->routeIs('customer.ticket-status.index') ? 'active' : '' }}" href="{{ route('customer.ticket-status.index') }}">Add Ticket Status</a></li>
                            <li><a class="{{ request()->routeIs('customer.leave-type') ? 'active' : '' }}" href="{{ route('customer.leave-type') }}">Add Leave Types</a></li>
                            <li><a class="{{ request()->routeIs('customer.faretypes') ? 'active' : '' }}" href="{{route('customer.faretypes')}}">Add Fare Types</a></li>
                            <li><a class="{{ request()->routeIs('customer.discounts') ? 'active' : '' }}" href="{{route('customer.discounts')}}">Add Discounts</a></li>
                        </ul>
                    </li>
                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'travel-agent'))

                    <li class="submenu">
                        <a href="#" class=""><i class="la la-user"></i> <span>Travel Agent</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if (auth('admin')->check())

                                 <li><a class="{{ request()->routeIs('customer.agents') ? 'active' : '' }}" href="{{ route('customer.agents') }}">Travel Partners List</a></li>
                                <li><a class="{{ request()->routeIs('customer.agent-library') ? 'active' : '' }}" href="{{ route('customer.agent-library') }}">Library</a></li>
                                <li><a class="{{ request()->routeIs('customer.agent-reports') ? 'active' : '' }}" href="{{ route('customer.agent-reports') }}">Reports</a></li>
                                 <li><a class="{{ request()->routeIs('customer.view.case-history') ? 'active' : '' }}" href="{{ route('customer.view.case-history') }}">Case History</a></li>
                            @endif
                        </ul>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isStaff())
                    @canAccessModule('travel-agent')
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-user"></i> <span>Travel Agent</span>
                                <span class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                @canAccessSubmodule('travel-agent.travel-partners-list')
                                    <li><a class="{{ request()->routeIs('staff.agents') ? 'active' : '' }}" href="{{ route('staff.agents') }}">Travel Partners List</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('travel-agent.library')
                                    <li><a class="{{ request()->routeIs('staff.agent-library') ? 'active' : '' }}" href="{{ route('staff.agent-library') }}">Library</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('travel-agent.reports')
                                    <li><a class="{{ request()->routeIs('staff.agent-reports') ? 'active' : '' }}" href="{{ route('staff.agent-reports') }}">Reports</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('travel-agent.case-history')
                                    <li><a class="{{ request()->routeIs('staff.view.case-history') ? 'active' : '' }}" href="{{ route('staff.view.case-history') }}">Case History</a></li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'b2b-partners') || \App\Helpers\RouteHelper::isSuperAdmin())

                    <li class="submenu">
                        <a href="#" class=""><i class="la la-users"></i> <span> B2B Partners</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if (auth('admin')->check())
                                <li><a class="{{ request()->routeIs('admin.b2b-partners') ? 'active' : '' }}" href="{{ route('admin.b2b-partners') }}">B2B Partners List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'b2c-customers') || \App\Helpers\RouteHelper::isSuperAdmin())

                    <li class="submenu">
                        <a href="#" class=""><i class="la la-user"></i> <span> B2C Customers</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if (auth('admin')->check())
                                <li><a class="{{ request()->routeIs('admin.b2c-customers.index') ? 'active' : '' }}" href="{{ route('admin.b2c-customers.index') }}">B2C Customers List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'airline'))

                    <li class="submenu">
                        <a href="#" class=""><i class="la la-fighter-jet"></i> <span> Airline</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if (auth('admin')->check())
                                <li><a class="{{ request()->routeIs('customer.airlines-details') ? 'active' : '' }}" href="{{ route('customer.airlines-details') }}">Airlines List</a></li>
                                <li><a class="{{ request()->routeIs('customer.airline-library') ? 'active' : '' }}" href="{{ route('customer.airline-library') }}">Library</a></li>
                                <li><a class="{{ request()->routeIs('customer.airline-reports') ? 'active' : '' }}" href="{{ route('customer.airline-reports') }}">Reports</a></li>
                            @endif
                        </ul>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isStaff())
                    @canAccessModule('airline')
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-fighter-jet"></i> <span> Airline</span>
                                <span class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                @canAccessSubmodule('airline.airlines-list')
                                    <li><a class="{{ request()->routeIs('staff.airlines-details') ? 'active' : '' }}" href="{{ route('staff.airlines-details') }}">Airlines List</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('airline.library')
                                    <li><a class="{{ request()->routeIs('staff.airline-library') ? 'active' : '' }}" href="{{ route('staff.airline-library') }}">Library</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('airline.reports')
                                    <li><a class="{{ request()->routeIs('staff.airline-reports') ? 'active' : '' }}" href="{{ route('staff.airline-reports') }}">Reports</a></li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                @endif

                @if(auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin'))
                    <li>
                        <a class="{{ request()->routeIs('admin.suppliers') ? 'active' : '' }}" href="{{ route('admin.suppliers') }}"><i class="la la-truck"></i> <span>Supplier</span></a>
                    </li>
                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'sales-marketing'))
                    <li class="submenu">
                        <a href="#"><i class="la la-files-o"></i> <span>Sales & Marketing</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('customer.saleslead') ? 'active' : '' }}" href="{{ route('customer.saleslead') }}">Add Sales Lead</a></li>
                            <li><a class="{{ request()->routeIs('customer.comingSoon') ? 'active' : '' }}" href="{{url('/customer/coming-soon')}}">Record Sales call/Visit</a></li>
                            
                        </ul>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isStaff())
                    @canAccessModule('sales-marketing')
                        <li class="submenu">
                            <a href="#"><i class="la la-files-o"></i> <span>Sales & Marketing</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                @canAccessSubmodule('sales-marketing.add-sales-lead')
                                    <li><a class="{{ request()->routeIs('staff.saleslead') ? 'active' : '' }}" href="{{ route('staff.saleslead') }}">Add Sales Lead</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('sales-marketing.record-sales-call-visit')
                                    <li><a class="{{ request()->routeIs('staff.comingSoon') ? 'active' : '' }}" href="{{url('/staff/coming-soon')}}">Record Sales call/Visit</a></li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                @endif
                @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isCustomer() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'reservations')))
                    <li class="submenu">
                        <a href="#"><i class="la la-ticket"></i> <span>Reservations</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.booking.index', 'customer.booking.index', 'staff.booking.index') ? 'active' : '' }}" href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.index') : route('admin.booking.index')) }}">Manage Reservations</a></li>
                            <li><a class="" href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.create') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.create') : route('admin.booking.create')) }}">New Reservations</a></li>
                            <li><a class="{{ request()->routeIs('admin.booking.pending', 'customer.booking.pending', 'staff.booking.pending') ? 'active' : '' }}" href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.booking.pending') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.booking.pending') : route('admin.booking.pending')) }}">Pending Reservations</a></li>

                            <!-- <li><a class="{{ request()->routeIs('admin.air-tickets') ? 'active' : '' }}" href="{{ route('admin.air-tickets') }}">Manage Reservations</a></li>
                            <li><a class="{{ request()->routeIs('admin.reservation.newsale') ? 'active' : '' }}" href="{{ route('admin.reservation.newsale') }}">New Sale</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Modify Booking</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Refunds</a></li>
                            <li><a class="{{ request()->routeIs('admin.groups') ? 'active' : '' }}" href="{{ route('admin.groups') }}">Groups</a></li> -->
                        </ul>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isStaff())
                    @canAccessModule('reservations')
                        <li class="submenu">
                            <a href="#"><i class="la la-ticket"></i> <span>Reservations</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                @canAccessSubmodule('reservations.manage-reservations')
                                    <li><a class="{{ request()->routeIs('staff.booking.index') ? 'active' : '' }}" href="{{ route('staff.booking.index') }}">Manage Reservations</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('reservations.new-reservations')
                                    <li><a class="" href="{{ route('staff.booking.create') }}">New Reservations</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('reservations.manage-reservations')
                                    <li><a class="{{ request()->routeIs('staff.booking.pending') ? 'active' : '' }}" href="{{ route('staff.booking.pending') }}">Pending Reservations</a></li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'accounts') && auth('admin')->user()->getRoleNames()->first() != 'SuperAdmin')
                    <li class="submenu">
                        <a href="#"><i class="la la-money"></i> <span>Accounts</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.accounts.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.accounts.index') : route('admin.accounts.index')) }}">Account</a></li>
                            <li><a class="{{ request()->routeIs('admin.accounts.view') ? 'active' : '' }}" href="{{route('admin.accounts.view')}}">Add account</a></li>
                            <li><a class="{{ request()->routeIs('admin.accounts.all') ? 'active' : '' }}" href="{{route('admin.accounts.all')}}">View accounts </a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Add Payment to Pool </a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">View Invoice</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">View Booking Accounts </a></li>
                        </ul>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isCustomer() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'accounts'))
                    <li class="submenu">
                        <a href="#"><i class="la la-money"></i> <span>Accounts</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.accounts.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.accounts.index') : route('admin.accounts.index')) }}">Account</a></li>
                            <li><a class="{{ request()->routeIs('customer.accounts.view') ? 'active' : '' }}" href="{{route('customer.accounts.view')}}">Add account</a></li>
                            <li><a class="{{ request()->routeIs('customer.accounts.all') ? 'active' : '' }}" href="{{route('customer.accounts.all')}}">View accounts </a></li>
                            <li><a class="{{ request()->routeIs('customer.ledger') ? 'active' : '' }}" href="{{route('customer.ledger')}}">Customer Ledger</a></li>
                        </ul>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isSuperAdmin())
                    <li class="submenu">
                        <a href="#"><i class="la la-money"></i> <span>Accounts</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.accounts.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.accounts.index') : route('admin.accounts.index')) }}">Account</a></li>
                            <li><a class="{{ request()->routeIs('admin.bank-accounts.index') ? 'active' : '' }}" href="{{ route('admin.bank-accounts.index') }}">My Bank Accounts</a>
                            </li>
                            <li><a class="{{ request()->routeIs('admin.customer.accounts.view') ? 'active' : '' }}" href="{{route('admin.customer.accounts.view')}}">Add account</a></li>
                            <li><a class="{{ request()->routeIs('admin.customer.accounts.all') ? 'active' : '' }}" href="{{route('admin.customer.accounts.all')}}">View accounts </a></li>
                            <li><a class="{{ request()->routeIs('admin.payment-pool') ? 'active' : '' }}" href="{{route('admin.payment-pool')}}">Add Payment to Pool </a></li>
                            <li><a class="{{ request()->routeIs('admin.customer.ledger') ? 'active' : '' }}" href="{{route('admin.customer.ledger')}}">Customer Ledger</a></li>
                            <li><a class="{{ request()->routeIs('admin.general-ledger') ? 'active' : '' }}" href="{{route('admin.general-ledger')}}">General Ledger</a></li>
                            <li><a class="{{ request()->routeIs('admin.expense-entry') ? 'active' : '' }}" href="{{route('admin.expense-entry')}}">Expense Entry</a></li>
                        </ul>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isStaff())
                    @canAccessModule('accounts')
                        <li class="submenu">
                            <a href="#"><i class="la la-money"></i> <span>Accounts</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                @canAccessSubmodule('accounts.account')
                                    <li><a class="" href="{{ route('staff.accounts.index') }}">Account</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('accounts.add-account')
                                    <li><a class="{{ request()->routeIs('staff.customer.accounts.view') ? 'active' : '' }}" href="{{route('staff.customer.accounts.view')}}">Add account</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('accounts.view-accounts')
                                    <li><a class="{{ request()->routeIs('staff.customer.accounts.all') ? 'active' : '' }}" href="{{route('staff.customer.accounts.all')}}">View accounts </a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('accounts.customer-ledger')
                                    <li><a class="{{ request()->routeIs('staff.customer.ledger') ? 'active' : '' }}" href="{{route('staff.customer.ledger')}}">Customer Ledger</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('accounts.general-ledger')
                                    <li><a class="{{ request()->routeIs('staff.general-ledger') ? 'active' : '' }}" href="{{route('staff.general-ledger')}}">General Ledger</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('accounts.expense-entry')
                                    <li><a class="{{ request()->routeIs('staff.expense-entry') ? 'active' : '' }}" href="{{route('staff.expense-entry')}}">Expense Entry</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('accounts.payment-pool')
                                    <li><a class="{{ request()->routeIs('staff.payment-pool') ? 'active' : '' }}" href="{{route('staff.payment-pool')}}">Payment Pool</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('accounts.view-invoice')
                                    <li><a class="{{ request()->routeIs('staff.view-invoice') ? 'active' : '' }}" href="{{route('staff.view-invoice')}}">View Invoice</a></li>
                                @endcanAccessSubmodule

                                @canAccessSubmodule('accounts.booking-accounts')
                                    <li><a class="{{ request()->routeIs('staff.booking-accounts') ? 'active' : '' }}" href="{{route('staff.booking-accounts')}}">Booking Accounts</a></li>
                                @endcanAccessSubmodule
                            </ul>
                        </li>
                    @endcanAccessModule
                @endif
            
            </ul>
        </div>
    </div>
</div>

<!-- /Sidebar -->
