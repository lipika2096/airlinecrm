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
                @elseif(\App\Helpers\RouteHelper::isCustomer())
                    <li><a class="{{ request()->routeIs('customer.support-tickets.dashboard') ? 'active' : '' }}" href="{{ route('customer.support-tickets.dashboard') }}"><i class="la la-life-ring"></i> <span> Support Tickets</span></a>
                    </li>
                @elseif(\App\Helpers\RouteHelper::isStaff())
                    <li><a class="{{ request()->routeIs('staff.support-tickets.dashboard') ? 'active' : '' }}" href="{{ route('staff.support-tickets.dashboard') }}"><i class="la la-life-ring"></i> <span> Support Tickets</span></a>
                    </li>
                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'hr'))
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
                @endif
                @if(auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin'))
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
                                <a class="{{ request()->routeIs('customer.case-history') ? 'active' : '' }}" href="{{ route('customer.case-history') }}">Case History</a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin'))
                    <li>
                        <a class="{{ request()->routeIs('admin.roles-permissions.index') ? 'active' : '' }}" href="{{ route('admin.roles-permissions.index') }}"><i class="la la-cog"></i> <span>Manage Modules</span></a>
                    </li>
                    <li><a class="{{ request()->routeIs('admin.sales-packages.index') ? 'active' : '' }}" href="{{ route('admin.sales-packages.index') }}"><i class="la la-cog"></i> <span>Sales Packages</span></a></li>
                @endif
                @if(auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin'))
                    <li class="submenu">
                        <a href="javascript:void(0);"><i class="la la-cube"></i> <span>System Admin</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.departments') ? 'active' : '' }}" href="{{route('admin.departments')}}">Add Departments</a></li>
                            <li><a class="{{ request()->routeIs('admin.designations') ? 'active' : '' }}" href="{{route('admin.designations')}}">Add Designations</a></li>
                            <li><a class="{{ request()->routeIs('admin.categories.view') ? 'active' : '' }}" href="{{route('admin.categories.view')}}">Add Category</a></li>

                            <li><a class="{{ request()->routeIs('admin.duties') ? 'active' : '' }}" href="{{route('admin.duties')}}">Add Duties</a></li>
                            <!-- <li><a class="" href="javascript:void(0);">Add Public Holidays</a></li> -->
                            <li><a class="{{ request()->routeIs('admin.events.status') ? 'active' : '' }}" href="{{ route('admin.events.status') }}">Add Status</a></li>
                            <li><a class="{{ request()->routeIs('admin.ticket-status.index') ? 'active' : '' }}" href="{{ route('admin.ticket-status.index') }}">Add Ticket Status</a></li>
                            <li><a class="{{ request()->routeIs('admin.leave-type') ? 'active' : '' }}" href="{{ route('admin.leave-type') }}">Add Leave Types</a></li>
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
                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'travel-agent'))

                    <li class="submenu">
                        <a href="#" class=""><i class="la la-user"></i> <span>Travel Agent</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if (auth('admin')->check())

                                 <li><a class="{{ request()->routeIs('admin.agents') ? 'active' : '' }}" href="{{ route('admin.agents') }}">Travel Partners List</a></li>
                                <li><a class="{{ request()->routeIs('admin.agent-library') ? 'active' : '' }}" href="{{ route('admin.agent-library') }}">Library</a></li>
                                <li><a class="{{ request()->routeIs('admin.agent-reports') ? 'active' : '' }}" href="{{ route('admin.agent-reports') }}">Reports</a></li>
                                 <li><a class="{{ request()->routeIs('admin.view.case-history') ? 'active' : '' }}" href="{{ route('admin.view.case-history') }}">Case History</a></li>
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
                                <li><a class="{{ request()->routeIs('admin.airlines-details') ? 'active' : '' }}" href="{{ route('admin.airlines-details') }}">Airlines List</a></li>
                                <li><a class="{{ request()->routeIs('admin.airline-library') ? 'active' : '' }}" href="{{ route('admin.airline-library') }}">Library</a></li>
                                <li><a class="{{ request()->routeIs('admin.airline-reports') ? 'active' : '' }}" href="{{ route('admin.airline-reports') }}">Reports</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'sales-marketing'))
                    <li class="submenu">
                        <a href="#"><i class="la la-files-o"></i> <span>Sales & Marketing</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.saleslead') ? 'active' : '' }}" href="{{ route('admin.saleslead') }}">Add Sales Lead</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Record Sales call/Visit</a></li>
                            
                        </ul>
                    </li>

                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'reservations'))
                    <li class="submenu">
                        <a href="#"><i class="la la-ticket"></i> <span>Reservations</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.air-tickets') ? 'active' : '' }}" href="{{ route('admin.air-tickets') }}">Manage Reservations</a></li>
                            <li><a class="{{ request()->routeIs('admin.reservation.newsale') ? 'active' : '' }}" href="{{ route('admin.reservation.newsale') }}">New Sale</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Modify Booking</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Refunds</a></li>
                            <li><a class="{{ request()->routeIs('admin.groups') ? 'active' : '' }}" href="{{ route('admin.groups') }}">Groups</a></li>
                        </ul>
                    </li>

                @endif
                @if(auth('admin')->check() && auth('admin')->user()?->getDirectPermissions()->contains('name', 'accounts') && auth('admin')->user()->getRoleNames()->first() != 'SuperAdmin')
                    <li class="submenu">
                        <a href="#"><i class="la la-money"></i> <span>Accounts</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
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
                            <li><a class="{{ request()->routeIs('admin.bank-accounts.index') ? 'active' : '' }}" href="{{ route('admin.bank-accounts.index') }}">My Bank Accounts</a>
                            </li>
                            <li><a class="{{ request()->routeIs('admin.customer.accounts.view') ? 'active' : '' }}" href="{{route('admin.customer.accounts.view')}}">Add account</a></li>
                            <li><a class="{{ request()->routeIs('admin.customer.accounts.all') ? 'active' : '' }}" href="{{route('admin.customer.accounts.all')}}">View accounts </a></li>
                            <li><a class="{{ request()->routeIs('admin.payment-pool') ? 'active' : '' }}" href="{{route('admin.payment-pool')}}">Add Payment to Pool </a></li>
                            <li><a class="{{ request()->routeIs('admin.customer.ledger') ? 'active' : '' }}" href="{{route('admin.customer.ledger')}}">Customer Ledger</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<!-- /Sidebar -->
